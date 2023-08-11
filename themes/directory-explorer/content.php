<?php
/*
<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
	<header class="entry-header">
		<?php if( ! has_post_format('quote') ) : ?><h2 class="entry-title"><a href="<?php the_permalink(); ?>" rel="bookmark"><?php the_title(); ?></a></h2><?php endif; ?>
		<?php dw_minion_entry_meta(); ?>
	</header>
	<?php if( has_post_thumbnail() ) : ?>
	<div class="entry-thumbnail"><a href="<?php the_permalink(); ?>" rel="bookmark"><?php the_post_thumbnail(); ?></a></div>
	<?php endif; ?>
	<div class="entry-content"> 
		<?php the_content( __( '<span class="btn btn-small">Continue reading</span>', 'dw-minion' ) ); ?>
		<?php
			wp_link_pages( array(
				'before' => '<div class="page-links">',
				'after'  => '</div>',
				'link_before' => '<span class="btn btn-small">',
				'link_after'  => '</span>',
			) );
		?>
	</div>
</article>

		<?php if( ! has_post_format('quote') ) : ?><h2 class="entry-title"><a href="<?php the_permalink(); ?>" rel="bookmark">/<?php the_title(); ?></a></h2><div class="entry-tags"><?php the_tags('<button class="btn btn-small first-s" type="button">', '</button><button class="btn btn-small first-s" type="button">', '</button>'); ?></div><?php endif; ?>

<?php the_tags('<button class="btn btn-small first-s" type="button">', '</button><button class="btn btn-small first-s" type="button">', '</button>'); ?>


/<?php the_title(); ?>
</a>
*/ ?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
	<header class="entry-header">
		<?php if( ! has_post_format('quote') ) : ?><?php /*<h2 class="entry-title"><a href="https://wordpress.org/plugins/<?php echo get_the_title(); ?>" target="_blank">/<?php the_title(); ?></a></h2><?php endif; ?>*/?>
		<h2 class="entry-title"><a href="<?php the_permalink(); ?>" rel="bookmark"><?php the_title(); ?></a></h2><?php endif; ?>
	
	</header>
<div class="entry-tags">
		<?php the_tags('<i class="icon-tag"></i>', '<i class="icon-tag"></i>'); ?>
	</div>
</article>
