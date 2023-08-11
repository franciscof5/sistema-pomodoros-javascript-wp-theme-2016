
<?php

// Check theme options for whether to show sidebar

if ( is_home() || is_page_template('t-index.php') ) {

	if( get_theme_mod( 'hide_sidebar', '1' ) == '0' ) {
	?>
	<div class="content-wrapper">
<?php
	}

}
?>


<div class="content-hold">
	<div class="wrapper is-loop">

		<?php
			rewind_posts();


			if ( is_front_page() ) {

					$paged = (get_query_var('page')) ? get_query_var('page') : 1;

				} else {

					$paged = (get_query_var('paged')) ? get_query_var('paged') : 1;

				}

			if ( is_page_template('t-index.php') ) {

				query_posts('&posts_per_page&paged=' . $paged);

			}



			if (have_posts()) :
			while (have_posts()) : the_post();

			if( get_post_type() === 'page' ) {

				get_template_part('_part-content-result');

			} else {

					if(!get_post_format()) {
						get_template_part('post-formats/content', 'standard');
					} else {
						get_template_part('post-formats/content', get_post_format());
					}

			}

			endwhile;
			endif;
		?>

	</div>
</div>


	<?php

	// Check theme options for whether to show sidebar

	if ( is_home() || is_page_template('t-index.php') ) {

		if( get_theme_mod( 'hide_sidebar', '1' ) == '0' ) {
		get_sidebar();
		?>
		</div>
	<?php
		}

		get_template_part('_part', 'nav-archive');

	}
	?>



<?php wp_reset_query(); ?>
