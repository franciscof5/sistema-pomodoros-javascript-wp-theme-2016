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

<div class="row">
	<iframe width="560" height="315" src="https://www.youtube.com/embed/2IVrCxG1rW8" frameborder="0" allow="accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
</div>

<div class="row">
	<h2>O treinamento que vai ajudar você a:</h2>
	<ol style="color: #000; list-style: none; font-size: 24px; font-family: lobster; width: 100%;">
		<li><i class="glyphicon glyphicon-dashboard"></i> Ser mais produtivo!</li>
		<li style="text-align: right;">Passar no vestibular? <i class="glyphicon glyphicon-education"></i></li>
		<li><i class="glyphicon glyphicon-flash"></i> Aprender um novo idioma em pouco tempo!</li>
		<li style="text-align: right;">Controlar tempo de funcionários! <i class="glyphicon glyphicon-time"></i></li>
	</ol>
	<h2>Descubra nosso exclusivo método:</h2>
	<h3><a href="/contato"><i class="glyphicon glyphicon-envelope"></i> Entre em contato agora mesmo!</a></h3>
</div>

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
		<li data-target="#carousel-example-generic" data-slide-to="4"></li>
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
		<div class="item">
			<img src="<?php bloginfo('stylesheet_directory'); ?>/slider-home/slide5.jpg" id="pomodoros-banner" alt="Palestra Skill Itapetininga" class="img-responsive" style="width: 100%;">
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

<div class="row" style="margin-top:40px;">
	<div class="col-sm-8 col-md-offset-2">
		<div class="col-md-3 blob">
			<img src="<?php bloginfo('stylesheet_directory'); ?>/img/icons8-treinamento-100.png" >
			<h4>Palestra</h4>
		</div>
		<div class="col-md-3 blob">
			<img src="<?php bloginfo('stylesheet_directory'); ?>/img/icons8-licenca-100.png" >
			<h4>Cursos</h4>
		</div>
		<div class="col-md-3 blob">
			<img src="<?php bloginfo('stylesheet_directory'); ?>/img/icons8-placa-de-sinalizacao-100.png" >
			<h4>Acompanhamento</h4>
		</div>
		<div class="col-md-3 blob">
			<img src="<?php bloginfo('stylesheet_directory'); ?>/img/icons8-smartphone-100.png" >
			<h4>EAD</h4>
		</div>
	</div>
</div>

<div class="row">
		<h2 class="forte"><i class="glyphicon glyphicon-signal"></i> Estatísticas</h2>
		<ul class="col-sm-8 col-md-offset-2">
			<li class="list-group-item">
				<span class="badge">+250</span>
				<i class="glyphicon glyphicon-user" aria-hidden="true"></i> &nbsp; Pessoas Treinadas</li>
			<li class="list-group-item">
				<span class="badge">+7</span>
				<i class="glyphicon glyphicon-ok"></i> &nbsp; Palestras Realizadas</li>
			<li class="list-group-item">
				<span class="badge">2</span>
				<i class="glyphicon glyphicon-globe"></i> &nbsp; Cidades Atendidas			</li>
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
	<div id="primary" <?php generate_content_class();?>>
		<main id="DDDmain" <?php #generate_main_class(); ?> class="col-sm-8 col-md-offset-2 front-page">
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