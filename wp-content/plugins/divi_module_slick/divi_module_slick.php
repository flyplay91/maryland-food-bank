<?php

/*
 * Plugin Name: ET Slick Carousel Module
 * Plugin URI:  http://www.sean-barton.co.uk
 * Description: A plugin to add a Slick Slider module to the Divi Builder. Based on Slick from http://kenwheeler.github.io/slick/
 * Author:      Sean Barton - Tortoise IT
 * Version:     2.3
 * Author URI:  http://www.sean-barton.co.uk
 *
 * Changelog:
 * < V1.7
 * - First release, bug fixes etc
 * 
 * V1.7
 * - Added EDD Featured slider module
 *
 * V1.8
 * - Fixed bug with open in new window functionality
 * 
 * V1.9
 * - Fixed responsive text size/line height issues
 * - Added more configuration options in advanced design settings across all modules
 *
 * V2.0
 * - Added Loop Archive Module for infinite flexibility
 *
 * V2.1 - 30/1/17
 * - Added title, content and image modules for use with the post carousel
 * - Added licensing and auto updates
 * 
 * V2.2 - 11/5/17
 * - Added setting to title and featured image modules to remove the link when shown on an archive
 *
 * V2.3 - 16/5/17
 * - Fixed missing Div!
 *
 */
 
		require_once('includes/emp-licensing.php');
		
		define('SB_ET_SLICK_VERSION', '2.3');
		
    add_action('plugins_loaded', 'sb_mod_slick_init');
		
    function sb_mod_slick_init() {
        add_action('init', 'sb_mod_slick_theme_setup', 9999);
        add_action('admin_head', 'sb_mod_slick_admin_head', 9999); //for development only
				add_action('admin_menu', 'sb_mod_slick_submenu');
	
				wp_enqueue_style('sb_mod_slick_css', plugins_url( '/slick.css', __FILE__ ));
				wp_enqueue_style('sb_mod_slick_custom_css', plugins_url( '/style.css', __FILE__ ));
				
				wp_enqueue_script('jquery');
				wp_enqueue_script('sb_mod_slick_js', plugins_url( '/slick.min.js', __FILE__ ));
				wp_enqueue_script('sb_mod_slick_custom_js', plugins_url( '/script.js', __FILE__ ));
	
    }
		
		function sb_mod_slick_submenu() {
        add_submenu_page(
            'plugins.php',
            'Slick Slider/Carousel',
            'Slick Slider/Carousel',
            'manage_options',
            'sb_mod_slick',
            'sb_mod_slick_submenu_cb' );
    }
    
    function sb_mod_slick_box_start($title) {
        return '<div class="postbox">
                    <h2 class="hndle">' . $title . '</h2>
                    <div class="inside">';
    }
    
    function sb_mod_slick_box_end() {
        return '    </div>
                </div>';
    }
     
    function sb_mod_slick_submenu_cb() {
        
        echo '<div class="wrap"><div id="icon-tools" class="icon32"></div>';
        echo '<h2>Slick Slider/Carousel Module</h2>';
                
        echo '<div id="poststuff">';
        
        echo '<div id="post-body" class="metabox-holder columns-2">';
        
        echo '<form method="POST">';
        
        sb_et_slick_license_page();
        
        echo '</form>';
        
        echo '</div>';
        echo '</div>';
        
        echo '</div>';
    }		
    
    function sb_mod_slick_admin_head() {
	
	if (stripos($_SERVER['PHP_SELF'], 'wp-admin/index.php') !== false || isset($_GET['post_type']) && $_GET['post_type'] == 'acf-field-group') {
	    $prop_to_remove = array(
		'et_pb_templates_et_pb_slick'
		, 'et_pb_templates_et_pb_slick_woo_gallery'
		, 'et_pb_templates_et_pb_slick_slide'
		, 'et_pb_templates_et_pb_slick_edd_featured'
	    );
	    
	    $js_prop_to_remove = 'var sb_sc_remove = ["' . implode('","', $prop_to_remove) . '"];';
    
	    echo '<script>
	    
	    ' . $js_prop_to_remove . '
	    
	    for (var prop in localStorage) {
		if (sb_sc_remove.indexOf(prop) != -1) {
		    //console.log("found "+prop);
		    console.log(localStorage.removeItem(prop));
		}
	    }
	    
	    </script>';
	}
    }
    
    function sb_mod_slick_theme_setup() {
    
        if ( class_exists('ET_Builder_Module')) {
						
class et_pb_slick_loop_archive extends ET_Builder_Module {
	function init() {
		$this->name = esc_html__( 'SB Slick Loop Archive', 'et_builder' );
		$this->slug = 'et_pb_slick_loop_archive';

		$this->whitelisted_fields = array(
				'loop_layout'
				, 'post_type'
				, 'posts_number'
				, 'offset_number'
				, 'include_tax'
				, 'include_tax_terms'
				, 'arrows'
				,'arrow_colour'
				, 'dots'
				, 'dot_colour'
				, 'slides_to_show'
				, 'slides_to_scroll'
				, 'autoplay'
				, 'autoplay_speed'
				, 'pause_on_hover'
				, 'adaptive_height'
				, 'center_mode'
				, 'speed'
				, 'rows'
				, 'slides_per_row'
				, 'vertical'
				, 'fade'
				, 'draggable'
				, 'admin_label'
				, 'module_id'
				, 'module_class'
		);

		$this->fields_defaults = array(
			'posts_number'      => array( 10, 'add_default_setting' ),
			'offset_number'     => array( 0, 'only_default_setting' ),
		);

		$this->main_css_element = '%%order_class%% .et_pb_post .et_pb_post_type';
		
		$this->advanced_options = array(
						'fonts' => array(
										'text'   => array(
																		'label'    => esc_html__( 'Text', 'et_builder' ),
																		'css'      => array(
																						'main' => "{$this->main_css_element} p",
																		),
																		'font_size' => array('default' => '14px'),
																		'line_height'    => array('default' => '1.5em'),
										),
										'headings'   => array(
																		'label'    => esc_html__( 'Headings', 'et_builder' ),
																		'css'      => array(
																						'main' => "{$this->main_css_element} h1, {$this->main_css_element} h2, {$this->main_css_element} h3, {$this->main_css_element} h4",
																		),
																		'font_size' => array('default' => '30px'),
																		'line_height'    => array('default' => '1.5em'),
										),
						),
						'background' => array(
										'settings' => array(
														'color' => 'alpha',
										),
						),
						'border' => array(),
						'custom_margin_padding' => array(
										'css' => array(
														'important' => 'all',
										),
						),
		);
	}

	function get_fields() {
		$options = array();
		
		$layouts = get_posts(array('post_type'=>'et_pb_layout', 'posts_per_page'=>-1));
		foreach ($layouts as $layout) {
			$options[$layout->ID] = $layout->post_title;
		}
		
		$args = array(
			'public'   => true
		);
		$output = 'objects'; // names or objects
		$pt_options = array();
		
		$post_types = get_post_types( $args, $output );
		
		foreach ( $post_types as $post_type=>$post_type_obj ) {
			$pt_options[$post_type] = $post_type_obj->labels->name;
		}
		
			    
		$fields = array(
			'loop_layout' => array(
				'label'             => esc_html__( 'Loop Layout', 'et_builder' ),
				'type'              => 'select',
				'option_category'   => 'layout',
				'options'           => $options,
				'description'        => esc_html__( 'Choose a layout to use for each post in this archive loop', 'et_builder' ),
			),
			'post_type' => array(
				'label'             => esc_html__( 'Post Type', 'et_builder' ),
				'type'              => 'select',
				'options'           => $pt_options,
				'description'        => esc_html__( 'Choose a post type to show', 'et_builder' ),
			),
			'posts_number' => array(
				'label'             => esc_html__( 'Posts Number', 'et_builder' ),
				'type'              => 'text',
				'description'       => esc_html__( 'Choose how many posts you would like to display per page.', 'et_builder' ),
			),
			'offset_number' => array(
				'label'           => esc_html__( 'Offset Number', 'et_builder' ),
				'type'            => 'text',
				'description'     => esc_html__( 'Choose how many posts you would like to offset by', 'et_builder' ),
			),
			'include_tax' => array(
				'label'           => esc_html__( 'Include Taxonomy Only', 'et_builder' ),
				'type'            => 'text',
				'description'     => esc_html__( 'This will filter the query by this taxonomy slug (advanced users only).', 'et_builder' ),
			),
			'include_tax_terms' => array(
				'label'           => esc_html__( 'Include Taxonomy Terms', 'et_builder' ),
				'type'            => 'text',
				'description'     => esc_html__( 'This will filter the query by the above taxonomy and these comma separated term slugs (advanced users only).', 'et_builder' ),
			),
			'arrows' => array(
						'label'         => esc_html__( 'Arrows?', 'et_builder' ),
						'type'          => 'yes_no_button',
						'options'       => array(
								'on'  => esc_html__( 'Yes', 'et_builder' ),
								'off' => esc_html__( 'No', 'et_builder' ),
						),
						'option_category' => 'configuration',
						'affects' => array(
							'#et_pb_arrow_colour',
						),
						'description'   => esc_html__( 'Prev/Next Arrows', 'et_builder' ),
					),
					'arrow_colour' => array(
						'label'             => esc_html__( 'Arrow Colour', 'et_builder' ),
						'type'              => 'color-alpha',
						'custom_color'      => true,
						'option_category' => 'configuration',
						'depends_show_if'   => 'on',
						'description'       => esc_html__( 'Here you can define a custom background colour for the arrows. Default: white', 'et_builder' ),
					),
					'dots' => array(
						'label'         => esc_html__( 'Dots?', 'et_builder' ),
						'type'          => 'yes_no_button',
						'option_category' => 'configuration',
						'options'       => array(
								'on'  => esc_html__( 'Yes', 'et_builder' ),
								'off' => esc_html__( 'No', 'et_builder' ),
						),
						'affects' => array(
							'#et_pb_dot_colour',
						),
						'description'   => esc_html__( 'Show dot indicators', 'et_builder' ),
					),
					'dot_colour' => array(
						'label'             => esc_html__( 'Dot Colour', 'et_builder' ),
						'type'              => 'color-alpha',
						'option_category' => 'configuration',
						'custom_color'      => true,
						'depends_show_if'   => 'on',
						'description'       => esc_html__( 'Here you can define a custom background colour for the dots. Default: black', 'et_builder' ),
					),
					'center_mode' => array(
						'label'         => esc_html__( 'Center Mode?', 'et_builder' ),
						'type'          => 'yes_no_button',
						'option_category' => 'configuration',
						'options'       => array(
								'off' => esc_html__( 'No', 'et_builder' ),
								'on'  => esc_html__( 'Yes', 'et_builder' ),
						),
						'affects' => array(
							'#et_pb_center_padding',
						),
						'description'   => esc_html__( 'Enables centered view with partial prev/next slides. Use with odd numbered slidesToShow counts.', 'et_builder' ),
					),
					'autoplay' => array(
						'label'         => esc_html__( 'Autoplay?', 'et_builder' ),
						'type'          => 'yes_no_button',
						'option_category' => 'configuration',
						'options'       => array(
								'on'  => esc_html__( 'Yes', 'et_builder' ),
								'off' => esc_html__( 'No', 'et_builder' ),
						),
						'affects' => array(
							'#et_pb_autoplay_speed',
							'#et_pb_pause_on_hover',
						),
						'description'   => esc_html__( 'Enables Autoplay', 'et_builder' ),
					),
					'autoplay_speed' => array(
						'label'       => esc_html__( 'Autoplay Speed', 'et_builder' ),
						'type'        => 'text',
						'option_category' => 'configuration',
						'depends_show_if'   => 'on',
						'description' => esc_html__( 'Autoplay Speed in milliseconds: EG: 3000 is 3 seconds', 'et_builder' ),
					),
					'pause_on_hover' => array(
						'label'         => esc_html__( 'Pause on Hover?', 'et_builder' ),
						'type'          => 'yes_no_button',
						'option_category' => 'configuration',
						'depends_show_if'   => 'on',
						'options'       => array(
								'on'  => esc_html__( 'Yes', 'et_builder' ),
								'off' => esc_html__( 'No', 'et_builder' ),
						),
						'description'   => esc_html__( 'Pause Autoplay On Hover', 'et_builder' ),
					),
					'slides_to_show' => array(
						'label'       => esc_html__( 'Slides to Show', 'et_builder' ),
						'type'        => 'text',
						'option_category' => 'configuration',
						'description' => esc_html__( '# of slides to show. Default: 1', 'et_builder' ),
					),
					'slides_to_scroll' => array(
						'label'       => esc_html__( 'Slides to Scroll', 'et_builder' ),
						'type'        => 'text',
						'option_category' => 'configuration',
						'description' => esc_html__( '# of slides to scroll. Default: 1', 'et_builder' ),
					),
					'speed' => array(
						'label'       => esc_html__( 'Speed', 'et_builder' ),
						'type'        => 'text',
						'option_category' => 'configuration',
						'description' => esc_html__( 'Slide/Fade animation speed. Default: 300', 'et_builder' ),
					),
					'rows' => array(
						'label'       => esc_html__( 'Rows', 'et_builder' ),
						'type'        => 'text',
						'option_category' => 'configuration',
						'description' => esc_html__( 'Setting this to more than 1 initializes grid mode. Use "Slides Per Row" to set how many slides should be in each row.', 'et_builder' ),
					),
					'slides_per_row' => array(
						'label'       => esc_html__( 'Slides per Row', 'et_builder' ),
						'type'        => 'text',
						'option_category' => 'configuration',
						'description' => esc_html__( 'With grid mode intialized via the rows option, this sets how many slides are in each grid row.', 'et_builder' ),
					),
					'adaptive_height' => array(
						'label'         => esc_html__( 'Adaptive Height?', 'et_builder' ),
						'type'          => 'yes_no_button',
						'option_category' => 'configuration',
						'options'       => array(
								'off' => esc_html__( 'No', 'et_builder' ),
								'on'  => esc_html__( 'Yes', 'et_builder' ),
						),
						'description'   => esc_html__( 'Enables adaptive height for single slide horizontal carousels.', 'et_builder' ),
					),
					'vertical' => array(
						'label'       => esc_html__( 'Vertical', 'et_builder' ),
						'type'          => 'yes_no_button',
						'option_category' => 'configuration',
						'options'       => array(
								'off' => esc_html__( 'No', 'et_builder' ),
								'on'  => esc_html__( 'Yes', 'et_builder' ),
						),
						'description' => esc_html__( 'Vertical slide mode. Doesn\'t work with multiple slides at a time', 'et_builder' ),
					),
					'fade' => array(
						'label'         => esc_html__( 'Fade?', 'et_builder' ),
						'type'          => 'yes_no_button',
						'option_category' => 'configuration',
						'options'       => array(
								'off' => esc_html__( 'No', 'et_builder' ),
								'on'  => esc_html__( 'Yes', 'et_builder' ),
						),
						'description'   => esc_html__( 'Enable fade. Only works with single slides', 'et_builder' ),
					),
				'admin_label' => array(
					'label'       => esc_html__( 'Admin Label', 'et_builder' ),
					'type'        => 'text',
					'description' => esc_html__( 'This will change the label of the module in the builder for easy identification.', 'et_builder' ),
				),
				'module_id' => array(
					'label'           => esc_html__( 'CSS ID', 'et_builder' ),
					'type'            => 'text',
					'option_category' => 'configuration',
					'tab_slug'        => 'custom_css',
					'option_class'    => 'et_pb_custom_css_regular',
				),
				'module_class' => array(
					'label'           => esc_html__( 'CSS Class', 'et_builder' ),
					'type'            => 'text',
					'option_category' => 'configuration',
					'tab_slug'        => 'custom_css',
					'option_class'    => 'et_pb_custom_css_regular',
				),
		);
		return $fields;
	}

	function shortcode_callback( $atts, $content = null, $function_name ) {
		
		$output = '';
		$rand = mt_rand(1111,9999);
		
		$loop_layout           = $this->shortcode_atts['loop_layout'];
		$module_id           = $this->shortcode_atts['module_id'];
		$module_class        = $this->shortcode_atts['module_class'];
		$posts_number        = $this->shortcode_atts['posts_number'];
		$post_type        = $this->shortcode_atts['post_type'];
		$offset_number       = $this->shortcode_atts['offset_number'];
		$include_tax         = $this->shortcode_atts['include_tax'];
		$include_tax_terms      = $this->shortcode_atts['include_tax_terms'];
		
		$autoplay = sb_mod_slick_option_translate($this->shortcode_atts['autoplay']);
		$autoplaySpeed = (int)$this->shortcode_atts['autoplay_speed'];
		$arrows = sb_mod_slick_option_translate($this->shortcode_atts['arrows']);
		$arrow_colour = $this->shortcode_atts['arrow_colour'];
		$dot_colour = $this->shortcode_atts['dot_colour'];
		$centerMode = sb_mod_slick_option_translate($this->shortcode_atts['center_mode']);
		$centerPadding = $this->shortcode_atts['center_padding'];
		$dots = sb_mod_slick_option_translate($this->shortcode_atts['dots']);
		$draggable = sb_mod_slick_option_translate($this->shortcode_atts['draggable']);
		$fade = sb_mod_slick_option_translate($this->shortcode_atts['fade']);
		$lazyLoad = $this->shortcode_atts['lazy_load'];
		$pauseOnHover = sb_mod_slick_option_translate($this->shortcode_atts['pause_on_hover']);
		$rows = (int)$this->shortcode_atts['rows'];
		$slidesPerRow = (int)$this->shortcode_atts['slides_per_row'];
		$slidesToShow = (int)$this->shortcode_atts['slides_to_show'];
		$slidesToScroll = (int)$this->shortcode_atts['slides_to_scroll'];
		$speed = (int)$this->shortcode_atts['speed'];
		
		//echo '<pre>';
		//print_r($this->shortcode_atts);
		//echo '</pre>';

		global $paged;

		$module_class = ET_Builder_Element::add_module_order_class( $module_class, $function_name );

		// remove all filters from WP audio shortcode to make sure current theme doesn't add any elements into audio module
		remove_all_filters( 'wp_audio_shortcode_library' );
		remove_all_filters( 'wp_audio_shortcode' );
		remove_all_filters( 'wp_audio_shortcode_class');

		$args = array( 'posts_per_page' => (int) $posts_number );

		$et_paged = is_front_page() ? get_query_var( 'page' ) : get_query_var( 'paged' );

		if ( is_front_page() ) {
			$paged = $et_paged;
		}

		$args['post_type'] = $post_type;

		if ( ! is_search() ) {
			$args['paged'] = $et_paged;
		}

		if ( '' !== $offset_number && ! empty( $offset_number ) ) {
			/**
			 * Offset + pagination don't play well. Manual offset calculation required
			 * @see: https://codex.wordpress.org/Making_Custom_Queries_using_Offset_and_Pagination
			 */
			if ( $paged > 1 ) {
				$args['offset'] = ( ( $et_paged - 1 ) * intval( $posts_number ) ) + intval( $offset_number );
			} else {
				$args['offset'] = intval( $offset_number );
			}
		}
		
		if ($include_tax && $include_tax_terms) {
			if (strpos($include_tax, '|') !== false) {
				$include_tax = explode('|', $include_tax);
				$include_tax_terms = explode('|', $include_tax_terms);
				
				$args['tax_query'] = array();
				
				for ($i = 0; $i < count($include_tax); $i++) {
					$args['tax_query'][] = array(
							'taxonomy' => $include_tax[$i],
							'field'    => 'slug',
							'terms'    => explode(',', $include_tax_terms[$i]),
					);
				}
			} else {
				$args['tax_query'] = array(
					array(
							'taxonomy' => $include_tax,
							'field'    => 'slug',
							'terms'    => explode(',', $include_tax_terms),
					)
				);
			}
		}

		if ( is_single() && ! isset( $args['post__not_in'] ) ) {
			$args['post__not_in'] = array( get_the_ID() );
		}

		$args = apply_filters('sb_et_divi_pt_loop_archive_module_args', $args);

		query_posts( $args );
		
		if ( have_posts() ) {
			$shortcodes = '';
			
			$i = 0;
			
				//////////////////////////////////////////////////////////////////////
				
				if (!$rows) {
					    $rows = 1;
					}
					if (!$slidesPerRow) {
					    $slidesPerRow = 1;
					}
					if (!$slidesToShow) {
					    $slidesToShow = 1;
					}
					if (!$slidesToScroll) {
					    $slidesToScroll = 1;
					}
					
					if ( '' !== $arrow_colour ) {
						ET_Builder_Element::set_style( $function_name, array(
							'selector'    => '%%order_class%% .slick-arrow:before',
							'declaration' => sprintf(
								'color: %1$s;',
								esc_html( $arrow_colour )
							),
						) );
					}
					if ( '' !== $dot_colour ) {
						ET_Builder_Element::set_style( $function_name, array(
							'selector'    => '%%order_class%% .slick-dots li button:before',
							'declaration' => sprintf(
								'color: %1$s;',
								esc_html( $dot_colour )
							),
						) );
					}
					
					$slick = array(
					    'arrows'=>$arrows
					    , 'dots'=>$dots
					);
					
					if ($centerMode) {
					    $slick['centerMode'] = $centerMode;
					}
					
					if ($speed) {
					    $slick['speed'] = $speed;
					}
					
					if ($rows > 1) {
					    $slick['rows'] = $rows;
					    
					    if ($slidesPerRow) {
						$slick['slidesPerRow'] = $slidesPerRow;
					    }
					    
					}
					
					if ($slidesToScroll) {
					    $slick['slidesToScroll'] = $slidesToScroll;
					}
					
					if ($slidesToShow) {
					    $slick['slidesToShow'] = $slidesToShow;
					}
					
					if ($fade) {
					    $slick['fade'] = $fade;
					}
					
					if ($vertical) {
					    $slick['vertical'] = $vertical;
					}
					
					if ($pauseOnHover) {
					    $slick['pauseOnHover'] = $pauseOnHover;
					}
					
					if ($adaptiveHeight) {
					    $slick['adaptiveHeight'] = $adaptiveHeight;
					}
					
					//if ($variableWidth) {
					    //$slick['variableWidth'] = $variableWidth;
					//}
					
					if ($autoplay) {
					    $slick['autoplay'] = $autoplay;
					}
					
					if ($autoplay && $autoplaySpeed) {
					    $slick['autoplaySpeed'] = $autoplaySpeed;
					}
					
					if ($centerPadding) {
					    $slick['centerPadding'] = $centerPadding;
					}
					
					$responsive = array();
					
					if ($slidesToShow > 3) {
					    $bp2 = array(
						'breakpoint'=>782
						, 'settings'=>array(
						    'slidesToShow'=>3
						)
					    );
					    
					    $responsive[] = $bp2;
					}
					
					$bp1 = array(
					    'breakpoint'=>471
					    , 'settings'=>array(
						'slidesToShow'=>1
						,'slidesToScroll'=>1
					    )
					);
					
					$responsive[] = $bp1;
					
					$slick['responsive'] = $responsive;
					
					$slick = json_encode(apply_filters('sb_divi_module_slick_js_init', $slick, get_the_ID()));
					
					$output = ' <div class="sb-slick-carousel sb-slick-carousel-' . $rand . ' ' . $module_class . '">';
							
				//////////////////////////////////////////////////////////////////////
				
				while ( have_posts() ) {
						the_post();
						
						$output .= '<div>';
						$output .= apply_filters('sb_et_ept_li_loop_archive_start', '', get_the_ID());
						$output .= do_shortcode('[et_pb_section global_module="' . $loop_layout . '"][/et_pb_section]');
						$output .= apply_filters('sb_et_ept_li_loop_archive_end', '', get_the_ID());
						$output .= '</div>';
						
						$i++;
				} // endwhile
				
				$output .= '</div>';
			
				$output .= '<script>
						    jQuery(document).ready(function(){
							jQuery(\'.sb-slick-carousel-' . $rand . '.sb-slick-carousel\').slick(' . $slick . ');
						    });
						    </script>';
								
			wp_reset_query();
		} else {
			if ( et_is_builder_plugin_active() ) {
				include( ET_BUILDER_PLUGIN_DIR . 'includes/no-results.php' );
			} else {
				get_template_part( 'includes/no-results', 'index' );
			}
		}

		$class = " et_pb_module et_pb_bg_layout_";

		$output = '<div ' . ( '' !== $module_id ? sprintf( ' id="%1$s"', esc_attr( $module_id ) ) : '' ) . ' class="clearfix ' . esc_attr( $class ) . ' ' . ( '' !== $module_class ? sprintf( ' %1$s', esc_attr( $module_class ) ) : '' ) . '">' . $output . '</div>';
		$output = '<div class="et_pb_slick_loop_archive_wrapper">' . $output . '</div>';

		return $output;
	}
}
new et_pb_slick_loop_archive;

			class et_pb_slick extends ET_Builder_Module {
				function init() {
					$this->name            = esc_html__( 'SB Slick Carousel', 'et_builder' );
					$this->slug            = 'et_pb_slick';
					$this->child_slug      = 'et_pb_slick_slide';
					$this->child_item_text = esc_html__( 'Slide', 'et_builder' );
			
					$this->whitelisted_fields = array(
					    'arrows'
					    ,'arrow_colour'
					    , 'dots'
					    , 'dot_colour'
					    , 'slides_to_show'
					    , 'slides_to_scroll'
					    , 'autoplay'
					    , 'autoplay_speed'
					    , 'pause_on_hover'
					    , 'adaptive_height'
					    , 'center_mode'
					    , 'speed'
					    , 'rows'
					    , 'slides_per_row'
					    , 'vertical'
					    , 'fade'
					    , 'draggable'
					);
					
					$this->fields_defaults = array(
					    'slides_to_show' => array( '1', 'add_default_setting' ),
					    'slides_to_scroll' => array( '1', 'add_default_setting' ),
					    'autoplay_speed' => array( '3000', 'add_default_setting' ),
					    'speed' => array( '300', 'add_default_setting' ),
					    'rows' => array( '1', 'add_default_setting' ),
					    'slides_per_row' => array( '1', 'add_default_setting' ),
					);
			
					$this->main_css_element = '%%order_class%%.et_pb_slide';
					$this->advanced_options = array(
                                        'fonts' => array(
                                                'text'   => array(
                                                                'label'    => esc_html__( 'Text', 'et_builder' ),
                                                                'css'      => array(
                                                                        'main' => "{$this->main_css_element} p",
                                                                ),
                                                                'font_size' => array('default' => '14px'),
                                                                'line_height'    => array('default' => '1.5em'),
                                                ),
                                                'headings'   => array(
                                                                'label'    => esc_html__( 'Headings', 'et_builder' ),
                                                                'css'      => array(
                                                                        'main' => "{$this->main_css_element} h1, {$this->main_css_element} h2, {$this->main_css_element} h1 a, {$this->main_css_element} h2 a, {$this->main_css_element} h3, {$this->main_css_element} h4",
                                                                ),
                                                                'font_size' => array('default' => '30px'),
                                                                'line_height'    => array('default' => '1.5em'),
                                                ),
                                        ),
                                        'background' => array(
                                                'settings' => array(
                                                        'color' => 'alpha',
                                                ),
                                        ),
                                        'border' => array(),
                                        'custom_margin_padding' => array(
                                                'css' => array(
                                                        'important' => 'all',
                                                ),
                                        ),
                                );
					$this->custom_css_options = array();
				}
			
				function get_fields() {
					$fields = array(
						'arrows' => array(
							'label'         => esc_html__( 'Arrows?', 'et_builder' ),
							'type'          => 'yes_no_button',
							'options'       => array(
							    'on'  => esc_html__( 'Yes', 'et_builder' ),
							    'off' => esc_html__( 'No', 'et_builder' ),
							),
							'option_category' => 'configuration',
							'affects' => array(
								'#et_pb_arrow_colour',
							),
							'description'   => esc_html__( 'Prev/Next Arrows', 'et_builder' ),
						),
						'arrow_colour' => array(
							'label'             => esc_html__( 'Arrow Colour', 'et_builder' ),
							'type'              => 'color-alpha',
							'custom_color'      => true,
							'option_category' => 'configuration',
							'depends_show_if'   => 'on',
							'description'       => esc_html__( 'Here you can define a custom background colour for the arrows. Default: white', 'et_builder' ),
						),
						'dots' => array(
							'label'         => esc_html__( 'Dots?', 'et_builder' ),
							'type'          => 'yes_no_button',
							'option_category' => 'configuration',
							'options'       => array(
							    'on'  => esc_html__( 'Yes', 'et_builder' ),
							    'off' => esc_html__( 'No', 'et_builder' ),
							),
							'affects' => array(
								'#et_pb_dot_colour',
							),
							'description'   => esc_html__( 'Show dot indicators', 'et_builder' ),
						),
						'dot_colour' => array(
							'label'             => esc_html__( 'Dot Colour', 'et_builder' ),
							'type'              => 'color-alpha',
							'option_category' => 'configuration',
							'custom_color'      => true,
							'depends_show_if'   => 'on',
							'description'       => esc_html__( 'Here you can define a custom background colour for the dots. Default: black', 'et_builder' ),
						),
						/*'draggable' => array(
							'label'         => esc_html__( 'Draggable?', 'et_builder' ),
							'type'          => 'yes_no_button',
							'options'       => array(
							    'on'  => esc_html__( 'Yes', 'et_builder' ),
							    'off' => esc_html__( 'No', 'et_builder' ),
							),
							'description'   => esc_html__( 'Enable mouse dragging', 'et_builder' ),
						),*/
						'center_mode' => array(
							'label'         => esc_html__( 'Center Mode?', 'et_builder' ),
							'type'          => 'yes_no_button',
							'option_category' => 'configuration',
							'options'       => array(
							    'off' => esc_html__( 'No', 'et_builder' ),
							    'on'  => esc_html__( 'Yes', 'et_builder' ),
							),
							'affects' => array(
								'#et_pb_center_padding',
							),
							'description'   => esc_html__( 'Enables centered view with partial prev/next slides. Use with odd numbered slidesToShow counts.', 'et_builder' ),
						),
						/*'center_padding' => array(
							'label'       => esc_html__( 'Center Padding', 'et_builder' ),
							'type'        => 'text',
							'depends_show_if'   => 'on',
							'description' => esc_html__( 'Side padding when in center mode (px or %)', 'et_builder' ),
						),*/
						/*'lazy_load' => array(
							'label'         => esc_html__( 'Lazy Load?', 'et_builder' ),
							'type'          => 'yes_no_button',
							'options'       => array(
							    'on'  => esc_html__( 'Yes', 'et_builder' ),
							    'off' => esc_html__( 'No', 'et_builder' ),
							),
							'description'   => esc_html__( 'Set lazy loading technique. Accepts "ondemand" or "progressive"', 'et_builder' ),
						),*/
						'autoplay' => array(
							'label'         => esc_html__( 'Autoplay?', 'et_builder' ),
							'type'          => 'yes_no_button',
							'option_category' => 'configuration',
							'options'       => array(
							    'on'  => esc_html__( 'Yes', 'et_builder' ),
							    'off' => esc_html__( 'No', 'et_builder' ),
							),
							'affects' => array(
								'#et_pb_autoplay_speed',
								'#et_pb_pause_on_hover',
							),
							'description'   => esc_html__( 'Enables Autoplay', 'et_builder' ),
						),
						'autoplay_speed' => array(
							'label'       => esc_html__( 'Autoplay Speed', 'et_builder' ),
							'type'        => 'text',
							'option_category' => 'configuration',
							'depends_show_if'   => 'on',
							'description' => esc_html__( 'Autoplay Speed in milliseconds: EG: 3000 is 3 seconds', 'et_builder' ),
						),
						'pause_on_hover' => array(
							'label'         => esc_html__( 'Pause on Hover?', 'et_builder' ),
							'type'          => 'yes_no_button',
							'option_category' => 'configuration',
							'depends_show_if'   => 'on',
							'options'       => array(
							    'on'  => esc_html__( 'Yes', 'et_builder' ),
							    'off' => esc_html__( 'No', 'et_builder' ),
							),
							'description'   => esc_html__( 'Pause Autoplay On Hover', 'et_builder' ),
						),
						'slides_to_show' => array(
							'label'       => esc_html__( 'Slides to Show', 'et_builder' ),
							'type'        => 'text',
							'option_category' => 'configuration',
							'description' => esc_html__( '# of slides to show. Default: 1', 'et_builder' ),
						),
						'slides_to_scroll' => array(
							'label'       => esc_html__( 'Slides to Scroll', 'et_builder' ),
							'type'        => 'text',
							'option_category' => 'configuration',
							'description' => esc_html__( '# of slides to scroll. Default: 1', 'et_builder' ),
						),
						'speed' => array(
							'label'       => esc_html__( 'Speed', 'et_builder' ),
							'type'        => 'text',
							'option_category' => 'configuration',
							'description' => esc_html__( 'Slide/Fade animation speed. Default: 300', 'et_builder' ),
						),
						'rows' => array(
							'label'       => esc_html__( 'Rows', 'et_builder' ),
							'type'        => 'text',
							'option_category' => 'configuration',
							'description' => esc_html__( 'Setting this to more than 1 initializes grid mode. Use "Slides Per Row" to set how many slides should be in each row.', 'et_builder' ),
						),
						'slides_per_row' => array(
							'label'       => esc_html__( 'Slides per Row', 'et_builder' ),
							'type'        => 'text',
							'option_category' => 'configuration',
							'description' => esc_html__( 'With grid mode intialized via the rows option, this sets how many slides are in each grid row.', 'et_builder' ),
						),
						/*'variable_width' => array(
							'label'         => esc_html__( 'Variable Width?', 'et_builder' ),
							'type'          => 'yes_no_button',
							'option_category' => 'configuration',
							'options'       => array(
							    'off' => esc_html__( 'No', 'et_builder' ),
							    'on'  => esc_html__( 'Yes', 'et_builder' ),
							),
							'description'   => esc_html__( 'Variable width slides', 'et_builder' ),
						),*/
						'adaptive_height' => array(
							'label'         => esc_html__( 'Adaptive Height?', 'et_builder' ),
							'type'          => 'yes_no_button',
							'option_category' => 'configuration',
							'options'       => array(
							    'off' => esc_html__( 'No', 'et_builder' ),
							    'on'  => esc_html__( 'Yes', 'et_builder' ),
							),
							'description'   => esc_html__( 'Enables adaptive height for single slide horizontal carousels.', 'et_builder' ),
						),
						'vertical' => array(
							'label'       => esc_html__( 'Vertical', 'et_builder' ),
							'type'          => 'yes_no_button',
							'option_category' => 'configuration',
							'options'       => array(
							    'off' => esc_html__( 'No', 'et_builder' ),
							    'on'  => esc_html__( 'Yes', 'et_builder' ),
							),
							'description' => esc_html__( 'Vertical slide mode. Doesn\'t work with multiple slides at a time', 'et_builder' ),
						),
						'fade' => array(
							'label'         => esc_html__( 'Fade?', 'et_builder' ),
							'type'          => 'yes_no_button',
							'option_category' => 'configuration',
							'options'       => array(
							    'off' => esc_html__( 'No', 'et_builder' ),
							    'on'  => esc_html__( 'Yes', 'et_builder' ),
							),
							'description'   => esc_html__( 'Enable fade. Only works with single slides', 'et_builder' ),
						),
					);
					return $fields;
				}
			
				function shortcode_callback( $atts, $content = null, $function_name ) {
					$module_class = @$this->shortcode_atts['module_class'];
					$module_class = ET_Builder_Element::add_module_order_class( $module_class, $function_name );
					$rand = mt_rand(1111,9999);
					
					$adaptiveHeight = sb_mod_slick_option_translate($this->shortcode_atts['adaptive_height']);
					$autoplay = sb_mod_slick_option_translate($this->shortcode_atts['autoplay']);
					$autoplaySpeed = (int)$this->shortcode_atts['autoplay_speed'];
					$arrows = sb_mod_slick_option_translate($this->shortcode_atts['arrows']);
					$arrow_colour = $this->shortcode_atts['arrow_colour'];
					$dot_colour = $this->shortcode_atts['dot_colour'];
					$centerMode = sb_mod_slick_option_translate($this->shortcode_atts['center_mode']);
					$centerPadding = $this->shortcode_atts['center_padding'];
					$dots = sb_mod_slick_option_translate($this->shortcode_atts['dots']);
					$draggable = sb_mod_slick_option_translate($this->shortcode_atts['draggable']);
					$fade = sb_mod_slick_option_translate($this->shortcode_atts['fade']);
					$lazyLoad = $this->shortcode_atts['lazy_load'];
					$pauseOnHover = sb_mod_slick_option_translate($this->shortcode_atts['pause_on_hover']);
					$rows = (int)$this->shortcode_atts['rows'];
					$slidesPerRow = (int)$this->shortcode_atts['slides_per_row'];
					$slidesToShow = (int)$this->shortcode_atts['slides_to_show'];
					$slidesToScroll = (int)$this->shortcode_atts['slides_to_scroll'];
					$speed = (int)$this->shortcode_atts['speed'];
					$vertical = sb_mod_slick_option_translate($this->shortcode_atts['vertical']);
					
					if (!$rows) {
					    $rows = 1;
					}
					if (!$slidesPerRow) {
					    $slidesPerRow = 1;
					}
					if (!$slidesToShow) {
					    $slidesToShow = 1;
					}
					if (!$slidesToScroll) {
					    $slidesToScroll = 1;
					}
					
					if ( '' !== $arrow_colour ) {
						ET_Builder_Element::set_style( $function_name, array(
							'selector'    => '%%order_class%% .slick-arrow:before',
							'declaration' => sprintf(
								'color: %1$s;',
								esc_html( $arrow_colour )
							),
						) );
					}
					if ( '' !== $dot_colour ) {
						ET_Builder_Element::set_style( $function_name, array(
							'selector'    => '%%order_class%% .slick-dots li button:before',
							'declaration' => sprintf(
								'color: %1$s;',
								esc_html( $dot_colour )
							),
						) );
					}
					
					$slick = array(
					    //'autoplay'=>$autoplay
					    'arrows'=>$arrows
					    //, 'centerMode'=>$centerMode
					    , 'dots'=>$dots
					    //, 'draggable'=>$draggable
					    //, 'fade'=>$fade
					    //, 'pauseOnHover'=>$pauseOnHover
					    //, 'rows'=>$rows
					    //, 'slidesPerRow'=>$slidesPerRow
					    //, 'slidesToShow'=>$slidesToShow
					    //, 'variableWidth'=>$variableWidth
					    //, 'vertical'=>$vertical
					);
					
					if ($centerMode) {
					    $slick['centerMode'] = $centerMode;
					}
					
					if ($speed) {
					    $slick['speed'] = $speed;
					}
					
					if ($rows > 1) {
					    $slick['rows'] = $rows;
					    
					    if ($slidesPerRow) {
						$slick['slidesPerRow'] = $slidesPerRow;
					    }
					    
					}
					
					if ($slidesToScroll) {
					    $slick['slidesToScroll'] = $slidesToScroll;
					}
					
					if ($slidesToShow) {
					    $slick['slidesToShow'] = $slidesToShow;
					}
					
					if ($fade) {
					    $slick['fade'] = $fade;
					}
					
					if ($vertical) {
					    $slick['vertical'] = $vertical;
					}
					
					if ($pauseOnHover) {
					    $slick['pauseOnHover'] = $pauseOnHover;
					}
					
					if ($adaptiveHeight) {
					    $slick['adaptiveHeight'] = $adaptiveHeight;
					}
					
					//if ($variableWidth) {
					    //$slick['variableWidth'] = $variableWidth;
					//}
					
					if ($autoplay) {
					    $slick['autoplay'] = $autoplay;
					}
					
					if ($autoplay && $autoplaySpeed) {
					    $slick['autoplaySpeed'] = $autoplaySpeed;
					}
					
					if ($centerPadding) {
					    $slick['centerPadding'] = $centerPadding;
					}
					
					$responsive = array();
					
					if ($slidesToShow > 3) {
					    $bp2 = array(
						'breakpoint'=>782
						, 'settings'=>array(
						    'slidesToShow'=>3
						)
					    );
					    
					    $responsive[] = $bp2;
					}
					
					$bp1 = array(
					    'breakpoint'=>471
					    , 'settings'=>array(
						'slidesToShow'=>1
						,'slidesToScroll'=>1
					    )
					);
					
					$responsive[] = $bp1;
					
					$slick['responsive'] = $responsive;
					
					$slick = json_encode(apply_filters('sb_divi_module_slick_js_init', $slick, get_the_ID()));
					
					$all_tabs_content = $this->shortcode_content;
			
					$output = ' <div class="sb-slick-carousel sb-slick-carousel-' . $rand . ' ' . $module_class . '">
							' . $all_tabs_content . '
						    </div>';
						    
					$output .= '<script>
						    jQuery(document).ready(function(){
							jQuery(\'.sb-slick-carousel-' . $rand . '.sb-slick-carousel\').slick(' . $slick . ');
						    });
						    </script>';
								
					return $output;
				}
			}
			new et_pb_slick;
			
			class et_pb_slick_woo_gallery extends ET_Builder_Module {
				function init() {
					$this->name            = esc_html__( 'SB Slick Carousel (Woo Thumbs)', 'et_builder' );
					$this->slug            = 'et_pb_slick_woo_gallery';
			
					$this->whitelisted_fields = array(
					    'link_replace_class'
					    , 'link_slides'
					    , 'image_size'
					    , 'arrows'
					    ,'arrow_colour'
					    , 'dots'
					    , 'dot_colour'
					    , 'slides_to_show'
					    , 'slides_to_scroll'
					    , 'autoplay'
					    , 'autoplay_speed'
					    , 'pause_on_hover'
					    //, 'center_padding'
					    , 'adaptive_height'
					    //, 'lazy_load'
					    , 'center_mode'
					    //, 'variable_width'
					    , 'speed'
					    , 'rows'
					    , 'slides_per_row'
					    , 'vertical'
					    , 'fade'
					    , 'draggable'
					);
					
					$this->fields_defaults = array(
					    'slides_to_show' => array( '1', 'add_default_setting' ),
					    'slides_to_scroll' => array( '1', 'add_default_setting' ),
					    'autoplay_speed' => array( '3000', 'add_default_setting' ),
					    'speed' => array( '300', 'add_default_setting' ),
					    'rows' => array( '1', 'add_default_setting' ),
					    'slides_per_row' => array( '1', 'add_default_setting' ),
					);
			
					$this->main_css_element = '%%order_class%%.et_pb_slide';
					$this->advanced_options = array(
                                        'fonts' => array(
                                                'text'   => array(
                                                                'label'    => esc_html__( 'Text', 'et_builder' ),
                                                                'css'      => array(
                                                                        'main' => "{$this->main_css_element} p",
                                                                ),
                                                                'font_size' => array('default' => '14px'),
                                                                'line_height'    => array('default' => '1.5em'),
                                                ),
                                                'headings'   => array(
                                                                'label'    => esc_html__( 'Headings', 'et_builder' ),
                                                                'css'      => array(
                                                                        'main' => "{$this->main_css_element} h1, {$this->main_css_element} h2, {$this->main_css_element} h1 a, {$this->main_css_element} h2 a, {$this->main_css_element} h3, {$this->main_css_element} h4",
                                                                ),
                                                                'font_size' => array('default' => '30px'),
                                                                'line_height'    => array('default' => '1.5em'),
                                                ),
                                        ),
                                        'background' => array(
                                                'settings' => array(
                                                        'color' => 'alpha',
                                                ),
                                        ),
                                        'border' => array(),
                                        'custom_margin_padding' => array(
                                                'css' => array(
                                                        'important' => 'all',
                                                ),
                                        ),
                                );
					$this->custom_css_options = array();
				}
			
				function get_fields() {
				    $image_options = array();
				    $sizes = get_intermediate_image_sizes();
				    
				    foreach ($sizes as $size) {
					    $image_options[$size] = $size;
				    }
								
				    $fields = array(
						'image_size' => array(
						    'label'           => __( 'Image Size', 'et_builder' ),
						    'type'            => 'select',
						    'options'         => $image_options,
						    'description'       => __( 'Choose an image size from here. If there is no size you like in the list consider using the free <a href="https://wordpress.org/plugins/simple-image-sizes/" target="_blank">Simple Image Sizes</a> plugin where you can define your own.', 'et_builder' ),
						),
						'link_slides' => array(
							'label'             => esc_html__( 'Link slide images?', 'et_builder' ),
							'type'              => 'yes_no_button',
							'option_category'   => 'configuration',
							'options'           => array(
								'on'  => esc_html__( 'Yes', 'et_builder' ),
								'off' => esc_html__( 'No', 'et_builder' ),
							),
							'affects'           => array(
								'#et_pb_link_replace_class',
							),
							'description'        => esc_html__( 'Should the slide images be linked to their larger versions?', 'et_builder' ),
						),
						'link_replace_class' => array(
							'label'             => esc_html__( 'Link Replacement Classname (see notes below)', 'et_builder' ),
							'type'              => 'text',
							'depends_show_if'   => 'on',
							'description'       => esc_html__( 'Each slide image will be a link if the above setting is enabled. If you enter a class name in this box then any img tags will be replaced, on click, with a larger version of this. Use this to create a slider which, when clicked, will change the product image anywhere else on the page. A really nice visual feature! Leave this box empty for each image to link to it\'s larger version directly.', 'et_builder' ),
						),
						'arrows' => array(
							'label'         => esc_html__( 'Arrows?', 'et_builder' ),
							'type'          => 'yes_no_button',
							'options'       => array(
							    'on'  => esc_html__( 'Yes', 'et_builder' ),
							    'off' => esc_html__( 'No', 'et_builder' ),
							),
							'option_category' => 'configuration',
							'affects' => array(
								'#et_pb_arrow_colour',
							),
							'description'   => esc_html__( 'Prev/Next Arrows', 'et_builder' ),
						),
						'arrow_colour' => array(
							'label'             => esc_html__( 'Arrow Colour', 'et_builder' ),
							'type'              => 'color-alpha',
							'custom_color'      => true,
							'option_category' => 'configuration',
							'depends_show_if'   => 'on',
							'description'       => esc_html__( 'Here you can define a custom background colour for the arrows. Default: white', 'et_builder' ),
						),
						'dots' => array(
							'label'         => esc_html__( 'Dots?', 'et_builder' ),
							'type'          => 'yes_no_button',
							'option_category' => 'configuration',
							'options'       => array(
							    'on'  => esc_html__( 'Yes', 'et_builder' ),
							    'off' => esc_html__( 'No', 'et_builder' ),
							),
							'affects' => array(
								'#et_pb_dot_colour',
							),
							'description'   => esc_html__( 'Show dot indicators', 'et_builder' ),
						),
						'dot_colour' => array(
							'label'             => esc_html__( 'Dot Colour', 'et_builder' ),
							'type'              => 'color-alpha',
							'option_category' => 'configuration',
							'custom_color'      => true,
							'depends_show_if'   => 'on',
							'description'       => esc_html__( 'Here you can define a custom background colour for the dots. Default: black', 'et_builder' ),
						),
						'center_mode' => array(
							'label'         => esc_html__( 'Center Mode?', 'et_builder' ),
							'type'          => 'yes_no_button',
							'option_category' => 'configuration',
							'options'       => array(
							    'off' => esc_html__( 'No', 'et_builder' ),
							    'on'  => esc_html__( 'Yes', 'et_builder' ),
							),
							'affects' => array(
								'#et_pb_center_padding',
							),
							'description'   => esc_html__( 'Enables centered view with partial prev/next slides. Use with odd numbered slidesToShow counts.', 'et_builder' ),
						),
						'autoplay' => array(
							'label'         => esc_html__( 'Autoplay?', 'et_builder' ),
							'type'          => 'yes_no_button',
							'option_category' => 'configuration',
							'options'       => array(
							    'on'  => esc_html__( 'Yes', 'et_builder' ),
							    'off' => esc_html__( 'No', 'et_builder' ),
							),
							'affects' => array(
								'#et_pb_autoplay_speed',
								'#et_pb_pause_on_hover',
							),
							'description'   => esc_html__( 'Enables Autoplay', 'et_builder' ),
						),
						'autoplay_speed' => array(
							'label'       => esc_html__( 'Autoplay Speed', 'et_builder' ),
							'type'        => 'text',
							'option_category' => 'configuration',
							'depends_show_if'   => 'on',
							'description' => esc_html__( 'Autoplay Speed in milliseconds: EG: 3000 is 3 seconds', 'et_builder' ),
						),
						'pause_on_hover' => array(
							'label'         => esc_html__( 'Pause on Hover?', 'et_builder' ),
							'type'          => 'yes_no_button',
							'option_category' => 'configuration',
							'depends_show_if'   => 'on',
							'options'       => array(
							    'on'  => esc_html__( 'Yes', 'et_builder' ),
							    'off' => esc_html__( 'No', 'et_builder' ),
							),
							'description'   => esc_html__( 'Pause Autoplay On Hover', 'et_builder' ),
						),
						'slides_to_show' => array(
							'label'       => esc_html__( 'Slides to Show', 'et_builder' ),
							'type'        => 'text',
							'option_category' => 'configuration',
							'description' => esc_html__( '# of slides to show. Default: 1', 'et_builder' ),
						),
						'slides_to_scroll' => array(
							'label'       => esc_html__( 'Slides to Scroll', 'et_builder' ),
							'type'        => 'text',
							'option_category' => 'configuration',
							'description' => esc_html__( '# of slides to scroll. Default: 1', 'et_builder' ),
						),
						'speed' => array(
							'label'       => esc_html__( 'Speed', 'et_builder' ),
							'type'        => 'text',
							'option_category' => 'configuration',
							'description' => esc_html__( 'Slide/Fade animation speed. Default: 300', 'et_builder' ),
						),
						'rows' => array(
							'label'       => esc_html__( 'Rows', 'et_builder' ),
							'type'        => 'text',
							'option_category' => 'configuration',
							'description' => esc_html__( 'Setting this to more than 1 initializes grid mode. Use "Slides Per Row" to set how many slides should be in each row.', 'et_builder' ),
						),
						'slides_per_row' => array(
							'label'       => esc_html__( 'Slides per Row', 'et_builder' ),
							'type'        => 'text',
							'option_category' => 'configuration',
							'description' => esc_html__( 'With grid mode intialized via the rows option, this sets how many slides are in each grid row.', 'et_builder' ),
						),
						'adaptive_height' => array(
							'label'         => esc_html__( 'Adaptive Height?', 'et_builder' ),
							'type'          => 'yes_no_button',
							'option_category' => 'configuration',
							'options'       => array(
							    'off' => esc_html__( 'No', 'et_builder' ),
							    'on'  => esc_html__( 'Yes', 'et_builder' ),
							),
							'description'   => esc_html__( 'Enables adaptive height for single slide horizontal carousels.', 'et_builder' ),
						),
						'vertical' => array(
							'label'       => esc_html__( 'Vertical', 'et_builder' ),
							'type'          => 'yes_no_button',
							'option_category' => 'configuration',
							'options'       => array(
							    'off' => esc_html__( 'No', 'et_builder' ),
							    'on'  => esc_html__( 'Yes', 'et_builder' ),
							),
							'description' => esc_html__( 'Vertical slide mode. Doesn\'t work with multiple slides at a time', 'et_builder' ),
						),
						'fade' => array(
							'label'         => esc_html__( 'Fade?', 'et_builder' ),
							'type'          => 'yes_no_button',
							'option_category' => 'configuration',
							'options'       => array(
							    'off' => esc_html__( 'No', 'et_builder' ),
							    'on'  => esc_html__( 'Yes', 'et_builder' ),
							),
							'description'   => esc_html__( 'Enable fade. Only works with single slides', 'et_builder' ),
						),
					);
					return $fields;
				}
			
				function shortcode_callback( $atts, $content = null, $function_name ) {
				    
					if (get_post_type() != 'product') {
					    return;
					}
					
					$output = '';
				    
					$module_class = @$this->shortcode_atts['module_class'];
					$module_class = ET_Builder_Element::add_module_order_class( $module_class, $function_name );
					$rand = mt_rand(1111,9999);
					
					$adaptiveHeight = sb_mod_slick_option_translate($this->shortcode_atts['adaptive_height']);
					$autoplay = sb_mod_slick_option_translate($this->shortcode_atts['autoplay']);
					$autoplaySpeed = (int)$this->shortcode_atts['autoplay_speed'];
					$arrows = sb_mod_slick_option_translate($this->shortcode_atts['arrows']);
					$arrow_colour = $this->shortcode_atts['arrow_colour'];
					$dot_colour = $this->shortcode_atts['dot_colour'];
					$centerMode = sb_mod_slick_option_translate($this->shortcode_atts['center_mode']);
					$centerPadding = $this->shortcode_atts['center_padding'];
					$dots = sb_mod_slick_option_translate($this->shortcode_atts['dots']);
					$draggable = sb_mod_slick_option_translate($this->shortcode_atts['draggable']);
					$fade = sb_mod_slick_option_translate($this->shortcode_atts['fade']);
					$lazyLoad = $this->shortcode_atts['lazy_load'];
					$pauseOnHover = sb_mod_slick_option_translate($this->shortcode_atts['pause_on_hover']);
					$rows = (int)$this->shortcode_atts['rows'];
					$slidesPerRow = (int)$this->shortcode_atts['slides_per_row'];
					$slidesToShow = (int)$this->shortcode_atts['slides_to_show'];
					$slidesToScroll = (int)$this->shortcode_atts['slides_to_scroll'];
					$speed = (int)$this->shortcode_atts['speed'];
					//$variableWidth = sb_mod_slick_option_translate($this->shortcode_atts['variable_width']);
					$vertical = sb_mod_slick_option_translate($this->shortcode_atts['vertical']);
					
					if (!$rows) {
					    $rows = 1;
					}
					if (!$slidesPerRow) {
					    $slidesPerRow = 1;
					}
					if (!$slidesToShow) {
					    $slidesToShow = 1;
					}
					if (!$slidesToScroll) {
					    $slidesToScroll = 1;
					}
					
					if ( '' !== $arrow_colour ) {
						ET_Builder_Element::set_style( $function_name, array(
							'selector'    => '%%order_class%% .slick-arrow:before',
							'declaration' => sprintf(
								'color: %1$s;',
								esc_html( $arrow_colour )
							),
						) );
					}
					if ( '' !== $dot_colour ) {
						ET_Builder_Element::set_style( $function_name, array(
							'selector'    => '%%order_class%% .slick-dots li button:before',
							'declaration' => sprintf(
								'color: %1$s;',
								esc_html( $dot_colour )
							),
						) );
					}
					
					$slick = array(
					    //'autoplay'=>$autoplay
					    'arrows'=>$arrows
					    //, 'centerMode'=>$centerMode
					    , 'dots'=>$dots
					    //, 'draggable'=>$draggable
					    //, 'fade'=>$fade
					    //, 'pauseOnHover'=>$pauseOnHover
					    //, 'rows'=>$rows
					    //, 'slidesPerRow'=>$slidesPerRow
					    //, 'slidesToShow'=>$slidesToShow
					    //, 'variableWidth'=>$variableWidth
					    //, 'vertical'=>$vertical
					);
					
					if ($centerMode) {
					    $slick['centerMode'] = $centerMode;
					}
					
					if ($speed) {
					    $slick['speed'] = $speed;
					}
					
					if ($rows > 1) {
					    $slick['rows'] = $rows;
					    
					    if ($slidesPerRow) {
						$slick['slidesPerRow'] = $slidesPerRow;
					    }
					    
					}
					
					if ($slidesToScroll) {
					    $slick['slidesToScroll'] = $slidesToScroll;
					}
					
					if ($slidesToShow) {
					    $slick['slidesToShow'] = $slidesToShow;
					}
					
					if ($fade) {
					    $slick['fade'] = $fade;
					}
					
					if ($vertical) {
					    $slick['vertical'] = $vertical;
					}
					
					if ($pauseOnHover) {
					    $slick['pauseOnHover'] = $pauseOnHover;
					}
					
					if ($adaptiveHeight) {
					    $slick['adaptiveHeight'] = $adaptiveHeight;
					}
					
					//if ($variableWidth) {
					    //$slick['variableWidth'] = $variableWidth;
					//}
					
					if ($autoplay) {
					    $slick['autoplay'] = $autoplay;
					}
					
					if ($autoplay && $autoplaySpeed) {
					    $slick['autoplaySpeed'] = $autoplaySpeed;
					}
					
					if ($centerPadding) {
					    $slick['centerPadding'] = $centerPadding;
					}
					
					$responsive = array();
					
					if ($slidesToShow > 3) {
					    $bp2 = array(
						'breakpoint'=>782
						, 'settings'=>array(
						    'slidesToShow'=>3
						)
					    );
					    
					    $responsive[] = $bp2;
					}
					
					$bp1 = array(
					    'breakpoint'=>471
					    , 'settings'=>array(
						'slidesToShow'=>1
						,'slidesToScroll'=>1
					    )
					);
					
					$responsive[] = $bp1;
					
					$slick['responsive'] = $responsive;
					
					$slick = json_encode(apply_filters('sb_divi_module_slick_js_init', $slick, get_the_ID()));
					
					//woo slides
					$product = wc_get_product(get_the_ID());
					$attachment_ids = $product->get_gallery_attachment_ids();
					$all_tabs_content = '';
					
					if ( $attachment_ids ) { 
							foreach ( $attachment_ids as $attachment_id ) {
								$pre = $post = '';
							    
							    	$all_tabs_content .= '<div class="slide-image">';
								$image_title 	= esc_attr( get_the_title( $attachment_id ) );
								$image_caption 	= esc_attr( get_post_field( 'post_excerpt', $attachment_id ) );
								
								$image = wp_get_attachment_image( $attachment_id, $this->shortcode_atts['image_size'], 0, $attr = array(
									'title'	=> $image_title,
									'alt'	=> $image_title
								) );
								
								if ($this->shortcode_atts['link_slides'] == 'on') {
								    $large_image = wp_get_attachment_image_src( $attachment_id, 'large');
								    $large_image = $large_image[0];
								    $full_image = wp_get_attachment_image_src( $attachment_id, 'full');
								    $full_image = $full_image[0];
								    $post = '</a>';
								    
								    if ($click_class = $this->shortcode_atts['link_replace_class']) {
									$pre = '<a style="cursor:pointer;" onclick="jQuery(\'.' . $click_class . ' img\').attr(\'srcset\', \'\'); jQuery(\'.' . $click_class . ' img\').attr(\'src\', \'' . $large_image . '\'); jQuery(\'.' . $click_class . ' a\').attr(\'href\', \'' . $full_image . '\');">';
								    } else {
									$pre = '<a href="' . $large_image . '" class="prettyphoto colorbox" data-rel="prettyPhoto[product-gallery]">';
								    }
								}
								
					
								$all_tabs_content .= $pre . $image . $post;
								
								$all_tabs_content .= '</div>';
							}

							$output = ' <div class="sb-slick-carousel sb-slick-carousel-' . $rand . ' ' . $module_class . '">
									' . $all_tabs_content . '
								    </div>';
								    
							$output .= '<script>
								    jQuery(document).ready(function(){
									jQuery(\'.sb-slick-carousel-' . $rand . '.sb-slick-carousel\').slick(' . $slick . ');
								    });
								    </script>';
						    
					}
								
					return $output;
				}
			}
			new et_pb_slick_woo_gallery;
			
			class et_pb_slick_edd_featured extends ET_Builder_Module {
				function init() {
					$this->name            = esc_html__( 'SB Slick Carousel (EDD Featured)', 'et_builder' );
					$this->slug            = 'et_pb_slick_edd_featured';
			
					$this->whitelisted_fields = array(
					    'image_size'
					    , 'arrows'
					    ,'arrow_colour'
					    , 'dots'
					    , 'dot_colour'
					    , 'slides_to_show'
					    , 'slides_to_scroll'
					    , 'autoplay'
					    , 'autoplay_speed'
					    , 'pause_on_hover'
					    //, 'center_padding'
					    , 'adaptive_height'
					    //, 'lazy_load'
					    , 'center_mode'
					    //, 'variable_width'
					    , 'speed'
					    , 'rows'
					    , 'slides_per_row'
					    , 'vertical'
					    , 'fade'
					    , 'draggable'
					);
					
					$this->fields_defaults = array(
					    'slides_to_show' => array( '1', 'add_default_setting' ),
					    'slides_to_scroll' => array( '1', 'add_default_setting' ),
					    'autoplay_speed' => array( '3000', 'add_default_setting' ),
					    'speed' => array( '300', 'add_default_setting' ),
					    'rows' => array( '1', 'add_default_setting' ),
					    'slides_per_row' => array( '1', 'add_default_setting' ),
					);
			
					$this->main_css_element = '%%order_class%%.et_pb_slide';
					$this->advanced_options = array(
                                        'fonts' => array(
                                                'text'   => array(
                                                                'label'    => esc_html__( 'Text', 'et_builder' ),
                                                                'css'      => array(
                                                                        'main' => "{$this->main_css_element} p",
                                                                ),
                                                                'font_size' => array('default' => '14px'),
                                                                'line_height'    => array('default' => '1.5em'),
                                                ),
                                                'headings'   => array(
                                                                'label'    => esc_html__( 'Headings', 'et_builder' ),
                                                                'css'      => array(
                                                                        'main' => "{$this->main_css_element} h1, {$this->main_css_element} h2, {$this->main_css_element} h1 a, {$this->main_css_element} h2 a, {$this->main_css_element} h3, {$this->main_css_element} h4",
                                                                ),
                                                                'font_size' => array('default' => '30px'),
                                                                'line_height'    => array('default' => '1.5em'),
                                                ),
                                        ),
                                        'background' => array(
                                                'settings' => array(
                                                        'color' => 'alpha',
                                                ),
                                        ),
                                        'border' => array(),
                                        'custom_margin_padding' => array(
                                                'css' => array(
                                                        'important' => 'all',
                                                ),
                                        ),
                                );
					$this->custom_css_options = array();
				}
			
				function get_fields() {
				    $image_options = array();
				    $sizes = get_intermediate_image_sizes();
				    
				    foreach ($sizes as $size) {
					    $image_options[$size] = $size;
				    }
								
				    $fields = array(
						'image_size' => array(
						    'label'           => __( 'Image Size', 'et_builder' ),
						    'type'            => 'select',
						    'options'         => $image_options,
						    'description'       => __( 'Choose an image size from here. If there is no size you like in the list consider using the free <a href="https://wordpress.org/plugins/simple-image-sizes/" target="_blank">Simple Image Sizes</a> plugin where you can define your own.', 'et_builder' ),
						),
						'arrows' => array(
							'label'         => esc_html__( 'Arrows?', 'et_builder' ),
							'type'          => 'yes_no_button',
							'options'       => array(
							    'on'  => esc_html__( 'Yes', 'et_builder' ),
							    'off' => esc_html__( 'No', 'et_builder' ),
							),
							'option_category' => 'configuration',
							'affects' => array(
								'#et_pb_arrow_colour',
							),
							'description'   => esc_html__( 'Prev/Next Arrows', 'et_builder' ),
						),
						'arrow_colour' => array(
							'label'             => esc_html__( 'Arrow Colour', 'et_builder' ),
							'type'              => 'color-alpha',
							'custom_color'      => true,
							'option_category' => 'configuration',
							'depends_show_if'   => 'on',
							'description'       => esc_html__( 'Here you can define a custom background colour for the arrows. Default: white', 'et_builder' ),
						),
						'dots' => array(
							'label'         => esc_html__( 'Dots?', 'et_builder' ),
							'type'          => 'yes_no_button',
							'option_category' => 'configuration',
							'options'       => array(
							    'on'  => esc_html__( 'Yes', 'et_builder' ),
							    'off' => esc_html__( 'No', 'et_builder' ),
							),
							'affects' => array(
								'#et_pb_dot_colour',
							),
							'description'   => esc_html__( 'Show dot indicators', 'et_builder' ),
						),
						'dot_colour' => array(
							'label'             => esc_html__( 'Dot Colour', 'et_builder' ),
							'type'              => 'color-alpha',
							'option_category' => 'configuration',
							'custom_color'      => true,
							'depends_show_if'   => 'on',
							'description'       => esc_html__( 'Here you can define a custom background colour for the dots. Default: black', 'et_builder' ),
						),
						'center_mode' => array(
							'label'         => esc_html__( 'Center Mode?', 'et_builder' ),
							'type'          => 'yes_no_button',
							'option_category' => 'configuration',
							'options'       => array(
							    'off' => esc_html__( 'No', 'et_builder' ),
							    'on'  => esc_html__( 'Yes', 'et_builder' ),
							),
							'affects' => array(
								'#et_pb_center_padding',
							),
							'description'   => esc_html__( 'Enables centered view with partial prev/next slides. Use with odd numbered slidesToShow counts.', 'et_builder' ),
						),
						'autoplay' => array(
							'label'         => esc_html__( 'Autoplay?', 'et_builder' ),
							'type'          => 'yes_no_button',
							'option_category' => 'configuration',
							'options'       => array(
							    'on'  => esc_html__( 'Yes', 'et_builder' ),
							    'off' => esc_html__( 'No', 'et_builder' ),
							),
							'affects' => array(
								'#et_pb_autoplay_speed',
								'#et_pb_pause_on_hover',
							),
							'description'   => esc_html__( 'Enables Autoplay', 'et_builder' ),
						),
						'autoplay_speed' => array(
							'label'       => esc_html__( 'Autoplay Speed', 'et_builder' ),
							'type'        => 'text',
							'option_category' => 'configuration',
							'depends_show_if'   => 'on',
							'description' => esc_html__( 'Autoplay Speed in milliseconds: EG: 3000 is 3 seconds', 'et_builder' ),
						),
						'pause_on_hover' => array(
							'label'         => esc_html__( 'Pause on Hover?', 'et_builder' ),
							'type'          => 'yes_no_button',
							'option_category' => 'configuration',
							'depends_show_if'   => 'on',
							'options'       => array(
							    'on'  => esc_html__( 'Yes', 'et_builder' ),
							    'off' => esc_html__( 'No', 'et_builder' ),
							),
							'description'   => esc_html__( 'Pause Autoplay On Hover', 'et_builder' ),
						),
						'slides_to_show' => array(
							'label'       => esc_html__( 'Slides to Show', 'et_builder' ),
							'type'        => 'text',
							'option_category' => 'configuration',
							'description' => esc_html__( '# of slides to show. Default: 1', 'et_builder' ),
						),
						'slides_to_scroll' => array(
							'label'       => esc_html__( 'Slides to Scroll', 'et_builder' ),
							'type'        => 'text',
							'option_category' => 'configuration',
							'description' => esc_html__( '# of slides to scroll. Default: 1', 'et_builder' ),
						),
						'speed' => array(
							'label'       => esc_html__( 'Speed', 'et_builder' ),
							'type'        => 'text',
							'option_category' => 'configuration',
							'description' => esc_html__( 'Slide/Fade animation speed. Default: 300', 'et_builder' ),
						),
						'rows' => array(
							'label'       => esc_html__( 'Rows', 'et_builder' ),
							'type'        => 'text',
							'option_category' => 'configuration',
							'description' => esc_html__( 'Setting this to more than 1 initializes grid mode. Use "Slides Per Row" to set how many slides should be in each row.', 'et_builder' ),
						),
						'slides_per_row' => array(
							'label'       => esc_html__( 'Slides per Row', 'et_builder' ),
							'type'        => 'text',
							'option_category' => 'configuration',
							'description' => esc_html__( 'With grid mode intialized via the rows option, this sets how many slides are in each grid row.', 'et_builder' ),
						),
						'adaptive_height' => array(
							'label'         => esc_html__( 'Adaptive Height?', 'et_builder' ),
							'type'          => 'yes_no_button',
							'option_category' => 'configuration',
							'options'       => array(
							    'off' => esc_html__( 'No', 'et_builder' ),
							    'on'  => esc_html__( 'Yes', 'et_builder' ),
							),
							'description'   => esc_html__( 'Enables adaptive height for single slide horizontal carousels.', 'et_builder' ),
						),
						'vertical' => array(
							'label'       => esc_html__( 'Vertical', 'et_builder' ),
							'type'          => 'yes_no_button',
							'option_category' => 'configuration',
							'options'       => array(
							    'off' => esc_html__( 'No', 'et_builder' ),
							    'on'  => esc_html__( 'Yes', 'et_builder' ),
							),
							'description' => esc_html__( 'Vertical slide mode. Doesn\'t work with multiple slides at a time', 'et_builder' ),
						),
						'fade' => array(
							'label'         => esc_html__( 'Fade?', 'et_builder' ),
							'type'          => 'yes_no_button',
							'option_category' => 'configuration',
							'options'       => array(
							    'off' => esc_html__( 'No', 'et_builder' ),
							    'on'  => esc_html__( 'Yes', 'et_builder' ),
							),
							'description'   => esc_html__( 'Enable fade. Only works with single slides', 'et_builder' ),
						),
					);
					return $fields;
				}
			
				function shortcode_callback( $atts, $content = null, $function_name ) {
				    
					$output = '';
				  $centerPadding = '';
					
					$module_class = (isset($this->shortcode_atts['module_class']) ? $this->shortcode_atts['module_class']:'');
					$module_class = ET_Builder_Element::add_module_order_class( $module_class, $function_name );
					$rand = mt_rand(1111,9999);
					
					$adaptiveHeight = sb_mod_slick_option_translate($this->shortcode_atts['adaptive_height']);
					$autoplay = sb_mod_slick_option_translate($this->shortcode_atts['autoplay']);
					$autoplaySpeed = (int)$this->shortcode_atts['autoplay_speed'];
					$arrows = sb_mod_slick_option_translate($this->shortcode_atts['arrows']);
					$arrow_colour = $this->shortcode_atts['arrow_colour'];
					$dot_colour = $this->shortcode_atts['dot_colour'];
					$centerMode = sb_mod_slick_option_translate($this->shortcode_atts['center_mode']);
					//$centerPadding = @$this->shortcode_atts['center_padding'];
					$dots = sb_mod_slick_option_translate($this->shortcode_atts['dots']);
					$draggable = sb_mod_slick_option_translate($this->shortcode_atts['draggable']);
					$fade = sb_mod_slick_option_translate($this->shortcode_atts['fade']);
					//$lazyLoad = @$this->shortcode_atts['lazy_load'];
					$pauseOnHover = sb_mod_slick_option_translate($this->shortcode_atts['pause_on_hover']);
					$rows = (int)$this->shortcode_atts['rows'];
					$slidesPerRow = (int)$this->shortcode_atts['slides_per_row'];
					$slidesToShow = (int)$this->shortcode_atts['slides_to_show'];
					$slidesToScroll = (int)$this->shortcode_atts['slides_to_scroll'];
					$speed = (int)$this->shortcode_atts['speed'];
					//$variableWidth = sb_mod_slick_option_translate($this->shortcode_atts['variable_width']);
					$vertical = sb_mod_slick_option_translate($this->shortcode_atts['vertical']);
					
					if (!$rows) {
					    $rows = 1;
					}
					if (!$slidesPerRow) {
					    $slidesPerRow = 1;
					}
					if (!$slidesToShow) {
					    $slidesToShow = 1;
					}
					if (!$slidesToScroll) {
					    $slidesToScroll = 1;
					}
					
					if ( '' !== $arrow_colour ) {
						ET_Builder_Element::set_style( $function_name, array(
							'selector'    => '%%order_class%% .slick-arrow:before',
							'declaration' => sprintf(
								'color: %1$s;',
								esc_html( $arrow_colour )
							),
						) );
					}
					if ( '' !== $dot_colour ) {
						ET_Builder_Element::set_style( $function_name, array(
							'selector'    => '%%order_class%% .slick-dots li button:before',
							'declaration' => sprintf(
								'color: %1$s;',
								esc_html( $dot_colour )
							),
						) );
					}
					
					$slick = array(
					    //'autoplay'=>$autoplay
					    'arrows'=>$arrows
					    //, 'centerMode'=>$centerMode
					    , 'dots'=>$dots
					    //, 'draggable'=>$draggable
					    //, 'fade'=>$fade
					    //, 'pauseOnHover'=>$pauseOnHover
					    //, 'rows'=>$rows
					    //, 'slidesPerRow'=>$slidesPerRow
					    //, 'slidesToShow'=>$slidesToShow
					    //, 'variableWidth'=>$variableWidth
					    //, 'vertical'=>$vertical
					);
					
					if ($centerMode) {
					    $slick['centerMode'] = $centerMode;
					}
					
					if ($speed) {
					    $slick['speed'] = $speed;
					}
					
					if ($rows > 1) {
					    $slick['rows'] = $rows;
					    
					    if ($slidesPerRow) {
						$slick['slidesPerRow'] = $slidesPerRow;
					    }
					    
					}
					
					if ($slidesToScroll) {
					    $slick['slidesToScroll'] = $slidesToScroll;
					}
					
					if ($slidesToShow) {
					    $slick['slidesToShow'] = $slidesToShow;
					}
					
					if ($fade) {
					    $slick['fade'] = $fade;
					}
					
					if ($vertical) {
					    $slick['vertical'] = $vertical;
					}
					
					if ($pauseOnHover) {
					    $slick['pauseOnHover'] = $pauseOnHover;
					}
					
					if ($adaptiveHeight) {
					    $slick['adaptiveHeight'] = $adaptiveHeight;
					}
					
					//if ($variableWidth) {
					    //$slick['variableWidth'] = $variableWidth;
					//}
					
					if ($autoplay) {
					    $slick['autoplay'] = $autoplay;
					}
					
					if ($autoplay && $autoplaySpeed) {
					    $slick['autoplaySpeed'] = $autoplaySpeed;
					}
					
					if ($centerPadding) {
					    $slick['centerPadding'] = $centerPadding;
					}
					
					$responsive = array();
					
					if ($slidesToShow > 3) {
					    $bp2 = array(
						'breakpoint'=>782
						, 'settings'=>array(
						    'slidesToShow'=>3
						)
					    );
					    
					    $responsive[] = $bp2;
					}
					
					$bp1 = array(
					    'breakpoint'=>471
					    , 'settings'=>array(
						'slidesToShow'=>1
						,'slidesToScroll'=>1
					    )
					);
					
					$responsive[] = $bp1;
					
					$slick['responsive'] = $responsive;
					
					$slick = json_encode(apply_filters('sb_divi_module_slick_js_init', $slick, get_the_ID()));
					
					//edd featured
						$args = apply_filters( 'edd_fd_featured_downloads_args', array(
								'post_type' => 'download',
								//'orderby' => $orderby,
								//'order' => $order,
								'posts_per_page' => 9,
								'meta_key' => 'edd_feature_download',
						));
						
						$attachments = get_posts($args);
						
						//echo '<pre>';
						//print_r($args);
						//print_r($attachments);
						//echo '</pre>';
					
					$all_tabs_content = '';
					
					if ( $attachments ) { 
							foreach ( $attachments as $attachment ) {
								$attachment_id = $attachment->ID;
							  $all_tabs_content .= '<div class="slide-image">';
								$image_title 	= esc_attr( $attachment->post_title );
								$image_caption 	= esc_attr( get_post_field( 'post_excerpt', $attachment_id ) );
								
								$image = get_the_post_thumbnail( $attachment_id, $this->shortcode_atts['image_size'], array(
									'title'	=> $image_title,
									'alt'	=> $image_title
								) );
								
								$post = '</a>';
								$pre = '<a href="' . get_permalink($attachment_id) . '">';
								$all_tabs_content .= $pre . $image . $post;
								$all_tabs_content .= '</div>';
							}

							$output = ' <div class="sb-slick-carousel sb-slick-carousel-' . $rand . ' ' . $module_class . '">
									' . $all_tabs_content . '
								    </div>';
								    
							$output .= '<script>
								    jQuery(document).ready(function(){
									jQuery(\'.sb-slick-carousel-' . $rand . '.sb-slick-carousel\').slick(' . $slick . ');
								    });
								    </script>';
						    
					}
								
					return $output;
				}
			}
			new et_pb_slick_edd_featured;
			
			class et_pb_slick_slide extends ET_Builder_Module {
				function init() {
					$this->name                        = esc_html__( 'Slick Slide', 'et_builder' );
					$this->slug                        = 'et_pb_slick_slide';
					$this->type                        = 'child';
					$this->child_title_var             = 'title';
			
					$this->whitelisted_fields = array(
						'slide_image',
						'content',
						'layout_type',
						'text_colour',
						'background_colour',
						'image_link',
						'image_link_new_window',
					);
					
					$this->fields_defaults = array(
					    'layout' => array('image100_content100')
					);
			
					$this->advanced_setting_title_text = esc_html__( 'New Slide', 'et_builder' );
					$this->settings_text               = esc_html__( 'Slide Settings', 'et_builder' );
					$this->main_css_element = '%%order_class%%';
					$this->advanced_options = array(
                                        'fonts' => array(
                                                'text'   => array(
                                                                'label'    => esc_html__( 'Text', 'et_builder' ),
                                                                'css'      => array(
                                                                        'main' => "{$this->main_css_element} p",
                                                                ),
                                                                'font_size' => array('default' => '14px'),
                                                                'line_height'    => array('default' => '1.5em'),
                                                ),
                                                'headings'   => array(
                                                                'label'    => esc_html__( 'Headings', 'et_builder' ),
                                                                'css'      => array(
                                                                        'main' => "{$this->main_css_element} h1, {$this->main_css_element} h2, {$this->main_css_element} h1 a, {$this->main_css_element} h2 a, {$this->main_css_element} h3, {$this->main_css_element} h4",
                                                                ),
                                                                'font_size' => array('default' => '30px'),
                                                                'line_height'    => array('default' => '1.5em'),
                                                ),
                                        ),
                                        'background' => array(
                                                'settings' => array(
                                                        'color' => 'alpha',
                                                ),
                                        ),
                                        'border' => array(),
                                        'custom_margin_padding' => array(
                                                'css' => array(
                                                        'important' => 'all',
                                                ),
                                        ),
                                );
				}
			
				function get_fields() {
							
					$fields = array(
						'title' => array(
							'label'       => esc_html__( 'Admin Label', 'et_builder' ),
							'type'        => 'text',
							'description' => esc_html__( 'Just something to call this slide so you can easily find it later', 'et_builder' ),
						),
						'slide_image' => array(
							'label'              => esc_html__( 'Slide Image', 'et_builder' ),
							'type'               => 'upload',
							'option_category'    => 'basic_option',
							'upload_button_text' => esc_attr__( 'Upload an image', 'et_builder' ),
							'choose_text'        => esc_attr__( 'Choose a Slide Image', 'et_builder' ),
							'update_text'        => esc_attr__( 'Set As Slide Image', 'et_builder' ),
							'description'        => esc_html__( 'If defined, this image will be used as the background for this module. To remove a background image, simply delete the URL from the settings field.', 'et_builder' ),
						),
						'add_image_link' => array(
							'label'         => esc_html__( 'Add Image Link?', 'et_builder' ),
							'type'          => 'yes_no_button',
							'option_category' => 'configuration',
							'options'       => array(
							    'off' => esc_html__( 'No', 'et_builder' ),
							    'on'  => esc_html__( 'Yes', 'et_builder' ),
							),
							'affects' => array(
								'#et_pb_image_link_new_window',
								'#et_pb_image_link',
							),
							'description'   => esc_html__( 'Should this slide link to another page or website?', 'et_builder' ),
						),
						'image_link' => array(
							'label'       => esc_html__( 'Image Link', 'et_builder' ),
							'type'        => 'text',
							'depends_show_if'   => 'on',
							'description' => esc_html__( 'Optionally enter a URL for this slide image to link to.', 'et_builder' ),
						),
						'image_link_new_window' => array(
							'label'         => esc_html__( 'Link new tab/window?', 'et_builder' ),
							'type'          => 'yes_no_button',
							'option_category' => 'configuration',
							'options'       => array(
							    'off' => esc_html__( 'No', 'et_builder' ),
							    'on'  => esc_html__( 'Yes', 'et_builder' ),
							),
							'depends_show_if'   => 'on',
							'description'   => esc_html__( 'Link opens in new window/tab?', 'et_builder' ),
						),
						'content' => array(
							'label'           => esc_html__( 'Content', 'et_builder' ),
							'type'            => 'tiny_mce',
							'option_category' => 'basic_option',
							'description'     => esc_html__( 'If you would like to add some content then use this editor', 'et_builder' ),
						),
						'layout_type' => array(
							'label'         => esc_html__( 'Image/Content Layout', 'et_builder' ),
							'type'          => 'select',
							'options'       => array(
							    'image100_content100'  => 'Full Width',
							    'image50_content50'  => 'Image 50% / Content 50%',
							    'content50_image50'  => 'Content 50% / Image 50%',
							    'image25_content75'  => 'Image 25% / Content 75%',
							    'content75_image25'  => 'Content 75% / Image 25%',
							),
							'option_category' => 'configuration',
							'description'   => esc_html__( 'IF BOTH image AND content are filled in then this will effect the layout. Default: Full Width', 'et_builder' ),
						),
						'background_colour' => array(
							'label'             => esc_html__( 'Slide Background Colour', 'et_builder' ),
							'type'              => 'color-alpha',
							'custom_color'      => true,
							'option_category' => 'basic_option',
							'description'       => esc_html__( 'Here you can define a custom background colour for the slide.', 'et_builder' ),
						),
						'text_colour' => array(
							'label'             => esc_html__( 'Slide Text Colour', 'et_builder' ),
							'type'              => 'color-alpha',
							'custom_color'      => true,
							'option_category' => 'basic_option',
							'description'       => esc_html__( 'Here you can define a custom text colour for the slide.', 'et_builder' ),
						),
					);
					return $fields;
				}
			
				function shortcode_callback( $atts, $content = null, $function_name ) {
					$output = '';
					$module_class = @$this->shortcode_atts['module_class'];
					$module_class = ET_Builder_Element::add_module_order_class( $module_class, $function_name );
					
					$image = $this->shortcode_atts['slide_image'];
					$layout_type = $this->shortcode_atts['layout_type'];
					$background_colour = $this->shortcode_atts['background_colour'];
					$text_colour = $this->shortcode_atts['text_colour'];
					$image_link = $this->shortcode_atts['image_link'];
					$image_link_new_window = ($this->shortcode_atts['image_link_new_window'] == 'on');
					$content = $this->shortcode_content;
					
					if ( '' !== $background_colour ) {
						ET_Builder_Element::set_style( $function_name, array(
							'selector'    => '%%order_class%%.slick-slide',
							'declaration' => sprintf(
								'background-color: %1$s;',
								esc_html( $background_colour )
							),
						) );
					}
					if ( '' !== $text_colour ) {
						ET_Builder_Element::set_style( $function_name, array(
							'selector'    => '%%order_class%%.slick-slide p, %%order_class%%.slick-slide h1, %%order_class%%.slick-slide h2, %%order_class%%.slick-slide h3, %%order_class%%.slick-slide h4, %%order_class%%.slick-slide a',
							'declaration' => sprintf(
								'color: %1$s;',
								esc_html( $text_colour )
							),
						) );
					}
					
					$output .= '<div class="' . $module_class . ' ' . ($layout_type && $image ? $layout_type:'image100_content100') . '">';
					
					if ($image) {
					    $output .= '<div class="slide-image">';
					    
					    if ($image_link) {
								$output .= '<a href="' . $image_link . '" ' . ($image_link_new_window ? 'target="_blank"':'') . '>';
					    }
					    
					    $output .= '<img src="' . $image . '" />';
					    
					    if ($image_link) {
								$output .= '</a>';
					    }
					    
					    $output .= '</div>';
					}
					
					if (strip_tags($content)) {
					    $output .= '<div class="slide-content">' . $content . '</div>';
					}
					
					$output .= '</div>';
			
					return $output;
				}
			}
			new et_pb_slick_slide;
				
				////////////////////////////////////////////////////////
				
            class sb_et_slick_gallery_module extends ET_Builder_Module {
                function init() {
                        $this->name = __( 'SB Slick Featured Image', 'et_builder' );
                        $this->slug = 'et_pb_slick_featured_image';
        
                        $this->whitelisted_fields = array(
                                'image_size',
                                'alt',
                                'title_text',
                                'show_in_lightbox',
                                'url',
                                'url_new_window',
                                'disable_link_title',
                                'animation',
                                'sticky',
                                'align',
                                'admin_label',
                                'module_id',
                                'module_class',
                                'max_width',
                                'force_fullwidth',
                                'always_center_on_mobile',
                                'use_overlay',
                                'overlay_icon_color',
                                'hover_overlay_color',
                                'hover_icon',
                                'max_width_tablet',
                                'max_width_phone',
                        );
        
                        $this->fields_defaults = array(
                                'show_in_lightbox'        => array( 'off' ),
                                'url_new_window'          => array( 'off' ),
                                'animation'               => array( 'left' ),
                                'sticky'                  => array( 'off' ),
                                'align'                   => array( 'left' ),
                                'force_fullwidth'         => array( 'off' ),
                                'always_center_on_mobile' => array( 'on' ),
                                'use_overlay'             => array( 'off' ),
                        );
        
                        $this->advanced_options = array(
                                'border'                => array(),
                                'custom_margin_padding' => array(
                                        'use_padding' => false,
                                        'css' => array(
                                                'important' => 'all',
                                        ),
                                ),
                        );
                }
            
                function get_fields() {
                        
                        $options = array();
                        $sizes = get_intermediate_image_sizes();
                        
                        foreach ($sizes as $size) {
                                    $options[$size] = $size;
                        }
                        
                        // List of animation options
                        $animation_options_list = array(
                                'left'    => esc_html__( 'Left To Right', 'et_builder' ),
                                'right'   => esc_html__( 'Right To Left', 'et_builder' ),
                                'top'     => esc_html__( 'Top To Bottom', 'et_builder' ),
                                'bottom'  => esc_html__( 'Bottom To Top', 'et_builder' ),
                                'fade_in' => esc_html__( 'Fade In', 'et_builder' ),
                                'off'     => esc_html__( 'No Animation', 'et_builder' ),
                        );
        
                        $animation_option_name       = sprintf( '%1$s-animation', $this->slug );
                        $default_animation_direction = ET_Global_Settings::get_value( $animation_option_name );
        
                        // If user modifies default animation option via Customizer, we'll need to change the order
                        if ( 'left' !== $default_animation_direction && ! empty( $default_animation_direction ) && array_key_exists( $default_animation_direction, $animation_options_list ) ) {
                                // The options, sans user's preferred direction
                                $animation_options_wo_default = $animation_options_list;
                                unset( $animation_options_wo_default[ $default_animation_direction ] );
        
                                // All animation options
                                $animation_options = array_merge(
                                        array( $default_animation_direction => $animation_options_list[$default_animation_direction] ),
                                        $animation_options_wo_default
                                );
                        } else {
                                // Simply copy the animation options
                                $animation_options = $animation_options_list;
                        }
        
                        $fields = array(
                                'image_size' => array(
                                                'label'           => __( 'Image Size', 'et_builder' ),
                                                'type'            => 'select',
                                                'options'         => $options,
                                                'description'       => __( 'Pick a size for the featured image from the list. Leave blank for default.', 'et_builder' ),
                                    ),
                                'alt' => array(
                                        'label'           => esc_html__( 'Image Alternative Text', 'et_builder' ),
                                        'type'            => 'text',
                                        'option_category' => 'basic_option',
                                        'description'     => esc_html__( 'This defines the HTML ALT text. A short description of your image can be placed here.', 'et_builder' ),
                                ),
                                'title_text' => array(
                                        'label'           => esc_html__( 'Image Title Text', 'et_builder' ),
                                        'type'            => 'text',
                                        'option_category' => 'basic_option',
                                        'description'     => esc_html__( 'This defines the HTML Title text.', 'et_builder' ),
                                ),
                                'show_in_lightbox' => array(
                                        'label'             => esc_html__( 'Open in Lightbox', 'et_builder' ),
                                        'type'              => 'yes_no_button',
                                        'option_category'   => 'configuration',
                                        'options'           => array(
                                                'off' => esc_html__( "No", 'et_builder' ),
                                                'on'  => esc_html__( 'Yes', 'et_builder' ),
                                        ),
                                        'affects'           => array(
                                                '#et_pb_url',
                                                '#et_pb_url_new_window',
                                                '#et_pb_use_overlay'
                                        ),
                                        'description'       => esc_html__( 'Here you can choose whether or not the image should open in Lightbox. Note: if you select to open the image in Lightbox, url options below will be ignored.', 'et_builder' ),
                                ),
                                'url' => array(
                                        'label'           => esc_html__( 'Link URL', 'et_builder' ),
                                        'type'            => 'text',
                                        'option_category' => 'basic_option',
                                        'depends_show_if' => 'off',
                                        'affects'         => array(
                                                '#et_pb_use_overlay',
                                        ),
                                        'description'     => esc_html__( 'If you would like your image to be a link, input your destination URL here. No link will be created if this field is left blank unless the image is used on an archive page in which case the image will link to the post type item.', 'et_builder' ),
                                ),
                                'url_new_window' => array(
                                        'label'             => esc_html__( 'Url Opens', 'et_builder' ),
                                        'type'              => 'select',
                                        'option_category'   => 'configuration',
                                        'options'           => array(
                                                'off' => esc_html__( 'In The Same Window', 'et_builder' ),
                                                'on'  => esc_html__( 'In The New Tab', 'et_builder' ),
                                        ),
                                        'depends_show_if'   => 'off',
                                        'description'       => esc_html__( 'Here you can choose whether or not your link opens in a new window', 'et_builder' ),
                                ),
																'disable_link_title' => array(
																		'label'             => esc_html__( 'Disable Link?', 'et_builder' ),
																		'type'              => 'yes_no_button',
																		'option_category'   => 'configuration',
																		'options'           => array(
																				'off' => esc_html__( 'No', 'et_builder' ),
																				'on'  => esc_html__( 'Yes', 'et_builder' ),
																		),
																		'description'       => esc_html__( 'When on an archive page the image would normally link. This disables that.', 'et_builder' ),
																),
                                'use_overlay' => array(
                                        'label'             => esc_html__( 'Image Overlay', 'et_builder' ),
                                        'type'              => 'yes_no_button',
                                        'option_category'   => 'layout',
                                        'options'           => array(
                                                'off' => esc_html__( 'Off', 'et_builder' ),
                                                'on'  => esc_html__( 'On', 'et_builder' ),
                                        ),
                                        'affects'           => array(
                                                '#et_pb_overlay_icon_color',
                                                '#et_pb_hover_overlay_color',
                                                '#et_pb_hover_icon',
                                        ),
                                        'depends_default'   => true,
                                        'description'       => esc_html__( 'If enabled, an overlay color and icon will be displayed when a visitors hovers over the image', 'et_builder' ),
                                ),
                                'overlay_icon_color' => array(
                                        'label'             => esc_html__( 'Overlay Icon Color', 'et_builder' ),
                                        'type'              => 'color',
                                        'custom_color'      => true,
                                        'depends_show_if'   => 'on',
                                        'description'       => esc_html__( 'Here you can define a custom color for the overlay icon', 'et_builder' ),
                                ),
                                'hover_overlay_color' => array(
                                        'label'             => esc_html__( 'Hover Overlay Color', 'et_builder' ),
                                        'type'              => 'color-alpha',
                                        'custom_color'      => true,
                                        'depends_show_if'   => 'on',
                                        'description'       => esc_html__( 'Here you can define a custom color for the overlay', 'et_builder' ),
                                ),
                                'hover_icon' => array(
                                        'label'               => esc_html__( 'Hover Icon Picker', 'et_builder' ),
                                        'type'                => 'text',
                                        'option_category'     => 'configuration',
                                        'class'               => array( 'et-pb-font-icon' ),
                                        'renderer'            => 'et_pb_get_font_icon_list',
                                        'renderer_with_field' => true,
                                        'depends_show_if'     => 'on',
                                        'description'       => esc_html__( 'Here you can define a custom icon for the overlay', 'et_builder' ),
                                ),
                                'animation' => array(
                                        'label'             => esc_html__( 'Animation', 'et_builder' ),
                                        'type'              => 'select',
                                        'option_category'   => 'configuration',
                                        'options'           => $animation_options,
                                        'description'       => esc_html__( 'This controls the direction of the lazy-loading animation.', 'et_builder' ),
                                ),
                                'sticky' => array(
                                        'label'             => esc_html__( 'Remove Space Below The Image', 'et_builder' ),
                                        'type'              => 'yes_no_button',
                                        'option_category'   => 'layout',
                                        'options'           => array(
                                                'off'     => esc_html__( 'No', 'et_builder' ),
                                                'on'      => esc_html__( 'Yes', 'et_builder' ),
                                        ),
                                        'description'       => esc_html__( 'Here you can choose whether or not the image should have a space below it.', 'et_builder' ),
                                ),
                                'align' => array(
                                        'label'           => esc_html__( 'Image Alignment', 'et_builder' ),
                                        'type'            => 'select',
                                        'option_category' => 'layout',
                                        'options' => array(
                                                'left'   => esc_html__( 'Left', 'et_builder' ),
                                                'center' => esc_html__( 'Center', 'et_builder' ),
                                                'right'  => esc_html__( 'Right', 'et_builder' ),
                                        ),
                                        'description'       => esc_html__( 'Here you can choose the image alignment.', 'et_builder' ),
                                ),
                                'max_width' => array(
                                        'label'           => esc_html__( 'Image Max Width', 'et_builder' ),
                                        'type'            => 'text',
                                        'option_category' => 'layout',
                                        'tab_slug'        => 'advanced',
                                        'mobile_options'  => true,
                                        'validate_unit'   => true,
                                ),
                                'force_fullwidth' => array(
                                        'label'             => esc_html__( 'Force Fullwidth', 'et_builder' ),
                                        'type'              => 'yes_no_button',
                                        'option_category'   => 'layout',
                                        'options'           => array(
                                                'off' => esc_html__( "No", 'et_builder' ),
                                                'on'  => esc_html__( 'Yes', 'et_builder' ),
                                        ),
                                        'tab_slug'    => 'advanced',
                                ),
                                'always_center_on_mobile' => array(
                                        'label'             => esc_html__( 'Always Center Image On Mobile', 'et_builder' ),
                                        'type'              => 'yes_no_button',
                                        'option_category'   => 'layout',
                                        'options'           => array(
                                                'on'  => esc_html__( 'Yes', 'et_builder' ),
                                                'off' => esc_html__( "No", 'et_builder' ),
                                        ),
                                        'tab_slug'    => 'advanced',
                                ),
                                'max_width_tablet' => array(
                                        'type' => 'skip',
                                ),
                                'max_width_phone' => array(
                                        'type' => 'skip',
                                ),
                                'disabled_on' => array(
                                        'label'           => esc_html__( 'Disable on', 'et_builder' ),
                                        'type'            => 'multiple_checkboxes',
                                        'options'         => array(
                                                'phone'   => esc_html__( 'Phone', 'et_builder' ),
                                                'tablet'  => esc_html__( 'Tablet', 'et_builder' ),
                                                'desktop' => esc_html__( 'Desktop', 'et_builder' ),
                                        ),
                                        'additional_att'  => 'disable_on',
                                        'option_category' => 'configuration',
                                        'description'     => esc_html__( 'This will disable the module on selected devices', 'et_builder' ),
                                ),
                                'admin_label' => array(
                                        'label'       => esc_html__( 'Admin Label', 'et_builder' ),
                                        'type'        => 'text',
                                        'description' => esc_html__( 'This will change the label of the module in the builder for easy identification.', 'et_builder' ),
                                ),
                                'module_id' => array(
                                        'label'           => esc_html__( 'CSS ID', 'et_builder' ),
                                        'type'            => 'text',
                                        'option_category' => 'configuration',
                                        'tab_slug'        => 'custom_css',
                                        'option_class'    => 'et_pb_custom_css_regular',
                                ),
                                'module_class' => array(
                                        'label'           => esc_html__( 'CSS Class', 'et_builder' ),
                                        'type'            => 'text',
                                        'option_category' => 'configuration',
                                        'tab_slug'        => 'custom_css',
                                        'option_class'    => 'et_pb_custom_css_regular',
                                ),
                        );
        
                        return $fields;
                }
            
                function shortcode_callback( $atts, $content = null, $function_name ) {
                        $output = '';
                        
                        $image_size               = $this->shortcode_atts['image_size'];
                        $module_id               = $this->shortcode_atts['module_id'];
                        $module_class            = $this->shortcode_atts['module_class'];
                        $alt                     = $this->shortcode_atts['alt'];
                        $title_text              = $this->shortcode_atts['title_text'];
                        $animation               = $this->shortcode_atts['animation'];
                        $url                     = $this->shortcode_atts['url'];
                        $url_new_window          = $this->shortcode_atts['url_new_window'];
												$disable_link       		 = $this->shortcode_atts['disable_link_title'];
                        $show_in_lightbox        = $this->shortcode_atts['show_in_lightbox'];
                        $sticky                  = $this->shortcode_atts['sticky'];
                        $align                   = $this->shortcode_atts['align'];
                        $max_width               = $this->shortcode_atts['max_width'];
                        $max_width_tablet        = $this->shortcode_atts['max_width_tablet'];
                        $max_width_phone         = $this->shortcode_atts['max_width_phone'];
                        $force_fullwidth         = $this->shortcode_atts['force_fullwidth'];
                        $always_center_on_mobile = $this->shortcode_atts['always_center_on_mobile'];
                        $overlay_icon_color      = $this->shortcode_atts['overlay_icon_color'];
                        $hover_overlay_color     = $this->shortcode_atts['hover_overlay_color'];
                        $hover_icon              = $this->shortcode_atts['hover_icon'];
                        $use_overlay             = $this->shortcode_atts['use_overlay'];
        
                        $module_class = ET_Builder_Element::add_module_order_class( $module_class, $function_name );
        
                        if ( 'on' === $always_center_on_mobile ) {
                                $module_class .= ' et_always_center_on_mobile';
                        }
        
                        // overlay can be applied only if image has link or if lightbox enabled
                        $is_overlay_applied = 'on' === $use_overlay && ( 'on' === $show_in_lightbox || ( 'off' === $show_in_lightbox && '' !== $url ) ) ? 'on' : 'off';
        
                        if ( '' !== $max_width_tablet || '' !== $max_width_phone || '' !== $max_width ) {
                                $max_width_values = array(
                                        'desktop' => $max_width,
                                        'tablet'  => $max_width_tablet,
                                        'phone'   => $max_width_phone,
                                );
        
                                et_pb_generate_responsive_css( $max_width_values, '%%order_class%%', 'max-width', $function_name );
                        }
        
                        if ( 'on' === $force_fullwidth ) {
                                ET_Builder_Element::set_style( $function_name, array(
                                        'selector'    => '%%order_class%% img',
                                        'declaration' => 'width: 100%;',
                                ) );
                        }
        
                        if ( $this->fields_defaults['align'][0] !== $align ) {
                                ET_Builder_Element::set_style( $function_name, array(
                                        'selector'    => '%%order_class%%',
                                        'declaration' => sprintf(
                                                'text-align: %1$s;',
                                                esc_html( $align )
                                        ),
                                ) );
                        }
        
                        if ( 'center' !== $align ) {
                                ET_Builder_Element::set_style( $function_name, array(
                                        'selector'    => '%%order_class%%',
                                        'declaration' => sprintf(
                                                'margin-%1$s: 0;',
                                                esc_html( $align )
                                        ),
                                ) );
                        }
        
                        if ( 'on' === $is_overlay_applied ) {
                                if ( '' !== $overlay_icon_color ) {
                                        ET_Builder_Element::set_style( $function_name, array(
                                                'selector'    => '%%order_class%% .et_overlay:before',
                                                'declaration' => sprintf(
                                                        'color: %1$s !important;',
                                                        esc_html( $overlay_icon_color )
                                                ),
                                        ) );
                                }
        
                                if ( '' !== $hover_overlay_color ) {
                                        ET_Builder_Element::set_style( $function_name, array(
                                                'selector'    => '%%order_class%% .et_overlay',
                                                'declaration' => sprintf(
                                                        'background-color: %1$s;',
                                                        esc_html( $hover_overlay_color )
                                                ),
                                        ) );
                                }
        
                                $data_icon = '' !== $hover_icon
                                        ? sprintf(
                                                ' data-icon="%1$s"',
                                                esc_attr( et_pb_process_font_icon( $hover_icon ) )
                                        )
                                        : '';
        
                                $overlay_output = sprintf(
                                        '<span class="et_overlay%1$s"%2$s></span>',
                                        ( '' !== $hover_icon ? ' et_pb_inline_icon' : '' ),
                                        $data_icon
                                );
                        }
        
                        if (has_post_thumbnail( get_the_ID() ) ) {
                                    $image = wp_get_attachment_image_src( get_post_thumbnail_id( get_the_ID() ), $image_size );
                                    $src = $image[0];
        
                                    $output = sprintf(
																				'<img src="%1$s" alt="%2$s"%3$s />
																				%4$s',
																				esc_url( $src ),
																				esc_attr( $alt ),
																				( '' !== $title_text ? sprintf( ' title="%1$s"', esc_attr( $title_text ) ) : '' ),
																				'on' === $is_overlay_applied ? $overlay_output : ''
                                    );
                    
                                    if ( 'on' === $show_in_lightbox ) {
																				$output = sprintf( '<a href="%1$s" class="et_pb_lightbox_image" title="%3$s">%2$s</a>',
																								esc_url( $src ),
																								$output,
																								esc_attr( $alt )
																				);
                                    } else if ( '' !== $url ) {
																				$output = sprintf( '<a href="%1$s"%3$s>%2$s</a>',
																								esc_url( $url ),
																								$output,
																								( 'on' === $url_new_window ? ' target="_blank"' : '' )
																				);
                                    } else if ($disable_link != 'on') {
																				$output = sprintf( '<a href="%1$s"%3$s>%2$s</a>',
																								esc_url( get_permalink(get_the_ID()) ),
																								$output,
																								( 'on' === $url_new_window ? ' target="_blank"' : '' )
																				);
                                    }
                    
                                    $animation = '' === $animation ? ET_Global_Settings::get_value( 'et_pb_image-animation' ) : $animation;
                    
                                    $output = sprintf(
                                            '<div%5$s class="et_pb_module et-waypoint et_pb_image%2$s%3$s%4$s%6$s">
                                                    %1$s
                                            </div>',
                                            $output,
                                            esc_attr( " et_pb_animation_{$animation}" ),
                                            ( '' !== $module_class ? sprintf( ' %1$s', esc_attr( ltrim( $module_class ) ) ) : '' ),
                                            ( 'on' === $sticky ? esc_attr( ' et_pb_image_sticky' ) : '' ),
                                            ( '' !== $module_id ? sprintf( ' id="%1$s"', esc_attr( $module_id ) ) : '' ),
                                            'on' === $is_overlay_applied ? ' et_pb_has_overlay' : ''
                                    );
                        }
        
                        return $output;
                }
            }
        
            new sb_et_slick_gallery_module();
						
						class sb_et_slick_title_module extends ET_Builder_Module {
                function init() {
                    $this->name = __( 'SB Slick Title', 'et_builder' );
                    $this->slug = 'et_pb_slick_title';
            
                    $this->whitelisted_fields = array(
                        'module_id',
                        'module_class',
												'title',
												'disable_link_title',
												'meta',
												'author',
												'date',
												'date_format',
												'categories',
												'comments',
                    );
            
                    $this->fields_defaults = array();
                    //$this->main_css_element = '.et_pb_slick_title';
                    //$this->advanced_options = array();
                    //$this->custom_css_options = array();
										
                    $this->main_css_element = '%%order_class%%';
                    
																$this->advanced_options = array(
                                        'fonts' => array(
                                                'text'   => array(
                                                                'label'    => esc_html__( 'Text', 'et_builder' ),
                                                                'css'      => array(
                                                                        'main' => "{$this->main_css_element} p",
                                                                ),
                                                                'font_size' => array('default' => '14px'),
                                                                'line_height'    => array('default' => '1.5em'),
                                                ),
                                                'headings'   => array(
                                                                'label'    => esc_html__( 'Headings', 'et_builder' ),
                                                                'css'      => array(
                                                                        'main' => "{$this->main_css_element} h1, {$this->main_css_element} h2, {$this->main_css_element} h1 a, {$this->main_css_element} h2 a, {$this->main_css_element} h1 a, {$this->main_css_element} h2 a, {$this->main_css_element} h3, {$this->main_css_element} h4",
                                                                ),
                                                                'font_size' => array('default' => '30px'),
                                                                'line_height'    => array('default' => '1.5em'),
                                                ),
                                        ),
                                        'background' => array(
                                                'settings' => array(
                                                        'color' => 'alpha',
                                                ),
                                        ),
                                        'border' => array(),
                                        'custom_margin_padding' => array(
                                                'css' => array(
                                                        'important' => 'all',
                                                ),
                                        ),
                                );
                }
            
                function get_fields() {
                    $fields = array(
                        'admin_label' => array(
                            'label'       => __( 'Admin Label', 'et_builder' ),
                            'type'        => 'text',
                            'description' => __( 'This will change the label of the module in the builder for easy identification.', 'et_builder' ),
                        ),
                        'module_id' => array(
																'label'           => esc_html__( 'CSS ID', 'et_builder' ),
																'type'            => 'text',
																'option_category' => 'configuration',
																'tab_slug'        => 'custom_css',
																'option_class'    => 'et_pb_custom_css_regular',
															),
															'module_class' => array(
																'label'           => esc_html__( 'CSS Class', 'et_builder' ),
																'type'            => 'text',
																'option_category' => 'configuration',
																'tab_slug'        => 'custom_css',
																'option_class'    => 'et_pb_custom_css_regular',
															),
															'title' => array(
																'label'             => esc_html__( 'Hide Title', 'et_builder' ),
																'type'              => 'yes_no_button',
																'option_category'   => 'configuration',
																'options'           => array(
																								'off' => esc_html__( 'No', 'et_builder' ),
																								'on'  => esc_html__( 'Yes', 'et_builder' ),
																),
																'description'       => esc_html__( 'Here you can choose whether or not hide the Post Title', 'et_builder' ),
															),
															'disable_link_title' => array(
																'label'             => esc_html__( 'Disable Link?', 'et_builder' ),
																'type'              => 'yes_no_button',
																'option_category'   => 'configuration',
																'options'           => array(
																		'off' => esc_html__( 'No', 'et_builder' ),
																		'on'  => esc_html__( 'Yes', 'et_builder' ),
																),
																'description'       => esc_html__( 'When on an archive page the title would normally link. This disables that.', 'et_builder' ),
															),
															'meta' => array(
																'label'             => esc_html__( 'Show Meta', 'et_builder' ),
																'type'              => 'yes_no_button',
																'option_category'   => 'configuration',
																'options'           => array(
																	'on'  => esc_html__( 'Yes', 'et_builder' ),
																	'off' => esc_html__( 'No', 'et_builder' ),
																),
																'affects'           => array(
																	'author',
																	'date',
																	'categories',
																	'comments',
																),
																'description'       => esc_html__( 'Here you can choose whether or not display the Post Meta', 'et_builder' ),
															),
															'author' => array(
																'label'             => esc_html__( 'Show Author', 'et_builder' ),
																'type'              => 'yes_no_button',
																'option_category'   => 'configuration',
																'options'           => array(
																	'on'  => esc_html__( 'Yes', 'et_builder' ),
																	'off' => esc_html__( 'No', 'et_builder' ),
																),
																'depends_show_if'   => 'on',
																'description'       => esc_html__( 'Here you can choose whether or not display the Author Name in Post Meta', 'et_builder' ),
															),
															'date' => array(
																'label'             => esc_html__( 'Show Date', 'et_builder' ),
																'type'              => 'yes_no_button',
																'option_category'   => 'configuration',
																'options'           => array(
																	'on'  => esc_html__( 'Yes', 'et_builder' ),
																	'off' => esc_html__( 'No', 'et_builder' ),
																),
																'depends_show_if'   => 'on',
																'affects'           => array(
																	'date_format'
																),
																'description'       => esc_html__( 'Here you can choose whether or not display the Date in Post Meta', 'et_builder' ),
															),
												
															'date_format' => array(
																'label'             => esc_html__( 'Date Format', 'et_builder' ),
																'type'              => 'text',
																'option_category'   => 'configuration',
																'depends_show_if'   => 'on',
																'description'       => esc_html__( 'Here you can define the Date Format in Post Meta. Default is \'M j, Y\'', 'et_builder' ),
															),
												
															'categories' => array(
																'label'             => esc_html__( 'Show Post Categories', 'et_builder' ),
																'type'              => 'yes_no_button',
																'option_category'   => 'configuration',
																'options'           => array(
																	'on'  => esc_html__( 'Yes', 'et_builder' ),
																	'off' => esc_html__( 'No', 'et_builder' ),
																),
																'depends_show_if'   => 'on',
																'description'       => esc_html__( 'Here you can choose whether or not display the Categories in Post Meta. Note: This option doesn\'t work with custom post types.', 'et_builder' ),
															),
															'comments' => array(
																'label'             => esc_html__( 'Show Comments Count', 'et_builder' ),
																'type'              => 'yes_no_button',
																'option_category'   => 'configuration',
																'options'           => array(
																	'on'  => esc_html__( 'Yes', 'et_builder' ),
																	'off' => esc_html__( 'No', 'et_builder' ),
																),
																'depends_show_if'   => 'on',
																'description'       => esc_html__( 'Here you can choose whether or not display the Comments Count in Post Meta.', 'et_builder' ),
															),
                    );
                    
                    return $fields;
                }
            
                function shortcode_callback( $atts, $content = null, $function_name ) {
																$module_id          = $this->shortcode_atts['module_id'];
																$module_class       = $this->shortcode_atts['module_class'];
																$title              = $this->shortcode_atts['title'];
																$meta               = $this->shortcode_atts['meta'];
																$disable_link       = $this->shortcode_atts['disable_link_title'];
																$author             = $this->shortcode_atts['author'];
																$date               = $this->shortcode_atts['date'];
																$date_format        = $this->shortcode_atts['date_format'];
																$categories         = $this->shortcode_atts['categories'];
																$comments           = $this->shortcode_atts['comments'];
            
																$module_class = ET_Builder_Element::add_module_order_class( $module_class, $function_name );
            
																//////////////////////////////////////////////////////////////////////

																$output = '';
														
																if ( $title != 'on' ) {
																								if ( is_et_pb_preview() && isset( $_POST['post_title'] ) && wp_verify_nonce( $_POST['et_pb_preview_nonce'], 'et_pb_preview_nonce' ) ) {
																									$post_title = sanitize_text_field( wp_unslash( $_POST['post_title'] ) );
																								} else {
																									$post_title = get_the_title();
																								}
														
																								if (is_single() || is_page()) {
																																$output .= '<h1 itemprop="name" class="cpt_title page_title entry-title">' . $post_title . '</h1>';
																								} else {
																																$output .= '<h2 itemprop="name" class="cpt_title page_title entry-title">';
																																
																																if ($disable_link != 'on') {
																																		$output .= '<a href="' . get_permalink(get_the_ID()) . '">';
																																}
																																
																																$output .= $post_title;
																																
																																if ($disable_link != 'on') {
																																		$output .= '</a>';
																																}
																																
																																$output .= '</h2>';
																								}																	
																	
																}
														
																if ( 'on' === $meta ) {
																	$meta_array = array();
																	foreach( array( 'author', 'date', 'categories', 'comments' ) as $single_meta ) {
																		if ( 'on' === $$single_meta && ( 'categories' !== $single_meta || ( 'categories' === $single_meta ) ) ) {
																			 $meta_array[] = $single_meta;
																		}
																	}
														
																	$output .= sprintf( '<p class="et_pb_title_meta_container">%1$s</p>',
																		et_pb_postinfo_meta( $meta_array, $date_format, esc_html__( '0 comments', 'et_builder' ), esc_html__( '1 comment', 'et_builder' ), '% ' . esc_html__( 'comments', 'et_builder' ) )
																	);
																}
														
																//////////////////////////////////////////////////////////////////////
            
																if ($output) {
																		$output = '<div ' . ( '' !== $module_id ? sprintf( ' id="%1$s"', esc_attr( $module_id ) ) : '' ) . ' class="clearfix et_pb_module ' . esc_attr( $class ) . ' ' . ( '' !== $module_class ? esc_attr( $module_class ) : '' ) . '">' . $output . '</div>';
																}
            
                    return $output;
                }
            }
        
            new sb_et_slick_title_module();
						
						class sb_et_slick_content_module extends ET_Builder_Module {
                function init() {
                    $this->name = __( 'SB Slick Content', 'et_builder' );
                    $this->slug = 'et_pb_slick_text';
            
                    $this->whitelisted_fields = array(
                        'excerpt_only',
                        'show_read_more',
                        'read_more_label',
                        'admin_label',
                        'module_id',
                        'module_class',
                    );
            
                    $this->fields_defaults = array();
                    //$this->main_css_element = '.et_pb_slick_text';
                                $this->main_css_element = '%%order_class%%';
                    
                                $this->advanced_options = array(
                                        'fonts' => array(
                                                'text'   => array(
                                                                'label'    => esc_html__( 'Text', 'et_builder' ),
                                                                'css'      => array(
                                                                        'main' => "{$this->main_css_element} p",
                                                                ),
                                                                'font_size' => array('default' => '14px'),
                                                                'line_height'    => array('default' => '1.5em'),
                                                ),
                                                'headings'   => array(
                                                                'label'    => esc_html__( 'Headings', 'et_builder' ),
                                                                'css'      => array(
                                                                        'main' => "{$this->main_css_element} h1, {$this->main_css_element} h2, {$this->main_css_element} h3, {$this->main_css_element} h4",
                                                                ),
                                                                'font_size' => array('default' => '30px'),
                                                                'line_height'    => array('default' => '1.5em'),
                                                ),
                                                'buttons'   => array(
                                                        'label'    => esc_html__( 'Read More Button', 'et_builder' ),
                                                        'css'      => array(
                                                                'main' => "{$this->main_css_element} .et_pb_more_button",
                                                        ),
                                                ),
                                        ),
                                        'background' => array(
                                                'settings' => array(
                                                        'color' => 'alpha',
                                                ),
                                        ),
                                        'border' => array(),
                                        'custom_margin_padding' => array(
                                                'css' => array(
                                                        'important' => 'all',
                                                ),
                                        ),
                                );
                }
            
                function get_fields() {
                    $fields = array(
                                'excerpt_only' => array(
                                                'label'           => __( 'Excerpt Only?', 'et_builder' ),
                                                'type'            => 'yes_no_button',
                                                'option_category' => 'configuration',
                                                'options'         => array(
                                                                'off' => __( 'No', 'et_builder' ),
                                                                'on'  => __( 'Yes', 'et_builder' ),
                                                ),
                                                'description'       => __( 'Should this show content only or excerpt?', 'et_builder' ),
                                ),
                                'show_read_more' => array(
                                                'label'           => __( 'Show Read More?', 'et_builder' ),
                                                'type'            => 'yes_no_button',
                                                'option_category' => 'configuration',
                                                'options'         => array(
                                                                'off' => __( 'No', 'et_builder' ),
                                                                'on'  => __( 'Yes', 'et_builder' ),
                                                ),
                                                'affects'=>array('#et_pb_read_more_label'),
                                                'description'       => __( 'Should a read more button be shown below the content?', 'et_builder' ),
                                ),
                                'read_more_label' => array(
                                                'label'       => __( 'Read More Label', 'et_builder' ),
                                                'type'        => 'text',
                                                'depends_show_if'=>'on',
                                                'description' => __( 'What should the read more button be labelled as? Defaults to "Read More".', 'et_builder' ),
                                ),
                                'admin_label' => array(
                                                'label'       => __( 'Admin Label', 'et_builder' ),
                                                'type'        => 'text',
                                                'description' => __( 'This will change the label of the module in the builder for easy identification.', 'et_builder' ),
                                ),
                                'module_id' => array(
                                                'label'           => esc_html__( 'CSS ID', 'et_builder' ),
                                                'type'            => 'text',
                                                'option_category' => 'configuration',
                                                'tab_slug'        => 'custom_css',
                                                'option_class'    => 'et_pb_custom_css_regular',
                                ),
                                'module_class' => array(
                                                'label'           => esc_html__( 'CSS Class', 'et_builder' ),
                                                'type'            => 'text',
                                                'option_category' => 'configuration',
                                                'tab_slug'        => 'custom_css',
                                                'option_class'    => 'et_pb_custom_css_regular',
                                ),
                    );
                    
                    return $fields;
                }
            
                function shortcode_callback( $atts, $content = null, $function_name ) {
                    $module_id          = $this->shortcode_atts['module_id'];
                    $module_class       = $this->shortcode_atts['module_class'];
                    $excerpt_only       = $this->shortcode_atts['excerpt_only'];
                    $show_read_more       = $this->shortcode_atts['show_read_more'];
                    $read_more_label       = $this->shortcode_atts['read_more_label'];
                    
                    $read_more_label = ($read_more_label ? $read_more_label:'Read More');
                    
                    $module_class = ET_Builder_Element::add_module_order_class( $module_class, $function_name );
            
                    //////////////////////////////////////////////////////////////////////
                    
                                if ($excerpt_only == 'on') {
                                                ob_start();
                                                the_excerpt();
                                                $content = ob_get_clean();
                                                //$content = apply_filters('the_content', get_the_excerpt());
                                } else {
                                                $content = apply_filters('the_content', get_the_content());
                                }
                                
                                if ($show_read_more == 'on') {
                                                $content .= '<p><a class="button et_pb_button et_pb_more_button" href="' . get_permalink(get_the_ID()) . '">' . $read_more_label . '</a></p>';
                                }
                    
                    //////////////////////////////////////////////////////////////////////
            
                    $output = sprintf(
                        '<div%5$s class="%1$s%3$s%6$s">
                            %2$s
                        %4$s',
                        'clearfix ',
                        $content,
                        esc_attr( 'et_pb_module' ),
                        '</div>',
                        ( '' !== $module_id ? sprintf( ' id="%1$s"', esc_attr( $module_id ) ) : '' ),
                        ( '' !== $module_class ? sprintf( ' %1$s', esc_attr( $module_class ) ) : '' )
                    );
										
										$output = '<div ' . ($module_id ? 'id="' . esc_attr( $module_id ) . '"':'') . ' class="clearfix ' . esc_attr( $class ) . ' ' . ($module_class ? esc_attr( $module_class ):'') . '">' . $output . '</div>';
            
                    return $output;
                }
            }
        
            new sb_et_slick_content_module();
				}
    }
    
    function sb_mod_slick_option_translate($option) {
				return ($option == 'on' ? true:false);
    }
    
?>