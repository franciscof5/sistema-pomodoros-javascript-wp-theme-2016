<?php
/**
 * Template Name: Magazine Template
 *
 * Displays the Magazine Layout of the theme.
 *
 * @package Theme Horse
 * @subpackage Magcast
 *0@since Magcast 1.0
 */
?>
<?php get_header(); ?>
	<?php
		/** 
		 * magcast_before_main_container hook
		 */
		do_action( 'magcast_before_main_container' );
		/** 
		 * magcast_magazine_template_content hook
		 *
		 * HOOKED_FUNCTION_NAME PRIORITY
		 *
		 * magcast_display_business_template_content 10
		 */
		do_action( 'magcast_magazine_template_content' );
		/** 
		 * magcast_after_main_container hook
		 */
		do_action( 'magcast_after_main_container' );
	?>
<?php get_footer(); ?>
