<?php

// Register Post Type
function timeline_posttype() {
	$register = new TimelinePostTypes('timeline', array(), array('plural_name' => 'Timelines') );
}

add_action('init', 'timeline_posttype');




// Enqueue Timeline Styles & Scripts
function timeline_enqueues() {

	$handle    = 'jquery-appear';
	$src       = UT_URL . 'js/jquery.appear.js'; 
	$deps      = array('jquery');
	$ver       = 1.0; 
	$in_footer = false;

	wp_enqueue_script( $handle, $src, $deps, $ver, $in_footer );


	$handle    = 'jquery-expander';
	$src       = UT_URL . 'js/jquery.expander.min.js'; 
	$deps      = array('jquery');
	$ver       = '1.4.7'; 
	$in_footer = false;

	wp_enqueue_script( $handle, $src, $deps, $ver, $in_footer );


	$handle    = 'timeline';
	$src       = UT_URL . 'js/timeline.js'; 
	$deps      = array('jquery', 'jquery-appear');
	$ver       = 1.0; 
	$in_footer = true;

	wp_enqueue_script( $handle, $src, $deps, $ver, $in_footer );


	$handle    = 'timeline';
	$src       = UT_URL . 'css/timeline.css'; 
	$deps      = array(); 
	$ver       = 1.0; 
	$media     = 'all';

	wp_enqueue_style( $handle, $src, $deps, $ver, $media );
	
	$options   = get_option('timeline_basics');
	$option    = isset($options['fontawesome_turn'])?$options['fontawesome_turn']:"";

	if($option != 'no') :

	$handle    = 'font-awesome';
	$src       = UT_URL . 'css/font-awesome.css'; 
	$deps      = array(); 
	$ver       = 1.0; 
	$media     = 'all';



	wp_enqueue_style( $handle, $src, $deps, $ver, $media );

	endif;
}

add_action('wp_enqueue_scripts', 'timeline_enqueues');


// Enqueue Timeline Styles & Scripts
function timeline_admin_enqueues() {

    $handle    = 'admin-timeline';
	$src       = UT_URL . 'js/admin-timeline.js'; 
	$deps      = array('jquery');
	$ver       = 1.0; 
	$in_footer = true;

	wp_enqueue_script( $handle, $src, $deps, $ver, $in_footer );


	$handle = 'admin-timeline';
	$src    = UT_URL . 'css/admin-timeline.css'; 
	$deps   = array(); 
	$ver    = 1.0; 
	$media  = 'all';

    wp_register_style( $handle, $src, $deps, $ver, $media );
    wp_enqueue_style( $handle );

}
add_action( 'admin_enqueue_scripts', 'timeline_admin_enqueues' );



// Generate Shortcode
function save_shortcode( $post_id ) {

	$meta_key   = "shortcode";
	$meta_value = "[timeline id={$post_id}]";

	update_post_meta( $post_id, $meta_key, $meta_value );
    
}
add_action( 'save_post', 'save_shortcode' );


// Trow A Notice If Missing Twitter Info
function timeline_admin_notice() {

	$connection    = get_option('timeline_connection');
	$basics        = get_option('timeline_basics');

	$consumer_key = $connection['consumer_key'];
	$secret_key   = $connection['consumer_secret'];

	$fb_id		  = isset($connection['fb_app_id'])?$connection['fb_app_id']:"";
	$fb_secret	  = isset($connection['fb_consumer_secret'])?$connection['fb_consumer_secret']:"";

	$instagram_access_token   = isset($connection['instagram_access_token'])?$connection['instagram_access_token']:"";
	$instagram_client_id      = isset($connection['instagram_client_id'])?$connection['instagram_client_id']:"";
	$instagram_client_secret  = isset($connection['instagram_client_secret'])?$connection['instagram_client_secret']:"";

	$url = get_admin_url( '', '/edit.php?post_type=timeline&page=ul-timeline-options' );

	$a = get_option('timeline_basics');
 
	if(  (empty($consumer_key) || empty($secret_key)) && ($a['twitter_disable'] != 'yes') ) {
     ?>
    
    <div class="error">
        <p><?php _e( 'Ultimate Timeline: Please enter your Twitter account info <a href="' .$url. '">here</a>'  . ' <a href="?twitter_dismiss_me=yes">Dismiss</a>', 'timeline' ); ?></p>
    </div>
    <?php	

    }
    $a = get_option('timeline_basics');
    if(  (empty($fb_id) || empty($fb_secret)) && ($a['fb_disable'] != 'yes') ) {
     ?>
    
    <div class="error">
        <p><?php _e( 'Ultimate Timeline: Please enter your Facebook account info <a href="' .$url. '">here</a>'  . ' <a href="?fb_dismiss_me=yes">Dismiss</a>', 'timeline' ); ?></p>
    </div>
    <?php
    
    }
    $a = get_option('timeline_basics');
    if(  (empty($instagram_access_token) || empty($instagram_client_id) || empty($instagram_client_secret)) && ($a['insta_disable'] != 'yes') ) {
     ?>
    
    <div class="error">
        <p><?php _e( 'Ultimate Timeline: Please enter your Instagram account info <a href="' .$url. '">here</a>'  . ' <a href="?insta_dismiss_me=yes">Dismiss</a>', 'timeline' ); ?></p>
    </div>
    <?php	

    }
}
add_action( 'admin_notices', 'timeline_admin_notice' );



function thsp_dismiss_admin_notice() {

	// $a = get_option('timeline_basics');
	// unset($a['twitter_disable']);
	// unset($a['fb_disable']);
	// unset($a['insta_disable']);
	// update_option( 'timeline_basics', $a );

	
	// If "Dismiss" link has been clicked, user meta field is added
	if ( isset( $_GET['twitter_dismiss_me'] ) && 'yes' == $_GET['twitter_dismiss_me'] ) {
		$a = get_option('timeline_basics');

		$a['twitter_disable'] = 'yes';
		update_option( 'timeline_basics', $a );
	}

	if ( isset( $_GET['fb_dismiss_me'] ) && 'yes' == $_GET['fb_dismiss_me'] ) {
		$a = get_option('timeline_basics');

		$a['fb_disable'] = 'yes';
		update_option( 'timeline_basics', $a );
	}

	if ( isset( $_GET['insta_dismiss_me'] ) && 'yes' == $_GET['insta_dismiss_me'] ) {
		$a = get_option('timeline_basics');

		$a['insta_disable'] = 'yes';
		update_option( 'timeline_basics', $a );
	}
}

add_action( 'admin_init', 'thsp_dismiss_admin_notice' );


// Custom Post Type Messages
function custom_post_type_messages($messages) {
  global $post, $post_ID;

  $post_type = get_post_type( $post_ID );
  $obj = get_post_type_object($post_type);

  $singular = $obj->labels->singular_name;

  $viewLink = ($obj->public) ?  ' <a href="%s">View '.strtolower($singular).'</a>' : "";
  $previewLink = ($obj->public) ? ' <a target="_blank" href="%s">Preview '.strtolower($singular).'</a>': "";
  $schedPreviewLink = ($obj->public) ? ' <a target="_blank" href="%2$s">Preview '.strtolower($singular).'</a>': "";

  $messages[$post_type] = array(
    0 => '', // Unused. Messages start at index 1.
    1 => sprintf( __($singular.' updated.'.$viewLink), esc_url( get_permalink($post_ID) ) ),
    2 => __('Custom field updated.'),
    3 => __('Custom field deleted.'),
    4 => __($singular.' updated.'),
    5 => isset($_GET['revision']) ? sprintf( __($singular.' restored to revision from %s'), wp_post_revision_title( (int) $_GET['revision'], false ) ) : false,
    6 => sprintf( __($singular.' published.'.$viewLink), esc_url( get_permalink($post_ID) ) ),
    7 => __('Page saved.'),
    8 => sprintf( __($singular.' submitted.'.$previewLink), esc_url( add_query_arg( 'preview', 'true', get_permalink($post_ID) ) ) ),
    9 => sprintf( __($singular.' scheduled for: <strong>%1$s</strong>.'.$schedPreviewLink), date_i18n( __( 'M j, Y @ G:i' ), strtotime( $post->post_date ) ), esc_url( get_permalink($post_ID) ) ),
    10 => sprintf( __($singular.' draft updated.'.$previewLink), esc_url( add_query_arg( 'preview', 'true', get_permalink($post_ID) ) ) ),
  );
  return $messages;
}

add_filter('post_updated_messages', 'custom_post_type_messages');

// Return Icon Container If Icons Are Enabled
function get_timeline_icons($value, $timeline_id) {
	

	


	$options = get_option('timeline_basics');
	$option = $value['type'] . '_icon';
	$option = $options[$option];

	if($option != 'yes') return;

	// Custom Icon For individual blog posts
	if($value['type'] == 'post') :

		$id = $value['id'];
		if( get_field('post_icon', $id) ==  'Image') :
		
			$src = wp_get_attachment_image_src(get_field('image', $id), 'thumbnail');
			return "<div class='ut-timeline-icon img-type-{$value['type']}' style='background-image:url({$src[0]});'></div>";

		elseif( get_field('post_icon', $id) == 'fontawesome') :

			return "<div class='ut-timeline-icon fa-type-{$value['type']}'><i class='fa fa-" .get_field('fontawesome', $id). "'></i></div>";

		endif;	

	endif;	


	// Custom Icon For individual Status Update
	
	$type 		 = $value['type'];
	$custom_icon = $value['custom_icon'];
	$fontawesome = $value['fontawsome'];
	$icon 		 = $value['icon'];

	if($type == 'status') :
		if($custom_icon == 'fontawesome') :

			$output = "<div class='ut-timeline-icon type-stat'><i class='fa fa-{$fontawesome}'></i></div>";
			return $output;

		elseif($custom_icon == 'image') :

			$output = "<div class='ut-timeline-icon type-stat' style='background-image:url({$icon});'></div>";
			return $output;

		endif;
	endif;
	
	
	if($options['icon_choice'] == 'images') :

		$output = "<div class='ut-timeline-icon type-{$type}'></div>";

	elseif($options['icon_choice'] == 'fa-icons') :
		
		$class_name = $type . '_icon_fontawesome';
		$class = $options[$class_name];
		// if($type == 'dribbble') {
		// 	var_dump($class_name);die;
		// }
		if(($pos = strpos($class, 'fa-')) !== false) {
	   		$class = substr($class, $pos + 3); 
	   	}

		$output = "<div class='ut-timeline-icon'><i class='fa fa-{$class}'></i></div>";

	else : 

		$output = "<div class='ut-timeline-icon type-{$type}'></div>";

	endif;	

	return $output;
}

// Add ODD/EVEN Classes
function timeline_odd_even($count) {
	if($count % 2) {
		return ' timeline-odd';
	} else {
		return ' timeline-even';
	}
}

function timeline_affiliates() {
	$options = get_option('timeline_basics');
	$option = $options['affiliate_link'];

	if($option == 'no') return;

	if(isset($options['affiliate_id']) && !empty($options['affiliate_id'])) {
		$affiliate = $options['affiliate_id'];
	} else {
		$affiliate = DEFAULT_AFFILIATE;
	}



	$link = "http://codecanyon.net/item/wordpress-ultimate-timeline/7411135?ref={$affiliate}";
	

	$output  = "<p class='timeline-affiliates'>"; 
	$output .= "<a href='{$link}' title='WordPress Ultimate Timeline - Available on CodeCanyon'>"; 
	$output .= "Made with WP Ultimate Timeline"; 
	$output .= "</a>"; 
	$output .= "</p>";

	return $output;
}


function timeline_dynamic_styles() {
	$options = get_option('timeline_appearance');
	extract($options);

	if($default_css == 'yes') return;

	$output  = "<style>";
	$output .= "	.ut-timeline { background-color: $background_color; }";
	$output .= "	.ut-timeline .ut-timeline-icon .fa { color: $icon_color; }";
	$output .= "	.ut-timeline .ut-timeline-content ul.ut-timeline-ulist:before { background-color: $sepereator; }";
	$output .= "	.ut-timeline .ut-timeline-content ul.ut-timeline-ulist .ut-timeline-col1::after { background-color: $sepereator_dots; border-color: $background_color; }";
	$output .= "	.ut-timeline .ut-timeline-text-wrap { background-color: $text_container_bg; }";
	$output .= "	.ut-timeline .ut-timeline-text-wrap:before { border-right-color: $text_container_bg; }";
	$output .= "	.ut-timeline li.ut-timeline-list-item:nth-child(even) .ut-timeline-text-wrap:before { border-left-color: $text_container_bg; }";
	$output .= "	.ut-timeline .ut-timeline-content .ut-timeline-text-wrap h3.ut-timeline-title,";
	$output .= "	.ut-timeline .ut-timeline-content .ut-timeline-text-wrap h3.ut-timeline-title a { color: $title_color; }";
	$output .= "	.ut-timeline .ut-timeline-content .ut-timeline-text-wrap p.ut-timeline-text { color: $content_color; }";
	$output .= "	.ut-timeline a { color: $links_color; }";
	$output .= "	.ut-timeline .ut-timeline-content ul.ut-timeline-ulist .ut-timeline-col1 p.ut-timeline-date { color: $date_color; }";
	$output .= "	.ut-timeline .ut-timeline-footer { background-color: $footer_bg; } ";
	$output .= "	.ut-timeline .ut-timeline-footer::before { border-bottom-color: $footer_bg; }";
	$output .= "	.ut-timeline .ut-timeline-begin span.begin-text, ";
	$output .= "	.ut-timeline .ut-timeline-end span.end-text { color: $begin_end_text_color; }";
	$output .= "	.ut-timeline .ut-timeline-begin span.begin-text, ";
	$output .= "	.ut-timeline .ut-timeline-end span.end-text { background-color: $begin_end_text_bg; }";
	$output .= "	/*Responsive Styles*/";
	$output .= "	.ut-timeline.timeline-responsive .ut-timeline-text-wrap:after { background-color: $sepereator_dots; border-color: $background_color; }";
	$output .= "	.ut-timeline.timeline-responsive li.ut-timeline-list-item .ut-timeline-text-wrap:before { border-right-color: $text_container_bg; }";
	$output .= "</style>";

	return $output;
}


function timeline_dynamic_icons() {
	$options = get_option('timeline_basics');
	extract($options);

	$output  = '<style>';

	if(( $tweet_icon   == 'yes' ) && !empty( $tweet_icon_file ) && ( $icon_choice ) == 'images' ) :
		$output .= ".ut-timeline-icon.type-tweet { background-image: url('$tweet_icon_file'); }";
	endif;	

	if(( $facebook_icon == 'yes' ) && !empty( $facebook_icon_file ) && ( $icon_choice ) == 'images' ) :
		$output .= ".ut-timeline-icon.type-facebook { background-image: url('$facebook_icon_file'); }";
	endif;

	if(( $dribbble_icon == 'yes' ) && !empty( $dribbble_icon_file ) && ( $icon_choice ) == 'images' ) :
		$output .= ".ut-timeline-icon.type-dribbble { background-image: url('$dribbble_icon_file'); }";
	endif;

	if(( $post_icon    == 'yes' ) && !empty( $post_icon_file )): 
		$output .= ".ut-timeline-icon.type-post { background-image: url('$post_icon_file'); }";
	endif;	

	if(( $status_icon  == 'yes' ) && !empty( $status_icon_file )) :
		$output .= ".ut-timeline-icon.type-status { background-image: url('$status_icon_file'); }";
	endif;		

	$output .= '</style>';

	return $output;
}


function excluded_posts($key, $id) {

	$exclude_posts = get_field($key, $id);
	$exclude = array();

	if( !$exclude_posts ) return $exclude;
	
	foreach( $exclude_posts as $excluded ) {
		$exclude[] = $excluded->ID;
	}
	return $exclude;
}

function included_authors($key, $id) {

	$authors = get_field($key, $id);
	$author_ids = '';

	if( !$authors ) return $author_ids;

	foreach( $authors as $author ) {
		$author_ids .= $author['ID'] . ',';
	}
	return rtrim($author_ids, ',');
}


function set_timeline_columns($columns) {
    return array(
        'cb' => '<input type="checkbox" />',
        'title' => __('Timeline Title'),
        'shortcode' => __('Shortcode'),
        'date' => __('Date')
    );
}
add_filter('manage_timeline_posts_columns' , 'set_timeline_columns');


function data_new_gallery_columns($column, $post_id) {

    switch ( $column ) {
        case 'shortcode' :
        	$output  = "<div class='shortcode-holder'>";
        	$output .= get_post_meta( $post_id , 'shortcode' , true );
        	$output .= "</div>";
        	echo $output;
    }
}
add_action('manage_timeline_posts_custom_column', 'data_new_gallery_columns', 10, 2);




function timeline_time_ago($time) {

		$timestamp      = $time;
	    $current_time   = time();
	    $diff           = $current_time - $timestamp;
	    
	    //intervals in seconds
	    $intervals      = array (
	        'year' => 31556926, 'month' => 2629744, 'week' => 604800, 'day' => 86400, 'hour' => 3600, 'minute'=> 60
	    );
	    
	    //now we just find the difference
	    if ($diff == 0) {
	        $output = 'just now';
	    }    

	    if ($diff < 60) {
	         if ($diff == 1) {$output = $diff . ' second ago'; } else {$output = $diff . ' seconds ago'; }
	    }        

	    if ($diff >= 60 && $diff < $intervals['hour']) {
	        $diff = floor($diff/$intervals['minute']);
	        if ($diff == 1) { $output = $diff . ' minute ago';} else { $output = $diff . ' minutes ago';}
	    }        

	    if ($diff >= $intervals['hour'] && $diff < $intervals['day']) {
	        $diff = floor($diff/$intervals['hour']);
	        if ($diff == 1) { $output = $diff . ' hour ago'; } else{ $output = $diff . ' hours ago';}
	    }    

	    if ($diff >= $intervals['day'] && $diff < $intervals['week']) {
	        $diff = floor($diff/$intervals['day']);
	         if ($diff == 1) { $output = $diff . ' day ago'; } else { $output = $diff . ' days ago';}
	    }    

	    if ($diff >= $intervals['week'] && $diff < $intervals['month']) {
	        $diff = floor($diff/$intervals['week']);
	         if ($diff == 1) { $output = $diff . ' week ago'; } else { $output = $diff . ' weeks ago';}
	    }    

	    if ($diff >= $intervals['month'] && $diff < $intervals['year']) {
	        $diff = floor($diff/$intervals['month']);
	        if ($diff == 1) { $output = $diff . ' month ago'; } else { $output = $diff . ' months ago'; }
	    }    

	    if ($diff >= $intervals['year']) {
	        $diff = floor($diff/$intervals['year']);
	         if ($diff == 1) {$output = $diff . ' year ago'; } else { $output = $diff . ' years ago';}
	 	}

	 	return $output;
}



//Translation
function smart_seo_load_translation_files() {
  load_plugin_textdomain('ultimate-timeline', 'false', dirname(plugin_basename(__FILE__)) . '/languages/');
 }
 //add action to load my plugin files
 add_action('after_setup_theme', 'smart_seo_load_translation_files');