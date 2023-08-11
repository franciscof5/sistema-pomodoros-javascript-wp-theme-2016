 <?php if ( is_single() || is_page() ) { ?>

<?php 

// Hide comments

if( false === get_theme_mod( 'hide_comments' ) ) { ?>

	 <div id="comments">
		
		    <h5 id="respond-title"><?php comments_popup_link( __( 'Comments (0)','meanthemes' ), __( 'Comments (1)','meanthemes' ), __( 'Comments (%)','meanthemes' ) ); ?></h5>
		    
	  <div class="inner">	    
			    <aside class="comments">
			<?php if ( post_password_required() ) : ?>
		    <p class="nopassword"><?php _e( 'This post is password protected. Enter the password to view any comments.', 'meanthemes' ); ?></p>
		
		<?php
		return; endif; ?>
		</aside>
		<?php if ( have_comments() ) : ?>
		
		<?php if ( get_comment_pages_count() > 1 && get_option( 'page_comments' ) ) : ?>
					<div class="navigation">
						<div class="nav-previous"><?php previous_comments_link( __( '<span class="meta-nav">&larr;</span> Older Comments', 'meanthemes' ) ); ?></div>
						<div class="nav-next"><?php next_comments_link( __( 'Newer Comments <span class="meta-nav">&rarr;</span>', 'meanthemes' ) ); ?></div>
					</div> 
		<?php endif; ?>
					<ol class="commentlist">
						<?php wp_list_comments( array( 'callback' => 'post_comments' ) ); ?>
					</ol>
		<?php if ( get_comment_pages_count() > 1 && get_option( 'page_comments' ) ) : ?>
		            <div class="navigation">
						<div class="nav-previous"><?php previous_comments_link( __( '<span class="meta-nav">&larr;</span> Older Comments', 'meanthemes' ) ); ?></div>
						<div class="nav-next"><?php next_comments_link( __( 'Newer Comments <span class="meta-nav">&rarr;</span>', 'meanthemes' ) ); ?></div>
					</div>
		<?php endif; ?>
		<?php else : if ( ! comments_open() ) : ?>
			<p class="nocomments"><?php _e( 'Comments are closed.', 'meanthemes' ); ?></p>
		<?php endif; ?>
		<?php endif; ?>
		<?php
		$form_args = array( 
			
			'title_reply' => __( 'Leave a comment', 'meanthemes'),
			'comment_notes_before' => '<p class="comment-notes">' . __( 'Your email address will not be published. Required fields are marked <span class="required">*</span>' , 'meanthemes' ) . '</p>',
			'comment_notes_after' => '',
			'comment_field' => '<p class="comment-form-comment"><label for="comment">' . __( 'Comment', 'meanthemes' ) .
			    '</label><textarea id="comment" name="comment" cols="45" rows="8" aria-required="true">' .
			    '</textarea></p>',
			'label_submit' => __( 'Post Comment' , 'meanthemes' )
		 
		); 
		
		comment_form( $form_args );  ?>
		</div>	
	</div>
	<?php } ?>

<?php } ?>
