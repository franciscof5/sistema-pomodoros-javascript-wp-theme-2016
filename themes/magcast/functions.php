<?php
/**
 * Magcast defining constants, adding files and WordPress core functionality.
 *
 * Defining some constants, loading all the required files and Adding some core functionality.
 * @uses add_theme_support() To add support for post thumbnails and automatic feed links.
 * @uses register_nav_menu() To add support for navigation menu.
 *
 * @package Theme Horse
 * @subpackage Magcast
 * @since Magcast 1.0
 */
	add_action('after_setup_theme', 'magcast_setup');
	/**
	 * This content width is based on the theme structure and style.
	 */
	function magcast_setup()
	{
		global $content_width;
		if (!isset($content_width)) {
			$content_width = 770;
		}
	}
		add_action('magcast_init', 'magcast_constants', 10);
		/**
		 * This function defines the Magcast theme constants
		 *
		 * @since 1.0
		 */
	function magcast_constants()
	{
		/** Define Directory Location Constants */
		define('MAGCAST_PARENT_DIR', get_template_directory());
		define('MAGCAST_CHILD_DIR', get_stylesheet_directory());
		define('MAGCAST_INC_DIR', MAGCAST_PARENT_DIR . '/inc');
		define('MAGCAST_ADMIN_DIR', MAGCAST_INC_DIR . '/admin');
		define('MAGCAST_JS_DIR', MAGCAST_PARENT_DIR . '/js');
		define('MAGCAST_FUNCTIONS_DIR', MAGCAST_INC_DIR . '/functions');
		define('MAGCAST_SHORTCODES_DIR', MAGCAST_INC_DIR . '/footer-info');
		define('MAGCAST_STRUCTURE_DIR', MAGCAST_INC_DIR . '/structure');
		if (!defined('MAGCAST_LANGUAGES_DIR'))
		/** So we can define with a child theme */ {
			define('MAGCAST_LANGUAGES_DIR', MAGCAST_PARENT_DIR . '/languages');
		}
		define('MAGCAST_WIDGETS_DIR', MAGCAST_INC_DIR . '/widgets');
	}
		add_action('magcast_init', 'magcast_load_files', 15);
		/**
		 * Loading the included files.
		 *
		 * @since 1.0
		 */
	function magcast_load_files()
	{
		/**
		 * magcast_add_files hook
		 *
		 * Adding other addtional files if needed.
		 */
		do_action('magcast_add_files');
		/** Load functions */
		require_once (MAGCAST_FUNCTIONS_DIR . '/i18n.php');

		require_once (MAGCAST_FUNCTIONS_DIR . '/custom-header.php');

		require_once (MAGCAST_FUNCTIONS_DIR . '/functions.php');

		require_once (MAGCAST_FUNCTIONS_DIR . '/customizer.php');
		require_once (MAGCAST_ADMIN_DIR . '/magcast-metaboxes.php');

		/** Load Footer Info */
		require_once (MAGCAST_SHORTCODES_DIR . '/magcast-footer-info.php');

		/** Load Structure */
		require_once (MAGCAST_STRUCTURE_DIR . '/header-extensions.php');

		require_once (MAGCAST_STRUCTURE_DIR . '/footer-extensions.php');

		require_once (MAGCAST_STRUCTURE_DIR . '/content-extensions.php');

		/** Load Widgets and Widgetized Area */
		require_once (MAGCAST_WIDGETS_DIR . '/magcast-widgets.php');

	}
	add_action('magcast_init', 'magcast_core_functionality', 20);
	/**
	 * Adding the core functionality of WordPess.
	 *
	 * @since 1.0
	 */
	function magcast_core_functionality()
	{
		/**
		 * magcast_add_functionality hook
		 *
		 * Adding other addtional functionality if needed.
		 */
		do_action('magcast_add_functionality');
		// Add default posts and comments RSS feed links to head
		add_theme_support('automatic-feed-links');
		/*
		* Let WordPress manage the document title.
		* By adding theme support, we declare that this theme does not use a
		* hard-coded <title> tag in the document head, and expect WordPress to
		* provide it for us.
		*/
		add_theme_support('title-tag');
		// This theme uses Featured Images (also known as post thumbnails) for per-post/per-page.
		add_theme_support('post-thumbnails');
		// This theme uses wp_nav_menu() in two locations.
		register_nav_menus(array(
			'primary' => __('Primary Navigation', 'magcast') ,
			'social' => __('Social Navigation', 'magcast') ,
			'left-section' => __('Top Left Section Navigation', 'magcast') ,
			'right-section' => __('Top Right Section Navigation', 'magcast') ,
		));
		// Add magcast custom image sizes
		add_image_size( 'magcast-slider-image', 666, 810, true );
		add_image_size( 'magcast-slider-image-two', 1024, 608, true );
		add_image_size( 'magcast-large-thumb', 965, 575, true );
		add_image_size( 'magcast-small-thumb', 467, 350, true );

		// Support for WooCommerce Product gallery
		add_theme_support( 'wc-product-gallery-zoom' );
		add_theme_support( 'wc-product-gallery-lightbox' );
		add_theme_support( 'wc-product-gallery-slider' );

		/* 
		* Enable support for custom logo. 
		* 
		*/ 
		add_theme_support( 'custom-logo', array( 
			'height'      => 100, 
			'width'       => 260, 
			'flex-height' => true,
			'flex-width' => true,
		) );
		// Indicate widget sidebars can use selective refresh in the Customizer. 
		add_theme_support( 'customize-selective-refresh-widgets' );
		/**
		 * This theme supports custom background color and image
		 */
		add_theme_support('custom-background');
	}
		/**
		 * magcast_init hook
		 *
		 * Hooking some functions of functions.php file to this action hook.
		 */
		do_action('magcast_init');
	function magcast_get_featured_posts()
	{
		/**
		 * Filter the featured posts to return in Magcast.
		 * @param array|bool $posts Array of featured posts, otherwise false.
		 */
		return apply_filters('magcast_get_featured_posts', array());
	}
		/**
		 * A helper conditional function that returns a boolean value.
		 * @return bool Whether there are featured posts.
		 */
	function magcast_has_featured_posts()
	{
		return !is_paged() && (bool)magcast_get_featured_posts();
	}
function magcast_get_option_defaults() {
	global $magcast_array_of_default_settings;
	$magcast_array_of_default_settings = array(
		'magcast_disable_slider' => 1,
		'magcast_slider_quantity' =>'4',
		'magcast_featured_post_slider'	=> array(),
		'magcast_slider_type'	=> 'post-slider',
		'magcast_categories'	=>array(),
		'magcast_exclude_slider_post' =>0,
		'magcast_disable_setting'	=>0,
		'magcast_design_layout' =>'on',
		'magcast_search_header_settings' =>1,
		'magcast_site_title_setting' => 0,
		'magcast-img-upload-site-title' => '',
		'magcast_content_layout' => 'right',
		'magcast_dropdown_categories'=>array(),
		'magcast_hide_highligted_options'=> 'off',
		'magcast_post_num_highligted'=>'3',
		'magcast_highligted_title'=>'',
		'magcast_hide_header_social_icon'=>0,
		'magcast_hide_footer_social_icon'=>0,
		'magcast_hide_date'=>0,
		'magcast_hide_infobar'=>0,
		'magcast_hide_top_search'=>0,
		'magcast_header_design'=>'sitetitle_social_icons_search',
		'magcast_hide_slider_date'=>0,
		'magcast_hide_slider_author'=>0,
	);
	return apply_filters( 'magcast_get_option_defaults', $magcast_array_of_default_settings );
}
add_action( 'after_setup_theme', 'magcast_woocommerce_support' );
function magcast_woocommerce_support() {
    add_theme_support( 'woocommerce' );
}
remove_action( 'woocommerce_before_main_content', 'woocommerce_output_content_wrapper', 10);

remove_action( 'woocommerce_after_main_content', 'woocommerce_output_content_wrapper_end', 10);


add_action('woocommerce_before_main_content', 'magcast_wrapper_start', 10);
add_action('woocommerce_after_main_content', 'magcast_wrapper_end', 10);
function magcast_wrapper_start() { echo '<div id="primary"> <div id="main">'; }

function magcast_wrapper_end() { echo '</div></div>'; }


if ( ! function_exists( 'magcast_the_custom_logo' ) ) : 
	/** 
	 * Displays the optional custom logo. 
	 * 
	 * Does nothing if the custom logo is not available. 
	 */ 
	function magcast_the_custom_logo() { 
	    if ( function_exists( 'the_custom_logo' ) ) { 
	        the_custom_logo(); 
	    } 
	} 
endif;
/*********** Sanitize Checkbox on widgets *****************/
function magcast_sanitize_checkbox( $checked ) {
    // Boolean check.
	return ( ( isset( $checked ) && true == $checked ) ? true : false );
}
?>