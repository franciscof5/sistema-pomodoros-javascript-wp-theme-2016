<?php
/**
 * The Content Sidebar
 *
 * @package WordPress
 * @subpackage Twenty_Fourteen
 * @since Twenty Fourteen 1.0
 */

//if ( ! is_active_sidebar( 'sidebar-4' ) ) {
//	return;
//}
?>
<div id="content-sidebar" class="content-sidebar widget-area" role="complementary">

	<?php
	 dynamic_sidebar( 'sidebar-4' ); 

	 	if(isset($_GET["bgmp-category"])) {
			$catAtual = $_GET["bgmp-category"];
		} else {
			$t = explode("/", $_SERVER['REQUEST_URI']);
			$catAtual = $t[2];
		}
		echo $catAtual;
		var_dump($idd=get_term_by('name', $catAtual, 'categoria'));
		echo "<br /> adsasd";
		//var_dump($idd);
	 ?>
	<?php if (function_exists('get_most_rated_category')): ?>
    <ul>
        <?php //OK, mas geral, get_highest_rated(); ?>
        <?php 
        
        query_posts( 
        	array( 
        		'categoria' => $catAtual,
        		'post_type' => 'bgmp',
        		'meta_key' => 'ratings_average',
        		'orderby' => 'meta_value_num',
        		'order' => 'DESC'
        	) 
        ); 
        // The Loop
		while ( have_posts() ) : the_post();
		    echo '<li>';
		    the_title();
		    echo '</li>';
		endwhile;

		// Reset Query
		wp_reset_query();

        ?>
        <?php get_highest_rated_category(42, "bgmp", 0, 10); ?>
        <?php get_most_rated_category(42, "both"); ?>
        <?php get_highest_score_category(42); ?>
    </ul>
<?php endif; ?>
<?php if (function_exists('get_highest_rated_range')): ?>
    <ul>
        <?php get_highest_rated_range('1 day'); ?>
    </ul>
<?php endif; ?>
</div><!-- #content-sidebar -->
