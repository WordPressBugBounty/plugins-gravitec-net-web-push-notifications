<?php

/**
 * The public-facing functionality of the plugin.
 *
 * @link       https://gravitec.net/
 * @since      1.0.0
 *
 * @package    Gravitecnet
 * @subpackage Gravitecnet/public
 */

defined( 'ABSPATH' ) or die( 'This page may not be accessed directly.' );

/**
 * The public-facing functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the public-facing stylesheet and JavaScript.
 *
 * @package    Gravitecnet
 * @subpackage Gravitecnet/public
 * @author     Gravitec Support <support@gravitec.net>
 */
class Gravitecnet_Public {

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
	 * @var Gravitecnet_Path_Helper
	 */
	private $sdk_path_helper;

	/**
	 * Initialize the class and set its properties.
	 *
	 * @param string $plugin_name The name of the plugin.
	 * @param string $version The version of this plugin.
	 *
	 * @param Gravitecnet_Path_Helper $sdk_path_helper
	 *
	 * @since    1.0.0
	 */
	public function __construct( $plugin_name, $version, $sdk_path_helper ) {

		$this->plugin_name     = $plugin_name;
		$this->version         = $version;
		$this->sdk_path_helper = $sdk_path_helper;
	}

	/**
	 * Register the stylesheets for the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_styles() {
	}

	/**
	 * Register the JavaScript for the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_scripts() {
		$this->_register_gravitec_sdk();
	}


	private function _register_gravitec_sdk() {
		wp_enqueue_script(
			$this->plugin_name,
			$this->sdk_path_helper->generate_sdk_path(),
			array(),
			$this->version,
			false
		);
	}

}
