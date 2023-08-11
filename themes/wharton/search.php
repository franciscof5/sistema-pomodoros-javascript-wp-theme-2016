<?php get_header(); ?>

<?php

// Sidebar

 if( get_theme_mod( 'hide_sidebar', '1' ) == '0' ) {  ?>
<div class="full-hold">
<?php
}

?>

	<?php if ( have_posts() ) { ?>

	<?php

	// Sidebar

	 if( get_theme_mod( 'hide_sidebar', '1' ) == '0' ) {  ?>
			<div class="content-hold">
	<?php
	}
	?>

		<div class="wrapper">
			<article class="post result">
				<div class="inner">
					<h1 class="post-title searching"><?php printf( __( 'Search Results for: %s', 'meanthemes' ), '<span>' . get_search_query() . '</span>' ); ?></h1>
				</div>
			</article>
		</div>

<?php

// Sidebar

 if( get_theme_mod( 'hide_sidebar', '1' ) == '0' ) {  ?>
	</div>
<?php

get_sidebar();

}
?>

	<?php get_template_part('loop-search'); ?>		



	<?php } else { ?>

	<?php

	// Sidebar

	 if( get_theme_mod( 'hide_sidebar', '1' ) == '0' ) {  ?>
				<div class="content-hold">
	<?php
	}
	?>

		<div class="wrapper">
			<article class="post">
				<div class="inner">
					<h1 class="searching"><?php printf( __( 'Nothing Found for: %s', 'meanthemes' ), '<span>' . get_search_query() . '</span>' ); ?></h1><span class="further"><?php _e( 'Sorry, but nothing matched your search criteria. Please try again with some different keywords.', 'meanthemes' ); ?></span>

					<?php get_search_form(); ?>

				</div>
			</article>
		</div>

		<?php

		// Alternative Sidebar

		 if( get_theme_mod( 'hide_sidebar', '1' ) == '0' ) {  ?>
	</div>

		<?php

		get_sidebar();

		}
		?>

	<?php } ?>


<?php

// Check theme options for whether to show sidebar

if( get_theme_mod( 'hide_sidebar', '1' ) == '0' ) {
	 // Full hold  ?>

	</div>
<?php
}
?>

<?php get_template_part('_part', 'nav-archive'); ?>


<?php get_footer();  ?>
