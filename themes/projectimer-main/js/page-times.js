jQuery( document ).ready(function($) {
		jQuery(".entry-header").hide();
		document.title = "Times | Focalizador";
		//teams (sites) - TABS navigation hack
		$(".page-id-43 .entry-title").text("Projectimer Teams");
		var span_qtty = $("#blogs-all a span").clone();
		$("#blogs-all a").text("Todos os Times ");
		$("#blogs-all a").append(span_qtty);
		var span_qtty = $("#blogs-personal a span").clone();
		$("#blogs-personal a").text("Meus Times");
		$("#blogs-personal a").append(span_qtty);
		$("#blog-create-nav a").text("Criar Time");
		$("#blogs_search").attr("placeholder", "Procurar times...");
		function update_screen_on_internal_tab_change() {
			$('[title="Visit Site"]').text("Team Dashboard");
			$('.action .meta').each(function(){
				var link = $(this).find("a").clone();
				if(link.text()) {
					$(this).html("Latest Task Done:");
					$(this).append(link);
				} else {
					$(this).html("No activities yet");
				}
			});
		}
		var newCountText = $("#blog-dir-count-top").text();
		newCountText = newCountText.slice(0,-7);
		newCountText += "teams";
		$("#blog-dir-count-top").text(newCountText);
		$("#blog-dir-count-bottom").text(newCountText);
		update_screen_on_internal_tab_change();
		jQuery( document ).ajaxComplete(function() {
			//alert("ajx");
			setTimeout(function() {update_screen_on_internal_tab_change()}, 200);
		});
		
		//wp-signup.php
		/*$('[for="signupblog"]').parent().parent().parent().parent().parent().parent().parent().parent().find(".nav-menu").hide();
		$('[for="signupblog"]').text("A free username and a Projectimer Team PRO Account (U$5,00/member/month)");
		$('[for="signupuser"]').text("Just a free username, I will join a Projectimer Team");
		$('for="blogname"]').text("Team URL");
		$('[for="blog_title"]').text("Team Name");*/
		//
		
	});
