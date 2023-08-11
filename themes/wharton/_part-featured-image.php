  <?php $disable_featured_image = get_post_meta($post->ID, 'disable_featured_image', true); ?>

  <?php

   if( !is_single() && !is_page() && $disable_featured_image === "yes" ) {
   // If the post is not a post or page and disable feature image is not set to yes then do nothing, else show the featured image please

  } else { ?>

  	<?php if ( has_post_thumbnail() ) { ?>


  		<span class="post-image">
  			<?php if( (!is_single()) && (!is_page()) ) { ?>
  				<a href="<?php the_permalink(); ?>" title="<?php the_title(); ?>">
  			<?php } ?>
  				<?php the_post_thumbnail('default'); ?>
  			<?php if( (!is_single()) && (!is_page()) ) { ?>
  				</a>
  			<?php } ?>
  		<?php

  		// Get caption
  		$captionExist = the_post_thumbnail_caption2();

  		if ( $captionExist ) { ?>

  		<span class="flex-caption"><?php echo the_post_thumbnail_caption2(); ?></span>

  		<?php } ?>

  		</span>

	<?php } ?>

<?php } // end else ?>
