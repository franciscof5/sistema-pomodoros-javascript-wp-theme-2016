<?php 

if( is_single() ) { ?> 

<?php if( !is_page() ) { ?>
	<ul class="meta top">
		<li class="time">
			<?php if( !is_single() ) { ?><a href="<?php the_permalink(); ?>" title="<?php the_title(); ?>"><?php } ?><time class="post-date updated" datetime="<?php the_time('Y-m-d', '', ''); ?>"><?php the_time(get_option('date_format')); ?></time><?php if( !is_single() ) { ?></a><?php } ?>
		</li>
		<?php if( is_single() || ( true === get_theme_mod( 'show_comments_archive' ) ) ) { ?>
			<?php

			// Hide comments

			if( false === get_theme_mod( 'hide_comments' ) ) { ?>

			<li class="comments post-tags"><?php comments_popup_link( __( '0 Comments','meanthemes' ), __( '1 Comment','meanthemes' ), __( '% Comments','meanthemes' ) ); ?></li>

			<?php } if (is_single()) { ?>
			<li class="author-m post-tags">
				<?php _e( "by " , "meanthemes" ); ?> <span class="vcard author post-author"><span class="fn"><?php the_author_posts_link(); ?></span></span>
			</li>
		<?php
			}
		}
		?>
	</ul>
<?php } ?>
<?php } ?>
