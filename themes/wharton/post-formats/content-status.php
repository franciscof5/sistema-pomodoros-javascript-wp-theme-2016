<?php 

// Set up post class

	$postClass = "post format-status";
	
	// If no featured image add no-image class
	
	if ( !has_post_thumbnail() ) { 
	
		$postClass = "post format-status no-image";
	
	 }
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
	
	
		<?php get_template_part( '_part', 'status' ); ?>
	
		<div class="inner post-inner">		
		<?php if ( !is_single() || get_theme_mod( 'use_subtle_layout', '0' ) == '1' ) {
			get_template_part( '_part', 'meta-top' ); 
		} ?>
		
		<h3 class="entry-title"><?php echo get_the_content(); ?></h3>
			<?php get_template_part( '_part', 'meta-bottom' ); ?>
		</div>	   
	<?php if( is_single() )	{ ?>
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