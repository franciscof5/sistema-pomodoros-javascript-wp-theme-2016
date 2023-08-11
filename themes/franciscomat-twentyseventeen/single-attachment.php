<?php
/**
 * Template Name: Full Width
 *
 * Description: A custom template for displaying a fullwidth layout with no sidebar.
 *
 * @package Twenty Seventeen Child
 * https://gist.github.com/Netzberufler/792a74d63f24aadcad444f4c9d415c11
 */
get_header(); ?>
<style type="text/css">
	.entry-content img{
		background: #FFF;
	}
	.entry-content a {
		box-shadow: none !important;
	}
	#primary {
		width: 52% !important;
	}
	#secondary {
		width: 43% !important;
	}
	/*#primary, #secondary {
		width: 50% !important;
	}*/
</style>
<div class="wrap">
	<div id="primary" class="content-area">
		<main id="main" class="site-main" role="main">
			<?php
			while ( have_posts() ) : the_post();

				get_template_part( 'template-parts/page/content', 'page' );
				// If comments are open or we have at least one comment, load up the comment template.
				#if ( comments_open() || get_comments_number() ) :
				#	comments_template();
				#endif;
			endwhile; // End of the loop.
			?>

		</main><!-- #main -->
	</div><!-- #primary -->

	<aside id="secondary" class="widget-area" role="complementary">
		<h2><a href="https://portfolio.franciscomat.com/category/product-type/logo/">Logos</a></h2>
		<?php
		$args = array(
		    'post_type'		=> 'attachment',
		    'post_status'	=> 'published',
		    'numberposts'	=> -1,
		    'category'		=> '119',
		);

		$attachments = get_posts($args);

		$post_count = count ($attachments);

		if ($attachments) {
		    foreach ($attachments as $attachment) {
		    echo "<div class=\"post photo col3\" style='width:25%; float:left; padding:1%;'>";
		        $url = get_attachment_link($attachment->ID);// extraigo la _posturl del attachmnet      
		        $img = wp_get_attachment_url($attachment->ID);
		        $title = get_the_title($attachment->post_parent);//extraigo titulo
		        echo '<a href="'.$url.'"><img title="'.$title.'" src="'.$img.'" style="background:#FFF;"></a>';
		        echo "</div>";
		    }   
		}
		?>
	</aside>
</div><!-- .wrap -->

<?php get_footer();