<?php 
//NEW index.php, old is 404.php
get_header("fullpage"); 

wp_enqueue_script("fullpage-js");
wp_enqueue_style("fullpage-css");
wp_enqueue_style("fullPage_examples_examples.css");


locate_template( "part-index.php", true );

//get_footer();
?>
