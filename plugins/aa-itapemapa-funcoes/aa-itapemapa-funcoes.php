<?php
/*
Plugin Name: Aa Itapemapa Functions
Plugin URI: http://www.itapemapa.com.br
Description: Moves most functions away from functions.php
Author: Francisco Matelli
Version: 1.0
Author URI: http://www.franciscomatelli.com
License: GPL2
*/

/**
*
*  ESTRUTURA
*
*  AJAX
*  FUNCOES GENERICAS
*  TEMPLATE PAGES
*  PLUGIN WOOCOMMERCE
*  PLUGIN BGMP E LOCAIS 
*
**/

/* AJAX */
//solicita_orcamento ()
//aplica_assinatura ()

/* FUNCOES GENERICAS */
add_filter( 'show_admin_bar', '__return_false' ); 
add_action( 'wp_enqueue_scripts', 'itapemapa_scripts' );
add_action( 'admin_init', 'redirect_non_admin_users' );
add_action( 'init', 'jk_remove_wc_breadcrumbs' );
remove_action('wp_head', 'shortlink_wp_head'); //nao sei que isso

/* AJAX */
add_action( 'wp_ajax_solicita_orcamento', 'solicita_orcamento' );
add_action( 'wp_ajax_aplica_assinatura', 'aplica_assinatura' );

/* TEMPLATE PAGES */
add_action( 'wp_ajax_insert_placemark_frontend', 'insert_placemark_frontend' );

/* PLUGIN WOOCOMMERCE */
remove_action( 'admin_notices', 'woothemes_updater_notice');
add_filter( 'woocommerce_checkout_fields' , 'custom_override_checkout_fields' );
add_action( 'woocommerce_after_order_notes', 'my_custom_checkout_field' );
add_action( 'woocommerce_order_status_processing', 'mysite_woocommerce_payment_complete' );
add_action( 'woocommerce_payment_complete', 'mysite_woocommerce_payment_complete' );
add_action( 'manage_users_custom_column', 'mysite_custom_column_company', 15, 3);
add_filter( 'manage_users_columns', 'mysite_column_company', 15, 1);
add_filter('woocommerce_login_redirect', 'wcs_login_redirect');
add_action( 'woocommerce_register_form_start', 'wooc_extra_register_fields' );
add_action( 'woocommerce_register_post', 'wooc_validate_extra_register_fields', 10, 3 );


/* PLUGIN BGMP E LOCAIS */
add_action( 'wp_ajax_atualiza_endereco', 'atualiza_endereco' );
#add_action( 'bgmp_post-type-params', 'modifyPostTypeParams' );
add_action( 'parse_query', 'parse_event_query' );
add_filter( 'post_type_link', 'create_event_permalink', 10, 4 );
add_filter( 'bgmp_default-icon', 'setBGMPDefaultIconByCategory', 10, 2 );
add_action( 'wp', 'bgmpShortcodeCalled' );
add_action( 'admin_init', 'add_theme_caps');

//


/* FUNÇÕES GENÉRICAS */

// Registro de scripts diversos
function itapemapa_scripts() {
	wp_register_script('mascara-campos', plugins_url( '/jquery.mask.js', __FILE__ ));
	wp_register_script('gmaps-functions', plugins_url( '/gmaps-functions.js', __FILE__ ));
	wp_register_script('itapemapa-functions', plugins_url( '/itapemapa-functions.js', __FILE__ ));
	wp_register_script('modal-plugin', plugins_url( '/jquery.bpopup.js', __FILE__ ));
	//wp_localize_script('modal-plugin', 'ajaxurl', admin_url('admin-ajax.php') );
	//wp_register_script('modal-plugin', plugins_url( '/leanModal.js', __FILE__ ));
	//wp_register_script('facebook', plugins_url( '/facebook.js', __FILE__ ));
	wp_enqueue_script('itapemapa-functions');
}

// Redirect non admin users
function redirect_non_admin_users() {
	/*if ( ! current_user_can( 'manage_options' ) && '/wp-admin/admin-ajax.php' != $_SERVER['PHP_SELF'] ) {
		wp_redirect( home_url() );
		exit;
	}
	//disable /wp-login.php
	global $pagenow;
	if( 'wp-login.php' == $pagenow && $_GET['action']!="logout") {
		wp_redirect('/');
	exit();
	}*/
}

// Remove breadcumbs
function jk_remove_wc_breadcrumbs() {
    remove_action( 'woocommerce_before_main_content', 'woocommerce_breadcrumb', 20, 0 );
}

/* AJAX */

// content-bgmp.php (OUTROS NAO TESTEI) taxonomy-category.php or shortcode-bgmp-list-marker.php
function aplica_assinatura() {

	if ( isset($_REQUEST) ) {
		//$_REQUEST["localID"];
		$user_id = get_current_user_id();
		//check if user has the correct asset, if has signature available
		echo "ass_id_total:".$ass_id_total = (int)get_user_meta($user_id, $_REQUEST['assinaturaID'], true);
		if($ass_id_total>0) { 
			echo ", new_total:".$new_total = $ass_id_total-1;
			echo ", remove_one:".$remove_one = update_user_meta($user_id, $_REQUEST['assinaturaID'], $new_total);
			if($remove_one) {
				echo ", aplica_novo_tipo_assinatura:".$aplica_novo_tipo_assinatura = update_post_meta($_REQUEST["localID"], 'tipo_assinatura', $_REQUEST["assinaturaSlug"]);
				//TODO: check above
				$now = date('Ymd');
				//
				$current_user = wp_get_current_user();
				echo ", useremail:".$user_email = $current_user->user_email;
				//echo ", useremail:".$user_email = get_user_meta(get_current_user_id(), "user_email", true);
				//
				switch ($_REQUEST["assinaturaSlug"]) {
					case 'ouro':
						$altura = 3;
						echo ", email:".$atualizouemail = update_field("field_51dc4390560a6", $user_email, $_REQUEST["localID"]);
						break;
					case 'prata':
						$altura = 2;
						//echo ", email:".$atualizouemail = update_field("field_51dc4390560a6", $user_email, $_REQUEST["localID"]);
						break;
					case 'bronze':
						$altura = 1;
						break;
					default:
						# code...
						break;
				}
				
				echo ", da:".$data_ativacao = update_field("field_564ee658f356b", $now, $_REQUEST["localID"]);
				//echo ", da:".$data_ativacao = update_post_meta($_REQUEST["localID"], 'data_ativacao', $now);

				echo ", modifica_zINDEX:".$aplica_novo_zindex = update_post_meta($_REQUEST["localID"], 'bgmp_zIndex', $altura);
				
				//array to update the post 
				$my_post = array(
	        			'ID'            => $_REQUEST["localID"],
	        			'post_author'   => get_current_user_id(),
	    		);

	    		// update the post, which calls save_post again
	    		//echo "ATUALIZOU AUTOR?:";
	    		echo ", upd:".wp_update_post( $my_post );
				
				//return "tudo ok";
				//if($atualizaLocal) {}
				
				?>
				<div class="avisoHolder avisoSucesso">
					<p><strong>Assinatura aplicada!</strong></p>
					<p>O local agradece, feche a janela para recarregar o site.</p>
				</div>
				<?php
			}
		} else {
			echo "assinatura não disponível, compre uma assinatura";
		}
	}
	
	// Always die in functions echoing ajax content
	die();
}

// content-bgmp.php
function solicita_orcamento() {
	// The $_REQUEST contains all the data sent via ajax 
	if ( isset($_REQUEST) ) {
		//var_dump($_REQUEST);//array(8) { ["action"]=> string(18) "solicita_orcamento" ["nome"]=> string(17) "Francisco Matelli" ["email"]=> string(21) "francisco@f5sites.com" ["msg"]=> string(7) "aasdasd" ["localNome"]=> string(9) "Ita Aços" ["indicadorID"]=> string(1) "2" ["localID"]=> string(4) "5474" ["quemProcessa"]=> string(16) "proprietarioLoja" } 
		$campos_customizados = get_post_custom($_REQUEST["localID"]);
		//var_dump($campos_customizados);//array(30) { ["_edit_last"]=> array(2) { [0]=> string(1) "2" [1]=> string(1) "2" } ["bgmp_address"]=> array(2) { [0]=> string(41) "Humberto José F Notari 140, itapetininga" [1]=> string(41) "Humberto José F Notari 140, itapetininga" } ["bgmp_latitude"]=> array(2) { [0]=> string(11) "-23.5737834" [1]=> string(11) "-23.5737834" } ["bgmp_longitude"]=> array(2) { [0]=> string(11) "-48.0258819" [1]=> string(11) "-48.0258819" } ["bgmp_zIndex"]=> array(2) { [0]=> string(1) "0" [1]=> string(1) "0" } ["telefone"]=> array(2) { [0]=> string(10) "1533769222" [1]=> string(10) "1533769222" } ["_telefone"]=> array(2) { [0]=> string(19) "field_51dc398792d10" [1]=> string(19) "field_51dc398792d10" } ["telefone_2"]=> array(2) { [0]=> string(1) "0" [1]=> string(1) "0" } ["_telefone_2"]=> array(2) { [0]=> string(19) "field_522df2975f033" [1]=> string(19) "field_522df2975f033" } ["celular"]=> array(2) { [0]=> string(1) "0" [1]=> string(1) "0" } ["_celular"]=> array(2) { [0]=> string(19) "field_522df2cc5f034" [1]=> string(19) "field_522df2cc5f034" } ["website"]=> array(2) { [0]=> string(0) "" [1]=> string(0) "" } ["_website"]=> array(2) { [0]=> string(19) "field_51dc43ae560a7" [1]=> string(19) "field_51dc43ae560a7" } ["email"]=> array(2) { [0]=> string(0) "" [1]=> string(0) "" } ["_email"]=> array(2) { [0]=> string(19) "field_51dc4390560a6" [1]=> string(19) "field_51dc4390560a6" } ["facebook"]=> array(2) { [0]=> string(0) "" [1]=> string(0) "" } ["_facebook"]=> array(2) { [0]=> string(19) "field_51dc422481664" [1]=> string(19) "field_51dc422481664" } ["twitter"]=> array(2) { [0]=> string(0) "" [1]=> string(0) "" } ["_twitter"]=> array(2) { [0]=> string(19) "field_51dc429e57e99" [1]=> string(19) "field_51dc429e57e99" } ["google"]=> array(2) { [0]=> string(0) "" [1]=> string(0) "" } ["_google"]=> array(2) { [0]=> string(19) "field_51dc42a757e9a" [1]=> string(19) "field_51dc42a757e9a" } ["estacionamento"]=> array(2) { [0]=> string(4) "Não" [1]=> string(4) "Não" } ["_estacionamento"]=> array(2) { [0]=> string(19) "field_51dc42b757e9b" [1]=> string(19) "field_51dc42b757e9b" } ["notas"]=> array(2) { [0]=> string(0) "" [1]=> string(0) "" } ["_notas"]=> array(2) { [0]=> string(19) "field_524c4999abc18" [1]=> string(19) "field_524c4999abc18" } ["_edit_lock"]=> array(1) { [0]=> string(12) "1413842102:2" } ["data_primeira_visita"]=> array(1) { [0]=> string(0) "" } ["_data_primeira_visita"]=> array(1) { [0]=> string(19) "field_542d42a746293" } ["tipo_assinatura"]=> array(1) { [0]=> string(4) "ouro" } ["_tipo_assinatura"]=> array(1) { [0]=> string(19) "field_542b58227dd43" } } 
		$localTels = $campos_customizados["telefone"][1]." | ".$campos_customizados["telefone"][2]." | ".$campos_customizados["celular"][1];
		$localEnde = $campos_customizados["bgmp_address"][1];
		$localAss = $campos_customizados["tipo_assinatura"][0];
		$localEmail = $campos_customizados["email"][0];
		//echo "<hr />";
		$emailMsg = "Mensagem: ".$_REQUEST["msg"]." \n Telefones: ".$localTels." \n Endereço: ".$localEnde." \n Email do local: ".$localEmail." \n Tipo de assinante: ".$localAss." \n\n Requisitante: ".$_REQUEST["nome"]." \n Telefone do Requisitante: ".$_REQUEST["telefone"]." \n Endereço do Requisitante: ".$_REQUEST["endereco"]." \n Email do Requisitante: ".$_REQUEST["email"];
		//echo "<hr />";
		if($_REQUEST["quemProcessa"]=="equipeItapemapa") {
			$emailAssunto = "Orçamento para local: ".$_REQUEST["localNome"];
			//echo "<hr />";
			$emailTo = "orcamento@itapemapa.com.br, fmatelli@gmail.com";
		} else {
			$emailAssunto = "Copia de Orçamento para local: ".$_REQUEST["localNome"];
			//echo "<hr />";
			$emailTo = "orcamento@itapemapa.com.br, fmatelli@gmail.com, ".$localEmail;
		}
		$emailHeaders = 'From: '.$_REQUEST["nome"].'<'.$_REQUEST["email"].'>' . "\r\n";
		$enviaEmail = wp_mail("emailqueeuleio@gmail.com", $emailAssunto, $emailMsg, $emailHeaders);
		
		if($enviaEmail) { ?>
			<div class="avisoHolder avisoSucesso">
				<p><strong>Orçamento enviado!</strong></p>
				<?php if($_REQUEST["quemProcessa"]=="equipeItapemapa") { ?>
					<p>Vamos entrar em contato com o local e oferecer seu orçamento, será cobrado o aceite, portanto o retorno não é garantido.</p>
				<? } else { ?>
					<p>O seu pedido de orçamento foi enviado diretamente para o local, sendo que o retorno não e de responsabilidade do Itapemapa.</p>
				<?php } ?>
			</div>
		<?php } else { ?>
			<div class="avisoHolder avisoErro">
				<p><strong>Erro ao enviar!</strong></p>
				<p>Desculpe, não foi possível enviar o orçamento, tente novamente mais tarde ou entre em contato com <a href="admin [at] example.com" rel="nofollow" onclick="this.href='mailto:' + 'orcamento' + '@' + 'itapemapa.com.br'">departamento de orcamento.</a></p>

			</div>
		<?php } 
	}
	// Always die in functions echoing ajax content
	die();
}



/* TEMPLATE PAGE */

// indicar-local.php
function insert_placemark_frontend() {
	// The $_REQUEST contains all the data sent via ajax 
	if ( isset($_REQUEST) ) {
		if(""==$_REQUEST["nome"]) { ?>
			<div class="avisoHolder avisoErro">
				<p><strong>Erro no nome!</strong></p>
				<p>Por favor indique um nome para o local</p>
			</div>

		<?php die;
		}
		$page = get_page_by_title(html_entity_decode($_REQUEST["nome"]), OBJECT, 'bgmp');
		if($page) { ?>
			<div class="avisoHolder avisoErro">
				<p><strong>Erro ao cadastrar o local!</strong></p>
				<p>Você está tentando indicar um local que já está cadastrado: <a href="<?php echo $page->guid ?>"><?php echo $page->post_title ?></a>. (status: <?php echo $page->post_status ?>).</p>
			</div>
		<?php } else {
			global $bgmp;
			$coordinates = $bgmp->geocode( $_REQUEST['endereco'] );
			if(!$coordinates) { ?>
				<div class="avisoHolder avisoErro">
					<p><strong>Erro ao ler endereço!</strong></p>
					<p>Por favor, informe um endereço correto.</p>
				</div>
			<?php } else {
				if(""==$_REQUEST["categoria"]) { ?>
					<div class="avisoHolder avisoErro">
						<p><strong>Erro na categoria!</strong></p>
						<p>Uma categoria deve ser selecionada para o local ser indicado com sucesso.</p>
					</div>
				<?php } else {
				    $my_post = array(
				      'post_title'    => $_REQUEST["nome"],
				      'post_type'  => 'bgmp',
				      'post_status'   => 'pending',
				      'post_author'   => $_REQUEST["indicadorID"],
				      //'categories' => array("mapa-comercial", $_REQUEST["categoria"]),
				      'tax_input' => array('bgmp-category' => array("mapa-comercial", 175, $_REQUEST["categoria"]))
				    );
				    //var_dump();die;
				    $tag = array( 175, intval($_REQUEST["categoria"]));
				    //var_dump($my_post);
				    // Insert the post into the database
				    global $post;
				    $insereNovoLocal = wp_insert_post( $my_post );
				    //var_dump($insereNovoLocal);
				    if($insereNovoLocal) { ?>
						<div class="avisoHolder avisoSucesso">
							<p><strong>Local cadastrado com sucesso!</strong></p>
							<p>Muito obrigado, iremos verificar os dados e se o local indicado for aprovado será listado.</p>
						</div>
						<?php
						update_post_meta( $insereNovoLocal, 'bgmp_address', $_REQUEST["endereco"] );
						update_post_meta( $insereNovoLocal, 'bgmp_latitude', $coordinates[ 'latitude' ] );
						update_post_meta( $insereNovoLocal, 'bgmp_longitude', $coordinates[ 'longitude' ] );
						update_field( "field_51dc398792d10", $_REQUEST["telefone"], $insereNovoLocal );
						$tags2 = wp_set_object_terms( $insereNovoLocal, $tag, "categoria" );
				      //var_dump($tags2);
				    } else { ?>
						<div class="avisoHolder avisoErro">
							<p><strong>Erro ao conectar!</strong></p>
							<p>Não foi possível conectar-se ao servidor, por favor tente novamente mais tarde.</p>
						</div>
				    <?php }
				} // erro nao selecionou categoria
			} // erro ao ler endereco
		} // $page erro local ja indicado
	} // isset request
	// Always die in functions echoing ajax content
	die();
}


/* PLUGIN WOOCOMMERCE */
// Custom redirect for users after logging in

function wcs_login_redirect( $redirect ) {
     $redirect = '/ranking';
     return $redirect;
}

//Extra fields
function wooc_extra_register_fields() {
	?>

	<p class="form-row form-row-first">
	<label for="reg_billing_first_name"><?php _e( 'First name', 'woocommerce' ); ?> <span class="required">*</span></label>
	<input type="text" class="input-text" name="billing_first_name" id="reg_billing_first_name" value="<?php if ( ! empty( $_POST['billing_first_name'] ) ) esc_attr_e( $_POST['billing_first_name'] ); ?>" />
	</p>

	<p class="form-row form-row-last">
	<label for="reg_billing_last_name"><?php _e( 'Last name', 'woocommerce' ); ?> <span class="required">*</span></label>
	<input type="text" class="input-text" name="billing_last_name" id="reg_billing_last_name" value="<?php if ( ! empty( $_POST['billing_last_name'] ) ) esc_attr_e( $_POST['billing_last_name'] ); ?>" />
	</p>

	<div class="clear"></div>

	<!--p class="form-row form-row-wide">
	<label for="reg_billing_phone"><?php _e( 'Phone', 'woocommerce' ); ?> <span class="required">*</span></label>
	<input type="text" class="input-text" name="billing_phone" id="reg_billing_phone" value="<?php if ( ! empty( $_POST['billing_phone'] ) ) esc_attr_e( $_POST['billing_phone'] ); ?>" />
	</p>

	<p class="form-row form-row-wide">
	<label for="reg_billing_address"><?php _e( 'Address', 'woocommerce' ); ?> com nº (em Itapetininga) <span class="required">*</span></label>
	<input type="text" class="input-text" name="billing_address" id="reg_billing_address" value="<?php if ( ! empty( $_POST['billing_address'] ) ) esc_attr_e( $_POST['billing_address'] ); ?>" />
	</p-->
	<?php
}


/**
 * Validate the extra register fields.
 *
 * @param  string $username          Current username.
 * @param  string $email             Current email.
 * @param  object $validation_errors WP_Error object.
 *
 * @return void
 */
function wooc_validate_extra_register_fields( $username, $email, $validation_errors ) {
	if ( isset( $_POST['billing_first_name'] ) && empty( $_POST['billing_first_name'] ) ) {
		$validation_errors->add( 'billing_first_name_error', __( '<strong>Error</strong>: First name is required!', 'woocommerce' ) );
	}

	if ( isset( $_POST['billing_last_name'] ) && empty( $_POST['billing_last_name'] ) ) {
		$validation_errors->add( 'billing_last_name_error', __( '<strong>Error</strong>: Last name is required!.', 'woocommerce' ) );
	}


	/*if ( isset( $_POST['billing_phone'] ) && empty( $_POST['billing_phone'] ) ) {
		$validation_errors->add( 'billing_phone_error', __( '<strong>Error</strong>: Phone is required!.', 'woocommerce' ) );
	}

	if ( isset( $_POST['billing_address'] ) && empty( $_POST['billing_address'] ) ) {
		$validation_errors->add( 'billing_address_error', __( '<strong>Error</strong>: Address is required!.', 'woocommerce' ) );
	}*/
}


/**
 * Save the extra register fields.
 *
 * @param  int  $customer_id Current customer ID.
 *
 * @return void
 */
function wooc_save_extra_register_fields( $customer_id ) {
	if ( isset( $_POST['billing_first_name'] ) ) {
		// WordPress default first name field.
		update_user_meta( $customer_id, 'first_name', sanitize_text_field( $_POST['billing_first_name'] ) );

		// WooCommerce billing first name.
		update_user_meta( $customer_id, 'billing_first_name', sanitize_text_field( $_POST['billing_first_name'] ) );
	}

	if ( isset( $_POST['billing_last_name'] ) ) {
		// WordPress default last name field.
		update_user_meta( $customer_id, 'last_name', sanitize_text_field( $_POST['billing_last_name'] ) );

		// WooCommerce billing last name.
		update_user_meta( $customer_id, 'billing_last_name', sanitize_text_field( $_POST['billing_last_name'] ) );
	}

	if ( isset( $_POST['billing_phone'] ) ) {
		// WooCommerce billing phone
		update_user_meta( $customer_id, 'billing_phone', sanitize_text_field( $_POST['billing_phone'] ) );
	}

	if ( isset( $_POST['billing_address'] ) ) {
		// WooCommerce billing address
		update_user_meta( $customer_id, 'billing_address', sanitize_text_field( $_POST['billing_address'] ) );
	}
}

add_action( 'woocommerce_created_customer', 'wooc_save_extra_register_fields' );

/**/

// Personaliza campos na hora de fechar a compra
function custom_override_checkout_fields( $fields ) {
    //unset($fields['order']['order_comments']);
    wp_dequeue_script( 'googleMapsAPI' );
	wp_dequeue_script( 'markerClusterer' );
	wp_dequeue_script( 'bgmp' );
	
	//AIzaSyCVzvUupMPrIDACQFMOD300OAFlM0-qGWI
	//wp_register_script('googlemaps', 'http://maps.googleapis.com/maps/api/js?' . $locale . '&key=' . GOOGLE_MAPS_V3_API_KEY . '&sensor=false&libraries=places', false, '3');
	//wp_register_script('googlemaps', 'https://maps.googleapis.com/maps/api/js?v=3.exp&libraries=places', false, '3');
	//wp_register_script('googlemaps', 'http://maps.googleapis.com/maps/api/js?' . $locale . '&key={AIzaSyDcT9jNDHafm1cKlNdJaumfwmz4CeLhiXU}&libraries=places&sensor=false', false, '3');
	//wp_register_script('googlemaps', 'https://maps.googleapis.com/maps/api/js?v=3.exp&libraries=places');
	//wp_enqueue_script('googlemaps');
	//
	$mapvars = array( 'lat' => get_option( 'bgmp_map-latitude' ), 'lon' => get_option( 'bgmp_map-longitude' ) );
	wp_localize_script( 'load-gmaps', 'mapvar', $mapvars );
	wp_enqueue_script('load-gmaps');
	//
    unset($fields['order']['order_comments']);
	//$fields['order']['order_comments']['label'] = 'Muito obrigado por comprar conosco';
	unset($fields['billing']['billing_company']);
	unset($fields['billing']['billing_address_2']);
	unset($fields['billing']['billing_city']);
	unset($fields['billing']['billing_postcode']);
	unset($fields['billing']['billing_country']);
	unset($fields['billing']['billing_state']);
    return $fields;
}
 
function my_custom_checkout_field( $checkout ) {
	echo '<div id="map-canvas" style="height:250px;">mapa</div>';
}

// WooCommerce automatically give user benefits when order is processed
function mysite_woocommerce_payment_complete( $order_id ) {
	$order = new WC_Order( $order_id );
	$user_id = $order->user_id;
	// Do something with $user_id
	$order = new WC_Order( $order_id );
	$user_id = $order->user_id;
	/*$user_data = array(
    	'ID' => $user_id,'role' => 'subscriber'
	);*/
	//wp_update_user( $user_data );
	//$data_compra = $order->order_date;
	$items = $order->get_items();
	//var_dump($items);die;

	foreach ( $items as $item ) {
		$product_name = $item['name'];
		$product_qty = $item["item_meta"]["_qty"][0];
		//echo $product_qty = ["qty"];die;
		$product_id = $item['product_id'];
		//$product_variation_id = $item['variation_id'];

		//TO INSERT IN USER META FIELDS
		$qty_atual = get_user_meta($user_id,  $product_id, true );
		if($qty_atual>0) {
			update_user_meta($user_id, $product_id, $product_qty + $qty_atual);
		} else {
			update_user_meta($user_id, $product_id, $product_qty);
		}
	}
}

// Editar ATIVOS do usuario no backend do wp
// 1 em visualizaçao de usuario (users.php)
function mysite_column_company( $defaults ) {
    $defaults['mysite-usercolumn-gratis'] = __('Gratis', 'user-column');
    $defaults['mysite-usercolumn-comercial'] = __('Comerc.', 'user-column');
    $defaults['mysite-usercolumn-bronze'] = __('Bronze', 'user-column');
    $defaults['mysite-usercolumn-prata'] = __('Prata', 'user-column');
    $defaults['mysite-usercolumn-ouro'] = __('Ouro', 'user-column');
    return $defaults;
}
function mysite_custom_column_company($value, $column_name, $id) {
    if( $column_name == 'mysite-usercolumn-gratis' ) {
        return get_the_author_meta( '6891', $id );
    } elseif( $column_name == 'mysite-usercolumn-comercial' ) {
        return get_the_author_meta( '6832', $id );
    } elseif( $column_name == 'mysite-usercolumn-bronze' ) {
        return get_the_author_meta( '6841', $id );
    } elseif( $column_name == 'mysite-usercolumn-prata' ) {
        return get_the_author_meta( '6843', $id );
    } elseif( $column_name == 'mysite-usercolumn-ouro' ) {
        return get_the_author_meta( '6844', $id );
    }
}

// 2 em edicao do usuario (user-edit.php)
function action_show_user_profile($user) {
	?>
	<h3>Ativos</h3>
	<p>Assinaturas que podem ser utilizadas</p>
	<table>
	<tr>
	<th><label>Gratis</label></th>
	<td><input type="text" name="campo-gratis" value="<?php echo esc_attr(get_the_author_meta('6891', $user->ID) ); ?>" /></td>
	</tr>
	<tr>
	<th><label>Comercial</label></th>
	<td><input type="text" name="campo-comercial" value="<?php echo esc_attr(get_the_author_meta('6832', $user->ID) ); ?>" /></td>
	</tr>
	<tr>
	<th><label>Bronze</label></th>
	<td><input type="text" name="campo-bronze" value="<?php echo esc_attr(get_the_author_meta('6841', $user->ID) ); ?>" /></td>
	</tr>
	<tr>
	<th><label>Prata</label></th>
	<td><input type="text" name="campo-prata" value="<?php echo esc_attr(get_the_author_meta('6843', $user->ID) ); ?>" /></td>
	</tr>
	<tr>
	<th><label>Ouro</label></th>
	<td><input type="text" name="campo-ouro" value="<?php echo esc_attr(get_the_author_meta('6844', $user->ID) ); ?>" /></td>
	</tr>
	</table>
	<?php
}

function action_process_option_update($user_id) {
	update_usermeta($user_id, '6891', ( isset($_POST['campo-gratis']) ? $_POST['campo-gratis'] : '' ) );
	update_usermeta($user_id, '6832', ( isset($_POST['campo-comercial']) ? $_POST['campo-comercial'] : '' ) );
	update_usermeta($user_id, '6841', ( isset($_POST['campo-bronze']) ? $_POST['campo-bronze'] : '' ) );
	update_usermeta($user_id, '6843', ( isset($_POST['campo-prata']) ? $_POST['campo-prata'] : '' ) );
	update_usermeta($user_id, '6844', ( isset($_POST['campo-ouro']) ? $_POST['campo-ouro'] : '' ) );
}

if ( is_admin() ) {
	add_action('show_user_profile', 'action_show_user_profile');
	add_action('edit_user_profile', 'action_show_user_profile');
	add_action('personal_options_update', 'action_process_option_update');
	add_action('edit_user_profile_update', 'action_process_option_update');
}

/* PLUGIN BGMP E LOCAIS */

// ajax atualizar endereco
function atualiza_endereco () {
	// The $_REQUEST contains all the data sent via ajax 
	if ( isset($_REQUEST) ) {
		echo $sucesso = update_user_meta($_REQUEST['userid'], "billing_address_1", $_REQUEST['endereco']);
	}
	// Always die in functions echoing ajax content
	die();
}

// BGMP PLUGIN - customizacoes
function modifyPostTypeParams( $params ) {
	$params[ 'labels' ][ 'name' ]       = 'Locais';
	$params[ 'labels' ][ 'singular_name' ]    = 'Local';
	$params[ 'labels' ][ 'add_new' ]   = 'Adicionar local';
	$params[ 'labels' ][ 'categories' ]   = 'Categorias';
	$params[ 'labels' ][ 'add_new_item' ]   = 'Adicionar local';
	$params[ 'labels' ][ 'edit_item' ]      = 'Editar local';
	$params[ 'labels' ][ 'new_item' ]     = 'Novo local';
	$params[ 'labels' ][ 'view' ]       = 'Ver locais';
	$params[ 'labels' ][ 'view_item' ]      = 'Ver local';
	$params[ 'labels' ][ 'search_items' ]   = 'Procurar locais';
	$params[ 'labels' ][ 'not_found' ]      = 'Nenhum local encontrado';
	$params[ 'labels' ][ 'not_found_in_trash' ] = 'Nenhum local encontrado no lixo';
	$params[ 'labels' ][ 'parent' ]       = 'Local pais';
	$params[ 'singular_label' ]         = 'Local';
	$params[ 'rewrite' ]            = array( 'slug' => '', 'with_front' => false );
	$params[ 'has_archive' ]          = '';
	return $params;
}

//Make the permalink work by setting post types when none are given
function parse_event_query( $query ) {
  $post_name = $query->get( 'name' );
  $post_type = $query->get( 'post_type' );
  if( ! empty( $post_name ) && empty( $post_type ) ) {
  $query->set( 'post_type', array( 'post', 'page', 'bgmp' ) );
  }
}

function create_event_permalink( $permalink, $post, $leavename, $sample ) {
  if ( '' != $permalink && !in_array( $post->post_status, array('draft', 'pending', 'auto-draft')) ) {
  $permalink = str_replace( '%postname%', $post->post_name, $permalink);
  }
  return $permalink;
}

//
function setBGMPDefaultIconByCategory( $iconURL, $placemarkID )
{
  
  #$placemarkCategories = wp_get_object_terms( $placemarkID, 'categoria' );
  $placemarkCategories = wp_get_object_terms( $placemarkID, 'bgmp-category' );
  
  $campos_customizados = get_post_custom($placemarkID);
  
  if(array_key_exists("tipo_assinatura",$campos_customizados))
  $tipo_assinatura = $campos_customizados["tipo_assinatura"][0];
  else
  //if(!isset($tipo_assinatura) or $tipo_assinatura=="" or $tipo_assinatura==NULL)
  $tipo_assinatura = "gratuito";
  //var_dump($campos_customizados["tipo_assinatura"][0]);die;
  
  /*francisco 2015-10 testes simplificando aqui*/
  //var_dump(get_bloginfo( 'stylesheet_directory' ) . '/images/default-marker-'.$tipo_assinatura.'.png');die;
  //$iconURL = get_bloginfo( 'stylesheet_directory' ) . '/images/default-marker-'.$tipo_assinatura.'.png';
  //return $iconURL;
  //francisco before 2015-10 testes
  $ar = array();
  foreach( $placemarkCategories as $pc ) {
      if($pc->slug!=="mapa-comercial")
      array_push($ar, $pc->slug);
  }

  if(in_array("alimentacao", $ar)) {
    $iconURL = get_bloginfo( 'stylesheet_directory' ) . '/images/alimentacao/default-marker-alimentacao-'.$tipo_assinatura.'.png';
  } elseif(in_array("beleza", $ar)) {
    $iconURL = get_bloginfo( 'stylesheet_directory' ) . '/images/beleza/default-marker-beleza-'.$tipo_assinatura.'.png';
  } elseif(in_array("casa", $ar)) {
    $iconURL = get_bloginfo( 'stylesheet_directory' ) . '/images/casa-e-construcao/default-marker-casa-e-construcao-'.$tipo_assinatura.'.png';
  } elseif(in_array("comercio", $ar)) {
    $iconURL = get_bloginfo( 'stylesheet_directory' ) . '/images/comercio/default-marker-comercio-'.$tipo_assinatura.'.png';
  } elseif(in_array("redes", $ar)) {
    $iconURL = get_bloginfo( 'stylesheet_directory' ) . '/images/industria/default-marker-industria-'.$tipo_assinatura.'.png';
  } elseif(in_array("servicos", $ar)) {
    $iconURL = get_bloginfo( 'stylesheet_directory' ) . '/images/servicos/default-marker-servicos-'.$tipo_assinatura.'.png';
  }
  return $iconURL;

      /*$what .= $pc->slug; 
      if (strpos($pc->slug,'alimentacao') !== false) {

    }
    if (strpos($pc->slug,'pizzarias') !== false) {
          $iconURL = get_bloginfo( 'stylesheet_directory' ) . '/images/default-marker-pizzarias.png';
          $what .= $pc->slug;
    } elseif (strpos($pc->slug,'pizzarias') !== false) {
          $iconURL = get_bloginfo( 'stylesheet_directory' ) . '/images/default-marker-pizzarias.png';
          $what .= $pc->slug;
    } else {
      $iconURL = get_bloginfo( 'stylesheet_directory' ) . '/images/default-marker-alimentacao.png';
      $what .= $pc->slug;
    }*/
        /*
    remove o termo MAPA-COMERCIAL
    checa o pai
    ataca o filho
    *
        switch( $pc->slug )
        {


          case 'alimentacao':
                $iconURL = get_bloginfo( 'stylesheet_directory' ) . '/images/default-marker-pizzarias.png';
            break;

            case 'pizzarias':
                $iconURL = get_bloginfo( 'stylesheet_directory' ) . '/images/default-marker-pizzarias.png';
            break;

            case 'alho':
                $iconURL = get_bloginfo( 'stylesheet_directory' ) . '/images/default-marker-pizzarias.png';
            break;

            case 'book-stores':
                $iconURL = get_bloginfo( 'stylesheet_directory' ) . '/images/marker-icons/book-stores.png';
            break;
            
            default:
                $iconURL = get_bloginfo( 'stylesheet_directory' )  . '/images/default-marker.png';
            break;
        }*
        //-'.$pc->slug.'
        $var = $pc->slug;
        //var_dump(get_bloginfo( 'stylesheet_directory' )  . '/images/default-marker-'.$var.'.png');die;
        //$var = "acougues";
        $iconURL = get_bloginfo( 'stylesheet_directory' )  . '/images/default-marker-'.$var.'.png';
        *
    }*/
    //echo $what;die;
    //return $iconURL;
}
/*
function some_func( $query ) {
	if ( is_post_type_archive('bgmp') )
	
	{
	// Do stuff
	echo "asdas";
	}
}
add_action('pre_get_posts','some_func');

add_filter('pre_get_posts', 'query_post_type');
function query_post_type($query) {
  if(is_category() || is_tag()) {
    $post_type = get_query_var('post_type');
	if($post_type)
	    $post_type = $post_type;
	else
	    $post_type = array('post','cpt'); // replace cpt to your custom post type
    $query->set('post_type',$post_type);
	return $query;
    }
}
*/
/*
?bgmp-category=beleza

<?php 
//echo $_SERVER["HTTP_HOST"] . $_SERVER["REQUEST_URI"];
$url = $_SERVER['REQUEST_URI'];
$url = rtrim($url, "/");
$str = explode('/', $url);
//if(preg_match("/(.*?\/)\/+$/", $str))//
//echo prev($str);


//var_dump($str);
if(in_array("mapa-comercial", $str)) {
  $cat = end($str);
  $existe_cat = term_exists($cat, "bgmp-category");
  if($existe_cat) {
    echo do_shortcode('[bgmp-map categories="'.$cat.'"]');
    echo do_shortcode('[bgmp-list categories="'.$cat.'"]');
  } else {
    echo "Não encontramos a categoria <b>$cat</b> dentro de nossos Mapas comerciais";
  }
} else {
  echo "Página não encontrada";
}
?>
//



if ( function_exists ('register_sidebar')) { 
    register_sidebar (array(
  'name' => 'Sidebar Loja',
  'id' => 's-loja',
  'description' => 'Sidebar utilizado na loja de assinatura.'
  )); 
} 

if ( function_exists ('register_sidebar')) { 
    register_sidebar (array(
  'name' => 'Sidebar parceiro',
  'id' => 's-parceiro',
  'description' => 'Sidebar utilizado no seja um parceiro'
  )); 
} 
*/
/*ADD STYLE E FUNCIONS DO BGMP EM TODAS AS PAGINAS (ARRUMAR) */
function bgmpShortcodeCalled()
{
    global $post;
    /*
    $shortcodePageSlugs = array(
        'hello-world',
        'second-page-slug'
    );
    
    if( $post )
        if( in_array( $post->post_name, $shortcodePageSlugs ) )*/
            add_filter( 'bgmp_map-shortcode-called', '__return_true' );
}

/* MODIFICA CAPACIDADES DE USUARIOS */
function add_theme_caps() {
    // gets the author role
    $role = get_role( 'editor' );

    // This only works, because it accesses the class instance.
    // would allow the author to edit others' posts for current theme only
    //$role->add_cap( 'edit_others_posts' );
    $role->remove_cap( 'edit_others_pages' );
    $role->add_cap( 'edit_theme_options' );
}


//var_dump(plugin_dir_path( __FILE__ ) . 'images/icone-pizzarias.png');die;
// ADICIONA ICONES CUSTOMIZADOS 
/*
function setBGMPDefaultIconByCategory( $iconURL, $placemarkID )
{
	$placemarkCategories = wp_get_object_terms( $placemarkID, 'bgmp-category' );

    foreach( $placemarkCategories as $pc )
    {
        switch( $pc->slug )
        {
            case 'pizzarias':
                $iconURL = plugin_dir_path( __FILE__ ) . 'images/icone-pizzarias.png';

            break;
            
            case 'book-stores':
                $iconURL = get_bloginfo( 'stylesheet_directory' ) . '/images/marker-icons/book-stores.png';
            break;
            
            default:
                $iconURL = plugin_dir_path( __FILE__ ) . 'images/default-marker.png';
            break;
        }
    }
    return $iconURL;
}
add_filter( 'bgmp_default-icon', 'setBGMPDefaultIconByCategory', 10, 2 );

/*
function setBGMPDefaultIcon( $iconURL, $placemarkID )
{
    //if( $category-slug == "pizzarias" ) // change this to be whatever condition you want
    /*$placemarkCategories = wp_get_object_terms( $placemarkID, 'bgmp-category' );

	foreach( $placemarkCategories as $pc )
		if( $pc->slug == 'pizzarias' )
        $iconURL = get_bloginfo( 'stylesheet_directory' ) . '/imagens/icone-pizzaria.png';
        
    return $iconURL;
    $placemarkCategories = wp_get_object_terms( $placemarkID, 'bgmp-category' );

	foreach( $placemarkCategories as $pc )
		if( $pc->slug == 'pizzaria' )
			$iconURL = get_bloginfo( 'stylesheet_directory' ) . '/imagens/icone-pizzaria.png';

    return $iconURL;
}
add_filter( 'bgmp_default-icon', 'setBGMPDefaultIcon', 10, 2 );*/
$adressCasa = get_user_meta(get_current_user_id(), "billing_address_1", true);

function calcularDistanciaCasa($lat, $lon) {
	$pontos = array( 'startLat' => $lat, 'startLon' => $lon, 'endLat' => $lat, 'endLon' => $lon );
	wp_dequeue_script('gmaps-functions');
	//wp_deregister_script('gmaps-functions');
	//wp_register_script('gmaps-functions', plugins_url( '/gmaps-functions.js', __FILE__ ));	
	wp_localize_script( 'gmaps-functions', 'pontos', $pontos );
	wp_enqueue_script('gmaps-functions');
	//echo $adressCasa."a";
	return $lat;
}
function getCoordenadasDeEndereco ($end) { 
	//wp_enqueue_script('gmaps-functions');
}
