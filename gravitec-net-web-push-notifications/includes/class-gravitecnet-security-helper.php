<?php

defined( 'ABSPATH' ) or die( 'This page may not be accessed directly.' );

if ( ! function_exists( 'wp_get_current_user' ) ) {
	require_once ABSPATH . WPINC . '/pluggable.php';
}

class Gravitecnet_Security_Helpers {
	private $WP_NONCE_FIELD_NAME = '__WP_NONCE_FIELD_NAME';
	private $WP_NONCE_ACTION_NAME = '__WP_NONCE_ACTION_NAME';

	public function display_wp_nonce_field() {
		echo wp_nonce_field( $this->WP_NONCE_ACTION_NAME, $this->WP_NONCE_FIELD_NAME );
	}

	public function is_wp_nonce_valid( $form_data ) {
		return wp_verify_nonce( $form_data[ $this->WP_NONCE_FIELD_NAME ], $this->WP_NONCE_ACTION_NAME );
	}

	public function can_modify_plugin_settings() {
		return current_user_can( 'delete_users' );
	}

	public function can_send_notifications() {
		return current_user_can( 'publish_posts' ) || current_user_can( 'edit_published_posts' );
	}

}
