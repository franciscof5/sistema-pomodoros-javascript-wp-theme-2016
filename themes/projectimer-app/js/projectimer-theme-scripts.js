//Francisco Matelli
jQuery().ready(function($) {
	/*$.each( "#header-content div span", function(index, value) {
		$(this).hide();
	});*/
	$( ".contem-icone " ).mouseenter(function() {
		if(!$(this).find( ".icone-legenda" ).is(":animated")) {
			//console.log("enter");
			//var contemIcone = $ (this);
			$(this).css("background-color", "rgba(0, 0, 0, 0.5)");
			$(this).find( ".icone-legenda" ).animate({width:'show'},150);

			/*.slideDown(400, function() {
				console.log("slideDown complete");
				/*$(this).mouseout(function() {
					console.log("mouseout1");
					//contemIcone.find( ".icone-legenda" ).slideUp(400);
					//$( ".icone-legenda" ).slideUp(400);
				});//*
				console.log(contemIcone.html());
				
			});*/
		} else {
			$(this).css("background-color", "rgba(0, 0, 0, 0.5)");
			$(this).find( ".icone-legenda" ).show();
			//$(this).find( ".icone-legenda" ).animate({width:'show'},0);;
		}
		/*$(this).*/
	});

	$( ".contem-icone " ).mouseleave(function() {
		//console.log("mouseout2");
		//contemIcone.find( ".icone-legenda" ).slideUp(400);
		//$( this ).find( ".icone-legenda" ).hide(400);
		$(this).css("background-color", "transparent");
		$( this ).find( ".icone-legenda" ).animate({width:'hide'},250);
		//.animate({width:'toggle'},350);
	});
	/*$( "#header " ).mouseleave(function() {
		$( ".icone-legenda" ).hide();
	});*/
	$( ".icone-legenda" ).hide();
	/*$( ".contem-icone" ).mouseout(function() {

		$(this).find( ".icone-legenda" ).slideUp(400);

		//$( ".icone-legenda" ).slideUp(400);
	});*/
	
	/*2016-09-30now in plugin $( "#settings_button" ).click(function() {
		$( "#projectimer_settingsbox" ).toggle("slow");
	});$( ".button_close" ).click(function() {
		$( "#projectimer_settingsbox" ).hide("slow");
	});*/
	
	if($("#loading-message").length) {
		i = 0;
		loading_animated = setInterval(function() {
		    i = ++i % 4;
		    $("#loading-message").find("p").html("loading"+Array(i+1).join("."));
		}, 200);
	}
	
});
