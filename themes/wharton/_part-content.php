<?php

$showExcerpt = "";
$showExcerpt = get_theme_mod( 'auto_excerpt');

if( is_single() ) { ?>

<?php


	if ( get_theme_mod( 'use_subtle_layout', '0' ) == '1' && is_single() ) { ?>

		<h1 class="entry-title post-title"><?php the_title(); ?></h1>

		<?php get_template_part( '_part' , 'meta-top' ); ?>
		<?php get_template_part( '_part' , 'social-share' ); ?>

	<?php }

	the_content();

	wp_link_pages( array( 'before' => '<nav class="pagination">' . __( '<span>Pages:</span>', 'meanthemes' ), 'after' => '</nav>' ) );


} else {

	if ( $showExcerpt ) {

		the_excerpt();

	} else {

		the_content( __('Continue reading' , 'meanthemes') ); 

	}

}
