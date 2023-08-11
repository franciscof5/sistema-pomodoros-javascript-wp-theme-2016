<?php
//criado por Francisco Matelli Matulovic
//data-tag: 2016-04-06
//update-dat: 2016-10-07

#
//require_once( dirname( __FILE__ ) . '/required_plugins/required_plugins.php' );

#
add_filter('show_admin_bar', '__return_false'); 

#
add_action('init', 'theme_scripts');

function theme_scripts() {	
	//projectimer
	wp_enqueue_script("projectimer-theme-scripts", get_bloginfo("template_directory")."/js/projectimer-theme-scripts.js");

	//bootstrap
	wp_enqueue_style("boostrap-css", get_bloginfo("template_directory")."/css/bootstrap.min.css");
	wp_enqueue_script("boostrap-js", get_bloginfo("template_directory")."/js/bootstrap.min.js");

	//jquery colors
	wp_enqueue_script("jquery-color", get_bloginfo("template_directory")."/js/jquery.color-2.1.2.min.js");	

	
	//jquery ui
	#wp_enqueue_script("jquery-ui", get_bloginfo("template_directory")."/js/jquery-ui.min.js");
	#wp_enqueue_style("boostrap-css", get_bloginfo("template_directory")."/css/jquery-ui.min.css");
	#wp_enqueue_style("boostrap-css", get_bloginfo("template_directory")."/css/jquery-ui.theme.min.css");
}

?>
