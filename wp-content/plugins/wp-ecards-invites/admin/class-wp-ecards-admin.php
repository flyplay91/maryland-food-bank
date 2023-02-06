<?php

/**
 * The admin-specific functionality of the plugin.
 *
 * @link       https://ecardwidget.com
 * @since      1.0.0
 *
 * @package    Wp_Ecards
 * @subpackage Wp_Ecards/admin
 */

/**
 * The admin-specific functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @package    Wp_Ecards
 * @subpackage Wp_Ecards/admin
 * @author     Tim Badolato <tim@ecardwidget.com>
 */
class Wp_Ecards_Admin {

	/**
	 * The ID of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $plugin_name    The ID of this plugin.
	 */
	private $plugin_name;

	/**
	 * The version of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $version    The current version of this plugin.
	 */
	private $version;

	/**
	 * Initialize the class and set its properties.
	 *
	 * @since    1.0.0
	 * @param      string    $plugin_name       The name of this plugin.
	 * @param      string    $version    The version of this plugin.
	 */
	public function __construct( $plugin_name, $version ) {

		$this->plugin_name = $plugin_name;
		$this->version = $version;

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
		 * defined in Wp_Ecards_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Wp_Ecards_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/wp-ecards-admin.css', array(), $this->version, 'all' );

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
		 * defined in Wp_Ecards_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Wp_Ecards_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_script( $this->plugin_name, 'https://wp.ecardwidget.com/assets/app/vendor/resizerLatest/iframeResizer.min.js', array( 'jquery' ), $this->version, false );
	}


	public function display_admin_page() {
		add_menu_page(
			'WP Ecards', // Page title
			'WP Ecards', // Menu title
			'manage_options', // capability
			'wp-ecards-admin', //menu slug
			array($this, 'ecard_main'), //function
			'dashicons-email', //icon url
			'80.0' // position from the menu top
		);

		// add_submenu_page(
		// 	'wp-ecards-admin',
		// 	'Settings',
		// 	'Sub Level Menu',
		// 	'manage_options',
		// 	'wp-ecards-admin-asdf',
		// 	'myplguin_admin_sub_page'
		// );
	}

	public function ecard_main() {
		global $wpdb;
		global $wp_ecards_table_name;
		global $plugin_path;

		$route = "";
		if(isset($_GET["route"])) $route = $_GET["route"];

		$deauthorize = "";
		if(isset($_GET["deauthorize"])) $deauthorize = $_GET["deauthorize"];

		if($deauthorize) {
			update_option( 'wp_ecards_credit', 0 );
			update_option( 'wp_ecards_api_key', '' );
		}

		if(strlen($route)) {
			self::$route();
		} else {
			$apiKey = get_option( 'wp_ecards_api_key', '' );

			$checkAPIKey = self::checkAPIKey($apiKey);

			// if($_GET['giveCredit']) {
			// 	update_option( 'wp_ecards_credit', 1 );
			// } else if(!$_GET['giveCredit']) {
			// 	update_option( 'wp_ecards_credit', 0 );
			// }
			if($checkAPIKey && !isset($_GET["auth"])) {
				$getWidgetList = self::apiCall("https://wp.ecardwidget.com/api/getWidgets?apikey=".$apiKey);

				if(strlen($getWidgetList) && self::isJson($getWidgetList)) {
					$widgetList = json_decode($getWidgetList,true);
				}

				include $plugin_path.'admin/partials/wp-ecards-list.php';
			} else {

				include $plugin_path.'admin/partials/wp-ecards-authenticate.php';
			}
		}
	}

	private function checkAPIKey($apiKey) {
		$checkApiKey = self::apiCall("https://wp.ecardwidget.com/api/checkApiKey?apikey=".$apiKey);

		if(strlen($checkApiKey) && self::isJson($checkApiKey)) {
			$checkApiKey = json_decode($checkApiKey,true);
			if($checkApiKey["success"] === 'true') {
				return true;
			}
		}
		update_option( 'wp_ecards_api_key', '' );
		return false;
	}

	private function apiCall($url){
		if(!function_exists('curl_version')) {
	    	echo '<br><br><br><div id="message" class="notice is-dismissible notice-error"><p>Sorry, this plugin will not work without CURL installed. Please have your host enable CURL and try again.</p></div>'; exit();
		} else {
			//initialize
			$ch = curl_init();

			// 2. set the options, including the url
			curl_setopt($ch, CURLOPT_URL, $url);

			//execute
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
			$result = curl_exec($ch);
			if ($result === FALSE) {
			    echo '<br><br><br><div id="message" class="notice is-dismissible notice-error"><p>cURL Error: ' . curl_error($ch);
			}

			//free up the curl handle
			curl_close($ch);

			return $result;
		}
	}

	private function isJson($string) {
		json_decode($string);
		return (json_last_error() == JSON_ERROR_NONE);
	}

	public function save_key() {
		$apiKey = $_POST['key'];

		if(self::notNullOrEmpty($apiKey)) {
			echo "SUCCESS";
			update_option( 'wp_ecards_api_key', $apiKey );
		} else {
			echo "FAIL";
		}
	}

	function notNullOrEmpty($checkThis){
	    return (isset($checkThis) && strlen(trim($checkThis)) != 0);
	}

	// public function wp_ecards_set_api_key() {
	// 	global $wpdb;
	// 	global $wp_ecards_table_name;

	// 	$checkAPIKey = $wpdb->get_results( "SELECT * FROM $wp_ecards_table_name WHERE id = 'apikey'", OBJECT );

	// 	if(count($checkAPIKey)) {
	// 		$api_key = 'update';
	// 		$wpdb->update(
	// 			$wp_ecards_table_name,
	// 			array(
	// 				'value' => $api_key,
	// 				'createdat' => current_time( 'mysql' ),
	// 			),
	// 			array( 'id' => 'apikey' ) // where
	// 		);
	// 	} else {
	// 		$api_key = 'insert';
	// 		$wpdb->insert(
	// 			$wp_ecards_table_name,
	// 			array(
	// 				'id' => 'apikey',
	// 				'value' => $api_key,
	// 				'createdat' => current_time( 'mysql' ),
	// 			)
	// 		);
	// 	}

	// }

}
