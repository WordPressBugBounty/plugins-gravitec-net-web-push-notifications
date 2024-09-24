<?php

/**
 * The admin-specific functionality of the plugin.
 *
 * @link       https://gravitec.net/
 * @since      1.0.0
 *
 * @package    Gravitecnet
 * @subpackage Gravitecnet/admin
 */

defined( 'ABSPATH' ) or die( 'This page may not be accessed directly.' );


/**
 * The admin-specific functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @package    Gravitecnet
 * @subpackage Gravitecnet/admin
 * @author     Gravitec Support <support@gravitec.net>
 */

add_action('admin_enqueue_scripts', 'gravitecnet_load_javascript');

function gravitecnet_load_javascript()
{
    global $post;
    if ($post) {
        wp_register_script('notice_script', plugins_url('notice.js', __FILE__), array('jquery'), '1.1', true);
        wp_enqueue_script('notice_script');
        wp_localize_script('notice_script', 'ajax_object', array('ajax_url' => admin_url('admin-ajax.php'), 'post_id' => $post->ID));
    }
}

add_action('wp_ajax_show_notice', 'gravitecnet_show_notice');

function gravitecnet_show_notice ()
{
    $post_id = isset($_GET['post_id']) ? 
            (filter_var($_GET['post_id'], FILTER_SANITIZE_NUMBER_INT))
            : '';
    
    if (is_null($post_id)) {
        $data = array('error' => 'could not get post id');
    } else {
        $recipients = get_post_meta($post_id, 'recipients');
        if ($recipients && is_array($recipients)) {
            $recipients = $recipients[0];
        }

        $status = get_post_meta($post_id, 'status');
        if ($status && is_array($status)) {
            $status = $status[0];
        }

        $response_body = get_post_meta($post_id, 'response_body');
        if ($response_body && is_array($response_body)) {
            $response_body = $response_body[0];
        }

        // reset meta
        delete_post_meta($post_id, 'status');
        delete_post_meta($post_id, 'recipients');
        delete_post_meta($post_id, 'response_body');

        $data = array('recipients' => $recipients, 'status_code' => $status, 'response_body' => $response_body);
    }

    echo wp_json_encode($data);

    exit;
}

class Gravitecnet_Admin {

	/**
	 * The ID of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string $plugin_name The ID of this plugin.
	 */
	private $plugin_name;

	/**
	 * The version of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string $version The current version of this plugin.
	 */
	private $version;


	/**
	 * @var Gravitecnet_Security_Helpers
	 */
	private $security;

	/**
	 * Initialize the class and set its properties.
	 *
	 * @param string $plugin_name The name of this plugin.
	 * @param string $version The version of this plugin.
	 *
	 * @param Gravitecnet_Security_Helpers $security
	 *
	 * @since    1.0.0
	 */
	public function __construct( $plugin_name, $version, $security ) {

		$this->plugin_name = $plugin_name;
		$this->version     = $version;
		$this->security    = $security;

		$this->register_actions();
	}

	public function register_actions() {
		if ( $this->security->can_modify_plugin_settings() ) {
			add_action( 'admin_menu', array( $this, 'add_gravitecnet_admin_page_to_admin_menu' ) );
		}
		add_action('admin_init', array($this, 'add_gravitecnet_post_options'));
		add_action('transition_post_status', array($this, 'on_publish_post'), 10, 3);
		
		if( class_exists( 'woocommerce' ) ){
			$gravitecnet_settings = new Gravitecnet_Settings();
			if ($gravitecnet_settings->get_enable_abandoned_cart() === 'true') {
				add_action('wp_footer', array($this, 'store_endpoint_in_cookies'), 100);
				add_action( 'woocommerce_add_to_cart', array($this, 'store_woo_cart_info'), 100, 0 );
				add_action( 'woocommerce_cart_item_removed', array($this, 'store_woo_cart_info'), 100, 0 );
				add_action( 'woocommerce_cart_item_restored', array($this, 'store_woo_cart_info'), 100, 0 );
				add_action( 'woocommerce_after_calculate_totals', array($this, 'store_woo_cart_info'), 100, 0 );
				add_action( 'woocommerce_thankyou', array($this, 'store_woo_cart_info'), 100, 0 );
				
				if (!$gravitecnet_settings->get_app_key() || !$gravitecnet_settings->get_app_secret()) return;
				
				add_filter( 'cron_schedules', array($this, 'user_define_recurrence'));
				add_action( 'wp', array($this, 'cron_job'));
				add_action( 'gravitecnet_abandoned_cart', array($this, 'send_abandoned_notification'));
			}
			add_action( 'transition_post_status', array($this, 'send_woo_product_push'), 100, 3);
		}
		add_action( 'add_meta_boxes', array($this, 'create_woo_product_notification_box'), 10);
		add_action('wp_footer', array($this, 'add_gravitec_tag'), 100);
	}

	public function add_gravitecnet_admin_page_to_admin_menu() {
		add_menu_page( 'Gravitec.net Configuration',
			'Gravitec.net Push',
			'manage_options',
			'gravitecnet-push',
			array( $this, 'render_gravitecnet_admin_page_html' ),
			plugin_dir_url( __FILE__ ) . 'images/badge.png'
		);
	}

	public function render_gravitecnet_admin_page_html() {
		require_once plugin_dir_path( __FILE__ ) . '/views/gravitecnet-admin-page.php';
	}
	
	public function add_gravitecnet_post_options () {
		add_action('admin_notices', array($this, 'display_notice'));
	}
	
	public function user_define_recurrence( $schedules ) {
		$schedules['gravitecnet_abandoned_cart_interval'] = array(
			'display' => __( 'Every 5 minute', 'gravitecnet' ),
			'interval' => 60 * 5,
		);
		return $schedules;
	}
	
	public function cron_job() {
		if ( ! wp_next_scheduled( 'gravitecnet_abandoned_cart' ) ) {
			wp_schedule_event( time(), 'gravitecnet_abandoned_cart_interval', 'gravitecnet_abandoned_cart' );
		}
	}
	
	public function add_gravitec_tag () {
		$gravitecnet_settings = new Gravitecnet_Settings();
		if ($gravitecnet_settings->get_tag_enable_segmentation() !== 'true') return;
		if(!$gravitecnet_settings->get_tag_url()) return;
		if(!$gravitecnet_settings->get_tag_title()) return;
		?>
			<script>
				const startTime = new Date().getTime(); 
				window.addEventListener('load', () => {
					const tagUrl = "<?php echo esc_js( $gravitecnet_settings->get_tag_url() ); ?>".split(' ').join('');
					const tagTitle = "<?php echo esc_js( $gravitecnet_settings->get_tag_title() ); ?>".split(' ').join('');
					const tagCondition = "<?php echo esc_js( $gravitecnet_settings->get_tag_condition() ); ?>";
					const tagScroll = "<?php echo esc_js( $gravitecnet_settings->get_tag_scroll() ); ?>";

					const tagVisitTime = parseInt("<?php echo esc_js( intval( str_replace(' ', '', $gravitecnet_settings->get_tag_visit_time() ) ) ); ?>");
					const startTime = new Date().getTime();
					
					if ((document.location.href !== tagUrl && document.location.href !== (tagUrl + '/')) && "<?php echo esc_js( $gravitecnet_settings->get_tag_enable_subpages() ); ?>" !== 'true') return;
					if ("<?php echo esc_js( $gravitecnet_settings->get_tag_enable_subpages() ) ;?>" === 'true') {
						if ((document.location.href !== tagUrl && document.location.href !== (tagUrl + '/')) && !document.location.href.includes(tagUrl + '/')) return;
					}
					setTimeout(() => {
						if (!window.Gravitec) return;
						window.Gravitec.push(["isSubscribed", function (success) {
							if (success) {
								const addTag = () => {
									Gravitec.push(['getTags', function(tags) {
										var newArray = [];
										tags.map((tag)=>newArray.push(tag));
										if (newArray.includes(tagTitle)) return console.log('exist');
										window.Gravitec.push([
											"segmentation.addTag", tagTitle
// 											function() {console.log("Tag has been added")},
	// 										function(err) {console.log(err.message)}
										]);
									}])
								}
								if (tagCondition === "visit") {
									addTag();
									return;
								} else if (tagCondition === "scroll") {
									function getScrollPercent () {
										var h = document.documentElement, 
											b = document.body,
											st = 'scrollTop',
											sh = 'scrollHeight';
										return (h[st]||b[st]) / ((h[sh]||b[sh]) - h.clientHeight) * 100;
									}
									const addTagOnScroll = () => {
										const percent = getScrollPercent();
										if (Math.floor(percent) < parseInt(tagScroll)) return;
										addTag();
										window.removeEventListener('scroll', addTagOnScroll);
										return;
									}
									window.addEventListener('scroll', addTagOnScroll);
								} else if (tagCondition === "time") {
									if (!tagVisitTime) return;
									window.addEventListener('beforeunload', () => {
										const visitDuration = (new Date().getTime() - startTime) / 1000;
										if (visitDuration < tagVisitTime) return;
										addTag();
										return;
									});
								}
							}
						}]);
					}, 2000)
				})
			</script>
		<?php
	}
	
    public function send_abandoned_notification() {
		$gravitecnet_settings = new Gravitecnet_Settings();
		if ($gravitecnet_settings->get_enable_abandoned_cart() !== 'true') return;
		global $wpdb;
		
		$wpdb->query("delete from " . $wpdb->prefix . "gravitecnet_abandoned_cart where date_time < current_timestamp - interval 10 day");
		$checkout_page_url = wc_get_checkout_url();
		
		$title_template = ($gravitecnet_settings->get_woo_abandoned_title_template()) ? $gravitecnet_settings->get_woo_abandoned_title_template() : "You've left item(s) in your cart";
		$message_template = ($gravitecnet_settings->get_woo_abandoned_message_template()) ? $gravitecnet_settings->get_woo_abandoned_message_template() : "Checkout Now!" ;
		$redirect_url = ($gravitecnet_settings->get_woo_abandoned_redirect_url()) ? $gravitecnet_settings->get_woo_abandoned_redirect_url() : $checkout_page_url;
		$push_period_hours = ($gravitecnet_settings->get_woo_abandoned_hours()) ? intval($gravitecnet_settings->get_woo_abandoned_hours()) : 6;
		
		$result = $wpdb->get_results( $wpdb->prepare("select * from " . $wpdb->prefix . "gravitecnet_abandoned_cart where date_time < current_timestamp - INTERVAL %d hour", $push_period_hours), ARRAY_A);

		foreach($result as $r){
			$wppNotificationImage	= get_the_post_thumbnail_url( $r['prod_id'] , array(512,512));
			$product_name = ($r['prod_count'] > 1) ? 'Multiple Products' :  get_the_title( $r['prod_id'] );
			$request_body = array(
				'payload' => array (
					'message' => str_replace(array('{product_name}','{product_count}','{cart_total}'), array( $product_name, $r['prod_count'], $r['cart_total']), $message_template),
					'title' => str_replace(array('{product_name}','{product_count}','{cart_total}'), array( $product_name, $r['prod_count'], $r['cart_total']), $title_template),
					'redirect_url' => str_replace('{checkout_page}', $checkout_page_url, $redirect_url)
				),
				'audience' => array ('tokens' => [$r['regID']])
			);
			if ($wppNotificationImage && $gravitecnet_settings->get_woo_abandoned_icon() === 'true') {
				$request_body['payload']['icon'] = $wppNotificationImage;
			}
			
			$this->send_woo_push('https://uapi.gravitec.net/api/v3/push', $request_body);
			
			if( $gravitecnet_settings->get_woo_abandoned_push_period() === 'repeat' ) {	
				$wpdb->query( $wpdb->prepare("update " . $wpdb->prefix . "gravitecnet_abandoned_cart set date_time = current_timestamp where id = %d",array($r['id'])));
			} else {
				$wpdb->query( $wpdb->prepare("delete from " . $wpdb->prefix . "gravitecnet_abandoned_cart where id = %d",array($r['id'])));
			}
		}
	}
	
	public function send_woo_push ($endpoint, $request_body) {
		$gravitecnet_settings = new Gravitecnet_Settings();
		
		$basic_auth_key = base64_encode($gravitecnet_settings->get_app_key() . ':' . $gravitecnet_settings->get_app_secret());

		$request = array(
			'headers' => array (
			'content-type' => 'application/json',
			'Authorization' => 'Basic ' . $basic_auth_key
			),
			'body' => wp_json_encode( $request_body )
		);

		$response = wp_remote_post($endpoint, $request );
		
// 		$status = $response['response']['code'];
// 		$response_body = json_decode($response['body'], true);
// 		$this->set_gravitec_success_transient('<p>Status: '. $status. '; Response: ' . $response_body .'</p>');
		return;
	}
	
	public function send_woo_product_push ($new_status, $old_status, $post) {
		if( !$post || $new_status != 'publish' ) return; 
		if( defined( 'REST_REQUEST' ) && REST_REQUEST ) return;
		if( $post->post_type !== 'product' || !class_exists( 'woocommerce' )) return;
		
		$gravitecnet_settings = new Gravitecnet_Settings();
		
		$wooCurrency 			= get_option('woocommerce_currency');
		$priceFormat 			= get_woocommerce_price_format();
		$product 				= wc_get_product ( $post->ID );
		
		$old_price 	= $product->get_regular_price() . ' ' .  $wooCurrency;
		$new_price 	= filter_var($_POST['_regular_price'], FILTER_SANITIZE_NUMBER_INT) . ' ' .  $wooCurrency;
		$sale_price = filter_var($_POST['_sale_price'], FILTER_SANITIZE_NUMBER_INT) . ' ' .  $wooCurrency;
		
		$url = '';
		$title = '';
		$message = '';
		$icon = '';
		
		if ( $gravitecnet_settings->get_woo_enable_new_product() === 'true' && $new_status !== $old_status && $old_status !== 'trash' )  {
			$title_template = 'new ' . $post->post_title;
			$message_template = get_the_excerpt($post->ID);
			$url_template = get_the_permalink();
			$icon = '';
			
			if ($gravitecnet_settings->get_woo_new_product_title_template()) {
				$title_template = $gravitecnet_settings->get_woo_new_product_title_template();
			}
			if ($gravitecnet_settings->get_woo_new_product_message_template()) {
				$message_template = $gravitecnet_settings->get_woo_new_product_message_template();
			}
			if ($gravitecnet_settings->get_woo_new_product_redirect_url()) {
				$url_template = $gravitecnet_settings->get_woo_new_product_redirect_url();
			}
			
			$title = str_replace(array('{product_name}','{short_product_description}' ,'{product_url}'), array( $post->post_title, get_the_excerpt($post->ID), get_the_permalink()), $title_template);
			$message = str_replace(array('{product_name}','{short_product_description}' ,'{product_url}'), array( $post->post_title, get_the_excerpt($post->ID), get_the_permalink()), $message_template);
			$url = str_replace('{product_url}', get_the_permalink(), $url_template);
			if ($gravitecnet_settings->get_woo_new_product_icon() === 'true' && get_the_post_thumbnail_url($post->ID)) {
				$icon = get_the_post_thumbnail_url($post->ID);
			}
		}
		
		if ( null !== $_POST['gravitecnet_price_drop'] && $product->get_regular_price() > $_POST['_regular_price']) {
			$title_template = $post->post_title;
			$message_template = 'New price: ' . '{new_price}';
			$url_template = get_the_permalink();
			$icon = '';
			
			if ($gravitecnet_settings->get_woo_price_drop_title_template()) {
				$title_template = $gravitecnet_settings->get_woo_price_drop_title_template();
			}
			if ($gravitecnet_settings->get_woo_price_drop_message_template()) {
				$message_template = $gravitecnet_settings->get_woo_price_drop_message_template();
			}
			if ($gravitecnet_settings->get_woo_price_drop_redirect_url()) {
				$url_template = $gravitecnet_settings->get_woo_price_drop_redirect_url();
			}
			
			$title = str_replace(array('{product_name}', '{old_price}', '{new_price}', '{product_url}'), array( $post->post_title, $old_price, $new_price, get_the_permalink()), $title_template);
			$message = str_replace(array('{product_name}', '{old_price}', '{new_price}', '{product_url}'), array( $post->post_title, $old_price, $new_price, get_the_permalink()), $message_template);
			$url = str_replace('{product_url}', get_the_permalink(), $url_template);
			if ($gravitecnet_settings->get_woo_price_drop_icon() === 'true' && get_the_post_thumbnail_url($post->ID)) {
				$icon = get_the_post_thumbnail_url($post->ID);
			}
		}
		
		if( isset($_POST['gravitecnet_sale_price'], $_POST['_sale_price']) ) {
			$title_template = $post->post_title;
			$message_template = 'Sale price: ' . '{sale_price}';
			$url_template = get_the_permalink();
			$icon = '';
			
			if ($gravitecnet_settings->get_woo_sale_price_title_template()) {
				$title_template = $gravitecnet_settings->get_woo_sale_price_title_template();
			}
			if ($gravitecnet_settings->get_woo_sale_price_message_template()) {
				$message_template = $gravitecnet_settings->get_woo_sale_price_message_template();
			}
			if ($gravitecnet_settings->get_woo_sale_price_redirect_url()) {
				$url_template = $gravitecnet_settings->get_woo_sale_price_redirect_url();
			}
			
			$title = str_replace(array('{product_name}', '{sale_price}', '{product_url}'), array( $post->post_title, $sale_price, get_the_permalink()), $title_template);
			$message = str_replace(array('{product_name}', '{sale_price}', '{product_url}'), array( $post->post_title, $sale_price, get_the_permalink()), $message_template);
			$url = str_replace('{product_url}', get_the_permalink(), $url_template);
			if ($gravitecnet_settings->get_woo_sale_price_icon() === 'true' && get_the_post_thumbnail_url($post->ID)) {
				$icon = get_the_post_thumbnail_url($post->ID);
			}
		}
		
		$url = str_replace(' ', '', $url);
		$message = str_replace("\'", "'", $message);
		$title = str_replace("\'", "'", $title);
		
		$request_body = array(
			'payload' => array (
				'message' => $message,
				'title' => $title,
				'redirect_url' => $url
			)
		);
		
		if ($icon) {
			$request_body['payload']['icon'] = $icon;
		}
		
		if (!$request_body['payload']['message']) return;
		
		$gravitecnet_push_url = 'https://uapi.gravitec.net/api/v3/push';
		
		$response = self::send_gravitecnet_api($gravitecnet_push_url, $request_body);
		
		if (is_null($response)) {
				$this->set_gravitec_error_transient('<p><strong>Gravitec.net - Web Push Notifications: </strong><em> There was a problem sending your push notification.</em></p>');
				return;
        	}
			
			if ($gravitecnet_settings->get_status_after_sending() !== 'true') {return;}
			
			if (isset($response['body'])) {
				$response_body = json_decode($response['body'], true);
			}
			
			
			if (isset($response['response'])) {
				$status = $response['response']['code'];
			}
			
			update_post_meta($post->ID, 'response_body', wp_json_encode($response_body));
			update_post_meta($post->ID, 'status', $status);
			

			if ($status !== 200) {
				if ($status !== 0) {
					if ($status === 403) {
						$this->set_gravitec_error_transient('<p><strong>Gravitec.net - Web Push Notifications: </strong><em>[' . $status . '] ' . $response_body['error_message'] . '</em></p>');
					}
					else if ($status === 410) {
						$this->set_gravitec_error_transient('<p><strong>Gravitec.net - Web Push Notifications: </strong><em>[' . $status . '] ' . $response_body['description'] . '</em></p>');
					}
					else if ($status === 422) {
						$this->set_gravitec_error_transient('<p><strong>Gravitec.net - Web Push Notifications: </strong><em>[' . $status . '] ' . $response_body['errorDescription'] . '</em></p>');
					}
					else if ($status === 500) {
						$this->set_gravitec_error_transient('<p><strong>Gravitec.net - Web Push Notifications: </strong><em>[' . $status . '] Internal server error</em></p>');
					}
					else {
						$this->set_gravitec_error_transient('<p><strong>Gravitec.net - Web Push Notifications: </strong><em> There was a '.$status.' error sending your notification.</em></p>');
					}
				} 
				else {
					// A 0 HTTP status code means the connection couldn't be established
					$this->set_gravitec_error_transient('<p><strong>Gravitec.net - Web Push Notifications: </strong><em> There was an error establishing a network connection. Please make sure outgoing network connections from cURL are allowed.</em></p>');
				}
			} else {
				if (!empty($response)) {

					// API can send a 200 OK even if the notification failed to send
					if (isset($response['body'])) {
						$response_body = json_decode($response['body'], true);
						if (isset($response_body['id'])) {
							$notification_id = $response_body['id'];
						} else {
							return;
						}
					}

					$push_status_api_url = 'https://uapi.gravitec.net/api/v3/messages/' . $notification_id;
					
					$basic_auth_key = base64_encode($gravitecnet_settings->get_app_key() . ':' . $gravitecnet_settings->get_app_secret());
					
					$status_api_request_body = array(
						'headers' => array (
						'content-type' => 'application/json',
						'Authorization' => 'Basic ' . $basic_auth_key
						)
					);
					
					usleep(2000000);
					
					$status_api_response = wp_remote_get( $push_status_api_url, $status_api_request_body );
					
					if (!isset($status_api_response['body'])) {return;}
					
					$status_api_response_body = json_decode($status_api_response['body'], true);
					
					if (!isset($status_api_response_body['send'])) {return;}
					
					$recipient_count = $status_api_response_body['send'];
					
					update_post_meta($post->ID, 'recipients', $recipient_count);
					
					if ($recipient_count !== 0) {
						$this->set_gravitec_success_transient('<p><strong>Gravitec.net - Web Push Notifications: </strong><em> Successfully sent'.' a notification to '.$recipient_count.' recipients.'.'</em></p>');
					} else {
						$this->set_gravitec_success_transient('<p><strong>Gravitec.net - Web Push Notifications: </strong><em>There were no recipients. You likely have no subscribers.</em></p>');
					}
				}
			}
		
		return;
	}
	
	public function create_woo_product_notification_box () {
		global $post;
		if( !class_exists( 'woocommerce' ) || $post->post_status !== 'publish' || $post->post_type !== 'product') return;
		add_action( 'woocommerce_product_options_general_product_data', array($this, 'woo_box_fileds') );
	}
	
	public function woo_box_fileds() {
		$args = array(
			'id' => 'gravitecnet_price_drop',
			'label' => __( 'Gravitec Options', 'gravitecnet' ),
			'class' => 'gravitecnet-box-field',
			'type' => 'checkbox',
			'desc_tip' => false,
			'description' => __( 'Send Push notification for Price Drop.', 'gravitecnet' ),
		);
		woocommerce_wp_text_input( $args );
		$args = array(
			'id' => 'gravitecnet_sale_price',
			'label' => __( 'Gravitec Options', 'gravitecnet' ),
			'class' => 'gravitecnet-box-field',
			'type' => 'checkbox',
			'desc_tip' => false,
			'description' => __( 'Send Push notification for Sale Price.', 'gravitecnet' ),
		);
		woocommerce_wp_text_input( $args );
	}
	
	public function store_endpoint_in_cookies () {
		?>
			<script>
				window.addEventListener('load', () => {
					setTimeout(() => {
						if (!window.Gravitec) return;
						window.Gravitec.push(["isSubscribed", function (success) {
							if (success) {
								window.Gravitec.push(["getSubscription", function (subscriptionId) {
								  if (subscriptionId) {
									document.cookie = `gravitecnet_regID=${subscriptionId.regID}`;
								  } else {
									document.cookie = 'gravitecnet_regID=';
								  }
								}]);
							} else {
								document.cookie = 'gravitecnet_regID=';
								window.Gravitec.push(["afterSubscription", function (token) {
									window.Gravitec.push(["getSubscription", function (subscriptionId) {
										if (subscriptionId) {
											document.cookie = `gravitecnet_regID=${subscriptionId.regID}`;
										}
									}]);
								}]);
							}
						}]);
					}, 2000);
				})
			</script>
		<?php
	}
	
	public function store_woo_cart_info(){
		global $wpdb;
		global $woocommerce;
		
		if( empty($_COOKIE['gravitecnet_regID']) ) return;

		if( ! $woocommerce->cart->is_empty( ) ){
			$products		= $woocommerce->cart->get_cart_contents();
			$firstProd 		= reset($products);
			$cart_total		= strip_tags($woocommerce->cart->get_cart_total());
			$prod_count 	= count($woocommerce->cart->get_cart());

			$wpdb->replace(
				$wpdb->prefix . "gravitecnet_abandoned_cart", 
				array(
						'date_time' 	=> date('Y-m-d H:i:s'), 
						'regID' 		=> sanitize_text_field($_COOKIE['gravitecnet_regID']),
						'prod_count' 	=> $prod_count,
						'prod_id' 		=> $firstProd['product_id'],
						'cart_total'	=> $cart_total
						),
				array('%s','%s','%d','%d','%s')
			);
		}else{
			$wpdb->delete($wpdb->prefix . "gravitecnet_abandoned_cart", array('regID' => sanitize_text_field($_COOKIE['gravitecnet_regID'])), array('%s') );
		}
	}
	
    public function display_notice() {
	    $allowed_html = [
		'div' => [
		   'class' => []
		],
		'strong' => [],
		'a' => [],
		'p' => [],
		'em' => []
	    ];
		
		$gravitecnet_transient_error = get_transient('gravitecnet_transient_error');
		if (!empty($gravitecnet_transient_error)) {
			delete_transient('gravitecnet_transient_error');
			echo wp_kses($gravitecnet_transient_error, $allowed_html);
		}

		$gravitecnet_transient_success = get_transient('gravitecnet_transient_success');
		if (!empty($gravitecnet_transient_success)) {
			delete_transient('gravitecnet_transient_success');
			echo wp_kses($gravitecnet_transient_success, $allowed_html);
		}
    }
	
	public function on_publish_post ($new_status, $old_status, $post) {
		if(empty( $post ) || wp_is_post_revision($post) || $new_status !== 'publish') {return;}
		if ($new_status === $old_status || $old_status === 'trash') {return;}
		if ($post->post_type !== 'post') return;
		$gravitecnet_settings = new Gravitecnet_Settings();
		if (!$gravitecnet_settings->get_app_key() || !$gravitecnet_settings->get_app_secret()) {return;}
		if ($gravitecnet_settings->get_automatically_send_on_post() != 'true') {return;}
		if ($old_status === 'future' && $new_status === 'publish') {
			$this->send_gravitec_notification_on_post($post);
			return;
		}
		add_action('rest_after_insert_post', array($this, 'send_gravitec_notification_on_post'), 10, 1);
	}
	
	public function send_gravitec_notification_on_post ($post) {
		try {
			$gravitecnet_settings = new Gravitecnet_Settings();
			
			$push_redirect_url = get_permalink( $post->ID );
			
			if ($gravitecnet_settings->get_add_url_parameters()) {
				$push_redirect_url = get_permalink( $post->ID ) . '?' . $gravitecnet_settings->get_add_url_parameters();
			}
			
			$content = get_post_field('post_content', $post->ID);
			
			$trimed_content = wp_trim_words($content, 10, ' ...');
			
			$gravitecnet_push_url = 'https://uapi.gravitec.net/api/v3/push';
			
			$request_body = array (
				'payload' => array (
					'message' => $trimed_content,
					'title' => get_the_title( $post->ID ),
					'redirect_url' => $push_redirect_url
				)
			);
			
			if ($gravitecnet_settings->get_use_featured_image() === 'true' && has_post_thumbnail($post->ID)) {
				$request_body['payload']['icon'] = wp_get_attachment_url( get_post_thumbnail_id ($post->ID), array(192, 192) );
			}
			
			$response = self::send_gravitecnet_api($gravitecnet_push_url, $request_body);
			
			if (is_null($response)) {
				$this->set_gravitec_error_transient('<p><strong>Gravitec.net - Web Push Notifications: </strong><em> There was a problem sending your push notification.</em></p>');
				$this->remove_gravitec_push_on_post_action();
				return;
        	}
			
			if ($gravitecnet_settings->get_status_after_sending() !== 'true') {$this->remove_gravitec_push_on_post_action(); return;}
			
			if (isset($response['body'])) {
				$response_body = json_decode($response['body'], true);
			}
			
			
			if (isset($response['response'])) {
				$status = $response['response']['code'];
			}
			
			update_post_meta($post->ID, 'response_body', wp_json_encode($response_body));
			update_post_meta($post->ID, 'status', $status);
			

			if ($status !== 200) {
				if ($status !== 0) {
					if ($status === 403) {
						$this->set_gravitec_error_transient('<p><strong>Gravitec.net - Web Push Notifications: </strong><em>[' . $status . '] ' . $response_body['error_message'] . '</em></p>');
					}
					else if ($status === 410) {
						$this->set_gravitec_error_transient('<p><strong>Gravitec.net - Web Push Notifications: </strong><em>[' . $status . '] ' . $response_body['description'] . '</em></p>');
					}
					else if ($status === 422) {
						$this->set_gravitec_error_transient('<p><strong>Gravitec.net - Web Push Notifications: </strong><em>[' . $status . '] ' . $response_body['errorDescription'] . '</em></p>');
					}
					else if ($status === 500) {
						$this->set_gravitec_error_transient('<p><strong>Gravitec.net - Web Push Notifications: </strong><em>[' . $status . '] Internal server error</em></p>');
					}
					else {
						$this->set_gravitec_error_transient('<p><strong>Gravitec.net - Web Push Notifications: </strong><em> There was a '.$status.' error sending your notification.</em></p>');
					}
				} 
				else {
					// A 0 HTTP status code means the connection couldn't be established
					$this->set_gravitec_error_transient('<p><strong>Gravitec.net - Web Push Notifications: </strong><em> There was an error establishing a network connection. Please make sure outgoing network connections from cURL are allowed.</em></p>');
				}
			} else {
				if (!empty($response)) {

					// API can send a 200 OK even if the notification failed to send
					if (isset($response['body'])) {
						$response_body = json_decode($response['body'], true);
						if (isset($response_body['id'])) {
							$notification_id = $response_body['id'];
						} else {
							$this->remove_gravitec_push_on_post_action();
							return;
						}
					}

					$push_status_api_url = 'https://uapi.gravitec.net/api/v3/messages/' . $notification_id;
					
					$basic_auth_key = base64_encode($gravitecnet_settings->get_app_key() . ':' . $gravitecnet_settings->get_app_secret());
					
					$status_api_request_body = array(
						'headers' => array (
						'content-type' => 'application/json',
						'Authorization' => 'Basic ' . $basic_auth_key
						)
					);
					
					usleep(2000000);
					
					$status_api_response = wp_remote_get( $push_status_api_url, $status_api_request_body );
					
					if (!isset($status_api_response['body'])) {$this->remove_gravitec_push_on_post_action(); return;}
					
					$status_api_response_body = json_decode($status_api_response['body'], true);
					
					if (!isset($status_api_response_body['send'])) {$this->remove_gravitec_push_on_post_action(); return;}
					
					$recipient_count = $status_api_response_body['send'];
					
					update_post_meta($post->ID, 'recipients', $recipient_count);
					
					if ($recipient_count !== 0) {
						$this->set_gravitec_success_transient('<p><strong>Gravitec.net - Web Push Notifications: </strong><em> Successfully sent'.' a notification to '.$recipient_count.' recipients.'.'</em></p>');
					} else {
						$this->set_gravitec_success_transient('<p><strong>Gravitec.net - Web Push Notifications: </strong><em>There were no recipients. You likely have no subscribers.</em></p>');
					}
				}
			}
			$this->remove_gravitec_push_on_post_action();
			return;
		} catch (Exception $e) {
			remove_action('rest_after_insert_post', array($this, 'send_gravitec_notification_on_post'));
            return new WP_Error('err', __( "There was a problem sending a notification"));
        }
	}
	
	static function send_gravitecnet_api($url, $request_body) {
		$gravitecnet_settings = new Gravitecnet_Settings();
		
		$basic_auth_key = base64_encode($gravitecnet_settings->get_app_key() . ':' . $gravitecnet_settings->get_app_secret());

		$request = array(
			'headers' => array (
			'content-type' => 'application/json',
			'Authorization' => 'Basic ' . $basic_auth_key
			),
			'body' => wp_json_encode( $request_body )
		);

		$response = wp_remote_post( $url, $request );
		
		return $response;
	}
	
	public function set_gravitec_success_transient($value) {
		set_transient(
			'gravitecnet_transient_success', 
			'<div class="updated notice notice-success is-dismissible">
		  		<div class="components-notice__content">'
		  			. $value .
		  		'</div>
			</div>',
			86400
		);
	}
	
	public function set_gravitec_error_transient($value) {
		set_transient(
			'gravitecnet_transient_success', 
			'<div class="error notice">'
		  		. $value .
		  	'</div>',
			86400
		);
	}
	
	public function remove_gravitec_push_on_post_action () {
		remove_action('rest_after_insert_post', array($this, 'send_gravitec_notification_on_post'));
		return;
	}

	/**
	 * Register the stylesheets for the admin area.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_styles() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Gravitecnet_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Gravitecnet_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_style( 'gravitecnet-admin', plugin_dir_url( __FILE__ ) . '/css/gravitecnet-admin.css', array(), $this->version, 'all' );

	}

	/**
	 * Register the JavaScript for the admin area.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_scripts() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Gravitecnet_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Gravitecnet_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_script( 'gravitecnet-jstz', plugin_dir_url( __FILE__ ) . 'js/gravitecnet-jstz.min.js', array( 'jquery' ), $this->version, false );
		wp_enqueue_script( 'gravitecnet-admin', plugin_dir_url( __FILE__ ) . 'js/gravitecnet-admin.js', array( 'jquery' ), $this->version, false );

	}

}