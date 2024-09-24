<?php

defined( 'ABSPATH' ) or die( 'This page may not be accessed directly.' );

class Gravitecnet_Path_Helper {
	/**
	 * @var Gravitecnet_Settings
	 */
	private $settings;

	public function __construct( $settings ) {
		$this->settings = $settings;
	}

	public function generate_sdk_path() {
		$cdn_domain         = $this->get_gravitec_cdn_domain();
		$app_key            = $this->settings->get_app_key();
		$service_worker_url = $this->get_service_worker_path_url();

		if ($app_key) {
			return esc_html( sprintf(
				'%s/storage/%s/client.js?service=wp&wpath=%s',
				$cdn_domain,
				$app_key,
				$service_worker_url
			) );
		} else {
			return '';
		}
	}

	public function base_plugin_dir_url() {
		return plugin_dir_url( dirname( __FILE__ ) );
	}

	public function get_img_path( $filename ) {
		return esc_html( sprintf(
				'%s/admin/images/%s',
				$this->base_plugin_dir_url(),
				$filename
			)
		);
	}


	private function get_gravitec_cdn_domain() {
		return $this->settings->get_cdn_sdk_domain();
	}

	private function get_service_worker_path_url() {
		return sprintf(
			'%s/sdk_files/sw.php',
			$this->base_plugin_dir_url()
		);
	}
}
