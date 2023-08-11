<?php
/**
 * Template Name: Indicar Local
 */

get_header(); ?>

<?php 
/*wp_deregister_script( 'googleMapsAPI' );
wp_deregister_script( 'markerClusterer' );
wp_deregister_script( 'bgmp' );*/
//
//wp_register_script('googlemaps', 'http://maps.googleapis.com/maps/api/js?' . $locale . '&key=' . GOOGLE_MAPS_V3_API_KEY . '&sensor=false&libraries=places', false, '3');
//wp_enqueue_script('googlemaps');
//
//$mapvars = array( 'lat' => get_option( 'bgmp_map-latitude' ), 'lon' => get_option( 'bgmp_map-longitude' ) );
//wp_localize_script( 'load-gmaps', 'mapvar', $mapvars );
//


?>

<div id="main-content" class="main-content">

<?php
/*	if ( is_front_page() && twentyfourteen_has_featured_posts() ) {
		// Include the featured content template.
		get_template_part( 'featured-content' );
	}*/
?>
	<div id="primary" class="content-area">
		<div id="content" class="site-content-DESATIVADO" role="main">
		<article class="page type-page status-publish hentry">
			<header class="entry-header">
				<h1 class="entry-title">Indicar Local</h1>
			</header><!-- .entry-header -->
			<div class="entry-content">
			<p>Conhece um local que ainda não está no mapa? Indique para gente </p><!-- se os dados correspondem a um local verdadeiro te daremos uma <a href="<?php bloginfo(url)?>/produto/assinatura-comercial/">Assinatura Comercial</a> de brinde(*).</p-->
			<hr />
			<div id="resposta_servidor"></div>
			
			<?php if ( !is_user_logged_in() ) { ?>
				<p>Para indicar um local <a href="/">crie uma conta e acesse o sistema</a>.</p>
			<?php } if ( is_user_logged_in() )  { ?>
				<div style="float:left;width:45%;min-width:200px;">
					<h3>Nome do Local</h3>
					<input type="text" id="novolocal_nome" name="s">
					<div id="key"></div>

					<h3>Telefone</h3>
					<input type="text" id="novolocal_telefone" name="novolocal_telefone">
			
					<h3 fot="novolocal_endereco">Endereço (c número)</h3>
					<input id="novolocal_endereco" class="controls" type="text" placeholder="Escreva o endereço...">

				</div>

				<div style="float:left;width:45%;min-width:200px;">
					<h3>Categoria</h3>
					<?php 
					//wp_list_categories( "taxonomy=categoria&child_of=175&hierachical=17&title_li=&show_count=0&echo=1" );
					$categories = get_categories('taxonomy=categoria&hierachical=false&parent=175&title_li=&show_count=0&echo=1');  
					foreach($categories as $category) {
						echo "<input type='radio' name='novolocal_categoria' value='$category->term_id' />";    
						echo $category->cat_name;
						echo '<br>';
					}
					?>
					<br />
					
				</div>
				<button id="indicar_local" name="indicar_local" >Indicar local</button>
				<br style="clear:both; margin: 20px 0;" />
				<div id="map-canvas">mapa</div>
				<div class="sua-casa">
					<?php $adressCasa = get_user_meta(get_current_user_id(), "billing_address_1", true); ?>
					<img src='<?php echo bloginfo("template_directory") ?>/images/home-pin/home_pin.png' alt="sua casa icone">
					<label>Sua casa:</label>
					<input type="text" value="<?php echo $adressCasa ?>" alt="Sua casa" id="billing_address_1"></input>
				</div>
				<br />
				&nbsp;
				<br />
				<p> (*) Daremos uma Assinatura Comercial por local indicado e aprovado</p>
				<!--p>Receber um email assim que este local for aprovado</p-->
				<p> (**) Para utilizar uma assinatura neste novo local, aguarde ate ele ser aprovado</p>

			<?php } //if user logged in ?>
			</div>
		</div><!-- #content -->
	</div><!-- #primary -->
	<?php //get_sidebar( 'content' ); ?>
</div><!-- #main-content -->


<?php
wp_enqueue_script('load-gmaps');
wp_enqueue_script('mascara-campos');
?>


<script type="text/javascript">

//AJAX
jQuery(document).ready(function($) {
	//MASCARA
	//var msk = ;
	$("#novolocal_telefone").mask("(99) 9999-9999");
	/*$("#novolocal_telefone").blur(function(e) {
	        $(this).unmask(mask);
	   }
	});*/
	//AJAX SUBMIT LOCAL
	$("#indicar_local").click(function() {
		
		$("#indicar_local").attr('disabled','disabled');
		$("#indicar_local").html('enviando...');
		//
		$("#resposta_servidor").html('<div class="avisoHolder avisoAtencao"><p>Enviando os dados para o servidor<p></div>');
		
		var ajaxurl = "<?php echo admin_url('admin-ajax.php') ?>";
		$("#novolocal_telefone").unmask();
	 	var data = {
			action: 'insert_placemark_frontend',
			nome: $("#novolocal_nome").attr("value"),
			//telefone: $("#novolocal_telefone").attr("value"),
			telefone: $("#novolocal_telefone").val(),
			endereco: $("#novolocal_endereco").attr("value"),
			categoria: $('input[name=novolocal_categoria]:checked').val(),
			indicadorID: <?php echo get_current_user_id() ?>,
		};
	 	$.post( ajaxurl, data, function( response) {
			$("#resposta_servidor").html( response );
			$("#indicar_local").html('Indicar Local');
			$("#indicar_local").removeAttr('disabled');
			/*$("#novolocal_nome").attr("value", "");
			$("#novolocal_telefone").attr("value", "");
			$("#novolocal_endereco").attr("value", "");*/
			$("#novolocal_telefone").mask("(99) 9999-9999");
		});
	});

	var mapOptions = {
		zoom: 14,
		scrollwheel: false,
		draggable: false,
		mapTypeId: google.maps.MapTypeId.ROADMAP,
	};
	var map = new google.maps.Map(document.getElementById('map-canvas'), mapOptions);

	// Casa do usuario
	var addressCasa = "<?php echo $adressCasa; ?>";
	
	if(""!=addressCasa) {
		geocoder = new google.maps.Geocoder();
		var markerCasa = new google.maps.Marker({
			title: "Sua casa",
			icon: '<?php echo bloginfo("template_directory") ?>/images/home-pin/home_pin.png',
		});
		var inputAdressCasa = document.getElementById('billing_address_1');
		var autocompleteCasa = new google.maps.places.Autocomplete(inputAdressCasa);
		geocoder.geocode( { 'address': addressCasa}, function(results, status) {
			if (status == google.maps.GeocoderStatus.OK) {
				map.setCenter(results[0].geometry.location);
				markerCasa.setMap(map);
				markerCasa.setPosition(results[0].geometry.location);
				
				autocompleteCasa.bindTo('bounds', map);
				
				google.maps.event.addListener(autocompleteCasa, 'place_changed', function() {
					alteraAdressCasa();
				});

			} else {
				alert("Geocode was not successful for the following reason: " + status);
			}
		});
	} else {
		alert("Erro ao carregar seu endereço");
	}

	function alteraAdressCasa () {
		markerCasa.setVisible(false);
		var place = autocompleteCasa.getPlace();
		if (!place.geometry) {
	  		return;
		}

		// If the place has a geometry, then present it on a map.
		if (place.geometry.viewport) {
			map.fitBounds(place.geometry.viewport);
		} else {
			map.setCenter(place.geometry.location);
			map.setZoom(15);  // Why 17? Because it looks good.
		}
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
	}

	var inputAdressNovoLocal = document.getElementById('novolocal_endereco');
	var autocompleteNovoLocal = new google.maps.places.Autocomplete(inputAdressNovoLocal);
	autocompleteNovoLocal.bindTo('bounds', map);
	var markerNovoLocal = new google.maps.Marker({
		map: map,
		anchorPoint: new google.maps.Point(0, -29)
	});
	function alteraAdressNovoLocal () {
		markerNovoLocal.setVisible(false);
		var place = autocompleteNovoLocal.getPlace();
		if (!place.geometry) {
	  	return;
		}

		// If the place has a geometry, then present it on a map.
		if (place.geometry.viewport) {
			map.fitBounds(place.geometry.viewport);
		} else {
			map.setCenter(place.geometry.location);
			map.setZoom(15);  // Why 17? Because it looks good.
		}
		markerNovoLocal.setIcon(/** @type {google.maps.Icon} */({
			url: place.icon,
			size: new google.maps.Size(71, 71),
			origin: new google.maps.Point(0, 0),
			anchor: new google.maps.Point(17, 34),
			scaledSize: new google.maps.Size(35, 35)
		}));
		markerNovoLocal.setPosition(place.geometry.location);
		markerNovoLocal.setVisible(true);

		var address = '';
		if (place.address_components) {
		  address = [
		    (place.address_components[0] && place.address_components[0].short_name || ''),
		    (place.address_components[1] && place.address_components[1].short_name || ''),
		    (place.address_components[2] && place.address_components[2].short_name || '')
		  ].join(' ');
		}
	}

	google.maps.event.addListener(autocompleteNovoLocal, 'place_changed', function() {
		alteraAdressNovoLocal();
	});
});
</script>

<?php
//get_sidebar();
get_footer();
