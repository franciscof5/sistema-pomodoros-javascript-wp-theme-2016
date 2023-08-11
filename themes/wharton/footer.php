
</section>
<?php 

if ( is_active_sidebar( 1 ) ) { ?>

<div class="footer-widgets">
	 <div class="wrapper">
<?php

	if (!function_exists('dynamic_sidebar') || !dynamic_sidebar('Footer Widget Area')) {  
	
	} ?>
	</div>
</div>

<?php	
} 

?>
<footer class="footer">
	
        <div class="wrapper">
        
             	<p class="copyright"> <span id="footer-text"><?php echo get_theme_mod( 'footer_tagline' , '&copy; 2014 Wharton. Built by <a href="http://www.meanthemes.com" target="_blank">MeanThemes</a>' ); ?></span></p>
             	
             	<?php
             		// Support for Zilla Social icons
             	 if( function_exists('zilla_social') ) zilla_social();
             	 
             	 // Just meant for the MeanThemes Social Widget
             	 if ( !function_exists('dynamic_sidebar') || !dynamic_sidebar('Social Footer Widget Area')) { ?>
             	 	
              	<?php } ?>
             	
        </div>
    </footer>
</div><!-- /wrap -->


<script> var ie9 = false; </script>
<!--[if lte IE 9 ]>   
<script> var ie9 = true; </script>
<![endif]-->
<?php
// Check theme options for using a standard menu
if( get_theme_mod( 'use_standard_menu', '0' ) == '1' ) { ?>
<script>
// Load MeanMenu
jQuery(document).ready(function() {  
	jQuery('header nav').meanmenu({ meanRevealPosition: "center", meanScreenWidth: <?php echo get_theme_mod( 'use_standard_menu_screenwidth', '767' ); ?> });
});
</script>
<?php } ?>
<?php wp_footer(); ?>
</body>
</html>