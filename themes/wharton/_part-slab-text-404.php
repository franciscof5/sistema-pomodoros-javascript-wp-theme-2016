<div class="slab animated fadeIn">
	<div class="wrapper">
		<h1><?php echo get_theme_mod( 'home_slab_404' , '<span class="slabtext">No Page Here</span> <span class="slabtext">Oh Dear!</span>' ); ?></h1>
	</div>
	<script src="//ajax.googleapis.com/ajax/libs/webfont/1/webfont.js"></script>
	<script>
		jQuery(function() {
		    WebFont.load({
		        custom: {
		            families: ['LeagueGothicRegular'], // font-family name
		            urls : ['<?php echo get_template_directory_uri(); ?>/webfonts/leaguegothic.css'] // URL to css
		        },
		        active: function() {
		            jQuery('.slab h1').slabText({  "viewportBreakpoint":300 });
		        }
		    });
		});
	</script>
</div>