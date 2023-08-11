<?php if ( $wp_query->max_num_pages > 1 ) { ?>
	<div class="pagination p-archive">
			<div class="older-posts"><span class="prev-post"><?php next_posts_link( __( '.Prev Page', 'meanthemes' ) ); ?></span></div>
			<div class="newer-posts"><span class="next-post"><?php previous_posts_link( __( 'Next Page.', 'meanthemes' ) ); ?></span></div>
	</div>	
<?php } ?>