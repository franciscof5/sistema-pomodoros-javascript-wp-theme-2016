<?php
/*
Plugin Name: F5 Sites | Bug Correction Hack Plugin
Plugin URI: https://www.f5sites.com/software/wordpress/f5sites-bug-correction-hack-plugin/
Plugin Description: When some 3rd part plugin has a bug and we dont modify it source code to avoid update issues, so we make changes in our custom hack plugin. WordPress F5 Sites DEV projects. 
Author: Francisco Matelli Matulovic
Author URI: https://www.franciscomat.com/
License: GPLv3
Tags: mu-plugins */

if( !defined( 'ABSPATH') ) exit();

#add_filter( 'woocommerce_persistent_cart_enabled', '__return_false' );
add_action( 'wpcf7_before_send_mail', 'cfdb7_pugin_activation_send', 10, 2 );
add_action( 'toplevel_page_cfdb7-list', 'cfdb7_pugin_activation_send' );
add_shortcode('show-age', 'whats_my_age_again');

show_admin_bar( false );
#add_action( 'woocommerce_before_main_content', 'redirect_from_default_archives_untill_find_better_hack');


add_filter('wc_session_expiring', 'filter_ExtendSessionExpiring' );
add_filter('wc_session_expiration' , 'filter_ExtendSessionExpired' );

function filter_ExtendSessionExpiring($seconds) {
    return 60 * 60 * 1; #era 71 em vez de 1, tentando resolver bug
}
function filter_ExtendSessionExpired($seconds) {
   return 60 * 60 * 1; #72
}


if(!is_admin()) { 
	add_action('wp_footer', 'correct_bugs_f5sites');
}


function redirect_from_default_archives_untill_find_better_hack() {
	if(is_shop()) {
		wp_redirect("/product-category/".$_SERVER["HTTP_HOST"]);
	}
}

####WOO CART COOKIE LOAD BUG FROM CROSS-STORES 




isset( $_COOKIE['woocommerce_cart_hash'] ) && define( 'DONOTCACHEPAGE', true );

# shortcode para woocommerce em pages
function url_shortcode() {
	return get_bloginfo('url');
}
#add_shortcode('current_blog_url','url_shortcode');

##

function cfdb7_pugin_activation_send() {
	#echo "cfdb7_pugin_activation_send(primeiro)";
	global $wpdb;
	$old_p = $wpdb->prefix;
	$wpdb->prefix="7fnetwork_";
}

function cfdb7_pugin_activation_init() {
	if(function_exists('cfdb7_pugin_activation')) {
		global $wpdb;
		$old_p = $wpdb->prefix;
		$wpdb->prefix="7fnetwork_";
		#var_dump($old_p);
		#die;
		cfdb7_pugin_activation();
		$wpdb->prefix=$old_p;
	}
}


function correct_bugs_f5sites() { ?>
	<style type="text/css">
		ul.post-meta {display: none;}
	</style>
<?php } 

#add_action( 'plugins_loaded', 'cfdb7_pugin_activation_init', 10, 2 );
#add_action( 'wpcf7_before_send_mail', 'cfdb7_pugin_activation_send', 10, 2 );
#add_action( 'cfdb7_admin_init', 'cfdb7_pugin_activation_send', 10, 2 );
/*
function cfdb7_pugin_activation_send() {
	echo "cfdb7_pugin_activation_send(primeiro)";
	global $wpdb;
	$old_p = $wpdb->prefix;
	$wpdb->prefix="7fnetwork_";
}

function cfdb7_pugin_activation_init() {
	if(function_exists('cfdb7_pugin_activation')) {
		global $wpdb;
		$old_p = $wpdb->prefix;
		$wpdb->prefix="7fnetwork_";
		#var_dump($old_p);
		#die;
		cfdb7_pugin_activation();
		$wpdb->prefix=$old_p;
	}
}*/

/************/
function whats_my_age_again($birthday) {
	extract( shortcode_atts( array(
		'birthday' => 'birthday'
	), $birthday));
	return date("Y", time() - strtotime($birthday)) - 1970;
}
