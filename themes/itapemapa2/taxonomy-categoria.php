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
//var_dump($_SERVER['REQUEST_URI']);die;
if(isset($_GET["bgmp-category"])) {
	$catAtual = $_GET["bgmp-category"];
} else {
	$t = explode("/", $_SERVER['REQUEST_URI']);
	$catAtual = $t[2];
}
/*foreach ( $_GET as $key => $value ) {
	$catAtual = $value;
}*/

//GLOBAL $adressCasa;

?>
<?php //wp_enqueue_script('gmaps-functions'); ?>
<?php //wp_enqueue_script('modal-plugin'); ?>

<style type="text/css">
	
	.site-content {
		/*margin:0 !important;*/
	}

</style>

<script type="text/javascript">
	//jQuery.ready(function($) {	});
</script>

	<section id="primary" class="content-area">

		<div id="content" class="site-content taxonomy-categoria" role="main" style="margin-right:0;">
			<!--taxonomy-categoria.php-->
			<div id="directionsPanel">&nbsp;</div>
			<?php 
				//var_dump($catAtual);
				echo do_shortcode('[bgmp-map categories="'.$catAtual.'" width="100%" height="400"]');
			?>

			<!--a href="#">Gostaria de enviar um email para todos as empresas desta lista.</a-->
			
			<?php if ( is_user_logged_in() ) { ?>
				<?php $adressCasa = get_user_meta(get_current_user_id(), "billing_address_1", true); ?>
				<div class="sua-casa">
					<img src='<?php echo bloginfo("template_directory") ?>/images/home-pin/home_pin.png' alt="sua casa icone">
					<label>Sua casa:</label>
					<input type="text" value="<?php echo $adressCasa ?>" alt="Sua casa" id="billing_address_1"></input>
				</div>
				<select id="selecionaOrdenacao" disabled>
					<option value="selCarregando" selected="selected">carregando...</option>
					<option value="pornome">Ordenar por nome</option>
					<option value="pordistancia">Ordenar por distância</option>
					<option value="poravaliacao">Ordenar por avaliação</option>
				</select>
				<!--br />
				<a id="ativa-aplicar-assinatura">Ativar Assinatura</a-->
			<?php } else { ?>
				<p style="margin-left:10px">Aonde você está? <a href="/">crie uma conta e informe seu endereço</a>.</p>
			<?php } ?>
			
			<?php
				echo do_shortcode('[bgmp-list categories="'.$catAtual.'"]');
			?>

			<?php /*if ( !is_user_logged_in() ) { ?>
				<?php //QUANDO USAVA JQUERY echo '<ul id="usuario-nao-logado"></ul>'; ?>
				<ul id="usuario-nao-logado"></ul>
				<p style="margin-left:10px">Para ver os outros locais <a href="/">crie uma conta e acesse o sistema</a>.</p>
				<p style="margin-left:10px">Com uma conta voce pode visualizar o endereço e o telefone dos assinantes Comercial, Bronze e Prata.</p>
			<?php }*/ ?>
		</div><!-- #content -->
	</section><!-- #primary -->

<div id="aplicar-assinatura-confirmacao-modal" >
	<span class="button b-close"><span>X</span></span>
	<h3>NOME DO LOCAL</h3>
	<p id="assinatura-atual">Atualmente este local possui uma assinatura do tipo: OURO</p>
	<p id="assinatura-descricao">Voce esta tentando aplicar uma assinatura do tipo: GRATUITO</p>
	<p id="assinatura-opcao">Essa operacao nao e permitida, voce soh pode aplicar um plano superior</p>
	<button id="assinatura-acao">Aplicar Assinatura</button>
	<button id="fechar-modal" class="botaoFechar">Fechar</button>
	<p><div id="resposta_servidor"></div></p>
</div>

<script>
jQuery( document ).ready(function($) {
		//alert("h:"+$(document).height());
		//if($(window).width()>670)
		//	$("#secondary").height($(document).height()-50-400);
		/*ALOHA
		var $ = Aloha.jQuery;
		aloha(document.querySelector(".editable"));*/
		/**/
		$('<h3 class="bgmp_list_h3">Assinantes ouro</h3><ul id="assinantes_ouro_list" class=""></ul><br style="clear:both"/><h3 class="bgmp_list_h3">Outros</h3>').insertBefore('.bgmp_list');
		if($('.ouro').length>0) {
			$('.ouro').appendTo('#assinantes_ouro_list');
		} else {
			$('#assinantes_ouro_list').html('<p style="margin-bottom:-50px">Seja o primeiro Assinante Ouro desta sub-categoria, <a href="/?p=6804" alt="criar uma conta Itapemapa">conheça nossos planos</a></p>');
		}
		$('.prata').prependTo('#bgmp_list');
		//TODO: ESPECIAL FUNCTION BECAUSE WHEN CHANGE ABOVE CHANGE OVERALL #CONTENT HEIGHT (moved to sidebar.php)
		//if($(window).width()>670)
		//	$("#secondary").height($("#content").height()+20);

	//function codeAddress() {
	var addressCasa = "<?php echo $adressCasa; ?>";
	if(""!=addressCasa && typeof google != "undefined") {
		geocoder = new google.maps.Geocoder();
		var markerCasa = new google.maps.Marker({
			title: "Sua casa",
			icon: '<?php echo bloginfo("template_directory") ?>/images/home-pin/home_pin.png',
		});
		var inputAdressCasa = document.getElementById('billing_address_1');
		var autocompleteCasa = new google.maps.places.Autocomplete(inputAdressCasa);
		//var sw = new google.maps.LatLng(-23.741061, -48.460350);
		//var ne = new google.maps.LatLng(-23.391127, -47.806664);
		//var bounds = new google.maps.LatLngBounds(sw, ne);
		//autocompleteCasa.setBounds(bounds);
		geocoder.geocode( { 'address': addressCasa}, function(results, status) {
			if (status == google.maps.GeocoderStatus.OK) {
				$.bgmp.map.setCenter(results[0].geometry.location);
				/*var marker = new google.maps.Marker({
					map: $.bgmp.map,
					position: results[0].geometry.location,
					title: "Sua casa",
					icon: '<?php echo bloginfo("template_directory") ?>/images/home-pin/home_pin.png',
				});*/
				markerCasa.setMap($.bgmp.map);
				markerCasa.setPosition(results[0].geometry.location);

				//autocompleteCasa.bindTo('bounds', $.bgmp.map);
				
				google.maps.event.addListener(autocompleteCasa, 'place_changed', function() {
					alteraAdressCasa();
				});


				

			} else {
				alert("1Geocode was not successful for the following reason: " + status);
			}
		});
	}

	
	
	/*var infowindow = new google.maps.InfoWindow();
	var marker = new google.maps.Marker({
		map: $.bgmp.map,
		anchorPoint: new google.maps.Point(0, -29)
	});*/

	function alteraAdressCasa () {
		//infowindow.close();
		markerCasa.setVisible(false);
		var place = autocompleteCasa.getPlace();
		if (!place.geometry) {
	  		return;
		}

		// If the place has a geometry, then present it on a map.
		if (place.geometry.viewport) {
			$.bgmp.map.fitBounds(place.geometry.viewport);
		} else {
			$.bgmp.map.setCenter(place.geometry.location);
			$.bgmp.map.setZoom(15);  // Why 17? Because it looks good.
		}
		/*marker.setIcon(({
			url: place.icon,
			size: new google.maps.Size(71, 71),
			origin: new google.maps.Point(0, 0),
			anchor: new google.maps.Point(17, 34),
			scaledSize: new google.maps.Size(35, 35)
		}));*/
		markerCasa.setPosition(place.geometry.location);
		markerCasa.setVisible(true);

		var address = '';
		if (place.address_components) {
		  address = [
		    (place.address_components[0] && place.address_components[0].short_name || ''),
		    (place.address_components[1] && place.address_components[1].short_name || ''),
		    (place.address_components[2] && place.address_components[2].short_name || '')
		  ].join(' ');
		}

		var ajaxurl = "<?php echo admin_url('admin-ajax.php') ?>";
		var data = {
			action: 'atualiza_endereco',
			endereco: $("#billing_address_1").attr("value"),
			userid: <?php echo get_current_user_id() ?>,
		};
		$.post( ajaxurl, data, function( response) {
			if(!response)
				alert("Erro ao atulizar o endereço da sua casa");
		});
		//infowindow.setContent('<div><strong>' + place.name + '</strong><br>' + address);
		//infowindow.open($.bgmp.map, marker);
	}
});
</script>

<?php
//DESATIVADO POR ENQUANTO get_sidebar( 'mapa' ); //mostraria ranking da categoria
get_sidebar();

get_footer();

?>
