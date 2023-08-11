<?php

/* #######################################################################

	Wharton by MeanThemes

	Theme Support & Content width

####################################################################### */

// Load editor CSS
add_editor_style();

// Grab general theme options
add_action('after_setup_theme', 'meanthemes_theme_setup');
function meanthemes_theme_setup(){
    load_theme_textdomain( 'meanthemes', get_template_directory().'/languages' );
}

$locale = get_locale();
$locale_file = get_template_directory()."/languages/$locale.php";
if ( is_readable($locale_file) )
	require_once($locale_file);

add_theme_support( 'menus' );
add_theme_support( 'post-thumbnails' );
add_theme_support( 'automatic-feed-links' );
add_theme_support('post-formats', array( 'aside', 'chat', 'gallery', 'image', 'link', 'quote', 'status', 'video', 'audio'));
add_theme_support( 'structured-post-formats', array( 'aside', 'chat', 'gallery', 'image', 'link', 'quote', 'status', 'video', 'audio'));



// Content width
if ( ! isset( $content_width ) ) $content_width = 900;


    /* #######################################################################

      Define Theme Constants

    ####################################################################### */

    $theme = wp_get_theme();
    $theme_title = $theme->name;
    $theme_version = $theme->version;
    $author_url = 'http://www.meanthemes.com';

    define( 'MEANTHEMES_THEME_SLUG', get_template() );
    define( 'MEANTHEMES_THEME_NAME', $theme_title );
    define( 'MEANTHEMES_THEME_VER', $theme_version );
    define( 'MEANTHEMES_URL', $author_url );


    /* #######################################################################

        Add Version and Theme Name and link

    ####################################################################### */

    if ( !function_exists('meanthemes_footer_admin') ) {

        function meanthemes_footer_admin ()
        {
          $random_statement = array (
            MEANTHEMES_THEME_NAME .' v'. MEANTHEMES_THEME_VER .' by <a href="'. MEANTHEMES_URL .'?ref=wp_footer' .'"target="blank">MeanThemes</a>.',
            'Don\'t forget to sign up to the <a href="'. MEANTHEMES_URL .'/sign-up/?ref=wp_footer' .'"target="blank">MeanThemes Newsletter &rarr;</a>',
          );

          $random = (count($random_statement)/1);
          $nmbr = (rand(0,($random-1)));
          $nmbr = $nmbr*1;
          $footer_text = $random_statement[$nmbr];
          $nmbr = $nmbr+1;

          echo $footer_text;

        } //END function meanthemes_footer_admin ()
        add_filter('admin_footer_text', 'meanthemes_footer_admin');

    } //END if ( !function_exists('meanthemes_footer_admin') )



    // Add menu item for themes
function add_drafts_admin_menu_item() {
  // $page_title, $menu_title, $capability, $menu_slug, $callback_function
  add_object_page(__('More MeanThemes', 'meanthemes'), __('More Themes', 'meanthemes'), 'administrator', 'meanthemes_more_themes_menu', 'meanthemes_more_themes', 'dashicons-desktop');
}
//add_action('admin_menu', 'add_drafts_admin_menu_item');



function meanthemes_more_themes( ) {
?>
  <style>
    .mt-btn {
      font-weight: 600;
      padding: 18px 35px;
      border-radius: 5px;
      color: #fff;
      background: #ff4729;
      text-decoration: none;
      display: inline-block;
      font-size: 16px;
    }

    .mt-btn:hover {
      color: #fff;
      background: #dd371c;
    }

    .mt-btn.alternate {
      background: #5bd55b;
    }
    .mt-btn.alternate:hover {
      background: #4db54d;
    }
  </style>
	<div class="wrap meanthemes_admin">
		<h2>Yes, there are more MeanThemes Themes</h2>
    <p>Yes we do more themes, keep up with the latest themes by clicking on this ↓ button below.</p>
    <p><a href="http://www.meanthemes.com/" target="_blank" class="mt-btn">View our latest themes</a></p>
    <h3 style="margin-top: 40px;">Want to be kept up to date via your mailbox?</h3>
    <p>Sure, no problem, just sign up for newsletter using the ↓ button below</p>
    <p><a href="http://www.meanthemes.com/sign-up/?ref=wp_theme_menu" target="_blank" class="mt-btn alternate">Subscribe to our Newsletter</a></p>
    <h3 style="margin-top: 40px;">Social Networks</h3>
    <p>You can keep up to date with everything on <a href="http://facebook.com/MeanThemes" target="_blank">Facebook</a> and <a href="http://twitter.com/GetMeanThemes" target="_blank">Twitter</a> too.</p>

	<?php
}



/* #######################################################################

	Filter home class out for all standard templates.

####################################################################### */

add_filter('body_class', 'remove_a_body_class', 20, 2);
function remove_a_body_class($wp_classes) {
if( is_page_template('t-archive.php') ) {
      foreach($wp_classes as $key => $value) {
      if ($value == 'home') unset($wp_classes[$key]);
      }
}
return $wp_classes;
}

/* #######################################################################

	Add paragraph around read more link

####################################################################### */

function add_p_tag($link){
	return "<p>$link</p>";
}
add_filter('the_content_more_link', 'add_p_tag');

/* #######################################################################

	Custom Image Sizes

####################################################################### */

// You can override the image size with the theme options

$use_image_settings = false;
$image_width = 1100;
$image_height = 9999;
$image_crop = false;

$image_width_wide = 1600;
$image_height_wide = 9999;
$image_crop_wide = false;

$use_image_settings = get_theme_mod( 'use_image_settings');

if ( $use_image_settings === true ) {

	$image_width = get_theme_mod( 'image_width');
	$image_height = get_theme_mod( 'image_height');
	$image_crop = get_theme_mod( 'image_crop');

}



add_image_size( 'default', $image_width, $image_height, $image_crop );
add_image_size( 'wide', $image_width_wide, $image_height_wide, $image_crop_wide );
add_image_size( 'rss-thumb', 300, 9999, false );


/* #######################################################################

	Get Image Caption

####################################################################### */

function the_post_thumbnail_caption2() {
  global $post;
  $thumbnail_id    = get_post_thumbnail_id($post->ID);
  $thumbnail_image = get_posts(array('p' => $thumbnail_id, 'post_type' => 'attachment'));
  if ($thumbnail_image && isset($thumbnail_image[0])) {
    return $thumbnail_image[0]->post_excerpt;
  }
}


/* #######################################################################

	Register Menus

####################################################################### */

register_nav_menus( array(
	'primary' => 'Main Menu'
) );

/* #######################################################################

	Get the topmost ancestor of current page

####################################################################### */

if(!function_exists('get_post_top_ancestor_id')){
	/**
	 * @uses object $post
	 * @return int
	 */
	function get_post_top_ancestor_id(){
		global $post;

		if($post->post_parent){
			$ancestors = array_reverse(get_post_ancestors($post->ID));
			return $ancestors[0];
		}

		return $post->ID;
	}}

/* #######################################################################

	Comments & Password Protect Setup

####################################################################### */

add_filter('the_password_form','my_password_form');
function my_password_form($text){
$text='<div class="password-protect">'.$text.'</div>';
return $text;
}

function post_comments( $comment, $args, $depth ) {
	$GLOBALS['comment'] = $comment;
	switch ( $comment->comment_type ) :
	case '' :
?>
	<li <?php comment_class(); ?> id="li-comment-<?php comment_ID(); ?>">
		<div id="comment-<?php comment_ID(); ?>">

		<span class="author-avatar"><?php echo get_avatar( $comment, 130 ); ?></span>

		<?php if ( $comment->comment_approved == '0' ) : ?>
			<div class="comment-body"><em><?php _e( 'Your comment is awaiting moderation.', 'meanthemes' ); ?></em></div>
		<?php endif; ?>

		<div class="comment-body">
			<p><?php comment_author_link(); ?>
			<a class="comment-date" href="<?php echo esc_url( get_comment_link( $comment->comment_ID ) ); ?>">
				<?php comment_date(); _e(' at ','meanthemes'); comment_time(); ?></a><?php edit_comment_link( __( '(Edit)', 'meanthemes' ), ' ' ); ?></p>
			<div class="comment-text"><?php comment_text(); ?></div>

		<div class="comment-reply">
			<?php comment_reply_link( array_merge( $args, array( 'depth' => $depth, 'max_depth' => $args['max_depth'] ) ) ); ?>
		</div>
		</div>
	</div>
	<?php
	break;
case 'pingback'  :
case 'trackback' :
?>

	<li class="post pingback">
		<p><?php _e( 'Pingback:','meanthemes' ); ?> <?php comment_author_link(); ?><?php edit_comment_link( __( '(Edit)', 'meanthemes' ), ' ' ); ?></p>
	<?php

	break;
	endswitch;
}

/* #######################################################################

	Add page type to <body> class

####################################################################### */

function page_bodyclass() {
	global $wp_query;
	$page = '';
	$page = $wp_query->query_vars["pagename"];
	echo $page;
}

/* #######################################################################

	Control size of excerpts

####################################################################### */


function custom_excerpt_length( $length ) {

	// Get Excerpt length from theme options
	$excerptLength = get_theme_mod( 'auto_excerpt_length');

	if ( !$excerptLength ) {

		$excerptLength = 40;

	}

	return $excerptLength;
}
add_filter( 'excerpt_length', 'custom_excerpt_length', 999 );

/* #######################################################################

	Pagination, thanks for Kriesi (http://www.kriesi.at/archives/how-to-build-a-wordpress-post-pagination-without-plugin)

####################################################################### */

function meanthemes_pagination($pages = '', $range = 2)
{
     $showitems = ($range * 2)+1;

     global $paged;
     if(empty($paged)) $paged = 1;

     if($pages == '')
     {
         global $wp_query;
         $pages = $wp_query->max_num_pages;
         if(!$pages)
         {
             $pages = 1;
         }
     }

     if(1 != $pages)
     {
         echo "<nav class='pagination'><ul>";
         if($paged > 2 && $paged > $range+1 && $showitems < $pages) echo "<li><a href='".get_pagenum_link(1)."'>&laquo;</a></li>";
         if($paged > 1 && $showitems < $pages) echo "<li><a href='".get_pagenum_link($paged - 1)."'>&lsaquo;</a></li>";

         for ($i=1; $i <= $pages; $i++)
         {
             if (1 != $pages &&( !($i >= $paged+$range+1 || $i <= $paged-$range-1) || $pages <= $showitems ))
             {
                 echo ($paged == $i)? "<li><span class='current'>".$i."</span></li>":"<li><a href='".get_pagenum_link($i)."' class='inactive' >".$i."</a></li>";
             }
         }

         if ($paged < $pages && $showitems < $pages) echo "<li><a href='".get_pagenum_link($paged + 1)."'>&rsaquo;</a></li>";
         if ($paged < $pages-1 &&  $paged+$range-1 < $pages && $showitems < $pages) echo "<li><a href='".get_pagenum_link($pages)."'>&raquo;</a></li>";
         echo "</ul></nav>\n";
     }
}




/* #######################################################################

	Get attachment data

####################################################################### */

add_filter('wp_get_attachment_image_attributes','get_captions', 10, 2);

function get_captions($attr, $attachment){
	$attr['title'] = trim(strip_tags( $attachment->post_excerpt ));
	return $attr;
}


/* #######################################################################

	Envoke Colour Picker JS & CSS

####################################################################### */

add_action( 'admin_enqueue_scripts', 'mt_enqueue_color_picker' );
function mt_enqueue_color_picker( $hook_suffix ) {
    wp_enqueue_style( 'wp-color-picker' );
    wp_enqueue_script( 'mt-colorpicker', get_template_directory_uri().'/framework/js/mt-colorpicker.js', array( 'wp-color-picker' ), false, true );
}


/* #######################################################################

	Include thumbnail + custom meta in RSS feed

####################################################################### */

function add_thumb_to_RSS($content) {
	global $post;
	$meta = "";
	if ( has_post_thumbnail( $post->ID ) ){
	$content = '<div>' . get_the_post_thumbnail( $post->ID, 'rss-thumb' ) . '</div>' . $content;
	}
	if ( get_post_meta($post->ID, 'single_format_audio', true) ) {
	$meta = '<p><strong>' . __('Audio Link: ', 'meanthemes'). '</strong><p>' . get_post_meta($post->ID, 'single_format_audio', true) . '</p><p>';
	}
	if ( get_post_meta($post->ID, 'single_format_video', true) ) {
	$meta = '<p><strong>' . __('Video Post: ', 'meanthemes') . '</strong>' . get_post_meta($post->ID, 'single_format_video', true) . '</p>';
	}
	if ( get_post_meta($post->ID, 'single_format_link_url', true) ) {
	$meta = '<p><strong>' . __('Link Post: ', 'meanthemes') . '</strong>' . get_post_meta($post->ID, 'single_format_link_url', true) . '</p><p>';
	}
	if ( get_post_meta($post->ID, 'single_format_quote', true) ) {
	$meta = '<p><strong>' . __('Quote Source: ', 'meanthemes') . '</strong>' . get_post_meta($post->ID, 'single_format_quote', true) . '</p>';
	}
	return $content . $meta;
}
add_filter('the_excerpt_rss', 'add_thumb_to_RSS');
add_filter('the_content_feed', 'add_thumb_to_RSS');

?>
