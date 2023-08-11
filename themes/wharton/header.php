<!doctype html>
<html class="no-js<?php if( get_theme_mod( 'center_header', '0' ) == '1' ) { echo " center-header"; } ?><?php if( get_theme_mod( 'use_standard_menu', '0' ) == '1' ) { echo " d-menu"; } ?><?php if( get_theme_mod( 'hide_sidebar', '1' ) == '0' ) { echo " sidebar-on"; } ?><?php if ( get_theme_mod( 'use_subtle_layout', '0' ) == '1' ) { echo " subtle"; } ?> <?php page_bodyclass(); ?>" <?php language_attributes(); ?>>
<head>
	<title><?php
	if ( defined('WPSEO_VERSION') ) {

	 wp_title('');

	 } else {

	 	 if ( is_home() || is_front_page() ) { echo bloginfo('name'); ?> | <?php echo bloginfo('description'); } else { wp_title('| ', true, 'right'); echo bloginfo('name'); }

	 }
	  ?></title>



	<meta charset="<?php bloginfo( 'charset' ); ?>" />
	<link rel="profile" href="http://gmpg.org/xfn/11" />

	<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>" />
	<meta name="viewport" content="width=device-width, initial-scale=1, minimum-scale=1">

<?php

// Show Facebook Open Graph tags
if ( is_page() || is_single() ) { ?>

<?php

if ( has_post_thumbnail() ) { ?>

<?php $image = wp_get_attachment_image_src( get_post_thumbnail_id( $post->ID ), 'wide' ); ?>

<meta name="og:image" content="<?php echo $image[0]; ?>">

<?php }
} ?>

<?php

	// Check for Favicon and Apple Icon
	$favicon = get_theme_mod( 'favicon_image');
	$appleicon = get_theme_mod( 'appleicon_image');

 ?>

<?php if ( $favicon ) { ?>

	<link rel="icon" type="image/png" href="<?php echo $favicon; ?>" />

<?php } ?>
<?php if ( $appleicon ) { ?>

	<link rel="apple-touch-icon-precomposed" href="<?php echo $appleicon; ?>" />

<?php } ?>

<?php

	// Font Advanced JS/CSS
	echo get_theme_mod( 'font_advanced_service' , "<link href='http://fonts.googleapis.com/css?family=Noto+Serif:400,700,400italic,700italic|Lato:900' rel='stylesheet' type='text/css'>" );

	// Analytics JS
	echo get_theme_mod( 'google_analytics' );

 ?>




<?php wp_head(); ?>
</head>
<body <?php body_class(); ?> id="top">

<?php

	// Check theme option for background on.

	$backgroundOn = get_theme_mod( 'meanthemes_background_image');


 ?>

 <div class="wrap animated fadeIn">

	<header class="header">

		<div class="logo">

		<?php

		// Get a logo if there is one from theme options
		$logo = get_theme_mod( 'meanthemes_logo_image' );
		$logo_retina = get_theme_mod( 'meanthemes_logo_image_retina' );

		if ( $logo ) { ?>
		  <a href="<?php echo get_home_url(); ?>/" title="<?php get_theme_mod( 'text_logo_title' , 'Go to Home' ); ?>"><img id="logo" src="<?php echo $logo; ?>" alt="<?php get_theme_mod( 'text_logo_alt' , 'Logo' ); ?>" <?php if ($logo_retina) { echo ' data-fullsrc="' . $logo_retina . '"'; } ?> /></a>
		<?php } // end if ?>



		<?php

		// Hide the site title based on theme options

		if( false === get_theme_mod( 'hide_logo_text' ) ) { ?>

			<div class="blog-title"><a href="<?php echo get_home_url(); ?>/" title="<?php _e('Go to Home', 'meanthemes'); ?>">
			<?php
			// Check theme options to push logo text or logo image in
			?>
			<?php bloginfo('name'); ?>

			</a></div>

		<?php } ?>


		<?php
		// Check theme options for whether to show tagline

		if( get_theme_mod( 'hide_tagline', '1' ) == '0' ) { ?>

			<div class="blog-tagline"><?php bloginfo('description'); ?></div>


			<?php } ?>

		</div>

      	<?php

      	// Check theme options for using a standard menu
      	if( get_theme_mod( 'use_standard_menu', '0' ) == '1' ) { ?>

      		<nav class="sitenav-main" id="nav" role="navigation">
      			<?php wp_nav_menu( array( 'theme_location' => 'primary', 'container' => false, 'menu_id' => false, 'menu_class' => false ) ); ?>
      		</nav>

      	<?php } else {


      	 if ( false === get_theme_mod( 'hide_menu_icon' ) ) { ?>
      		<a id="menu-control" href="#nav" title="<?php echo get_theme_mod( 'text_menu_icon' , 'Menu' ); ?>"><?php echo get_theme_mod( 'text_menu_icon' , 'Menu' ); ?></a>
      	<?php
      		}
      	}
      	?>

	</header>



	<?php
	// Check theme options for using a standard menu
	if( get_theme_mod( 'use_standard_menu', '0' ) == '0' ) {
		get_template_part( '_part-site-navigation' );
	}
		?>


	<section class="main<?php if ( ( !is_page() ) && ( !is_single() ) ) { echo ' main-archive'; } ?><?php if ( is_page_template('t-index.php') ) { echo ' main-archive'; } ?>">
