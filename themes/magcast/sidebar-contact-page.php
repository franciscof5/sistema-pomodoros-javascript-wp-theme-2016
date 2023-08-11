<?php
/**
 * Displays the sidebar on contact page template.
 *
 * @package Theme Horse
 * @subpackage Magcast
 * @since Magcast 1.0
 */
?>
<?php
// Calling the conatact page sidebar
	if ( is_active_sidebar( 'magcast_contact_page_sidebar' ) ) :
		dynamic_sidebar( 'magcast_contact_page_sidebar' );
	endif;
?>