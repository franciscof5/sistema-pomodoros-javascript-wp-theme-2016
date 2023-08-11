<?php
get_header(); ?>
<style type="text/css">
	.entry-content a {
		box-shadow: none !important;
	}
</style>
<div class="wrap" style="position: relative;">
	<div id="primary1" class="content-area">
		<main id="main" class="site-main" role="main">
			<h1>Logos</h1>
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
			    echo "<div class=\"post photo col3\" style=\"position:relative;float:left;width:33%; padding:1%; \">";
			        $url = get_attachment_link($attachment->ID);// extraigo la _posturl del attachmnet      
			        $img = wp_get_attachment_url($attachment->ID);
			        $title = get_the_title($attachment->post_parent);//extraigo titulo
			        echo '<a href="'.$url.'"><img title="'.$title.'" src="'.$img.'" style="background:#FFF;"></a>';
			        echo '<div style="position:absolute; right:14px; bottom:14px; background:#000;">'.get_the_date("Y", $attachment->ID).'</div>';
			        #echo '<div style="position:relative;margin-left:-50px;">'.get_the_date("Y", $attachment->ID).'</div>';
			        echo "</div>";
			    }   
			}
			?>

		</main><!-- #main -->
	</div><!-- #primary -->

</div><!-- .wrap -->

<?php get_footer();