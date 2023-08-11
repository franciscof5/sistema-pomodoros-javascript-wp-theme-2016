

<ul class="meta bottom">
	<li class="cat post-tags"><?php the_category(', '); ?></li>
	<?php if( get_the_tags() ) { ?>
	<li class="tag post-tags"><?php the_tags('', ', ', ''); ?></li>
	<?php } ?>
</ul>	

<?php 

if( is_single() ) { ?> 

<?php

 if ( get_the_author_meta( 'description' ) ) { // If a user has filled out their description, show a bio on their entries  ?>

                
<div class="author-wrap">
	<span class="author-avatar"><?php echo get_avatar( get_the_author_meta( 'user_email' ), apply_filters( 'twentyten_author_bio_avatar_size', 130 ) ); ?></span>
	<div class="author-bio">
        <h6><?php _e('By' , 'meanthemes'); ?> <a href="<?php echo get_author_posts_url(get_the_author_meta( 'ID' )); ?>"><?php the_author_meta('display_name'); ?></a></h6>
        <p><?php the_author_meta( 'description' ); ?></p>
    </div>
</div>

<?php } ?>

<?php } ?>