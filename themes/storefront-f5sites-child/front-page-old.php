<?php
/**
 * The main template file.
 *
 * This is the most generic template file in a WordPress theme
 * and one of the two required files for a theme (the other being style.css).
 * It is used to display a page when nothing more specific matches a query.
 * E.g., it puts together the home page when no home.php file exists.
 * Learn more: http://codex.wordpress.org/Template_Hierarchy
 *
 * @package storefront
 */

get_header(); ?>

<?php if(is_blog() || is_singular( 'post' )) { ?>
	<div id="primary" class="content-area" style="width: 70%;">
		<main id="main" class="site-main" role="main">


			<h1>Preços & Planos</h1>

			<p>Soluções completas para projetos.</p>

			<?php 
			#var_dump($wp_query);die;
			#force_database_aditional_tables_share($wp_query);
			echo do_shortcode('[product id="3316"]');
			echo do_shortcode('[product id="3313"]');
			echo do_shortcode('[product id="3286"]');
			echo do_shortcode('[product id="3542"]');
			echo do_shortcode('[product id="3403"]');
			echo do_shortcode('[product id="3917"]');
			#die(); ?>

			<?php #if ( have_posts() ) :

				#get_template_part( 'loop' );
			#endif; ?>

		</main><!-- #main -->
	</div><!-- #primary -->
	<div id="secondary" class="widget-area col-md-3" role="complementary" style="width: 30%;">
		BLOG
		<?php 
		if(function_exists("smartlang_recent_posts_georefer_widget")) {
			smartlang_recent_posts_georefer_widget();
			$user_prefered_language_prefix;
		}
		#the_widget("Recent_Posts_Widget_Extended", "limit=20"); 
		?>
	</div>
<?php } else { ?>


	<div id="primary" class="content-area">
		<main id="main" class="site-main" role="main">

		<?php if ( have_posts() ) :

			get_template_part( 'loop' );

		else :

			get_template_part( 'content', 'none' );

		endif; ?>

		</main><!-- #main -->
	</div><!-- #primary -->

<?php
}
#do_action( 'storefront_sidebar' );
get_footer();
