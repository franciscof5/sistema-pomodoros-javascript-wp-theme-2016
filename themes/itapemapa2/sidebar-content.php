<?php
/**
 * The Content Sidebar
 *
 * @package WordPress
 * @subpackage Twenty_Fourteen
 * @since Twenty Fourteen 1.0
 */

if ( ! is_active_sidebar( 'sidebar-2' ) ) {
	return;
}
?>
<div id="content-sidebar" class="content-sidebar widget-area" role="complementary">

	<?php
	if(is_woocommerce())
		dynamic_sidebar( 'sidebar-5' ); 
	else
		dynamic_sidebar( 'sidebar-2' ); 
	?>
</div><!-- #content-sidebar -->
