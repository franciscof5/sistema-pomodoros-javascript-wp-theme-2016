<?php

if ( get_theme_mod( 'use_subtle_layout', '0' ) == '0' ) {

	// Get Lead settings from custom meta
		$lead_colour_background = get_post_meta($post->ID, 'lead_colour_background', true);
		$lead_text_color = get_post_meta($post->ID, 'lead_text_color', true);
		$lead_p_background = get_post_meta($post->ID, 'lead_p_background', true);
		$lead_p_background_position = get_post_meta($post->ID, 'lead_p_background_position', true);
		$lead_p_background_opacity = get_post_meta($post->ID, 'lead_p_background_opacity', true);

	?>
	<?php
		if ($lead_colour_background || $lead_text_color || $lead_p_background || $lead_p_background_position ) { ?>
		<style>
		<?php
		if ($lead_colour_background) { ?>
			.lead { background-color: <?php echo $lead_colour_background; ?>;  }
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
			.lead h1, body time, .lead .meta.top, .lead .meta.top a { color: <?php echo $lead_text_color; ?>; }
			.lead time:after { background-color: <?php echo $lead_text_color; ?> }
		<?php

		}
		?>
		</style>
	<?php

	}

	?>


	<?php

	 if ( has_post_thumbnail() ) { ?>

	  <?php
	  	// Get image
	  	$image = wp_get_attachment_image_src( get_post_thumbnail_id( $post->ID ), 'wide' );

	   ?>



	<?php } ?>

	 	<div class="lead">

	 		<h1 class="entry-title post-title"><?php the_title(); ?></h1>

	 		<?php get_template_part( '_part' , 'meta-top' ); ?>
	 		<?php get_template_part( '_part' , 'social-share' ); ?>

	  		<?php

	  			// Add a background image from theme options
	  			$background_image_url = "";
	  			$background_image_url = get_theme_mod( 'meanthemes_background_image' );

	  		 if ( has_post_thumbnail() || $background_image_url ) { ?>
	  			<div class="lead-image" style="background-image: url(<?php if ( has_post_thumbnail() ) { echo $image[0]; } else { echo $background_image_url; } ?>);"></div>
	 		<?php } ?>

	  		<?php // Get caption
				$captionExist = '';

				if ( get_theme_mod( 'use_subtle_layout' ) === '1' ) {

	  			$captionExist = the_post_thumbnail_caption2();

				} 

	  		if ( $captionExist ) { ?>

	  		<span class="flex-caption"><?php echo the_post_thumbnail_caption2(); ?></span>

	  		<?php } ?>

		</div>

<?php } ?>
