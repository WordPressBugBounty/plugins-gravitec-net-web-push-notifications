<?php

defined( 'ABSPATH' ) or die( 'This page may not be accessed directly.' );

class Gravitecnet_Form {
	/**
	 * @var array - $_POST or $_GET
	 */
	private $form_data;

	/**
	 * @var Gravitecnet_Settings
	 */
	private $settings;

	/**
	 * @var Gravitecnet_Security_Helpers
	 */
	private $security;

	private $form_was_saved = false;

	/**
	 * Gravitecnet_Form constructor.
	 *
	 * @param array $form_data - $_POST or $_GET
	 * @param Gravitecnet_Settings $settings
	 * @param Gravitecnet_Security_Helpers $security
	 */
	public function __construct( $form_data, $settings, $security ) {
		$this->form_data = $form_data;
		$this->settings  = $settings;
		$this->security  = $security;
	}

	public function handle_submit() {
		if ( isset($this->form_data[ 'which-form' ])) {
			$which_form = stripslashes( sanitize_text_field( $this->form_data[ 'which-form' ] ) );

			if ($which_form === 'segmentation' ) {
				if ( ! $this->security->is_wp_nonce_valid( $this->form_data ) ) {
					die( 'wp nonce is not valid' );
				}
				
				$this->settings->save_tag_enable_segmentation(
					array_key_exists($this->settings->get_tag_enable_segmentation_field_name(), $this->form_data) ? stripslashes( sanitize_text_field( $this->form_data[ $this->settings->get_tag_enable_segmentation_field_name() ] ) ) : ""
				);
				
				$this->settings->save_tag_url(
					stripslashes( sanitize_text_field( $this->form_data[ $this->settings->get_tag_url_field_name() ] ) )
				);
				
				$this->settings->save_tag_enable_subpages(
					array_key_exists($this->settings->get_tag_enable_subpages_field_name(), $this->form_data) ? stripslashes( sanitize_text_field( $this->form_data[ $this->settings->get_tag_enable_subpages_field_name() ] ) ) : ""
				);
				
				$this->settings->save_tag_title(
					stripslashes( sanitize_text_field( $this->form_data[ $this->settings->get_tag_title_field_name() ] ) )
				);
				
				$this->settings->save_tag_scroll(
					stripslashes( sanitize_text_field( $this->form_data[ $this->settings->get_tag_scroll_field_name() ] ) )
				);
				
				$this->settings->save_tag_visit_time(
					stripslashes( sanitize_text_field( $this->form_data[ $this->settings->get_tag_visit_time_field_name() ] ) )
				);
				
				$this->settings->save_tag_condition(
					stripslashes( sanitize_text_field( $this->form_data[ $this->settings->get_tag_condition_field_name() ] ) )
				);
				
				return;
			}
			
			if ( $which_form === 'woocommerce-abandoned-cart' ) {
				if ( ! $this->security->is_wp_nonce_valid( $this->form_data ) ) {
					die( 'wp nonce is not valid' );
				}
				
				$this->settings->save_enable_abandoned_cart(
					array_key_exists($this->settings->get_enable_abandoned_cart_field_name(), $this->form_data) ? stripslashes( sanitize_text_field( $this->form_data[ $this->settings->get_enable_abandoned_cart_field_name() ] ) ) : ""
				);
				
				$this->settings->save_woo_abandoned_title_template(
					stripslashes( sanitize_text_field( $this->form_data[ $this->settings->get_woo_abandoned_title_template_field_name() ] ) )
				);
				
				$this->settings->save_woo_abandoned_message_template(
					stripslashes( sanitize_text_field( $this->form_data[ $this->settings->get_woo_abandoned_message_template_field_name() ] ) )
				);
				
				$this->settings->save_woo_abandoned_redirect_url(
					stripslashes( sanitize_text_field( $this->form_data[ $this->settings->get_woo_abandoned_redirect_url_field_name() ] ) )
				);
				
				$this->settings->save_woo_abandoned_push_period(
					stripslashes( sanitize_text_field( $this->form_data[ $this->settings->get_woo_abandoned_push_period_field_name() ] ) )
				);
				
				$this->settings->save_woo_abandoned_icon(
					array_key_exists($this->settings->get_woo_abandoned_icon_field_name(), $this->form_data) ? stripslashes( sanitize_text_field( $this->form_data[ $this->settings->get_woo_abandoned_icon_field_name() ] ) ) : ""
				);
				
				$this->settings->save_woo_abandoned_hours(
					stripslashes( sanitize_text_field( $this->form_data[ $this->settings->get_woo_abandoned_hours_field_name() ] ) )
				);
				
				return;
			}
			
			if ( $which_form === 'woocommerce-new-product' ) {
				if ( ! $this->security->is_wp_nonce_valid( $this->form_data ) ) {
					die( 'wp nonce is not valid' );
				}
				
				$this->settings->save_woo_enable_new_product(
					array_key_exists($this->settings->get_woo_enable_new_product_field_name(), $this->form_data) ? stripslashes( sanitize_text_field( $this->form_data[ $this->settings->get_woo_enable_new_product_field_name() ] ) ) : ""
				);
				
				$this->settings->save_woo_new_product_title_template(
					stripslashes( sanitize_text_field( $this->form_data[ $this->settings->get_woo_new_product_title_template_field_name() ] ) )
				);
				
				$this->settings->save_woo_new_product_message_template(
					stripslashes( sanitize_text_field( $this->form_data[ $this->settings->get_woo_new_product_message_template_field_name() ] ) )
				);
				
				$this->settings->save_woo_new_product_icon(
					array_key_exists($this->settings->get_woo_new_product_icon_field_name(), $this->form_data) ? stripslashes( sanitize_text_field( $this->form_data[ $this->settings->get_woo_new_product_icon_field_name() ] ) ) : ""
				);
				
				$this->settings->save_woo_new_product_redirect_url(
					stripslashes( sanitize_text_field( $this->form_data[ $this->settings->get_woo_new_product_redirect_url_field_name() ] ) )
				);			
				return;
			}
			
			if ( $which_form === 'woocommerce-price-drop' ) {
				if ( ! $this->security->is_wp_nonce_valid( $this->form_data ) ) {
					die( 'wp nonce is not valid' );
				}
				
				$this->settings->save_woo_price_drop_title_template(
					stripslashes( sanitize_text_field( $this->form_data[ $this->settings->get_woo_price_drop_title_template_field_name() ] ) )
				);
				
				$this->settings->save_woo_price_drop_message_template(
					stripslashes( sanitize_text_field( $this->form_data[ $this->settings->get_woo_price_drop_message_template_field_name() ] ) )
				);
				
				$this->settings->save_woo_price_drop_icon(
					array_key_exists($this->settings->get_woo_price_drop_icon_field_name(), $this->form_data) ? stripslashes( sanitize_text_field( $this->form_data[ $this->settings->get_woo_price_drop_icon_field_name() ] ) ) : ""
				);
				
				$this->settings->save_woo_price_drop_redirect_url(
					stripslashes( sanitize_text_field( $this->form_data[ $this->settings->get_woo_price_drop_redirect_url_field_name() ] ) )
				);			
				return;
			}
			
			if ( $which_form === 'woocommerce-sale-price' ) {
				if ( ! $this->security->is_wp_nonce_valid( $this->form_data ) ) {
					die( 'wp nonce is not valid' );
				}
				
				$this->settings->save_woo_sale_price_title_template(
					stripslashes( sanitize_text_field( $this->form_data[ $this->settings->get_woo_sale_price_title_template_field_name() ] ) )
				);
				
				$this->settings->save_woo_sale_price_message_template(
					stripslashes( sanitize_text_field( $this->form_data[ $this->settings->get_woo_sale_price_message_template_field_name() ] ) )
				);
				
				$this->settings->save_woo_sale_price_icon(
					array_key_exists($this->settings->get_woo_sale_price_icon_field_name(), $this->form_data) ? stripslashes( sanitize_text_field( $this->form_data[ $this->settings->get_woo_sale_price_icon_field_name() ] ) ) : ""
				);
				
				$this->settings->save_woo_sale_price_redirect_url(
					stripslashes( sanitize_text_field( $this->form_data[ $this->settings->get_woo_sale_price_redirect_url_field_name() ] ) )
				);			
				return;
			}
			
			if ( $which_form === 'configuration' ) {
				if ( ! $this->security->is_wp_nonce_valid( $this->form_data ) ) {
					die( 'wp nonce is not valid' );
				}
				
				$this->settings->save_automatically_send_on_post(
					array_key_exists($this->settings->get_automatically_send_on_post_field_name(), $this->form_data) ? stripslashes( sanitize_text_field( $this->form_data[ $this->settings->get_automatically_send_on_post_field_name() ] ) ) : ""
				);
				
				$this->settings->save_use_featured_image(
					array_key_exists($this->settings->get_use_featured_image_field_name(), $this->form_data) ? stripslashes( sanitize_text_field( $this->form_data[ $this->settings->get_use_featured_image_field_name() ] ) ) : ""
				);
				
				$this->settings->save_add_url_parameters(
					stripslashes( sanitize_text_field( $this->form_data[ $this->settings->get_add_url_parameters_field_name() ] ) )
				);
				
				$this->settings->save_status_after_sending(
					array_key_exists($this->settings->get_status_after_sending_field_name(), $this->form_data) ? stripslashes( sanitize_text_field( $this->form_data[ $this->settings->get_status_after_sending_field_name() ] ) ) : ""
				);
				
				return;
			}
			
			if ( $which_form === 'push' ) {
				if ( ! $this->security->is_wp_nonce_valid( $this->form_data ) ) {
					die( 'wp nonce is not valid' );
				}
				
				$data = $this->form_data;
				if (!$data['title'] || !$data['message'] || !$data['url']) {
					return;
				}
				
				if (!$this->settings->get_app_key() || !$this->settings->get_app_secret()) {
					return;
				}
				
				$content = stripslashes( sanitize_text_field( $data['message'] ) );
				
				$trimed_content = wp_trim_words($content, 10, ' ...');
				
				$api_url = 'https://uapi.gravitec.net/api/v3/push';
				
				$request_body = array (
					'payload' => array (
						'message' => $trimed_content,
						'title' => stripslashes( sanitize_text_field( $data['title'] ) ),
						'redirect_url' => stripslashes( sanitize_text_field( $data['url'] ) )
					)
				);
				
				$basic_auth_key = base64_encode($this->settings->get_app_key() . ':' . $this->settings->get_app_secret());

				$request = array(
					'headers' => array (
					'content-type' => 'application/json',
					'Authorization' => 'Basic ' . $basic_auth_key
					),
					'body' => wp_json_encode( $request_body )
				);
				
				$response = wp_remote_post( $api_url, $request );
				
				if (is_null($response)) {
					set_transient('gravitecnet_transient_error', '<div class="error notice">
						<p><strong>Gravitec.net - Web Push Notifications: </strong><em> There was a problem sending your push notification.</em></p>
						</div>', 86400
					);
					return;
				}
				
				if ($this->settings->get_status_after_sending() !== 'true') {return;}
				
				if (isset($response['body'])) {
					$response_body = json_decode($response['body'], true);
				}
				
				if (isset($response['response'])) {
					$status = $response['response']['code'];
				}

				if ($status !== 200) {
					if ($status !== 0) {
						set_transient('gravitecnet_transient_error', '<div class="error notice">
					<p><strong>Gravitec.net - Web Push Notifications: </strong><em> There was a '.$status.' error sending your notification.</em></p>
				</div>', 86400);
					} 
					else {
						// A 0 HTTP status code means the connection couldn't be established
						set_transient('gravitecnet_transient_error', '<div class="error notice">
					<p><strong>Gravitec.net - Web Push Notifications: </strong><em> There was an error establishing a network connection. Please make sure outgoing network connections from cURL are allowed.</em></p>
				</div>', 86400);
					}
				}
				else {
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
						
						$auth_key = base64_encode($this->settings->get_app_key() . ':' . $this->settings->get_app_secret());
						
						$status_api_request_body = array(
							'headers' => array (
							'content-type' => 'application/json',
							'Authorization' => 'Basic ' . $auth_key
							)
						);
						
						usleep(2000000);
						
						$status_api_response = wp_remote_get( $push_status_api_url, $status_api_request_body );
						
						if (!isset($status_api_response['body'])) {return;}
						
						$status_api_response_body = json_decode($status_api_response['body'], true);
						
						if (!isset($status_api_response_body['send'])) {return;}
						
						$recipient_count = $status_api_response_body['send'];
						
						if ($recipient_count !== 0) {
							set_transient('gravitecnet_transient_success', '<div class="updated notice notice-success is-dismissible">
			<div class="components-notice__content">
			<p><strong>Gravitec.net - Web Push Notifications: </strong><em> Successfully sent'.' a notification to '.$recipient_count.' recipients.'.'</em></p>
			</div>
				</div>', 86400);
						} else {
							set_transient('gravitecnet_transient_success', '<div class="updated notice notice-success is-dismissible">
					<p><strong>Gravitec.net - Web Push Notifications: </strong><em>There were no recipients. You likely have no subscribers.</em></p>
				</div>', 86400);
						}
					}
				}
				
				return;
			}
		}
		
		if ( ! $this->is_form_was_submitted() ) {
			return;
		}
		
		if ( ! $this->security->is_wp_nonce_valid( $this->form_data ) ) {
			die( 'wp nonce is not valid' );
		}
		
		if ( $this->form_data[ 'is_auth_form' ] ) {
			$this->settings->save_app_key(
				stripslashes( sanitize_text_field( $this->form_data[ $this->settings->get_app_key_field_name() ] ) )
			);
			$this->settings->save_app_secret(
				stripslashes( sanitize_text_field( $this->form_data[ $this->settings->get_app_secret_field_name() ] ) )
			);
			$this->settings->save_account_email(
				stripslashes( sanitize_text_field( $this->form_data[ $this->settings->get_email_field_name() ] ) )
			);

			$this->form_was_saved = true;
			
			return;
		}
	}

	public function form_was_saved() {
		return $this->form_was_saved;
	}

	private function is_form_was_submitted() {
		return isset( $this->form_data[ $this->settings->get_app_key_field_name() ] );
	}
}