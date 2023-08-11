<?php 
$campos_customizados = get_post_custom($p->ID);
$categorias = get_the_terms($p, "categoria");

if(array_key_exists("tipo_assinatura",$campos_customizados))
$tipo_assinatura = $campos_customizados["tipo_assinatura"][0];
else
$tipo_assinatura = "gratuito";

if(has_term("alimentacao", "categoria", $p->ID)) {
	$iconURL = get_bloginfo( 'stylesheet_directory' ) . '/images/alimentacao/default-marker-alimentacao-'.$tipo_assinatura.'.png';
} elseif(has_term("beleza", "categoria", $p->ID)) {
	$iconURL = get_bloginfo( 'stylesheet_directory' ) . '/images/beleza/default-marker-beleza-'.$tipo_assinatura.'.png';
} elseif(has_term("casa-e-construcao", "categoria", $p->ID)) {
	$iconURL = get_bloginfo( 'stylesheet_directory' ) . '/images/casa-e-construcao/default-marker-casa-e-construcao-'.$tipo_assinatura.'.png';
} elseif(has_term("comercio", "categoria", $p->ID)) {
	$iconURL = get_bloginfo( 'stylesheet_directory' ) . '/images/comercio/default-marker-comercio-'.$tipo_assinatura.'.png';
} elseif(has_term("industria", "categoria", $p->ID)) {
 	$iconURL = get_bloginfo( 'stylesheet_directory' ) . '/images/industria/default-marker-industria-'.$tipo_assinatura.'.png';
} elseif(has_term("servicos", "categoria", $p->ID)) {
	$iconURL = get_bloginfo( 'stylesheet_directory' ) . '/images/servicos/default-marker-servicos-'.$tipo_assinatura.'.png';
}
global $tipo_assinatura_filtrada;

if(isset($tipo_assinatura_filtrada) and $tipo_assinatura_filtrada!==$tipo_assinatura)
	return;
//echo $iconURL;
//$iconURL = get_bloginfo( 'stylesheet_directory' ) . '/images/default-marker-alimentacao-ouro.-'.$tipo_assinatura.'.png';

//GLOBAL $addressCasa;
//var_dump($GLOBALS);
//echo $GLOBALS['adressCasa'];
//echo $addressCasa;die;
?>
<?php 
//var_dump($p->post_modified);
?>

<li id="<?php esc_attr_e( self::PREFIX ); ?>list-item-<?php esc_attr_e( $p->ID ); ?>" class="<?php esc_attr_e( self::PREFIX ); ?>list-item <?php echo $tipo_assinatura?>" data-tipo-assinatura="<?php echo $tipo_assinatura?>" data-ultima-alteracao="<?php echo $p->post_modified ?>" data-local-id="<?php echo $p->ID; ?>">
<div style="position:relative;">
	<div class="aplicar-assinatura" style="display:none;">
		<p><?php echo $p->post_title; ?></p>
		<ul class="contem-botao-trocar-assinatura">
    	<?php  
		$args = array( 'post_type' => 'product', 'posts_per_page' => 0, 'product_cat' => 'divulgar-empresas' );
		$loop = new WP_Query( $args );
		$desabilitado = "";
		while ( $loop->have_posts() ) : $loop->the_post(); 
		global $product; 
		$detalhes = $product->post;
		$qty_atual = get_user_meta(get_current_user_id(), $product->id, true );
		//var_dump($product);
		//var_dump($detalhes);
		if($tipo_assinatura == $detalhes->post_name) {
			$desabilitado = "selecionado";
		}
		?>
		<li class='botao-trocar-assinatura <?php echo $desabilitado; ?>' data-assinatura-id='<?php echo $product->id ?>' data-assinatura-nome='<?php echo $detalhes->post_title ?>' data-assinatura-slug="<?php echo $detalhes->post_name ?>" data-assinatura-quantidade="<?php echo $qty_atual ?>">
			<?php echo woocommerce_get_product_thumbnail(array(20,20)); ?>
			<?php //var_dump($d); ?>
			<span class="assinaturas-disponiveis" >
				<?php echo ($qty_atual=="" ? "0" : $qty_atual); ?>
			</span>
			<?php //var_dump($product); die; //?>
		</li>
		<?php
		//}
		endwhile; 
		wp_reset_query(); 
		?>
		</ul>
	</div>
	<div class="caixa-elementos">
		<?php echo do_shortcode('[ratings id="'.$p->ID.'"]'); ?>
	</div>
	<?php
	if($tipo_assinatura=="prataNAAAAAAAAAAAAAAAAAAAAAAAAO") { ?>
		<div class="coluna-numero3">
			<div class="<?php esc_attr_e( self::PREFIX ); ?>list-description">
				<?php /* note: don't use setup_postdata/get_the_content() in this instance -- http://lists.automattic.com/pipermail/wp-hackers/2013-January/045053.html */ ?>
				<?php echo apply_filters( 'the_content', $p->post_content ); ?>
			</div>
		</div>
	<?php } ?>

	<div class="coluna-numero1">
		<?php 
		/*if ( $tipo_assinatura=="gratuito" ) { 
			echo "<img src=$iconURL  />";
		} else {
			echo "<img src=$iconURL  />";
			//echo "<img src=$iconURL  onclick=javascript:tracarRota($campos_customizados.[\"bgmp_address\"][1] /> ";
		}*/
		 ?>

		<?php if ( $tipo_assinatura=="gratuito" ) { ?>
    		<img src="<?php echo $iconURL ?>" alt="icone" />
    	<?php } if ( $tipo_assinatura!="gratuito" ) { ?>
    		<img src="<?php echo $iconURL ?>" alt="icone" onclick='javascript:tracarRota("<?php echo $campos_customizados["bgmp_address"][1]?>")' />
    	<?php } ?>

    	<input type="hidden" value="<?php echo $campos_customizados["bgmp_latitude"][0]?>" id="casa_lat">
		<input type="hidden" value="<?php echo $campos_customizados["bgmp_longitude"][0]?>" id="casa_lon">
    	<span class="distancia-casa"></span>
    	
	</div>

	<div class="coluna-numero2">

	<a href="<?php bloginfo('url') ?>/<?php echo $p->post_name ?>">
	<p class="<?php esc_attr_e( self::PREFIX ); ?>list-placemark-title titulo-local">
	  <?php echo apply_filters( 'the_title', $p->post_title ); 
	  /*
	  //Nao sei que porra eh esse por isso comentei
	  if( $viewOnMap ) : ?>
	    <span class="<?php esc_attr_e( self::PREFIX ); ?>view-on-map-container">
	      [<a href="javascript:;" data-marker-id="<?php esc_attr_e( $p->ID ); ?>" class="<?php esc_attr_e( self::PREFIX ); ?>view-on-map">View On Map</a>]
	    </span>
	  <?php endif; */ ?>
	</p>
	</a>
	<p>
		<span class="telefone">
			<?php
			//Esconde telefone de nao assinantes
			if($tipo_assinatura=="gratuito") {
				echo "não assinante";
			} else {
				if(array_key_exists("telefone",$campos_customizados)) {
					$from = $campos_customizados["telefone"][1];
					//1532726982
					$to = sprintf("(%s) %s-%s",
							substr($from, 0, 2),
							substr($from, 2, 4),
							substr($from, 4, 4));
					echo $to;
					
					/*$from = $campos_customizados["telefone"][2];
					if(""!=$from) {
						//1532726982
						$to = sprintf("(%s) %s-%s",
								substr($from, 0, 2),
								substr($from, 2, 4),
								substr($from, 4, 4));
						echo $to;
					}*/
				}
			}

			?>
		</span>
	</p>
	<p class="<?php esc_attr_e( self::PREFIX ); ?>list-link">
		<?php
		//Esconde endereco de nao assinantes
		if($tipo_assinatura=="gratuito") {
			echo "comprar assinatura";
		} else {
			echo $campos_customizados["bgmp_address"][1];
		//echo wp_kses( $address, wp_kses_allowed_html( 'post' ) );
		}
		?>
	</p>
	</div>
</div>
</li>
