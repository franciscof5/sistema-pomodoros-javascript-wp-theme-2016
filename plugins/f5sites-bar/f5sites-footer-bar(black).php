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

add_action('wp_enqueue_scripts', 'load_scritps_footer');
//add_action("wp_footer", "generate_footer", 12, 2);
add_action("wp_head", "generate_footer", 12, 2);

function generate_footer() {
	$all_startups = array(
	["HOST", "www.f5sites.com", "Hospedagem e desenvolvimento profissional para empresas", "Hosting and professional development for companies"],
	["BLOG", "www.franciscomat.com", "Blog do CEO e dev Francisco Mat", "Blog of CEO and dev Francisco mat"],
	["POMODOROS", "www.pomodoros.com.br", "App para medir tempo de projetos", "Online time tracker for projects"],
	["CURSO", "www.treinamentoemfoco.com.br", "Treinamentom em Foco: Você e seu time mais produtivos do que nunca", "Focus Training: You and your team more productive than ever"],
	["LOJA", "www.lojasdomago.com.br", "Loja de brindes e produtos eletrônicos", "Gift & Electronics Store"],
	#["Curso de WordPress", "www.f5sites.com/startups-under-development/cursowp/", "WordPress course for brazilian market", "Curso de WordPress para programadores", "www.cursowp.com.br"],
	);

	#var_dump(get_option('stylesheet'));die;
	
	?>
	<style type="text/css">
		.row-container {
			background: #222 none repeat scroll 0 0;
			font-family: Open Sans,sans-serif;
			min-height: 32px;
			color: #666;
			padding-top:6px;
			background:#222;
			font-size: 13px;
			border-bottom: 3px solid #02385f;
		}
		.row-container .popover {
			text-align: center;
		}
		.row-container .popover h3 {
			font-family: Arial !important;
			color: #333 !important;
			font-weight: normal;
		}
		.row-container-twentyseventeen {
			width: 100%;
			position: absolute;
			z-index: 99;
		}
		.divlinks {
			color: #666;
			font-family: Open Sans,sans-serif;
			/*font-size: 10px;
			line-height: 15px;
			*/
			font-size: 12px;
			line-height: 32px;
			font-weight: 100;
			/*min-height: 40px;
			/*padding-top: 5px;*/
			text-transform: uppercase;
			text-align: justify;
		}
		.alogo {
			float:left;
			height: 34px;
			margin-right: 20px;
			margin-top: -8px;
			background: #024779;
			padding-right: 16px;
		}
		.alogo:hover {
			background: #02385f;
			color: #FFF
		}

		.alogo:before {
			content: "";
			display: block;
			width: 21px;
			height: 32px;
			position: absolute;
			top: 0;
			transform: skew(-25deg, 0deg);
			background: #02385f;
			left: 104px;
		}

		.alink {
			color:#CCC !important;
			font-family: Open Sans,sans-serif;
			text-decoration:none;
			font-weight: 100;
			text-decoration: none;
			letter-spacing: -1px;
			font-weight: 600;
		}
		.alink:hover {
			color: #549ED1 !important;
			text-decoration: none;
		}
		.aditional-links {
			background-color: #111;
			height: 40px;
			left: 110px;
			padding: 10px;
			position: absolute;
			top: -40px;
			display: none;
			min-width: 490px;
			/*width: 100%;*/
		}
		.contain-languages a {
			float: right;
			margin:0 4px;
		}
		/***/
		.icon {
			display: inline-block;
			width: 1em;
			height: 1em;
			stroke-width: 0;
			stroke: currentColor;
			fill: currentColor;
		}
	</style>

	<?php if(get_option('stylesheet')=="franciscomat-twentyseventeen") { ?>
		<div class='row-container row-container-twentyseventeen'> 	
	<?php } else  { ?>
		<div class='row-container'>
	<?php } ?>

	<?php
    if(function_exists('cp_displayPoints')) { ?>
		<div style="background: #982 none repeat scroll 0 0; border: 4px dashed #fff; border-radius: 4px; color: #fff; float: right; font-size: 14px; margin-left: 10px; min-height: 30px; min-width: 60px; padding: 4px;" data-toggle='popover' data-placement='top' title='"You F Cash balance, earn point using our services and spent in our virtual stores' data-trigger='hover' data-content='Portuguese: balanço F Cash, ganhe pontos usando nossos serviços e gaste em nossas lojas virtuais'>$ 
    	<?php cp_displayPoints(get_current_user_id()); ?>
    	</div> <?php
	} ?>

	<a href="https://www.f5sites.com/startups-navigator/" class="alogo" data-toggle='popover' data-placement='bottom' title="F5 Sites Startups Navigator" data-trigger='hover' data-content="Portuguese: Navegador de Startups F5 Sites"><img src='<?php echo plugins_url( "f5sites-2016-logo-conceito(branco)2x-not.png", __FILE__ ); ?>' alt="F5 Sites" /></a>
	
	<span class="showed-links hidden-xs">
		<?php if(function_exists("smartlang_generate_flag_links_current")) {
			smartlang_generate_flag_links_current(false);
		} else { ?>
			<img src="<?php echo plugins_url("br.png",__FILE__);?>" style="display: inline;" alt="BR">
		<?php } ?>
		<?php fore($all_startups);	?>
	</span>
	
	

		<div class="hidden-sm hidden-xs pull-right" style="padding-right: 10px;">
			
			<!--span class="glyphicon glyphicon-map-marker" aria-hidden="true"></span-->
			<!--svg class="icon icon-location2">
				<use xlink:href="<?php echo plugins_url('/location.svg', __FILE__) ?>#icon-location2"></use>
			</svg-->
			<!--img src="<?php echo plugins_url('/location.svg', __FILE__) ?>"-->
			<img src="<?php echo plugins_url('assets/location-icon-map-png-location-24-128.png', __FILE__) ?>"  alt="Pin" style="float: left; margin-top: 3px;">
			<span id="user_location_city" style="display: none;"></span> 
			<span id="user_location_region"></span>, 
			<span id="user_location_country">
				<?php if(isset($location['country']))
					echo $location['country'];
				else
					echo $local;
				?>
			</span>	
		</div>

		<?php if(function_exists('smartlang_show_lang_options')) { ?>
		<div class="contain-languages pull-right">
		<?php smartlang_show_lang_options(true); ?>
	<?php } ?>

	</div>

	</div>
	<script type="text/javascript">
		jQuery(function () {
			jQuery('[data-toggle="popover"]').popover();
			
			/*if(jQuery( ".storefront-handheld-footer-bar").length) {
				jQuery(".storefront-handheld-footer-bar").appendTo(document.body);
				if(jQuery(".storefront-handheld-footer-bar").is(":visible"));
					jQuery(".row-container").css("margin-bottom", "60px");
			}*/
			
			jQuery(".showed-links img").hover(function(){
				jQuery(".aditional-links").show(200);
			})
			jQuery(".row-container").mouseleave(function() {
				jQuery(".aditional-links").hide(200);
			});
			
		})
	</script>
	<?php
}

function fore($names_links_array) {
	#STYLES	
	$s=$_SERVER['HTTP_HOST'];
	#$names_links_array = $all_startups;
	#$s = 
	#echo $s;
	#var_dump($names_links_array);
	foreach ($names_links_array as $item) :
		$ns=$nt=$ntp='';
		if(isset($item[1])) {
			$s1 = rtrim($s, '/');
			if(dirname($item[1])==".")
				$s2 = ($item[1]);
			else
				$s2 = dirname($item[1]);
			#var_dump($s1);
			#var_dump($item[1]);
			#var_dump($s2);
			#die;
			if ($s1==$s2) {
				$ns=' style="color:#549ED1 !important;" ';#font-weight:100;
				$nt=' <you are here>';
				$ntp=' <você está aqui>';
			#	echo "<span style='background:#0365AD;border-radius:3px;'>";
			
				#echo "<a $ns class='alink'>".$item[0]."</a>";
			}	
		}
		echo " | ";
			echo "<a href='https://".$item[1]."' $ns class='alink'  data-toggle='popover' data-placement='bottom' title='".$item[2].$ntp."' data-trigger='hover' data-content='".$item[3].$nt."' >".$item[0]."</a>";
		#echo "F5 SITES WORDPRESS PHP WP MYSQL MANAGER";
		#echo "Settings: localdatabase name: <- PROCEED -> Remote name";
		#echo do_shortcode('');
	endforeach;
	?>
	
	<?php
}

function load_scritps_footer() {
	wp_enqueue_script('footerjs', plugins_url('/assets/bootstrap.min.js', __FILE__), '', time() );
	wp_enqueue_style('footercss', plugins_url('/assets/bootstrap.min.css', __FILE__), '', time() );
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
	#
	$in_project=array(

		["Ideias", "ideias.franciscomat.com"]);

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
	#["Startups", "www.f5sites.com/startups", "F5 Sites sponsored startups", "Conheça as startups patrocinadas pela F5Sites"],

	#DOMAIN GROUPS
	$global_st = array(
		["F5Sites", "www.f5sites.com", "IT Services For Global Startups", "Serviços para startups globais", "www.f5sites.com"],
		["Francisco Mat", "www.franciscomat.com", "Personal blog of CEO and full stack developer", "Blog pessoal do CEO e desenvolvedor full stack", "www.franciscomat.com"],
		["Pomodoros Global", "www.pomodoros.com.br/?lang=en_US", "Open source online app, time tracker for projects", "App online de código-aberto para medir tempo de projetos", "www.pomodoros.com.br"],
		#["Projectimer", "www.f5sites.com/startups/projectimer/", "App for teams and startups track project time", "App para times cronometrarem tempo de projeto", "www.projectimer.com"],
	);
<?php 
	$location="";
	#var_dump(class_exists("WC_Geolocation"));
	if(class_exists("WC_Geolocation")) {
		$location = WC_Geolocation::geolocate_ip();
		#var_dump($location);
		//$location['city'].$location['region']
		$local = $location['country'];
	} /*else {
		$local = "US";
		#die;
	}*
	if(!class_exists("WC_Geolocation") || $location["city"]=="") {
		#if(gethostname()!="note-samsung") ?>
		<script type="text/javascript">
		//jQuery( document ).ready(function() {
			jQuery.get("https://ipinfo.io?token=e7e9316dfdc5fa", function (response) {
				//alert(response.city);
			    //console.log("IP: " + response.ip);
				//console.log("Location: " + response.city + ", " + response.region);
				if(jQuery("#user_location_country").text()!=response.country) {
					//alert("geolocated ip from remote is different then woocommerce");
				}
				jQuery("#user_location_city").text(response.city);
				jQuery("#user_location_region").text(response.region);
				jQuery("#user_location_country").text(response.country);
				
			}, "jsonp");
		//}
		</script>
		
	<?php }

	if(!$local) {
		if(function_exists("locale_accept_from_http"))
		$local = locale_accept_from_http($_SERVER['HTTP_ACCEPT_LANGUAGE']);
		else
		$local = "en_US";
	}
	
	#if($local=="PT" || $local=="BR" || $local=="pt" || $local=="pt_BR" || $local=="pt_PT") { ?>
		<!--a href="https://br.f5sites.com/startups-brasil/" data-toggle='popover' data-placement='top' title="F5 Sites startups for Brazil" data-trigger='hover' data-content="Portuguese: F5 Sites startups para o Brasil"></a-->

		<?php /* } else { ?>
	<span class="aditional-links">
		<img src="<?php echo plugins_url("us.png",__FILE__);?>" style="display: inline;" alt="US">
		<?php fore($all_startups);	?>
	</span>
		<!--a href="https://www.f5sites.com/startups/" data-toggle='popover' data-placement='top' title="F5 Sites global startups" data-trigger='hover' data-content="Portuguese: F5 Sites startups de classe global"></a-->
		<div class="showed-links">
			<img src="<?php echo plugins_url("us.png",__FILE__);?>" style="display: inline;" alt="US">
			<?php fore($all_startups);	?>
		</div>
		<div class="aditional-links">
			<img src="<?php echo plugins_url("br.png",__FILE__);?>" style="display: inline;" alt="BR">
			<?php fore($all_startups);	?>
		</div>
	<?php }	*/ ?>
	
	<?php
	#var_dump($local);die;
	/*###############
	<a href="https://www.f5sites.com/startups-under-development/" class="alink" data-toggle='popover' data-placement='top' title="F5 Sites startups Under development" data-trigger='hover' data-content="Portuguese: F5 Sites startups em desenvolvimento"><img src="<?php echo plugins_url("under-dev-icon.png",__FILE__);?>" style="display: inline;"></a>
	<?php fore($under_development);
	
	/*if(current_user_can('administrator')) {
		echo " In project: ";
		fore($in_project);
	}*/
	?>