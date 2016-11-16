<!DOCTYPE html>

<html xmlns="http://www.w3.org/1999/xhtml" <?php language_attributes(); ?>>
	<head profile="http://gmpg.org/xfn/11">
		<meta http-equiv="Content-Type" content="<?php bloginfo('html_type'); ?>; charset=<?php bloginfo('charset'); ?>" />
		<title>
		<?php 
		$basename = basename($_SERVER['REQUEST_URI'],'/');
		if($basename=="calendar" or $basename=="calendario") {
			echo "Calendar";
		} else { 
			wp_title(); 
		} ?></title>
		<?php do_action( 'bp_head' ) ?>
		<meta name="generator" content="WordPress <?php bloginfo('version'); ?>" /> <!-- leave this for stats -->
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<link rel="stylesheet" href="<?php bloginfo('stylesheet_url'); ?>" type="text/css" media="screen" />
		<?php if ( function_exists( 'bp_sitewide_activity_feed_link' ) ) : ?>
			<link rel="alternate" type="application/rss+xml" title="<?php bloginfo('name'); ?> | <?php _e('Site Wide Activity RSS Feed', 'buddypress' ) ?>" href="<?php bp_sitewide_activity_feed_link() ?>" />
		<?php endif; ?>
		<?php if ( function_exists( 'bp_member_activity_feed_link' ) && bp_is_member() ) : ?>
			<link rel="alternate" type="application/rss+xml" title="<?php bloginfo('name'); ?> | <?php bp_displayed_user_fullname() ?> | <?php _e( 'Activity RSS Feed', 'buddypress' ) ?>" href="<?php bp_member_activity_feed_link() ?>" />
		<?php endif; ?>
		<?php if ( function_exists( 'bp_group_activity_feed_link' ) && bp_is_group() ) : ?>
			<link rel="alternate" type="application/rss+xml" title="<?php bloginfo('name'); ?> | <?php bp_current_group_name() ?> | <?php _e( 'Group Activity RSS Feed', 'buddypress' ) ?>" href="<?php bp_group_activity_feed_link() ?>" />
		<?php endif; ?>
		<link rel="alternate" type="application/rss+xml" title="<?php bloginfo('name'); ?> <?php _e( 'Blog Posts RSS Feed', 'buddypress' ) ?>" href="<?php bloginfo('rss2_url'); ?>" />
		<link rel="alternate" type="application/atom+xml" title="<?php bloginfo('name'); ?> <?php _e( 'Blog Posts Atom Feed', 'buddypress' ) ?>" href="<?php bloginfo('atom_url'); ?>" />
		<link rel="pingback" href="<?php bloginfo('pingback_url'); ?>" />
		<link href='http://fonts.googleapis.com/css?family=Lilita+One' rel='stylesheet' type='text/css'>
		<?php wp_head(); ?>
	<link href="<?php echo bloginfo('stylesheet_directory'); ?>/_inc/select2/select2.css" rel="stylesheet"/>
</head>

<?php if (function_exists('mbj_notify_bar_display')) { mbj_notify_bar_display(); }?>
<?php if (function_exists("activate_maintenance_mode")) { activate_maintenance_mode();} ?>

<body <?php body_class() ?> id="bp-default">
	<div id="wrapper">
		<?php do_action( 'bp_before_header' ) ?>
		
			<!--span id='linha-fundo<?php if (is_front_page()) echo "-home" ?>'></span-->
			<span id='linha-fundo'></span>
		<?php //} ?>
		<script type="text/javascript">
			jQuery().ready(function($) {
				/*$.each( "#header-content div span", function(index, value) {
					$(this).hide();
				});*/

				$( ".contem-icone " ).mouseenter(function() {
					//if(!$(this).find( ".icone-legenda" ).is(":animated"))
					//$(this).find( ".icone-legenda" ).attr("")
					if(!$(this).find(".icone-legenda" ).is(':visible') && !$(this).find( ".icone-legenda" ).is(":animated"))
					$(this).find( ".icone-legenda" ).show(600);
					/*$(this).*/
				});
				$( ".contem-icone" ).mouseleave(function() {
					//if(!$(this).find( ".icone-legenda" ).width)
					$(this).find( ".icone-legenda" ).hide(300);
				});
				$( ".icone-legenda" ).mouseenter(function() {
					$(this).hide();
				})
				/*jQuery( "#login_login" ).click(function() {
					jQuery( "#loginlogbox" ).toggle("slow");
				});
				jQuery( "#settings_panel" ).click(function() {
					jQuery( "#settingsbox" ).toggle("slow");
				});*/
			});
		</script>
		<div id="header">			
			<div id="header-content">
				
					<a title="Pomodoros.com.br" href="<?php bloginfo('url'); ?>">
						<!--img src="<?php bloginfo('stylesheet_directory'); ?>/images/pomodoro-logo-topo.png" id="pomodoros-topo"-->
						<div id="logo_generated">
							<?php echo bloginfo('name' ); ?>
						</div>
					</a>
				
				
				
					<div class="contem-icone"><a title="Focar" href="<?php bloginfo('url'); ?>/focus/" alt="Focalizador"><div href="" id="icone-foc">&nbsp;</div><span class="icone-legenda">Focar</span></a></div>
				<?php if ( is_user_logged_in() ) { ?> 
					<div class="contem-icone"><a title="Encontrar colegas" href="<?php bloginfo('url'); ?>/teams/" alt="Amigos"><div href="" id="icone-amigo">&nbsp;</div><span class="icone-legenda">Time</span></a></div>
					
					<div class="contem-icone"><a title="Ranking dos mais produtivos" href="<?php bloginfo('url'); ?>/ranking/"><div href="" id="icone-rank">&nbsp;</div><span class="icone-legenda">Ranking</span></a></div>
					<div class="contem-icone"><a title="Calendário de desempenho" href="<?php bloginfo('url'); ?>/calendar/"><div href="" id="icone-calend">&nbsp;</div><span class="icone-legenda">Calendário</span></a></div>
				
				<div class="contem-icone"><a title="Fator produtividade" href="<?php bloginfo('url'); ?>/members/<?php  $current_user = wp_get_current_user(); echo $current_user->user_login  ?>"><div href="" id="icone-gauge">&nbsp;</div><span class="icone-legenda">Produtividade</span></a></div>
				<?php } ?>
				<!--div class="contem-icone"><a title="Mural de pomodoros" href="<?php bloginfo('url'); ?>/mural/"><div href="" id="icone-mural">&nbsp;</div><span class="icone-legenda">Mural</span></a></div-->
				<!--a title="Comunidades" href="<?php bloginfo('url'); ?>/groups/"><div href="" id="icone-balao">&nbsp;</div></a-->
				<!--a title="Prêmios" href="<?php bloginfo('url'); ?>/pontos/"><div href="" id="icone-pontos">&nbsp;</div></a-->				
				<!--div class="contem-icone"><a title="Cronograma de entregas" href="<?php bloginfo('url'); ?>/calendar/"><div href="" id="icone-calend">&nbsp;</div><span class="icone-legenda">Entregas</span></a></div-->
				<?php do_action('projectimer_show_header_buttons'); ?>
			</div>
		</div><!-- #header -->
		
		<?php do_action('projectimer_show_header_popups'); ?>
		
		<?php do_action( 'bp_header' ) ?>
		<?php do_action( 'bp_after_header' ) ?>
		<?php do_action( 'bp_before_container' ) ?>
<?php
//get the language file
/*if(function_exists(qtrans_getLanguage)){
   if(qtrans_getLanguage() == "en")
	$filelang="en.js";
   else if(qtrans_getLanguage() == "pt")
	$filelang="pt-br.js";
} else {
	//If the function doesnt exists then call the default language
	$filelang="pt-br.js";
}
<script src="<?php bloginfo('stylesheet_directory'); ?>/pomodoro/languages/<?php echo $filelang ?>" type="text/javascript"></script>
*/
?>
