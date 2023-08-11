<?php
//
add_action('wp_enqueue_scripts', 'load_scritps');
add_action('login_form_middle', 'add_lost_password_link' );
add_action('wp_ajax_save_progress', 'save_progress');
add_action('wp_ajax_nopriv_save_progress', 'save_progress');
add_action('wp_ajax_load_session', 'load_session');
add_action('wp_ajax_nopriv_load_session', 'load_session');
add_action('wp_ajax_update_session', 'update_session');
add_action('wp_ajax_nopriv_update_session', 'update_session');
add_action('wp_ajax_save_or_delete_model', 'save_or_delete_model');
add_action('wp_ajax_nopriv_save_or_delete_model', 'save_or_delete_model');
add_action('wp_ajax_update_cycle_list', 'update_cycle_list');
add_action('wp_ajax_nopriv_update_cycle_list', 'update_cycle_list');
add_action('admin_menu', 'my_remove_menu_pages' );
add_action('wp_logout','go_home');
add_action('init', 'create_post_type' );
add_action('init', 'custom_rewrite_basic');
//
add_filter( 'redirect_canonical','custom_disable_redirect_canonical' );//nunca desativar
add_filter( 'woocommerce_order_button_text', 'woo_custom_order_button_text' ); 
add_filter( 'woocommerce_enable_order_notes_field', '__return_false' );
add_filter('style_loader_tag', 'myplugin_remove_type_attr', 10, 2);
add_filter('script_loader_tag', 'myplugin_remove_type_attr', 10, 2);
add_filter('login_redirect', 'admin_default_page');


function admin_default_page() {
  return '/focus';
}

function google_play_link() {
	?>
	<a href="https://play.google.com/store/apps/details?id=com.f5sites.pomodoros" target="_blank"><img src="<?php bloginfo('stylesheet_directory'); ?>/images/google-play-badge.png" alt="Google Play Badge" class="img-responsive"></a>
	<?php
}

#function custom_disable_redirect_canonical( $redirect_url, $requested_url ) {
function custom_disable_redirect_canonical( $redirect_url ) {
	#global $pagenow;
	#var_dump($redirect_url);die;
	if ( preg_match("/ranking/",$redirect_url) ) {
		return FALSE;
	} elseif ( preg_match("/calendar/",$redirect_url) ) {
		return FALSE;
	} elseif ( preg_match("/product/",$redirect_url) ) {
		return FALSE;
	} elseif ( preg_match("/members/",$redirect_url) ) {
		return FALSE;
	} elseif ( preg_match("/blog/",$redirect_url) ) {
		#var_dump($redirect_url);
		#die;
		return "https://www.pomodoros.com.br/news/";
	} /*elseif ( preg_match("/register/",$redirect_url) ) {
		return FALSE;
	} elseif ( preg_match("register",$redirect_url) ) {
		return FALSE;
	} */else {
		return $redirect_url;
	}
}

function get_projectimer_project_tags($author_id,$taxonomy = 'post_tag'){
    //get author's posts
    $exclude_adm=="";
    if($author_id>0)
    	$exclude_adm=="";
    else {
    	$exclude_adm=", -2";
    	if($author_id==2)//unless it is admin
    		$exclude_adm=="";
    }
    
    	
    $posts = get_posts(array(
    	'post_type' => "projectimer_focus",
        'author' => $author_id.$exclude_adm,
        'posts_per_page' => -1,
        'fields' => 'ids'
        )
    );

    $ts = array();

    //loop over the post and count the tags
    foreach ((array)$posts as $p_id) {
        $tags = wp_get_post_terms( $p_id, $taxonomy);
        foreach ((array)$tags as $tag) {
        	#var_dump(isset($tags[$tag->term_id]));
            if (isset($ts[$tag->term_id])){ //if its already set just increment the count
                $ts[$tag->term_id]['count'] = $ts[$tag->term_id]['count']  + 1;
            }else{ //set the term name start the count
                $ts[$tag->term_id] = array('count' => 1, 'name' => $tag->name, 'slug' => $tag->slug);
            }
        }
    }
    #var_dump($posts);die;
    //so now $ts holds a list of arrays which each hold the name and the count of posts 
    arsort($ts);
    //that author have in that term/tag, so we just need to display it
    $url = get_author_posts_url($author_id);
    #echo '<ul>';
    foreach ($ts as $term_id => $term_args) {
        echo '<a href="/tag/'.$term_args['slug'].'">'.$term_args['name'].'</a>'.' <span class="count">'.$term_args['count'].'</span>'.', ';
    }
    /*foreach ($ts as $term_id => $term_args) {
        echo '<a href="'.add_query_arg('tag',$term_args['slug'],$url).'">'.$term_args['name'].'</a>'.' <span class="count">'.$term_args['count'].'</span>'.', ';
    }*/
    #echo '</ul>';
}

function get_author_post_tags_wpa78489($author_id,$taxonomy = 'post_tag'){
    //get author's posts
    $posts = get_posts(array(
    	'post_type' => "projectimer_focus",
        'author' => $author_id,
        'posts_per_page' => -1,
        'fields' => 'ids'
        )
    );

    $ts = array();

    //loop over the post and count the tags
    foreach ((array)$posts as $p_id) {
        $tags = wp_get_post_terms( $p_id, $taxonomy);
        foreach ((array)$tags as $tag) {
            if (isset($tags[$tag->term_id])){ //if its already set just increment the count
                $ts[$tag->term_id]['count'] = $ts[$tag->term_id]['count']  + 1;
            }else{ //set the term name start the count
                $ts[$tag->term_id] = array('count' => 1, 'name' => $tag->name, 'slug' => $tag->slug);
            }
        }
    }

    //so now $ts holds a list of arrays which each hold the name and the count of posts 
    //that author have in that term/tag, so we just need to display it
    $url = get_author_posts_url($author_id);
    #echo '<ul>';
    foreach ($ts as $term_id => $term_args) {
        echo '<span class="count">'.$term_args['count'].'</span> <a href="'.add_query_arg('tag',$term_args['slug'],$url).'">'.$term_args['name'].'</a>, ';
    }
    #echo '</ul>';
}

function user_object_productivity ($user_id) {
	//echo "<script>alert($user_id);</script>";
	$user_id = (empty($user_id)) ? get_current_user_id() : $user_id;
	//$SEMPRE = $TRINTADIAS = $MES = $SETEDIAS = $SEMANA = $HOJE = array ();
	//$SEMPRE = $TRINTADIAS = $MES = $SETEDIAS = $SEMANA = $HOJE = array ();
	//variaveis assistentes
	$data_registro_do_usuario = strtotime(date("Y-m-d", strtotime(get_userdata($user_id)->user_registered)));
	$now = time();
	global $wpdb;
	$datediff = $now - $data_registro_do_usuario;//must exist, MUST!

	/*It must be splitted because it uses itself values, and it cant be accessed in real time*/
	$SEMPRE['totalDias'] = floor($datediff/(60*60*24));
	$SEMPRE['diasTrabalhados'] = $wpdb->query('SELECT ID FROM `pomodoros_posts` WHERE `post_author` = '.$user_id.' AND `post_status` in ("publish", "private") GROUP BY DATE (`post_date_gmt`)');
	$SEMPRE['diasFolga'] = $SEMPRE['totalDias'] - $SEMPRE ['diasTrabalhados'];
	$SEMPRE['fatorProdutividade'] = round($SEMPRE['diasTrabalhados']/$SEMPRE['totalDias'], 2);
	
	$TRINTADIAS['totalDias'] = 30;
	$TRINTADIAS['diasTrabalhados'] = $wpdb->query('SELECT ID FROM `pomodoros_posts` WHERE `post_author` = '.$user_id.' AND post_date_gmt > DATE_SUB(NOW(), INTERVAL 30 DAY) GROUP BY DATE (`post_date_gmt`)');
	$TRINTADIAS['diasFolga'] = $TRINTADIAS['totalDias'] - $TRINTADIAS['diasTrabalhados'];
	$TRINTADIAS['fatorProdutividade'] = round($TRINTADIAS['diasTrabalhados']/$TRINTADIAS['totalDias'], 2);

	$MES['totalDias'] = date("j");
	$MES['diasTrabalhados'] = $wpdb->query("SELECT ID FROM `pomodoros_posts` WHERE `post_author` = ".$user_id." AND post_date_gmt > DATE_SUB(NOW(), INTERVAL ".$MES['totalDias']." DAY) GROUP BY DATE (`post_date_gmt`)");
	$MES['diasFolga'] = $MES['totalDias'] - $MES['diasTrabalhados'];
	$MES['fatorProdutividade'] = round($MES['diasTrabalhados']/$MES['totalDias'], 2);

	$SETEDIAS['totalDias'] = 7;
	$SETEDIAS['diasTrabalhados'] = $wpdb->query("SELECT ID FROM `pomodoros_posts` WHERE `post_author` = ".$user_id." AND post_date_gmt > DATE_SUB(NOW(), INTERVAL ".$SETEDIAS['totalDias']." DAY) GROUP BY DATE (`post_date_gmt`)");
	$SETEDIAS ['diasFolga'] = $SETEDIAS['totalDias'] - $SETEDIAS['diasTrabalhados'];
	$SETEDIAS ['fatorProdutividade'] = round($SETEDIAS['diasTrabalhados']/($SETEDIAS['totalDias']), 2);
	
	$SEMANA['totalDias'] = date('w') + 1;
	$SEMANA['diasTrabalhados'] = $wpdb->query("SELECT * FROM `pomodoros_posts` WHERE `post_author` = ".$user_id." AND post_date_gmt > DATE_SUB(NOW(), INTERVAL ".($SEMANA['totalDias'])." DAY) GROUP BY DATE (`post_date_gmt`)");
	//Its to prevent a very intersting bug, when there are 2 posts with less than 24 hours of difference but are published at 2 differents days, it will result in a 2 posts for 1 day, grouped by date, because there are 2 differente days
	($SEMANA['diasTrabalhados']>$SEMANA['totalDias']) ? $SEMANA['diasTrabalhados'] = $SEMANA['totalDias'] : $SEMANA['diasTrabalhados'];
	$SEMANA['diasFolga'] = $SEMANA['totalDias'] - $SEMANA['diasTrabalhados'];
	$SEMANA['fatorProdutividade'] = round($SEMANA['diasTrabalhados']/$SEMANA['totalDias'], 2);

	$new_object_productivity = array(
		"sempre" => $SEMPRE,
		"trintadias" => $TRINTADIAS,
		"mes" => $MES,
		"setedias" => $SETEDIAS,
		"semana" => $SEMANA
	);
	return $new_object_productivity;
}

function user_object_productivity_human_time_diff ($user_id) {
	//echo "<script>alert($user_id);</script>";
	$user_id = (empty($user_id)) ? get_current_user_id() : $user_id;
	//$SEMPRE = $TRINTADIAS = $MES = $SETEDIAS = $SEMANA = $HOJE = array ();
	//$SEMPRE = $TRINTADIAS = $MES = $SETEDIAS = $SEMANA = $HOJE = array ();
	//variaveis assistentes
	$data_registro_do_usuario = strtotime(date("Y-m-d", strtotime(get_userdata($user_id)->user_registered)));
	$now = time();
	global $wpdb;
	$datediff = $now - $data_registro_do_usuario;//must exist, MUST!

	/*It must be splitted because it uses itself values, and it cant be accessed in real time*/
	$totalDias = floor($datediff/(60*60*24));
	
	$totalDias_human = human_time_diff( $data_registro_do_usuario, current_time('timestamp') );

	$diasTrabalhados = $wpdb->query('SELECT * FROM `pomodoros_posts` WHERE `post_author` = '.$user_id.' AND `post_status` in ("publish", "private")  GROUP BY DATE (`post_date_gmt`)');

	$diasTrabalhados_human = human_time_diff( strtotime("+".$diasTrabalhados." days"), current_time('timestamp') );
	
	$diasFolga = $totalDias - $diasTrabalhados;
	$diasFolga_human = human_time_diff( strtotime("+".$diasFolga." days"), current_time('timestamp') );
	
	$SEMPRE['totalDias'] = $totalDias;
	$SEMPRE['totalDias_human'] = $totalDias_human;
	$SEMPRE['diasTrabalhados'] = $diasTrabalhados;
	$SEMPRE['diasFolga'] = $diasFolga;
	$SEMPRE['fatorProdutividade'] = round($diasTrabalhados/$totalDias, 2);
	
	$TRINTADIAS['totalDias'] = 30;
	$TRINTADIAS['diasTrabalhados'] = $wpdb->query('SELECT * FROM `pomodoros_posts` WHERE `post_author` = '.$user_id.' AND post_date_gmt > DATE_SUB(NOW(), INTERVAL 30 DAY) GROUP BY DATE (`post_date_gmt`)');
	$TRINTADIAS['diasFolga'] = $TRINTADIAS['totalDias'] - $TRINTADIAS['diasTrabalhados'];
	$TRINTADIAS['fatorProdutividade'] = round($TRINTADIAS['diasTrabalhados']/$TRINTADIAS['totalDias'], 2);

	$MES['totalDias'] = date("j");
	$MES['diasTrabalhados'] = $wpdb->query("SELECT * FROM `pomodoros_posts` WHERE `post_author` = ".$user_id." AND post_date_gmt > DATE_SUB(NOW(), INTERVAL ".$MES['totalDias']." DAY) GROUP BY DATE (`post_date_gmt`)");
	$MES['diasFolga'] = $MES['totalDias'] - $MES['diasTrabalhados'];
	$MES['fatorProdutividade'] = round($MES['diasTrabalhados']/$MES['totalDias'], 2);

	$SETEDIAS['totalDias'] = 6;
	$SETEDIAS['diasTrabalhados'] = $wpdb->query("SELECT * FROM `pomodoros_posts` WHERE `post_author` = ".$user_id." AND post_date_gmt > DATE_SUB(NOW(), INTERVAL ".$SETEDIAS['totalDias']." DAY) GROUP BY DATE (`post_date_gmt`)");
	$SETEDIAS ['diasFolga'] = $SETEDIAS['totalDias'] - $SETEDIAS['diasTrabalhados'] +1;
	$SETEDIAS ['fatorProdutividade'] = round($SETEDIAS['diasTrabalhados']/($SETEDIAS['totalDias']+1), 2);
	
	$SEMANA['totalDias'] = date('w') + 1;
	$SEMANA['diasTrabalhados'] = $wpdb->query("SELECT * FROM `pomodoros_posts` WHERE `post_author` = ".$user_id." AND post_date_gmt > DATE_SUB(NOW(), INTERVAL ".($SEMANA['totalDias']-1)." DAY) GROUP BY DATE (`post_date_gmt`)");
	//Its to prevent a very intersting bug, when there are 2 posts with less than 24 hours of difference but are published at 2 differents days, it will result in a 2 posts for 1 day, grouped by date, because there are 2 differente days
	($SEMANA['diasTrabalhados']>$SEMANA['totalDias']) ? $SEMANA['diasTrabalhados'] = $SEMANA['totalDias'] : $SEMANA['diasTrabalhados'];
	$SEMANA['diasFolga'] = $SEMANA['totalDias'] - $SEMANA['diasTrabalhados'];
	$SEMANA['fatorProdutividade'] = round($SEMANA['diasTrabalhados']/$SEMANA['totalDias'], 2);

	$new_object_productivity = array(
		"sempre" => $SEMPRE,
		"trintadias" => $TRINTADIAS,
		"mes" => $MES,
		"setedias" => $SETEDIAS,
		"semana" => $SEMANA
	);
	return $new_object_productivity;
}

if ( function_exists( 'add_theme_support' ) ) { 
	add_theme_support( 'post-thumbnails' ); 
}

function blockusers_from_wp_admin() {
	if ( is_admin() && ! current_user_can( ‘administrator’ ) && ! ( defined( ‘DOING_AJAX’ ) && DOING_AJAX ) ) {
		wp_redirect( home_url() );
		exit;
	}
}

//
/*add_action( 'muplugins_loaded', function()
{
    $files = get_included_files();
    foreach ( $files as $f )
        echo $f.'<br>';

    // or...
});*/


function default_page() {
  return '/focus';
}



function load_scritps() {		
	#wp_enqueue_style('pomodoro-css', get_bloginfo("stylesheet_directory")."/pomodoro/pomodoro.css", __FILE__, time());
	#ERROR CONSOLE wp_enqueue_style('fonts-css', get_bloginfo("stylesheet_directory")."/assets/fonts/stylesheet.css", __FILE__);


	//jquery colors
	wp_enqueue_script("jquery-color", get_bloginfo("stylesheet_directory")."/assets/jquery.color-2.1.2.min.js");
	
	//alertify
	wp_enqueue_script("alertify-js", get_bloginfo("stylesheet_directory")."/assets/alertify.min.js");
	wp_enqueue_style('alertify-css', get_bloginfo("stylesheet_directory")."/assets/alertify.core_and_default_merged.css", __FILE__);
	
	//bootstrap
	/*wp_dequeue_script('bootstrap-css');
	wp_dequeue_script('bootstrap-scripts');
	wp_dequeue_style('bootstrap-js');
	wp_dequeue_style('bootstrap-style');*/
	#JA CARREGADO EM SMART LANG
	wp_enqueue_script("bootstrap-js", get_bloginfo("stylesheet_directory")."/assets/bootstrap.min.js");
	wp_enqueue_style('bootstrap-css', get_bloginfo("stylesheet_directory")."/assets/bootstrap.min.css", __FILE__);
	
	//select2
	wp_register_script("select2-js", get_bloginfo("stylesheet_directory")."/assets/select2/select2.full.min.js");
	wp_register_script("select2-jsbr", get_bloginfo("stylesheet_directory")."/assets/select2/select2_locale_pt-BR.js");
	wp_register_style('select2-css', get_bloginfo("stylesheet_directory")."/assets/select2/select2.min.css", __FILE__);

	//jquery-ui
	wp_register_script("jquery-ui-js", get_bloginfo("stylesheet_directory")."/assets/jquery-ui/jquery-ui.min.js");
	wp_register_style('jquery-ui-css', get_bloginfo("stylesheet_directory")."/assets/jquery-ui/jquery-ui.min.css", __FILE__);
	wp_register_style('jquery-ui-theme-css', get_bloginfo("stylesheet_directory")."/assets/jquery-ui/jquery-ui.theme.min.css", __FILE__);

	//jquery-ui touchable
	wp_register_script("jquery-ui-touhc-js", get_bloginfo("stylesheet_directory")."/assets/jquery.ui.touch-punch.min.js");

	//no sleep
	wp_register_script("nosleep-js", get_bloginfo("stylesheet_directory")."/assets/NoSleep.min.js");

	//
	#wp_register_script("artyom-js", get_bloginfo("stylesheet_directory")."/assets/artyom.window.min.js");
	#wp_enqueue_script("speakW-js", get_bloginfo("stylesheet_directory")."/assets/speakWorker.js");
	
	//fullpage.js for home
	wp_enqueue_script("fullpage-js", get_bloginfo("stylesheet_directory")."/assets/fullpage.min.js");
	wp_enqueue_style('fullpage-css', get_bloginfo("stylesheet_directory")."/assets/fullpage.min.css", __FILE__);
	wp_enqueue_style('fullpage_homepage.css', get_bloginfo("stylesheet_directory")."/assets/fullpage_homepage.css", __FILE__, time()*rand());
	


	#<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/github-fork-ribbon-css/0.2.0/gh-fork-ribbon.min.css" />
	//inter8
	//Theme language, need to be there
	load_theme_textdomain( 'sis-foca-js', get_template_directory() . '/languages' );

	//THEME CSS FOR IMPROVE SPEED
	wp_enqueue_style('theme-css', get_bloginfo("stylesheet_directory")."/style.css", __FILE__, time()*rand());
	

	
	global $user_prefered_language;
	if(isset($_SESSION["user_prefered_language"])) {
		$user_prefered_language==$_SESSION["user_prefered_language"];
	} else {
		if($user_prefered_language=="" || $user_prefered_language)
			$user_prefered_language=="en_US";
	}
	if($user_prefered_language=="US")
		$user_prefered_language="en_US";
	
	$filelang = $user_prefered_language.".js";
	//var_dump($filelang);die;
	//if(qtranxf_getLanguage() == "en")
		//$filelang="en.js";
	   //else if(qtranxf_getLanguage() == "pt")
		//$filelang="pt-br.js";
	//} else {
		//If the function doesnt exists then call the default language
		//$filelang="pt-br.js";
	//}
	$filelang = ($filelang=="" || !isset($filelang)) ? "pt_BR.js" : $filelang;
	wp_enqueue_script("pomodoros-language", get_bloginfo("stylesheet_directory")."/languages/js/".$filelang, __FILE__, time());
	#var_dump(get_bloginfo("stylesheet_directory")."/languages/".$filelang);die;
	// Register the script
	//wp_register_script( 'some_handle', 'path/to/myscript.js' );
	wp_register_script("pomodoros-js", get_bloginfo("stylesheet_directory")."/pomodoro/pomodoro-functions.js", __FILE__, time());

	// Localize the script with new data
	$localized_array = array(
		'php_locale' => $user_prefered_language,
		'is_admin' => current_user_can("administrator") ? true : false,
	);
	
	wp_localize_script( 'pomodoros-js', 'data_from_php', $localized_array );

	// Enqueued script with localized data.
	//wp_enqueue_script( 'pomodoros-js' );
		#echo get_template_directory()."/pomodoro/projectimer-pomodoros-shared-parts.js";
	wp_register_script("projectimer-pomodoros-shared-parts-js", get_bloginfo("stylesheet_directory")."/pomodoro/projectimer-pomodoros-shared-parts.js", __FILE__);
	#
	#VIA CSS wp_enqueue_style("projectimer-pomodoros-shared-parts-css", get_template_directory()."/pomodoro/projectimer-pomodoros-shared-parts.css", __FILE__);

	//
	wp_register_script("sound-js", get_bloginfo("stylesheet_directory")."/assets/soundmanager2-nodebug-jsmin.js", __FILE__);

	wp_register_script("rangeslider-js", get_bloginfo("stylesheet_directory")."/assets/rangeslider.min.js", __FILE__);
	
}

function myplugin_remove_type_attr($tag, $handle) {
    return preg_replace( "/type=['\"]text\/(javascript|css)['\"]/", '', $tag );
}


function show_recent_pomodoros() {
	#<h3><script>document.write(txt_foot_last)</script></h3>
	?>
		<ul>
			<?php 
			$args = array( 'post_type' => 'projectimer_focus', 'posts_per_page' => 80, 'post_status' => 'publish' ); 
			$recent_posts = get_posts( $args );
			foreach( $recent_posts as $recent ) { ?>
				<li>
				<?php echo get_avatar($recent->post_author, 24) ?>
				<a href="<?php echo get_permalink($recent->ID); ?>" title="Look <?php esc_attr($recent->post_title); ?>">
				<?php echo $recent->post_title ?>
				<span class="post_location">
				<span class="post_location_city"><?php echo get_post_meta($recent->ID, "post_location_city", true); ?></span>
				<span class="post_location_region"><?php echo get_post_meta($recent->ID, "post_location_region", true); ?></span>
				<span class="post_location_country"><?php echo get_post_meta($recent->ID, "post_location_country", true); ?></span>		
				</span>
				</a> 
				</li>
			<?php }
			#
			if(function_exists('set_shared_database_schema'))set_shared_database_schema();
			 ?>
		</ul>
	<?php
}



function show_welcome_message($alertify=false) {
	if(is_user_logged_in()) {
		$current_user = wp_get_current_user();
		$args = array(
	              'post_type' => 'projectimer_focus',
	              'post_status' => 'draft',
	              'author'   => get_current_user_id(),

	              'posts_per_page' => 1,
	            );
		$recent = get_posts($args);
		/*if( $recent ) {
			$title = ", you most recent task is <i>".get_the_title($recent[0]->ID)."</i>";
		} else{
			$title = ", you did not started a task yet"; //No published posts
		} 
		
		$msg_saudacao = "Hello ".$current_user->display_name." ".$title.", <a href=/focar>go to online app and start focus</a>";*/
		if( $recent ){
		  $title = ", ".__("you most recent task is", "sis-foca-js")." <i>".get_the_title($recent[0]->ID)."</i>";#sua tarefa mais recente é
		}else{
		  $title = ", ".__("you never started a task", "sis-foca-js"); #você ainda não começou nenhuma tarefa //No published posts
		} 
		$msg_saudacao = __("Hello", "sis-foca-js")." ".$current_user->display_name.$title.", <a href=/focar>".__("go to online app and start focus", "sis-foca-js")."</a>";#acessar aplicativo online e focar
	} else {
		$msg_saudacao = __("Dear visitor", "sis-foca-js").", <a href=/register>".__("register for free", "sis-foca-js")."</a> ".__("and start focus right now", "sis-foca-js");
		$msg_saudacao2 = __("If you already have an account", "sis-foca-js").", <a id=testes href=# class=abrir_login>".__("login", "sis-foca-js")."</a>";
	} 
	if($alertify) {
		echo "<script>alertify.log('".$msg_saudacao."');</script>";
		if(isset($msg_saudacao2))
		echo "<script>alertify.log('".$msg_saudacao2."');</script>";	
	} else {
		if(isset($msg_saudacao2))
			echo $msg_saudacao.". ".$msg_saudacao2;
		else
			echo $msg_saudacao;
	}
	
}
####
function get_meta_values( $meta_key,  $post_type = 'post' ) {

    $posts = get_posts(
        array(
            'post_type' => $post_type,
            'meta_key' => $meta_key,
            'posts_per_page' => -1,
            #'author' => '-2', exclude francisco matelli matulovic
        )
    );

    $meta_values = array();
    foreach( $posts as $post ) {
        $meta_values[] = get_post_meta( $post->ID, $meta_key, true );
    }
    return array_count_values($meta_values);
    #return $meta_values;

}

function array_to_rank ($ar, $qtt) { ?>
	<ul>
	<?php 
	arsort($ar);
	$i = 1;
	foreach ($ar as $key => $value) { 
		if($key) {
		?>
		<li>
			<?php echo $i.". ".$key. " : ".$value; ?>
		</li>
	<?php 
	if (++$i == $qtt) break;
	} 
	}?>
	</ul>
<?php }

#get_projectimer_tags_COPY();
function get_projectimer_tags_COPY($excludeTags=NULL) {
	
	global $please_dont_change_wpdb_woo_separated_tables;
	$please_dont_change_wpdb_woo_separated_tables=true;

	$args = array(
		'post_type' => array("projectimer_focus"),
		'author'        =>  get_current_user_id(),
		'post_status' => array("publish", "future", "pending", "draft"),
		'posts_per_page' => -1,

	);
	$all_projectimer_tags = get_posts( $args );
	$please_dont_change_wpdb_woo_separated_tables=false;
	#set_shared_database_schema();
	$terms = array();
	foreach ($all_projectimer_tags as $post) {
		$tags = get_the_terms($post->ID, 'post_tag');
		if($tags) {
			foreach ($tags as $tag) {
				//array_
				//$t = "<option>".$tag->slug."</option>";
				$t = $tag->slug;
				if(!in_array($t, $terms)) {
					if($excludeTags) {
						if(!in_array($t, $excludeTags))
						$terms[] = $t;
					} else {
						$terms[] = $t;
					}

				}
			}
		}
		//$terms[] = $tags;
	}
	if($terms)
		return $terms;
	else
		return "projeto-inicial";
}

#
function add_lost_password_link() {
    return '<a href="/wp-login.php?action=lostpassword">Forgot password (esqueci a senha)</a>';
    #
}

function go_home(){
	wp_redirect( home_url() );
	exit();
}

function my_remove_menu_pages() {
	wp_get_current_user();
	if(!current_user_can('administrator')) {
		remove_menu_page('link-manager.php');
		remove_menu_page('themes.php');
		remove_menu_page('index.php');
		remove_menu_page('tools.php');
		remove_menu_page('profile.php');
		remove_menu_page('upload.php');
		remove_menu_page('post.php');
		remove_menu_page('post-new.php');
		remove_menu_page('edit-comments.php');
		remove_menu_page('admin.php');
		remove_menu_page('edit-comments.php');
		remove_submenu_page( 'edit.php', 'post-new.php' );
		remove_submenu_page( 'tools.php', 'wp-cumulus.php' );
		
		 remove_meta_box('linktargetdiv', 'link', 'normal');
		  remove_meta_box('linkxfndiv', 'link', 'normal');
		  remove_meta_box('linkadvanceddiv', 'link', 'normal');
		  remove_meta_box('postexcerpt', 'post', 'normal');
		  remove_meta_box('trackbacksdiv', 'post', 'normal');
		  remove_meta_box('commentstatusdiv', 'post', 'normal');
		  remove_meta_box('postcustom', 'post', 'normal');
		  remove_meta_box('commentstatusdiv', 'post', 'normal');
		  remove_meta_box('commentsdiv', 'post', 'normal');
		  remove_meta_box('revisionsdiv', 'post', 'normal');
		  remove_meta_box('authordiv', 'post', 'normal');
		  remove_meta_box('sqpt-meta-tags', 'post', 'normal');
		  remove_meta_box('submitdiv', 'post', 'normal');
		  remove_meta_box('avhec_catgroupdiv', 'post', 'normal');
		  remove_meta_box('categorydiv', 'post', 'normal');
	}
}

/*function edit_admin_menus() {  
	global $menu;  
	$menu[5][0] = 'Pomodoros'; // Change Posts to Pomodoros
}  

/*function myStartSession() {
	if(!session_id()) {
		session_start();
	}
 
}

function myEndSession() {
    session_destroy ();
}*/


function checkLogin() {
	if(!get_current_user_id()) {
		header('Content-type: application/json');//CRUCIAL
		echo json_encode("NOTIN");
		die();
	}
}

function save_progress () {
	checkLogin();
	global $force_publish_post_not_shared;
	$force_publish_post_not_shared = true;
	if(!$_POST['post_priv'])
		$_POST['post_priv']="publish";
	$tagsinput = explode(" ", $_POST['post_tags']);
	date_default_timezone_set('America/Sao_Paulo');

	$agora = current_time('Y-m-d H:i:s');#current_time("mysql");
	$agora_gmt = current_time("mysql", true);
	#echo "agora:".$agora.", agora_gmt:".$agora_gmt;die;
	$my_post = array(
		'post_type' => 'projectimer_focus',
		'post_title' => $_POST['post_titulo'],
		'post_content' => $_POST['post_descri'],
		'post_status' => $_POST['post_priv'],
		'post_category' => array(1, $_POST['post_cat']),
		'post_author' => $current_user->ID,
		'tags_input' => ($_POST['post_tags']),
		'post_date' => $agora,
		'post_date_gmt' => $agora_gmt
		//'post_category' => array(0)
	);

	$save_progress = wp_insert_post( $my_post );

	if($save_progress) {
		if($save_progress) {
			update_post_meta( $save_progress, 'post_location_city', $_POST['post_local_city'] );
			update_post_meta( $save_progress, 'post_location_region', $_POST['post_local_region'] );
			update_post_meta( $save_progress, 'post_location_country', $_POST['post_local_country'] );
		}
		if(function_exists("cp_module_notify_displayNoticesFor"))
		cp_module_notify_displayNoticesFor(cp_currentUser());

		
		//$id = get_current_postid_for_user(get_current_user_id());
		$id = $save_progress;
		$current_user = get_currentuserinfo();
		$namefull = $current_user->user_firstname." ".$current_user->user_lastname;
		$user_id = $current_user->ID;

		$act_args = array(
			'user_id' => $user_id,
			'item_id' => $id,
			'component' => 'projectimer',
			'type' => 'projectimer_start',
		);
		//
		if($_POST["post_priv"]=="private")
			$act_args['hide_sitewide'] = true;
		//
		$act_args['action'] = "<p><a href='/colegas/".$current_user->user_login."'><span class=activity_title>".$namefull."</span></a> completou <a href='".get_permalink($save_progress)."'><span class=hidden>$id</span>".$_POST['post_titulo']." (25 min)</a></p>";
	
		$ac = bp_activity_add( $act_args );
		//
		echo "ATIVI:".$ac;
	} else {
		//echo " ERROR NOT PUBLISHED"; #NOT RESPONSE FOR ERROR
	}

	
	//echo wp_publish_post( $my_post );

	/*$sql = "INSERT INTO `wp_posts` (`ID`, `post_author`, `post_date`, `post_date_gmt`, `post_content`, `post_title`, `post_excerpt`, `post_status`, `comment_status`, `ping_status`, `post_password`, `post_name`, `to_ping`, `pinged`, `post_modified`, `post_modified_gmt`, `post_content_filtered`, `post_parent`, `guid`, `menu_order`, `post_type`, `post_mime_type`, `comment_count`) VALUES ";
	$sql .= "(' ','".$current_user->ID."',"."'".$agora."',"."'".$agora."',"."'".$_POST['post_descri']."',"."'".$_POST['post_titulo']."',"."'".$post_excerpt."',"."'".$post_status."',"."'".$comment_status."',"."'".$ping_status."',"."'".$posd_password."',"."'".$post_name."',"."'".$to_ping."',"."'".$pinged."',"."'".$post_modified."',"."'".$post_modified_gmt."',"."'".$post_content_filtered."',"."'".$post_parent."',"."'".$guid."',"."'".$menu_order."',"."'projectimer_focus',"."'".$post_mime_type."',"."'".$comment_count."'),";

	$res = mysql_query($sql); 
	if($res): print 'Successful Insert'; else: print 'Unable to update table'; endif;
	*/
	
	#echo do_action( "save_post_projectimer_focus", int $post_ID, WP_Post $post, bool $update )
	
	die(); 
}

function woo_custom_order_button_text() {
    #return __( 'Realizar Doação', 'woocommerce' ); 
    return __( 'Realizar Pagamento', 'woocommerce' ); 
}
/*
echo date_default_timezone_get();
date_default_timezone_set('UTC');
		echo $agora = (current_time("Y-m-d H:i:s"));
		echo "<br>";
		date_default_timezone_set('America/Sao_Paulo');
		echo date_default_timezone_get();
		echo $agora_gmt = (current_time("Y-m-d H:i:s"));die;*/
#
function load_session () {
	checkLogin();
	
	//checa se já existe um rascunho, caso não cria o primeiro
	
	/*if($pomodoroAtivo=="") {
		
		//If there is no active post, look for any type of post, for the current user
		$args = array(
			'post_type' => 'projectimer_focus',
			'author' => get_current_user_id(),
			'posts_per_page' => 1

		);
		$any_post = get_posts($args);
		

		//$res = get_post($pomodoroAtivo);
		if (count($any_post)==0) {
			echo "É a sua primeira visita? Configurei uma tarefa como exemplo abaixo! $^$ Organizar ambiente$^$ projeto-organizacao$^$ Organizar mesa e gaveta, arquivar papéis do ano passado. Nessa área você pode escrever mais detalhes da tarefa. Uma curiosidade, organizar o ambiente é a tarefa número 1 de quem usa o Pomodoros.com.br pela primeira vez $^$ ".date("Y-m-d H:i:s")."$^$ $^$ $^$ ";
			//echo "É a sua primeira visita? Vou configurar um pomodoro como exemplo"
			//echo "Houve um problema ao carregar seu pomodoro ativo! É sua primeira visita? $^$ $^$ $^$ $^$ ";
			//O $^$ é o separador, para (FALA DA FOCA, TITULO, PROJETO, DESCRICAO)
			
		} else {
			foreach ($any_post as $post) {
				echo "Carreguei sua última tarefa, basta acionar o botão FOCAR! e arregaçar as mangas."."$^$ ".$post->post_title."$^$ ".$tags[0]->name."$^$ ".$post->post_content."$^$ ".$post->post_date."$^$ ".$post->post_status."$^$ ".$post->ID."$^$ ".$secs;
			}
		}
	} else {*/
		//O cara já tem um pomodoroAtivo, só carregar	
		//$res = get_posts($args);
		#$pomodoroAtivo = get_user_meta(get_current_user_id(), "pomodoroAtivo", true);
		//if(!$pomodoroAtivo) {
			//$last_post = get_most_recent_post_of_user( get_current_user_id() );
			//$pomodoroAtivo = $last_post->post_id;
			#get_most_recent_post_of_user( $user_id );
			//$pomodoroAtivo = 1;//INITIAL POMODORO
			//$post = get_post($pomodoroAtivo);
		//} else {
		#$post = get_post($pomodoroAtivo);
		

		$agora = current_time("mysql");
		$agora_gmt = current_time("mysql", true);
		$args = array(
		              'post_type' => 'projectimer_focus',
		              'post_status' => 'draft',
		              'author'   => get_current_user_id(),
		              //'orderby'   => 'title',
		              //'order'     => 'ASC',
		              'posts_per_page' => 1,
		            );
		$post = get_posts($args); #new WP_Query( $args );

		if(!$post) {
			//$pomodoroAtivo = 2;//LOST POMODORO
			//reset_configurations();
			//echo "0";
			$argsnew = array(
					'post_type' => 'projectimer_focus',
		            'post_status' => 'draft',
		            'author'   => get_current_user_id(),
		            'post_title' => 'Testar Pomodoros',
		            //'post_tags' => 'projeto-inicial',
		            'post_content' => 'Bem vindo ao Pomodoros, descreva aqui o que precisa fazer para terminar a tarefa, use este campo como anotações',
				);
			$ok = wp_insert_post($argsnew);
			if($ok) {
				wp_set_post_tags( $ok, 'projeto-inicial' );
				$postReturned['post_title'] = $argsnew['post_title'];
				$postReturned['post_tags'] = array('projeto-inicial');
				$postReturned['post_content'] = $argsnew['post_content'];
				$postReturned['ID'] = $f;
				$postReturned['post_date'] = "now";
				$postReturned['post_status'] = $argsnew['post_status'];
				$postReturned['secs'] = 0;
				$postReturned['agora'] = $agora;
				$postReturned['agora_gmt'] = $agora_gmt;
				$postReturned['tags_total'] = get_projectimer_tags_COPY();
			}
			//$post = get_post($pomodoroAtivo);
		} else {

			#$pomodoroAtivo = update_user_meta(get_current_user_id(), "pomodoroAtivo", $post[0]->ID);
			
			//}
			
			$tags = wp_get_post_tags($post[0]->ID);
			$tags_list = array();
			foreach ($tags as $t) {
				# code...
				$tags_list[]=$t->name;
			}
			//if($post[0]->post_status=="pending") {
			$post[0]->post_date;
			//echo " i ".date("Y-m-d H:i:s");//, strtotime('+25 minutes')
			$timePost  = strtotime($post[0]->post_date);
			//echo " i ";
			
			$agora_strtotime = strtotime($agora);
			
			//echo " S:";
			$secs = ($agora_strtotime - $timePost);

			/*$date = new DateTime( $post[0]->post_date_gmt );
			$date2 = new DateTime( "2014-01-13 04:29:10" );
			echo " s2:".$diffInSeconds = $date2->getTimestamp() - $date->getTimestamp();*/
			//$secs = 1000;
			//} 
			$postReturned['post_title'] = $post[0]->post_title;
			$postReturned['post_tags'] = $tags_list;
			$postReturned['post_content'] = $post[0]->post_content;
			$postReturned['ID'] = $post[0]->ID;
			$postReturned['post_date'] = $post[0]->post_date;
			$postReturned['post_status'] = $post[0]->post_status;
			$postReturned['secs'] = $secs;
			$postReturned['agora'] = $agora;
			$postReturned['tags_total'] = get_projectimer_tags_COPY();	
		}

		$vol = get_user_meta(get_current_user_id(), "rangeVolume", true);
		if($vol<0 || $vol>100 || $vol=="")
			$vol=100;
		$postReturned['range_volume'] = $vol;
		//

		$soundfx_enabled = get_user_meta(get_current_user_id(), "soundfx_enabled", true);
		if($soundfx_enabled=="")
			$soundfx_enabled=true;
		$postReturned['soundfx_enabled'] = $soundfx_enabled;

		$voice_enabled = get_user_meta(get_current_user_id(), "voice_enabled", true);
		if($voice_enabled=="")
			$voice_enabled=true;
		$postReturned['voice_enabled'] = $voice_enabled;

		//header('Content-type: application/json');//CRUCIAL
		//if($pomodoroAtivo)
		echo json_encode($postReturned);
		die();
		#echo "Carreguei sua última tarefa, basta acionar o botão FOCAR! e arregaçar as mangas."."$^$ ".$post->post_title."$^$ ".$tags[0]->name."$^$ ".$post->post_content."$^$ ".$post->post_date."$^$ ".$post->post_status."$^$ ".$post->ID."$^$ ".$secs;
		//}
	//}

	/*} else {
		//O cara ainda não tem pomodoroAtivo
		echo "É a sua primeira visita? Configurei uma tarefa como exemplo abaixo! $^$ Organizar ambiente$^$ projeto-organizacao$^$ Organizar mesa e gaveta, arquivar papéis do ano passado. Nessa área você pode escrever mais detalhes da tarefa. Uma curiosidade, organizar o ambiente é a tarefa número 1 de quem usa o Pomodoros.com.br pela primeira vez $^$ ";
	}*/
	//echo "META[pomodoativo]:".$reqweasdasd.get_current_user_id();
}

function update_session () {
	checkLogin();
	//UPDATE DRAFT POMODOROS ON TASK FORM
	$args = array(
	          'post_type' => 'projectimer_focus',
	          'post_status' => 'draft',
	          'author'   => get_current_user_id(),
	          //'orderby'   => 'title',
	          //'order'     => 'ASC',
	          'posts_per_page' => 1,
	        );
	$post = get_posts($args); #new WP_Query( $args );

	if($_POST['post_status']=="trash") {
		echo wp_trash_post($post[0]->ID);
		die();
	}
	#$pomodoroAtivo = get_user_meta(get_current_user_id(), "pomodoroAtivo", true);
	$pomodoroAtivo =  $post[0]->ID;

	
	//$tagsinput = explode(" ", $_POST['post_tags']);
	

	//$agora = date("Y-m-d H:i:s");
	
	/*if($_POST['ignora_data']) {
		//echo "com o pomodoro rolando. ";
		$my_post = array(
			'post_type' => 'projectimer_focus',
			'post_title' => $_POST['post_titulo'],
			'post_content' => $_POST['post_descri'],
			'post_category' => array(1, $_POST['post_cat']),
			'post_author' => get_current_user_id(),
			'tags_input' => array($_POST['post_tags']),
			'post_status' => "pending",
			'edit_date' => true,
			//'post_date' => $agora
			//'post_date' => $_POST["post_data"]
			//'post_category' => array(0)
		);
	} else {*/
		//echo "com o relógio parado. ";
		$my_post = array(
			'ID'	=> $pomodoroAtivo,
			#'post_type' => 'projectimer_focus',
			'post_title' => $_POST['post_titulo'],
			'post_content' => $_POST['post_descri'],
			'post_category' => array(1, $_POST['post_cat']),
			//'post_author' => get_current_user_id(),
			'tags_input' => $_POST['post_tags'],
			//'post_status' => "draft",
			//'edit_date' => true,
			//'post_date' => $agora
			//'post_date' => $_POST["post_data"]
			//'post_category' => array(0)
		);
	//}
	//if($_POST["post_status"]!="") {
	//	$my_post["post_status"] = $_POST["post_status"];
	//}
	
	//$pomodoroAtivo = get_user_meta(get_current_user_id(), "pomodoroAtivo", true);

	#if(function_exists("force_database_aditional_tables_share")) {
	#	force_database_aditional_tables_share();
	#}
	if($pomodoroAtivo=="") {
		//Não tem pomodoro ativo
		$save_progress = wp_insert_post( $my_post );
		/*if($save_progress) {
			update_post_meta( $save_progress, 'post_location', $_POST['post_local'] );
		}*/
		//update_user_meta(get_current_user_id(), "pomodoroAtivo", $save_progress);
		//$pomodoroAtivo = update_user_meta(get_current_user_id(), "pomodoroAtivo", $save_progress);
		//$pomodoroAtivo = "NAO ACHOU";
		//$pomodoroAtivo = $save_progress;
		//echo "Salvando pela primeira vez.";
	} else {
		//Atualiza o pomodoro ativo
		//$my_post["ID"] = $pomodoroAtivo;
		$save_progress = wp_update_post( $my_post );
		//echo "Atualizando seu pomodoro ativo.";
		//SO USADA PARA TESTES
		//update_user_meta(get_current_user_id(), "pomodoroAtivo", $save_progress);
	}

	//RETORNANDO VALORES
	#$post_atual_pega_data = get_post($pomodoroAtivo);

	//echo "$^$ ".$post_atual_pega_data->post_status."$^$ ".$post_atual_pega_data->post_date;
	$postReturned['post_status'] = $post_atual_pega_data[0]->post_status;
	$postReturned['post_date'] = $post_atual_pega_data[0]->post_date;
	$postReturned['ID'] = $post_atual_pega_data[0]->ID;
	$postReturned['pomodoroAtivo'] = $pomodoroAtivo;
	$postReturned['tags_recebidas'] = $_POST['post_tags'];
	//$postReturned['psot_atual_pega_data'] = $my_post;
	$postReturned['save_progress'] = $save_progress;
	
	$vok = update_user_meta(get_current_user_id(), "rangeVolume", $_POST['range_volume']);

	$postReturned['volume_ok'] = $vok;
	//

	$soundfx_enabled_ok = update_user_meta(get_current_user_id(), "soundfx_enabled", $_POST['soundfx_enabled']);
	$postReturned['soundfx_enabled_ok'] = $soundfx_enabled_ok;

	$voice_enabled_ok = update_user_meta(get_current_user_id(), "voice_enabled", $_POST['voice_enabled']);
	$postReturned['voice_enabled_ok'] = $voice_enabled_ok;

	header('Content-type: application/json');//CRUCIAL
	echo json_encode($postReturned);
	
}

function update_pomo_active () {
	checkLogin();
	//echo "update_pomo";
	$tagsinput = explode(" ", $_POST['post_tags']);
	$pomodoroAtivo = get_user_meta(get_current_user_id(), "pomodoroAtivo", true);
	#date_default_timezone_set('America/Sao_Paulo');
	#$agora = strtotime(current_time("Y-m-d H:i:s"));
	#date_default_timezone_set('UTC');
	#$agora_gmt = strtotime(current_time("Y-m-d H:i:s"));
	
	$agora = current_time("mysql");
	$agora_gmt = current_time("mysql", true);
	/*if($_POST['ignora_data']) {
		//echo "com o pomodoro rolando. ";
		$my_post = array(
			'post_type' => 'projectimer_focus',
			'post_title' => $_POST['post_titulo'],
			'post_content' => $_POST['post_descri'],
			'post_category' => array(1, $_POST['post_cat']),
			'post_author' => get_current_user_id(),
			'tags_input' => array($_POST['post_tags']),
			'post_status' => "pending",
			'edit_date' => true,
			//'post_date' => $agora
			//'post_date' => $_POST["post_data"]
			//'post_category' => array(0)
		);
	} else {*/
		//echo "com o relógio parado. ";
		$my_post = array(
			//'ID'	=> $pomodoroAtivo;
			'post_type' => 'projectimer_focus',
			'post_title' => $_POST['post_titulo'],
			'post_content' => $_POST['post_descri'],
			'post_category' => array(1, $_POST['post_cat']),
			'post_author' => get_current_user_id(),
			'tags_input' => array($_POST['post_tags']),
			//'post_status' => "draft",
			'edit_date' => true,
			'post_date' => $agora,
			'post_date_gmt' => $agora_gmt
			//'post_date' => $_POST["post_data"]
			//'post_category' => array(0)
		);
	//}
	//if($_POST["post_status"]!="") {
	//	$my_post["post_status"] = $_POST["post_status"];
	//}
	
	//$pomodoroAtivo = get_user_meta(get_current_user_id(), "pomodoroAtivo", true);

	if($pomodoroAtivo=="") {
		//Não tem pomodoro ativo
		$save_progress = wp_insert_post( $my_post );
		update_user_meta(get_current_user_id(), "pomodoroAtivo", $save_progress);
		$pomodoroAtivo = $save_progress;
		if($save_progress) {
			update_post_meta( $save_progress, 'post_location', $_POST['post_local'] );
		}
		//echo "Salvando pela primeira vez.";

	} else {
		//Atualiza o pomodoro ativo
		$my_post["ID"] = $pomodoroAtivo;
		$save_progress = wp_update_post( $my_post );
		//echo "Atualizando seu pomodoro ativo.";
		//SO USADA PARA TESTES
		//update_user_meta(get_current_user_id(), "pomodoroAtivo", $save_progress);
	}

	//RETORNANDO VALORES
	$post_atual_pega_data = get_posts($pomodoroAtivo);
	//echo "$^$ ".$post_atual_pega_data->post_status."$^$ ".$post_atual_pega_data->post_date;
	$postReturned['post_status'] = $post_atual_pega_data[0]->post_status;
	$postReturned['post_date'] = $post_atual_pega_data[0]->post_date;
	$postReturned['ID'] = $post_atual_pega_data[0]->ID;
	$postReturned['pomodoroAtivo'] = $pomodoroAtivo;
	$postReturned['post_atual_pega_data'] = $my_post;
	$postReturned['save_progress'] = $save_progress;
	

	//

	header('Content-type: application/json');//CRUCIAL
	echo json_encode($postReturned);
	
}

function save_or_delete_model () {
	checkLogin();
	//header('Content-type: application/json');//CRUCIAL
	if(isset($_POST['post_para_deletar'])) {
		#echo "deletando: ".$_POST['post_para_deletar'];
		$del = wp_trash_post($_POST['post_para_deletar']);
		echo $del;
		die();
	} else {
		$tagsinput = explode(" ", $_POST['post_tags']);	
		$my_post = array(
			'post_type' => 'projectimer_focus',
			'post_title' => $_POST['post_titulo'],
			'post_content' => $_POST['post_descri'],
			'post_status' => "pending",
			'post_author' => $current_user->ID,
			'tags_input' => ($_POST['post_tags'])
		);
		#var_dump(($_POST['post_tags']));
		$idofpost = wp_insert_post( $my_post );
		echo $idofpost;
		#die();
	}
}

function update_cycle_list() {
	checkLogin();
	//
	if(isset($_POST["clean"])) {
		$ok = update_user_meta(get_current_user_id(), "cycle_list", "");
		echo $ok;
	} else {
		if(isset($_POST['list'])) {
			$ok = update_user_meta(get_current_user_id(), "cycle_list", $_POST["list"]);
			echo $ok;
		} else {
			echo false;
		}	
	}
	
}
function create_post_type() {
	createPostTypeCOPY_FROM_PROJECTIMER_PLUGIN();
}

function createPostTypeCOPY_FROM_PROJECTIMER_PLUGIN() {
	if ( ! post_type_exists( "projectimer_focus" ) ) {
		$labelFocus = array(
			'name'  => __( 'Focus',' projectimer-plugin' ), 
			'singular_name' => __( 'Focus',    ' projectimer-plugin' ),
			'add_new'    => __( 'Add New', ' projectimer-plugin' ),
			'add_new_item'  => __( 'Add New Focus',    ' projectimer-plugin' ),
			'edit'  => __( 'Edit', ' projectimer-plugin' ),
			'edit_item'  => __( 'Edit Focus', ' projectimer-plugin' ),
			'new_item'   => __( 'New Focus', ' projectimer-plugin' ),
			'view'  => __( 'View Focus', ' projectimer-plugin' ),
			'view_item'  => __( 'View Focus', ' projectimer-plugin' ),
			'search_items'  => __( 'Search Focus', ' projectimer-plugin' ),
			'not_found'  => __( 'No Focus found', ' projectimer-plugin' ),
			'not_found_in_trash' => __( 'No Focus found in Trash', ' projectimer-plugin' ),
			'parent'     => __( 'Parent Focus',     ' projectimer-plugin' ),
		);
		
		$postTypeFocusParams = array(
			'labels'  => $labelFocus,
			'singular_label'  => __( 'Focus', ' projectimer-plugin' ),
			'public'  => true,
			//'show_ui' => true,
			'menu_icon' => get_bloginfo('stylesheet_directory').'/images/projectimer_post_type_icon.png',
			'description' => 'Post type for Projectimer Plugin',
			'menu_position'   => 20,
			'can_export' => true,
			'hierarchical'    => false,
			'capability_type' => 'post',
			'rewrite' => array( 'slug' => 'done'),//, 'with_front' => false ),
			'has_archive' => true,
			'query_var'  => true,
			'show_in_rest' => true,
			'taxonomies' => array('post_tag', 'category'),
			'supports'   => array( 'title', 'content', 'editor', 'author', 'thumbnail', 'comments', 'revisions', 'custom-fields' )
		);

		#var_dump($postTypeFocusParams);die;
		register_post_type("projectimer_focus", $postTypeFocusParams);
		
		#register_taxonomy_for_object_type("post_tags", "projectimer_focus");
		#register_taxonomy_for_object_type("categories", "projectimer_focus");
		#register_taxonomy_for_object_type('category', 'projectimer_focus');
		#register_taxonomy_for_object_type('post_tag', 'projectimer_focus');
	}
}

/*function get_user_subscription($user_id, $domain) {
	$user_id = (!isset($user_id)) ? get_current_user_id() : $user_id;
	$sql = "SELECT * FROM f5sites_posts WHERE post_type='subscription' AND post_author=".$user_id;
	global $wpdb;
	 echo "<pre>"; print_r($wpdb); echo "</pre>";
	
	$results = $wpdb->get_results( $sql, OBJECT );
	die;
				
}*/
//get_user_subscription(2, $_SERVER['REQUEST_URI']);
foreach( array( 'projectimer_focus' ) as $hook )
    add_filter( "views_edit-$hook", 'modified_views_so_15799171' );

function modified_views_so_15799171( $views ) {
    $views['all'] = str_replace( 'All ', 'Tutti ', $views['all'] );

    if( isset( $views['publish'] ) )
        $views['publish'] = str_replace( 'Published ', 'Online ', $views['publish'] );

    if( isset( $views['future'] ) )
        $views['future'] = str_replace( 'Scheduled ', 'Future ', $views['future'] );

    if( isset( $views['draft'] ) )
        $views['draft'] = str_replace( 'Drafts ', 'Clipboard ', $views['draft'] );

    if( isset( $views['pending'] ) )
        $views['trash'] = str_replace( 'Pending ', 'Models ', $views['trash'] );

    if( isset( $views['trash'] ) )
        $views['trash'] = str_replace( 'Trash ', 'Done ', $views['trash'] );
    #PT
    if( isset( $views['draft'] ) )
        $views['draft'] = str_replace( 'Rascunhos ', 'Clipboard ', $views['draft'] );

    if( isset( $views['pending'] ) )
        $views['pending'] = str_replace( 'Pendentes ', 'Modelos ', $views['pending'] );

    return $views;
}

function custom_rewrite_basic() {
  add_rewrite_rule('^shop/?$', 'index.php?page_id=3487', 'top');
}


function wpse187831_redir_loggedin() {
    global $action;

    if ('logout' === $action || !is_user_logged_in()) {
        return;
    }

    wp_redirect(apply_filters(
        'wpse187831_loggedin_redirect',
        current_user_can('administrator') ? admin_url() : home_url(),
        wp_get_current_user()
    ), 302);
    exit;
}

/*
function show_lang_options($hide_title=false, $current_location="") {
	global $user_prefered_language;
	if($current_location=="") {
		if($user_prefered_language!="")
			$current_location = $user_prefered_language;
		else
			$current_location = "notset";
	} ?>

		<?php 
		if(!$hide_title) { ?>
			<strong>Change Language:</strong>
		<?php }
		/*if($showtitle_in_h3) { ?>
			<h3 class="widget-title">Change Language</h3>
		<?php } else { ?>
			<strong>Change Language:</strong>
		<?php } * / ?>

	<?php
	#var_dump($user_prefered_language);
	#var_dump($current_location);die;
	switch ($current_location) {
		case 'notset' :
		case 'en' :
		case 'en_US' :
			generate_flag_links_except("en");
			break;
		
		case 'pt' :
		case 'pt_BR' :
			generate_flag_links_except("pt");
			break;

		case 'fr' :
		case 'fr_FR' :
			generate_flag_links_except("fr");
			break;

		case 'es' :
		case 'es_ES' :
			generate_flag_links_except("es");
			break;

		case 'zh' :
		case 'zh_CN' :
			generate_flag_links_except("zh");
			break;

		default:
			generate_flag_links_except("en");
			break;
	}
	/*
	if($current_location!="en" && $current_location!="en_US") { ?>
		<?php if($showtitle_in_h3) { ?>
			<h3 class="widget-title">Change Language</h3>
		<?php } else { ?>
			<strong>Change Language:</strong>
		<?php } ?>
		<a href="<?php echo get_bloginfo('url'); ?>/?lang=en_US"><img src="<?php bloginfo('stylesheet_directory'); ?>/images/flag-lang/us.png" alt="Language Flag"> English</a>
	<?php } else { ?>
		<?php if($showtitle_in_h3) { ?>
			<h3 class="widget-title">Mudar Idioma</h3>
		<?php } else { ?>
			<strong>Mudar Idioma:</strong>
		<?php } ?>
		<a href="<?php echo get_bloginfo('url'); ?>/?lang=pt_BR"><img src="<?php bloginfo('stylesheet_directory'); ?>/images/flag-lang/br.png" alt="Bandeira de Idioma"> Português</a>
	<?php }* /
}

/*
function generate_flag_links_except($except) { ?>
	<?php 
	$base_link = $_SERVER['REQUEST_URI']; 
	$base_link = preg_replace('/\?.*    /', '', $base_link);
	?>
	<?php if($except!="en" && $except!="en_US") { ?>
		<a href="<?php echo $base_link; ?>?lang=en_US"><img src="<?php bloginfo('stylesheet_directory'); ?>/images/flag-lang/us.png" alt="Language Flag"> English</a>
	<?php } ?>
	<?php if($except!="fr" && $except!="fr_FR") { ?>
		<a href="<?php echo $base_link; ?>?lang=fr_FR"><img src="<?php bloginfo('stylesheet_directory'); ?>/images/flag-lang/fr.png" alt="Drapeau de langue"> Français</a>
	<?php } ?>
	<?php if($except!="pt" && $except!="pt_BR") { ?>
		<a href="<?php echo $base_link; ?>?lang=pt_BR"><img src="<?php bloginfo('stylesheet_directory'); ?>/images/flag-lang/br.png" alt="Bandeira de Idioma"> Português</a>
	<?php } ?>
	<?php if($except!="es" && $except!="es_ES") { ?>
		<a href="<?php echo $base_link; ?>?lang=es_ES"><img src="<?php bloginfo('stylesheet_directory'); ?>/images/flag-lang/es.png" alt="Bandera de Idioma"> Spañol</a>
	<?php } ?>
	<?php if($except!="zh" && $except!="zh_CN") { ?>
		<a href="<?php echo $base_link; ?>?lang=zh_CN"><img src="<?php bloginfo('stylesheet_directory'); ?>/images/flag-lang/cn.png" alt="语言标志"> 中文</a>
	<?php } ?>
<?php }

function check_language_user_and_content($tags) {
	global $user_prefered_language;
	global $user_prefered_language_prefix;
	$user_prefered_language_prefix = substr($user_prefered_language,0,2);
	if($tags) {
		foreach ($tags as $tag) {
			# code...
			if(substr($tag->slug, 0, 5)=="lang-") {
				$content_lang = substr($tag->slug, 5, 7);
				if($user_prefered_language_prefix!=$content_lang) { ?>
					<div class="alert alert-warning">
					<strong><?php _e("Warning!", "sis-foca-js"); ?></strong> 
					<?php _e("These content is not avaiable in your language. Original content language is: ", "sis-foca-js");
					echo "<strong>".$content_lang."</strong>";
					echo "<br>";
					echo "<a href='/'>".__("Go to blog homepage", "sis-foca-js")."</a>";
					#echo "These content is not avaiable in your language";	] ?>
					</div>
				<?php }
			}
		}
	}
	#var_dump($user_prefered_language_prefix);die;
}

function smart_set_user_language() {
	global $user_prefered_language;
	
	if(class_exists("WC_Geolocation")) {
		$wclocation = WC_Geolocation::geolocate_ip();
		$user_location_georefered = $wclocation['country'];

	}
	if(!$user_location_georefered) {
		if(function_exists("locale_accept_from_http"))
			$user_location_georefered = locale_accept_from_http($_SERVER['HTTP_ACCEPT_LANGUAGE']);
		else
			$user_location_georefered = "en_US";
	}
	if($user_location_georefered=="BR")
		$user_location_georefered="pt_BR";

	#$user_prefered_language = $user_location_georefered;
	#var_dump($user_location_georefered);
	

	#$user_lang_pref = get_user_meta(get_current_user_id(), "pomodoros_lang", true);
	#if($user_lang_pref=="")
	#	$user_lang_pref="en_US";
	/*if($user_lang_pref) {
		if($_GET["lang"]=="pt" || $_GET["lang"]=="pt_BR") {
			echo update_user_meta( get_current_user_id(), "pomodoros_lang", "pt_BR" );
		} elseif($_GET["lang"]=="en" || $_GET["lang"]=="en_US") {
			echo update_user_meta( get_current_user_id(), "pomodoros_lang", "en_US" );
		}
	} else {* /
	$user_prefered_language = $user_location_georefered;
	session_start();
	if(!isset($_SESSION["user_prefered_language"]))
	$_SESSION["user_prefered_language"]=$user_prefered_language;
	
	if($_GET && isset($_GET["lang"])) {
		/*if($_GET["lang"]=="pt" || $_GET["lang"]=="pt_BR") {	
			$user_lang_on_url="pt_BR";
			#update_user_meta( get_current_user_id(), "pomodoros_lang", $user_lang_on_url );
		} elseif($_GET["lang"]=="en" || $_GET["lang"]=="en_US") {
			$user_lang_on_url="en_US";
			#update_user_meta( get_current_user_id(), "pomodoros_lang", $user_lang_on_url );
		}* /

		#if($user_lang_on_url!=$user_prefered_language) {
			#$user_prefered_language=$user_lang_on_url;
			$user_prefered_language=$_GET["lang"];
			$_SESSION["user_prefered_language"]=$user_prefered_language;
		#}
	}

	if(isset($_SESSION["user_prefered_language"])) {
		$user_prefered_language=$_SESSION["user_prefered_language"];
	} else {
		$_SESSION["user_prefered_language"]=$user_prefered_language;
	}
	if($user_prefered_language=="")
		$user_prefered_language=="en_US";
	#var_dump($_SESSION["user_prefered_language"]);
	#var_dump($user_prefered_language);
	switch_to_locale($user_prefered_language);
	define_title_apendix($user_prefered_language);
	#var_dump($user_prefered_language);die;
	return $user_prefered_language;
}

function define_title_apendix($lang) {
	global $title_apendix;
	switch ($lang) {
		case 'notset' :
		case 'en' :
		case 'en_US' :
			$title_apendix = "USA/UK";
			break;
		case 'pt' :
		case 'pt_BR' :
			$title_apendix = "Brasil";
			break;

		case 'fr' :
		case 'fr_FR' :
			$title_apendix = "France";
			break;

		case 'es' :
		case 'es_ES' :
			$title_apendix = "Espanã/AL";
			break;

		case 'zh' :
		case 'zh_CN' :
			$title_apendix = "中国";
			break;
		default:
			$title_apendix = "Global";
			break;
	}
}

function show_recent_posts_georefer() {
	#<h3><script>document.write(txt_foot_blog)</script></h3>
	?>
	<div class="widget widget_recent_entries">
		<ul>
		
			<?php 
			if(function_exists('set_shared_database_schema'))set_shared_database_schema();
			
			$idObj = get_category_by_slug("www.pomodoros.com.br"); 

			global $user_prefered_language;
			$user_prefered_language_prefix = substr($user_prefered_language, 0,2);
			
			$arro = array(
				'cat' => $idObj->term_id,
				'posts_per_page' => 6,
				'tag' => "lang-".$user_prefered_language_prefix,
			);
			
			/*if($user_prefered_language=="en" || $user_prefered_language=="en_US")
				#$args[] = array("tag"=>"english");
				$arro["tag"] = "english";
			else 
				$arro["tag__not_in"] = 579;* /
			wp_reset_query();
			$catquery = new WP_Query( $arro );
			while($catquery->have_posts()) : $catquery->the_post();
			?>
			
			<li>
				<?php the_post_thumbnail(array(50,50)); ?>
				<a href="<?php the_permalink() ?>" rel="bookmark"><?php the_title(); ?></a>
			</li>
			
			<?php endwhile;	?>
		</ul>
	</div>
	<?php
}

/*
function fbp($d) {
	
	global $field;
	return ".adas".$d.$field->id; 
	#return $field->id;
	#return apply_filters( 'bp_get_the_profile_field_input_name', 'field_' . $field->id ); 
	#return apply_filters( 'bp_get_the_profile_field_input_name', 'field_' . $field->id ); 
}
add_filter("bp_the_profile_field_input_name", "fbp", 10, 1);
/*
function filter_bp_get_the_profile_field_input_name( $bp_dtheme_add_brackets_to_multiselectbox_attributes ) { 
    // make filter magic happen here... 
    //return "a".$bp_dtheme_add_brackets_to_multiselectbox_attributes; 
    #return apply_filters( 'bp_get_the_profile_field_input_name', 'field_' . $field->id ); 
    die;
} 
         
add_filter( 'bp_get_the_profile_field_input_name', 'filter_bp_get_the_profile_field_input_name', 10, 1 );


/*function show_most_recent_taskDISABLED() {
	#echo '<h3 class="widget-title">Tarefa recente</h3>';
	if(is_user_logged_in()) {
		$current_user = wp_get_current_user(); 
		$args = array(
		              'post_type' => 'projectimer_focus',
		              'post_status' => 'draft',
		              'author'   => get_current_user_id(),

		              'posts_per_page' => 1,
		            );
		$recent = get_posts($args);
		if( $recent ){
		  $title = ", ".__("you most recent task is", "sis-foca-js")." <i>".get_the_title($recent[0]->ID)."</i>";#sua tarefa mais recente é
		}else{
		  $title = ", ".__("you never started a task", "sis-foca-js"); #você ainda não começou nenhuma tarefa //No published posts
		} 
		$msg_saudacao = __("Hello", "buddypress")." ".$current_user->display_name.$title.", <a href=/focar>".__("go to online app and start focus", "sis-foca-js")."</a>";#acessar aplicativo online e focar
	} else {
		#$msg_saudacao = "Caro visitante, <a href=/register>crie sua conta GRÁTIS</a> para acessar o aplicativo online";
		#$msg_saudacao2 = "Se já possui um usuário, <a id=testes href=# class=abrir_login>acesse sua conta</a>";
		echo show_welcome_message();
	} 
			
	echo $msg_saudacao;
	if(isset($msg_saudacao2))
	echo $msg_saudacao2;
	#die();
}*/
