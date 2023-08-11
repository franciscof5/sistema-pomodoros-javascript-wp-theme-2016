<?php
// Check theme options for whether to show tagline

if( false === get_theme_mod( 'hide_slab' ) ) { ?>
	
	<div class="slab animated fadeIn">
	<div class="wrapper">
		<h1><?php echo get_theme_mod( 'home_slab' , "<span class='slabtext'>I am Wharton</span> <span class='slabtext'>I'm Lean <span class='amp'>&amp;</span> I'm Keen</span>" ); ?></h1>
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

<?php } ?>