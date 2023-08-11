<?php
/**
 * Displays the index section of the theme.
 *
 * @package Theme Horse
 * @subpackage Magcast
 * @since Magcast 1.0
 */
?>
<?php get_header(); ?>
	<?php
		/** 
		 * magcast_before_main_container hook
		 */
		do_action( 'magcast_before_main_container' );
		/** 
		 * magcast_main_container hook
		 *
		 * HOOKED_FUNCTION_NAME PRIORITY
		 *
		 * magcast_content 10
		 */
		do_action( 'magcast_main_container' );
		/** 
		 * magcast_after_main_container hook
		 */
		do_action( 'magcast_after_main_container' );
	?>
<?php get_footer(); ?>
