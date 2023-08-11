<?php
/**
 Template Name: Page - Home Alternative
 *
 * @package WordPress
 * @subpackage Wharton
 * @since Wharton 1.0
 */
get_header(); ?>
<?php get_header(); ?>
<?php if ( have_posts() ) while ( have_posts() ) : the_post(); ?>

<?php
$lead_colour_background = get_post_meta($post->ID, 'lead_colour_background', true);
	$lead_text_color = get_post_meta($post->ID, 'lead_text_color', true);
	$lead_p_background = get_post_meta($post->ID, 'lead_p_background', true);
	$lead_p_background_position = get_post_meta($post->ID, 'lead_p_background_position', true);
	$lead_p_background_opacity = get_post_meta($post->ID, 'lead_p_background_opacity', true);


	if ($lead_colour_background || $lead_text_color || $lead_p_background || $lead_p_background_position ) { ?>
	<style>	
	<?php
	
	if ($lead_colour_background) { ?>
	
		.home-alt { background-color: <?php echo $lead_colour_background; ?>;  }
	
	<?php	
	
	}
	
	if ($lead_p_background) { ?>
	
		.lead-image {
			<?php if ($lead_p_background !== "cover") { ?>
			background-size: auto;
			<?php } ?>
			background-repeat: <?php echo $lead_p_background; ?>;
		}
	
	
	<?php
	
	}
	
	if ($lead_p_background_position) { ?>
	
		.lead-image {
			background-position: <?php echo $lead_p_background_position; ?>;
		}
	
	<?php 
	
	}
	
	if ($lead_p_background_opacity) { ?>
	
		.lead-image {
			<?php echo $lead_p_background_opacity; ?>;
		}
	
	<?php 
	
	}
	
	if ($lead_text_color) { ?>
	
		.home-alt *, .home-alt a { color: <?php echo $lead_text_color; ?>; }
		
	<?php 		
	
	}
	 
	?>
	</style>
	
	<?php }
	
	 if ( has_post_thumbnail() ) { ?>
	  
	  <?php 
	  	// Get image
	  	$image = wp_get_attachment_image_src( get_post_thumbnail_id( $post->ID ), 'wide' );
	  	
	   ?>
	  	
	  
	  
	<?php } ?>  
	
	<div class="home-alt animated fadeIn">
	
		<div class="wrapper">
		
			<?php the_content(); ?>
			<?php wp_link_pages( array( 'before' => '<nav class="pagination">' . __( '<span>Pages:</span>', 'meanthemes' ), 'after' => '</nav>' ) ); ?>	
		
		</div>
		
	<?php
		 if ( has_post_thumbnail() ) { ?>
			<div class="lead-image" style="background-image: url(<?php if ( has_post_thumbnail() ) { echo $image[0]; } ?>);"></div>
	<?php } ?>
		
	</div>

<?php endwhile; wp_reset_query(); ?>
<?php

	// Set up global more for excerpts / more tag
	global $more; $more = 0;

	// Get the loop
 	get_template_part('loop'); 
 
 ?>
<?php get_footer();  ?>

