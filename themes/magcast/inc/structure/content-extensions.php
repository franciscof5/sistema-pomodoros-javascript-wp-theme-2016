<?php
/**
 * Adds content structures.
 *
 * @package Theme Horse
 * @subpackage Magcast
 * @since Magcast 1.0
 * @license http://www.opensource.org/licenses/gpl-license.php GPL v2.0 (or later)
 * @link http://themehorse.com/themes/magcast
 */
/****************************************************************************************/
add_action( 'magcast_main_container', 'magcast_content', 10 );
/**
 * Function to display the content for the single post, single page, archive page, index page etc.
 */
function magcast_content() {
	global $post;
	global $magcast_site_layout, $magcast_content_layout, $magcast_settings,$magcast_array_of_default_settings;
	$magcast_settings = wp_parse_args(  get_option( 'magcast_theme_settings', array() ),  magcast_get_option_defaults() );
	if( $post ) {
		$magcast_layout = get_post_meta( $post->ID, 'magcast_sidebarlayout', true );
		$magcast_frontpage_id = get_option('page_on_front'); // for front page
		$magcast_content_layout = $magcast_settings['magcast_content_layout'];
		$magcast_banner = get_post_meta( $magcast_frontpage_id, 'magcast_sidebarlayout', true );
		$magcast_page_id = ( 'page' == get_option( 'show_on_front' ) ? get_option( 'page_for_posts' ) : get_the_ID() );
		$magcast_home_blog = get_post_meta( $magcast_page_id, 'magcast_sidebarlayout', true ); 
	}
	if( empty( $magcast_layout ) || is_archive() || is_search() || is_home() ) {
		$magcast_layout = 'default';
	}
	if(is_front_page() && $magcast_banner):
		if( 'default' == $magcast_banner ) {//checked from the themeoptions.
		$magcast_themeoption_layout = $magcast_content_layout;
			if( 'left' == $magcast_themeoption_layout ) { 
			get_template_part( 'content','leftsidebar' );//used content-leftsidebar.php
			}
			elseif( 'right' == $magcast_themeoption_layout ) { 
			get_template_part( 'content','rightsidebar' );//used content-rightsidebar.php
			}
			else {
			get_template_part( 'content','nosidebar' );//used content-nosidebar.php
			}
		}
		elseif( 'left-sidebar' == $magcast_banner ) { //checked from the particular page / post.
			get_template_part( 'content','leftsidebar' );//used content-leftsidebar.php
		}
		elseif( 'right-sidebar' == $magcast_banner ) {
			get_template_part( 'content','rightsidebar' );//used content-rightsidebar.php
		}
		else { 
			get_template_part( 'content','nosidebar' );//used content-nosidebar.php
		}
		elseif(is_front_page()):
		if( 'default' == $magcast_layout ) {//checked from the themeoptions.
		$magcast_themeoption_layout = $magcast_content_layout;
			if( 'left' == $magcast_themeoption_layout ) { 
			get_template_part( 'content','leftsidebar' );//used content-leftsidebar.php
			}
			elseif( 'right' == $magcast_themeoption_layout ) { 
			get_template_part( 'content','rightsidebar' );//used content-rightsidebar.php
			}
			else {
			get_template_part( 'content','nosidebar' );//used content-nosidebar.php
			}
		}
		elseif( 'left-sidebar' == $magcast_layout ) { //checked from the particular page / post.
			get_template_part( 'content','leftsidebar' );//used content-leftsidebar.php
		}
		elseif( 'right-sidebar' == $magcast_layout ) {
			get_template_part( 'content','rightsidebar' );//used content-rightsidebar.php
		}
		else { 
			get_template_part( 'content','nosidebar' );//used content-nosidebar.php
		}
	elseif(is_home()):
		if( 'default' == $magcast_layout ) {//checked from the themeoptions.
		$magcast_themeoption_layout = $magcast_content_layout;
			if( 'left' == $magcast_themeoption_layout ) { 
			get_template_part( 'content','leftsidebar' );//used content-leftsidebar.php
			}
			elseif( 'right' == $magcast_themeoption_layout ) {
			get_template_part( 'content','rightsidebar' );//used content-rightsidebar.php
			}
			else {
			get_template_part( 'content','nosidebar' );//used content-nosidebar.php
			}
		}
		elseif( 'left-sidebar' == $magcast_home_blog ) { //checked from the particular page / post.
			get_template_part( 'content','leftsidebar' );//used content-leftsidebar.php
		}
		elseif( 'right-sidebar' == $magcast_home_blog ) {
			get_template_part( 'content','rightsidebar' );//used content-rightsidebar.php
		}
		else { 
			get_template_part( 'content','nosidebar' );//used content-nosidebar.php
		}
	else:
		if( 'default' == $magcast_layout ) { //checked from the themeoptions.
		$magcast_themeoption_layout = $magcast_content_layout;
			if( 'left' == $magcast_themeoption_layout ) {

			get_template_part( 'content','leftsidebar' );//used content-leftsidebar.php
			}
			elseif( 'right' == $magcast_themeoption_layout ) {
			get_template_part( 'content','rightsidebar' );//used content-rightsidebar.php
			}
			else {
			get_template_part( 'content','nosidebar' );//used content-nosidebar.php
			}
		}
		elseif( 'left-sidebar' == $magcast_layout ) {//checked from the particular page / post.
			get_template_part( 'content','leftsidebar' );//used content-leftsidebar.php
		}
		elseif( 'right-sidebar' == $magcast_layout ) {
			get_template_part( 'content','rightsidebar' );//used content-rightsidebar.php
		}
		else {
			get_template_part( 'content','nosidebar' );//used content-nosidebar.php
		}
	endif;
}
/****************************************************************************************/
add_action( 'magcast_before_loop_content', 'magcast_loop_before', 10 );
/**
 * Contains the opening div
 */
function magcast_loop_before() {
	echo '<div id="main">';
}
/****************************************************************************************/
add_action( 'magcast_loop_content', 'magcast_theloop', 10 );
/**
 * Shows the loop content
 */
function magcast_theloop() {
	if( is_page() ) {
		magcast_theloop_for_page();
	}
	elseif( is_single() ) {
		magcast_theloop_for_single();
	}
	elseif( is_search() ) {
		magcast_theloop_for_search();
	}
	else {
		magcast_theloop_for_archive();
	}
}
/****************************************************************************************/
if ( ! function_exists( 'magcast_theloop_for_archive' ) ) :
/**
 * Fuction to show the archive loop content.
 */
function magcast_theloop_for_archive() {
	global $post;
		if( have_posts() ) {
			while( have_posts() ) {
				the_post();
				do_action( 'magcast_before_post' ); ?>
						<?php do_action( 'magcast_before_post_header' ); ?>
						 <div id="post-<?php the_ID(); ?>" <?php post_class('clearfix'); ?>>
							<?php
							if( has_post_thumbnail() ) { ?>
								<figure class="post-featured-image">
									<?php if(is_sticky()){?>
											<a title="<?php the_title(); ?>" href="<?php the_permalink(); ?>"><?php the_post_thumbnail('magcast-large-thumb'); ?></a>
										<?php } else { ?>
											<a title="<?php the_title(); ?>" href="<?php the_permalink(); ?>"><?php the_post_thumbnail('magcast-small-thumb'); ?></a>
										<?php } ?>
								</figure><!-- .post-featured-image -->
							<?php } ?>
							<div class="post-featured-content">
								<article>
									<header class="entry-header">
										<h2 class="entry-title">
											<a title="<?php the_title(); ?>" href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
										</h2><!-- .entry-title -->
										<?php if (get_the_author() !=''){?>
											<div class="entry-meta clearfix">
												<div class="date"><a href="<?php the_permalink(); ?>" title="<?php echo esc_attr( get_the_time('j F Y') ); ?>"><?php echo esc_attr( get_the_time('j F Y') ); ?></a></div><div class="by-author"><a href="<?php echo get_author_posts_url( get_the_author_meta( 'ID' ) ); ?>" title="<?php the_title(); ?>"><?php the_author(); ?> </a></div>
												<?php
												if ( comments_open() ) { ?>
												<div class="comments">
													<?php comments_popup_link( __( 'No Comments', 'magcast' ), __( '1 Comment', 'magcast' ), __( '% Comments', 'magcast' ), '', __( 'Comments Off', 'magcast' ) ); ?>
												</div>
												<?php
												} ?>
											</div><!-- .entry-meta -->
										<?php } ?>
									</header><!-- .entry-header -->
									<?php  if (has_category() !=''){?>
									<div class="entry-content clearfix">
										<?php the_excerpt(); ?>
										<a href="<?php the_permalink();?>" class="readmore"><?php esc_html_e('Read More','magcast'); ?></a>
									</div><!-- .entry-content -->
									<?php } else { ?>
									<p> <?php the_content(); ?> </p>
									<?php } ?>
								</article>
							</div>
						</div><!-- .post -->
				<?php do_action( 'magcast_after_post' );
			}
		} else { ?>
			<h2 class="entry-title">
				<?php esc_html_e( 'No Posts Found.', 'magcast' ); ?>
			</h2>
		<?php }
}
endif;
/****************************************************************************************/
if ( ! function_exists( 'magcast_theloop_for_page' ) ) :
/**
 * Fuction to show the page content.
 */
function magcast_theloop_for_page() { ?>
	<div <?php post_class(); ?>>
	<?php global $post;
	if( have_posts() ) {
		while( have_posts() ) {
			the_post();
				do_action( 'magcast_before_post' );
					if( is_home() || is_front_page() ) { ?>
					<header class="entry-header">
						<h2 class="entry-title">
							<?php the_title(); ?>
						</h2><!-- .entry-title -->
					</header>
				<?php
					}
				do_action( 'magcast_after_post_header' );
				do_action( 'magcast_before_post_content' ); ?>
				<div class="entry-content">
					<?php the_content(); ?>
				</div><!-- .entry-content -->
				<?php
					wp_link_pages( array( 
					'before'            => '<div style="clear: both;"></div><div class="pagination clearfix">'.__( 'Pages:', 'magcast' ),
					'after'             => '</div>',
					'link_before'       => '<span>',
					'link_after'        => '</span>',
					'pagelink'          => '%',
					'echo'              => 1
					) );
				?>
				<?php 
					do_action( 'magcast_after_post_content' );
					do_action( 'magcast_before_comments_template' );
					comments_template(); 
					do_action ( 'magcast_after_comments_template' );
				?>
		<?php
			do_action( 'magcast_after_post' );
		}
	}
	else { ?>
	<h2 class="entry-title">
		<?php esc_html_e( 'No Posts Found.', 'magcast' ); ?>
	</h2>
<?php
	}
		echo '</div><!-- .entry-content -->';
}
endif;
/****************************************************************************************/
if ( ! function_exists( 'magcast_theloop_for_single' ) ) :
/**
 * Fuction to show the single post content.
 */
function magcast_theloop_for_single() {
	global $post;
	if( have_posts() ) {
		while( have_posts() ) {
			the_post();
			do_action( 'magcast_before_post' ); ?>
			<div id="post-<?php the_ID(); ?> clearfix" <?php post_class('clearfix'); ?>>
					<div class="post-featured-content">
						<article>
							<header class="entry-header">
							<div class="entry-meta">
									<span class="cat-links">
										<?php the_category(' '); ?>
									</span>
								</div><!-- .entry-meta -->
								<h2 class="entry-title">
									<?php the_title(); ?>
								</h2><!-- .entry-title -->
								<?php if (get_the_author() !=''){?>
									<div class="entry-meta clearfix">
										<div class="date"><a href="<?php the_permalink(); ?>" title="<?php echo esc_attr( get_the_time('j F Y') ); ?>"><?php echo esc_attr( get_the_time('j F Y') ); ?></a></div><div class="by-author"><a href="<?php echo get_author_posts_url( get_the_author_meta( 'ID' ) ); ?>" title="<?php the_title(); ?>"><?php the_author(); ?> </a></div>
									</div><!-- .entry-meta -->
								<?php } ?>
							</header><!-- .entry-header -->
							<div class="entry-content clearfix">
								<?php the_content(); ?>
							</div><!-- .entry-content -->
						<?php
						wp_link_pages( array( 
							'before'			=> '<div style="clear: both;"></div><div class="pagination clearfix">'.__( 'Pages:', 'magcast' ),
							'after'			=> '</div>',
							'link_before'	=> '<span>',
							'link_after'	=> '</span>',
							'pagelink'		=> '%',
							'echo'			=> 1
						) );
								$tag_list = get_the_tag_list( '', __( ', ', 'magcast' ) );
								 if( !empty( $tag_list ) ) {  ?>
									<footer class="entry-meta clearfix">
											<span class="tag-links">
												<?php echo $tag_list;?>
											</span><!-- .tag-links -->
									</footer><!-- .entry-meta -->
								<?php } ?>
						</article>
					</div>
				</div><!-- .post -->
				<?php
						do_action( 'magcast_after_post_content' );
						do_action( 'magcast_after_post' );
						do_action( 'magcast_before_comments_template' );
						comments_template();
						do_action ( 'magcast_after_comments_template' );
		}
	}
	else {
	?>
		<h2 class="entry-title">
			<?php esc_html_e( 'No Posts Found.', 'magcast' ); ?>
		</h2>
	<?php
	}
}
endif;
/****************************************************************************************/
if ( ! function_exists( 'magcast_theloop_for_search' ) ) :
/**
 * Fuction to show the search results.
 */
function magcast_theloop_for_search() {
	global $post;
	if( have_posts() ) {
		while( have_posts() ) {
			the_post();
			do_action( 'magcast_before_post' ); ?>
		<section id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
			<article class="entry-wrap">
				<?php do_action( 'magcast_before_post_header' ); ?>
					<div class="entry-main">
						<header class="entry-header">
							<h2 class="entry-title">
								<a href="<?php the_permalink(); ?>" title="<?php the_title_attribute();?>">
									<?php the_title(); ?>
								</a>
							</h2><!-- .entry-title -->
						</header>
						<?php do_action( 'magcast_after_post_header' ); ?>
						<?php do_action( 'magcast_before_post_content' ); ?>
						<div class="entry-content clearfix">
							<?php the_excerpt(); ?>
						</div>
						<?php do_action( 'magcast_after_post_content' ); ?>
					</div><!-- .entry-main -->
			</article>
		</section>
			<?php do_action( 'magcast_after_post' );
		}
	}
	else {
		?>
	<h2 class="entry-title">
		<?php esc_html_e( 'No Posts Found.', 'magcast' ); ?>
	</h2>
<?php
	}
}
endif;
/****************************************************************************************/
add_action( 'magcast_after_loop_content', 'magcast_next_previous', 5 );
/**
 * Shows the next or previous posts
 */
function magcast_next_previous() {
	if( is_archive() || is_home() || is_search() ) {
		/**
		 * Checking WP-PageNaviplugin exist
		 */
		if ( function_exists('wp_pagenavi' ) ) :
			wp_pagenavi();
		else: 
			global $wp_query;
			if ( $wp_query->max_num_pages > 1 ) : ?>
				<div class="nav-links clearfix">
					<div class="nav-previous">
						<span class="meta-nav"><?php next_posts_link( __( 'Previous', 'magcast' ) ); ?></span>
					</div>
					<div class="nav-next">
						<span class="meta-nav"><?php previous_posts_link( __( 'Next', 'magcast' ) ); ?></span>
					</div>
				</div>
			<?php
			endif;
		endif;
	}
}
/****************************************************************************************/
add_action( 'magcast_after_post_content', 'magcast_next_previous_post_link', 10 );
/**
 * Shows the next or previous posts link with respective names.
 */
function magcast_next_previous_post_link() {
	if ( is_single() ) {
		if( is_attachment() ) {
		?>
		<div class="nav-links clearfix">
			<div class="nav-previous">
				<span class="meta-nav"> <?php previous_image_link( false, __( 'Previous', 'magcast' ) ); ?> </span>
			</div>
				<div class="nav-next">
					<span class="meta-nav"><?php next_image_link( false, __( 'Next', 'magcast' ) ); ?></span>
				</div>
			</div>
		<?php
		}
		else {
		?>
		<div class="nav-links clearfix">
			<div class="nav-previous">
				<?php previous_post_link( '%link', '<span class="meta-nav">' . __( 'Previous', 'magcast' ) . '</span>'. '<span class="screen-reader-text">' . __( 'Previous post:','magcast') . '</span>' . ' <span class="post-title">%title </span>' ); ?>
			</div>
			<div class="nav-next">
				<?php next_post_link( '%link', '<span class="meta-nav">' . __( 'Next', 'magcast' ) . '</span>'. '<span class="screen-reader-text">' . __( 'Next post:','magcast') . '</span>'.'<span class="post-title">%title </span>' ); ?>
			</div>
		</div>
<?php
		}
	}
}
/****************************************************************************************/
add_action( 'magcast_after_loop_content', 'magcast_loop_after', 10 );
/**
 * Contains the closing div
 */
function magcast_loop_after() {
	echo '</div><!-- #main -->';
}
/****************************************************************************************/
if ( ! function_exists( 'magcast_comment' ) ) :
/**
 * Template for comments and pingbacks.
 *
 * To override this walker in a child theme without modifying the comments template
 * simply create your own magcast_comment(), and that function will be used instead.
 *
 * Used as a callback by wp_list_comments() for displaying the comments.
 *
 * @since Magcast 1.0
 */
function magcast_comment( $comment, $args, $depth ) {
	$GLOBALS['comment'] = $comment;
	switch ( $comment->comment_type ) :
	case 'pingback' :
	case 'trackback' :
		// Display trackbacks differently than normal comments.
	?>
<li <?php comment_class(); ?> id="comment-<?php comment_ID(); ?>">
	<p>
		<?php esc_html_e( 'Pingback:', 'magcast' ); ?>
		<?php comment_author_link(); ?>
		<?php edit_comment_link( __( '(Edit)', 'magcast' ), '<span class="edit-link">', '</span>' ); ?>
	</p>
	<?php
		break;
		default :
		// Proceed with normal comments.
		global $post;
	?>
<li <?php comment_class(); ?> id="li-comment-<?php comment_ID(); ?>">
	<article id="comment-<?php comment_ID(); ?>" class="comment">
		<header class="comment-meta comment-author vcard">
			<?php
				echo get_avatar( $comment, 44 );
				printf( '<cite class="fn">%1$s %2$s</cite>',
				get_comment_author_link(),
				// If current post author is also comment author, make it known visually.
				( $comment->user_id === $post->post_author ) ? '<span> ' . __( 'Post author', 'magcast' ) . '</span>' : ''
				);
				printf( '<a href="%1$s"><time pubdate datetime="%2$s">%3$s</time></a>',
				esc_url( get_comment_link( $comment->comment_ID ) ),
				get_comment_time( 'c' ),
				/* translators: 1: date, 2: time */
				sprintf( __( '%1$s at %2$s', 'magcast' ), get_comment_date(), get_comment_time() )
				);
			?>
		</header> <!-- .comment-meta -->
		<?php if ( '0' == $comment->comment_approved ) : ?>
			<p class="comment-awaiting-moderation">
				<?php esc_html_e( 'Your comment is awaiting moderation.', 'magcast' ); ?>
			</p>
		<?php endif; ?>
		<section class="comment-content comment">
			<?php comment_text(); ?>
			<?php edit_comment_link( __( 'Edit', 'magcast' ), '<p class="edit-link">', '</p>' ); ?>
		</section><!-- .comment-content -->
		<div class="reply">
			<?php comment_reply_link( array_merge( $args, array( 'reply_text' => __( 'Reply <span>&darr;</span>', 'magcast' ), 'depth' => $depth, 'max_depth' => $args['max_depth'] ) ) ); ?>
		</div><!-- .reply --> 
	</article><!-- #comment-## -->
	<?php
		break;
	endswitch; // end comment_type check
}
endif;
/****************************************************************************************/
add_action( 'magcast_contact_page_template_content', 'magcast_display_contact_page_template_content', 10 );
/**
 * Displays the contact page template content.
 */
function magcast_display_contact_page_template_content() {
	global $post;	
	global $magcast_content_layout;
	if( $post ) {
		$magcast_layout = get_post_meta( $post->ID, 'magcast_sidebarlayout', true );
	}
	if( empty( $magcast_layout ) || is_archive() || is_search() || is_home() ) {
		$magcast_layout = 'default';
	}
	if( 'default' == $magcast_layout ) { //checked from the themeoptions.
	$magcast_themeoption_layout = $magcast_content_layout;
		if( 'left' == $magcast_themeoption_layout ) {
		get_template_part( 'content','leftsidebar' );//used content-leftsidebar.php
		}
		elseif( 'right' == $magcast_themeoption_layout ) {
		get_template_part( 'content','rightsidebar' );//used content-rightsidebar.php
		}
		else {
		get_template_part( 'content','nosidebar' );//used content-nosidebar.php
		}
	}
	elseif( 'left-sidebar' == $magcast_layout ) { //checked from the particular page / post.
		get_template_part( 'content','leftsidebar' );//used content-leftsidebar.php
	}
	elseif( 'right-sidebar' == $magcast_layout ) {
		get_template_part( 'content','rightsidebar' );//used content-rightsidebar.php
	}
	else {
		get_template_part( 'content','nosidebar' );//used content-nosidebar.php
	}
}
/****************************************************************************************/
add_action( 'magcast_magazine_template_content', 'magcast_magazine_template_widgetized_content');
/**
 * Displays the widget as contents
 */
function magcast_magazine_template_widgetized_content() { 
	global $post;	
	global $magcast_content_layout;
	$magcast_settings = wp_parse_args(  get_option( 'magcast_theme_settings', array() ),  magcast_get_option_defaults() );
	$magcast_content_layout = $magcast_settings['magcast_content_layout'];
	if( $post ) {
		$magcast_layout = get_post_meta( $post->ID, 'magcast_sidebarlayout', true );
	}
	if( empty( $magcast_layout )) {
		$magcast_layout = 'default';
	}
	if( 'default' == $magcast_layout ) { //checked from the themeoptions.
	$magcast_themeoption_layout = $magcast_content_layout;
		if( 'left' == $magcast_themeoption_layout ) {
		get_template_part( 'content','leftsidebar' );//used content-leftsidebar.php
		}
		elseif( 'right' == $magcast_themeoption_layout ) {
		get_template_part( 'content','rightsidebar' );//used content-rightsidebar.php
		}
		else {
		get_template_part( 'content','nosidebar' );//used content-nosidebar.php
		}
	}
	elseif( 'left-sidebar' == $magcast_layout ) { //checked from the particular page / post.
		get_template_part( 'content','leftsidebar' );//used content-leftsidebar.php
	}
	elseif( 'right-sidebar' == $magcast_layout ) {
		get_template_part( 'content','rightsidebar' );//used content-rightsidebar.php
	}
	else {
		get_template_part( 'content','nosidebar' );//used content-nosidebar.php
	}
} ?>