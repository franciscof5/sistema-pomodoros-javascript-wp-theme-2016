<?php
/**
 * Template Name: Contact Page Template
 *
 * Displays the contact page template.
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
		 * magcast_contact_page_template_content hook
		 *
		 * HOOKED_FUNCTION_NAME PRIORITY
		 *
		 * magcast_display_contact_page_template_content 10
		 */
		do_action( 'magcast_contact_page_template_content' );
		/** 
		 * magcast_after_main_container hook
		 */
		do_action( 'magcast_after_main_container' );
	?>
<?php get_footer(); ?>
