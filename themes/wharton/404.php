<?php get_header(); ?>

		<?php get_template_part('_part-slab-text-404'); ?>
		<div class="wrapper">
			<article class="post">
				<div class="inner">
					<span class="further"><?php _e( 'Please try using our search to find the content you were looking for.', 'meanthemes' ); ?></span>
					
					<?php get_search_form(); ?>
					
				</div>
			</article>		
		</div>	
	
<?php get_footer();  ?>