<?php

/**
 * Template Name: Mapa de Locais
 * The template for displaying all pages
 *
 * This is the template that displays all pages by default.
 * Please note that this is the WordPress construct of pages and that
 * other 'pages' on your WordPress site will use a different template.
 *
 * @package WordPress
 * @subpackage Twenty_Fourteen
 * @since Twenty Fourteen 1.0
 */

get_header(); 

?>
<style type="text/css">
	h3 {
		margin: 20px 30px 10px !important;
	}
</style>

<?php 
//mask for phone
if(!is_user_logged_in()) {
wp_enqueue_script('load-gmaps');
wp_enqueue_script('mascara-campos');
?>
	<script type="text/javascript">
	jQuery(document).ready(function($) {
		//MASCARA
		//var msk = ;
		$("#reg_billing_phone").mask("(99) 99999-9999");
		$('[for="reg_billing_phone"]').html('Celular <span class="required">*</span>');
		//
		//TODO: ESPECIAL FUNCTION BECAUSE WHEN CHANGE ABOVE CHANGE OVERALL #CONTENT HEIGHT (moved to sidebar.php)
		//if($(window).width()>670)
		//	$("#secondary").height($("#content").height()+20);
		//
		
	});
	</script>
<?php } ?>
<script type="text/javascript">
	jQuery(document).ready(function($) {
		//MASCARA
		//var msk = ;
		//
		//TODO: ESPECIAL FUNCTION BECAUSE WHEN CHANGE ABOVE CHANGE OVERALL #CONTENT HEIGHT
		if($(window).width()>670)
			$("#secondary").height($("#content").height()+20);
		//
		
	});
	</script>
<div id="main-content" class="main-content">

	<div id="primary" class="content-area">
		
		<div id="content" class="site-content" role="main" style="margin-right:0;">
		<!-- Map Container -->
		<!--mapa-de-locais.php-->
		<?php
		global $tipo_assinatura_filtrada;
		$tipo_assinatura_filtrada = "ouro";
		$t = explode("/", $_SERVER['REQUEST_URI']);
		echo $subpagina = $t[1];
		//echo is_woocommerce().is_shop();
		if ( is_user_logged_in() ) { ?> 
			<?php
			echo do_shortcode('[bgmp-map categories="alimentacao,beleza,comercio,servicos,casa-e-construcao,shoppings" width="100%" height="400"]');
			echo '<p style="margin:10px 30px -10px 30px;">Confira a nossa lista de assinantes ouro</p>';
			echo '<h3>Alimentação</h3>';
			echo do_shortcode('[bgmp-list categories="alimentacao"]');
			echo '<h3>Beleza</h3>';
			echo do_shortcode('[bgmp-list categories="beleza"]');
			echo '<h3>Comércio</h3>';
			echo do_shortcode('[bgmp-list categories="comercio"]');
			echo '<h3>Serviços</h3>';
			echo do_shortcode('[bgmp-list categories="servicos"]');
			echo '<h3>Casa e Construção</h3>';
			echo do_shortcode('[bgmp-list categories="casa-e-construcao"]');
				// Start the Loop.
				/*while ( have_posts() ) : the_post();

					// Include the page content template.
					get_template_part( 'content', 'page' );

					// If comments are open or we have at least one comment, load up the comment template.
					if ( comments_open() || get_comments_number() ) {
						comments_template();
					}
				endwhile;*/
		?>
		<?php } else { ?>
			<?php //echo do_shortcode('[layerslider id="2"]'); ?>
			<?php //layerslider(2); ?>
			<?php echo do_shortcode('[woocommerce_my_account]'); ?>
		<?php } ?>
		</div><!-- #content -->
	</div><!-- #primary -->

	<?php 
	/*
	if($subpagina=="loja")
		get_sidebar( 'loja' );
	else
		get_sidebar( 'content' );
	*/
	?>
</div><!-- #main-content -->

<?php if ( is_user_logged_in() ) { ?> 
	<?php get_sidebar(); ?>
<?php } ?>


<?php
get_footer();
