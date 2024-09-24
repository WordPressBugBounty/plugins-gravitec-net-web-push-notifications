<?php

defined( 'ABSPATH' ) or die( 'This page may not be accessed directly.' );

/**
 * Define the internationalization functionality
 *
 * Loads and defines the internationalization files for this plugin
 * so that it is ready for translation.
 *
 * @link       https://gravitec.net/
 * @since      1.0.0
 *
 * @package    Gravitecnet
 * @subpackage Gravitecnet/includes
 */

/**
 * Define the internationalization functionality.
 *
 * Loads and defines the internationalization files for this plugin
 * so that it is ready for translation.
 *
 * @since      1.0.0
 * @package    Gravitecnet
 * @subpackage Gravitecnet/includes
 * @author     Gravitec Support <support@gravitec.net>
 */
class Gravitecnet_i18n {


	/**
	 * Load the plugin text domain for translation.
	 *
	 * @since    1.0.0
	 */
	public function load_plugin_textdomain() {

		load_plugin_textdomain(
			'gravitecnet',
			false,
			dirname( dirname( plugin_basename( __FILE__ ) ) ) . '/languages/'
		);

	}


}
