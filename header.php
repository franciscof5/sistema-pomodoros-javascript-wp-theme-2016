<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">

<html xmlns="http://www.w3.org/1999/xhtml" <?php language_attributes(); ?>>
	<head profile="http://gmpg.org/xfn/11">
		<meta http-equiv="Content-Type" content="<?php bloginfo('html_type'); ?>; charset=<?php bloginfo('charset'); ?>" />
		<title>
		<?php 
		$basename = basename($_SERVER['REQUEST_URI'],'/');
		if($basename=="calendar" or $basename=="calendario") {
			echo "Calendar";
		} else { 
			bp_page_title(); 
		} ?></title>
		<?php do_action( 'bp_head' ) ?>
		<meta name="generator" content="WordPress <?php bloginfo('version'); ?>" /> <!-- leave this for stats -->
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
				jQuery( "#login_login" ).click(function() {
					jQuery( "#loginlogbox" ).toggle("slow");
				});
				jQuery( "#settings_panel" ).click(function() {
					jQuery( "#settingsbox" ).toggle("slow");
				});
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
				
				
				<?php if ( is_user_logged_in() ) { ?> 
					<div class="contem-icone"><a title="Focar" href="<?php bloginfo('url'); ?>/focus/" alt="Focalizador"><div href="" id="icone-foc">&nbsp;</div><span class="icone-legenda">Focar</span></a></div>
					<div class="contem-icone"><a title="Encontrar colegas" href="<?php bloginfo('url'); ?>/members/" alt="Amigos"><div href="" id="icone-amigo">&nbsp;</div><span class="icone-legenda">Colegas</span></a></div>
					<div class="contem-icone"><a title="Fator produtividade" href="<?php bloginfo('url'); ?>/members/<?php  $current_user = wp_get_current_user(); echo $current_user->user_login  ?>"><div href="" id="icone-gauge">&nbsp;</div><span class="icone-legenda">Produtividade</span></a></div>
					<div class="contem-icone"><a title="Ranking dos mais produtivos" href="<?php bloginfo('url'); ?>/ranking/"><div href="" id="icone-rank">&nbsp;</div><span class="icone-legenda">Ranking</span></a></div>
					<div class="contem-icone"><a title="Calendário de desempenho" href="<?php bloginfo('url'); ?>/calendar/"><div href="" id="icone-calend">&nbsp;</div><span class="icone-legenda">Calendário</span></a></div>
				<?php } ?>
				<!--div class="contem-icone"><a title="Mural de pomodoros" href="<?php bloginfo('url'); ?>/mural/"><div href="" id="icone-mural">&nbsp;</div><span class="icone-legenda">Mural</span></a></div-->
				<!--a title="Comunidades" href="<?php bloginfo('url'); ?>/groups/"><div href="" id="icone-balao">&nbsp;</div></a-->
				<!--a title="Prêmios" href="<?php bloginfo('url'); ?>/pontos/"><div href="" id="icone-pontos">&nbsp;</div></a-->				
				<!--div class="contem-icone"><a title="Cronograma de entregas" href="<?php bloginfo('url'); ?>/calendar/"><div href="" id="icone-calend">&nbsp;</div><span class="icone-legenda">Entregas</span></a></div-->
				<div style="float:right;padding: 5px 10px;">
					 <?php if ( !is_user_logged_in() ) { ?> 
						<button  title="Acessar sua conta" id="login_login" tabindex="1" />Entrar</button>
						<a title="Criar uma conta Pomodoros.com.br" href="/wp-signup.php"><button>Registre-se</button></a>
					<?php } else { ?> 
						<button id="login_login">My Teams</button>
						<a title="Desconectar-se" href="<?php echo wp_logout_url( network_home_url() ); ?>"><button>Sair</button></a>
						<!--button title="Configurar tempo" id="settings_panel"  style="padding: 2px 15px;float: left;margin: 0 4px;"><img src="<?php bloginfo('stylesheet_directory'); ?>/images/settings-icon.png" /></button-->
					<?php } 
					//TOUR IDEIA - VOCE SABIA QUE O POMODOROS.COM.BR É FEITO COM POMODOROS.COM.BR - Aqui todos os colaboradores e fornecedores utilizam o sistema. Nós fazemos o pomodoros usando o pomodoros. Perguntamos para Francisco Matelli, programador do sistema, como era usar a ferramenta. "Do ponto de vista técnico é muito interessante, levando em conta que é uma aplicaćão na nuvem, enquanto estamos programando melhorias para a nova versão, usamos a versão antiga. Depois que a versão na nuvem é atualizada, basta atualizar o navegador e comećamos a trabalhar com a última versão do sistema. O grande segredo, e também grande dificuldade, é fazer essa transićão ser imperceptível para o usuário, não se pode perder nenhuma informaćão durante essas atualizaćões. Por isso que temos sempre duas versões do sistema rolando. Temos até uma terceira versão, porém não posso falar sobre esse projeto nesse momento."
					?> 
					<!--a title="Como usar o site Pomodoros.com.br!" href="#"><button>Tour</button></a-->
				</div>
			</div>
		</div><!-- #header -->

		<div id="loginlogbox">
			<?php if(is_user_logged_in()) { ?>
				<?php
				$blogs = get_blogs_of_user(get_current_user_id());
				
				if ( !empty($blogs) ) { ?>
					<h3><?php _e( 'My Teams' ) ?></h3>
					<ul>
						<?php 
						if(count($blogs)<=1) {
							_e('you are member of no teams, try join one', 'projectimer-root');
						} else {
							_e('you are member of', 'projectimer-root');
						}
						//
						foreach ( $blogs as $blog ) {
							//var_dump($blog);
							$home_url = get_home_url( $blog->userblog_id );
							//
							if($blog->userblog_id>1) {
								echo '<p><a href="' . esc_url( $home_url ) . '">' . $blog->blogname . '</a></p>';
							}
						} ?>
					</ul>
					<br />
				<?php } ?>
				<h3>Joining Teams</h3>
				<p>To enter in a private team you must have the link or get an invite by email.</p>
				<p>You can ask to join in <a href="/teams/" alt="See public teams">public teams</a> or <a href="/wp-signup.php">create you own team</a>.</p>
			<?php } else { ?>
				<?php wp_login_form(); ?>
				<div style="margin-top:-10px;">
					<?php do_action( 'bp_after_sidebar_login_form' ); ?>
				</div>
			<?php } ?>
		</div>

		<div id="settingsbox">
			BOTAO FECHAR
			TEAM SETTINGS
			Language:
			Public: (visible to search engine and so on site root teams page)
			<!--h3>Tempo do pomodoro:</h3>
			<sub>Recomendamos aos usuários não mudarem o tempo dos pomodoros, se esforce para se adaptar aos 25 minutos que vale a pena</sub-->
			<p>Você pode utilizar nossos sitema para medir o tempo de diversas maneiras, mas lembre-se, para participar dos sorteios de prêmios é preciso usar a configuraćão oficial</p>
			<p>VOLUME: </p>
			<h3>Tipo de relógio</h3>
			<p>Técnica dos Pomodoros - Configuraćões oficiais [participa em sorteios]</p>
			<p>Técnica dos Pomodoros - ConfiguraćÕes do usuário</p>
			<div>
				<form>
				Tempo do pomodoro:
				Tempo do descanso:
				Intervalo entre pomodoros:
				checkbox - Declaro que não participarei dos sorteios
				</form>
			</div>
			<p>Crônometro convencional com intervalo regressivo</p>
			<p>Crônometro convencional sem intervalo</p>
			<h3>Marcador de ponto</h3>
			<p>Ativar marcador de entrada e saída de expediente?</p>
		</div>
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
