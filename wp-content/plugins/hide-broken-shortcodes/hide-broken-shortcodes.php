<?php
/**
 * Plugin Name: Hide Broken Shortcodes
 * Version:     1.9.4
 * Plugin URI:  https://coffee2code.com/wp-plugins/hide-broken-shortcodes/
 * Author:      Scott Reilly
 * Author URI:  https://coffee2code.com/
 * Text Domain: hide-broken-shortcodes
 * License:     GPLv2 or later
 * License URI: https://www.gnu.org/licenses/gpl-2.0.html
 * Description: Prevent broken shortcodes from appearing in posts and pages.
 *
 * Compatible with WordPress 2.5 through 5.8+.
 *
 * =>> Read the accompanying readme.txt file for instructions and documentation.
 * =>> Also, visit the plugin's homepage for additional information and updates.
 * =>> Or visit: https://wordpress.org/plugins/hide-broken-shortcodes/
 *
 * @package Hide_Broken_Shortcodes
 * @author  Scott Reilly
 * @version 1.9.4
 */

/*
	Copyright (c) 2009-2021 by Scott Reilly (aka coffee2code)

	This program is free software; you can redistribute it and/or
	modify it under the terms of the GNU General Public License
	as published by the Free Software Foundation; either version 2
	of the License, or (at your option) any later version.

	This program is distributed in the hope that it will be useful,
	but WITHOUT ANY WARRANTY; without even the implied warranty of
	MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
	GNU General Public License for more details.

	You should have received a copy of the GNU General Public License
	along with this program; if not, write to the Free Software
	Foundation, Inc., 51 Franklin Street, Fifth Floor, Boston, MA  02110-1301, USA.
*/

defined( 'ABSPATH' ) or die();

if ( ! class_exists( 'c2c_HideBrokenShortcodes' ) ) :

class c2c_HideBrokenShortcodes {

	/**
	 * Returns version of the plugin.
	 *
	 * @since 1.4
	 */
	public static function version() {
		return '1.9.4';
	}

	/**
	 * Initializes class variables and adds actions and filters.
	 */
	public static function init() {
		self::register_filters();
	}

	/**
	 * Registers filters and loads text domain.
	 *
	 * @since 1.7 Filter 'the_excerpt' by default as well.
	 */
	public static function register_filters() {
		// Load plugin textdomain.
		load_plugin_textdomain( 'hide-broken-shortcodes' );

		/**
		 * Filters the list of filters that get processed for broken shortcode hiding.
		 *
		 * @param array $filters The list of filters. Default ['the_content', 'the_excerpt', 'widget_text'].
		 */
		$filters = (array) apply_filters( 'hide_broken_shortcodes_filters', array( 'the_content', 'the_excerpt', 'widget_text' ) );

		foreach ( $filters as $filter ) {
			add_filter( $filter, array( __CLASS__, 'do_shortcode' ), 1001 ); // Do this after the built-in do_shortcode() operates, which is 11
		}
	}

	/**
	 * Like WP's `do_shortcode()`, but doesn't return content immediately if no
	 * shortcodes exist.
	 *
	 * @param  string $content The primary text to be processed for shortcodes.
	 * @return string
	 */
	public static function do_shortcode( $content ) {
		if ( false === strpos( $content, '[' ) ) {
			return $content;
		}

		return preg_replace_callback( '/' . self::get_shortcode_regex() . '/s', array( __CLASS__, 'do_shortcode_tag' ), $content );
	}

	/**
	 * Like WP's `get_shortcode_regex()`, but matches for anything that looks
	 * like a shortcode.
	 *
	 * @return string The regexp for finding shortcodes in text.
	 */
	public static function get_shortcode_regex() {
		$tagregexp = '[a-zA-Z_\-][0-9a-zA-Z_\-\+]*';

		// WARNING! Do not change this regex without changing do_shortcode_tag()
		return '(?!<.*)'                         // Non-capturing check that text within HTML tags are skipped
			. '\\['                              // Opening bracket
			. '(\\[?)'                           // 1: Optional second opening bracket for escaping shortcodes: [[tag]]
			. "($tagregexp)"                     // 2: Shortcode name
			. '(?![\\w-])'                       // Not followed by word character or hyphen
			. '('                                // 3: Unroll the loop: Inside the opening shortcode tag
			.     '[^\\]\\/]*'                   // Not a closing bracket or forward slash
			.     '(?:'
			.         '\\/(?!\\])'               // A forward slash not followed by a closing bracket
			.         '[^\\]\\/]*'               // Not a closing bracket or forward slash
			.     ')*?'
			. ')'
			. '(?:'
			.     '(\\/)'                        // 4: Self closing tag ...
			.     '\\]'                          // ... and closing bracket
			. '|'
			.     '\\]'                          // Closing bracket
			.     '(?:'
			.         '('                        // 5: Unroll the loop: Optionally, anything between the opening and closing shortcode tags
			.             '[^\\[]*+'             // Not an opening bracket
			.             '(?:'
			.                 '\\[(?!\\/\\2\\])' // An opening bracket not followed by the closing shortcode tag
			.                 '[^\\[]*+'         // Not an opening bracket
			.             ')*+'
			.         ')'
			.         '\\[\\/\\2\\]'             // Closing shortcode tag
			.     ')?'
			. ')'
			. '(\\]?)'                           // 6: Optional second closing brocket for escaping shortcodes: [[tag]]
			. '(?![^<>]*>)';                     // Non-capturing check that text within HTML tags are skipped
	}

	/**
	 * Callback to handle each shortcode not replaced via the traditional
	 * shortcode system.
	 *
	 * The actual replacement string used can be modified by filtering
	 * 'hide_broken_shortcode'. By default this is the text between the
	 * opening/closing shortcode tags, or an empty string if there was no
	 * closing tag.
	 *
	 * @param  string $m The preg_match result array for the unhandled shortcode.
	 * @return string    The replacement string for the unhandled shortcode.
	 */
	public static function do_shortcode_tag( $m ) {
		// If this function gets executed, then the shortcode found is not being handled.

		// allow [[foo]] syntax for escaping a tag
		if ( $m[1] == '[' && $m[6] == ']' ) {
			return substr( $m[0], 1, -1 );
		}

		// If text is being wrapped by opening and closing shortcode tag, show text. Otherwise, show nothing.
		$default_display = ( isset( $m[5] ) ? self::do_shortcode( $m[5] ) : '' );

		/**
		 * Filters the list of filters that get processed for broken shortcode hiding.
		 *
		 * @param array  $default_display The text within opening and closing shortcode tags, else an empty string.
		 * @param string $shortcode_name  The name of the shortcode.
		 * @param array  $match_array     The preg_match result array for the unhandled shortcode.
		 */
		return apply_filters( 'hide_broken_shortcode', $default_display, $m[2], $m );
	}

} // end c2c_HideBrokenShortcodes

add_action( 'plugins_loaded', array( 'c2c_HideBrokenShortcodes', 'init' ) );

endif; // end if !class_exists()
