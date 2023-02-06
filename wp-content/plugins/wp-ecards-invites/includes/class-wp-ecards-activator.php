<?php

/**
 * Fired during plugin activation
 *
 * @link       https://ecardwidget.com
 * @since      1.0.0
 *
 * @package    Wp_Ecards
 * @subpackage Wp_Ecards/includes
 */

/**
 * Fired during plugin activation.
 *
 * This class defines all code necessary to run during the plugin's activation.
 *
 * @since      1.0.0
 * @package    Wp_Ecards
 * @subpackage Wp_Ecards/includes
 * @author     Tim Badolato <tim@ecardwidget.com>
 */
class Wp_Ecards_Activator {

	/**
	 * Short Description. (use period)
	 *
	 * Long Description.
	 *
	 * @since    1.0.0
	 */
	public static function activate() {
		// self::wp_ecards_install();
		(new self)->wp_ecards_install();
		// self::wp_ecards_install_data();
	}

	function wp_ecards_install() {

		global $wpdb;
		global $wp_ecards_db_version;
		global $wp_ecards_table_name;

		add_option( 'wp_ecards_api_key', '', '', 'yes' );
		add_option( 'wp_ecards_credit', false, '', 'yes' );


		// $charset_collate = $wpdb->get_charset_collate();

		// $sql = "CREATE TABLE $wp_ecards_table_name (
		// 	id varchar(90) NOT NULL,
		// 	value text NOT NULL,
		// 	createdat datetime DEFAULT '0000-00-00 00:00:00' NOT NULL,
		// 	UNIQUE KEY id (id)
		// ) $charset_collate;";

		// require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
		// dbDelta( $sql );

		// add_option( 'wp_ecards_db_version', $wp_ecards_db_version );
	}

}
