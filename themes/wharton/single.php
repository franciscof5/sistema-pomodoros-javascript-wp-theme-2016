<?php get_header(); ?>
<?php if ( have_posts() ) while ( have_posts() ) : the_post(); ?>


<?php if( get_theme_mod( 'use_subtle_layout', '0' ) == '1' ) { ?>
	<div class="content-wrapper">
<?php } ?>

<?php if( get_theme_mod( 'hide_sidebar', '1' ) == '0' ) { 
	if( get_theme_mod( 'alt_sidebar', '1' ) == '0' ) { ?>
	<div class="content-hold">
<?php 
	}
}	
?>	

    <?php 
    // decide on post format and load it if you find it
    
        if(!get_post_format()) {
           get_template_part('post-formats/content', 'standard');
        } else {
           get_template_part('post-formats/content', get_post_format());
        }
    
     ?>
<?php endwhile; ?>


<?php if( get_theme_mod( 'hide_sidebar', '1' ) == '0' ) { 
	if( get_theme_mod( 'alt_sidebar', '1' ) == '0' ) { ?>
</div>

<?php 

	get_sidebar();

	}
}	
?>	

<?php if( get_theme_mod( 'use_subtle_layout', '0' ) == '1' ) {
// content-wrapper
 ?>
	</div>
<?php } ?>


<?php get_template_part('_part', 'nav-prev-next'); ?>
<?php get_footer(); ?>