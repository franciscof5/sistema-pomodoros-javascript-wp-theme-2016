<?php
/**
 * Displays the left sidebar of the theme.
 *
 * @package Theme Horse
 * @subpackage Magcast
 * @since Magcast 1.0
 */
?>
<?php
// Calling the left sidebar
	if ( is_active_sidebar( 'magcast_left_sidebar' ) ) :
		dynamic_sidebar( 'magcast_left_sidebar' );
	endif;
?>
