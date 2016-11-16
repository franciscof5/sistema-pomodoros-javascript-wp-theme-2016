<?php
//
add_filter('show_admin_bar', '__return_false'); 
require_once( dirname( __FILE__ ) . '/required_plugins/required_plugins.php' );
add_action('init', 'theme_scripts');
function theme_scripts() {	
	//Theme
	wp_register_style( "activity-mural", get_template_directory()."/css/activity-mural.css");
	
	//Bootstrap
	wp_enqueue_style("boostrap-css", get_bloginfo("template_directory")."/css/bootstrap.min.css");
	wp_enqueue_script("boostrap-js", get_bloginfo("template_directory")."/js/bootstrap.min.js");
}
?>
