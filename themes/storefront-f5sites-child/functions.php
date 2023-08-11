<?php

add_action('wp_ajax_update_session', 'update_session');
add_action('wp_ajax_nopriv_update_session', 'update_session');

function update_session () {
	#$vok = update_user_meta(get_current_user_id(), "rangeVolume", $_POST['range_volume']);
	$session_json['challenger'] = "FASDASDAS";
	$session_json['test'] = $_POST['userchallenging'];
	#header('Content-type: application/json');//CRUCIAL
	echo json_encode($session_json);
}
#

function is_blog() {
	#
    return ( is_home() || is_single() || is_category() || is_archive() || is_front_page() || strpos($_SERVER['REQUEST_URI'], "blog") );
}

add_action( 'init', 'your_theme_init' );
function your_theme_init() {
	add_shortcode('startups-links', 'startups_link_generate');
	// Disable nesting check to allow inserted pages within inserted pages.
	#add_filter('insert_pages_apply_nesting_check','__return_false' );
}

function startups_link_generate($atts) {
	$alink='';
	
	if(!isset($atts['title']))
		$atts['title']="Visitar Site do Projeto";

	if(isset($atts['url']))
	$alink = '<br /><a href="https://'.$atts['url'].'" class="button">'.$atts['title'].'</a> <hr />';

	return $alink.do_shortcode('[insert page=3614]').do_shortcode('[insert page=4634]').do_shortcode('[insert page=5034]');
}

register_nav_menus(
	apply_filters(
		'storefront_register_nav_menus', array(
			'primary-en'   => __( 'Primary Menu En', 'storefront' ),
			'secondary-en' => __( 'Secondary Menu En', 'storefront' ),
			'handheld-en'  => __( 'Handheld Menu En', 'storefront' ),
		)
	)
);