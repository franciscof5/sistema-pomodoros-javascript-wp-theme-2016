<?php
/**
 * The front page template file
 *
 * If the user has selected a static page for their homepage, this is what will
 * appear.
 * Learn more: https://codex.wordpress.org/Template_Hierarchy
 *
 * @package WordPress
 * @subpackage Twenty_Seventeen
 * @since 1.0
 * @version 1.0
 */

get_header(); ?>

<div id="primary" class="content-area">
	<main id="main" class="site-main" role="main">
		<?php // Show the selected frontpage content.
		if($_SERVER["HTTP_HOST"]=="www.franciscomat.com") { ?>
			<style type="text/css">
				h3 {font-family: "lobster", Arial, Helvetica, sans-serif; margin-bottom: 0px; font-size: 30px; color: #67A8CB !important;}
				ul {padding-left: 10px;}
				ul li {
					font-size: 15px;
					padding-bottom: 4px;
				}
				hr {clear: both; background: #67A8CB !important;}
				.minha-thumb {
					width: 300px;
					height: 300px;
					border-radius: 200px;
					-webkit-transform: translate(-50%, -50%);  
	    			transform: translate(-50%, -50%); 
	    			position: absolute; 
	    			top: 50%; left: 50%;
				}
			</style>
			<div class="wrap">
				<div class="entry-content">
					<div style="padding-top: 20px;">
						<div class="col-md-6 col-sm-12" style="height: 360px;">
							<img src="https://www.franciscomat.com/wp-content/uploads/shared-wp-posts-uploads-dir/2017/08/fmm-frente.jpeg" alt="Foto de Francisco" class="align-middle minha-thumb">
							<!--p style="text-align: center;">My site for professional and personal stuff, simple things related to ME</p-->
						</div>

						<div class="col-md-6 col-sm-12">
							<h3>Blog Brasil</h3>
							<?php echo do_shortcode('[display-posts tag="lang-pt"]'); ?>
						</div>
					</div>

					<hr>

					<div class="col-md-6 col-sm-12">
						<h3>Blog Spañol</h3>
						<?php echo do_shortcode('[display-posts tag="lang-es"]'); ?>
					</div>

					<div class="col-md-6 col-sm-12">
						<h3>Blog USA</h3>
						<?php echo do_shortcode('[display-posts tag="lang-en"]'); ?>
					</div>

					<hr>

					<div class="col-md-6 col-sm-12">
						<h3>CursoWP</h3>
						<?php echo do_shortcode('[RSSImport feedurl="https://www.cursowp.com.br/feed/"]'); ?>
					</div>

					<div class="col-md-6 col-sm-12">
						<h3>Hortical</h3>
						<?php echo do_shortcode('[RSSImport feedurl="https://hortical.f5sites.com/feed/"]'); ?>
					</div>

					<hr>

					<div class="col-md-6 col-sm-12">
						<h3>Portfolio</h3>
						<?php echo do_shortcode('[RSSImport feedurl="https://portfolio.franciscomat.com/feed/"]'); ?>
					</div>
					
					<div class="col-md-6 col-sm-12">
						<h3>Pensamentos</h3>
						<?php echo do_shortcode('[RSSImport feedurl="https://pensamentos.franciscomat.com/feed/"]'); ?>
					</div>

					<hr>

					<div class="col-md-6 col-sm-12">
						<h3>Source</h3>
						<?php echo do_shortcode('[RSSImport feedurl="https://source.f5sites.com/feed/"]'); ?>
					</div>

					<p style="text-align: center;"><?php echo do_shortcode('[startups-links url="www.franciscomat.com"]'); ?></p>
					
				</div>
			</div>
		<? } else {
			if($_SERVER["HTTP_HOST"]=="portfolio.franciscomat.com") { ?>
			<style type="text/css">
				body .rt-tpg-container .rt-tpg-isotope-buttons .selected {
					background: #67A8CB !important;
				}
				.panel-content .wrap {
					padding-top: 0 !important;
				}
				.entry-header {
					display: none;
				}
				.entry-content {
					width: 100% !important;
				}
				.rt-tpg-container .isotope1 .rt-holder {
					position: relative;
					height: 320px !important;
					min-height: 320px !important;
					background: none !important;
				}
				.rt-tpg-container .isotope1 .rt-holder a {
					text-decoration: none !important;
					color: #FFF !important;
				}
				.rt-tpg-container .isotope1 .rt-holder .rt-detail {
					background: rgba(0,0,0,0.85);
					position: absolute;
					bottom: 60px;
					height: auto;
					width: 100%;
					padding-top: 4px !important;
				}
				.rt-tpg-container .isotope1 .rt-holder .post-meta-user,
				.rt-tpg-container .isotope1 .rt-holder .post-meta-tags {
					display: none !important;
				}
				.rt-tpg-container .isotope1 .rt-holder:hover .post-meta-user,
				.rt-tpg-container .isotope1 .rt-holder:hover .post-meta-tags {
					display: block !important;
				}
				.rt-tpg-container .isotope1 .rt-holder .entry-title a {
					color: #67A8CB !important;
					font-size: 20px;
					line-height: 30px;
				}
				.rt-tpg-container .isotope1 .rt-holder .date {
					color: #FFF !important;
					font-size: 16px;
				}
				.rt-equal-height {
					height: auto !important;
					min-height: auto !important;
				}
				.rt-tpg-container h2 {
					height: auto !important;
				}
				.rt-tpg-container h2 a {
					position: relative  !important;
				}
			</style>
			<?php }
			
			if ( have_posts() ) :
				while ( have_posts() ) : the_post();
					get_template_part( 'template-parts/page/content', 'front-page' );
				endwhile;
			else : // I'm not sure it's possible to have no posts when this page is shown, but WTH.
				get_template_part( 'template-parts/post/content', 'none' );
			endif; ?>

			<?php
			// Get each of our panels and show the post data.
			if ( 0 !== twentyseventeen_panel_count() || is_customize_preview() ) : // If we have pages to show.

				/**
				 * Filter number of front page sections in Twenty Seventeen.
				 *
				 * @since Twenty Seventeen 1.0
				 *
				 * @param int $num_sections Number of front page sections.
				 */
				$num_sections = apply_filters( 'twentyseventeen_front_page_sections', 4 );
				global $twentyseventeencounter;

				// Create a setting and control for each of the sections available in the theme.
				for ( $i = 1; $i < ( 1 + $num_sections ); $i++ ) {
					$twentyseventeencounter = $i;
					twentyseventeen_front_page_section( null, $i );
				}

			endif; // The if ( 0 !== twentyseventeen_panel_count() ) ends here. 
		}
		?>
		
	</main><!-- #main -->
</div><!-- #primary -->

<?php get_footer();
