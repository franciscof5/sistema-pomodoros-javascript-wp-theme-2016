<?php

if(!function_exists("buddypress")) {
	//
	require_once(ABSPATH .'/wp-admin/includes/plugin.php');
	$plugin_path = 'buddypress/bp-loader.php';
	$result = activate_plugin( $plugin_path );
	if ( is_wp_error( $result ) ) {
		echo "Problema ao configurar seu novo site...";
	} else {
		wp_redirect("focus");
	}
}
/*
if(!function_exists("projectimer_load_scripts")) {
	$plugin_path = 'projectimer-plugin/projectimer.php';
	require_once(ABSPATH .'/wp-admin/includes/plugin.php');
	$result = activate_plugin( $plugin_path );
	if ( is_wp_error( $result ) ) {
		echo "Problema ao configurar seu novo site...";
	}
}
if(!function_exists("listSubscriptios")) {
	//
	require_once(ABSPATH .'/wp-admin/includes/plugin.php');
	$plugin_path = 'woocommerce-wpmu-subscriptio-check/woocommerce-wpmu-subscriptio-check.php';
	$result = activate_plugin( $plugin_path );
	if ( is_wp_error( $result ) ) {
		echo "Problema ao configurar seu novo site...";
	} else {
		wp_redirect("focus");
	}
}
if(!function_exists("invite_anyone_init")) {
	//
	require_once(ABSPATH .'/wp-admin/includes/plugin.php');
	$plugin_path = 'invite-anyone/invite-anyone.php';
	$result = activate_plugin( $plugin_path );
	if ( is_wp_error( $result ) ) {
		echo "Problema ao configurar seu novo site...";
	} else {
		wp_redirect("focus");
	}
}
/*
if(!function_exists("set_shared_database_schema")) {
	//
	require_once(ABSPATH .'/wp-admin/includes/plugin.php');
	$plugin_path = 'shared-wordpress-tables-posts-and-taxonomies-uploads-folder/shared-wordpress-tables-posts-and-taxonomies-uploads-folder.php';
	$result = activate_plugin( $plugin_path );
	if ( is_wp_error( $result ) ) {
		echo "Problema ao configurar seu novo site...";
	} else {
		wp_redirect("focus");
	}
}

if(!function_exists("set_shared_database_schema")) {
	//
	require_once(ABSPATH .'/wp-admin/includes/plugin.php');
	$plugin_path = 'shared-wordpress-tables-posts-and-taxonomies-uploads-folder/shared-wordpress-tables-posts-and-taxonomies-uploads-folder.php';
	$result = activate_plugin( $plugin_path );
	if ( is_wp_error( $result ) ) {
		echo "Problema ao configurar seu novo site...";
	} else {
		wp_redirect("focus");
	}
}
if(!class_exists("WooCommerce")) {
	//
	require_once(ABSPATH .'/wp-admin/includes/plugin.php');
	$plugin_path = 'woocommerce/woocommerce.php';
	$result = activate_plugin( $plugin_path );
	if ( is_wp_error( $result ) ) {
		echo "Problema ao configurar seu novo site...";
	} else {
		wp_redirect("focus");
	}
}

if(!class_exists("WC_Subscriptions")) {
	//
	require_once(ABSPATH .'/wp-admin/includes/plugin.php');
	$plugin_path = 'woocommerce-subscriptions/woocommerce-subscriptions.php';
	$result = activate_plugin( $plugin_path );
	if ( is_wp_error( $result ) ) {
		echo "Problema ao configurar seu novo site...";
	} else {
		wp_redirect("focus");
	}
}*/
?>