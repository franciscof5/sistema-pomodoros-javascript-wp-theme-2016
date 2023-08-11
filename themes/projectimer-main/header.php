<?php
/**
 * The Header template for our theme
 *
 * Displays all of the <head> section and everything up till <div id="main">
 *
 * @package WordPress
 * @subpackage Twenty_Twelve
 * @since Twenty Twelve 1.0
 */

$page = basename($_SERVER["REQUEST_URI"]);

if($page=="wp-signup.php") {
	wp_redirect("/plugins/buddypress-br/registrar/");
} 
if($page=="times" || $page=="teams" || $page=="membro" || $page=="members") {
	if(get_current_user_id()=="")
		wp_redirect("/plugins/buddypress-br/registrar?warn=closed_to_members");
}

if($page=="times") {
	//wp_enqueue_script("page-times-js");

}

if($page=="register" && $_SERVER['HTTP_HOST']=="www.focalizador.com.br") {
	wp_redirect("/plugins/buddypress-br/registrar/");
}

if($page=="teams") {
	if($_SERVER['HTTP_HOST']=="www.focalizador.com.br")
	wp_redirect("/plugins/buddypress-br/times/");
	//wp_enqueue_script("page-teams-js");
}

?><!DOCTYPE html>
<!--[if IE 7]>
<html class="ie ie7" <?php language_attributes(); ?>>
<![endif]-->
<!--[if IE 8]>
<html class="ie ie8" <?php language_attributes(); ?>>
<![endif]-->
<!--[if !(IE 7) & !(IE 8)]><!-->
<html <?php language_attributes(); ?>>
<!--<![endif]-->
<head>
<meta charset="<?php bloginfo( 'charset' ); ?>" />
<meta name="viewport" content="width=device-width" />
<title><?php wp_title( '|', true, 'right' ); ?></title>
<link rel="profile" href="http://gmpg.org/xfn/11" />
<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>" />
<?php // Loads HTML5 JavaScript file to add support for HTML5 elements in older IE versions. ?>
<!--[if lt IE 9]>
<script src="<?php echo get_template_directory_uri(); ?>/js/html5.js" type="text/javascript"></script>
<![endif]-->
<?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>
<div id="page" class="hfeed site">
	<header id="masthead" class="site-header" role="banner">
		<hgroup>
			<h1 class="site-title"><a href="<?php echo esc_url( home_url( '/' ) ); ?>" title="<?php echo esc_attr( get_bloginfo( 'name', 'display' ) ); ?>" rel="home"><?php bloginfo( 'name' ); ?></a></h1>
			<h2 class="site-description"><?php bloginfo( 'description' ); ?></h2>
		</hgroup>

		<nav id="site-navigation" class="main-navigation" role="navigation">
			<button class="menu-toggle"><?php _e( 'Menu', 'twentytwelve' ); ?></button>
			<a class="assistive-text" href="#content" title="<?php esc_attr_e( 'Skip to content', 'twentytwelve' ); ?>"><?php _e( 'Skip to content', 'twentytwelve' ); ?></a>
			<?php wp_nav_menu( array( 'theme_location' => 'primary', 'menu_class' => 'nav-menu' ) ); ?>
		</nav><!-- #site-navigation -->

		<?php if ( get_header_image() ) : ?>
		<a href="<?php echo esc_url( home_url( '/' ) ); ?>"><img src="<?php header_image(); ?>" class="header-image" width="<?php echo esc_attr( get_custom_header()->width ); ?>" height="<?php echo esc_attr( get_custom_header()->height ); ?>" alt="<?php echo esc_attr( get_bloginfo( 'name', 'display' ) ); ?>" /></a>
		<?php endif; ?>
	</header><!-- #masthead -->
	<?php 
		if(isset($_GET["warn"])) {
		if($_GET["warn"]=="closed_to_members") { ?>
			<div class="alert alert-danger" role="alert"><span class="glyphicon glyphicon-exclamation-sign" aria-hidden="true"></span>
				<?php 
				if($_SERVER['HTTP_HOST']=="www.focalizador.com.br") {
					echo 'Por favor crie uma conta ou <a href=#faça class="open_settings_modal" data-toggle="modal" data-target="#login_modal" style="color:#A94442;text-decoration:underline;">faça o login</a> para ver o conteúdo exclusivo';
				} else {
					echo 'Please create an account or <a href=#faça class="open_settings_modal" data-toggle="modal" data-target="#login_modal" style="color:#A94442;text-decoration:underline;">login</a> before see members and teams"';
					//_e(" ", "projectimer-main");
				} ?>
			</div>
		<?php }
		}	?>
	<?php #do_action( 'projectimer_display_login_modal' ); ?>
	<div id="main" class="wrapper">