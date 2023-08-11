<?php
/**
 * Template Name: Jobs Grid
 *
 **/

get_header(); ?>

<style type="text/css">
	.rt-tpg-container .isotope1 .rt-holder {
		position: relative;
	}
	.rt-tpg-container .isotope1 .rt-holder .rt-detail {
		background: rgba(0,0,0,0.7);
		position: absolute;
		bottom: 30px;
		height: auto;
		width: 100%;
	}
	.rt-tpg-container .isotope1 .rt-holder .post-meta-user {
		display: none;
	}
</style>

<div class="wrap">
	<div id="primary" class="content-area">
		<main id="main" class="site-main" role="main">

			<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
				<header class="entry-header">
					<?php the_title( '<h1 class="entry-title">', '</h1>' ); ?>
					<?php twentyseventeen_edit_link( get_the_ID() ); ?>
				</header><!-- .entry-header -->
				<div class="entry-content">
					<?php
						the_content();

						wp_link_pages( array(
							'before' => '<div class="page-links">' . __( 'Pages:', 'twentyseventeen' ),
							'after'  => '</div>',
						) );
					?>
				</div><!-- .entry-content -->
			</article><!-- #post-## -->

		</main><!-- #main -->
	</div><!-- #primary -->
</div><!-- .wrap -->

<?php get_footer();