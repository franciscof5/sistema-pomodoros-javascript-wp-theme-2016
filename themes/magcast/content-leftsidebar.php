<?php
/**
 * This file displays page with left sidebar.
 *
 * @package Theme Horse
 * @subpackage Magcast
 * @since Magcast 1.0
 */
?>
	<?php
	/**
	 * magcast_before_primary
	 */
	do_action('magcast_before_primary'); ?>
	<div id="primary">
	  <?php
	 if(is_page_template('page-templates/page-template-magazine.php')){ ?>
	 <div id="main">
	 	<?php if( is_active_sidebar( 'magcast_magazine_template_primary' ) ) :
			// Calling the footer sidebar
				dynamic_sidebar( 'magcast_magazine_template_primary' ); 
			endif; ?>
	</div><!-- #main -->
	<?php }else{
	 	/**
		 * magcast_before_loop_content
		 *
		 * HOOKED_FUNCTION_NAME PRIORITY
		 *
		 * magcast_loop_before 10
		 */
		do_action('magcast_before_loop_content');
		/**
		 * magcast_loop_content
		 *
		 * HOOKED_FUNCTION_NAME PRIORITY
		 *
		 * magcast_theloop 10
		 */
		do_action('magcast_loop_content');
		/**
		 * magcast_after_loop_content
		 *
		 * HOOKED_FUNCTION_NAME PRIORITY
		 *
		 * magcast_next_previous 5
		 * magcast_loop_after 10
		 */
		do_action('magcast_after_loop_content');
	 }
	 ?>
	</div><!-- #primary -->
	<?php
	/**
	 * magcast_after_primary
	 */
	do_action('magcast_after_primary'); ?>
		<div id="secondary">
	<?php
		  if (is_page_template('page-templates/page-template-contact.php')) {
		  	get_sidebar( 'contact-page' );
		  }elseif(is_page_template('page-templates/page-template-magazine.php')){
		  	if( is_active_sidebar( 'magcast_magazine_template_secondary' ) ) :
		  		dynamic_sidebar( 'magcast_magazine_template_secondary' );
		  	endif;
		  }else{
			get_sidebar('left');
			} ?>
		</div><!-- #secondary -->