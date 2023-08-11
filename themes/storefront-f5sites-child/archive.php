<?php
/**
 * The template for displaying archive pages.
 *
 * Learn more: https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package storefront
 */

get_header(); ?>

	<div id="primary" class="content-area">
		<main id="main" class="site-main" role="main">

		
		<?php if ( have_posts() ) : ?>
			<div class="row">
				<header class="page-header">
					<?php
						the_archive_title( '<h1 class="page-title">', '</h1>' );
						the_archive_description( '<div class="taxonomy-description">', '</div>' );
					?>
				</header><!-- .page-header -->
			</div>

			<div class="row">
			
			<?php
			#get_template_part( 'loop' );
			#echo "1";

			do_action( 'storefront_loop_before' );

			while ( have_posts() ) :
				the_post();

				$allposttags = get_the_tags();
                $i=0;
                if ($allposttags) {
                    foreach($allposttags as $tags) {
                        $i++;
                        if (1 == $i) {
                            $firsttag = $tags->name;
                        }
                    }
                }
				?> 

				<div class="col-3">
					<a href="<?php the_permalink(); ?>" title="<?php the_title_attribute(); ?>">
						<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>> <?php
						
						#the_post_thumbnail(200,200);
						if ( has_post_thumbnail() ) {
							the_post_thumbnail();
						} else {
							?> <img src="https://dummyimage.com/200x200/EEEEEE/03659c&text=<?php echo $firsttag; ?>" class="rounded-square">
							 <?php
						}

						the_title();
						
						#get_template_part( 'content', get_post_format() );
						
						?> 
						</article><!-- #post-## -->
						
					</a>
				</div>

				<?php

			endwhile;
			?>
			</div>
			<div class="row">
				<div class="mx-auto">
				<?php
			do_action( 'storefront_loop_after' );

		else :

			get_template_part( 'content', 'none' );

		endif;
		?>
			</div>
		</div>
		</main><!-- #main -->
	</div><!-- #primary -->

<?php
do_action( 'storefront_sidebar' );
get_footer();
