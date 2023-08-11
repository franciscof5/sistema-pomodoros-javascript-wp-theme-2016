<div class="content_nosidebar">
	<?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>
    	<h2><?php the_title(); ?></h2>
    <?php the_post_thumbnail(); ?>
    <?php the_content(); ?>
	<?php endwhile; else: ?>
		<?php _e( 'Sorry, no posts matched your criteria.', 'textdomain' ); ?>
	<?php endif; ?>
</div>

