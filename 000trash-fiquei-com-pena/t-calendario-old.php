<?php
/* Template Name: Pomo - Calendario */
?>
<?php get_header() ?>

<div class="content_nosidebar">
	<!--todo: chanve view to MENSAL and YEAR
	todo:put button show only my records
	todo:put on configuration optionS above
	h2>Calenario mensal</h2>
	<p>Visualizar <a>calendario anual</a></p-->
	<?php
	echo do_shortcode("[calendar-archive]");
	//echo do_shortcode("{events_calendar}");
	?>
</div><!-- #content -->
	
<?php get_footer() ?>
<?php get_header() ?>
<? /*
	<div id="content" class="content_default">
		<div class="padder">

		<?php do_action( 'bp_before_blog_page' ) ?>

		<div class="page" id="blog-page">

			<?php if (have_posts()) : while (have_posts()) : the_post(); ?>


				<div class="post" id="post-<?php the_ID(); ?>">

					<div class="entry">

						<?php the_content( __( '<p class="serif">Read the rest of this page &rarr;</p>', 'buddypress' ) ); ?>

						<?php wp_link_pages( array( 'before' => __( '<p><strong>Pages:</strong> ', 'buddypress' ), 'after' => '</p>', 'next_or_number' => 'number')); ?>
						<?php edit_post_link( __( 'Edit this entry.', 'buddypress' ), '<p>', '</p>'); ?>

					</div>

				</div>

			<?php endwhile; endif; ?>

		</div><!-- .page -->

		<?php do_action( 'bp_after_blog_page' ) ?>

		</div><!-- .padder -->
	</div><!-- #content -->

	<?php locate_template( array( 'sidebar.php' ), true ) ?>

<?php get_footer(); ?>
