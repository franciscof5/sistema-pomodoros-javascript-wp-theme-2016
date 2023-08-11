<?php
/**
 * Template Name: Minha Conta - Meus Ativos
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
			<h3>Meus ativos</h3>
			
			<?php  
			$args = array( 'post_type' => 'product', 'posts_per_page' => 0, 'product_cat' => 'divulgar-empresas' );

			$loop = new WP_Query( $args );
			while ( $loop->have_posts() ) : $loop->the_post(); 
			global $product; 
			echo '<br /><a href="'.get_permalink().'">' . woocommerce_get_product_thumbnail(array(30,30)).' '.the_title().'</a>';
			//echo $product->id;
			    echo " - ";
			echo $qty_atual = get_user_meta(get_current_user_id(), $product->id, true );
			echo "<br /><hr />";
			//var_dump($product);
			endwhile; 
			wp_reset_query(); 
			?>

			<?php  
			/*
			<h3>Minhas Assinaturas</h3>
			
			
			$args = array( 'post_type' => 'product', 'posts_per_page' => 0, 'product_cat' => 'divulgar-empresas' );

			$loop = new WP_Query( $args );
			while ( $loop->have_posts() ) : $loop->the_post(); 
			global $product; 
			echo '<br /><a href="'.get_permalink().'">' . woocommerce_get_product_thumbnail(array(30,30)).' '.the_title().'</a>';
			//echo $product->id;
			    echo " - ";
			echo $qty_atual = get_user_meta(get_current_user_id(), $product->id, true );
			echo "<br /><hr />";
			//var_dump($product);
			endwhile; 
			wp_reset_query(); */
			?>
		</div><!-- #content -->
	</div><!-- #primary -->
	<?php get_sidebar( 'content' ); ?>
</div><!-- #main-content -->

<?php
get_sidebar();
get_footer();
