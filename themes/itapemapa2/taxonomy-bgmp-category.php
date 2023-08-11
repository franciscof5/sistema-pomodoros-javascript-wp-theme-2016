<?php
/**
 * The template for displaying Archive pages
 *
 * Used to display archive-type pages if nothing more specific matches a query.
 * For example, puts together date-based pages if no date.php file exists.
 *
 * If you'd like to further customize these archive views, you may create a
 * new template file for each specific one. For example, Twenty Fourteen
 * already has tag.php for Tag archives, category.php for Category archives,
 * and author.php for Author archives.
 *
 * @link http://codex.wordpress.org/Template_Hierarchy
 *
 * @package WordPress
 * @subpackage Twenty_Fourteen
 * @since Twenty Fourteen 1.0gfd
 */

get_header(); ?>
<?php 
//var_dump($_SERVER['REQUEST_URI']);
if($_GET["bgmp-category"]) {
	$catAtual = $_GET["bgmp-category"];
} else {
	$t = explode("/", $_SERVER['REQUEST_URI']);
	$catAtual = $t[2];
}

/*foreach ( $_GET as $key => $value ) {
	$catAtual = $value;
}*/
?>
	<section id="primary" class="content-area">
		<div id="content" class="site-content" role="main">
			<?php
			echo do_shortcode('[bgmp-map categories="'.$catAtual.'" width="100%" height="400"]');
			echo do_shortcode('[bgmp-list categories="'.$catAtual.'"]');
			?>
			<?php /*if ( have_posts() ) : ?>
			<header class="page-header">
				<h1 class="page-title">
					<?php

						/*if ( is_day() ) :
							printf( __( 'Daily Archives: %s', 'twentyfourteen' ), get_the_date() );

						elseif ( is_month() ) :
							printf( __( 'Monthly Archives: %s', 'twentyfourteen' ), get_the_date( _x( 'F Y', 'monthly archives date format', 'twentyfourteen' ) ) );

						elseif ( is_year() ) :
							printf( __( 'Yearly Archives: %s', 'twentyfourteen' ), get_the_date( _x( 'Y', 'yearly archives date format', 'twentyfourteen' ) ) );

						else :
							_e( 'Archives', 'twentyfourteen' );

						endif;
					?>
				</h1>
			</header><!-- .page-header -->

				
<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
	
	<div class="entry-content">
		<?php
			echo do_shortcode('[bgmp-map categories="'.$catAtual.'" width="100%" height="500"]');
			echo do_shortcode('[bgmp-list categories="'.$catAtual.'"]');
			?>
	</div><!-- .entry-content -->
	
	</article><!-- #post-## -->
				<?php
					// Start the Loop.
					/*while ( have_posts() ) : the_post();

						
						get_template_part( 'content', get_post_format() );

					endwhile;
					// Previous/next page navigation.
					twentyfourteen_paging_nav();
				
				else :
					// If no content, include the "No posts found" template.
					get_template_part( 'content', 'none' );

				endif;*/
			?>
		</div><!-- #content -->
	</section><!-- #primary -->

<?php
get_sidebar( 'content' );
get_sidebar();
get_footer();
