<?php
/**
 * Template Name: Full Width Page
 *
 * @package WordPress
 * @subpackage Twenty_Fourteen
 * @since Twenty Fourteen 1.0
 */

get_header(); ?>

<style type="text/css">
	@media screen and (min-width: 1008px) {
	.site-content {
		margin:0 !important;
	}
}
</style>

<div id="main-content" class="main-content">

<?php
	if ( is_front_page() && twentyfourteen_has_featured_posts() ) {
		// Include the featured content template.
		get_template_part( 'featured-content' );
	}
	
?>

	<div id="primary" class="content-area">
			<div id="content" class="site-content" role="main" style="width:80%;margin:0 auto !important;">
			<?php if ( is_user_logged_in() ) { ?> 
				<?php
					// Start the Loop.
					while ( have_posts() ) : the_post();

						// Include the page content template.
						get_template_part( 'content', 'page' );

						// If comments are open or we have at least one comment, load up the comment template.
						if ( comments_open() || get_comments_number() ) {
							comments_template();
						}
					endwhile;
				?>
			<?php } else { ?>
				<?php echo do_shortcode('[layerslider id="2"]'); ?>
				<?php //layerslider(2); ?>
				<?php echo do_shortcode('[woocommerce_my_account]'); ?>
		<?php } ?>
		</div><!-- #content -->
	</div><!-- #primary -->
</div><!-- #main-content -->

<?php
//get_sidebar();
get_footer();
