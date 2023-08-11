<?php
/**
 * The Template for displaying all single posts
 *
 * @package WordPress
 * @subpackage Twenty_Fourteen
 * @since Twenty Fourteen 1.0
 */

get_header(); ?>

	<div id="primary" class="content-area">
	<!--single.php-->
		<?php
		
		#var_dump(get_post_type());die;

		if(get_post_type()!=="bgmp")
			echo '<div id="content" class="site-content" role="main">';


		else
			echo '<div id="content" class="site-content-DESATIVADO" role="main">';
		?>
			<?php
				// Start the Loop.
				while ( have_posts() ) : the_post();

					/*
					 * Include the post format-specific template for the content. If you want to
					 * use this in a child theme, then include a file called called content-___.php
					 * (where ___ is the post format) and that will be used instead.
					 */
					
					if(get_post_type()=="bgmp")
						get_template_part( 'content-bgmp' );
					else
						get_template_part( 'content', get_post_format() );

					// Previous/next post navigation.
					twentyfourteen_post_nav();

					// If comments are open or we have at least one comment, load up the comment template.
					if ( comments_open() || get_comments_number() ) {
						comments_template();
					}
				endwhile;
			?>
		</div><!-- #content -->
	</div><!-- #primary -->

<?php //get_sidebar( 'content' ); ?>

<?php if ( is_user_logged_in() && (get_post_type()!=="bgmp")) { ?> 
	<?php get_sidebar( 'content' ); ?>
<?php } ?>

<?php get_footer(); ?>
