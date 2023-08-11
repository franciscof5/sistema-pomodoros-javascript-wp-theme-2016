<?php
//
require_once("required_plugins/auto_enable.php");
?>
<!DOCTYPE html>
<html <?php language_attributes(); ?> manifest="/wp-content/themes/projectimer-theme/projectimer-theme.appcache">
	<!--TODO: why that? -> head profile="http://gmpg.org/xfn/11"-->
	<head>
		<meta http-equiv="Content-Type" content="<?php bloginfo('html_type'); ?>; charset=<?php bloginfo('charset'); ?>" />
		<title><?php echo bloginfo("title"); echo  " - "; echo bloginfo("description");//bp_page_title() ?></title>
		<?php do_action( 'bp_head' ) ?>
		<meta name="generator" content="WordPress <?php bloginfo('version'); ?>" /> <!-- leave this for stats -->
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<link rel="stylesheet" href="<?php bloginfo('stylesheet_url'); ?>" type="text/css"  /> <!--TODO: verificar -> media="screen" -->
		<?php if ( function_exists( 'bp_sitewide_activity_feed_link' ) ) : ?>
			<link rel="alternate" type="application/rss+xml" title="<?php bloginfo('name'); ?> | <?php _e('Site Wide Activity RSS Feed', 'buddypress' ) ?>" href="<?php bp_sitewide_activity_feed_link() ?>" />
		<?php endif; ?>
		<?php if ( function_exists( 'bp_member_activity_feed_link' ) && bp_is_user() ) : ?>
			<link rel="alternate" type="application/rss+xml" title="<?php bloginfo('name'); ?> | <?php bp_displayed_user_fullname() ?> | <?php _e( 'Activity RSS Feed', 'buddypress' ) ?>" href="<?php bp_member_activity_feed_link() ?>" />
		<?php endif; ?>
		<?php if ( function_exists( 'bp_group_activity_feed_link' ) && bp_is_group() ) : ?>
			<link rel="alternate" type="application/rss+xml" title="<?php bloginfo('name'); ?> | <?php bp_current_group_name() ?> | <?php _e( 'Group Activity RSS Feed', 'buddypress' ) ?>" href="<?php bp_group_activity_feed_link() ?>" />
		<?php endif; ?>
		<link rel="alternate" type="application/rss+xml" title="<?php bloginfo('name'); ?> <?php _e( 'Blog Posts RSS Feed', 'buddypress' ) ?>" href="<?php bloginfo('rss2_url'); ?>" />
		<link rel="alternate" type="application/atom+xml" title="<?php bloginfo('name'); ?> <?php _e( 'Blog Posts Atom Feed', 'buddypress' ) ?>" href="<?php bloginfo('atom_url'); ?>" />
		<link rel="pingback" href="<?php bloginfo('pingback_url'); ?>" />
		
		

		<!--link href='http://fonts.googleapis.com/css?family=Lilita+One' rel='stylesheet' type='text/css'-->
		<!-- Bootstrap (JS is on footer) -->
    	<!--link href="<?php //bloginfo('stylesheet_directory'); ?>/bootstrap/bootstrap.min.css" rel="stylesheet"-->
    		<!-- TO USE IN JAVASCRIPT FOR LOADING EXTERNAL FILES (alternative to wp_localize_script) -->
		<!--script type="text/javascript">var templateDir = "<?php //bloginfo('stylesheet_directory') ?>";</script-->
		<?php wp_head(); ?>
	</head>

<?php //if (function_exists('mbj_notify_bar_display')) { mbj_notify_bar_display(); }?>
<?php //if (function_exists("activate_maintenance_mode")) { activate_maintenance_mode();} ?>

<body <?php body_class() ?> id="projectimer-theme">
	<?php
	
	//
	do_action( 'bp_before_header' );
	do_action( 'bp_header' );
	do_action( 'projectimer_show_header_navbar' );
	do_action( 'bp_after_header' );
	do_action( 'bp_before_container' );
	
	//modals
	do_action( 'projectimer_display_login_modal' );
	do_action( 'projectimer_display_remove_user_modal' );
	do_action( 'projectimer_display_make_user_admin_modal' );
	do_action( 'projectimer_display_team_settings' );
	//echo "is_user_member_of_blog:".;die;
	//
	if(is_user_logged_in() && is_user_member_of_blog(get_current_user_id())) { 		
		do_action( 'projectimer_display_settings_modal' );
		do_action( 'projectimer_display_recent_activities_load_task_modal' );
	} else { ?>	
		<div id="closed_team_warning">
			<p>Team Admin closed <strong><?php bloginfo("name"); ?></strong>, you must ask to join Team.</p>
			<p>Create an account to preserve your time and track project statistics.</p>
			<p> Contact admin: <?php $admin_email =  get_blog_option(get_current_blog_id(), 'admin_email');
			$admin_user = get_user_by('email', $admin_email);
			#var_dump($admin_user);
			$admin_user_id = $admin_user->ID;
			$admin_user_login = $admin_user->user_login;
			$admin_user_display_name = $admin_user->display_name;
			if($admin_user_display_name=="") {
				$admin_user_display_name = "Team Admin";
			}
			#echo bp_core_get_userlink($admin_user_id);
			$link = 'http://focalizador.com.br/membro/'.$admin_user_login ?>
				<a href="<?php echo $link; ?>"><?php echo $admin_user_display_name; ?></a>
			</p>
		</div>	
		<?php 
		get_footer();
		die; ?>
<?php }