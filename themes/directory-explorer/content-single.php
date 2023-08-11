<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
	<header class="entry-header">
		<?php if( ! has_post_format('quote') ) : ?><h1 class="entry-title"><?php the_title(); ?></h1><?php endif; ?>
		<?php dw_minion_entry_meta(); ?>
	</header>
	<?php if( has_post_thumbnail() ) : ?>
	<div class="entry-thumbnail"><?php the_post_thumbnail(); ?></div>
	<?php endif; ?>
	<?php if (  ( is_home() || is_tag() || is_category() || is_date() || is_search() ) ) : ?>
	<div class="entry-summary">
		<?php the_excerpt(); ?>
	</div>
	<?php else : ?>
	<div class="entry-content">
		<?php the_content( __( 'Continue reading <span class="meta-nav">&rarr;</span>', 'dw-minion' ) ); ?>
		<?php
			wp_link_pages( array(
				'before' => '<div class="page-links">',
				'after'  => '</div>',
				'link_before' => '<span class="btn btn-small">',
				'link_after'  => '</span>',
			) );
		?>
		<?php 
          $cursowp = get_post_meta($post->ID, 'cursowp', false);
          echo "<h2>CursoWP.com.br - Relacionado:</h2>";
          echo "<blockquote>";
          if(is_array($cursowp)) {
            foreach ($cursowp as $post) {
              echo "<h4><a href='".$post."'>".$post."</a></h4><br/>";
            }
          } else {
            echo "<h4><a href='".$cursowp."'>".$cursowp."</a></h4><br/>";
          }
          echo "</blockquote>";
        ?>


		<h2>Link WordPress Codex:</h2>
		<h4><a href="https://wordpress.org/plugins/<?php echo get_the_title(); ?>" target="_blank">https://wordpress.org/plugins/<?php the_title(); ?></a></h4>
	</div>
	<?php endif; ?>
	<footer class="entry-footer">
		<?php
			$tags_list = get_the_tag_list();
			if ( $tags_list ) :
		?>
		<div class="entry-tags">
			<span class="tags-title"><?php _e('Tags', 'dw-minion') ?></span>
			<span class="tags-links"><?php printf( __( '%1$s', 'dw-minion' ), $tags_list ); ?></span>
		</div>
		<?php endif; ?>
	</footer>
</article>