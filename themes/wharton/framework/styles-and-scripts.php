<?php

/* #######################################################################

	Wharton - Load Front-end JS and CSS

####################################################################### */


add_action( 'wp_enqueue_scripts', 'meanthemes_load_css' );
function meanthemes_load_css() {
  wp_enqueue_style( 'default', get_bloginfo( 'stylesheet_url' ), array(), MEANTHEMES_THEME_VER, 'screen' , 'google-fonts' );
  wp_register_style( 'webfonts', get_template_directory_uri() . '/webfonts/leaguegothic.css', array(), MEANTHEMES_THEME_VER, 'screen' , 'web-fonts' );
  wp_enqueue_style( 'print', get_template_directory_uri() . '/print.css', array(), MEANTHEMES_THEME_VER, 'print' );

  if ( is_home() || is_404() ) {

   wp_enqueue_style('webfonts');

  }

}


add_action( 'wp_enqueue_scripts', 'meanthemes_load_ie_css' );
function meanthemes_load_ie_css()
{
	global $wp_styles;
	wp_register_style('lt-ie9', get_template_directory_uri() . '/ie.css', array(), MEANTHEMES_THEME_VER, 'screen');
	$wp_styles->add_data('lt-ie9', 'conditional', '(lt IE 9) & (!IEMobile)');
	wp_enqueue_style('lt-ie9');
}


add_action( 'wp_enqueue_scripts', 'meanthemes_load_js' );
function meanthemes_load_js() {
	wp_register_style( 'meanmenu', get_template_directory_uri() . '/assets/js/plugins/meanmenu.min.css', array(), '1.0.7', 'screen' , 'meanmenu' );
	wp_register_script('meanmenu',get_template_directory_uri() . '/assets/js/plugins/jquery.meanmenu.min.js',array('jquery'), '2.0.8', true);
	wp_register_script('jplayer',get_template_directory_uri() . '/assets/js/plugins/jquery.jplayer.min.js',array('jquery'), '1.0.0', true);
	wp_register_script('flexslider',get_template_directory_uri() . '/assets/js/plugins/jquery.flexslider-min.js',array('jquery'), '1.0.0', true);
	wp_register_script('slabtext',get_template_directory_uri() . '/assets/js/plugins/jquery.slabtext.min.js',array('jquery'), '2.3', true);
	wp_register_script('global', get_template_directory_uri() . '/assets/js/plugins/global-plugins.min.js',array('jquery'), MEANTHEMES_THEME_VER, false);
	wp_register_script( 'mt-scripts', get_template_directory_uri() . '/assets/js/scripts.min.js', array('jquery','global'), MEANTHEMES_THEME_VER, true );

  if ( is_single() || is_archive() || is_search()  || is_author() || is_front_page() || is_page_template('t-index.php') ) {
    wp_enqueue_script('jplayer');
    wp_enqueue_script('flexslider');
  }

  if ( is_home() || is_404() ) {

   wp_enqueue_script('slabtext');

  }

  if ( !is_home() || !is_404() ) {

   wp_enqueue_style('webfonts');

  }


  // Check theme options for using a standard menu
  if( get_theme_mod( 'use_standard_menu', '0' ) == '1' ) {

  	wp_enqueue_style('meanmenu');
  	wp_enqueue_script('meanmenu');

  }

	// load on all pages
    wp_enqueue_script('global');
    wp_enqueue_script('mt-scripts');

}


add_action( 'comment_form_before', 'enqueue_comments_reply' );
function enqueue_comments_reply() {
	if( get_option( 'thread_comments' ) )  {
		wp_enqueue_script( 'comment-reply' );
	}
}


function meanthemes_load_html5_shim() {
	echo '<!--[if lt IE 9]><script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script><![endif]-->';
}
add_action('wp_head', 'meanthemes_load_html5_shim', 95);

?>
