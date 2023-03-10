<?php
/*
Plugin Name: Connections Line Alpha - Template
Plugin URI: http://www.connections-pro.com
Description: Connections Lines Alpha - Template
Version: 1.0
Author: Steven A. Zahm
Author URI: http://www.connections-pro.com
Text Domain: connections_lines_alpha

Copyright 2013  Steven A. Zahm  (email : shazahm1@hotmail.com)

This program is free software; you can redistribute it and/or modify
it under the terms of the GNU General Public License, version 2, as
published by the Free Software Foundation.

This program is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
along with this program; if not, write to the Free Software
Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA
*/

if ( ! class_exists( 'CN_LinesAlpha' ) ) {

	class CNT_LinesAlpha {

		/**
		 * Stores a copy of the shortcode $atts for use throughout the class.
		 *
		 * @access private
		 * @since 3.0
		 * @var (array)
		 */
		private static $atts;

		/**
		 * Stores an initialized instance of cnTemplate.
		 *
		 * @access private
		 * @since 3.0
		 * @var (object)
		 */
		private static $template;

		public static function register() {

			$atts = array(
				'class'       => 'CNT_LinesAlpha',
				'name'        => 'Lines Alpha',
				'type'        => 'all',
				'version'     => '1.0',
				'author'      => 'Steven A. Zahm',
				'authorURL'   => 'connections-pro.com',
				'description' => 'Alpha version of the Line template.',
				'path'        => plugin_dir_path( __FILE__ ),
				'url'         => plugin_dir_url( __FILE__ ),
				'thumbnail'   => ''
				);

			cnTemplateFactory::register( $atts );
		}

		/**
		 * Setup the template.
		 *
		 * @access public
		 * @since 3.0
		 * @param (object) $template An initialized instance of the cnTemplate class.
		 * @return (void)
		 */
		public function __construct( $template ) {

			self::$template = $template;

			$template->part( array( 'tag' => 'card', 'type' => 'file', 'path' => $template->getPath() . 'card.php' ) );
			//$template->part( array( 'tag' => 'card_single', 'type' => 'file', 'path' => $template->getPath() . 'card-single.php' ) );
			//$template->part( array( 'tag' => 'js', 'type' => 'action', 'callback' => array( __CLASS__, 'enqueueJS' ) ) );

			if ( ! is_admin() ) {

				// Enqueue the frontend scripts and CSS.
				add_action( 'wp_enqueue_scripts', array( __CLASS__, 'enqueueCSS' ) );

				// Update the permitted shortcode attribute the user may use and override the template defaults as needed.
				add_filter( 'cn_list_atts_permitted-' . $template->getSlug() , array( __CLASS__, 'initShortcodeAtts') );
				add_filter( 'cn_list_atts-' . $template->getSlug() , array( __CLASS__, 'initTemplateOptions') );
			}
		}

		/**
		 * Enqueue the template's CSS file.
		 *
		 * @access private
		 * @since 3.0
		 * @uses wp_enqueue_style()
		 * @return (void)
		 */
		public static function enqueueCSS() {

			// If SCRIPT_DEBUG is set and TRUE load the non-minified JS files, otherwise, load the minified files.
			$min = defined('SCRIPT_DEBUG') && SCRIPT_DEBUG ? '' : '.min';

			wp_enqueue_style( 'cnt_' . self::$template->getSlug() . '-css', self::$template->getURL() . "lines-alpha$min.css", array(), self::$template->getVersion() );
		}

		/**
		 * Enqueue the template's JS file.
		 *
		 * @access private
		 * @since 3.0
		 * @uses wp_enqueue_script()
		 * @return (void)
		 */
		public static function enqueueJS() {

			// If SCRIPT_DEBUG is set and TRUE load the non-minified JS files, otherwise, load the minified files.
			$min = defined('SCRIPT_DEBUG') && SCRIPT_DEBUG ? '' : '.min';

			//wp_enqueue_script( 'cnt_' . self::$template->getSlug() . '-js' , self::$template->getURL() . "cmap$min.js", array( 'jquery-chosen-min' ), self::$template->getVersion(), TRUE );
		}


		/**
		 * Initiate the permitted template shortcode options and load the default values.
		 *
		 * @access private
		 * @since 3.0
		 * @param  (array)  $permittedAtts The shortcode $atts array.
		 * @return (array)
		 */
		public static function initShortcodeAtts( $permittedAtts = array() ) {
			global $connections;

			$addressLabel = $connections->options->getDefaultAddressValues();
			$phoneLabel   = $connections->options->getDefaultPhoneNumberValues();
			$emailLabel   = $connections->options->getDefaultEmailValues();

			$permittedAtts['enable_search']                   = FALSE;

			$permittedAtts['enable_pagination']               = FALSE;
			$permittedAtts['page_limit']                      = 20;
			$permittedAtts['pagination_position']             = 'after';

			$permittedAtts['enable_category_select']          = FALSE;
			$permittedAtts['show_empty_categories']           = TRUE;
			$permittedAtts['show_category_count']             = FALSE;
			$permittedAtts['category_select_position']        = 'before';
			$permittedAtts['enable_category_by_root_parent']  = FALSE;
			$permittedAtts['enable_category_multi_select']    = FALSE;
			$permittedAtts['enable_category_group_by_parent'] = FALSE;

			$permittedAtts['show_title']                      = FALSE;
			$permittedAtts['show_org']                        = TRUE;
			$permittedAtts['show_contact_name']               = FALSE;
			$permittedAtts['show_family']                     = FALSE;
			$permittedAtts['show_addresses']                  = FALSE;
			$permittedAtts['show_phone_numbers']              = TRUE;
			$permittedAtts['show_email']                      = TRUE;
			$permittedAtts['show_im']                         = FALSE;
			$permittedAtts['show_social_media']               = FALSE;
			$permittedAtts['show_dates']                      = FALSE;
			$permittedAtts['show_links']                      = FALSE;

			$permittedAtts['address_types']                   = NULL;
			$permittedAtts['phone_types']                     = NULL;
			$permittedAtts['email_types']                     = NULL;

			$permittedAtts['image']                           = 'photo';
			$permittedAtts['image_width']                     = NULL;
			$permittedAtts['image_height']                    = NULL;
			$permittedAtts['image_fallback']                  = 'none';

			$permittedAtts['str_select']                      = 'Select Category';
			$permittedAtts['str_select_all']                  = 'Show All Categories';
			$permittedAtts['str_image']                       = 'No Photo Available';
			$permittedAtts['str_contact']                     = 'Contact';
			$permittedAtts['str_home_addr']                   = $addressLabel['home'];
			$permittedAtts['str_work_addr']                   = $addressLabel['work'];
			$permittedAtts['str_school_addr']                 = $addressLabel['school'];
			$permittedAtts['str_other_addr']                  = $addressLabel['other'];
			$permittedAtts['str_home_phone']                  = $phoneLabel['homephone'];
			$permittedAtts['str_home_fax']                    = $phoneLabel['homefax'];
			$permittedAtts['str_cell_phone']                  = $phoneLabel['cellphone'];
			$permittedAtts['str_work_phone']                  = $phoneLabel['workphone'];
			$permittedAtts['str_work_fax']                    = $phoneLabel['workfax'];
			$permittedAtts['str_personal_email']              = $emailLabel['personal'];
			$permittedAtts['str_work_email']                  = $emailLabel['work'];

			$permittedAtts['name_format']                     = '%prefix% %first% %middle% %last% %suffix%';
			$permittedAtts['contact_name_format']             = '%label%: %first% %last%';
			$permittedAtts['addr_format']                     = '%label% %line1% %line2% %line3% %city% %state%  %zipcode% %country%';
			$permittedAtts['email_format']                    = '%address%';
			$permittedAtts['phone_format']                    = '%number%';
			$permittedAtts['link_format']                     = '%label%%separator% %title%';
			$permittedAtts['date_format']                     = '%label%%separator% %date%';

			// Set this option so we can define template functionality: should we expand details or link to the single entry page.
			$permittedAtts['link']                            = cnSettingsAPI::get( 'connections', 'connections_link', 'name' );

			return $permittedAtts;
		}

		/**
		 * Initiate the template options using the user supplied shortcode option values.
		 *
		 * @access private
		 * @since 3.0
		 * @param  (array)  $atts The shortcode $atts array.
		 * @return (array)
		 */
		public static function initTemplateOptions( $atts ) {
			$convert = new cnFormatting();

			// Because the shortcode option values are treated as strings some of the values have to converted to boolean.
			$convert->toBoolean( $atts['enable_search'] );
			$convert->toBoolean( $atts['enable_pagination'] );
			$convert->toBoolean( $atts['enable_category_select'] );
			$convert->toBoolean( $atts['show_empty_categories'] );
			$convert->toBoolean( $atts['show_category_count'] );
			$convert->toBoolean( $atts['enable_category_by_root_parent'] );
			$convert->toBoolean( $atts['enable_category_multi_select'] );
			$convert->toBoolean( $atts['enable_category_group_by_parent'] );

			$convert->toBoolean( $atts['show_title'] );
			$convert->toBoolean( $atts['show_org'] );
			$convert->toBoolean( $atts['show_contact_name'] );
			$convert->toBoolean( $atts['show_family'] );
			$convert->toBoolean( $atts['show_addresses'] );
			$convert->toBoolean( $atts['show_phone_numbers'] );
			$convert->toBoolean( $atts['show_email'] );
			$convert->toBoolean( $atts['show_im'] );
			$convert->toBoolean( $atts['show_social_media'] );
			$convert->toBoolean( $atts['show_dates'] );
			$convert->toBoolean( $atts['show_links'] );

			$convert->toBoolean( $atts['link'] );

			// If displaying a signle entry, no need to display category select, search and pagination.
			if ( get_query_var( 'cn-entry-slug' ) ) {
				$atts['enable_search']          = FALSE;
				$atts['enable_pagination']      = FALSE;
				$atts['enable_category_select'] = FALSE;
			}

			// Lets disable these because they'll break the table layout.
			$atts['show_alphaindex']       = FALSE;
			$atts['repeat_alphaindex']     = FALSE;
			$atts['show_alphahead']        = FALSE;

			add_filter( 'cn_phone_number' , array( __CLASS__, 'phoneLabels') );
			add_filter( 'cn_email_address' , array( __CLASS__, 'emailLabels') );
			add_filter( 'cn_address' , array( __CLASS__, 'addressLabels') );

			// Start the form.
			add_action( 'cn_action_list_before-' . self::$template->getSlug() , array( __CLASS__, 'formOpen'), -1 );

			// If search is enabled, add the appropiate filters.
			if ( $atts['enable_search'] ) {
				add_filter( 'cn_list_retrieve_atts-' . self::$template->getSlug() , array( __CLASS__, 'limitList'), 10 );
				add_action( 'cn_action_list_before-' . self::$template->getSlug() , array( __CLASS__, 'searchForm') , 1 );
			}

			// If pagination is enabled add the appropiate filters.
			if ( $atts['enable_pagination'] ) {
				add_filter( 'cn_list_retrieve_atts-' . self::$template->getSlug() , array( __CLASS__, 'limitList'), 10 );
				add_action( 'cn_action_list_' . $atts['pagination_position'] . '-' . self::$template->getSlug() , array( __CLASS__, 'listPages') );
			}

			// If the category select/filter feature is enabled, add the appropiate filters.
			if ( $atts['enable_category_select'] ) {
				add_filter( 'cn_list_retrieve_atts-' . self::$template->getSlug() , array( __CLASS__, 'setCategory') );
				add_action( 'cn_action_list_' . $atts['category_select_position'] . '-' . self::$template->getSlug() , array( __CLASS__, 'categorySelect') , 5 );
			}

			// Close the form
			add_action( 'cn_action_list_after-' . self::$template->getSlug() , array( __CLASS__, 'formClose'), 11 );

			// Store a copy of the shortcode $atts to be used in other class methods.
			self::$atts = $atts;

			return $atts;
		}

		/**
		 * Alter the Address Labels.
		 *
		 * @access private
		 * @since 3.0
		 * @param (object) $data
		 * @return (object)
		 */
		public static function addressLabels( $data ) {

			switch ( $data->type ) {
				case 'home':
					$data->name = self::$atts['str_home_addr'];
					break;
				case 'work':
					$data->name = self::$atts['str_work_addr'];
					break;
				case 'school':
					$data->name = self::$atts['str_school_addr'];
					break;
				case 'other':
					$data->name = self::$atts['str_other_addr'];
					break;
			}

			return $data;
		}

		/**
		 * Alter the Phone Labels.
		 *
		 * @access private
		 * @since 3.0
		 * @param (object) $data
		 * @return (object)
		 */
		public static function phoneLabels( $data ) {

			switch ( $data->type ) {
				case 'homephone':
					$data->name = self::$atts['str_home_phone'];
					break;
				case 'homefax':
					$data->name = self::$atts['str_home_fax'];
					break;
				case 'cellphone':
					$data->name = self::$atts['str_cell_phone'];
					break;
				case 'workphone':
					$data->name = self::$atts['str_work_phone'];
					break;
				case 'workfax':
					$data->name = self::$atts['str_work_fax'];
					break;
			}

			return $data;
		}

		/**
		 * Alter the Email Labels.
		 *
		 * @access private
		 * @since 3.0
		 * @param (object) $data
		 * @return (object)
		 */
		public static function emailLabels( $data ) {

			switch ( $data->type ) {
				case 'personal':
					$data->name = self::$atts['str_personal_email'];
					break;
				case 'work':
					$data->name = self::$atts['str_work_email'];
					break;

				default:
					$data->name = 'Email';
				break;
			}

			return $data;
		}

		/**
		 * Limit the returned results.
		 *
		 * @access private
		 * @since 3.0
		 * @param (array) $atts The shortcode $atts array.
		 * @return (array)
		 */
		public static function limitList( $atts ) {

			// $atts['limit'] = $this->pageLimit; // Page Limit
			$atts['limit'] = empty( $atts['limit'] ) ? $atts['page_limit'] : $atts['limit'];

			return $atts;
		}

		/**
		 * Echo the form beginning.
		 *
		 * @access private
		 * @since 3.0
		 * @return (void)
		 */
		public static function formOpen() {
		    global $post, $wp_rewrite;

			$permalink = get_permalink();

			if ( $wp_rewrite->using_permalinks() ) {

				echo '<form class="cn-form" action="" method="get">';
				if ( is_front_page() ) echo '<input type="hidden" name="page_id" value="' . $post->ID .'">';

			} else {

				echo '<form class="cn-form" method="get">';
				echo '<input type="hidden" name="' . ( is_page() ? 'page_id' : 'p' ) . '" value="' . $post->ID .'">';
			}

			echo '<table>';

			echo '<tr>';
				echo '<th>Name, Title</th><th>Department</th>';
			echo '</tr>';
		}

		/**
		 * Echo the form ending.
		 *
		 * @access private
		 * @since 3.0
		 * @return (void)
		 */
		public static function formClose() {
			echo '</table>';
			echo '</form>';
		}

		/**
		 * Output the search input fields.
		 *
		 * @access private
		 * @since 3.0
		 * @return (void)
		 */
		public static function searchForm() {

			cnTemplatePart::search();
		}

		/**
		 * Output the pagination control.
		 *
		 * @access private
		 * @since 3.0
		 * @return (void)
		 */
		public static function listPages() {

			cnTemplatePart::pagination( array( 'limit' => self::$atts['page_limit'] ) );

		}

		/**
		 * Outputs the category select list.
		 *
		 * @access private
		 * @since 3.0
		 * @return (void)
		 */
		public static function categorySelect() {

			$atts = array(
				'default'    => self::$atts['str_select'],
				'select_all' => self::$atts['str_select_all'],
				'type'       => self::$atts['enable_category_multi_select'] ? 'multiselect' : 'select',
				'group'      => self::$atts['enable_category_group_by_parent'],
				'show_count' => self::$atts['show_category_count'],
				'show_empty' => self::$atts['show_empty_categories'],
				'parent_id'  => self::$atts['enable_category_by_root_parent'] ? self::$atts['category'] : array(),
				);

			cnTemplatePart::category( $atts );
		}

		/**
		 * Alters the shortcode attribute values before the query is processed.
		 *
		 * @access private
		 * @since 3.0
		 * @param  (array)  $atts The shortcode $atts array.
		 * @return (array)
		 */
		public function setCategory( $atts ) {

			if ( $atts['enable_category_multi_select'] ) {

				if ( get_query_var('cn-cat') ) $atts['category_in'] = get_query_var('cn-cat');

			} else {

				if ( get_query_var('cn-cat') ) $atts['category'] = get_query_var('cn-cat');
			}

			return $atts;
		}

		public function excerptLength( $length ) {
			return absint( self::$atts['excerpt_length'] );
		}

	}

	/**
	 * Start up the template class.
	 *
	 * @access public
	 * @since 3.0
	 * @return mixed (object)|(bool)
	 */
	function Connections_Lines_Alpha() {

		if ( class_exists('connectionsLoad') ) {

			new CN_LinesAlpha();

		} else {

			add_action(
				'admin_notices',
				 create_function(
				 	'',
					'echo \'<div id="message" class="error"><p><strong>ERROR:</strong> Connections must be installed and active in order use Connections Lines Alpha.</p></div>\';'
					)
			);

			return FALSE;
		}
	}

	/**
	 * Start the template.
	 *
	 * Since Connections loads at default priority 10, and this template is dependent on Connections,
	 * we'll load with priority 11 so we know Connections will be loaded and ready first.
	 */
	add_action( 'plugins_loaded', array( 'CNT_LinesAlpha', 'register' ), 11 );
}
