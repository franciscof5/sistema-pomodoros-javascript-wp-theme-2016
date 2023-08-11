<?php
/**
 * Template Name: Assine - Acessar empresas
 * @package WordPress
 * @subpackage Twenty_Fourteen
 * @since Twenty Fourteen 1.0
 */

get_header(); ?>

<div id="main-content" class="main-content">

<?php
	if ( is_front_page() && twentyfourteen_has_featured_posts() ) {
		// Include the featured content template.
		get_template_part( 'featured-content' );
	}
?>
	<div id="primary" class="content-area">
		<div id="content" class="site-content" role="main">
			<h3>Sua assinatura</h3>
			
			<?php 
			$tipo_assinatura = get_user_meta(get_current_user_id(), "tipo_assinatura", true);
			echo $tipo_assinatura;
			if($tipo_assinatura==null) { ?>
				<p>Você deseja se tornar um usuário premium, com liberdade para visualizar todas as informações 
				comerciais de todas as empresa? Veja abaixo os nosso planos:</p>
				<?php
				$ativar = $_GET['ativar'];
				echo $ativar;
				if($ativar) {
					update_user_meta(get_current_user_id(), "tipo_assinatura", "premium");
				}
				?>
			<?php } else if($tipo_assinatura=="premium"){ ?>
				<p>Voce ja e um assinante premium</p>
			<? } ?>

			<?php
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

		</div><!-- #content -->
	</div><!-- #primary -->
	<?php get_sidebar( 'content' ); ?>
</div><!-- #main-content -->

<?php
get_sidebar();
get_footer();
