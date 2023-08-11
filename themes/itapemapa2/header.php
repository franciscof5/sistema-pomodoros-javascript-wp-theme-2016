<?php
/**
 * The Header for our theme
 *
 * Displays all of the <head> section and everything up till <div id="main">
 *
 * @package WordPress
 * @subpackage Twenty_Fourteen
 * @since Twenty Fourteen 1.0
 */
?><!DOCTYPE html>
<!--[if IE 7]>
<html class="ie ie7" <?php language_attributes(); ?>>
<![endif]-->
<!--[if IE 8]>
<html class="ie ie8" <?php language_attributes(); ?>>
<![endif]-->
<!--[if !(IE 7) | !(IE 8) ]><!-->
<html <?php language_attributes(); ?>>
<!--<![endif]-->
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<meta name="viewport" content="width=device-width">
	<title><?php wp_title( '|', true, 'right' ); ?></title>
	<link rel="profile" href="http://gmpg.org/xfn/11">
	<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>">
	<!--[if lt IE 9]>
	<script src="<?php echo get_template_directory_uri(); ?>/js/html5.js"></script>
	<![endif]-->
	<?php wp_head(); ?>

</head>

<body <?php body_class(); ?>>



<?php
//6386 agapito - gratutio
//3010 acougue gordo - ouro
/*var_dump($campos_customizados = get_post_custom(3010));
echo "<hr />";

if(array_key_exists("tipo_assinatura",$campos_customizados))
$l=$campos_customizados["tipo_assinatura"][0];
//var_dump($l);

/*if(in_array("tipo_assinatura",$campos_customizados))
	$tipo_assinatura = $campos_customizados["tipo_assinatura"][0];
elseif(in_array("_tipo_assinatura",$campos_customizados))
	$tipo_assinatura = $campos_customizados["_tipo_assinatura"][0];*/
/*if(isset($l))
	$tipo_assinatura = $l;
else
	$tipo_assinatura = "gratuito";

var_dump($tipo_assinatura);die;*/

//var_dump(get_bloginfo( 'stylesheet_directory' ) . '/images/default-marker-gratuito.png');die;
//echo $ip = $_SERVER['REMOTE_ADDR'];
//$details = json_decode(file_get_contents("http://ipinfo.io/{$ip}"));
//echo $details->city; // -> "Mountain View"

?>

<?php
//echo " asd";
//print_r($record = geoip_record_by_name($_SERVER["REMOTE_ADDR"]));
//    if ($record) {
//        print_r($record." -aaaaaaaaaaaaaaaaaaaaaaaaaaaaaaa");
//    }
//    die;
/*
<?php if ( is_user_logged_in() ) { ?>
	<div id="page" class="hfeed site">
<?php } else { ?>
	<div id="page" class="">
<?php } ?>*/

?>

<div id="page" class="hfeed site-DESATIVADO">
	<?php if ( get_header_image() ) : ?>
	<div id="site-header">
		<a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home">
			<img src="<?php header_image(); ?>" width="<?php echo get_custom_header()->width; ?>" height="<?php echo get_custom_header()->height; ?>" alt="">
		</a>
	</div>
	<?php endif; 
	// style="min-height:61px;"
	?>

	<header id="masthead" class="site-header" role="banner">
		<div class="header-main">
			<h1 class="site-title">
				<a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home">
					<img src='<?php bloginfo( "stylesheet_directory" ); ?>/images/itapemapa-logo-contraste-200x40.png'></img> 
				</a>
			</h1>

			<?php /*if ( is_user_logged_in() ) { ?> 
				<div id="seus-ativos">
					<a href="/suas-compras/seus-ativos/" alt="Visualizar seus ativos" class="ativos-title">Seus ativos
					<?php  
					$args = array( 
						'post_type' => 'product', 
						'posts_per_page' => 0, 
						'product_cat' => 'divulgar-empresas', 
						'meta_key' => '_regular_price',
            			'orderby' => 'meta_value_num',
						'order' => 'ASC' 
					);
					$loop = new WP_Query( $args );
					//var_dump($loop);die;
					while ( $loop->have_posts() ) : $loop->the_post(); 
						global $product; 
						//COM LINK PARA PRODUTO NA LOJA VIRTUALecho '<a href="'.get_permalink().'">'.woocommerce_get_product_thumbnail(array(30,30)).'</a>';
						//COM LINK PARA ATIVOS echo '<a href="/suas-compras/seus-ativos" class="ativos-title" style="padding:0 10px 0 0;">'.woocommerce_get_product_thumbnail(array(30,30));
						echo woocommerce_get_product_thumbnail(array(30,30));
						//echo '<a href="/suas-compras/seus-ativos/" alt="Visualizar seus ativos" class="ativo_qty">';
						echo $qty_atual = get_user_meta(get_current_user_id(), $product->id, true );
						if($qty_atual=="")
						echo " 0 ";
						//var_dump($product);
					endwhile; 
					wp_reset_query(); 
					?>
					</a>
				</div>
			<?php } */?>

			<?php #if ( is_user_logged_in() ) { ?> 
				<li class="loginlogout menu-item">
					<?php if ( is_user_logged_in() ) { ?> 
						<a href="<?php echo wp_logout_url( get_permalink() ); ?>" title="Desconectar-se" >Sair</a>
						<!--a href="<?php echo wp_logout_url('/') ?>">Log out</a-->
					<?php } /*else { ?>
						<a href="<?php echo esc_url( home_url( '/' ) ); ?>" title="Acessar o sistema">Acessar</a>
					<?php }*/ ?>
					
				</li>

				<div class="search-toggle">
					<a href="#search-container" class="screen-reader-text" aria-expanded="false" aria-controls="search-container"><?php _e( 'Search', 'twentyfourteen' ); ?></a>
				</div>

				<nav id="primary-navigation" class="site-navigation primary-navigation" role="navigation">
					<h1 class="menu-toggle"><?php _e( 'Primary Menu', 'twentyfourteen' ); ?></h1>
					<a class="screen-reader-text skip-link" href="#content"><?php _e( 'Skip to content', 'twentyfourteen' ); ?></a>
					<?php wp_nav_menu( array( 'theme_location' => 'primary', 'menu_class' => 'nav-menu' ) ); ?>

				</nav>
				<!--a href="#search-container" class="screen-reader-text"><?php _e( 'Search', 'twentyfourteen' ); ?></a-->
			<?php #} ?>
		</div>

		<div id="search-container" class="search-box-wrapper hide">
			<div class="search-box">
				<?php get_search_form(); ?>
			</div>
		</div>
	</header><!-- #masthead -->
<?php /*if ( !is_user_logged_in() and !is_front_page() ) { ?> 
<!--div style="
    width: 100%;
    height: 40px;
    background: #A00 none repeat scroll 0% 0%;
    color: #FFF;
    margin: 48px 0 -48px 0; /*HEADER POSITION FIXED*
    display:block;
    line-height: 40px;
    padding: 0px 0px 0px 3%;
    overflow: hidden;
	white-space: nowrap;
	display: inline;"></div-->
	<p style="
		font-family: nexa_lightregular;
		/*margin: 48px 0 -48px 0; /*HEADER POSITION FIXED*
    	width: 100%;
    	text-align:center;
    	background: #A00 none repeat scroll 0% 0%;
    color: #FFF;
    line-height: 40px;
    margin-bottom: 0;
    	">Conteúdo exclusivo: <a style="color:#FFF;font-family: nexa_boldregular;" href="/">acesse sua conta ou registre-se</a> para ter acesso.</p>
	
<?php }*/ ?>

<div id="main" class="site-main">
