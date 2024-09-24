<?php

defined( 'ABSPATH' ) or die( 'This page may not be accessed directly.' );

class Gravitecnet_Settings {
	private $APP_KEY_OPTION_NAME = 'gravitecnet_option_app_key';
	private $APP_SECRET_OPTION_NAME = 'gravitecnet_option_app_secret';
	private $ACCOUNT_EMAIL_OPTION_NAME = 'gravitecnet_option_email';
	private $AUTOMATICALLY_SEND_ON_POST_OPTION_NAME = 'gravitecnet_option_automatically_send_on_post';
	private $USE_FEATURED_IMAGE_OPTION_NAME = 'gravitecnet_option_use_featured_image';
	private $ADD_URL_PARAMETERS_OPTION_NAME = 'gravitecnet_option_add_url_parameters';
	private $STATUS_AFTER_SENDING_OPTION_NAME = 'gravitecnet_option_status_after_sending';
	
	// WooCommerce abandoned cart
	private $ENABLE_ABANDONED_CART_OPTION_NAME = 'gravitecnet_option_enable_abandoned_cart';
	private $WOO_ABANDONED_TITLE_TEMPLATE_OPTION_NAME = 'gravitecnet_option_woo_abandoned_title_template';
	private $WOO_ABANDONED_MESSAGE_TEMPLATE_OPTION_NAME = 'gravitecnet_option_woo_abandoned_message_template';
	private $WOO_ABANDONED_REDIRECT_URL_OPTION_NAME = 'gravitecnet_option_woo_abandoned_redirect_url';
	private $WOO_ABANDONED_PUSH_PERIOD_OPTION_NAME = 'gravitecnet_option_woo_abandoned_push_period';
	private $WOO_ABANDONED_ICON_OPTION_NAME = 'gravitecnet_option_woo_abandoned_icon';
	private $WOO_ABANDONED_HOURS_OPTION_NAME = 'gravitecnet_option_woo_abandoned_hours';
	
	// WooCommerce new product
	private $WOO_ENABLE_NEW_PRODUCT_OPTION_NAME = 'gravitecnet_option_woo_enable_new_product';
	private $WOO_NEW_PRODUCT_TITLE_TEMPLATE_OPTION_NAME = 'gravitecnet_option_woo_new_product_title_template';
	private $WOO_NEW_PRODUCT_MESSAGE_TEMPLATE_OPTION_NAME = 'gravitecnet_option_woo_new_product_message_template';
	private $WOO_NEW_PRODUCT_ICON_OPTION_NAME = 'gravitecnet_option_woo_new_product_icon';
	private $WOO_NEW_PRODUCT_REDIRECT_URL_OPTION_NAME = 'gravitecnet_option_woo_new_product_redirect_url';
	
	// WooCommerce price drop
	private $WOO_PRICE_DROP_TITLE_TEMPLATE_OPTION_NAME = 'gravitecnet_option_woo_price_drop_title_template';
	private $WOO_PRICE_DROP_MESSAGE_TEMPLATE_OPTION_NAME = 'gravitecnet_option_woo_price_drop_message_template';
	private $WOO_PRICE_DROP_ICON_OPTION_NAME = 'gravitecnet_option_woo_price_drop_icon';
	private $WOO_PRICE_DROP_REDIRECT_URL_OPTION_NAME = 'gravitecnet_option_woo_price_drop_redirect_url';

	// WooCommerce sale price
	private $WOO_SALE_PRICE_TITLE_TEMPLATE_OPTION_NAME = 'gravitecnet_option_woo_sale_price_title_template';
	private $WOO_SALE_PRICE_MESSAGE_TEMPLATE_OPTION_NAME = 'gravitecnet_option_woo_sale_price_message_template';
	private $WOO_SALE_PRICE_ICON_OPTION_NAME = 'gravitecnet_option_woo_sale_price_icon';
	private $WOO_SALE_PRICE_REDIRECT_URL_OPTION_NAME = 'gravitecnet_option_woo_sale_price_redirect_url';
	
	// Segmentation
	private $TAG_ENABLE_SEGMENTATION_OPTION_NAME = 'gravitecnet_option_tag_enable_segmentation';
	private $TAG_URL_OPTION_NAME = 'gravitecnet_option_tag_url';
	private $TAG_ENABLE_SUBPAGES_OPTION_NAME = 'gravitecnet_option_tag_enable_subpages';
	private $TAG_TITLE_OPTION_NAME = 'gravitecnet_option_tag_title';
	private $TAG_SCROLL_OPTION_NAME = 'gravitecnet_option_tag_scroll';
	private $TAG_VISIT_TIME_OPTION_NAME = 'gravitecnet_option_tag_visit_time';
	private $TAG_CONDITION_OPTION_NAME = 'gravitecnet_option_tag_condition';

	// Segmentation field name
	public function get_tag_enable_segmentation_field_name() {
		return $this->TAG_ENABLE_SEGMENTATION_OPTION_NAME;
	}
	
	public function get_tag_url_field_name() {
		return $this->TAG_URL_OPTION_NAME;
	}
	
	public function get_tag_enable_subpages_field_name() {
		return $this->TAG_ENABLE_SUBPAGES_OPTION_NAME;
	}
	
	public function get_tag_title_field_name() {
		return $this->TAG_TITLE_OPTION_NAME;
	}

	public function get_tag_scroll_field_name() {
		return $this->TAG_SCROLL_OPTION_NAME;
	}

	public function get_tag_visit_time_field_name() {
		return $this->TAG_VISIT_TIME_OPTION_NAME;
	}

	public function get_tag_condition_field_name() {
		return $this->TAG_CONDITION_OPTION_NAME;
	}
	
	// Auth field name
	public function get_app_key_field_name() {
		return $this->APP_KEY_OPTION_NAME;
	}

	public function get_app_secret_field_name() {
		return $this->APP_SECRET_OPTION_NAME;
	}

	public function get_email_field_name() {
		return $this->ACCOUNT_EMAIL_OPTION_NAME;
	}
	
	// Push on post field name
	public function get_automatically_send_on_post_field_name() {
		return $this->AUTOMATICALLY_SEND_ON_POST_OPTION_NAME;
	}
	
	public function get_use_featured_image_field_name() {
		return $this->USE_FEATURED_IMAGE_OPTION_NAME;
	}
	
	public function get_add_url_parameters_field_name() {
		return $this->ADD_URL_PARAMETERS_OPTION_NAME;
	}
	
	public function get_status_after_sending_field_name() {
		return $this->STATUS_AFTER_SENDING_OPTION_NAME;
	}
	
	// Woo abandoned cart field name	
	
	public function get_enable_abandoned_cart_field_name() {
		return $this->ENABLE_ABANDONED_CART_OPTION_NAME;
	}
	
	public function get_woo_abandoned_title_template_field_name() {
		return $this->WOO_ABANDONED_TITLE_TEMPLATE_OPTION_NAME;
	}
	
	public function get_woo_abandoned_message_template_field_name() {
		return $this->WOO_ABANDONED_MESSAGE_TEMPLATE_OPTION_NAME;
	}

	public function get_woo_abandoned_redirect_url_field_name() {
		return $this->WOO_ABANDONED_REDIRECT_URL_OPTION_NAME;
	}
	
	public function get_woo_abandoned_push_period_field_name() {
		return $this->WOO_ABANDONED_PUSH_PERIOD_OPTION_NAME;
	}
	
	public function get_woo_abandoned_icon_field_name() {
		return $this->WOO_ABANDONED_ICON_OPTION_NAME;
	}
	
	public function get_woo_abandoned_hours_field_name() {
		return $this->WOO_ABANDONED_HOURS_OPTION_NAME;
	}
	
	// Woo new product field name	
	
	public function get_woo_enable_new_product_field_name() {
		return $this->WOO_ENABLE_NEW_PRODUCT_OPTION_NAME;
	}
	
	public function get_woo_new_product_title_template_field_name() {
		return $this->WOO_NEW_PRODUCT_TITLE_TEMPLATE_OPTION_NAME;
	}
	
	public function get_woo_new_product_message_template_field_name() {
		return $this->WOO_NEW_PRODUCT_MESSAGE_TEMPLATE_OPTION_NAME;
	}
	
	public function get_woo_new_product_icon_field_name() {
		return $this->WOO_NEW_PRODUCT_ICON_OPTION_NAME;
	}

	public function get_woo_new_product_redirect_url_field_name() {
		return $this->WOO_NEW_PRODUCT_REDIRECT_URL_OPTION_NAME;
	}
	
	// Woo price drop field name	
	
	public function get_woo_price_drop_title_template_field_name() {
		return $this->WOO_PRICE_DROP_TITLE_TEMPLATE_OPTION_NAME;
	}
	
	public function get_woo_price_drop_message_template_field_name() {
		return $this->WOO_PRICE_DROP_MESSAGE_TEMPLATE_OPTION_NAME;
	}
	
	public function get_woo_price_drop_icon_field_name() {
		return $this->WOO_PRICE_DROP_ICON_OPTION_NAME;
	}

	public function get_woo_price_drop_redirect_url_field_name() {
		return $this->WOO_PRICE_DROP_REDIRECT_URL_OPTION_NAME;
	}
	
	// Woo sale price field name	
	
	public function get_woo_sale_price_title_template_field_name() {
		return $this->WOO_SALE_PRICE_TITLE_TEMPLATE_OPTION_NAME;
	}
	
	public function get_woo_sale_price_message_template_field_name() {
		return $this->WOO_SALE_PRICE_MESSAGE_TEMPLATE_OPTION_NAME;
	}
	
	public function get_woo_sale_price_icon_field_name() {
		return $this->WOO_SALE_PRICE_ICON_OPTION_NAME;
	}

	public function get_woo_sale_price_redirect_url_field_name() {
		return $this->WOO_SALE_PRICE_REDIRECT_URL_OPTION_NAME;
	}
	
	// Segmentation 
	public function get_tag_enable_segmentation() {
		return get_option( $this->TAG_ENABLE_SEGMENTATION_OPTION_NAME );
	}

	public function save_tag_enable_segmentation( $value ) {
		update_option( $this->TAG_ENABLE_SEGMENTATION_OPTION_NAME, $value );
	}

	public function delete_tag_enable_segmentation() {
		delete_option( $this->TAG_ENABLE_SEGMENTATION_OPTION_NAME );
	}	

	public function get_tag_url() {
		return get_option( $this->TAG_URL_OPTION_NAME );
	}

	public function save_tag_url( $value ) {
		update_option( $this->TAG_URL_OPTION_NAME, $value );
	}

	public function delete_tag_url() {
		delete_option( $this->TAG_URL_OPTION_NAME );
	}
	
	public function get_tag_enable_subpages() {
		return get_option( $this->TAG_ENABLE_SUBPAGES_OPTION_NAME );
	}

	public function save_tag_enable_subpages( $value ) {
		update_option( $this->TAG_ENABLE_SUBPAGES_OPTION_NAME, $value );
	}

	public function delete_tag_enable_subpages() {
		delete_option( $this->TAG_ENABLE_SUBPAGES_OPTION_NAME );
	}
	
	public function get_tag_title() {
		return get_option( $this->TAG_TITLE_OPTION_NAME );
	}

	public function save_tag_title( $value ) {
		update_option( $this->TAG_TITLE_OPTION_NAME, $value );
	}

	public function delete_tag_title() {
		delete_option( $this->TAG_TITLE_OPTION_NAME );
	}
	
	public function get_tag_scroll() {
		return get_option( $this->TAG_SCROLL_OPTION_NAME );
	}

	public function save_tag_scroll( $value ) {
		update_option( $this->TAG_SCROLL_OPTION_NAME, $value );
	}

	public function delete_tag_scroll() {
		delete_option( $this->TAG_SCROLL_OPTION_NAME );
	}
	
	public function get_tag_visit_time() {
		return get_option( $this->TAG_VISIT_TIME_OPTION_NAME );
	}

	public function save_tag_visit_time( $value ) {
		update_option( $this->TAG_VISIT_TIME_OPTION_NAME, $value );
	}

	public function delete_tag_visit_time() {
		delete_option( $this->TAG_VISIT_TIME_OPTION_NAME );
	}

	public function get_tag_condition() {
		return get_option( $this->TAG_CONDITION_OPTION_NAME );
	}

	public function save_tag_condition( $value ) {
		update_option( $this->TAG_CONDITION_OPTION_NAME, $value );
	}

	public function delete_tag_condition() {
		delete_option( $this->TAG_CONDITION_OPTION_NAME );
	}
	
	// Auth 
	public function get_app_key() {
		return get_option( $this->APP_KEY_OPTION_NAME );
	}

	public function save_app_key( $app_key ) {
		update_option( $this->APP_KEY_OPTION_NAME, $app_key );
	}

	public function delete_app_key() {
		delete_option( $this->APP_KEY_OPTION_NAME );
	}

	public function get_app_secret() {
		return get_option( $this->APP_SECRET_OPTION_NAME );
	}

	public function save_app_secret( $app_secret ) {
		return update_option( $this->APP_SECRET_OPTION_NAME, $app_secret );
	}

	public function delete_app_secret() {
		delete_option( $this->APP_SECRET_OPTION_NAME );
	}

	public function get_account_email() {
		return get_option( $this->ACCOUNT_EMAIL_OPTION_NAME );
	}

	public function save_account_email( $email ) {
		return update_option( $this->ACCOUNT_EMAIL_OPTION_NAME, $email );
	}
	
	// Push on post 
	public function get_automatically_send_on_post() {
		return get_option( $this->AUTOMATICALLY_SEND_ON_POST_OPTION_NAME);
	}

	public function save_automatically_send_on_post( $isTrue ) {
		update_option( $this->AUTOMATICALLY_SEND_ON_POST_OPTION_NAME, $isTrue );
	}
	
	public function get_use_featured_image() {
		return get_option( $this->USE_FEATURED_IMAGE_OPTION_NAME);
	}

	public function save_use_featured_image( $isTrue ) {
		update_option( $this->USE_FEATURED_IMAGE_OPTION_NAME, $isTrue );
	}
	
	public function get_add_url_parameters() {
		return get_option( $this->ADD_URL_PARAMETERS_OPTION_NAME);
	}

	public function save_add_url_parameters( $parameters ) {
		update_option( $this->ADD_URL_PARAMETERS_OPTION_NAME, $parameters );
	}
	
	public function get_status_after_sending() {
		return get_option( $this->STATUS_AFTER_SENDING_OPTION_NAME);
	}

	public function save_status_after_sending( $isTrue ) {
		update_option( $this->STATUS_AFTER_SENDING_OPTION_NAME, $isTrue );
	}
	
	// Woo abandoned cart 	
	
	public function get_enable_abandoned_cart() {
		return get_option( $this->ENABLE_ABANDONED_CART_OPTION_NAME);
	}

	public function save_enable_abandoned_cart( $isTrue ) {
		update_option( $this->ENABLE_ABANDONED_CART_OPTION_NAME, $isTrue );
	}
	
	public function get_woo_abandoned_title_template() {
		return get_option( $this->WOO_ABANDONED_TITLE_TEMPLATE_OPTION_NAME);
	}

	public function save_woo_abandoned_title_template( $template ) {
		update_option( $this->WOO_ABANDONED_TITLE_TEMPLATE_OPTION_NAME, $template );
	}
	
	public function get_woo_abandoned_message_template() {
		return get_option( $this->WOO_ABANDONED_MESSAGE_TEMPLATE_OPTION_NAME);
	}

	public function save_woo_abandoned_message_template( $template ) {
		update_option( $this->WOO_ABANDONED_MESSAGE_TEMPLATE_OPTION_NAME, $template );
	}
	
	public function get_woo_abandoned_redirect_url() {
		return get_option( $this->WOO_ABANDONED_REDIRECT_URL_OPTION_NAME);
	}

	public function save_woo_abandoned_redirect_url( $url ) {
		update_option( $this->WOO_ABANDONED_REDIRECT_URL_OPTION_NAME, $url );
	}
	
	public function get_woo_abandoned_push_period() {
		return get_option( $this->WOO_ABANDONED_PUSH_PERIOD_OPTION_NAME);
	}

	public function save_woo_abandoned_push_period( $url ) {
		update_option( $this->WOO_ABANDONED_PUSH_PERIOD_OPTION_NAME, $url );
	}
	
	public function get_woo_abandoned_icon() {
		return get_option( $this->WOO_ABANDONED_ICON_OPTION_NAME);
	}

	public function save_woo_abandoned_icon( $isTrue ) {
		update_option( $this->WOO_ABANDONED_ICON_OPTION_NAME, $isTrue );
	}
	
	public function get_woo_abandoned_hours() {
		return get_option( $this->WOO_ABANDONED_HOURS_OPTION_NAME);
	}

	public function save_woo_abandoned_hours( $url ) {
		update_option( $this->WOO_ABANDONED_HOURS_OPTION_NAME, $url );
	}
	
	// Woo new product	
	
	public function get_woo_enable_new_product() {
		return get_option( $this->WOO_ENABLE_NEW_PRODUCT_OPTION_NAME);
	}

	public function save_woo_enable_new_product( $isTrue ) {
		update_option( $this->WOO_ENABLE_NEW_PRODUCT_OPTION_NAME, $isTrue );
	}
	
	public function get_woo_new_product_title_template() {
		return get_option( $this->WOO_NEW_PRODUCT_TITLE_TEMPLATE_OPTION_NAME);
	}

	public function save_woo_new_product_title_template( $template ) {
		update_option( $this->WOO_NEW_PRODUCT_TITLE_TEMPLATE_OPTION_NAME, $template );
	}
	
	public function get_woo_new_product_message_template() {
		return get_option( $this->WOO_NEW_PRODUCT_MESSAGE_TEMPLATE_OPTION_NAME);
	}

	public function save_woo_new_product_message_template( $template ) {
		update_option( $this->WOO_NEW_PRODUCT_MESSAGE_TEMPLATE_OPTION_NAME, $template );
	}
	
	public function get_woo_new_product_icon() {
		return get_option( $this->WOO_NEW_PRODUCT_ICON_OPTION_NAME);
	}

	public function save_woo_new_product_icon( $isTrue ) {
		update_option( $this->WOO_NEW_PRODUCT_ICON_OPTION_NAME, $isTrue );
	}
	
	public function get_woo_new_product_redirect_url() {
		return get_option( $this->WOO_NEW_PRODUCT_REDIRECT_URL_OPTION_NAME);
	}

	public function save_woo_new_product_redirect_url( $url ) {
		update_option( $this->WOO_NEW_PRODUCT_REDIRECT_URL_OPTION_NAME, $url );
	}

	// Woo price drop
	
	public function get_woo_price_drop_title_template() {
		return get_option( $this->WOO_PRICE_DROP_TITLE_TEMPLATE_OPTION_NAME);
	}

	public function save_woo_price_drop_title_template( $template ) {
		update_option( $this->WOO_PRICE_DROP_TITLE_TEMPLATE_OPTION_NAME, $template );
	}
	
	public function get_woo_price_drop_message_template() {
		return get_option( $this->WOO_PRICE_DROP_MESSAGE_TEMPLATE_OPTION_NAME);
	}

	public function save_woo_price_drop_message_template( $template ) {
		update_option( $this->WOO_PRICE_DROP_MESSAGE_TEMPLATE_OPTION_NAME, $template );
	}
	
	public function get_woo_price_drop_icon() {
		return get_option( $this->WOO_PRICE_DROP_ICON_OPTION_NAME);
	}

	public function save_woo_price_drop_icon( $isTrue ) {
		update_option( $this->WOO_PRICE_DROP_ICON_OPTION_NAME, $isTrue );
	}
	
	public function get_woo_price_drop_redirect_url() {
		return get_option( $this->WOO_PRICE_DROP_REDIRECT_URL_OPTION_NAME);
	}

	public function save_woo_price_drop_redirect_url( $url ) {
		update_option( $this->WOO_PRICE_DROP_REDIRECT_URL_OPTION_NAME, $url );
	}
	
	// Woo sale price
	
	public function get_woo_sale_price_title_template() {
		return get_option( $this->WOO_SALE_PRICE_TITLE_TEMPLATE_OPTION_NAME);
	}

	public function save_woo_sale_price_title_template( $template ) {
		update_option( $this->WOO_SALE_PRICE_TITLE_TEMPLATE_OPTION_NAME, $template );
	}
	
	public function get_woo_sale_price_message_template() {
		return get_option( $this->WOO_SALE_PRICE_MESSAGE_TEMPLATE_OPTION_NAME);
	}

	public function save_woo_sale_price_message_template( $template ) {
		update_option( $this->WOO_SALE_PRICE_MESSAGE_TEMPLATE_OPTION_NAME, $template );
	}
	
	public function get_woo_sale_price_icon() {
		return get_option( $this->WOO_SALE_PRICE_ICON_OPTION_NAME);
	}

	public function save_woo_sale_price_icon( $isTrue ) {
		update_option( $this->WOO_SALE_PRICE_ICON_OPTION_NAME, $isTrue );
	}
	
	public function get_woo_sale_price_redirect_url() {
		return get_option( $this->WOO_SALE_PRICE_REDIRECT_URL_OPTION_NAME);
	}

	public function save_woo_sale_price_redirect_url( $url ) {
		update_option( $this->WOO_SALE_PRICE_REDIRECT_URL_OPTION_NAME, $url );
	}

	/**
	 * If appKey and appSecret not empty - plugin was previously activated
	 * @return bool
	 */
	public function pluginWasActivated() {
		return $this->get_app_key() && $this->get_app_secret();
	}

	/**
	 * @return string user email
	 */
	public function get_current_user_email() {
		if ($this->get_account_email()) {
			return $this->get_account_email();
		} else {
			$current_user = wp_get_current_user();
			return esc_html( $current_user->user_email );
		}
	}

	/**
	 * @return string
	 */
	public function get_domain() {
		return get_site_url();
	}

	/**
	 * @return string
	 */
	public function get_rss_url() {
		$rss = bloginfo( 'rss2_url' );

		return $rss ? $rss : '';
	}

	/**
	 * @return string
	 * example: en_US
	 */
	public function get_locale() {
		$locale = get_locale();

		return $locale ? $locale : '';
	}

	public function get_cdn_sdk_domain() {
		if ( GRAVITECNET_TEST ) {
			return 'https://test-cdn-src.gravitec.net';
		} else {
			return 'https://cdn.gravitec.net';
		}
	}

	public function get_gravitecnet_service_domain() {
		if ( GRAVITECNET_TEST ) {
			return 'https://test-push.gravitec.net';
		} else {
			return 'https://push.gravitec.net';
		}
	}

	public function get_activate_button_url() {
		return sprintf( '%s/wp?', $this->get_gravitecnet_service_domain() );
	}
}