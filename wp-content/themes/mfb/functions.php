<?php
/**
 * Maryland Food Bank functions and definitions
 *
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 *
 * @package Maryland_Food_Bank
 */

if ( ! function_exists( 'mfb_setup' ) ) :
	/**
	 * Sets up theme defaults and registers support for various WordPress features.
	 *
	 * Note that this function is hooked into the after_setup_theme hook, which
	 * runs before the init hook. The init hook is too late for some features, such
	 * as indicating support for post thumbnails.
	 */
	function mfb_setup() {
		/*
		 * Make theme available for translation.
		 * Translations can be filed in the /languages/ directory.
		 * If you're building a theme based on Maryland Food Bank, use a find and replace
		 * to change 'mfb' to the name of your theme in all the template files.
		 */
		load_theme_textdomain( 'mfb', get_template_directory() . '/languages' );

		// Add default posts and comments RSS feed links to head.
		add_theme_support( 'automatic-feed-links' );

		/*
		 * Let WordPress manage the document title.
		 * By adding theme support, we declare that this theme does not use a
		 * hard-coded <title> tag in the document head, and expect WordPress to
		 * provide it for us.
		 */
		add_theme_support( 'title-tag' );

		/*
		 * Enable support for Post Thumbnails on posts and pages.
		 *
		 * @link https://developer.wordpress.org/themes/functionality/featured-images-post-thumbnails/
		 */
		add_theme_support( 'post-thumbnails' );

		// This theme uses wp_nav_menu() in one location.
		register_nav_menus( array(
			'menu-1' => esc_html__( 'Primary', 'mfb' ),
			'primary-navigation' => esc_html__( 'Primary Navigation', 'mfb' ),
			'utility-navigation' => esc_html__( 'Utility Navigation', 'mfb' ),
			'donate-navigation' => esc_html__( 'Donate Navigation', 'mfb' ),
			'footer-navigation' => esc_html__( 'Footer Navigation', 'mfb' ),
		) );

		/*
		 * Switch default core markup for search form, comment form, and comments
		 * to output valid HTML5.
		 */
		add_theme_support( 'html5', array(
			'search-form',
			'comment-form',
			'comment-list',
			'gallery',
			'caption',
		) );

		// Set up the WordPress core custom background feature.
		add_theme_support( 'custom-background', apply_filters( 'mfb_custom_background_args', array(
			'default-color' => 'ffffff',
			'default-image' => '',
		) ) );

		// Add theme support for selective refresh for widgets.
		add_theme_support( 'customize-selective-refresh-widgets' );

		/**
		 * Add support for core custom logo.
		 *
		 * @link https://codex.wordpress.org/Theme_Logo
		 */
		add_theme_support( 'custom-logo', array(
			'height'      => 250,
			'width'       => 250,
			'flex-width'  => true,
			'flex-height' => true,
		) );
	}
endif;
add_action( 'after_setup_theme', 'mfb_setup' );

/**
 * Set the content width in pixels, based on the theme's design and stylesheet.
 *
 * Priority 0 to make it available to lower priority callbacks.
 *
 * @global int $content_width
 */
function mfb_content_width() {
	// This variable is intended to be overruled from themes.
	// Open WPCS issue: {@link https://github.com/WordPress-Coding-Standards/WordPress-Coding-Standards/issues/1043}.
	// phpcs:ignore WordPress.NamingConventions.PrefixAllGlobals.NonPrefixedVariableFound
	$GLOBALS['content_width'] = apply_filters( 'mfb_content_width', 640 );
}
add_action( 'after_setup_theme', 'mfb_content_width', 0 );

/**
 * Register widget area.
 *
 * @link https://developer.wordpress.org/themes/functionality/sidebars/#registering-a-sidebar
 */
function mfb_widgets_init() {
	register_sidebar( array(
		'name'          => esc_html__( 'Sidebar', 'mfb' ),
		'id'            => 'sidebar-1',
		'description'   => esc_html__( 'Add widgets here.', 'mfb' ),
		'before_widget' => '<section id="%1$s" class="widget %2$s">',
		'after_widget'  => '</section>',
		'before_title'  => '<h2 class="widget-title">',
		'after_title'   => '</h2>',
	) );
	register_sidebar( array(
		'name'          => esc_html__( 'Footer Tier 1 Column 1', 'mfb' ),
		'id'            => 'ft1-1',
		'description'   => esc_html__( 'Add widgets here.', 'mfb' ),
		'before_widget' => '<div id="%1$s" class="widget %2$s">',
		'after_widget'  => '</div>',
		'before_title'  => '',
		'after_title'   => '',
	) );
	register_sidebar( array(
		'name'          => esc_html__( 'Footer Tier 1 Column 2', 'mfb' ),
		'id'            => 'ft1-2',
		'description'   => esc_html__( 'Add widgets here.', 'mfb' ),
		'before_widget' => '<div id="%1$s" class="widget %2$s">',
		'after_widget'  => '</div>',
		'before_title'  => '',
		'after_title'   => '',
	) );
	register_sidebar( array(
		'name'          => esc_html__( 'Footer Tier 1 Column 3', 'mfb' ),
		'id'            => 'ft1-3',
		'description'   => esc_html__( 'Add widgets here.', 'mfb' ),
		'before_widget' => '<div id="%1$s" class="widget %2$s">',
		'after_widget'  => '</div>',
		'before_title'  => '',
		'after_title'   => '',
	) );
	register_sidebar( array(
		'name'          => esc_html__( 'Footer Tier 1 Column 4', 'mfb' ),
		'id'            => 'ft1-4',
		'description'   => esc_html__( 'Add widgets here.', 'mfb' ),
		'before_widget' => '<div id="%1$s" class="widget %2$s">',
		'after_widget'  => '</div>',
		'before_title'  => '',
		'after_title'   => '',
	) );
	register_sidebar( array(
		'name'          => esc_html__( 'Footer Tier 2 Column 1', 'mfb' ),
		'id'            => 'ft2-1',
		'description'   => esc_html__( 'Add widgets here.', 'mfb' ),
		'before_widget' => '<div id="%1$s" class="widget %2$s">',
		'after_widget'  => '</div>',
		'before_title'  => '',
		'after_title'   => '',
	) );
	register_sidebar( array(
		'name'          => esc_html__( 'Footer Tier 2 Column 2', 'mfb' ),
		'id'            => 'ft2-2',
		'description'   => esc_html__( 'Add widgets here.', 'mfb' ),
		'before_widget' => '<div id="%1$s" class="widget %2$s">',
		'after_widget'  => '</div>',
		'before_title'  => '',
		'after_title'   => '',
	) );
	register_sidebar( array(
		'name'          => esc_html__( 'Footer Tier 2 Column 3', 'mfb' ),
		'id'            => 'ft2-3',
		'description'   => esc_html__( 'Add widgets here.', 'mfb' ),
		'before_widget' => '<div id="%1$s" class="widget %2$s">',
		'after_widget'  => '</div>',
		'before_title'  => '',
		'after_title'   => '',
	) );
	register_sidebar( array(
		'name'          => esc_html__( 'Footer Tier 3', 'mfb' ),
		'id'            => 'ft3',
		'description'   => esc_html__( 'Add widgets here.', 'mfb' ),
		'before_widget' => '<div id="%1$s" class="widget %2$s">',
		'after_widget'  => '</div>',
		'before_title'  => '',
		'after_title'   => '',
	) );

}
add_action( 'widgets_init', 'mfb_widgets_init' );

/**
 * Enqueue scripts and styles.
 */
function mfb_scripts() {
	wp_enqueue_style( 'mfb-style', get_stylesheet_directory_uri() . '/_silc/build/css/index.css' );
	wp_enqueue_script( 'mfb-script', get_template_directory_uri() . '/_silc/build/js/index.js', array(), '20170608', true );

	// wp_enqueue_script( 'mfb-navigation', get_template_directory_uri() . '/js/navigation.js', array(), '20151215', true );

	wp_enqueue_script( 'mfb-skip-link-focus-fix', get_template_directory_uri() . '/js/skip-link-focus-fix.js', array(), '20151215', true );


	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}
}
add_action( 'wp_enqueue_scripts', 'mfb_scripts' );

function mfb_donation_form_steps( $progress_steps, $form, $page ) {
	if ($form['cssClass'] == 'donation-form') {
		$name = $form['pagination']['pages'][$page - 1];
		$total = count($form['pagination']['pages']);
		$progress_steps = "<div class='donation-form__header'><h3>" . $name . "</h3><span>Step <em>" . $page . "</em> of <em>" . $total . "</em></span></div>";
	}
	return $progress_steps;
}
add_filter( 'gform_progress_steps', 'mfb_donation_form_steps', 10, 3 );

function mfb_donation_address_validation( $result, $value, $form, $field ) {
	$zipCode = rgar( $value, $field->id . '.5' );
	if (preg_match('/^[0-9]{5}$/', $zipCode)) {
		// If we wanted to validate 4 digit validation number preg_match('/^[0-9]{5}(-[0-9]{4})?$/', $zipCode)
		$result['is_valid'] = true;
		$result['message']  = '';
	} else {
		$result['is_valid'] = false;
		$result['message']  = 'The US zip code must contain 5 digits';
	}
  return $result;
}
add_filter( 'gform_field_validation_47_67', 'mfb_donation_address_validation', 10, 4 );

function mfb_donation_form_amounts( $form ) {
	// Only target forms with donation-form class.
	if ($form['cssClass'] == 'donation-form') {
		if (!empty($_GET['amounts'])) {
			$custom_amount = end($form['fields'][8]['choices']);
			$choices = array();
			$amounts = explode(',', $_GET['amounts']);
			foreach ($amounts as $key => $amount) {
				$choice = array();
				// Only add choice if amount is an integer
				$values = explode('|', $amount);
				if (ctype_digit($values[0])) {
					$choice['value'] = $values[0];
					$choice['price'] = '$ ' . $values[0];
					$choice['text'] = '$' . $values[0];
					// Allow label override
					if (isset($values[1])) {
						$choice['text'] = $values[1];
					}
					// Allow setting default selected
					if (isset($_GET['selected']) && $_GET['selected'] == $values[0]) {
						$choice['isSelected'] = 1;
					}
					else {
						$choice['isSelected'] = 0;
					}
				}

				if (!empty($choice)) {
					$choices[] = $choice;
				}
			}
			// Only include custom if amount is 0
			if ($custom_amount['value'] == 0) {
				$choices[] = $custom_amount;
				if (isset($_GET['custom']) && $_GET['custom'] == 0) {
					// Remove custom if override hides.
					array_pop($choices);
				}
			}
			if (!empty($choices)) {
				$form['fields'][8]['choices'] = $choices;
			}
		}
	}
  return $form;
}
add_filter('gform_pre_render', 'mfb_donation_form_amounts');

function mfb_donation_gform_confirmation( $confirmation, $form, $entry ) {
	if ($form['cssClass'] == 'donation-form') {
		if ( ! is_array( $confirmation ) || empty( $confirmation['redirect'] ) ) {
				return $confirmation;
		}
		$query_params = array();
		$parsed_url = parse_url($confirmation['redirect']);
		parse_str($parsed_url['query'], $query_params);
		if (strpos($query_params['amount'], '|')) {
			$parts = explode('|', $query_params['amount']);
			$amount = preg_replace("/[^0-9\.]/", "", $parts[0]);
			setlocale(LC_MONETARY, 'en_US');
			$amount_display = '$' . money_format('%i', $amount);
			$confirmation['redirect'] = add_query_arg( array( 'amount' => $amount_display ), $confirmation['redirect'] );
		}
	}
	return $confirmation;
}
add_filter( 'gform_confirmation', 'mfb_donation_gform_confirmation', 11, 3);
function mfb_donate_add_query_vars( $vars ){
	$vars[] = "amount";
	$vars[] = "other";
	$vars[] = "entry_id";
	$vars[] = "type";
	$vars[] = "payment";
  return $vars;
}
add_filter( 'query_vars', 'mfb_donate_add_query_vars' );

function mfb_gmw_radius_dropdown_output_1( $output, $gmw, $class ) {
	$miles  	   = explode( ",", $gmw['search_form']['radius'] );
	$output 	   = '';
	$default_value = apply_filters( 'gmw_search_form_default_radius', end( $miles ), $gmw );

	if ( count( $miles ) > 1 ) {
		$output .= "<select class=\"gmw-distance-select gmw-distance-select-{$gmw['ID']}\" name=\"{$gmw['url_px']}distance\">";
		foreach ( $miles as $mile ) {
			if ( !is_numeric( $mile ) )
				continue;

			if ( isset( $_GET[$gmw['url_px'].'distance'] ) && $_GET[$gmw['url_px'].'distance'] == $mile ) {
				$mile_s = 'selected="selected"';
			} else {
				$mile_s = "";
			}
			$output .= "<option value=\"{$mile}\" {$mile_s}>{$mile} Miles</option>";
		}
		$output .= "</select>";

	} else {
		$output = "<input type=\"hidden\" name=\"{$gmw['url_px']}distance\" value=\"{$default_value}\" />";
	}
	return $output;
}
add_filter( 'gmw_radius_dropdown_output_1', 'mfb_gmw_radius_dropdown_output_1', 10, 3 );

/**
 * Prevent update notification for plugin
 * http://www.thecreativedev.com/disable-updates-for-specific-plugin-in-wordpress/
 * Place in theme functions.php or at bottom of wp-config.php
 */
function disable_plugin_updates( $value ) {

	$pluginsToDisable = [
			'divi-builder/divi-builder.php',
			'divi-booster/divi-booster.php',
	];

	if ( isset($value) && is_object($value) ) {
			foreach ($pluginsToDisable as $plugin) {
					if ( isset( $value->response[$plugin] ) ) {
							unset( $value->response[$plugin] );
					}
			}
	}
	return $value;
}
add_filter( 'site_transient_update_plugins', 'disable_plugin_updates' );

function gmw_fix_pagination_page_number( $gmw ) {

	$gmw['paged_name'] = ( is_front_page() || is_single() ) ? 'page' : 'paged';
	$gmw['paged']      = get_query_var( $gmw['paged_name'] ) ? get_query_var( $gmw['paged_name'] ) : 1;

	return $gmw;
}
add_filter( 'gmw_default_form_values', 'gmw_fix_pagination_page_number', 50 );

// Add new note with PayPal transaction ID for a new subscription payment.

add_action( 'gform_post_add_subscription_payment', function ( $entry, $action ) {
GFCommon::log_debug( METHOD . '(): running.' );

if ( 'PayPal' === $action['payment_method'] && 'add_subscription_payment' === $action['type'] ) {
GFFormsModel::add_note( $entry['id'], 0, 'PayPal', 'My custom note for new Transaction ID: ' . $action['transaction_id'] );
GFCommon::log_debug( METHOD . '(): Custom note for PayPal added.' );
}
},10,2 );


/**
 * Implement the Custom Header feature.
 */
require get_template_directory() . '/inc/custom-header.php';

/**
 * Custom template tags for this theme.
 */
require get_template_directory() . '/inc/template-tags.php';

/**
 * Functions which enhance the theme by hooking into WordPress.
 */
require get_template_directory() . '/inc/template-functions.php';

/**
 * Customizer additions.
 */
require get_template_directory() . '/inc/customizer.php';

/**
 * Shortcodes
 */
require get_template_directory() . '/inc/shortcodes.php';

/**
 * Load Jetpack compatibility file.
 */
if ( defined( 'JETPACK__VERSION' ) ) {
	require get_template_directory() . '/inc/jetpack.php';
}

