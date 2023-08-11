<?php
if ( !defined('__THEME__') ){
	define( '__THEME__', 'sw_maxshop'. get_locale() );
}

if ( !defined('SW_THEME') ){
	define( 'SW_THEME', 'sw_maxshop' );
}

/**
 * Variables
 */
require_once ( get_template_directory().'/lib/plugin-requirement.php' );			// Custom functions
require_once ( get_template_directory().'/lib/defines.php' );
require_once ( get_template_directory().'/lib/mobile-layout.php' );
require_once ( get_template_directory().'/lib/classes.php' );		// Utility functions
require_once ( get_template_directory().'/lib/utils.php' );			// Utility functions
require_once ( get_template_directory().'/lib/init.php' );			// Initial theme setup and constants
require_once ( get_template_directory().'/lib/cleanup.php' );		// Cleanup
require_once ( get_template_directory().'/lib/nav.php' );			// Custom nav modifications
require_once ( get_template_directory().'/lib/widgets.php' );		// Sidebars and widgets
require_once ( get_template_directory().'/lib/scripts.php' );		// Scripts and stylesheets
require_once ( get_template_directory().'/lib/metabox.php' );	// Custom functions

if( class_exists( 'OCDI_Plugin' ) ) :
	require_once ( get_template_directory().'/lib/import/sw-import.php' );
endif;

if( class_exists( 'WooCommerce' ) ){
	require_once ( get_template_directory().'/lib/plugins/currency-converter/currency-converter.php' ); // currency converter
	require_once ( get_template_directory().'/lib/woocommerce-hook.php' );	// Utility functions
	
	if( class_exists( 'WC_Vendors' ) ) :
		require_once ( get_template_directory().'/lib/wc-vendor-hook.php' );			/** WC Vendor **/
	endif;
	
	if( class_exists( 'WeDevs_Dokan' ) ) :
		require_once ( get_template_directory().'/lib/dokan-vendor-hook.php' );			/** Dokan Vendor **/
	endif;
}

add_filter( 'ya_widget_register', 'ya_add_custom_widgets' );
function ya_add_custom_widgets( $ya_widget_areas ){
	if( class_exists( 'sw_woo_search_widget' ) ){
		$ya_widget_areas[] = array(
			'name' => esc_html__('Widget Search', 'maxshop'),
			'id'   => 'search',
			'before_widget' => '<div class="widget %1$s %2$s"><div class="widget-inner">',
			'after_widget'  => '</div></div>',
			'before_title'  => '<h3>',
			'after_title'   => '</h3>'
		);
	}
	return $ya_widget_areas;
}

function ya_template_load( $template ){ 	
	if( class_exists( 'WooCommerce' ) ){
		if ( is_tax( 'product_cat' ) || is_post_type_archive( 'product' ) ) {				
			$template = get_template_part( 'archive', 'product' );
		}			
	}
	
	return $template;
}
add_filter( 'template_include', 'ya_template_load' );

function ya_remove_script_version( $src ){
$parts = explode( '?ver', $src );
return $parts[0];
}
add_filter( 'script_loader_src', 'ya_remove_script_version', 999999, 1 );

add_action( 'admin_init', 'ya_deactive_plugins' );
function ya_deactive_plugins(){
	deactivate_plugins( array( '/sw-partner-slider/sw-partner-sliderwidget.php', '/sw-responsive-post-slider/sw-resp-slider.php', '/sw-testimonial-slider/sw-testimonial-sliderwidget.php', '/sw_ourteam/sw-ourteam-widget.php' ) );
}