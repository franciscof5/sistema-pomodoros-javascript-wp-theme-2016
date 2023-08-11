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
 * @package GeneratePress
 */
 
// No direct access, please
if ( ! defined( 'ABSPATH' ) ) exit;

get_header(); ?>

<?php #do_shortcode('[rev_slider alias="slider-home"]'); 
wp_enqueue_script("jquery");
wp_enqueue_script("bootstrap-js", get_bloginfo("stylesheet_directory")."/assets/bootstrap.min.js");
wp_enqueue_style('bootstrap-css', get_bloginfo("stylesheet_directory")."/assets/bootstrap.min.css", __FILE__);
?>
<div id="carousel-example-generic" class="carousel slide" data-ride="carousel">
		<!-- Indicators -->
		<ol class="carousel-indicators">
			<li data-target="#carousel-example-generic" data-slide-to="0" class="active"></li>
			<li data-target="#carousel-example-generic" data-slide-to="1"></li>
			<li data-target="#carousel-example-generic" data-slide-to="2"></li>
			<li data-target="#carousel-example-generic" data-slide-to="3"></li>
			
		</ol>

		<!-- Wrapper for slides -->
		<div class="carousel-inner" role="listbox">
			<div class="item active">
				
				<img src="<?php bloginfo('stylesheet_directory'); ?>/slider-home/slide1.jpg" id="pomodoros-banner" alt="Calendar" class="img-responsive" style="width: 100%;">
				<?php /*<div class="middle-right thumb-display thumb-display-black">
					<p><i class="glyphicon glyphicon-calendar"></i> <?php _e("Perfomance Calendar", "sis-foca-js"); ?></p>
					<p class="hidden-xs"><?php _e("shows tasks you done", "sis-foca-js"); ?></p> 
				</div>*/ ?>
			</div>
			<div class="item">
				<img src="<?php bloginfo('stylesheet_directory'); ?>/slider-home/slide2.jpg" id="pomodoros-banner" alt="Ranking" class="img-responsive" style="width: 100%;">
				<?php /*<div class="middle-left thumb-display thumb-display-black">
					<p><i class="glyphicon glyphicon-list"></i> <?php _e("Grow in Ranking", "sis-foca-js"); ?></p>
					<p class="hidden-xs"><?php _e("and get more productive", "sis-foca-js"); ?></p> 
				</div>*/ ?>
			</div>
			<div class="item">
				<img src="<?php bloginfo('stylesheet_directory'); ?>/slider-home/slide3.jpg" id="pomodoros-banner" alt="Tasks" class="img-responsive" style="width: 100%;">
				<?php /*<div class="middle-right thumb-display thumb-display-black">
					<p><i class="glyphicon glyphicon-tags"></i> <?php _e("Mind blown reports", "sis-foca-js"); ?></p>
					<p class="hidden-xs"><?php _e("to check time usage", "sis-foca-js"); ?></p> 
				</div>*/ ?>
			</div>
			<div class="item">
				<img src="<?php bloginfo('stylesheet_directory'); ?>/slider-home/slide4.jpg" id="pomodoros-banner" alt="Support System" class="img-responsive" style="width: 100%;">
				<?php /*<div class="middle-right thumb-display thumb-display-black">
					<p><i class="glyphicon glyphicon-question-sign"></i> <?php _e("Open a ticket", "sis-foca-js"); ?></p>
					<p class="hidden-xs"><?php _e("and get help", "sis-foca-js"); ?></p> 
				</div>*/ ?>
			</div>
		</div>

		<!-- Controls -->
		<a class="left carousel-control" href="#carousel-example-generic" role="button" data-slide="prev">
			<span class="glyphicon glyphicon-chevron-left" aria-hidden="true"></span>
			<span class="sr-only"><?php _e("Previous", "sis-foca-js"); ?></span>
		</a>
		<a class="right carousel-control" href="#carousel-example-generic" role="button" data-slide="next">
			<span class="glyphicon glyphicon-chevron-right" aria-hidden="true"></span>
			<span class="sr-only"><?php _e("Next", "sis-foca-js"); ?></span>
		</a>
	</div>
	<div id="primary" <?php generate_content_class();?>>
		<main id="main" <?php generate_main_class(); ?>>
		<div class="row stats-com">
		<center><h2 class="forte"><i class="glyphicon glyphicon-signal"></i> Estatísticas da Comunidade</h2></center>
		<ul class="list-group stats-group col-sm-6">
			<li class="list-group-item active">
				<span class="badge">76</span>
				<i class="glyphicon glyphicon-user" aria-hidden="true"></i> &nbsp; Usuários Ativos			</li>
			<li class="list-group-item active">
				<span class="badge">9110</span>
				<i class="glyphicon glyphicon-ok"></i> &nbsp; Pomodoros feitos			</li>
			<li class="list-group-item active">
				<span class="badge">4555 h</span>
				<i class="glyphicon glyphicon-time"></i> &nbsp; Tempo cronometrado			</li>
		</ul>
		<ul class="list-group stats-group col-sm-6">
			<li class="list-group-item active">
				<span class="badge">527</span>
				<i class="glyphicon glyphicon-tags" aria-hidden="true"></i> &nbsp; Tags dos projetos			</li>
			<li class="list-group-item active">
				<span class="badge">11</span>
				<i class="glyphicon glyphicon-globe"></i> &nbsp; Cidades rankeadas			</li>
			<li class="list-group-item active">
				<span class="badge">5</span>
				<i class="glyphicon glyphicon-text-background"></i> &nbsp; Traduções			</li>
		</ul>
		<script>
			jQuery(document).ready(function() {
				jQuery(".stats-group li").mouseover(function() {
					jQuery(this).removeClass( "active" );
				}).mouseout(function() {
					jQuery(this).addClass( "active " );
				});
			});
		</script>
	</div>
		<?php do_action( 'generate_before_main_content' ); ?>
		<?php if ( have_posts() ) : ?>

			<?php /* Start the Loop */ ?>
			<?php while ( have_posts() ) : the_post(); ?>

				<?php
					/* Include the Post-Format-specific template for the content.
					 * If you want to override this in a child theme, then include a file
					 * called content-___.php (where ___ is the Post Format name) and that will be used instead.
					 */
					get_template_part( 'content', get_post_format() );
				?>

			<?php endwhile; ?>

			<?php generate_content_nav( 'nav-below' ); ?>

		<?php else : ?>

			<?php get_template_part( 'no-results', 'index' ); ?>

		<?php endif; ?>
		<?php do_action( 'generate_after_main_content' ); ?>
		</main><!-- #main -->
	</div><!-- #primary -->

<script>
	$('.carousel').carousel({
		interval: 3000
	})
</script>
</script>

<?php 
do_action( 'generate_sidebars' );
get_footer();