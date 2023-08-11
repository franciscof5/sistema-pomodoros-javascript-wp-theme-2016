<script>
	document.title = "Pomodoros <?php global $title_apendix; echo $title_apendix.' » ';_e('Blog', 'sis-foca-js'); ?>";
</script>
	
	<?php 
	if(function_exists("show_welcome_message")) show_welcome_message(true); 
	global $user_prefered_language;
	?>
	<br>
	
	<div id="content" class="content_defaultDDD col col-xs-12 ">
		<center><h2 class="forte"><i class="glyphicon glyphicon-comment"></i> <?php _e("Pomodoros Blog", "sis-foca-js"); ?></h2></center>
		<div class="row">
			
			<div class="padder col-md-8">
			
			<!--hr /-->
				
			<?php do_action( 'bp_before_blog_home' ) ?>

			<div class="page" id="blog-latest">

				<?php 
				if(function_exists('set_shared_database_schema')) {
				    set_shared_database_schema();
				}
				global $wp_query;
				$original_query = $wp_query;
				$wp_query = null;
				global $user_prefered_language_prefix;
				$args = array(
					"posts_per_page" => 12,
					"post_type" => "post",
					'tag' => "lang-".$user_prefered_language_prefix,
				);
				$wp_query = new WP_Query( $args );
				if ( have_posts() ) : ?>

					<?php while (have_posts()) : the_post(); ?>
						<?php do_action( 'bp_before_blog_post' ) ?>

						<div class="post" id="post-<?php the_ID(); ?>">

								<div class="contem-thumb">
									<center>
								    <a style="margin:0 auto;" href="<?php the_permalink(); ?>" title="<?php the_title_attribute(); ?>">
								       <?php 

								       if ( has_post_thumbnail() ) {
								       		
											the_post_thumbnail( array(500,200) );
										}

								       ?>
								    </a>
								    </center>
								    
								    <div class="author-box">
										<?php echo get_avatar( get_the_author_meta( 'user_email' ), '80' ); ?>
									</div>
									
									<h2 class="posttitle"><a href="<?php the_permalink() ?>" rel="bookmark" title="<?php _e( 'Permanent Link to', 'buddypress' ) ?> <?php the_title_attribute(); ?>"><?php the_title(); ?></a>
									</h2>

									<p class="date"><?php the_time("Y-m-d") ?></p>

									<p class="postmetadata"><span class="tags"><?php the_tags( __( 'Tags: ', 'buddypress' ), ', ', '<br />'); ?></span> <span class="comments"><?php comments_popup_link( __( 'No Comments &#187;', 'buddypress' ), __( '1 Comment &#187;', 'buddypress' ), __( '% Comments &#187;', 'buddypress' ) ); ?></span></p>

							    </div>
						

							<div class="post-content">
								

								<div class="entry">
									<?php 
									if(!is_single())
									the_excerpt();
									else
									the_content( __( 'Read the rest of this entry &rarr;', 'buddypress' ) ); ?>
								</div>

								
							</div>

						</div>

						<?php do_action( 'bp_after_blog_post' )
						endwhile;
						the_posts_pagination();
					else : ?>

					<h2 class="center"><?php _e( 'Not Found', 'buddypress' ) ?></h2>
					<p class="center"><?php _e( 'Sorry, but you are looking for something that isn\'t here.', 'buddypress' ) ?></p>

					<?php locate_template( array( 'searchform.php' ), true ) ?>

				<?php endif; ?>
			</div>

			<?php do_action( 'bp_after_blog_home' ); ?>

		</div><!-- .padder -->

			<?php locate_template( array( 'sidebar-index.php' ), true ); ?>
		</div>
	</div><!-- #content -->
