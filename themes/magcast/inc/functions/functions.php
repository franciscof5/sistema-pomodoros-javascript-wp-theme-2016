<?php
/**
 * Magcast functions and definitions
 *
 * This file contains all the functions and it's defination that particularly can't be
 * in other files.
 *
 * @package Theme Horse
 * @subpackage Magcast
 * @since Magcast 1.0
 */
/****************************************************************************************/
add_action('wp_enqueue_scripts', 'magcast_scripts_styles_method');
/**
 * Register jquery scripts
 */
function magcast_scripts_styles_method() {
	global $magcast_settings,$magcast_array_of_default_settings;
	$magcast_settings = wp_parse_args(  get_option( 'magcast_theme_settings', array() ),  magcast_get_option_defaults() );
	/**
	 * Loads our main stylesheet.
	 */
	wp_enqueue_style('magcast_style', get_stylesheet_uri());
	wp_enqueue_style('magcast-font-awesome', get_template_directory_uri().'/font-awesome/css/font-awesome.css');
	// Load the html5 shiv.
	wp_enqueue_script( 'html5', get_template_directory_uri() . '/js/html5.js', array(), '3.7.3' );
	wp_script_add_data( 'html5', 'conditional', 'lt IE 9' );
	/**
	 * Adds JavaScript to pages with the comment form to support
	 * sites with threaded comments (when in use).
	 */
	if (is_singular() && comments_open() && get_option('thread_comments')) {
		wp_enqueue_script('comment-reply');
	}
	wp_enqueue_style('owl_carousel', get_template_directory_uri().'/owlcarousel/owl.carousel.css');
	wp_enqueue_script('owl_carousel', get_template_directory_uri().'/owlcarousel/owl.carousel.js', array('jquery'), '2.2.1', true);
	wp_enqueue_script('magcast_owl_carousel', get_template_directory_uri().'/owlcarousel/owl.carousel-settings.js', array('owl_carousel'), false, true);
	wp_register_style( 'magcast_google_fonts', '//fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600&subset=latin-ext,vietnamese');
  	wp_enqueue_style( 'magcast_google_fonts' );
	wp_enqueue_script('magcast_scripts', get_template_directory_uri().'/js/scripts.js', array('jquery'), false, true);
	wp_enqueue_script('newsTicker', get_template_directory_uri().'/js/jquery.newsTicker.js', array('jquery'), false, true);
	wp_enqueue_script('magcast_highligted_post', get_template_directory_uri().'/js/newsTicker-settings.js', array('newsTicker'), false, true);
}
/****************************************************************************************/
add_action('admin_enqueue_scripts', 'magcast_media_js', 10);
/**
 * Register scripts for image upload
 *
 * Hooked to admin_print_scripts action hook
 */
function magcast_media_js( $magcast_hook ) {
    if( $magcast_hook != 'widgets.php' )
		return;
	wp_enqueue_script('magcast_meta_upload_widget', get_template_directory_uri().'/inc/admin/js/add-image-script-widget.js', array('jquery', 'media-upload', 'thickbox'), false, true);
	wp_enqueue_media();
}
/****************************************************************************************/
function magcast_add_editor_styles() {
	add_editor_style( 'custom-editor-style.css' );
}
add_action( 'after_setup_theme', 'magcast_add_editor_styles' );
/****************************************************************************************/
add_filter('wp_page_menu', 'magcast_wp_page_menu');
/**
 * Remove div from wp_page_menu() and replace with ul.
 * @uses wp_page_menu filter
 */
function magcast_wp_page_menu($magcast_page_markup) {
	preg_match('/^<div class=\"([a-z0-9-_]+)\">/i', $magcast_page_markup, $matches);
	$magcast_divclass   = $matches[1];
	$magcast_replace    = array('<div class="'.$magcast_divclass.'">', '</div>');
	$magcast_new_markup = str_replace($magcast_replace, '', $magcast_page_markup);
	$magcast_new_markup = preg_replace('/^<ul>/i', '<ul class="'.$magcast_divclass.'">', $magcast_new_markup);
	return $magcast_new_markup;
}
/****************************************************************************************/
add_filter('excerpt_length', 'magcast_excerpt_length');
/**
 * Sets the post excerpt length to 50 words.
 *
 * function tied to the excerpt_length filter hook.
 *
 * @uses filter excerpt_length
 */
function magcast_excerpt_length($length) {
	return 50;// this will return 50 words in the excerpt
}
add_filter('excerpt_more', 'magcast_continue_reading');
/**
 * Returns a "Continue Reading" link for excerpts
 */
function magcast_continue_reading() {
	return '&hellip; ';
}
/****************************************************************************************/
add_action('pre_get_posts', 'magcast_alter_home');
/**
 * Alter the query for the main loop in home page
 *
 * @uses pre_get_posts hook
 */
function magcast_alter_home($query) {
	global $magcast_settings,$magcast_array_of_default_settings;
	$magcast_settings = wp_parse_args(  get_option( 'magcast_theme_settings', array() ),  magcast_get_option_defaults() );
	$magcast_disable_setting = $magcast_settings['magcast_disable_setting'];
	if ($magcast_settings['magcast_exclude_slider_post'] != 0 && !empty($magcast_settings['magcast_featured_post_slider'])) {
		if ($query->is_main_query() && $query->is_home()) {
			$query->query_vars['post__not_in'] = $magcast_settings['magcast_featured_post_slider'];
		}
	}
	if ( $magcast_disable_setting == 0 ) {
		$magcast_catID = $magcast_settings['magcast_categories'];
			if ( is_array( $magcast_catID ) && !in_array( '0', $magcast_catID ) ) {
				if( $query->is_main_query() && $query->is_home() ) {
					$query->query_vars['category__in'] = $magcast_settings['magcast_categories'];
				}
			}
	}
}
/****************************************************************************************/
add_filter('wp_page_menu', 'magcast_wp_page_menu_filter');
/**
 * @uses wp_page_menu filter hook
 */
if (!function_exists('magcast_wp_page_menu_filter')) {
	function magcast_wp_page_menu_filter($magcast_text) {
		$magcast_replace = array(
			'current_page_item' => 'current-menu-item',
		);
		$magcast_text = str_replace(array_keys($magcast_replace), $magcast_replace, $magcast_text);
		return $magcast_text;
	}
}
/****************************************************************************************/
add_filter('body_class', 'magcast_body_class');
/**
 * Filter the body_class
 *
 * Throwing different body class for the different layouts in the body tag
 */
function magcast_body_class($classes) {
	global $magcast_site_layout, $magcast_content_layout, $magcast_settings,$magcast_array_of_default_settings;
	$magcast_settings = wp_parse_args(  get_option( 'magcast_theme_settings', array() ),  magcast_get_option_defaults() );
	global $post;
	if ($post) {
		$magcast_layout = get_post_meta($post->ID, 'magcast_sidebarlayout', true);
	}
	$magcast_site_layout = $magcast_settings['magcast_design_layout'];
	$magcast_content_layout = $magcast_settings['magcast_content_layout'];
	$magcast_frontpage_id = get_option('page_on_front'); // for front page
	$magcast_banner = get_post_meta( $magcast_frontpage_id, 'magcast_sidebarlayout', true );
	$magcast_page_id = ( 'page' == get_option( 'show_on_front' ) ? get_option( 'page_for_posts' ) : get_the_ID() );
	$magcast_home_blog = get_post_meta( $magcast_page_id, 'magcast_sidebarlayout', true );
	if (empty($magcast_layout) || is_archive() || is_search() || is_home()) {
		$magcast_layout = 'default';
	}
	if ('default' == $magcast_layout) {
		$magcast_themeoption_layout = $magcast_content_layout;
		if ('left' == $magcast_themeoption_layout) {
			$classes[] = 'left-sidebar-layout';
		}
		elseif ('right' == $magcast_themeoption_layout) {
			$classes[] = '';
		}
		elseif ('fullwidth' == $magcast_themeoption_layout) {
			$classes[] = 'full-width-layout';
		}
		elseif ('nosidebar' == $magcast_themeoption_layout) {
			$classes[] = 'no-sidebar-layout';
		}
	}elseif ('left-sidebar' == $magcast_layout) {

	$classes[] = 'left-sidebar-layout';
	}
	elseif ('right-sidebar' == $magcast_layout) {
		$classes[] = '';//css blank
	}
	elseif ('no-sidebar-full-width' == $magcast_layout) {
		$classes[] = 'full-width-layout';
	}
	elseif ('no-sidebar' == $magcast_layout) {
		$classes[] = 'no-sidebar-layout';//css for no-sidebar-layout from <body >
	}
	if ($magcast_site_layout =='off') {

		$classes[] = 'narrow-layout';
	}
	return $classes;
}
/****************************************************************************************/
function magcast_display_social_icons(){
	if ( has_nav_menu( 'social' ) ) : ?>
		<div class="social-profiles clearfix">
		<?php
			// Social links navigation menu.
			wp_nav_menu( array(
				'theme_location' 	=> 'social',
				'container' 		=> '',
				'depth'          	=> 1,
				'items_wrap'      => '<ul>%3$s</ul>',
				'link_before'    	=> '<span class="screen-reader-text">',
				'link_after'     	=> '</span>',
			) );
		?>
		</div><!-- .social-profiles -->
	<?php endif;
}
/****************************************************************************************/
add_action( 'magcast_post_categories', 'magcast_post_categories_display' );
if( ! function_exists( 'magcast_post_categories_display' ) ):
	function magcast_post_categories_display() {
		global $post;
		$post_id = $post->ID;
		$categories_list = get_the_category($post_id);
		if( !empty( $categories_list ) ) {
				foreach ( $categories_list as $cat_data ) {
					$cat_name = $cat_data->name;
					$cat_id = $cat_data->term_id;
					$cat_link = get_category_link( $cat_id );
			?>
<a href="<?php echo esc_url( $cat_link ); ?>"><?php echo esc_html( $cat_name ); ?></a>
			<?php 
				}
		}
	}
endif; ?>
