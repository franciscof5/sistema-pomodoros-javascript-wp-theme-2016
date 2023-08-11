<?php
/**
 * Adds footer structures.
 *
 * @package Theme Horse
 * @subpackage Magcast
 * @since Magcast 1.0
 * @license http://www.opensource.org/licenses/gpl-license.php GPL v2.0 (or later)
 * @link http://themehorse.com/themes/magcast
 */
/****************************************************************************************/
add_action( 'magcast_footer', 'magcast_footer_widget_area', 15 );
/** 
 * Displays the footer widgets
 */
function magcast_footer_widget_area() {
	get_sidebar( 'footer' );
}
/****************************************************************************************/
add_action( 'magcast_footer', 'magcast_open_siteinfo_div', 20 );
/**
 * Opens the site generator div.
 */
function magcast_open_siteinfo_div() { ?>
	<div class="site-info clearfix">
		<div class="container">
<?php }
/****************************************************************************************/
add_action( 'magcast_footer', 'magcast_socialnetworks', 25 );
/**
 * This function for social links display on footer
 *
 */
function magcast_socialnetworks(){
	global $magcast_settings;
	if($magcast_settings['magcast_hide_footer_social_icon'] ==0){
		magcast_display_social_icons();
	}
}
/****************************************************************************************/
add_action( 'magcast_footer', 'magcast_footer_info', 30 );
/**
 * function to show the footer info, copyright information
 */
function magcast_footer_info() {      
	$output = '<div class="copyright">'.__( 'Copyright &copy;', 'magcast' ).' '.magcast_the_year().' '.magcast_site_link().' | ' .magcast_themehorse_link().' | '.' ' .magcast_wp_link() .'</div><!-- .copyright -->';
	echo $output;
}
/****************************************************************************************/
add_action( 'magcast_footer', 'magcast_close_siteinfo_div', 40 );
/**
 * Shows the back to top icon to go to top.
 */
function magcast_close_siteinfo_div() { ?>
	</div><!-- .site-info -->
</div><!-- .container -->
<?php }
/****************************************************************************************/
add_action( 'magcast_footer', 'magcast_backtotop_html', 45 );
/**
 * Shows the back to top icon to go to top.
 */
function magcast_backtotop_html() { ?>
	<div class="back-to-top"><a title="<?php esc_attr_e('Go to Top', 'magcast');?>" href="#masthead"></a></div><!-- .back-to-top -->
<?php } ?>
