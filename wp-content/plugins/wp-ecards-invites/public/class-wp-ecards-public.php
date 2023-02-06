<?php

/**
 * The public-facing functionality of the plugin.
 *
 * @link       https://ecardwidget.com
 * @since      1.0.0
 *
 * @package    Wp_Ecards
 * @subpackage Wp_Ecards/public
 */

/**
 * The public-facing functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @package    Wp_Ecards
 * @subpackage Wp_Ecards/public
 * @author     Tim Badolato <tim@ecardwidget.com>
 */
class Wp_Ecards_Public {

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
	 * @param      string    $plugin_name       The name of the plugin.
	 * @param      string    $version    The version of this plugin.
	 */
	public function __construct( $plugin_name, $version ) {

		$this->plugin_name = $plugin_name;
		$this->version = $version;

		$creditLink = get_option( 'wp_ecards_credit', false );

		// Add shortcodes
		add_shortcode( 'ecard', 'ecardtag_func' );
		function ecardtag_func( $atts ) {
			if(is_array($atts) && !array_key_exists("id", $atts)) $atts["id"] = "";
			if(is_array($atts) && !array_key_exists("poweredbylink", $atts)) $atts["poweredbylink"] = "true";
			if( !is_array($atts) || trim( strlen( $atts["id"] ) ) == "" ) {
				return "ERROR: The [Ecard] shortcode is missing the required 'id' attribute.";
			}
			$embed = '<script type="text/javascript" src="https://ecardwidget.com/embed/ecard/'.$atts["id"].'"></script><div id="ecardwidget_id_'.$atts["id"].'"></div>';
			$poweredbylink = 0;
			if($atts["poweredbylink"] == "true") $poweredbylink = 1;
			if($poweredbylink) {
				$embed .= '<a href="https://ecardwidget.com/" style="font-size:10px;">Powered by WP Ecards</a>';
			}
			return $embed;
		}

		// Add shortcodes
		add_shortcode( 'ecards', 'ecardstag_func' );
		function ecardstag_func( $atts ) {
			if(is_array($atts) && !array_key_exists("id", $atts)) $atts["id"] = "";
			if(is_array($atts) && !array_key_exists("poweredbylink", $atts)) $atts["poweredbylink"] = "true";
			if( !is_array($atts) || trim( strlen( $atts["id"] ) ) == "" ) {
				return "ERROR: The [Ecard] shortcode is missing the required 'id' attribute.";
			}
			$embed = '<script type="text/javascript" src="https://ecardwidget.com/embed/widget/'.$atts["id"].'"></script><div id="ecardwidget_id_'.$atts["id"].'"></div>';
			$poweredbylink = 0;
			if($atts["poweredbylink"] == "true") $poweredbylink = 1;
			if($poweredbylink) {
				$embed .= '<a href="https://ecardwidget.com/" style="font-size:10px;">Powered by WP Ecards</a>';
			}
			return $embed;
		}
	}

	/**
	 * Register the stylesheets for the public-facing side of the site.
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

		wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/wp-ecards-public.css', array(), $this->version, 'all' );

	}

	/**
	 * Register the JavaScript for the public-facing side of the site.
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

		wp_enqueue_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'js/wp-ecards-public.js', array( 'jquery' ), $this->version, false );

	}

}
