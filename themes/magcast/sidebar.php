<?php
/**
 * The Sidebar containing the main widget area
 *
 * @package WordPress
 * @subpackage Magcast
 * @since Magcast 1.0
 */
?>
<?php
global $magcast_settings,$magcast_array_of_default_settings;
$magcast_settings = wp_parse_args(  get_option( 'magcast_theme_settings', array() ),  magcast_get_option_defaults() );
$magcast_content_layout = $magcast_settings['magcast_content_layout'];
if ( class_exists( 'WooCommerce' ) && is_woocommerce() && $magcast_content_layout == 'right' ){
	echo '<div id="secondary">';
	// Calling the right sidebar
	if ( is_active_sidebar( 'magcast_right_sidebar' ) ) :
		dynamic_sidebar( 'magcast_right_sidebar' );
	endif;
	echo '</div>';
}elseif( class_exists( 'WooCommerce' ) && is_woocommerce() && $magcast_content_layout == 'left' ){
	echo '<div id="secondary">';
	// Calling the left sidebar
	if ( is_active_sidebar( 'magcast_left_sidebar' ) ) :
		dynamic_sidebar( 'magcast_left_sidebar' );
	endif;
	echo '</div>';
}
if( !class_exists( 'WooCommerce' ) || ( class_exists( 'WooCommerce' ) && !is_woocommerce()) ){
// Calling the right sidebar
	if ( is_active_sidebar( 'magcast_right_sidebar' ) ) :
		dynamic_sidebar( 'magcast_right_sidebar' );
	endif;
}
?>
