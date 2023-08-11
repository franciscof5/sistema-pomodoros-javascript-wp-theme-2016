<?php if( get_theme_mod( 'use_subtle_layout', '0' ) == '1' ) { ?>
	<div class="content-wrapper">
<?php } ?>

<?php

	// Set up post class
	$postClass = "post content-hold";

	if ( !has_post_thumbnail() ) {

		// If no featured image add no-image class
		$postClass = "post content-hold no-image";

	 }


	 // Alternative Sidebar

	  if( get_theme_mod( 'hide_sidebar', '1' ) == '0' ) {
	 	if( get_theme_mod( 'alt_sidebar', '0' ) == '1' ) {

	 		// Set up post class
	 		$postClass = "post";

	 		if ( !has_post_thumbnail() ) {

	 			// If no featured image add no-image class
	 			$postClass = "post no-image";

	 		 }

	 	}
	 }



?>
	 <article <?php post_class($postClass); ?> id="post-<?php the_ID(); ?>">
	<?php get_template_part( '_part', 'featured-image-single' ); ?>


	<?php

	// Alternative Sidebar

	 if( get_theme_mod( 'hide_sidebar', '1' ) == '0' ) {
		if( get_theme_mod( 'alt_sidebar', '0' ) == '1' ) { ?>
		<div class="content-wrapper">
			<div class="content-hold">
	<?php
		}
	}
	?>
<div class="z-wrap">
<div class="wrapper">

<?php if ( get_theme_mod( 'use_subtle_layout', '0' ) == '1' && is_page() ) {

	get_template_part( '_part', 'featured-image' );

}
?>

	<div class="inner post-inner">
		<?php if ( get_theme_mod( 'use_subtle_layout', '0' ) == '1' ) { ?>

			<h1 class="entry-title post-title"><?php the_title(); ?></h1>

		 <?php }

		 the_content(); ?>

		<?php if ( is_page_template( 't-archive.php' ) ) { ?>

		<div class="archives-content">

			<div class="one_third">
				<h4><?php _e("Most recent posts" , "meanthemes"); ?></h4>
				<ul>
				<?php
				$args = array( 'numberposts' => '30', 'post_status' => 'publish' );
				$recent_posts = wp_get_recent_posts( $args );
				foreach( $recent_posts as $recent ){
				echo '<li><a href="' . get_permalink($recent["ID"]) . '" title="'.esc_attr($recent["post_title"]).'" >' .   $recent["post_title"].'</a> </li> ';
				}
				?>
				</ul>
			</div>
			<div class="one_third">
				<h4><?php _e("By month" , "meanthemes"); ?></h4>
				<ul>
				<?php wp_get_archives(); ?>
				</ul>
				<h4><?php _e("By year" , "meanthemes"); ?></h4>
				<ul>
				<?php wp_get_archives('type=yearly'); ?>
				</ul>
			</div>
			<div class="one_third last">
				<h4><?php _e("By author" , "meanthemes"); ?></h4>
				<ul>
				<?php wp_list_authors('optioncount=0'); ?>
				</ul>
				<h4><?php _e("By category" , "meanthemes"); ?></h4>
				<ul>
				<?php wp_list_categories('hierarchical=0&title_li='); ?>
				</ul>
			</div>
		</div>

		<?php } ?>

	</div>
	<?php wp_link_pages( array( 'before' => '<nav class="pagination">' . __( '<span>Pages:</span>', 'meanthemes' ), 'after' => '</nav>' ) ); ?>
	<?php

	// Check theme options for whether to show default sidebar
	 if( get_theme_mod( 'show_comments_page', '0' ) == '1' ) {

		 comments_template();

	 }	  ?>

</div>
</div>
	<?php

	// Alternative Sidebar

	// Check theme options for whether to show sidebar

	if( get_theme_mod( 'hide_sidebar', '1' ) == '0' ) {
		if( get_theme_mod( 'alt_sidebar', '0' ) == '1' ) {


		// content-hold

		 ?>
		</div>

		<?php
			get_sidebar();

			// content-wrapper

			?>
			</div>

	<?php
		}
	}
	?>


</article>


<?php

// Check theme options for whether to show default sidebar
 if( get_theme_mod( 'hide_sidebar', '1' ) == '0' ) {
	if( get_theme_mod( 'alt_sidebar', '1' ) == '0' ) {
	get_sidebar();
}
}
?>



</div>

<?php if( get_theme_mod( 'use_subtle_layout', '0' ) == '1' ) {
// content-wrapper ?>
	</div>
<?php } ?>
