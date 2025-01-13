<?php

/**
 * The plugin bootstrap file
 *
 * This file is read by WordPress to generate the plugin information in the plugin
 * admin area. This file also includes all of the dependencies used by the plugin,
 * registers the activation and deactivation functions, and defines a function
 * that starts the plugin.
 *
 * @link              https://gravitec.net/
 * @since             1.0.0
 * @package           Gravitecnet
 *
 * @wordpress-plugin
 * Plugin Name:       Gravitec.net - Web Push Notifications
 * Plugin URI:        https://gravitec.net/
 * Description:       Automated web push notifications for newsmakers and publishers
 * Version:           2.9.11
 * Author:            Gravitec.net
 * Author URI:        https://push.gravitec.net/
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       gravitecnet
 * Domain Path:       /languages
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

/**
 * Currently plugin version.
 * Start at version 1.0.0 and use SemVer - https://semver.org
 * Rename this for your plugin and update it as you release new versions.
 */
define( 'GRAVITECNET_VERSION', '2.9.11' );

/**
 * For Gravitec developers: replace cdn domain to test domain.
 * Redeclare in wp-config.php
 */
if ( ! defined( 'GRAVITECNET_TEST' ) ) {
	define( 'GRAVITECNET_TEST', false );
}

/**
 * The code that runs during plugin activation.
 * This action is documented in includes/class-gravitecnet-activator.php
 */
function activate_gravitecnet() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-gravitecnet-activator.php';
	Gravitecnet_Activator::activate();
}

/**
 * The code that runs during plugin deactivation.
 * This action is documented in includes/class-gravitecnet-deactivator.php
 */
function deactivate_gravitecnet() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-gravitecnet-deactivator.php';
	Gravitecnet_Deactivator::deactivate();
}

register_activation_hook( __FILE__, 'activate_gravitecnet' );
register_deactivation_hook( __FILE__, 'deactivate_gravitecnet' );

/**
 * The core plugin class that is used to define internationalization,
 * admin-specific hooks, and public-facing site hooks.
 */
require plugin_dir_path( __FILE__ ) . 'includes/class-gravitecnet.php';

/**
 * Begins execution of the plugin.
 *
 * Since everything within the plugin is registered via hooks,
 * then kicking off the plugin from this point in the file does
 * not affect the page life cycle.
 *
 * @since    1.0.0
 */

function gravitecnet_abandoned_cart_table(){
	if( class_exists( 'woocommerce' ) ){
		global $wpdb;
		$charset_collate = $wpdb->get_charset_collate();
		$query = "CREATE TABLE IF NOT EXISTS " . $wpdb->prefix . "gravitecnet_abandoned_cart (
				`id` int(10) unsigned NOT NULL AUTO_INCREMENT,
				`date_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
				`regID` varchar(500) CHARACTER SET latin1 DEFAULT NULL,
				`prod_count` TINYINT(4) DEFAULT NULL,
				`prod_id` BIGINT(20)  DEFAULT NULL,
				`cart_total` varchar(20) CHARACTER SET latin1 DEFAULT NULL,
				PRIMARY KEY  (`id`),
				UNIQUE(`regID`)
				) $charset_collate; ";
				
		require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
		dbDelta( $query );
	}	
}

add_action( 'after_setup_theme', 'gravitecnet_add_post_thumbnails');

function gravitecnet_add_post_thumbnails()
{
	add_theme_support( 'title-tag' );
	add_theme_support( 'post-thumbnails' );
	add_theme_support( 'custom-header' );
}

function run_gravitecnet() {
	gravitecnet_abandoned_cart_table();
	$plugin = new Gravitecnet();
	$plugin->run();
}

add_action( 'init', 'run_gravitecnet');