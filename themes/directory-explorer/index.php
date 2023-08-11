<?php 
/*
//ORIGINAL FROM wp-minion		
get_header(); ?>
<div id="primary" class="content-area">
	<div class="primary-inner">
		<div id="content" class="site-content content-list" role="main">
		<?php 
		if ( have_posts() ) : 
			while ( have_posts() ) : the_post(); 
				get_template_part( 'content', get_post_format() ); 
			endwhile;
			dw_minion_content_nav( 'nav-below' ); 
		else : 
			get_template_part( 'no-results', 'index' ); 
		endif; 
		?>
		</div>
	</div>
</div>
<?php get_sidebar('secondary'); ?>
<?php get_footer(); */ 
//END ORIGINAL
?>
<?php
get_header(); ?>
<div id="primary" class="content-area">
	<div class="primary-inner">
		<div id="content" class="site-content content-list" role="main">
		<?php 
			//TUT FROM http://wesbos.com/wordpress-list-posts-by-category/
	        // get all the categories from the database
        	$cats = get_categories();

            // loop through the categries
            foreach ($cats as $cat) {
                // setup the cateogory ID
                $cat_id= $cat->term_id;
                // Make a header for the cateogry
                //echo "<h4>".$cat->name."</h4>";
		
	    		//PART MODIFIED FROM TUT TO LOOK LIKE WP MINION THEME
	    		echo '<header class="page-header"><a href="'.get_bloginfo("url").'/category/plugins/" title="Ver todos os posts arquivados em plugins"><h1 class="page-title">wp-content/'.$cat->name.'</h1></a></header>';

				
                // create a custom wordpress query
                query_posts("cat=$cat_id&posts_per_page=100");
                // start the wordpress loop!
                if (have_posts()) : while (have_posts()) : the_post(); ?>
				<?php //PART MODIFIED FROM TUT TO LOOK LIKE WP MINION THEME // create our link now that the post is setup  ?>
				<?php get_template_part( 'content', get_post_format() ); ?>			
				<?php the_content(); ?>
                <?php endwhile; endif; // done our wordpress loop. Will start again for each category ?>
			<br style="margin-bottom:20px"; />
            <?php } // done the foreach statement ?>
		</div>
	</div>
</div>
<?php get_sidebar('secondary'); ?>
<?php get_footer(); ?>
?>
<?php /*
get_header(); ?>
<div id="primary" class="content-area">
	<div class="primary-inner">
		<div id="content" class="site-content content-list" role="main">
		<?php 
		//TUT FROM http://wesbos.com/wordpress-list-posts-by-category/
	        // get all the categories from the database
            	$cats = get_categories();
 
                // loop through the categries
                foreach ($cats as $cat) {
                    // setup the cateogory ID
                    $cat_id= $cat->term_id;
                    // Make a header for the cateogry
                    //echo "<h4>".$cat->name."</h4>";
			
		    //PART MODIFIED FROM TUT TO LOOK LIKE WP MINION THEME
		    echo '<header class="page-header"><a href="'.get_bloginfo("url").'/category/plugins/" title="Ver todos os posts arquivados em plugins"><h1 class="page-title">wp-content/'.$cat->name.'</h1></a></header>';

					
                    // create a custom wordpress query
                    query_posts("cat=$cat_id&posts_per_page=100");
                    // start the wordpress loop!
                    if (have_posts()) : while (have_posts()) : the_post(); ?>
			<?php //PART MODIFIED FROM TUT TO LOOK LIKE WP MINION THEME // create our link now that the post is setup  ?>
			<?php get_template_part( 'content', get_post_format() ); ?>			
                    <?php endwhile; endif; // done our wordpress loop. Will start again for each category ?>
		<br style="margin-bottom:20px"; />
                <?php } // done the foreach statement ?>
		</div>
	</div>
</div>
<?php get_sidebar('secondary'); ?>
<?php get_footer(); ?>

	    
