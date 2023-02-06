<?php

/**
 * The plugin bootstrap file
 *
 * This file is read by WordPress to generate the plugin information in the plugin
 * admin area. This file also includes all of the dependencies used by the plugin,
 * registers the activation and deactivation functions, and defines a function
 * that starts the plugin.
 *
 * @link              https://ecardwidget.com
 * @since             1.3.901
 * @package           Wp_Ecards
 *
 * @wordpress-plugin
 * Plugin Name:       WP Ecards
 * Plugin URI:        ecardwidget.com
 * Description:       Finally an ecard plugin for the rest of us! With this plugin you can customize your ecards, choose premade designs and send via email and social media.
 * Version:           1.3.901
 * Author:            EiQ Interactive LLC
 * Author URI:        https://ecardwidget.com
 * License:           MIT
 * License URI:       https://opensource.org/licenses/MIT
 * Text Domain:       wp-ecards-invites
 * Domain Path:       /languages
 */

// require dirname(__DIR__, 2) . '/kint/Kint.class.php';
// dump example: d(__DIR__); exit();

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

/**
 * The code that runs during plugin activation.
 * This action is documented in includes/class-wp-ecards-activator.php
 */
function activate_wp_ecards() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-wp-ecards-activator.php';
	Wp_Ecards_Activator::activate();
}

/**
 * The code that runs during plugin deactivation.
 * This action is documented in includes/class-wp-ecards-deactivator.php
 */
function deactivate_wp_ecards() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-wp-ecards-deactivator.php';
	Wp_Ecards_Deactivator::deactivate();
}

register_activation_hook( __FILE__, 'activate_wp_ecards' );
register_deactivation_hook( __FILE__, 'deactivate_wp_ecards' );

/**
 * The core plugin class that is used to define internationalization,
 * admin-specific hooks, and public-facing site hooks.
 */
require plugin_dir_path( __FILE__ ) . 'includes/class-wp-ecards.php';

/**
 * Begins execution of the plugin.
 *
 * Since everything within the plugin is registered via hooks,
 * then kicking off the plugin from this point in the file does
 * not affect the page life cycle.
 *
 * @since    1.0.0
 */
function run_wp_ecards() {
	global $wpdb;
	global $wp_ecards_db_version;
	global $wp_ecards_table_name;
	global $plugin_path;

	//ddd($wpdb);

	$plugin_path = plugin_dir_path( __FILE__ );

	$wp_ecards_db_version = '1.0';
	$wp_ecards_table_name =  $wpdb->prefix . "ecp_ecards";

	$plugin = new Wp_Ecards();
	$plugin->run();

}
run_wp_ecards();
