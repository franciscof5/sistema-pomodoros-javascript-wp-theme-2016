<?php
/* 
Plugin Name: F5 Sites | Footer Bar
Plugin URI: https://www.f5sites.com/software/wordpress/f5sites-footer-bar/
Plugin Description: Just put it on mu-plugins and style it editing the single file php code, made to be simple for developers. WordPress F5 Sites DEV projects. 
Author: Francisco Matelli Matulovic
Author URI: https://www.franciscomat.com/
License: GPLv3
Tags: mu-plugins, notice bars */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
#if(gethostname()!="05de832e2373" && ($_SERVER['SERVER_ADDR']!="45.33.113.61")) {
	#if(strpos($_SERVER["HTTP_HOST"], "franciscomat") || (strpos($_SERVER["HTTP_HOST"], "focalizador")))
	#	add_action("wp_footer", "generate_f5sites_bar", 12, 2);
	#else
	if( !strpos($_SERVER['SERVER_NAME'], "pomodoros.com.br") && !strpos($_SERVER['SERVER_NAME'], "focalizador.com.br") && !strpos($_SERVER['SERVER_NAME'], "projectimer.com")
	) {
		add_action("wp_head", "generate_f5sites_bar", 12, 2);
		add_action('wp_enqueue_scripts', 'load_scritps_f5sites_bar');
	}
#}
function load_scritps_f5sites_bar() {
	wp_enqueue_script('footerjs', plugins_url('/assets/bootstrap.min.js', __FILE__), '', time() );
	#wp_enqueue_style('footercss', plugins_url('/assets/bootstrap-theme.min.css', __FILE__), '', time() );
	wp_enqueue_style('footercss', plugins_url('/assets/bootstrap.min.css', __FILE__), '', time() );
	
	#wp_enqueue_style('fontcss', plugins_url('/assets/font.css', __FILE__), '', time() );
	#wp_enqueue_style('bootstrap4', 'https://stackpath.bootstrapcdn.com/bootstrap/4.1.1/css/bootstrap.min.css');
	#wp_enqueue_script( 'boot1','https://code.jquery.com/jquery-3.3.1.slim.min.js', array('jquery'));
  	#wp_enqueue_script( 'boot2','https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js', array('jquery'));
  	#wp_enqueue_script( 'boot2','https://stackpath.bootstrapcdn.com/bootstrap/4.1.1/js/bootstrap.min.js', array('jquery'));

}
function generate_f5sites_bar() { ?>
	<?php 
	/*-
	<?php if(!strpos($_SERVER["HTTP_HOST"], "franciscomat") && (!strpos($_SERVER["HTTP_HOST"], "focalizador"))) { ?>
		<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
	<?php } ?>
	<script src="https://code.jquery.com/jquery-3.4.1.slim.min.js" integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n" crossorigin="anonymous"></script>
	<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
	<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>
	*/ ?>

	
	<nav class="navbar navbar-expand-md navbar-light bg-light navbar-f5sites-bar">
		<a href="https://www.f5sites.com/" class="alogo navbar-brand" data-toggle='popover' data-placement='bottom' title="F5 Sites Startups Navigator" data-trigger='hover' data-content="Portuguese: Navegador de Startups F5 Sites"><img src='<?php echo plugins_url( "f5sites.com-logo.png", __FILE__ ); ?>' alt="F5 Sites" /></a>
		<?php /*
		<button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarF5links" aria-controls="navbarF5links" aria-expanded="false" aria-label="Toggle navigation">
			<span class="navbar-toggler-icon"></span>
		</button>

		<div class="collapse navbar-collapse" id="navbarF5links">
			<ul class="navbar-nav mr-auto">
				<li class="nav-item dropdown <?php check("f5sites.com"); ?>">
					<a class="nav-link dropdown-toggleCONFCLIT" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" data-placement="bottom" data-trigger="hover" data-content="Hosting and professional development for companies" data-original-title="Hospedagem e desenvolvimento profissional para empresas">Fnetwork <span class="caret"></span></a>
					<?php #check("f5sites.com", "current"); ?>
					<div class="dropdown-menu" aria-labelledby="navbarDropdown">
						<a class="dropdown-item" href="https://www.f5sites.com/">F5 Sites</a>
						<!--li role="separator" class="divider"></li-->
						<a class="dropdown-item" href="https://source.f5sites.com/">Source</a>
						<!--a class="dropdown-item" href="https://projects.f5sites.com/">Projects</a-->
						<a class="dropdown-item" href="https://hortical.f5sites.com/">Hortical</a>
						<!--li role="separator" class="divider"></li-->
						<a class="dropdown-item" href="https://pesquisa.f5sites.com/">Pesquisa</a>
					</div>
				</li>

				<li class="nav-item dropdown <?php check('franciscomat.com', 'active'); check('franciscomatelli.com.br', 'active'); ?>">
					<a class="nav-link dropdown-toggleCONFCLIT" href="#" id="navbarDropdown2" data-toggle="dropdown" data-placement="bottom" data-trigger="hover" data-content="Blog of CEO and dev Francisco mat" data-original-title="Blog do CEO e dev Francisco Mat">Francisco Matelli <span class="caret"></span></a>
					<?php #check("franciscomat.com", "current"); ?>
					<div class="dropdown-menu" aria-labelledby="navbarDropdown2">
						<a class="dropdown-item" href="https://www.franciscomat.com/">Blogs</a>
						<a class="dropdown-item" href="https://portfolio.franciscomat.com/">Portfolio</a>
						<a class="dropdown-item" href="https://www.franciscomatelli.com.br/">Blog UX/UI </a>
						<a class="dropdown-item" href="https://pensamentos.franciscomat.com/">Pensamentos</a>
					</div>
				</li>

				<li class="nav-item dropdown <?php check('focalizador.com', 'active'); check('projectimer.com', 'active'); ?>">
					<a class="nav-link dropdown-toggleCONFCLIT" href="#" id="navbarDropdown3" data-toggle="dropdown" data-placement="bottom" data-trigger="hover">Aplicativos <span class="caret"></span></a>
					
					<div class="dropdown-menu" aria-labelledby="navbarDropdown3">
						<a class="dropdown-item" href="https://www.projectimer.com/">Projectimer</a>
						<a class="dropdown-item" href="https://www.Pomodoros.com.br/" class="nav-link" data-toggle="popover" data-placement="bottom" title="" data-trigger="hover" data-content="Online time tracker for projects" data-original-title="App para medir tempo de projetos">Pomodoros</a>
						<a class="dropdown-item" href="https://www.focalizador.com.br/">Focalizador</a>
					</div>
				</li>

				<li class="nav-item dropdown <?php check('cursowp.com.br', 'active'); check('treinamentoemfoco.com.br', 'active'); ?>">
					<a class="nav-link dropdown-toggleCONFCLIT" href="#" id="navbarDropdown4" data-toggle="dropdown" data-placement="bottom" data-trigger="hover" data-content="" data-original-title="">Cursos <span class="caret"></span></a>
					<?php #check("franciscomat.com", "current"); ?>
					<div class="dropdown-menu" aria-labelledby="navbarDropdown4">
						<a href="https://www.cursowp.com.br" class="dropdown-item" data-toggle="popover" data-placement="bottom" title="" data-trigger="hover" data-content="WordPress course for brazilian market" data-original-title="Curso de WordPress para programadores">Curso de WordPress</a>
						<a href="https://www.treinamentoemfoco.com.br" class="dropdown-item" data-toggle="popover" data-placement="bottom" title="" data-trigger="hover" data-content="Focus Training: You and your team more productive than ever" data-original-title="Treinamentom em Foco: Você e seu time mais produtivos do que nunca">Treinamento em Foco</a>
					</div>
				</li>
			</ul>
			<ul class="navbar-nav">
					<li class="nav-item">
						<span href="#">
							<?php if(function_exists('cp_displayPoints')) { ?>
								<div style="background: #982 none repeat scroll 0 0; border: 4px dashed #fff; border-radius: 4px; color: #fff; float: right; font-size: 14px; margin-left: 10px; min-height: 30px; min-width: 60px; padding: 4px;" data-toggle='popover' data-placement='top' title='"You F Cash balance, earn point using our services and spent in our virtual stores' data-trigger='hover' data-content='Portuguese: balanço F Cash, ganhe pontos usando nossos serviços e gaste em nossas lojas virtuais'>$ 
								<?php cp_displayPoints(get_current_user_id()); ?>
								</div> 
							<?php } ?>
						</span>
					</li>
					<li  class="nav-item dropdown dropdown-langs">
						<?php /* <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown3" data-toggle="dropdown"  data-trigger="hover">
							<?php if(function_exists("smartlang_generate_flag_links_current")) {
								smartlang_generate_flag_links_current(false);
							} else { ?>
								<img src="<?php echo plugins_url("assets/br.png",__FILE__);?>" style="display: inline;" alt="br">
							<?php } ?>
						</a>
						<div class="dropdown-menu dropdown-langs" aria-labelledby="navbarDropdown3">
							<li>
								<?php smartlang_show_lang_options(true, true); ?>
							</li>
						</div> * ?>
						<a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">
							<?php if(function_exists("smartlang_generate_flag_links_current")) {
								smartlang_generate_flag_links_current(false);
							} else { ?>
								<img src="<?php echo plugins_url("assets/br.png",__FILE__);?>" style="display: inline;" alt="br">
							<?php } ?>
							<span class="caret"></span>
						</a>
						<ul class="dropdown-menu">
							<li>
								<?php smartlang_show_lang_options(true, true); ?>
							</li>
						</ul>

					</li>

					<li class="nav-item">
						<a href="#">
						*/ ?> 
						<span style="position: absolute;right: 0;font-size: 0.8rem;">
							<?php if(!class_exists("WC_Geolocation") || !isset($location)) { ?>
							<script type="text/javascript">
								jQuery( document ).ready(function() {
									jQuery.get("https://ipinfo.io?token=e7e9316dfdc5fa", function (response) {
										console.log("response", response);
										if(jQuery("#user_location_country").text()!=response.country) {
											//alert("geolocated ip from remote is different then woocommerce");
										}
										jQuery("#user_location_city").text(response.city+", ");
										jQuery("#user_location_region").text(response.region+", ");
										jQuery("#user_location_country").text(response.country);
									}, "jsonp");
								})
							</script>
						
						<?php } ?>
						<img src="<?php echo plugins_url('assets/location-icon-map-png-location-24-128.png', __FILE__) ?>"  alt="Loc:" style="float: left;">
						<span id="user_location_city"></span>
						<span id="user_location_region"></span>
						<span id="user_location_country">
							<?php if(isset($location['country']))
								echo $location['country'];
							else
								echo "Unkown location";
							?>
						</span>
						</span>
						<?php /*
						</a>
					</li>
					
					
				</ul>
		</div>
		*/ ?>
	</nav>
	
	<?php /* ?>
	<nav class="navbar navbar-default f5sites-bar">
		<div class="container-fluid">
			<!-- Brand and toggle get grouped for better mobile display -->
			<div class="navbar-header">
				<button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
					<span class="sr-only">Toggle navigation</span>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
				</button>
				<a href="https://www.f5sites.com/startups-navigator/" class="alogo navbar-brand" data-toggle='popover' data-placement='bottom' title="F5 Sites Startups Navigator" data-trigger='hover' data-content="Portuguese: Navegador de Startups F5 Sites"><img src='<?php echo plugins_url( "f5sites.com-logo.png", __FILE__ ); ?>' alt="F5 Sites" /></a>
			</div>

			<!-- Collect the nav links, forms, and other content for toggling -->
			<div class="collapse navbar-collapse">
				<ul class="nav navbar-nav">
					<li class="dropdown <?php check("f5sites.com"); ?>">
						<a href="https://www.f5sites.com" class="dropdown-toggle" data-toggle="dropdown" data-placement="bottom" data-trigger="hover" data-content="Hosting and professional development for companies" data-original-title="Hospedagem e desenvolvimento profissional para empresas">F5 Sites <span class="caret"></span></a>
						<?php #check("f5sites.com", "current"); ?>
						<ul class="dropdown-menu">
							<li><a href="https://www.f5sites.com/">F5 Sites</a></li>
							<li role="separator" class="divider"></li>
							<li><a href="https://source.f5sites.com/">Source</a></li>
							<li><a href="https://projects.f5sites.com/">Projects</a></li>
							<li><a href="https://hortical.f5sites.com/">Eco</a></li>
							<li role="separator" class="divider"></li>
							<li><a href="https://pesquisa.f5sites.com/">Pesquisa</a></li>
						</ul>
					</li>
					<li class="dropdown <?php check('franciscomat.com', 'active'); ?>">
						<a href="https://www.franciscomat.com" class="dropdown-toggle" data-toggle="dropdown" data-placement="bottom" data-trigger="hover" data-content="Blog of CEO and dev Francisco mat" data-original-title="Blog do CEO e dev Francisco Mat">Francisco Mat <span class="caret"></span></a>
						<?php #check("franciscomat.com", "current"); ?>
						<ul class="dropdown-menu">
							<li><a href="https://www.franciscomat.com/">Francisco Mat</a></li>
							<li role="separator" class="divider"></li>
							<li><a href="https://portfolio.franciscomat.com/">Portfolio</a></li>
							<li><a href="https://pensamentos.franciscomat.com/">Pensamentos</a></li>
						</ul>
					</li>
					<li class="<?php check('cursowp.com.br', 'active'); ?>">
						<a href="https://www.cursowp.com.br" data-toggle="popover" data-placement="bottom" title="" data-trigger="hover" data-content="WordPress course for brazilian market" data-original-title="Curso de WordPress para programadores">CursoWP</a>
					</li>
					<li class="<?php check('pomodoros.com.br', 'active'); ?>">
						<a href="https://www.pomodoros.com.br" data-toggle="popover" data-placement="bottom" title="" data-trigger="hover" data-content="Online time tracker for projects" data-original-title="App para medir tempo de projetos">Pomodoros</a>
					</li>
					<li class="<?php check('treinamentoemfoco.com.br', 'active'); ?>">
						<a href="https://www.treinamentoemfoco.com.br" data-toggle="popover" data-placement="bottom" title="" data-trigger="hover" data-content="Focus Training: You and your team more productive than ever" data-original-title="Treinamentom em Foco: Você e seu time mais produtivos do que nunca">Treinamento em Foco</a>
						<?php #check("treinamentoemfoco.com.br", "current"); ?>
					</li>
					
				</ul>
				<ul class="nav navbar-nav navbar-right">
					<li>
						<a href="#">
							<?php if(function_exists('cp_displayPoints')) { ?>
								<div style="background: #982 none repeat scroll 0 0; border: 4px dashed #fff; border-radius: 4px; color: #fff; float: right; font-size: 14px; margin-left: 10px; min-height: 30px; min-width: 60px; padding: 4px;" data-toggle='popover' data-placement='top' title='"You F Cash balance, earn point using our services and spent in our virtual stores' data-trigger='hover' data-content='Portuguese: balanço F Cash, ganhe pontos usando nossos serviços e gaste em nossas lojas virtuais'>$ 
								<?php cp_displayPoints(get_current_user_id()); ?>
								</div> 
							<?php } ?>
						</a>
					</li>
					<li>
						<a href="#">
						<?php
							if(!class_exists("WC_Geolocation") || !isset($location)) { ?>
							<script type="text/javascript">
								jQuery( document ).ready(function() {
									jQuery.get("https://ipinfo.io?token=e7e9316dfdc5fa", function (response) {
										console.log("response", response);
										if(jQuery("#user_location_country").text()!=response.country) {
											//alert("geolocated ip from remote is different then woocommerce");
										}
										jQuery("#user_location_city").text(response.city+", ");
										jQuery("#user_location_region").text(response.region+", ");
										jQuery("#user_location_country").text(response.country);
									}, "jsonp");
								})
							</script>
						
						<?php } ?>
						<img src="<?php echo plugins_url('assets/location-icon-map-png-location-24-128.png', __FILE__) ?>"  alt="Loc:" style="float: left; margin-top: 3px;">
						<span id="user_location_city"></span>
						<span id="user_location_region"></span>
						<span id="user_location_country">
							<?php if(isset($location['country']))
								echo $location['country'];
							else
								echo "Unkown location";
							?>
						</span>
						</a>
					</li>
					<li class="dropdown">
						<a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">
							<?php if(function_exists("smartlang_generate_flag_links_current")) {
								smartlang_generate_flag_links_current(false);
							} else { ?>
								<img src="<?php echo plugins_url("assets/br.png",__FILE__);?>" style="display: inline;" alt="br">
							<?php } ?>
							<span class="caret"></span>
						</a>
						<ul class="dropdown-menu">
							<li>
								<?php smartlang_show_lang_options(true, true); ?>
							</li>
							<!--li><a href="#">Another action</a></li>
							<li><a href="#">Something else here</a></li>
							<li role="separator" class="divider"></li>
							<li><a href="#">Separated link</a></li-->
						</ul>
					</li>
				</ul>
			</div><!-- /.navbar-collapse -->
		</div><!-- /.container-fluid 
		REFERENCE: https://getbootstrap.com/docs/3.4/components/#navbar-default	-->
	</nav>
	<?php / ?>
	<script type="text/javascript">
		/*jQuery(function () {
			jQuery('[data-toggle="popover"]').popover();

			jQuery(".showed-links img").hover(function(){
				jQuery(".aditional-links").show(200);
			})
			jQuery(".row-container").mouseleave(function() {
				jQuery(".aditional-links").hide(200);
			});
		})
	</script>
	*/ ?>
	<style type="text/css">
		.dropdown:hover>.dropdown-menu {
			display: block;
		}
		.dropdown-menu {
			top:96%;
			border-top-right-radius: 0;
			border-top-left-radius: 0;
			border-top:none;
		}
		.navbar-brand {
			padding: 0;
			margin: 0;
			font-size: 1rem;
		}
		.navbar-brand img {
			height: 24px;
		}
		.navbar-f5sites-bar {
			background: #E6E6E6 !important;
			padding: 0 1rem;
			z-index: 9999;
		}
		#navbarF5links {
			padding-top: 2px;
			background: #E6E6E6;
		}
		#navbarF5links > ol,
		#navbarF5links > ul {
			margin-left: 0 !important;
			margin-top: 0 !important;
		}
		.navbar-f5sites-bar img {
			max-width: 70px;
		}
		.navbar-toggler {
			border: 0;
			margin-top: -4px;
			background: transparent !important;
		}
		.navbar-toggler:hover {
			background: #09d;
			color: #FFF !important;
		}
		.nav-link {
			font-family: -apple-system,BlinkMacSystemFont,"Segoe UI",Roboto,"Helvetica Neue",Arial,"Noto Sans",sans-serif,"Apple Color Emoji","Segoe UI Emoji","Segoe UI Symbol","Noto Color Emoji";
			font-size: 1rem !important;
		}
		.nav-link a {
			font-size: 1rem !important;
		}
		li.active > a {
			color: #0056b3 !important;
		}
		.dropdown-langs a {
			display: inline-block;
			width: 100%;
			padding: 4px 10px;
		}
		.dropdown-langs a img {
			float: left;
			padding: 3px 6px;
		}
		.dropdown-item {
			color: #212529 !important;
		}
		.f5sites-bar {
			font-family: open_sansregular,sans-serif;
		}
	</style>
	<?php
	/* #if(get_option('stylesheet')=="franciscomat-twentyseventeen"); 
	<style type="text/css">
		
		.row-container-twentyseventeen {
			width: 100%;
			position: absolute;
			z-index: 99;
		}
	</style>
	*/
	?>

	<?php
}

function check($check, $type="active") {
	#echo $check.";".$type;
	if(strpos($_SERVER['HTTP_HOST'], $check)) {
		#echo "ADSSA";
		if($type=="current")
			echo '<span class="sr-only">(current)</span>';
		else
			echo 'active';
	}
}


/*
	$under_development = array(
		#["LOJASDOMAGO", "www.f5sites.com/startups-brasil/lojasdomago", "Brazilian online store for costumer goods", "Loja de brindes produtos eletrônicos", "www.lojasdomago.com.br"],
		["Focalizador", "www.f5sites.com/startups-brasil/focalizador", "Gamefied online app for teams track projects time", "App online gamificado para times cronometrarem tempo de projetos", "www.focalizador.com.br"],
		["Instituto de Pesquisa", "www.f5sites.com/startups-under-development/instituto-de-pesquisa/", "Online self-hosted survey tool", "Ferramenta de survey online para pesquisa", "pesquisa.f5sites.com"],
		
		["Treinamento em Foco", "www.f5sites.com/startups-under-development/treinamentoemfoco", "Learn how to be productive and relaxed", "Aprenda a usar seu tempo de forma produtiva e relaxante", "www.treinamentoemfoco.com.br"],
		["Hortaliças e Orgânicos", "www.f5sites.com/startups-under-development/hortical", "Green and sustaintability project sponsored by F5 Sites", "Projeto de reciclagem e produção de alimentos em garrafa PET", "hortical.f5sites.com"],
		["Pensamentos Curados", "www.f5sites.com/startups-under-development/pensamentos-curados", "Newsletter for daily toughts", "Pensamentos diários de manhã cedo para você", "pensamentos.franciscomat.com"]#,
		#["Mat's Portfolio", "www.f5sites.com/startups-under-development/portfolio", "Get in touch with Francisco works", "Portfolio de trabalhos do Francisco", "portfolio.franciscomat.com"],
		#["F5 Source", "www.f5sites.com/startups-under-development/source", "Our open source open directory", "Fontes de código-aberto que usamos", "source.f5sites.com"]
		);
	
	$discontinued=array(
		["ItapeMapa", "www.itapemapa.com.br"],
		["RedeMapas", "www.redemapas.com.br"],
		["Epizzaria", "www.epizzaria.com.br"],
		["www.grupof.com.br"],
		["www.qrlink.com.br"],
		["www.editoradeblogs.com.br"],
		["www.ondeabrir.com.br"],
		["www.contratador.com.br"],
		["F5 Projects", "projects.f5sites.com", "More information about our projects", "Mais informações sobre nossos projetos"]);
	
	$global_st = array(
		["F5Sites", "www.f5sites.com/startups/f5sites/", "IT Services For Global Startups", "Serviços para startups globais", "www.f5sites.com"],
		["Francisco Mat", "www.f5sites.com/startups/franciscomat-com/", "Personal blog of CEO and full stack developer", "Blog pessoal do CEO e desenvolvedor full stack", "www.franciscomat.com"],
		["Pomodoros USA", "www.f5sites.com/startups/pomodoros-usa/", "Open source online app, time tracker for projects", "App online de código-aberto para medir tempo de projetos", "www.pomodoros.com.br"],
		["Projectimer", "www.f5sites.com/startups/projectimer/", "App for teams and startups track project time", "App para times cronometrarem tempo de projeto", "www.projectimer.com"],
	);

	$brasil_st = array(
		["BRF5Sites", "www.f5sites.com/startups-brasil/br-f5sites", "Startups services for Brazil", "Serviços para startups no brasil", "br.f5sites.com"],
		["BRFrancisco Mat", "www.f5sites.com/startups-brasil/br.franciscomat.com", "Brazilian version of personal blog of CEO and full stack developer", "Versão brasileira do blog pessoal do CEO e desenvolvedor full stack", "br.franciscomat.com"],
		["BR Pomodoros", "www.f5sites.com/startups-brasil/pomodoros", "Open source online app, time tracker for projects", "App online de código-aberto para medir tempo de projetos", "www.pomodoros.com.br"],
		["Curso de WordPress", "www.f5sites.com/startups-under-development/cursowp/", "WordPress course for brazilian market", "Curso de WordPress para programadores", "www.cursowp.com.br"],
		
	);
	
	$global_st = array(
		["F5Sites", "www.f5sites.com", "IT Services For Global Startups", "Serviços para startups globais", "www.f5sites.com"],
		["Francisco Mat", "www.franciscomat.com", "Personal blog of CEO and full stack developer", "Blog pessoal do CEO e desenvolvedor full stack", "www.franciscomat.com"],
		["Pomodoros Global", "www.pomodoros.com.br/?lang=en_US", "Open source online app, time tracker for projects", "App online de código-aberto para medir tempo de projetos", "www.pomodoros.com.br"],
		#["Projectimer", "www.f5sites.com/startups/projectimer/", "App for teams and startups track project time", "App para times cronometrarem tempo de projeto", "www.projectimer.com"],
	);
*/