if (window.jQuery) {
	//alert("not ready");//alert("versao do jquery is:"+jQuery.fn.jquery);
	jQuery( document ).ready(function($) {
		// header.php - Joga o link SAIR pra dentro do menu principal para nao quebrar em cel e tablet
		$('.nav-menu').children().last().find(".sub-menu").append($('.loginlogout'));

		//
		//if($(window).width()>670)
		//	$("#secondary").height($("#content").height()+100);//+header size

		// content-bgmp.php
		//$('#reply-title').html("Já esteve neste local? Comente sua experiência");

		// content.php - todo: outra gambiarra, tem que alterar o form de comments
		$('.form-allowed-tags').hide();

		// WOOCOMMERCE todo: melhorar essa linha, deveria estar em aa-itapemapa-funcoes.php em 
		$('.woocommerce-shipping-fields').find("h3").html("Seu endereço");
		
		// Organiza listas, separa o Ouro de Outros
		// COM ASSINATURA PLATINA (em taxonomy-categoria.php?)
		//$('<h3 style="margin-left:25px">Destaque da categoria</h3><ul id="assinantes_platina_list" class=""></ul><hr style="clear:both"/><h3 style="margin-left:25px">Assinantes ouro</h3><ul id="assinantes_ouro_list" class=""></ul><hr style="clear:both"/><h3 style="margin-left:25px">Outros</h3>').insertBefore('.bgmp_list');
		//$('.ouro').appendTo('#assinantes_ouro_list');
		
		/*
		var temp;
		$('.bgmp_list-item').bind('mouseenter', function(e) {
			//var visivel = $(this).find(".caixa-elementos").is(":visible");
			var caixaAssinatura = $(this).find(".aplicar-assinatura");
			var caixaRating = $(this).find(".caixa-elementos");
			if(caixaRating.is(":visible")) {
				//alert("over and time to show");
				temp = setTimeout(function() {
					//alert("1s"+$(this).parent().html());
					caixaAssinatura.show(200);
					//caixaRating.hide(2000);
					clearTimeout(temp);
				}, 2000);
			}
		});
		$('.bgmp_list-item').bind('mouseleave', function(e) {
			if($(this).find(".caixa-elementos").is(":visible")) {
				$(this).find(".aplicar-assinatura").hide();
				//$(this).find(".caixa-elementos").show();
				clearTimeout(temp);
			}
		});
		*/
		// Mostra somente assinantes OURO para usuarios nao logado
		if($('#usuario-nao-logado').length) {
			$('#bgmp_list').html('');
		}
		//$('.platina').prependTo('#assinantes_platina_list');

		// Aplicar-assinatura //ATUALMENTE O CODIGO QUE GERA AS CLASSES ABAIXO ESTA COMENTADO 2015-11
		/*$(".aplicar-assinatura").hide();
		//REALMENTE O CODIGO ABAIXO NAO USA
		$("#ativa-aplicar-assinatura").click(function() {
			//$(".aplicar-assinatura").toggle();
			if($(".aplicar-assinatura").is(":visible"))	{
				$(this).html("Aplicar Assinatura");
				$(".aplicar-assinatura").hide();
				$(".caixa-elementos").show();
			} else {
				$(this).html("Esconder Assinatura");
				$(".aplicar-assinatura").show();
				$(".caixa-elementos").hide();
			}
			
		});*/

		//
		
			
		//Remover POI (Points of Interst)
		var styles = [{featureType: "poi",stylers: [{ visibility: "off" }]}];
		if(typeof google != "undefined")
		var styledMap = new google.maps.StyledMapType(styles,{name: "Styled Map"});
		
		function pasteOverlayIndoorMapsImages() {
			//overlay image itapetininga shopping
			var bounds = new google.maps.LatLngBounds(
      			new google.maps.LatLng(-23.576958, -48.037038),
            	new google.maps.LatLng(-23.579013, -48.038315)
            );
            /*var imageMapType = new google.maps.ImageMapType({
			    getTileUrl: function(coord, zoom) {
				    /if (zoom < 17 || zoom > 20 ||
				        bounds[zoom][0][0] > coord.x || coord.x > bounds[zoom][0][1] ||
				        bounds[zoom][1][0] > coord.y || coord.y > bounds[zoom][1][1]) {
				        return null;
				    }/
				    if (zoom < 17 || zoom > 20) {
				    	return null;
				    }
				    return 'http://itapemapa.com.br/wp-content/uploads/2015/12/itapetininga-shopping-indoor.png';
				    //return ['http://www.gstatic.com/io2010maps/tiles/5/L2_',
				    //      zoom, '_', coord.x, '_', coord.y, '.png'].join('');
			    },
			    tileSize: new google.maps.Size(256,256)
			});*/
			//var pointSW = new GLatLng(-23.579334, -48.039341);
			//var pointNE = new GLatLng(-23.576551, -48.036390);

			var imageBounds = {
			    north: -23.576879,
			    south: -23.578989,
			    east: -48.036476,
			    west: -48.038761
			};

			  historicalOverlay = new google.maps.GroundOverlay(
			      'http://itapemapa.com.br/wp-content/uploads/2015/12/itapetininga-shopping-indoor.png',
			      imageBounds);
			  historicalOverlay.setMap($.bgmp.map);

			//$.bgmp.map.overlayMapTypes.push(imageMapType);
			/*var groundOverlay = new GGroundOverlay(
			   'http://itapemapa.com.br/wp-content/uploads/2015/12/itapetininga-shopping-indoor.png',
			   new GLatLngBounds(pointNE, pointSW)
			);

			$.bgmp.map.addOverlay(groundOverlay);*/
		}

		function waitForMapLoadToRemovePointOfInterst(){
			if(typeof $.bgmp.map !== "undefined"){
				$.bgmp.map.mapTypes.set('map_style', styledMap);
				$.bgmp.map.setMapTypeId('map_style');
				pasteOverlayIndoorMapsImages();																												pasteOverlayIndoorMapsImages();
			} else {
				setTimeout(function(){
					//console.log("ainda n");
					waitForMapLoadToRemovePointOfInterst();
				},250);
			}


		}

		if(typeof google != "undefined")
		waitForMapLoadToRemovePointOfInterst();
	});
} else {
	//alert("jQuery not loaded at all");
	console.log("jQuery not loaded at all");
}
