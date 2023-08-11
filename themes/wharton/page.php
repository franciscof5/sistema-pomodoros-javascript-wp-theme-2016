<?php get_header(); ?>
<?php if ( have_posts() ) while ( have_posts() ) : the_post(); ?>
    <?php 
           get_template_part( '_part' , 'content-page' );
     ?>
<?php endwhile; ?>
<?php get_footer(); ?>