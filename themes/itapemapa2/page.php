<?php
//
/**
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

get_header(); ?>

<div id="main-content" class="main-content">
<?php
//wp_dequeue_script( 'googleMapsAPI' );
//wp_dequeue_script( 'markerClusterer' );
//wp_enqueue_script('load-gmaps');
//wp_dequeue_script( 'bgmp' );
?>
<!--script src="https://maps.googleapis.com/maps/api/js"></script-->
	<style>
      #map {
        width: 500px;
        height: 400px;
      }

    </style>
<script>
jQuery( document ).ready(function($) {
  	function initialize() {
	    var mapCanvas = document.getElementById('map');
	    var mapOptions = {
	      center: new google.maps.LatLng(44.5403, -78.5463),
	      zoom: 8,
	      mapTypeId: google.maps.MapTypeId.ROADMAP
	    }

	    var map = new google.maps.Map(mapCanvas, mapOptions);
   	}
    //google.maps.event.addDomListener(window, 'load', initialize);
    //jQuery(ready).function({  });
    /*jQuery("label").each(function() {
    	$(this).hide();
    });*/
    jQuery(".wc-social-login").each(function(i) {
    	if(i==0)
    	$(this).appendTo($(this).parent());
    	else
    	$(this).hide();
    });
});
</script>



 <!--div id="map"></div-->



<?php
	if ( is_front_page() && twentyfourteen_has_featured_posts() ) {
		get_template_part( 'featured-content' );
	}
?>

	<div id="primary" class="content-area">
	
		<div id="content" class="site-content" role="main">
		<!--page.php-->
		<!-- Map Container -->
		
		<?php
		global $tipo_assinatura_filtrada;
		$tipo_assinatura_filtrada = "ouro";
		$t = explode("/", $_SERVER['REQUEST_URI']);
		
		//Em prod
		//echo "page.php /".$subpagina = $t[1];
		
		//var_dump(is_woocommerce());
		//echo is_woocommerce().is_shop();
		 if ( is_user_logged_in() ) { ?> 
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
			<?php //echo do_shortcode('[layerslider id="2"]'); ?>
			<?php //layerslider(2); ?>
			<?php echo do_shortcode('[woocommerce_my_account]'); ?>
		<?php } ?>
		</div><!-- #content -->
	</div><!-- #primary -->

	<?php 
	if ( is_user_logged_in() ) {

		if ($subpagina!=="minha-conta" && $subpagina!=="ranking" && $subpagina!=="agendar-visita") {
			if($subpagina=="loja" || $subpagina=="carrinho" || $subpagina="fechar-pedido")
				get_sidebar( 'loja' );
			else
				get_sidebar( 'content' );	
		}
	}
	?>

</div><!-- #main-content -->

<?php 
if ( is_user_logged_in()) {
	if($subpagina!=="fechar-pedido" && $subpagina!=="carrinho" && $subpagina!=="loja"  && $subpagina!=="minha-conta" && $subpagina!=="ranking" && $subpagina!=="agendar-visita")
	get_sidebar();
}
?>


<?php
get_footer();
