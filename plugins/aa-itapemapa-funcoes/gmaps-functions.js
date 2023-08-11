jQuery( document ).ready(function($) {
	//alert( "foi"+pontos.startLat);
	//alert("foi");
	geocoder = new google.maps.Geocoder();
	var address = document.getElementById('billing_address_1').value;
	
	var startLat;
	var startLong;
	var tudo = Array();
	var pontos = $('.bgmp_list-item');
	var R = 6371; // km
	geocoder.geocode( { 'address': address}, function(results, status) {
		if (status == google.maps.GeocoderStatus.OK) {
			//$("#selecionaOrdenacao").attr('disabled','disabled');
			startLat = results[0].geometry.location.lat();
			startLong = results[0].geometry.location.lng();
			for( var x = 0, len = pontos.length; x < len; x++ ) {
				var endLat = parseFloat( pontos.eq( x ).find( '#casa_lat' ).val() );
				var endLong = parseFloat( pontos.eq( x ).find( '#casa_lon' ).val() );
				var position = new google.maps.LatLng( endLat, endLong );
				var dLat = (endLat-startLat) * (Math.PI/180); //.toRad();
				var dLon = (endLong-startLong) * (Math.PI/180); //.toRad();
				var lat1 = startLat * (Math.PI/180); //.toRad(); lat1.toRad();
				var lat2 = endLat * (Math.PI/180);
				//
				var a = Math.sin(dLat/2) * Math.sin(dLat/2) + Math.sin(dLon/2) * Math.sin(dLon/2) * Math.cos(lat1) * Math.cos(lat2); 
				var c = 2 * Math.atan2(Math.sqrt(a), Math.sqrt(1-a)); 
				var d = (R * c);
				d = d.toFixed(2);
				tudo.push(Array(Math.round(d),position));
				pontos.eq( x ).find( '.distancia-casa' ).html(d);
			}
			$('#selecionaOrdenacao option[value="selCarregando"]').remove();
			$("#selecionaOrdenacao").removeAttr('disabled');
			//$('#selecionaOrdenacao').prop('disabled', false);
		} else {
			alert("Geocode was not successful for the following reason: " + status);
		}
	});
	//ORDENACAO
	function orderarPorNome () {
		var listaDeCaixasOuro = $('#assinantes_ouro_list .bgmp_list-item');
		var listaDeCaixasOutros = $('#bgmp_list .bgmp_list-item');
		listaDeCaixasOuro.sort(function(a, b) {
			return $(a).find('.bgmp_list-placemark-title').text().toUpperCase().localeCompare($(b).find('.bgmp_list-placemark-title' ).text().toUpperCase());
		});
		listaDeCaixasOutros.sort(function(a, b) {
			return $(a).find('.bgmp_list-placemark-title').text().toUpperCase().localeCompare($(b).find('.bgmp_list-placemark-title' ).text().toUpperCase());
		});
		$('#assinantes_ouro_list').html(listaDeCaixasOuro);
		$('#bgmp_list').html(listaDeCaixasOutros);
		$('.prata').prependTo('#bgmp_list');
	}

	function orderarPorDistancia () {
		var listaDeCaixasOuro = $('#assinantes_ouro_list .bgmp_list-item');
		var listaDeCaixasOutros = $('#bgmp_list .bgmp_list-item');
		//var listaDeCaixasOuro = $('#assinantes_ouro_list').find('.bgmp_list-item');
		listaDeCaixasOuro.sort(function(a, b) {
			if (a.a === b.a) return parseFloat($(a).find('.distancia-casa' ).text()) > parseFloat($(b).find('.distancia-casa' ).text()) ? 1 : -1;
			if (a.a > b.a) return 1;
			return -1;
		});
		listaDeCaixasOutros.sort(function(a, b) {
			if (a.a === b.a) return parseFloat($(a).find('.distancia-casa' ).text()) > parseFloat($(b).find('.distancia-casa' ).text()) ? 1 : -1;
			if (a.a > b.a) return 1;
			return -1;
		});
		$('#assinantes_ouro_list').html(listaDeCaixasOuro);
		$('#bgmp_list').html(listaDeCaixasOutros);
	}
	
	function ordernarPorAvaliacao () {
		var listaDeCaixasOuro = $('#assinantes_ouro_list .bgmp_list-item');
		var listaDeCaixasOutros = $('#bgmp_list .bgmp_list-item');
		
		listaDeCaixasOuro.sort(function(b, a) {
			if (a.a === b.a) return parseFloat($(a).find(".post-ratings").find("img").attr("onmouseout").slice( 12, 13 )) > parseFloat($(b).find(".post-ratings").find("img").attr("onmouseout").slice( 12, 13 )) ? 1 : -1;
			if (a.a > b.a) return 1;
			return -1;
		});
		listaDeCaixasOutros.sort(function(b, a) {
			//console.log("ATT" + $(a).find(".post-ratings").find("img").attr("onmouseout"));
			//console.log("SEM FLOAT" + $(a).find(".post-ratings").find("img").attr("onmouseout").slice( 12, 15 ));
			//console.log("COM FLOAT" + parseFloat($(a).find(".post-ratings").find("img").attr("onmouseout").slice( 12, 15 )));
			if (a.a === b.a) return parseFloat($(a).find(".post-ratings").find("img").attr("onmouseout").slice( 12, 15 )) > parseFloat($(b).find(".post-ratings").find("img").attr("onmouseout").slice( 12, 15 )) ? 1 : -1;
			if (a.a > b.a) return 1;
			return -1;
		});
		$('#assinantes_ouro_list').html(listaDeCaixasOuro);
		$('#bgmp_list').html(listaDeCaixasOutros);
		//$('.prata').prependTo('#bgmp_list');
	}
	$('#selecionaOrdenacao').change( function() {
		var valor = $( this ).val();
		if(valor=="pordistancia") {
			orderarPorDistancia ();
		} else if(valor=="pornome") {
			orderarPorNome ();
		} else if(valor=="poravaliacao") {
			ordernarPorAvaliacao ();
		}
	});
	//
	var rendererOptions = {
		map: $.bgmp.map,
		suppressMarkers: true,
	}
	directionsDisplay = new google.maps.DirectionsRenderer(rendererOptions);
	directionsDisplay.setPanel(document.getElementById('directionsPanel'));
	directionsService = new google.maps.DirectionsService();
});
var directionsDisplay;
var directionsService;
function tracarRota(endPoint) {
	var startPoint = document.getElementById('billing_address_1').value;
	jQuery( document ).ready(function($) {
		$("#bgmp_map-canvas").width("70%");
		$("#directionsPanel").width("30%");
		//$("#bgmp_map-canvas").focus();
		$(window).scrollTop($('#bgmp_map-canvas').offset().top-50);
		var request = {
			origin: startPoint,
			destination: endPoint,
			travelMode: google.maps.TravelMode.DRIVING
		};
		directionsService.route(request, function(result, status) {
			if (status == google.maps.DirectionsStatus.OK) {
				directionsDisplay.setDirections(result);
			}
		}); 
	});
}