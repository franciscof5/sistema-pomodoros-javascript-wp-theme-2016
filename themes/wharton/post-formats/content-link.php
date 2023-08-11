<?php 

	// Set up post class

	$postClass = "post format-link";
	
	// If no featured image add no-image class
	
	if ( !has_post_thumbnail() ) { 
	
		$postClass = "post format-link no-image";
	
	 }
	 
	 
	 // Get custom meta for opening in same window
	 $single_format_link_url_self = get_post_meta($post->ID, 'single_format_link_url_self', true);
	
 ?>

<article <?php post_class($postClass); ?> id="post-<?php the_ID(); ?>">
	
	<?php if( is_single() )	{

		get_template_part( '_part', 'featured-image-single' ); ?>
		
		<?php
						
				// Alternative Sidebar
				
				 if( get_theme_mod( 'hide_sidebar', '1' ) == '0' ) { 
					if( get_theme_mod( 'alt_sidebar', '0' ) == '1' ) { ?>
					<div class="content-wrapper">
						<div class="content-hold">
				<?php 
					}
				}	
				?>	
		<div class="z-wrap">
		<div class="wrapper">
		
	<?php } ?>
	
		<div class="inner post-inner link-inner">		
		<?php if ( is_single () ) { ?>
		<?php } ?>	
			<h3 class="link entry-title"><a href="<?php echo esc_url(get_post_meta($post->ID, 'single_format_link_url', true)); ?>" title="<?php the_title(); ?>" target="<?php if( $single_format_link_url_self ) { ?>_self<?php } else { ?>_blank<?php } ?>"><?php the_title(); ?></a></h3>
		</div>
<?php if( is_single() )	{ ?>		
		<div class="inner post-inner">	
			<?php get_template_part( '_part', 'content' ); ?>		
			<?php get_template_part( '_part', 'meta-bottom' ); ?>
		</div>	   
	
	</div></div>
	<?php } ?>
<?php	

	// grab comments template
	if ( is_single() ) { ?>
	
		<div class="wrapper">
		<?php comments_template(); ?>
		</div>

	<?php
	
	// Alternative Sidebar
	
	// Check theme options for whether to show sidebar
	
	if( get_theme_mod( 'hide_sidebar', '1' ) == '0' ) { 
		if( get_theme_mod( 'alt_sidebar', '0' ) == '1' ) { 
		
		// content-hold
		
		?>
		
		</div>
		
		<?php
			get_sidebar(); 
			
			// content-wrapper
			
			?>
			</div> 
	<?php		
		}	
	} 
	?>

<?php 	
	
} // END Single
	
	?>	

</article>