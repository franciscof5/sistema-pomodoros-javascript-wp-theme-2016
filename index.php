<?php 
$page = basename($_SERVER["REQUEST_URI"]);
//var_dump($_SERVER['HTTP_HOST']);die;
if (!is_user_logged_in() and $page!="focus")
	wp_redirect(get_bloginfo('url')."/focus");

if($page==basename(get_bloginfo("url")) || $page==NULL || $page=="") {
	wp_redirect(get_bloginfo('url')."/activity");
}
get_header(); ?>

<!--div id="loading-message"><p>.</p><p class="dots">..</p></div-->

<div id="content" class="container">
	<div class="row">
		<?php
		$page = basename($_SERVER["REQUEST_URI"]);
		$pages = array("focus", "calendar", "ranking", "teams", "me", "members");
		#var_dump($page);die;
		
		if($page==basename(get_bloginfo("url")) || $page==NULL || $page=="") {
			//$page=="" probably when a domain over
			#todo: colocar nos settings
			#wp_redirect("/activity");
			#locate_template( array( 'home-part.php' ), true );
			#var_dump(get_template_directory()."/css/activity-mural.css");die;
			#var_dump(
			wp_enqueue_style( "activity-mural");
			#);die;
			#echo "<link rel='stylesheet' href='".get_template_directory()."/css/activity-mural.css' type='text/css'>";
			locate_template( array( "activity/index.php" ), true );
			#locate_template( array( 'default.php' ), true );
			#die;
		} elseif(in_array($page, $pages)) {
			#var_dump("adasd");die;
			wp_enqueue_script("projectimer-js");
			locate_template( array( "page-".$page.".php" ), true );
			#wp_enqueue_script("/css/"$page.".css");
			#get_template_part($page);
		} else {
			#var_dump("a222dasd");die;
			locate_template( array( "default.php" ), true );
			#get_template_part("default.php");
		}

		?>
		
	</div>
</div><!-- #content -->

<?php get_footer() ?>
