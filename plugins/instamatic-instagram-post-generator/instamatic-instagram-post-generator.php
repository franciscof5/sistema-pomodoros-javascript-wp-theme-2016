<?php
/** 
Plugin Name: iMediamatic Automatic Post Generator
Plugin URI: //1.envato.market/coderevolution
Description: This plugin will generate content for you, even in your sleep using Instagram public group feeds.
Author: CodeRevolution
Version: 1.8.8
Author URI: //coderevolution.ro
License: Commercial. For personal use only. Not to give away or resell.
Text Domain: instagram-post-generator
*/
/*  
Copyright 2016 - 2022 CodeRevolution
*/
defined('ABSPATH') or die();
require_once (dirname(__FILE__) . "/res/other/plugin-dash.php"); 


function instamatic_load_textdomain() {
    load_plugin_textdomain( 'instagram-post-generator', false, basename( dirname( __FILE__ ) ) . '/languages' ); 
}
add_action( 'init', 'instamatic_load_textdomain' );

function instamatic_get_random_user_agent() {
	$agents = array(
		"Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/60.0.3112.113 Safari/537.36",
		"Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/60.0.3112.101 Safari/537.36",
		"Mozilla/5.0 (Windows NT 6.1; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/60.0.3112.113 Safari/537.36",
		"Mozilla/5.0 (Macintosh; Intel Mac OS X 10_12_6) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/60.0.3112.113 Safari/537.36",
		"Mozilla/5.0 (Macintosh; Intel Mac OS X 10_12_6) AppleWebKit/603.3.8 (KHTML, like Gecko) Version/10.1.2 Safari/603.3.8",
		"Mozilla/5.0 (Windows NT 6.1; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/60.0.3112.101 Safari/537.36",
		"Mozilla/5.0 (Macintosh; Intel Mac OS X 10_12_6) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/60.0.3112.101 Safari/537.36",
		"Mozilla/5.0 (Windows NT 10.0; WOW64; rv:55.0) Gecko/20100101 Firefox/55.0",
		"Mozilla/5.0 (X11; Ubuntu; Linux x86_64; rv:55.0) Gecko/20100101 Firefox/55.0",
		"Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/60.0.3112.90 Safari/537.36",
		"Mozilla/5.0 (Windows NT 6.1; WOW64; Trident/7.0; rv:11.0) like Gecko",
		"Mozilla/5.0 (Windows NT 6.1; WOW64; rv:55.0) Gecko/20100101 Firefox/55.0",
		"Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:55.0) Gecko/20100101 Firefox/55.0",
		"Mozilla/5.0 (Windows NT 6.3; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/60.0.3112.113 Safari/537.36",
		"Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/52.0.2743.116 Safari/537.36 Edge/15.15063",
		"Mozilla/5.0 (Macintosh; Intel Mac OS X 10.12; rv:55.0) Gecko/20100101 Firefox/55.0",
		"Mozilla/5.0 (Windows NT 10.0; WOW64; rv:54.0) Gecko/20100101 Firefox/54.0",
		"Mozilla/5.0 (Macintosh; Intel Mac OS X 10_11_6) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/60.0.3112.113 Safari/537.36",
		"Mozilla/5.0 (Windows NT 6.1) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/60.0.3112.113 Safari/537.36",
		"Mozilla/5.0 (Macintosh; Intel Mac OS X 10_11_6) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/60.0.3112.101 Safari/537.36"
	);
	$rand   = rand( 0, count( $agents ) - 1 );
	return trim( $agents[ $rand ] );
}
function instamatic_assign_var(&$target, $var, $root = false) {
	static $cnt = 0;
    $key = key($var);
    if(is_array($var[$key])) 
        instamatic_assign_var($target[$key], $var[$key], false);
    else {
        if($key==0)
		{
			if($cnt == 0 && $root == true)
			{
				$target['_instamaticr_nonce'] = $var[$key];
				$cnt++;
			}
			elseif($cnt == 1 && $root == true)
			{
				$target['_wp_http_referer'] = $var[$key];
				$cnt++;
			}
			else
			{
				$target[] = $var[$key];
			}
		}
        else
		{
            $target[$key] = $var[$key];
		}
    }   
}

function instamatic_preg_grep_keys( $pattern, $input, $flags = 0 )
{
    if(!is_array($input))
    {
        return array();
    }
    $keys = preg_grep( $pattern, array_keys( $input ), $flags );
    $vals = array();
    foreach ( $keys as $key )
    {
        $vals[$key] = $input[$key];
    }
    return $vals;
}

function instamatic_replace_attachment_url($att_url, $att_id) {
    {
         $post_id = get_the_ID();
         wp_suspend_cache_addition(true);
         $metas = get_post_custom($post_id);
         wp_suspend_cache_addition(false);
         $rez_meta = instamatic_preg_grep_keys('#.+?_featured_img#i', $metas);
         if(count($rez_meta) > 0)
         {
             foreach($rez_meta as $rm)
             {
                 if(isset($rm[0]) && $rm[0] != '' && filter_var($rm[0], FILTER_VALIDATE_URL))
                 {
                    return $rm[0];
                 }
             }
         }
    }
    return $att_url;
}


function instamatic_replace_attachment_image_src($image, $att_id, $size) {
    {
        $post_id = get_the_ID();
        wp_suspend_cache_addition(true);
        $metas = get_post_custom($post_id);
        wp_suspend_cache_addition(false);
        $rez_meta = instamatic_preg_grep_keys('#.+?_featured_img#i', $metas);
        if(count($rez_meta) > 0)
        {
            foreach($rez_meta as $rm)
            {
                if(isset($rm[0]) && $rm[0] != '' && filter_var($rm[0], FILTER_VALIDATE_URL))
                {
                    return array($rm[0], 0, 0, false);
                }
            }
        }
     }
     return $image;
}

function instamatic_thumbnail_external_replace( $html, $post_id, $thumb_id ) {
    
    wp_suspend_cache_addition(true);
    $metas = get_post_custom($post_id);
    wp_suspend_cache_addition(false);
    $rez_meta = instamatic_preg_grep_keys('#.+?_featured_img#i', $metas);
    if(count($rez_meta) > 0)
    {
        foreach($rez_meta as $rm)
        {
            if(isset($rm[0]) && $rm[0] != '' && filter_var($rm[0], FILTER_VALIDATE_URL))
            {
                $alt = get_post_field( 'post_title', $post_id ) . ' ' .  esc_html__( 'thumbnail', 'instagram-post-generator' );
                $attr = array( 'alt' => $alt );
                $attx = get_post($thumb_id);
                $attr = apply_filters( 'wp_get_attachment_image_attributes', $attr, $attx , 'thumbnail');
                $attr = array_map( 'esc_attr', $attr );
                $html = sprintf( '<img src="%s"', esc_url($rm[0]) );
                foreach ( $attr as $name => $value ) {
                    $html .= " " . esc_html($name) . "=" . '"' . esc_attr($value) . '"';
                }
                $html .= ' />';
                return $html;
            }
        }
    }
    return $html;
}

$plugin = plugin_basename(__FILE__);
if(is_admin())
{
    if($_SERVER["REQUEST_METHOD"]==="POST" && !empty($_POST["coderevolution_max_input_var_data"])) {
        $vars = explode("&", $_POST["coderevolution_max_input_var_data"]);
        $coderevolution_max_input_var_data = array();
        foreach($vars as $var) {
            parse_str($var, $variable);
            instamatic_assign_var($_POST, $variable, true);
        }
    	unset($_POST["coderevolution_max_input_var_data"]);
    }
    $plugin_slug = explode('/', $plugin);
    $plugin_slug = $plugin_slug[0];
    if(isset($_POST[$plugin_slug . '_register']) && isset($_POST[$plugin_slug. '_register_code']) && trim($_POST[$plugin_slug . '_register_code']) != '')
    {
        $uoptions = array();
        $uoptions['item_id'] = 19648561;
        $uoptions['item_name'] = 'iMediamatic - Social Media Importer/Exporter Plugin for WordPress';
        $uoptions['created_at'] = '24.12.1974';
        $uoptions['buyer'] = 'Tom & Jerry';
        $uoptions['licence'] = 'extended';
        $uoptions['supported_until'] = '24.12.2038';
        update_option($plugin_slug . '_registration', $uoptions);
        update_option('coderevolution_settings_changed', 2);
    }
    require "update-checker/plugin-update-checker.php";
    $fwdu3dcarPUC = Puc_v4_Factory::buildUpdateChecker("https://wpinitiate.com/auto-update/?action=get_metadata&slug=instamatic-instagram-post-generator", __FILE__, "instamatic-instagram-post-generator");
}
function instamatic_admin_enqueue_all()
{
    $reg_css_code = '.cr_auto_update{background-color:#fff8e5;margin:5px 20px 15px 20px;border-left:4px solid #fff;padding:12px 12px 12px 12px !important;border-left-color:#ffb900;}';
    wp_register_style( 'instamatic-plugin-reg-style', false );
    wp_enqueue_style( 'instamatic-plugin-reg-style' );
    wp_add_inline_style( 'instamatic-plugin-reg-style', $reg_css_code );
}
function instamatic_add_activation_link($links)
{
    $settings_link = '<a href="admin.php?page=instamatic_admin_settings">' . esc_html__('Activate Plugin License', 'instamatic-instagram-post-generator') . '</a>';
    array_push($links, $settings_link);
    return $links;
}

use \Eventviva\ImageResize;
$instamatic_Main_Settings = get_option('instamatic_Main_Settings', false);
if (isset($instamatic_Main_Settings['app_encrypt']) && $instamatic_Main_Settings['app_encrypt'] == 'yes') {
    if (isset($instamatic_Main_Settings['app_secret']) && $instamatic_Main_Settings['app_secret'] !== '') {
        $instamatic_Main_Settings['app_secret'] = instamatic_encrypt_decrypt('encrypt', $instamatic_Main_Settings['app_secret']);
        $instamatic_Main_Settings['app_encrypt'] = 'no';
        update_option('instamatic_Main_Settings', $instamatic_Main_Settings, false);
    }
}
add_action('admin_menu', 'instamatic_register_my_custom_menu_page');
add_action('network_admin_menu', 'instamatic_register_my_custom_menu_page');
use InstagramScraper\Model\Media;
use phpFastCache\CacheManager;
function instamatic_register_my_custom_menu_page()
{
    add_menu_page('iMediamatic Post Generator', 'iMediamatic Post Generator', 'manage_options', 'instamatic_admin_settings', 'instamatic_admin_settings', plugins_url('images/icon.png', __FILE__));
    $main = add_submenu_page('instamatic_admin_settings', esc_html__("Main Settings", 'instamatic-instagram-post-generator'), esc_html__("Main Settings", 'instamatic-instagram-post-generator'), 'manage_options', 'instamatic_admin_settings');
    add_action( 'load-' . $main, 'instamatic_load_all_admin_js' );
    add_action( 'load-' . $main, 'instamatic_load_main_admin_js' );
    $instamatic_Main_Settings = get_option('instamatic_Main_Settings', false);
    if (isset($instamatic_Main_Settings['instamatic_enabled']) && $instamatic_Main_Settings['instamatic_enabled'] == 'on') {
        $inst = add_submenu_page('instamatic_admin_settings', esc_html__('Instagram to Posts', 'instamatic-instagram-post-generator'), esc_html__('Instagram to Posts', 'instamatic-instagram-post-generator'), 'manage_options', 'instamatic_items_panel', 'instamatic_items_panel');
        add_action( 'load-' . $inst, 'instamatic_load_admin_js' );
        add_action( 'load-' . $inst, 'instamatic_load_all_admin_js' );
        $post = add_submenu_page('instamatic_admin_settings', esc_html__('Posts to Instagram', 'instamatic-instagram-post-generator'), esc_html__('Posts to Instagram', 'instamatic-instagram-post-generator'), 'manage_options', 'instamatic_Instagram_panel', 'instamatic_Instagram_panel');
        add_action( 'load-' . $post, 'instamatic_load_post_admin_js' );
        add_action( 'load-' . $post, 'instamatic_load_all_admin_js' );
        $logs = add_submenu_page('instamatic_admin_settings', esc_html__("Activity & Logging", 'instamatic-instagram-post-generator'), esc_html__("Activity & Logging", 'instamatic-instagram-post-generator'), 'manage_options', 'instamatic_logs', 'instamatic_logs');
        add_action( 'load-' . $logs, 'instamatic_load_all_admin_js' );
    }
}
function instamatic_load_post_admin_js(){
    add_action('admin_enqueue_scripts', 'instamatic_admin_load_post_files');
}

function instamatic_admin_load_post_files()
{
    wp_register_script('instamatic-submitter-script', plugins_url('scripts/poster.js', __FILE__), false, '1.0.0');
    wp_enqueue_script('instamatic-submitter-script');
}
function instamatic_load_admin_js(){
    add_action('admin_enqueue_scripts', 'instamatic_enqueue_admin_js');
}

function instamatic_enqueue_admin_js(){
    wp_enqueue_script('instamatic-footer-script', plugins_url('scripts/footer.js', __FILE__), array('jquery'), false, true);
    $cr_miv = ini_get('max_input_vars');
	if($cr_miv === null || $cr_miv === false || !is_numeric($cr_miv))
	{
        $cr_miv = '9999999';
    }
    $footer_conf_settings = array(
        'max_input_vars' => $cr_miv,
        'plugin_dir_url' => plugin_dir_url(__FILE__),
        'ajaxurl' => admin_url('admin-ajax.php')
    );
    wp_localize_script('instamatic-footer-script', 'mycustomsettings', $footer_conf_settings);
    wp_register_style('instamatic-rules-style', plugins_url('styles/instamatic-rules.css', __FILE__), false, '1.0.0');
    wp_enqueue_style('instamatic-rules-style');
}
function instamatic_load_main_admin_js(){
    add_action('admin_enqueue_scripts', 'instamatic_enqueue_main_admin_js');
}

function instamatic_enqueue_main_admin_js(){
    $instamatic_Main_Settings = get_option('instamatic_Main_Settings', false);
    wp_enqueue_script('instamatic-main-script', plugins_url('scripts/main.js', __FILE__), array('jquery'));
    if(!isset($instamatic_Main_Settings['best_user']))
    {
        $best_user = '';
    }
    else
    {
        $best_user = $instamatic_Main_Settings['best_user'];
    }
    if(!isset($instamatic_Main_Settings['best_password']))
    {
        $best_password = '';
    }
    else
    {
        $best_password = $instamatic_Main_Settings['best_password'];
    }
    $header_main_settings = array(
        'best_user' => $best_user,
        'best_password' => $best_password
    );
    wp_localize_script('instamatic-main-script', 'mycustommainsettings', $header_main_settings);
}
function instamatic_load_all_admin_js(){
    add_action('admin_enqueue_scripts', 'instamatic_admin_load_files');
}
function instamaticadd_rating_link($links)
{
    $settings_link = '<a href="//codecanyon.net/downloads" target="_blank" title="Rate">
            <i class="wdi-rate-stars"><svg xmlns="http://www.w3.org/2000/svg" width="15" height="15" viewBox="0 0 24 24" fill="#ffb900" stroke="#ffb900" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-star"><polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"></polygon></svg><svg xmlns="http://www.w3.org/2000/svg" width="15" height="15" viewBox="0 0 24 24" fill="#ffb900" stroke="#ffb900" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-star"><polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"></polygon></svg><svg xmlns="http://www.w3.org/2000/svg" width="15" height="15" viewBox="0 0 24 24" fill="#ffb900" stroke="#ffb900" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-star"><polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"></polygon></svg><svg xmlns="http://www.w3.org/2000/svg" width="15" height="15" viewBox="0 0 24 24" fill="#ffb900" stroke="#ffb900" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-star"><polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"></polygon></svg><svg xmlns="http://www.w3.org/2000/svg" width="15" height="15" viewBox="0 0 24 24" fill="#ffb900" stroke="#ffb900" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-star"><polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"></polygon></svg></i></a>';
    array_push($links, $settings_link);
    return $links;
}
add_filter("plugin_action_links_$plugin", 'instamatic_add_support_link');
function instamatic_add_support_link($links)
{
    $settings_link = '<a href="//coderevolution.ro/knowledge-base/" target="_blank">' . esc_html__('Support', 'instamatic-instagram-post-generator') . '</a>';
    array_push($links, $settings_link);
    return $links;
}
add_filter("plugin_action_links_$plugin", 'instamatic_add_settings_link');
add_filter("plugin_action_links_$plugin", 'instamaticadd_rating_link');
function instamatic_add_settings_link($links)
{
    $settings_link = '<a href="admin.php?page=instamatic_admin_settings">' . esc_html__('Settings', 'instamatic-instagram-post-generator') . '</a>';
    array_push($links, $settings_link);
    return $links;
}
add_action('add_meta_boxes', 'instamatic_add_meta_box');
function instamatic_add_meta_box()
{
    $instamatic_Main_Settings = get_option('instamatic_Main_Settings', false);
    if (isset($instamatic_Main_Settings['instamatic_enabled']) && $instamatic_Main_Settings['instamatic_enabled'] === 'on') {
        if (isset($instamatic_Main_Settings['enable_metabox']) && $instamatic_Main_Settings['enable_metabox'] == 'on') {
            foreach ( get_post_types( '', 'names' ) as $post_type ) {
               add_meta_box('instamatic_meta_box_function_add', esc_html__('iMediamatic Automatic Post Generator Information', 'instamatic-instagram-post-generator'), 'instamatic_meta_box_function', $post_type, 'advanced', 'default', array('__back_compat_meta_box' => true));
            }
            
        }
    }
}

add_filter('cron_schedules', 'instamatic_add_cron_schedule');
function instamatic_add_cron_schedule($schedules)
{
    $schedules['instamatic_cron'] = array(
        'interval' => 3600,
        'display' => esc_html__('iMediamatic Cron', 'instamatic-instagram-post-generator')
    );
    $schedules['minutely'] = array(
        'interval' => 60,
        'display' => esc_html__('Once A Minute', 'instamatic-instagram-post-generator')
    );
    $schedules['weekly']        = array(
        'interval' => 604800,
        'display' => esc_html__('Once Weekly', 'instamatic-instagram-post-generator')
    );
    $schedules['monthly']       = array(
        'interval' => 2592000,
        'display' => esc_html__('Once Monthly', 'instamatic-instagram-post-generator')
    );
    return $schedules;
}
function instamatic_auto_clear_log()
{
    global $wp_filesystem;
    if ( ! is_a( $wp_filesystem, 'WP_Filesystem_Base') ){
        include_once(ABSPATH . 'wp-admin/includes/file.php');$creds = request_filesystem_credentials( site_url() );
       wp_filesystem($creds);
    }
    if ($wp_filesystem->exists(WP_CONTENT_DIR . '/instamatic_info.log')) {
        $wp_filesystem->delete(WP_CONTENT_DIR . '/instamatic_info.log');
    }
}
function instamatic_isSecure() {
  return
    (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off')
    || $_SERVER['SERVER_PORT'] == 443;
}
register_deactivation_hook(__FILE__, 'instamatic_my_deactivation');
function instamatic_my_deactivation()
{
    wp_clear_scheduled_hook('instamaticaction');
    wp_clear_scheduled_hook('instamaticactionclear');
    $running = array();
    update_option('instamatic_running_list', $running, false);
}
add_action('instamaticaction', 'instamatic_cron');
add_action('instamaticactionclear', 'instamatic_auto_clear_log');

function instamatic_cron_schedule()
{
    $instamatic_Main_Settings = get_option('instamatic_Main_Settings', false);
    if (isset($instamatic_Main_Settings['instamatic_enabled']) && $instamatic_Main_Settings['instamatic_enabled'] === 'on') {
        if (!wp_next_scheduled('instamaticaction')) {
            $unlocker = get_option('instamatic_minute_running_unlocked', false);
            if($unlocker == '1')
            {
                $rez = wp_schedule_event(time(), 'minutely', 'instamaticaction');
            }
            else
            {
                $rez = wp_schedule_event(time(), 'hourly', 'instamaticaction');
            }
            if ($rez === FALSE) {
                instamatic_log_to_file('[Scheduler] Failed to schedule instamaticaction to instamatic_cron!');
            }
        }
        
        if (isset($instamatic_Main_Settings['enable_logging']) && $instamatic_Main_Settings['enable_logging'] === 'on' && isset($instamatic_Main_Settings['auto_clear_logs']) && $instamatic_Main_Settings['auto_clear_logs'] !== 'No') {
            if (!wp_next_scheduled('instamaticactionclear')) {
                $rez = wp_schedule_event(time(), $instamatic_Main_Settings['auto_clear_logs'], 'instamaticactionclear');
                if ($rez === FALSE) {
                    instamatic_log_to_file('[Scheduler] Failed to schedule instamaticactionclear to ' . $instamatic_Main_Settings['auto_clear_logs'] . '!');
                }
                add_option('instamatic_schedule_time', $instamatic_Main_Settings['auto_clear_logs']);
            } else {
                if (!get_option('instamatic_schedule_time')) {
                    wp_clear_scheduled_hook('instamaticactionclear');
                    $rez = wp_schedule_event(time(), $instamatic_Main_Settings['auto_clear_logs'], 'instamaticactionclear');
                    add_option('instamatic_schedule_time', $instamatic_Main_Settings['auto_clear_logs']);
                    if ($rez === FALSE) {
                        instamatic_log_to_file('[Scheduler] Failed to schedule instamaticactionclear to ' . $instamatic_Main_Settings['auto_clear_logs'] . '!');
                    }
                } else {
                    $the_time = get_option('instamatic_schedule_time');
                    if ($the_time != $instamatic_Main_Settings['auto_clear_logs']) {
                        wp_clear_scheduled_hook('instamaticactionclear');
                        delete_option('instamatic_schedule_time');
                        $rez = wp_schedule_event(time(), $instamatic_Main_Settings['auto_clear_logs'], 'instamaticactionclear');
                        add_option('instamatic_schedule_time', $instamatic_Main_Settings['auto_clear_logs']);
                        if ($rez === FALSE) {
                            instamatic_log_to_file('[Scheduler] Failed to schedule instamaticactionclear to ' . $instamatic_Main_Settings['auto_clear_logs'] . '!');
                        }
                    }
                }
            }
        } else {
            if (!wp_next_scheduled('instamaticactionclear')) {
                delete_option('instamatic_schedule_time');
            } else {
                wp_clear_scheduled_hook('instamaticactionclear');
                delete_option('instamatic_schedule_time');
            }
        }
    } else {
        if (wp_next_scheduled('instamaticaction')) {
            wp_clear_scheduled_hook('instamaticaction');
        }
        
        if (!wp_next_scheduled('instamaticactionclear')) {
            delete_option('instamatic_schedule_time');
        } else {
            wp_clear_scheduled_hook('instamaticactionclear');
            delete_option('instamatic_schedule_time');
        }
    }
}
function instamatic_cron()
{
    //instamatic_log_to_file('!!Starting cron checking for rules!');
    $GLOBALS['wp_object_cache']->delete('instamatic_rules_list', 'options');
    if (!get_option('instamatic_rules_list')) {
        $rules = array();
    } else {
        $rules = get_option('instamatic_rules_list');
    }
    if (!empty($rules)) {
        $instamatic_Main_Settings = get_option('instamatic_Main_Settings', false);
        $cont = 0;
        $rule_run = false;
        $unlocker = get_option('instamatic_minute_running_unlocked', false);
        foreach ($rules as $request => $bundle[]) {
            $bundle_values   = array_values($bundle);
            $myValues        = $bundle_values[$cont];
            $array_my_values = array_values($myValues);for($iji=0;$iji<count($array_my_values);++$iji){if(is_string($array_my_values[$iji])){$array_my_values[$iji]=stripslashes($array_my_values[$iji]);}}
            $schedule        = isset($array_my_values[1]) ? $array_my_values[1] : '24';
            $active          = isset($array_my_values[2]) ? $array_my_values[2] : '0';
            $last_run        = isset($array_my_values[3]) ? $array_my_values[3] : instamatic_get_date_now();
            if ($active == '1') {
                $now                = instamatic_get_date_now();
                if($unlocker == '1')
                {
                    $nextrun        = instamatic_add_minute($last_run, $schedule);
                    $instamatic_hour_diff = (int) instamatic_minute_diff($now, $nextrun);
                }
                else
                {
                    $nextrun        = instamatic_add_hour($last_run, $schedule);
                    $instamatic_hour_diff = (int) instamatic_hour_diff($now, $nextrun);
                }
                if ($instamatic_hour_diff >= 0) {
                    if($rule_run === false)
                    {
                        $rule_run = true;
                    }
                    else
                    {
                        //instamatic_log_to_file('!!Before sleep ' . $instamatic_Main_Settings['rule_delay'] . 's');
                        if (isset($instamatic_Main_Settings['rule_delay']) && $instamatic_Main_Settings['rule_delay'] !== '')
                        {
                            sleep($instamatic_Main_Settings['rule_delay']);
                        }
                        //instamatic_log_to_file('!!After sleep ' . $instamatic_Main_Settings['rule_delay'] . 's');
                    }
                    //instamatic_log_to_file('!!Running rule ' . $cont);
                    instamatic_run_rule($cont);
                    //instamatic_log_to_file('!!Finished running rule ' . $cont);
                }
            }
            $cont = $cont + 1;
        }
    }
    $running = array();
    update_option('instamatic_running_list', $running);
}

function instamatic_extractKeyWords($string, $count = 10)
{
    $stopwords = array();
    $string = trim(preg_replace('/\s\s+/iu', '\s', strtolower($string)));
    $string = wp_strip_all_tags($string);
    $matchWords   = array_filter(explode(' ', $string), function($item) use ($stopwords)
    {
        return !($item == '' || in_array($item, $stopwords) || strlen($item) <= 2 || ctype_alnum(trim(str_replace(' ', '', $item))) === FALSE || is_numeric($item));
    });
    $wordCountArr = array_count_values($matchWords);
    arsort($wordCountArr);
    return array_keys(array_slice($wordCountArr, 0, $count));
}

function instamatic_log_to_file($str)
{
    $instamatic_Main_Settings = get_option('instamatic_Main_Settings', false);
    if (isset($instamatic_Main_Settings['enable_logging']) && $instamatic_Main_Settings['enable_logging'] == 'on') {
        $d = date("j-M-Y H:i:s e", current_time( 'timestamp' ));
        error_log("[$d] " . $str . "<br/>\r\n", 3, WP_CONTENT_DIR . '/instamatic_info.log');
    }
}
function instamatic_delete_all_posts()
{
    $failed                 = false;
    $number                 = 0;
    $instamatic_Main_Settings = get_option('instamatic_Main_Settings', false);
    $post_list = array();
    $postsPerPage = 50000;
    $paged = 0;
    do
    {
        $postOffset = $paged * $postsPerPage;
        $query = array(
            'post_status' => array(
                'publish',
                'draft',
                'pending',
                'trash',
                'private',
                'future'
            ),
            'post_type' => array(
                'any'
            ),
            'numberposts' => $postsPerPage,
            'meta_key' => 'instamatic_parent_rule',
            'fields' => 'ids',
            'offset'  => $postOffset
        );
        $got_me = get_posts($query);
        $post_list = array_merge($post_list, $got_me);
        $paged++;
    }while(!empty($got_me));
    wp_suspend_cache_addition(true);
    foreach ($post_list as $post) {
        $index = get_post_meta($post, 'instamatic_parent_rule', true);
        if (isset($index) && $index !== '') {
            $args             = array(
                'post_parent' => $post
            );
            $post_attachments = get_children($args);
            if (isset($post_attachments) && !empty($post_attachments)) {
                foreach ($post_attachments as $attachment) {
                    wp_delete_attachment($attachment->ID, true);
                }
            }
            $res = wp_delete_post($post, true);
            if ($res === false) {
                $failed = true;
            } else {
                $number++;
            }
        }
    }
    wp_suspend_cache_addition(false);
    if ($failed === true) {
        if (isset($instamatic_Main_Settings['enable_detailed_logging'])) {
            instamatic_log_to_file('[PostDelete] Failed to delete all posts!');
        }
    } else {
        if (isset($instamatic_Main_Settings['enable_detailed_logging'])) {
            instamatic_log_to_file('[PostDelete] Successfuly deleted ' . esc_html($number) . ' posts!');
        }
    }
}

function instamatic_replaceContentShortcodesAgain($the_content, $item_cat, $item_tags)
{
    $the_content = str_replace('%%item_cat%%', $item_cat, $the_content);
    $the_content = str_replace('%%item_tags%%', $item_tags, $the_content);
    return $the_content;
}
function instamatic_replaceContentShortcodes($the_content, $just_title, $content, $item_url, $item_image, $description, $author, $author_link, $post_video, $likesCount, $locationId, $locationName, $commentsCount, $item_all_media, $screenimageURL, $ownerId)
{
    $matches = array();
    $i = 0;
    preg_match_all('~%regex\(\s*\"([^"]+?)\s*"\s*[,;]\s*\"([^"]*)\"\s*(?:[,;]\s*\"([^"]*?)\s*\")?(?:[,;]\s*\"([^"]*?)\s*\")?(?:[,;]\s*\"([^"]*?)\s*\")?\)%~si', $the_content, $matches);
    if (is_array($matches) && count($matches) && is_array($matches[0])) {
        for($i = 0; $i < count($matches[0]); $i++)
        {
            if (isset($matches[0][$i])) $fullmatch = $matches[0][$i];
            if (isset($matches[1][$i])) $search_in = instamatic_replaceContentShortcodes($matches[1][$i], $just_title, $content, $item_url, $item_image, $description, $author, $author_link, $post_video, $likesCount, $locationId, $locationName, $commentsCount, $item_all_media, $screenimageURL, $ownerId);
            if (isset($matches[2][$i])) $matchpattern = $matches[2][$i];
            if (isset($matches[3][$i])) $element = $matches[3][$i];
            if (isset($matches[4][$i])) $delimeter = $matches[4][$i];if (isset($matches[5][$i])) $counter = $matches[5][$i];
            if (isset($matchpattern)) {
               if (preg_match('<^[\/#%+~[\]{}][\s\S]*[\/#%+~[\]{}]$>', $matchpattern, $z)) {
                  $ret = preg_match_all($matchpattern, $search_in, $submatches, PREG_PATTERN_ORDER);
               }
               else {
                  $ret = preg_match_all('~'.$matchpattern.'~si', $search_in, $submatches, PREG_PATTERN_ORDER);
               }
            }
            if (isset($submatches)) {
               if (is_array($submatches)) {
                  $empty_elements = array_keys($submatches[0], "");
                  foreach ($empty_elements as $e) {
                     unset($submatches[0][$e]);
                  }
                  $submatches[0] = array_unique($submatches[0]);
                  if (!is_numeric($element)) {
                     $element = 0;
                  }if (!is_numeric($counter)) {
                     $counter = 0;
                  }
                  if(isset($submatches[(int)($element)]))
                  {
                      $matched = $submatches[(int)($element)];
                  }
                  else
                  {
                      $matched = '';
                  }
                  $matched = array_unique((array)$matched);
                  if (empty($delimeter) || $delimeter == 'null') {
                     if (isset($matched[$counter])) $matched = $matched[$counter];
                  }
                  else {
                     $matched = implode($delimeter, $matched);
                  }
                  if (empty($matched)) {
                     $the_content = str_replace($fullmatch, '', $the_content);
                  } else {
                     $the_content = str_replace($fullmatch, $matched, $the_content);
                  }
               }
            }
        }
    }
    $spintax = new Instamatic_Spintax();
    $the_content = $spintax->process($the_content);
    $pcxxx = explode('<!- template ->', $the_content);
    $the_content = $pcxxx[array_rand($pcxxx)];
    $the_content = str_replace('%%random_sentence%%', instamatic_random_sentence_generator(), $the_content);
    $the_content = str_replace('%%random_sentence2%%', instamatic_random_sentence_generator(false), $the_content);
    $the_content = instamatic_replaceSynergyShortcodes($the_content);
    $instamatic_Main_Settings = get_option('instamatic_Main_Settings', false);
    if (isset($instamatic_Main_Settings['custom_html'])) {
        $the_content = str_replace('%%custom_html%%', $instamatic_Main_Settings['custom_html'], $the_content);
    }
    if (isset($instamatic_Main_Settings['custom_html2'])) {
        $the_content = str_replace('%%custom_html2%%', $instamatic_Main_Settings['custom_html2'], $the_content);
    }
    $the_content = str_replace('%%post_video_embed%%', instamatic_getItemVideo($item_url, $content, $author), $the_content);
    if($post_video != '')
    {
        $the_content = str_replace('%%post_media_embed%%', instamatic_getItemVideo($item_url, $content, $author), $the_content);
    }
    else
    {
        $the_content = str_replace('%%post_media_embed%%', instamatic_getItemImageInstagram($item_url, $content, $author), $the_content);
    }
    $all_embed = '';
    foreach($item_all_media as $iam)
    {
        if($iam[0] == '.')
        {
            $iam = ltrim($iam, '.');
            $all_embed .= instamatic_getItemImage($iam, $just_title);
        }
        else
        {
            $all_embed .= instamatic_getItemEmbedVideo($iam);
        }
    }
    $the_content = str_replace('%%author_username%%', $ownerId, $the_content);
    $the_content = str_replace('%%item_show_all_media%%', $all_embed, $the_content);
    $the_content = str_replace('%%post_image_embed%%', instamatic_getItemImageInstagram($item_url, $content, $author), $the_content);
    $the_content = str_replace('%%item_title%%', $just_title, $the_content);
    $the_content = str_replace('%%item_content%%', $content, $the_content);
    $the_content = str_replace('%%item_url%%', instamatic_url_handle($item_url), $the_content);
    $the_content = str_replace('%%item_content_plain_text%%', instamatic_getPlainContent($content), $the_content);
    $the_content = str_replace('%%item_read_more_button%%', instamatic_getReadMoreButton(instamatic_url_handle($item_url)), $the_content);
    $the_content = str_replace('%%item_show_image%%', instamatic_getItemImage($item_image, $just_title), $the_content);
    $the_content = str_replace('%%item_show_video%%', instamatic_getItemEmbedVideo($post_video), $the_content);
    if($post_video != '')
    {
        $the_content = str_replace('%%item_show_media%%', instamatic_getItemEmbedVideo($post_video), $the_content);
    }
    else
    {
        $the_content = str_replace('%%item_show_media%%', instamatic_getItemImage($item_image, $just_title), $the_content);
    }
    $the_content = str_replace('%%item_image_URL%%', $item_image, $the_content);
    $the_content = str_replace('%%item_description%%', $description, $the_content);
    $the_content = str_replace('%%likes_count%%', $likesCount, $the_content);
    $the_content = str_replace('%%location_id%%', $locationId, $the_content);
    $the_content = str_replace('%%location_name%%', $locationName, $the_content);
    $the_content = str_replace('%%comments_count%%', $commentsCount, $the_content);
    $the_content = str_replace('%%author%%', $author, $the_content);
    $the_content = str_replace('%%author_link%%', $author_link, $the_content);
    if($screenimageURL != '')
    {
        $the_content = str_replace('%%item_screenshot_url%%', esc_url($screenimageURL), $the_content);
        $the_content = str_replace('%%item_show_screenshot%%', instamatic_getItemImage(esc_url($screenimageURL), $just_title), $the_content);
    }
    else
    {
        $snap = 'http://s.wordpress.com/mshots/v1/';
        if (isset($instamatic_Main_Settings['screenshot_height']) && $instamatic_Main_Settings['screenshot_height'] != '') 
        {
            $h = esc_attr($instamatic_Main_Settings['screenshot_height']);
        }
        else
        {
            $h = '450';
        }
        if (isset($instamatic_Main_Settings['screenshot_width']) && $instamatic_Main_Settings['screenshot_width'] != '') 
        {
            $w = esc_attr($instamatic_Main_Settings['screenshot_width']);
        }
        else
        {
            $w = '600';
        }
        $the_content = str_replace('%%item_screenshot_url%%', esc_url($snap . urlencode($item_url) . '?w=' . $w . '&h=' . $h), $the_content);
        $the_content = str_replace('%%item_show_screenshot%%', instamatic_getItemImage(esc_url($snap . urlencode($item_url) . '?w=' . $w . '&h=' . $h), $just_title), $the_content);
    }
    return $the_content;
}
function instamatic_replaceTitleShortcodes($the_content, $just_title, $content, $item_url)
{
    $matches = array();
    $i = 0;
    preg_match_all('~%regex\(\s*\"([^"]+?)\s*"\s*[,;]\s*\"([^"]*)\"\s*(?:[,;]\s*\"([^"]*?)\s*\")?(?:[,;]\s*\"([^"]*?)\s*\")?(?:[,;]\s*\"([^"]*?)\s*\")?\)%~si', $the_content, $matches);
    if (is_array($matches) && count($matches) && is_array($matches[0])) {
        for($i = 0; $i < count($matches[0]); $i++)
        {
            if (isset($matches[0][$i])) $fullmatch = $matches[0][$i];
            if (isset($matches[1][$i])) $search_in = instamatic_replaceTitleShortcodes($matches[1][$i], $just_title, $content, $item_url);
            if (isset($matches[2][$i])) $matchpattern = $matches[2][$i];
            if (isset($matches[3][$i])) $element = $matches[3][$i];
            if (isset($matches[4][$i])) $delimeter = $matches[4][$i];if (isset($matches[5][$i])) $counter = $matches[5][$i];
            if (isset($matchpattern)) {
               if (preg_match('<^[\/#%+~[\]{}][\s\S]*[\/#%+~[\]{}]$>', $matchpattern, $z)) {
                  $ret = preg_match_all($matchpattern, $search_in, $submatches, PREG_PATTERN_ORDER);
               }
               else {
                  $ret = preg_match_all('~'.$matchpattern.'~si', $search_in, $submatches, PREG_PATTERN_ORDER);
               }
            }
            if (isset($submatches)) {
               if (is_array($submatches)) {
                  $empty_elements = array_keys($submatches[0], "");
                  foreach ($empty_elements as $e) {
                     unset($submatches[0][$e]);
                  }
                  $submatches[0] = array_unique($submatches[0]);
                  if (!is_numeric($element)) {
                     $element = 0;
                  }if (!is_numeric($counter)) {
                     $counter = 0;
                  }
                  if(isset($submatches[(int)($element)]))
                  {
                      $matched = $submatches[(int)($element)];
                  }
                  else
                  {
                      $matched = '';
                  }
                  $matched = array_unique((array)$matched);
                  if (empty($delimeter) || $delimeter == 'null') {
                     if (isset($matched[$counter])) $matched = $matched[$counter];
                  }
                  else {
                     $matched = implode($delimeter, $matched);
                  }
                  if (empty($matched)) {
                     $the_content = str_replace($fullmatch, '', $the_content);
                  } else {
                     $the_content = str_replace($fullmatch, $matched, $the_content);
                  }
               }
            }
        }
    }
    $spintax = new Instamatic_Spintax();
    $the_content = $spintax->process($the_content);
    $pcxxx = explode('<!- template ->', $the_content);
    $the_content = $pcxxx[array_rand($pcxxx)];
    $the_content = str_replace('%%random_sentence%%', instamatic_random_sentence_generator(), $the_content);
    $the_content = str_replace('%%random_sentence2%%', instamatic_random_sentence_generator(false), $the_content);
    $the_content = str_replace('%%item_title%%', $just_title, $the_content);
    $the_content = str_replace('%%item_description%%', $content, $the_content);
    $the_content = str_replace('%%item_url%%', instamatic_url_handle($item_url), $the_content);
    return $the_content;
}

function instamatic_replaceTitleShortcodesAgain($the_content, $item_cat, $item_tags)
{
    $the_content = str_replace('%%item_cat%%', $item_cat, $the_content);
    $the_content = str_replace('%%item_tags%%', $item_tags, $the_content);
    return $the_content;
}

add_action('wp_ajax_instamatic_my_action', 'instamatic_my_action_callback');
function instamatic_my_action_callback()
{
    $instamatic_Main_Settings = get_option('instamatic_Main_Settings', false);
    $failed                 = false;
    $del_id                 = $_POST['id'];
    $how                    = $_POST['how'];
    if($how == 'duplicate')
    {
        $GLOBALS['wp_object_cache']->delete('instamatic_rules_list', 'options');
        if (!get_option('instamatic_rules_list')) {
            $rules = array();
        } else {
            $rules = get_option('instamatic_rules_list');
        }
        if (!empty($rules)) {
            $found            = 0;
            $cont = 0;
            foreach ($rules as $request => $bundle[]) {
                if ($cont == $del_id) {
                    $copy_bundle = $rules[$request];
                    $rules[] = $copy_bundle;
                    $found   = 1;
                    break;
                }
                $cont = $cont + 1;
            }
            if($found == 0)
            {
                instamatic_log_to_file('instamatic_rules_list index not found: ' . $del_id);
                echo 'nochange';
                die();
            }
            else
            {
                update_option('instamatic_rules_list', $rules, false);
                echo 'ok';
                die();
            }
        } else {
            instamatic_log_to_file('instamatic_rules_list empty!');
            echo 'nochange';
            die();
        }
        
    }
    $force_delete           = true;
    $number                 = 0;
    if ($how == 'trash') {
        $force_delete = false;
    }
    $post_list = array();
    $postsPerPage = 50000;
    $paged = 0;
    do
    {
        $postOffset = $paged * $postsPerPage;
        $query = array(
            'post_status' => array(
                'publish',
                'draft',
                'pending',
                'trash',
                'private',
                'future'
            ),
            'post_type' => array(
                'any'
            ),
            'numberposts' => $postsPerPage,
            'meta_key' => 'instamatic_parent_rule',
            'fields' => 'ids',
            'offset'  => $postOffset
        );
        $got_me = get_posts($query);
        $post_list = array_merge($post_list, $got_me);
        $paged++;
    }while(!empty($got_me));
    wp_suspend_cache_addition(true);
    foreach ($post_list as $post) {
        $index = get_post_meta($post, 'instamatic_parent_rule', true);
        if ($index == $del_id) {
            $args             = array(
                'post_parent' => $post
            );
            $post_attachments = get_children($args);
            if (isset($post_attachments) && !empty($post_attachments)) {
                foreach ($post_attachments as $attachment) {
                    wp_delete_attachment($attachment->ID, true);
                }
            }
            $res = wp_delete_post($post, $force_delete);
            if ($res === false) {
                $failed = true;
            } else {
                $number++;
            }
        }
    }
    wp_suspend_cache_addition(false);
    if ($failed === true) {
        if (isset($instamatic_Main_Settings['enable_detailed_logging'])) {
            instamatic_log_to_file('[PostDelete] Failed to delete all posts for rule id: ' . esc_html($del_id) . '!');
        }
        echo 'failed';
    } else {
        if (isset($instamatic_Main_Settings['enable_detailed_logging'])) {
            instamatic_log_to_file('[PostDelete] Successfuly deleted ' . esc_html($number) . ' posts for rule id: ' . esc_html($del_id) . '!');
        }
        if ($number == 0) {
            echo 'nochange';
        } else {
            echo 'ok';
        }
    }
    die();
}
add_action('wp_ajax_instamatic_run_my_action', 'instamatic_run_my_action_callback');
function instamatic_run_my_action_callback()
{
    $run_id = $_POST['id'];
    echo instamatic_run_rule($run_id, 0);
    die();
}

function instamatic_repairHTML($content)
{
    $doc                     = new DOMDocument();
    $doc->substituteEntities = false;
    if(function_exists('mb_convert_encoding'))
    {
        $content = mb_convert_encoding($content, 'html-entities', 'utf-8');
    }
    $internalErrors = libxml_use_internal_errors(true);
    $doc->loadHTML('<?xml encoding="utf-8" ?>' . $content);
    $content = $doc->saveHTML();
                    libxml_use_internal_errors($internalErrors);
	$content = str_replace('<?xml encoding="utf-8" ?>', '', $content);
    return $content;
}

function instamatic_clearFromList($param)
{
    $GLOBALS['wp_object_cache']->delete('instamatic_running_list', 'options');
    $running = get_option('instamatic_running_list');
    if($running !== false)
    {
        $key     = array_search($param, $running);
        if ($key !== FALSE) {
            unset($running[$key]);
            update_option('instamatic_running_list', $running);
        }
    }
}

function instamatic_get_web_page($url)
{
    $content = false;
    $instamatic_Main_Settings = get_option('instamatic_Main_Settings', false);
    if (!isset($instamatic_Main_Settings['proxy_url']) || $instamatic_Main_Settings['proxy_url'] == '') {
        $args = array(
           'timeout'     => 10,
           'redirection' => 10,
           'user-agent'  => instamatic_get_random_user_agent(),
           'blocking'    => true,
           'headers'     => array(),
           'cookies'     => array(),
           'body'        => null,
           'compress'    => false,
           'decompress'  => true,
           'sslverify'   => false,
           'stream'      => false,
           'filename'    => null
        );
        $ret_data            = wp_remote_get(html_entity_decode($url), $args);  
        $response_code       = wp_remote_retrieve_response_code( $ret_data );
        $response_message    = wp_remote_retrieve_response_message( $ret_data );        
        if ( 200 != $response_code ) {
        } else {
            $content = wp_remote_retrieve_body( $ret_data );
        }
    }
    if($content === false)
    {
        if(function_exists('curl_version') && filter_var($url, FILTER_VALIDATE_URL))
        {
            $instamatic_Main_Settings = get_option('instamatic_Main_Settings', false);
            $user_agent = instamatic_get_random_user_agent();
            $options    = array(
                CURLOPT_CUSTOMREQUEST => "GET",
                CURLOPT_POST => false,
                CURLOPT_USERAGENT => $user_agent,
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_HEADER => false,
                CURLOPT_FOLLOWLOCATION => true,
                CURLOPT_ENCODING => "",
                CURLOPT_AUTOREFERER => true,
                CURLOPT_CONNECTTIMEOUT => 10,
                CURLOPT_TIMEOUT => 10,
                CURLOPT_MAXREDIRS => 10,
                CURLOPT_SSL_VERIFYHOST => 0,
                CURLOPT_SSL_VERIFYPEER => 0
            );
            if (isset($instamatic_Main_Settings['proxy_url']) && $instamatic_Main_Settings['proxy_url'] != '') 
            {
                $prx = explode(',', $instamatic_Main_Settings['proxy_url']);
                $randomness = array_rand($prx);
                $options[CURLOPT_PROXY] = trim($prx[$randomness]);
                if (isset($instamatic_Main_Settings['proxy_auth']) && $instamatic_Main_Settings['proxy_auth'] != '') 
                {
                    $prx_auth = explode(',', $instamatic_Main_Settings['proxy_auth']);
                    if(isset($prx_auth[$randomness]) && trim($prx_auth[$randomness]) != '')
                    {
                        $options[CURLOPT_PROXYUSERPWD] = trim($prx_auth[$randomness]);
                    }
                }
            }
            $ch         = curl_init($url);
            if ($ch === FALSE) {
                return FALSE;
            }
            curl_setopt_array($ch, $options);
            $content = curl_exec($ch);
            curl_close($ch);
        }
        else
        {
            $allowUrlFopen = preg_match('/1|yes|on|true/i', ini_get('allow_url_fopen'));
            if ($allowUrlFopen) {
                global $wp_filesystem;
                if ( ! is_a( $wp_filesystem, 'WP_Filesystem_Base') ){
                    include_once(ABSPATH . 'wp-admin/includes/file.php');$creds = request_filesystem_credentials( site_url() );
                    wp_filesystem($creds);
                }
                return $wp_filesystem->get_contents($url);
            }
        }
    }
    return $content;
}

function instamatic_utf8_encode($str)
{
    if(function_exists('mb_detect_encoding') && function_exists('mb_convert_encoding'))
    {
        $enc = mb_detect_encoding($str);
        if ($enc !== FALSE) {
            $str = mb_convert_encoding($str, 'UTF-8', $enc);
        } else {
            $str = mb_convert_encoding($str, 'UTF-8');
        }
    }
    return $str;
}

function instamatic_generate_title($content, $backup)
{
    $regexEmoticons = '/[\x{1F600}-\x{1F64F}]/u';
    $content        = preg_replace($regexEmoticons, '', $content);
    $regexSymbols   = '/[\x{1F300}-\x{1F5FF}]/u';
    $content        = preg_replace($regexSymbols, '', $content);
    $regexTransport = '/[\x{1F680}-\x{1F6FF}]/u';
    $content        = preg_replace($regexTransport, '', $content);
    $regexMisc      = '/[\x{2600}-\x{26FF}]/u';
    $content        = preg_replace($regexMisc, '', $content);
    $regexDingbats  = '/[\x{2700}-\x{27BF}]/u';
    $content        = preg_replace($regexDingbats, '', $content);
    $pattern        = "/[a-zA-Z]*[:\/\/]*[A-Za-z0-9\-_]+\.+[A-Za-z0-9\.\/%&=\?\-_]+/i";
    $replacement    = "";
    $content        = preg_replace($pattern, $replacement, $content);
    $return         = trim(trim(trim(wp_trim_words($content, 14)), '.'), ',');
    if ($return == '') {
        $return = trim(trim(trim(wp_trim_words($backup, 14)), '.'), ',');
    }
    return $return;
}

function instamatic_embed_Instagram_media($atts)
{
    extract(shortcode_atts(array(
        'v' => ''
    ), $atts));
    
    if (strpos($v, 'http') !== false) {
        if (strpos($v, 'v=') !== false) {
            parse_str(parse_url($v, PHP_URL_QUERY), $params);
            if(isset($params['v']))
            {
                $vid = $params['v'];
            }
            else
            {
                $vid = '';
            }
        } else {
            $v   = rtrim($v, '/');
            $vid = substr($v, strrpos($v, '/') + 1);
        }
    } else {
        $vid = trim($v);
    }
    return '<blockquote class="instagram-media" data-instgrm-captioned data-instgrm-permalink="' . esc_url($vid) . '" data-instgrm-version="12" style=" background:#FFF; border:0; border-radius:3px; box-shadow:0 0 1px 0 rgba(0,0,0,0.5),0 1px 10px 0 rgba(0,0,0,0.15); margin: 1px; max-width:540px; min-width:326px; padding:0; width:99.375%; width:-webkit-calc(100% - 2px); width:calc(100% - 2px);"><div style="padding:16px;"> <a href="' . esc_url($vid) . '" style=" background:#FFFFFF; line-height:0; padding:0 0; text-align:center; text-decoration:none; width:100%;" target="_blank"> <div style=" display: flex; flex-direction: row; align-items: center;"> <div style="background-color: #F4F4F4; border-radius: 50%; flex-grow: 0; height: 40px; margin-right: 14px; width: 40px;"></div> <div style="display: flex; flex-direction: column; flex-grow: 1; justify-content: center;"> <div style=" background-color: #F4F4F4; border-radius: 4px; flex-grow: 0; height: 14px; margin-bottom: 6px; width: 100px;"></div> <div style=" background-color: #F4F4F4; border-radius: 4px; flex-grow: 0; height: 14px; width: 60px;"></div></div></div><div style="padding: 19% 0;"></div> <div style="display:block; height:50px; margin:0 auto 12px; width:50px;"><svg width="50px" height="50px" viewBox="0 0 60 60" version="1.1" xmlns="https://www.w3.org/2000/svg" xmlns:xlink="https://www.w3.org/1999/xlink"><g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd"><g transform="translate(-511.000000, -20.000000)" fill="#000000"><g><path d="M556.869,30.41 C554.814,30.41 553.148,32.076 553.148,34.131 C553.148,36.186 554.814,37.852 556.869,37.852 C558.924,37.852 560.59,36.186 560.59,34.131 C560.59,32.076 558.924,30.41 556.869,30.41 M541,60.657 C535.114,60.657 530.342,55.887 530.342,50 C530.342,44.114 535.114,39.342 541,39.342 C546.887,39.342 551.658,44.114 551.658,50 C551.658,55.887 546.887,60.657 541,60.657 M541,33.886 C532.1,33.886 524.886,41.1 524.886,50 C524.886,58.899 532.1,66.113 541,66.113 C549.9,66.113 557.115,58.899 557.115,50 C557.115,41.1 549.9,33.886 541,33.886 M565.378,62.101 C565.244,65.022 564.756,66.606 564.346,67.663 C563.803,69.06 563.154,70.057 562.106,71.106 C561.058,72.155 560.06,72.803 558.662,73.347 C557.607,73.757 556.021,74.244 553.102,74.378 C549.944,74.521 548.997,74.552 541,74.552 C533.003,74.552 532.056,74.521 528.898,74.378 C525.979,74.244 524.393,73.757 523.338,73.347 C521.94,72.803 520.942,72.155 519.894,71.106 C518.846,70.057 518.197,69.06 517.654,67.663 C517.244,66.606 516.755,65.022 516.623,62.101 C516.479,58.943 516.448,57.996 516.448,50 C516.448,42.003 516.479,41.056 516.623,37.899 C516.755,34.978 517.244,33.391 517.654,32.338 C518.197,30.938 518.846,29.942 519.894,28.894 C520.942,27.846 521.94,27.196 523.338,26.654 C524.393,26.244 525.979,25.756 528.898,25.623 C532.057,25.479 533.004,25.448 541,25.448 C548.997,25.448 549.943,25.479 553.102,25.623 C556.021,25.756 557.607,26.244 558.662,26.654 C560.06,27.196 561.058,27.846 562.106,28.894 C563.154,29.942 563.803,30.938 564.346,32.338 C564.756,33.391 565.244,34.978 565.378,37.899 C565.522,41.056 565.552,42.003 565.552,50 C565.552,57.996 565.522,58.943 565.378,62.101 M570.82,37.631 C570.674,34.438 570.167,32.258 569.425,30.349 C568.659,28.377 567.633,26.702 565.965,25.035 C564.297,23.368 562.623,22.342 560.652,21.575 C558.743,20.834 556.562,20.326 553.369,20.18 C550.169,20.033 549.148,20 541,20 C532.853,20 531.831,20.033 528.631,20.18 C525.438,20.326 523.257,20.834 521.349,21.575 C519.376,22.342 517.703,23.368 516.035,25.035 C514.368,26.702 513.342,28.377 512.574,30.349 C511.834,32.258 511.326,34.438 511.181,37.631 C511.035,40.831 511,41.851 511,50 C511,58.147 511.035,59.17 511.181,62.369 C511.326,65.562 511.834,67.743 512.574,69.651 C513.342,71.625 514.368,73.296 516.035,74.965 C517.703,76.634 519.376,77.658 521.349,78.425 C523.257,79.167 525.438,79.673 528.631,79.82 C531.831,79.965 532.853,80.001 541,80.001 C549.148,80.001 550.169,79.965 553.369,79.82 C556.562,79.673 558.743,79.167 560.652,78.425 C562.623,77.658 564.297,76.634 565.965,74.965 C567.633,73.296 568.659,71.625 569.425,69.651 C570.167,67.743 570.674,65.562 570.82,62.369 C570.966,59.17 571,58.147 571,50 C571,41.851 570.966,40.831 570.82,37.631"></path></g></g></g></svg></div><div style="padding-top: 8px;"> <div style=" color:#3897f0; font-family:Arial,sans-serif; font-size:14px; font-style:normal; font-weight:550; line-height:18px;"> ' . esc_html__('View this on Instagram', 'instamatic-instagram-post-generator') . '</div></div><div style="padding: 12.5% 0;"></div> <div style="display: flex; flex-direction: row; margin-bottom: 14px; align-items: center;"><div> <div style="background-color: #F4F4F4; border-radius: 50%; height: 12.5px; width: 12.5px; transform: translateX(0px) translateY(7px);"></div> <div style="background-color: #F4F4F4; height: 12.5px; transform: rotate(-45deg) translateX(3px) translateY(1px); width: 12.5px; flex-grow: 0; margin-right: 14px; margin-left: 2px;"></div> <div style="background-color: #F4F4F4; border-radius: 50%; height: 12.5px; width: 12.5px; transform: translateX(9px) translateY(-18px);"></div></div><div style="margin-left: 8px;"> <div style=" background-color: #F4F4F4; border-radius: 50%; flex-grow: 0; height: 20px; width: 20px;"></div> <div style=" width: 0; height: 0; border-top: 2px solid transparent; border-left: 6px solid #f4f4f4; border-bottom: 2px solid transparent; transform: translateX(16px) translateY(-4px) rotate(30deg)"></div></div><div style="margin-left: auto;"> <div style=" width: 0px; border-top: 8px solid #F4F4F4; border-right: 8px solid transparent; transform: translateY(16px);"></div> <div style=" background-color: #F4F4F4; flex-grow: 0; height: 12px; width: 16px; transform: translateY(-4px);"></div> <div style=" width: 0; height: 0; border-top: 8px solid #F4F4F4; border-left: 8px solid transparent; transform: translateY(-4px) translateX(8px);"></div></div></div></a></div></blockquote>';
}
add_shortcode('instamatic-media', 'instamatic_embed_Instagram_media');

function instamatic_async_tag( $tag, $handle, $src ) {
	if ( $handle !== 'instamatic-custom-js-footer' ) {
		return $tag;
	}
	return "<script src='$src' defer async></script>";
}
function instamatic_add_my_custom_js() {
     wp_enqueue_style('coderevolution-front-css', plugins_url('styles/coderevolution-front.css', __FILE__));
     $instamatic_Main_Settings = get_option('instamatic_Main_Settings', false);
     if (!isset($instamatic_Main_Settings['disable_scripts']) || $instamatic_Main_Settings['disable_scripts'] !== 'on') {
         wp_enqueue_script( 'instamatic-custom-js-footer', 'https://www.instagram.com/embed.js');
         add_filter( 'script_loader_tag', 'instamatic_async_tag', 10, 3 );
     }
}
add_action('wp_enqueue_scripts', 'instamatic_add_my_custom_js');

add_shortcode( 'instamatic-display-posts', 'instamatic_display_posts_shortcode' );
function instamatic_display_posts_shortcode( $atts ) {
	$original_atts = $atts;
	$atts = shortcode_atts( array(
		'author'               => '',
		'category'             => '',
		'category_display'     => '',
		'category_label'       => 'Posted in: ',
		'content_class'        => 'content',
		'date_format'          => '(n/j/Y)',
		'date'                 => '',
		'date_column'          => 'post_date',
		'date_compare'         => '=',
		'date_query_before'    => '',
		'date_query_after'     => '',
		'date_query_column'    => '',
		'date_query_compare'   => '',
		'display_posts_off'    => false,
		'excerpt_length'       => false,
		'excerpt_more'         => false,
		'excerpt_more_link'    => false,
		'exclude_current'      => false,
		'id'                   => false,
		'ignore_sticky_posts'  => false,
		'image_size'           => false,
		'include_author'       => false,
		'include_content'      => false,
		'include_date'         => false,
		'include_excerpt'      => false,
		'include_link'         => true,
		'include_title'        => true,
		'meta_key'             => '',
		'meta_value'           => '',
		'no_posts_message'     => '',
		'offset'               => 0,
		'order'                => 'DESC',
		'orderby'              => 'date',
		'post_parent'          => false,
		'post_status'          => 'publish',
		'post_type'            => 'post',
		'posts_per_page'       => '10',
		'tag'                  => '',
		'tax_operator'         => 'IN',
		'tax_include_children' => true,
		'tax_term'             => false,
		'taxonomy'             => false,
		'time'                 => '',
		'title'                => '',
        'title_color'          => '#000000',
        'excerpt_color'        => '#000000',
        'link_to_source'       => '',
        'title_font_size'      => '100%',
        'excerpt_font_size'    => '100%',
        'read_more_text'       => '',
		'wrapper'              => 'ul',
		'wrapper_class'        => 'display-posts-listing',
		'wrapper_id'           => false,
        'ruleid'               => ''
	), $atts, 'display-posts' );
	if( $atts['display_posts_off'] )
		return;
	$author               = sanitize_text_field( $atts['author'] );
    $ruleid               = sanitize_text_field( $atts['ruleid'] );
	$category             = sanitize_text_field( $atts['category'] );
	$category_display     = 'true' == $atts['category_display'] ? 'category' : sanitize_text_field( $atts['category_display'] );
	$category_label       = sanitize_text_field( $atts['category_label'] );
	$content_class        = array_map( 'sanitize_html_class', ( explode( ' ', $atts['content_class'] ) ) );
	$date_format          = sanitize_text_field( $atts['date_format'] );
	$date                 = sanitize_text_field( $atts['date'] );
	$date_column          = sanitize_text_field( $atts['date_column'] );
	$date_compare         = sanitize_text_field( $atts['date_compare'] );
	$date_query_before    = sanitize_text_field( $atts['date_query_before'] );
	$date_query_after     = sanitize_text_field( $atts['date_query_after'] );
	$date_query_column    = sanitize_text_field( $atts['date_query_column'] );
	$date_query_compare   = sanitize_text_field( $atts['date_query_compare'] );
	$excerpt_length       = intval( $atts['excerpt_length'] );
	$excerpt_more         = sanitize_text_field( $atts['excerpt_more'] );
	$excerpt_more_link    = filter_var( $atts['excerpt_more_link'], FILTER_VALIDATE_BOOLEAN );
	$exclude_current      = filter_var( $atts['exclude_current'], FILTER_VALIDATE_BOOLEAN );
	$id                   = $atts['id'];
	$ignore_sticky_posts  = filter_var( $atts['ignore_sticky_posts'], FILTER_VALIDATE_BOOLEAN );
	$image_size           = sanitize_key( $atts['image_size'] );
	$include_title        = filter_var( $atts['include_title'], FILTER_VALIDATE_BOOLEAN );
	$include_author       = filter_var( $atts['include_author'], FILTER_VALIDATE_BOOLEAN );
	$include_content      = filter_var( $atts['include_content'], FILTER_VALIDATE_BOOLEAN );
	$include_date         = filter_var( $atts['include_date'], FILTER_VALIDATE_BOOLEAN );
	$include_excerpt      = filter_var( $atts['include_excerpt'], FILTER_VALIDATE_BOOLEAN );
	$include_link         = filter_var( $atts['include_link'], FILTER_VALIDATE_BOOLEAN );
	$meta_key             = sanitize_text_field( $atts['meta_key'] );
	$meta_value           = sanitize_text_field( $atts['meta_value'] );
	$no_posts_message     = sanitize_text_field( $atts['no_posts_message'] );
	$offset               = intval( $atts['offset'] );
	$order                = sanitize_key( $atts['order'] );
	$orderby              = sanitize_key( $atts['orderby'] );
	$post_parent          = $atts['post_parent'];
	$post_status          = $atts['post_status'];
	$post_type            = sanitize_text_field( $atts['post_type'] );
	$posts_per_page       = intval( $atts['posts_per_page'] );
	$tag                  = sanitize_text_field( $atts['tag'] );
	$tax_operator         = $atts['tax_operator'];
	$tax_include_children = filter_var( $atts['tax_include_children'], FILTER_VALIDATE_BOOLEAN );
	$tax_term             = sanitize_text_field( $atts['tax_term'] );
	$taxonomy             = sanitize_key( $atts['taxonomy'] );
	$time                 = sanitize_text_field( $atts['time'] );
	$shortcode_title      = sanitize_text_field( $atts['title'] );
    $title_color          = sanitize_text_field( $atts['title_color'] );
    $excerpt_color        = sanitize_text_field( $atts['excerpt_color'] );
    $link_to_source       = sanitize_text_field( $atts['link_to_source'] );
    $excerpt_font_size    = sanitize_text_field( $atts['excerpt_font_size'] );
    $title_font_size      = sanitize_text_field( $atts['title_font_size'] );
    $read_more_text       = sanitize_text_field( $atts['read_more_text'] );
	$wrapper              = sanitize_text_field( $atts['wrapper'] );
	$wrapper_class        = array_map( 'sanitize_html_class', ( explode( ' ', $atts['wrapper_class'] ) ) );
	if( !empty( $wrapper_class ) )
		$wrapper_class = ' class="' . implode( ' ', $wrapper_class ) . '"';
	$wrapper_id = sanitize_html_class( $atts['wrapper_id'] );
	if( !empty( $wrapper_id ) )
		$wrapper_id = ' id="' . esc_html($wrapper_id) . '"';
	$args = array(
		'category_name'       => $category,
		'order'               => $order,
		'orderby'             => $orderby,
		'post_type'           => explode( ',', $post_type ),
		'posts_per_page'      => $posts_per_page,
		'tag'                 => $tag,
	);
	if ( ! empty( $date ) || ! empty( $time ) || ! empty( $date_query_after ) || ! empty( $date_query_before ) ) {
		$initial_date_query = $date_query_top_lvl = array();
		$valid_date_columns = array(
			'post_date', 'post_date_gmt', 'post_modified', 'post_modified_gmt',
			'comment_date', 'comment_date_gmt'
		);
		$valid_compare_ops = array( '=', '!=', '>', '>=', '<', '<=', 'IN', 'NOT IN', 'BETWEEN', 'NOT BETWEEN' );
		$dates = instamatic_sanitize_date_time( $date );
		if ( ! empty( $dates ) ) {
			if ( is_string( $dates ) ) {
				$timestamp = strtotime( $dates );
				$dates = array(
					'year'   => date( 'Y', $timestamp ),
					'month'  => date( 'm', $timestamp ),
					'day'    => date( 'd', $timestamp ),
				);
			}
			foreach ( $dates as $arg => $segment ) {
				$initial_date_query[ $arg ] = $segment;
			}
		}
		$times = instamatic_sanitize_date_time( $time, 'time' );
		if ( ! empty( $times ) ) {
			foreach ( $times as $arg => $segment ) {
				$initial_date_query[ $arg ] = $segment;
			}
		}
		$before = instamatic_sanitize_date_time( $date_query_before, 'date', true );
		if ( ! empty( $before ) ) {
			$initial_date_query['before'] = $before;
		}
		$after = instamatic_sanitize_date_time( $date_query_after, 'date', true );
		if ( ! empty( $after ) ) {
			$initial_date_query['after'] = $after;
		}
		if ( ! empty( $date_query_column ) && in_array( $date_query_column, $valid_date_columns ) ) {
			$initial_date_query['column'] = $date_query_column;
		}
		if ( ! empty( $date_query_compare ) && in_array( $date_query_compare, $valid_compare_ops ) ) {
			$initial_date_query['compare'] = $date_query_compare;
		}
		if ( ! empty( $date_column ) && in_array( $date_column, $valid_date_columns ) ) {
			$date_query_top_lvl['column'] = $date_column;
		}
		if ( ! empty( $date_compare ) && in_array( $date_compare, $valid_compare_ops ) ) {
			$date_query_top_lvl['compare'] = $date_compare;
		}
		if ( ! empty( $initial_date_query ) ) {
			$date_query_top_lvl[] = $initial_date_query;
		}
		$args['date_query'] = $date_query_top_lvl;
	}
    $args['meta_key'] = 'instamatic_parent_rule';
    if($ruleid != '')
    {
        $args['meta_value'] = $ruleid;
    }
	if( $ignore_sticky_posts )
		$args['ignore_sticky_posts'] = true;
	 
	if( $id ) {
		$posts_in = array_map( 'intval', explode( ',', $id ) );
		$args['post__in'] = $posts_in;
	}
	if( is_singular() && $exclude_current )
		$args['post__not_in'] = array( get_the_ID() );
	if( !empty( $author ) ) {
		if( 'current' == $author && is_user_logged_in() )
			$args['author_name'] = wp_get_current_user()->user_login;
		elseif( 'current' == $author )
            $unrelevar = false;
			 
		else
			$args['author_name'] = $author;
	}
	if( !empty( $offset ) )
		$args['offset'] = $offset;
	$post_status = explode( ', ', $post_status );
	$validated = array();
	$available = array( 'publish', 'pending', 'draft', 'auto-draft', 'future', 'private', 'inherit', 'trash', 'any' );
	foreach ( $post_status as $unvalidated )
		if ( in_array( $unvalidated, $available ) )
			$validated[] = $unvalidated;
	if( !empty( $validated ) )
		$args['post_status'] = $validated;
	if ( !empty( $taxonomy ) && !empty( $tax_term ) ) {
		if( 'current' == $tax_term ) {
			global $post;
			$terms = wp_get_post_terms(get_the_ID(), $taxonomy);
			$tax_term = array();
			foreach ($terms as $term) {
				$tax_term[] = $term->slug;
			}
		}else{
			$tax_term = explode( ', ', $tax_term );
		}
		if( !in_array( $tax_operator, array( 'IN', 'NOT IN', 'AND' ) ) )
			$tax_operator = 'IN';
		$tax_args = array(
			'tax_query' => array(
				array(
					'taxonomy'         => $taxonomy,
					'field'            => 'slug',
					'terms'            => $tax_term,
					'operator'         => $tax_operator,
					'include_children' => $tax_include_children,
				)
			)
		);
		$count = 2;
		$more_tax_queries = false;
		while(
			isset( $original_atts['taxonomy_' . $count] ) && !empty( $original_atts['taxonomy_' . $count] ) &&
			isset( $original_atts['tax_' . esc_html($count) . '_term'] ) && !empty( $original_atts['tax_' . esc_html($count) . '_term'] )
		):
			$more_tax_queries = true;
			$taxonomy = sanitize_key( $original_atts['taxonomy_' . $count] );
	 		$terms = explode( ', ', sanitize_text_field( $original_atts['tax_' . esc_html($count) . '_term'] ) );
	 		$tax_operator = isset( $original_atts['tax_' . esc_html($count) . '_operator'] ) ? $original_atts['tax_' . esc_html($count) . '_operator'] : 'IN';
	 		$tax_operator = in_array( $tax_operator, array( 'IN', 'NOT IN', 'AND' ) ) ? $tax_operator : 'IN';
	 		$tax_include_children = isset( $original_atts['tax_' . esc_html($count) . '_include_children'] ) ? filter_var( $atts['tax_' . esc_html($count) . '_include_children'], FILTER_VALIDATE_BOOLEAN ) : true;
	 		$tax_args['tax_query'][] = array(
	 			'taxonomy'         => $taxonomy,
	 			'field'            => 'slug',
	 			'terms'            => $terms,
	 			'operator'         => $tax_operator,
	 			'include_children' => $tax_include_children,
	 		);
			$count++;
		endwhile;
		if( $more_tax_queries ):
			$tax_relation = 'AND';
			if( isset( $original_atts['tax_relation'] ) && in_array( $original_atts['tax_relation'], array( 'AND', 'OR' ) ) )
				$tax_relation = $original_atts['tax_relation'];
			$args['tax_query']['relation'] = $tax_relation;
		endif;
		$args = array_merge_recursive( $args, $tax_args );
	}
	if( $post_parent !== false ) {
		if( 'current' == $post_parent ) {
			global $post;
			$post_parent = get_the_ID();
		}
		$args['post_parent'] = intval( $post_parent );
	}
	$wrapper_options = array( 'ul', 'ol', 'div' );
	if( ! in_array( $wrapper, $wrapper_options ) )
		$wrapper = 'ul';
	$inner_wrapper = 'div' == $wrapper ? 'div' : 'li';
	$listing = new WP_Query( apply_filters( 'display_posts_shortcode_args', $args, $original_atts ) );
	if ( ! $listing->have_posts() ) {
		return apply_filters( 'display_posts_shortcode_no_results', wpautop( $no_posts_message ) );
	}
	$inner = '';
    wp_suspend_cache_addition(true);
	while ( $listing->have_posts() ): $listing->the_post(); global $post;
		$image = $date = $author = $excerpt = $content = '';
		if ( $include_title && $include_link ) {
            if($link_to_source == 'yes')
            {
                $source_url = get_post_meta($post->ID, 'instamatic_post_url', true);
                if($source_url != '')
                {
                    $title = '<a class="instamatic_display_title" href="' . esc_url($source_url) . '"><span class="cr_display_span" >' . get_the_title() . '</span></a>';
                }
                else
                {
                    $title = '<a class="instamatic_display_title" href="' . apply_filters( 'the_permalink', get_permalink() ) . '"><span class="cr_display_span" >' . get_the_title() . '</span></a>';
                }
            }
            else
            {
                $title = '<a class="instamatic_display_title" href="' . apply_filters( 'the_permalink', get_permalink() ) . '"><span class="cr_display_span" >' . get_the_title() . '</span></a>';
            }
		} elseif( $include_title ) {
			$title = '<span class="instamatic_display_title" class="cr_display_span">' . get_the_title() . '</span>';
		} else {
			$title = '';
		}
		if ( $image_size && has_post_thumbnail() && $include_link ) {
            if($link_to_source == 'yes')
            {
                $source_url = get_post_meta($post->ID, 'instamatic_post_url', true);
                if($source_url != '')
                {
                    $image = '<a class="instamatic_display_image" href="' . esc_url($source_url) . '">' . get_the_post_thumbnail( get_the_ID(), $image_size ) . '</a> <br/>';
                }
                else
                {
                    $image = '<a class="instamatic_display_image" href="' . get_permalink() . '">' . get_the_post_thumbnail( get_the_ID(), $image_size ) . '</a> <br/>';
                }
            }
            else
            {
                $image = '<a class="instamatic_display_image" href="' . get_permalink() . '">' . get_the_post_thumbnail( get_the_ID(), $image_size ) . '</a> <br/>';
            }
		} elseif( $image_size && has_post_thumbnail() ) {
			$image = '<span class="instamatic_display_image">' . get_the_post_thumbnail( get_the_ID(), $image_size ) . '</span> <br/>';
		}
		if ( $include_date )
			$date = ' <span class="date">' . get_the_date( $date_format ) . '</span>';
		if( $include_author )
			$author = apply_filters( 'display_posts_shortcode_author', ' <span class="instamatic_display_author">by ' . get_the_author() . '</span>', $original_atts );
		if ( $include_excerpt ) {
			if( $excerpt_length || $excerpt_more || $excerpt_more_link ) {
				$length = $excerpt_length ? $excerpt_length : apply_filters( 'excerpt_length', 55 );
				$more   = $excerpt_more ? $excerpt_more : apply_filters( 'excerpt_more', '' );
				$more   = $excerpt_more_link ? ' <a href="' . get_permalink() . '">' . esc_html($more) . '</a>' : ' ' . esc_html($more);
				if( has_excerpt() && apply_filters( 'display_posts_shortcode_full_manual_excerpt', false ) ) {
					$excerpt = $post->post_excerpt . $more;
				} elseif( has_excerpt() ) {
					$excerpt = wp_trim_words( strip_shortcodes( $post->post_excerpt ), $length, $more );
				} else {
					$excerpt = wp_trim_words( strip_shortcodes( $post->post_content ), $length, $more );
				}
			} else {
				$excerpt = get_the_excerpt();
			}
			$excerpt = ' <br/><br/> <span class="instamatic_display_excerpt" class="cr_display_excerpt_adv">' . $excerpt . '</span>';
            if($read_more_text != '')
            {
                if($link_to_source == 'yes')
                {
                    $source_url = get_post_meta($post->ID, 'instamatic_post_url', true);
                    if($source_url != '')
                    {
                        $excerpt .= '<br/><a href="' . esc_url($source_url) . '"><span class="instamatic_display_excerpt" class="cr_display_excerpt_adv">' . esc_html($read_more_text) . '</span></a>';
                    }
                    else
                    {
                        $excerpt .= '<br/><a href="' . get_permalink() . '"><span class="instamatic_display_excerpt" class="cr_display_excerpt_adv">' . esc_html($read_more_text) . '</span></a>';
                    }
                }
                else
                {
                    $excerpt .= '<br/><a href="' . get_permalink() . '"><span class="instamatic_display_excerpt" class="cr_display_excerpt_adv">' . esc_html($read_more_text) . '</span></a>';
                }
            }
		}
		if( $include_content ) {
			add_filter( 'shortcode_atts_display-posts', 'instamatic_display_posts_off', 10, 3 );
			$content = '<div class="' . implode( ' ', $content_class ) . '">' . apply_filters( 'the_content', get_the_content() ) . '</div>';
			remove_filter( 'shortcode_atts_display-posts', 'instamatic_display_posts_off', 10, 3 );
		}
		$category_display_text = '';
		if( $category_display && is_object_in_taxonomy( get_post_type(), $category_display ) ) {
			$terms = get_the_terms( get_the_ID(), $category_display );
			$term_output = array();
			foreach( $terms as $term )
				$term_output[] = '<a href="' . get_term_link( $term, $category_display ) . '">' . esc_html($term->name) . '</a>';
			$category_display_text = ' <span class="category-display"><span class="category-display-label">' . esc_html($category_label) . '</span> ' . trim(implode( ', ', $term_output ), ', ') . '</span>';
			$category_display_text = apply_filters( 'display_posts_shortcode_category_display', $category_display_text );
		}
		$class = array( 'listing-item' );
		$class = array_map( 'sanitize_html_class', apply_filters( 'display_posts_shortcode_post_class', $class, $post, $listing, $original_atts ) );
		$output = '<br/><' . esc_html($inner_wrapper) . ' class="' . implode( ' ', $class ) . '">' . $image . $title . $date . $author . $category_display_text . $excerpt . $content . '</' . esc_html($inner_wrapper) . '><br/><br/><hr class="cr_hr_dot"/>';		$inner .= apply_filters( 'display_posts_shortcode_output', $output, $original_atts, $image, $title, $date, $excerpt, $inner_wrapper, $content, $class );
	endwhile; wp_reset_postdata();
    wp_suspend_cache_addition(false);
	$open = apply_filters( 'display_posts_shortcode_wrapper_open', '<' . $wrapper . $wrapper_class . $wrapper_id . '>', $original_atts );
	$close = apply_filters( 'display_posts_shortcode_wrapper_close', '</' . esc_html($wrapper) . '>', $original_atts );
	$return = $open;
	if( $shortcode_title ) {
		$title_tag = apply_filters( 'display_posts_shortcode_title_tag', 'h2', $original_atts );
		$return .= '<' . esc_html($title_tag) . ' class="display-posts-title">' . esc_html($shortcode_title) . '</' . esc_html($title_tag) . '>' . "\n";
	}
	$return .= $inner . $close;
    $reg_css_code = '.cr_hr_dot{border-top: dotted 1px;}.cr_display_span{font-size:' . esc_html($title_font_size) . ';color:' . esc_html($title_color) . ' !important;}.cr_display_excerpt_adv{font-size:' . esc_html($excerpt_font_size) . ';color:' . esc_html($excerpt_color) . ' !important;}';
    wp_register_style( 'instamatic-display-style', false );
    wp_enqueue_style( 'instamatic-display-style' );
    wp_add_inline_style( 'instamatic-display-style', $reg_css_code );
	return $return;
}
function instamatic_sanitize_date_time( $date_time, $type = 'date', $accepts_string = false ) {
	if ( empty( $date_time ) || ! in_array( $type, array( 'date', 'time' ) ) ) {
		return array();
	}
	$segments = array();
	if (
		true === $accepts_string
		&& ( false !== strpos( $date_time, ' ' ) || false === strpos( $date_time, '-' ) )
	) {
		if ( false !== $timestamp = strtotime( $date_time ) ) {
			return $date_time;
		}
	}
	$parts = array_map( 'absint', explode( 'date' == $type ? '-' : ':', $date_time ) );
	if ( 'date' == $type ) {
		$year = $month = $day = 1;
		if ( count( $parts ) >= 3 ) {
			list( $year, $month, $day ) = $parts;
			$year  = ( $year  >= 1 && $year  <= 9999 ) ? $year  : 1;
			$month = ( $month >= 1 && $month <= 12   ) ? $month : 1;
			$day   = ( $day   >= 1 && $day   <= 31   ) ? $day   : 1;
		}
		$segments = array(
			'year'  => $year,
			'month' => $month,
			'day'   => $day
		);
	} elseif ( 'time' == $type ) {
		$hour = $minute = $second = 0;
		switch( count( $parts ) ) {
			case 3 :
				list( $hour, $minute, $second ) = $parts;
				$hour   = ( $hour   >= 0 && $hour   <= 23 ) ? $hour   : 0;
				$minute = ( $minute >= 0 && $minute <= 60 ) ? $minute : 0;
				$second = ( $second >= 0 && $second <= 60 ) ? $second : 0;
				break;
			case 2 :
				list( $hour, $minute ) = $parts;
				$hour   = ( $hour   >= 0 && $hour   <= 23 ) ? $hour   : 0;
				$minute = ( $minute >= 0 && $minute <= 60 ) ? $minute : 0;
				break;
			default : break;
		}
		$segments = array(
			'hour'   => $hour,
			'minute' => $minute,
			'second' => $second
		);
	}

	return apply_filters( 'display_posts_shortcode_sanitized_segments', $segments, $date_time, $type );
}

function instamatic_display_posts_off( $out, $pairs, $atts ) {
	$out['display_posts_off'] = apply_filters( 'display_posts_shortcode_inception_override', true );
	return $out;
}
add_shortcode( 'instamatic-list-posts', 'instamatic_list_posts' );
function instamatic_list_posts( $atts ) {
    ob_start();
    extract( shortcode_atts( array (
        'type' => 'any',
        'order' => 'ASC',
        'orderby' => 'title',
        'posts' => 50,
        'posts_per_page' => 50,
        'category' => '',
        'ruleid' => ''
    ), $atts ) );
    $options = array(
        'post_type' => $type,
        'order' => $order,
        'orderby' => $orderby,
        'posts_per_page' => $posts,
        'category_name' => $category,
        'meta_key' => 'instamatic_parent_rule',
        'meta_value' => $ruleid
    );
    $query = new WP_Query( $options );
    if ( $query->have_posts() ) { ?>
        <ul class="clothes-listing">
            <?php while ( $query->have_posts() ) : $query->the_post(); ?>
            <li id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
                <a href="<?php echo esc_url(get_permalink()); ?>"><?php echo esc_html(get_the_title());?></a>
            </li>
            <?php endwhile;
            wp_reset_postdata(); ?>
        </ul>
    <?php $myvariable = ob_get_clean();
    return $myvariable;
    }
    return '';
}

function instamatic_removeEmoji($text) 
{			
				$clean_text = "";
				$regexEmoticons = '/[\x{1F600}-\x{1F64F}]/u';
				$clean_text = preg_replace($regexEmoticons, '', $text);
				$regexSymbols = '/[\x{1F300}-\x{1F5FF}]/u';
				$clean_text = preg_replace($regexSymbols, '', $clean_text);
				$regexTransport = '/[\x{1F680}-\x{1F6FF}]/u';
				$clean_text = preg_replace($regexTransport, '', $clean_text);
				$regexMisc = '/[\x{2600}-\x{26FF}]/u';
				$clean_text = preg_replace($regexMisc, '', $clean_text);
				$regexDingbats = '/[\x{2700}-\x{27BF}]/u';
				$clean_text = preg_replace($regexDingbats, '', $clean_text);			
				return $clean_text;
}
function instamatic_replaceSynergyShortcodes($the_content)
{
    $regex = '#%%([a-z0-9]+?)_(\d+?)_(\d+?)%%#';
    $rezz = preg_match_all($regex, $the_content, $matches);
    if ($rezz === FALSE) {
        return $the_content;
    }
    if(isset($matches[1][0]))
    {
        $two_var_functions = array('pdfomatic');
        $three_var_functions = array('bhomatic', 'crawlomatic', 'dmomatic', 'ezinomatic', 'fbomatic', 'flickomatic', 'imguromatic', 'iui', 'instamatic', 'linkedinomatic', 'mediumomatic', 'pinterestomatic', 'echo', 'spinomatic', 'tumblomatic', 'wordpressomatic', 'wpcomomatic', 'youtubomatic', 'mastermind', 'businessomatic');
        $four_var_functions = array('contentomatic', 'quoramatic', 'newsomatic', 'aliomatic', 'amazomatic', 'blogspotomatic', 'bookomatic', 'careeromatic', 'cbomatic', 'cjomatic', 'craigomatic', 'ebayomatic', 'etsyomatic', 'rakutenomatic', 'learnomatic', 'eventomatic', 'gameomatic', 'gearomatic', 'giphyomatic', 'gplusomatic', 'hackeromatic', 'imageomatic', 'midas', 'movieomatic', 'nasaomatic', 'ocartomatic', 'okomatic', 'playomatic', 'recipeomatic', 'redditomatic', 'soundomatic', 'mp3omatic', 'ticketomatic', 'tmomatic', 'trendomatic', 'tuneomatic', 'twitchomatic', 'twitomatic', 'vimeomatic', 'viralomatic', 'vkomatic', 'walmartomatic', 'wikiomatic', 'xlsxomatic', 'yelpomatic', 'yummomatic');
        for ($i = 0; $i < count($matches[1]); $i++)
        {
            $replace_me = false;
            if(in_array($matches[1][$i], $four_var_functions))
            {
                $za_function = $matches[1][$i] . '_run_rule';
                if(function_exists($za_function))
                {
                    $xreflection = new ReflectionFunction($za_function);
                    if($xreflection->getNumberOfParameters() >= 4)
                    {  
                        $rule_runner = $za_function($matches[3][$i], $matches[2][$i], 0, 1);
                        if($rule_runner != 'fail' && $rule_runner != 'nochange' && $rule_runner != 'ok' && $rule_runner !== false)
                        {
                            $the_content = str_replace('%%' . $matches[1][$i] . '_' . $matches[2][$i] . '_' . $matches[3][$i] . '%%', $rule_runner, $the_content);
                            $replace_me = true;
                        }
                    }
                    $xreflection = null;
                    unset($xreflection);
                }
            }
            elseif(in_array($matches[1][$i], $three_var_functions))
            {
                $za_function = $matches[1][$i] . '_run_rule';
                if(function_exists($za_function))
                {
                    $xreflection = new ReflectionFunction($za_function);
                    if($xreflection->getNumberOfParameters() >= 3)
                    {
                        $rule_runner = $za_function($matches[3][$i], 0, 1);
                        if($rule_runner != 'fail' && $rule_runner != 'nochange' && $rule_runner != 'ok' && $rule_runner !== false)
                        {
                            $the_content = str_replace('%%' . $matches[1][$i] . '_' . $matches[2][$i] . '_' . $matches[3][$i] . '%%', $rule_runner, $the_content);
                            $replace_me = true;
                        }
                    }
                    $xreflection = null;
                    unset($xreflection);
                }
            }
            elseif(in_array($matches[1][$i], $two_var_functions))
            {
                $za_function = $matches[1][$i] . '_run_rule';
                if(function_exists($za_function))
                {
                    $xreflection = new ReflectionFunction($za_function);
                    if($xreflection->getNumberOfParameters() >= 2)
                    {
                        $rule_runner = $za_function($matches[3][$i], 1);
                        if($rule_runner != 'fail' && $rule_runner != 'nochange' && $rule_runner != 'ok' && $rule_runner !== false)
                        {
                            $the_content = str_replace('%%' . $matches[1][$i] . '_' . $matches[2][$i] . '_' . $matches[3][$i] . '%%', $rule_runner, $the_content);
                            $replace_me = true;
                        }
                    }
                    $xreflection = null;
                    unset($xreflection);
                }
            }
            if($replace_me == false)
            {
                $the_content = str_replace('%%' . $matches[1][$i] . '_' . $matches[2][$i] . '_' . $matches[3][$i] . '%%', '', $the_content);
            }
        }
    }
    return $the_content;
}

use Phpfastcache\Helper\Psr16Adapter;
function instamatic_run_rule($param, $auto = 1, $ret_content = 0)
{
    $instamatic_Main_Settings = get_option('instamatic_Main_Settings', false);
    if($ret_content == 0)
    {
        $f = fopen(get_temp_dir() . 'instamatic_' . $param, 'w');
        if($f !== false)
        {
            $flock_disabled = explode(',', ini_get('disable_functions'));
            if(!in_array('flock', $flock_disabled))
            {
                if (!flock($f, LOCK_EX | LOCK_NB)) {
                    return 'nochange';
                }
            }
        }
        
        $GLOBALS['wp_object_cache']->delete('instamatic_running_list', 'options');
                if (!get_option('instamatic_running_list')) {
                    $running = array();
                } else {
                    $running = get_option('instamatic_running_list');
                }
                if (!empty($running)) {
                    if (in_array($param, $running)) {
                        if (isset($instamatic_Main_Settings['enable_detailed_logging'])) {
                            instamatic_log_to_file('Only one instance of this rule is allowed. Rule is already running!');
                        }
                        return 'nochange';
                    }
                }
                $running[] = $param;
                update_option('instamatic_running_list', $running, false);
                register_shutdown_function('instamatic_clear_flag_at_shutdown', $param);
        if (isset($instamatic_Main_Settings['rule_timeout']) && $instamatic_Main_Settings['rule_timeout'] != '') {
            $timeout = intval($instamatic_Main_Settings['rule_timeout']);
        } else {
            $timeout = 3600;
        }
        ini_set('safe_mode', 'Off');
        ini_set('max_execution_time', $timeout);
        ini_set('ignore_user_abort', 1);
        ini_set('user_agent', instamatic_get_random_user_agent());
        ignore_user_abort(true);
        set_time_limit($timeout);
    }
    $posts_inserted         = 0;
    if (isset($instamatic_Main_Settings['instamatic_enabled']) && $instamatic_Main_Settings['instamatic_enabled'] == 'on') {
        try {
            if (!isset($instamatic_Main_Settings['app_id']) || trim($instamatic_Main_Settings['app_id']) == '') {
                instamatic_log_to_file('You need to insert a valid Instagram User Name for this to work!');
                if($auto == 1)
                {
                    instamatic_clearFromList($param);
                }
                return 'fail';
            }
            if (!isset($instamatic_Main_Settings['app_secret']) || $instamatic_Main_Settings['app_secret'] == '') {
                instamatic_log_to_file('You need to insert a valid Instagram User Password for this to work!');
                if($auto == 1)
                {
                    instamatic_clearFromList($param);
                }
                return 'fail';
            }
            $item_img         = '';
            $rule_type        = 'group';
            $cont             = 0;
            $found            = 0;
            $ids              = '';
            $schedule         = '';
            $enable_comments  = '1';
            $enable_pingback  = '1';
            $author_link      = '';
            $max              = PHP_INT_MAX;
            $active           = '0';
            $last_run         = '';
            $ruleType         = 'week';
            $first            = false;
            $others           = array();
            $post_title       = '';
            $post_content     = '';
            $list_item        = '';
            $default_category = '';
            $default_title    = '';
            $strip_emojis     = '';
            $extra_categories = array();
            $posted_items    = array();
            $post_status     = 'publish';
            $post_type       = 'post';
            $accept_comments = 'closed';
            $post_user_name  = 1;
            $can_create_cat  = 'off';
            $item_create_tag = '';
            $can_create_tag  = '0';
            $item_tags       = array();
            $max             = 50;
            $auto_categories = '0';
            $featured_image  = '0';
            $post_date       = '0';
            $get_img         = '';
            $img_found       = false;
            $insert_comments = 'disabled';
            $image_url       = '';
            $attach_screen   = '';
            $post_format     = 'post-format-standard';
            $post_array      = array();
            $remove_default  = '0';
            $enable_login    = '';
            $user_agent      = '';
            $parent_category_id = '';
            $GLOBALS['wp_object_cache']->delete('instamatic_rules_list', 'options');
            if (!get_option('instamatic_rules_list')) {
                $rules = array();
            } else {
                $rules = get_option('instamatic_rules_list');
            }
            if (!empty($rules)) {
                foreach ($rules as $request => $bundle[]) {
                    if ($cont == $param) {
                        $bundle_values    = array_values($bundle);
                        $myValues         = $bundle_values[$cont];
                        $array_my_values  = array_values($myValues);for($iji=0;$iji<count($array_my_values);++$iji){if(is_string($array_my_values[$iji])){$array_my_values[$iji]=stripslashes($array_my_values[$iji]);}}
                        $ids              = isset($array_my_values[0]) ? $array_my_values[0] : '';
                        $schedule         = isset($array_my_values[1]) ? $array_my_values[1] : '';
                        $active           = isset($array_my_values[2]) ? $array_my_values[2] : '';
                        $last_run         = isset($array_my_values[3]) ? $array_my_values[3] : '';
                        $max              = isset($array_my_values[4]) ? $array_my_values[4] : '';
                        $post_status      = isset($array_my_values[5]) ? $array_my_values[5] : '';
                        $post_type        = isset($array_my_values[6]) ? $array_my_values[6] : '';
                        $post_user_name   = isset($array_my_values[7]) ? $array_my_values[7] : '';
                        $item_create_tag  = isset($array_my_values[8]) ? $array_my_values[8] : '';
                        $default_category = isset($array_my_values[9]) ? $array_my_values[9] : '';
                        $auto_categories  = isset($array_my_values[10]) ? $array_my_values[10] : '';
                        $can_create_tag   = isset($array_my_values[11]) ? $array_my_values[11] : '';
                        $enable_comments  = isset($array_my_values[12]) ? $array_my_values[12] : '';
                        $featured_image   = isset($array_my_values[13]) ? $array_my_values[13] : '';
                        $image_url        = isset($array_my_values[14]) ? $array_my_values[14] : '';
                        $post_title       = isset($array_my_values[15]) ? htmlspecialchars_decode($array_my_values[15]) : '';
                        $post_content     = isset($array_my_values[16]) ? htmlspecialchars_decode($array_my_values[16]) : '';
                        $enable_pingback  = isset($array_my_values[17]) ? $array_my_values[17] : '';
                        $post_format      = isset($array_my_values[18]) ? $array_my_values[18] : '';
                        $rule_type        = isset($array_my_values[19]) ? $array_my_values[19] : '';
                        $insert_comments  = isset($array_my_values[20]) ? $array_my_values[20] : '';
                        $default_title    = isset($array_my_values[21]) ? $array_my_values[21] : '';
                        $strip_emojis     = isset($array_my_values[22]) ? $array_my_values[22] : '';
                        $post_date        = isset($array_my_values[23]) ? $array_my_values[23] : '';
                        $remove_default   = isset($array_my_values[24]) ? $array_my_values[24] : '';
                        $parent_category_id= isset($array_my_values[25]) ? $array_my_values[25] : '';
                        $attach_screen    = isset($array_my_values[26]) ? $array_my_values[26] : '';
                        $enable_login     = isset($array_my_values[27]) ? $array_my_values[27] : '';
                        $user_agent       = isset($array_my_values[28]) ? $array_my_values[28] : '';
                        $found            = 1;
                        break;
                    }
                    $cont = $cont + 1;
                }
            } else {
                instamatic_log_to_file('No rules found for instamatic_rules_list!');
                if($auto == 1)
                {
                    instamatic_clearFromList($param);
                }
                return 'fail';
            }
            if ($found == 0) {
                instamatic_log_to_file($param . ' not found in instamatic_rules_list!');
                if($auto == 1)
                {
                    instamatic_clearFromList($param);
                }
                return 'fail';
            } else {
                if($ret_content == 0)
                {
                    $GLOBALS['wp_object_cache']->delete('instamatic_rules_list', 'options');
                    $rules = get_option('instamatic_rules_list');
                    $rules[$param][3] = instamatic_get_date_now();
                    update_option('instamatic_rules_list', $rules, false);
                }
            }
            if ($enable_comments == '1') {
                $accept_comments = 'open';
            }
            try
            {
                if(!class_exists('\GuzzleHttp\Client') || !class_exists('\Phpfastcache\Helper\Psr16Adapter'))
                {
                    require_once(dirname(__FILE__) . '/res/vendor/autoload.php');
                }
                require_once(dirname(__FILE__) . "/res/Instagram-get/InstagramScraper.php");
            }
            catch(Exception $e)
            {
                instamatic_log_to_file('Exception thrown in Instagram inclusion ' . esc_html($e->getMessage()) . '!');
                if($auto == 1)
                {
                    instamatic_clearFromList($param);
                }
                return 'fail';
            }
            $items = array();
            try
            {
                $param_arr = array();
                
                if (isset($instamatic_Main_Settings['proxy_url']) && $instamatic_Main_Settings['proxy_url'] != '') 
                {
                    $auth_arr_prx = array();
                    $auth = '';
                    $prx = explode(',', $instamatic_Main_Settings['proxy_url']);
                    $randomness = array_rand($prx);
                    $prxx = explode(':', trim($prx[$randomness]));
                    if (isset($instamatic_Main_Settings['proxy_auth']) && $instamatic_Main_Settings['proxy_auth'] != '') 
                    {
                        $prx_auth = explode(',', $instamatic_Main_Settings['proxy_auth']);
                        if(isset($prx_auth[$randomness]) && trim($prx_auth[$randomness]) != '')
                        {
                            $prxx_u = explode(':', trim($prx_auth[$randomness]));
                            if(isset($prxx_u[0]) && isset($prxx_u[1]))
                            {
                                $auth = $prxx_u[0] . ':' . $prxx_u[1] . '@';
                            }
                        }
                    }
                    $param_arr['proxy'] = 'http://' . $auth . $prx;                    
                }
                $gzzle = new \GuzzleHttp\Client($param_arr);
                $instagram = InstagramScraper\Instagram::withCredentials($gzzle, trim($instamatic_Main_Settings['app_id']), instamatic_encrypt_decrypt('decrypt', $instamatic_Main_Settings['app_secret']), new Psr16Adapter('Files'));
                
                if(trim($user_agent) != '')
                {
                    $instagram->setUserAgent(trim($user_agent));
                }
                if($enable_login == '1')
                {
                    $instagram->login();
                    $instagram->saveSession();
                }
                $ids = instamatic_replaceSynergyShortcodes($ids);
                if($rule_type == 'user')
                {
                    $items = $instagram->getMedias($ids, $max);
                    if (!is_array($items) || count($items) == 0) {
                        instamatic_log_to_file('Unrecognized API response: ' . print_r($items, true));
                        if($auto == 1)
                        {
                            instamatic_clearFromList($param);
                        }
                        return 'fail';
                    }
                }
                elseif($rule_type == 'url')
                {
                    if (filter_var($ids, FILTER_VALIDATE_URL) === FALSE) {
                        instamatic_log_to_file('Not a valid URL entered for URL rule: ' . $ids);
                        if($auto == 1)
                        {
                            instamatic_clearFromList($param);
                        }
                        return 'fail';
                    }
                    $ids = strtok($ids, '?');
                    $ids = trim($ids);
                    $ids = trim($ids, '/');
                    $temp_items = $instagram->getMediaByUrl($ids);
                    if (stristr(print_r($temp_items, true), '[id:protected]') === FALSE) {
                        instamatic_log_to_file('Unrecognized API response: ' . print_r($temp_items, true));
                        if($auto == 1)
                        {
                            instamatic_clearFromList($param);
                        }
                        return 'fail';
                    }
                    else
                    {
                        $items[] = $temp_items;
                    }
                }
                elseif($rule_type == 'tag')
                {
                    $ids = str_replace(' ', '', $ids);
                    $items = $instagram->getMediasByTag($ids, $max);
                    if (!is_array($items) || count($items) == 0) {
                        instamatic_log_to_file('Unrecognized API response: ' . print_r($items, true));
                        if($auto == 1)
                        {
                            instamatic_clearFromList($param);
                        }
                        return 'fail';
                    }
                }
                elseif($rule_type == 'toptag')
                {
                    $ids = str_replace(' ', '', $ids);
                    $items = $instagram->getCurrentTopMediasByTagName($ids);
                    if (!is_array($items) || count($items) == 0) {
                        instamatic_log_to_file('Unrecognized API response: ' . print_r($items, true));
                        if($auto == 1)
                        {
                            instamatic_clearFromList($param);
                        }
                        return 'fail';
                    }
                }
                elseif($rule_type == 'loc')
                {
                    $loc = $instagram->getLocationById($ids);
                    $items = $instagram->getMediasByLocationId($ids, $max);
                    if (!is_array($items) || count($items) == 0) {
                        instamatic_log_to_file('Unrecognized API response: ' . print_r($items, true));
                        if($auto == 1)
                        {
                            instamatic_clearFromList($param);
                        }
                        return 'fail';
                    }
                }
                elseif($rule_type == 'toploc')
                {
                    $items = $instagram->getCurrentTopMediasByLocationId($ids);
                    if (!is_array($items) || count($items) == 0) {
                        instamatic_log_to_file('Unrecognized API response: ' . print_r($items, true));
                        if($auto == 1)
                        {
                            instamatic_clearFromList($param);
                        }
                        return 'fail';
                    }
                }
            }
            catch(Exception $e)
            {
                instamatic_log_to_file('Exception thrown in Instagram exec ' . esc_html($e->getMessage()) . '!' . ' Query: ' . $ids);
                if($auto == 1)
                {
                    instamatic_clearFromList($param);
                }
                return 'fail';
            }
            
            $post_list = array();
            if($ret_content == 0)
            {
                $postsPerPage = 50000;
                $paged = 0;
                do
                {
                    $postOffset = $paged * $postsPerPage;
                    $query = array(
                        'post_status' => array(
                            'publish',
                            'draft',
                            'pending',
                            'trash',
                            'private',
                            'future'
                        ),
                        'post_type' => array(
                            'any'
                        ),
                        'numberposts' => $postsPerPage,
                        'meta_key' => 'instamatic_post_id',
                        'fields' => 'ids',
                        'offset'  => $postOffset
                    );
                    $got_me = get_posts($query);
                    $post_list = array_merge($post_list, $got_me);
                    $paged++;
                }while(!empty($got_me));
            }
            wp_suspend_cache_addition(true);
            foreach ($post_list as $post) {
                $posted_items[] = get_post_meta($post, 'instamatic_post_id', true);
            }
            wp_suspend_cache_addition(false);
            $count = 1;
            $init_date = time();
            $skip_pcount = 0;
            $skipped_pcount = 0;
            if($ret_content == 1)
            {
                $item_xcounter = count($items);
                $skip_pcount = rand(0, $item_xcounter-1);
            }
            foreach ($items as $item) {
                if($ret_content == 1)
                {
                    if($skip_pcount > $skipped_pcount)
                    {
                        $skipped_pcount++;
                        continue;
                    }
                }
                $item_id = $item->getId();
                if (in_array($item_id, $posted_items)) {
                    continue;
                }
                $type = $item->getType();
                $skip_types = $instamatic_Main_Settings['skip_types'];
                if($type != '')
                {
                    if (stristr($skip_types, $type)) {
                        continue;
                    }
                }
                if (isset($instamatic_Main_Settings['one_import']) && $instamatic_Main_Settings['one_import'] == 'on') {
                    $posted_me_it = get_option('instamatic_already_posted', false);
                    if(is_array($posted_me_it))
                    {
                        if(in_array($item_id, $posted_me_it))
                        {
                            instamatic_log_to_file('Skipping ' . $item_id . ' because it was already posted once before.');
                            continue;
                        }
                    }
                    else
                    {
                        $posted_me_it = array();
                    }
                    $posted_me_it[] = $item_id;
                    update_option('instamatic_already_posted', $posted_me_it);
                }
                $item_all_media = array();
                foreach ($item->getSidecarMedias() as $sidecarMedia) {
                    $sc_videoUrl = $sidecarMedia->getVideoStandardResolutionUrl();
                    if($sc_videoUrl == '')
                    {
                        $sc_videoUrl = $sidecarMedia->getVideoLowResolutionUrl();
                        if($sc_videoUrl == '')
                        {
                            $sc_videoUrl = $sidecarMedia->getVideoLowBandwidthUrl();
                        }
                    }
                    $sc_get_img = $sidecarMedia->getImageHighResolutionUrl();
                    if($sc_get_img != '')
                    {
                        $sc_get_img = $sidecarMedia->getImageStandardResolutionUrl();
                        if($sc_get_img != '')
                        {
                            $sc_get_img = $sidecarMedia->getImageLowResolutionUrl();
                            if($sc_get_img != '')
                            {
                                $sc_get_img = $sidecarMedia->getImageThumbnailUrl();
                            }
                        }
                    }
                    if($sc_videoUrl != '')
                    {
                        $item_all_media[] = $sc_videoUrl;
                    }
                    else
                    {
                        if($sc_get_img != '')
                        {
                            $item_all_media[] = '.' . $sc_get_img;
                        }
                    }
                }
                $img_found = false;
                if ($count > intval($max)) {
                    break;
                }
                $url = $item->getLink();
                $date = $item->getCreatedTime();
                
                $get_img = $item->getImageHighResolutionUrl();
                if($get_img != '')
                {
                    $img_found = true;
                }
                else
                {
                    $get_img = $item->getImageStandardResolutionUrl();
                    if($get_img != '')
                    {
                        $img_found = true;
                    }
                    else
                    {
                        $get_img = $item->getImageLowResolutionUrl();
                        if($get_img != '')
                        {
                            $img_found = true;
                        }
                        else
                        {
                            $get_img = $item->getImageThumbnailUrl();
                            if($get_img != '')
                            {
                                $img_found = true;
                            }
                        }
                    }
                }
                $content = $item->getCaption();
                if($strip_emojis == '1')
                {
                    $content = instamatic_removeEmoji($content);
                }
                $isAd = $item->isAd();
                $videoUrl = $item->getVideoStandardResolutionUrl();
                if($videoUrl == '')
                {
                    $videoUrl = $item->getVideoLowResolutionUrl();
                    if($videoUrl == '')
                    {
                        $videoUrl = $item->getVideoLowBandwidthUrl();
                    }
                }
                $videoViews = $item->getVideoViews();
                $shortcode = '';
                $shortcode = $item->getShortCode();
                if($shortcode == '')
                {
                    $shortcode = $item->getShortCode();
                }
                if (isset($instamatic_Main_Settings['get_more']) && $instamatic_Main_Settings['get_more'] == 'on' && $shortcode != '') {
                    usleep(555000);
                    $feed_uri = 'https://www.instagram.com/p/' . $shortcode . '/?__a=1';
                    $ext = instamatic_get_web_page($feed_uri);
                    if ($ext !== FALSE) {
                        $ext = json_decode($ext);
                        if(isset($ext->graphql->shortcode_media->owner->username))
                        {
                            $ownerId = $ext->graphql->shortcode_media->owner->username;
                            $owner = $ext->graphql->shortcode_media->owner->full_name;
                        }
                        else
                        {
                            $ownerId = $item->getOwner()->getUsername();
                            $owner = $item->getOwner()->getFullName();
                        }
                    }
                    else
                    {
                        $ownerId = $item->getOwner()->getUsername();
                        $owner = $item->getOwner()->getFullName();
                    }
                }
                else
                {
                    $ownerId = $item->getOwner()->getUsername();
                    $owner = $item->getOwner()->getFullName();
                }
                $likesCount = $item->getLikesCount();
                $locationId = $item->getLocationId();
                $locationName = $item->getLocationName();
                $commentsCount = $item->getCommentsCount();
                $description = instamatic_getExcerpt($content);
                if ($content != '') {
                    $content = preg_replace('@(https?://([-\w\.]+[-\w])+(:\d+)?(/([\w/_\.#-]*(\?\S+)?[^\.\s])?)?)@', '<a href="$1" target="_blank">$0</a>', $content);
                    $content = preg_replace('/#(\w+)/u', ' <a href="https://www.instagram.com/explore/tags/$1">#$1</a>', $content);
                }
                if($default_title != '')
                {
                    $backup = $default_title;
                }
                else
                {
                    $backup = 'Instagram photo';
                }
                $title = instamatic_generate_title($content, $backup);

                if ($owner != '') {
                    $author = $owner;
                } else {
                    $author = trim($instamatic_Main_Settings['app_id']);
                }
                if ($ownerId != '') {
                    $author_link = "https://instagram.com/" . $ownerId;
                } else {
                    $author_link = "https://instagram.com/" . trim($instamatic_Main_Settings['app_id']);
                }
                
                if ($featured_image == '1' && isset($instamatic_Main_Settings['skip_no_img']) && $instamatic_Main_Settings['skip_no_img'] == 'on' && $img_found == false) {
                    if (isset($instamatic_Main_Settings['enable_detailed_logging'])) {
                        instamatic_log_to_file('Skipping post "' . esc_html($title) . '", because it has no detected image file attached');
                    }
                    continue;
                }
                if (isset($instamatic_Main_Settings['skip_old']) && $instamatic_Main_Settings['skip_old'] == 'on' && isset($instamatic_Main_Settings['skip_year']) && $instamatic_Main_Settings['skip_year'] !== '' && isset($instamatic_Main_Settings['skip_month']) && isset($instamatic_Main_Settings['skip_day'])) {
                    $old_date      = $instamatic_Main_Settings['skip_day'] . '-' . $instamatic_Main_Settings['skip_month'] . '-' . $instamatic_Main_Settings['skip_year'];
                    $time_date     = strtotime(date('Y-m-d h:m:s', $date));
                    $time_old_date = strtotime($old_date);
                    if ($time_date !== false && $time_old_date !== false) {
                        if ($time_date < $time_old_date) {
                            if (isset($instamatic_Main_Settings['enable_detailed_logging'])) {
                                instamatic_log_to_file('Skipping post "' . esc_html($title) . '", because it is older than ' . $old_date . ' - posted on ' . $date);
                            }
                            continue;
                        }
                    }
                }
                $my_post                              = array();
                $my_post['insert_comments']           = $insert_comments;
                $my_post['instamatic_post_id']          = $item_id;
                $my_post['instamatic_enable_pingbacks'] = $enable_pingback;
                $my_post['instamatic_post_image']       = $get_img;
                $my_post['default_category']          = $default_category;
                $type_set = false;
                if (isset($instamatic_Main_Settings['default_types_fb']) && $instamatic_Main_Settings['default_types_fb'] !== '')
                {
                    $type_arr = explode(',', $instamatic_Main_Settings['default_types_fb']);
                    if(count($type_arr) == 2)
                    {
                        if ($type == 'image')
                        {
                            if(post_type_exists(trim($type_arr[0])))
                            {
                                $my_post['post_type']                 = trim($type_arr[0]);
                                $type_set = true;
                            }
                        }
                        elseif ($type == 'video')
                        {
                            if(post_type_exists(trim($type_arr[1])))
                            {
                                $my_post['post_type']                 = trim($type_arr[1]);
                                $type_set = true;
                            }
                        }
                    }
                }
                if($type_set == false)
                {
                    $my_post['post_type']                 = $post_type;
                }
                
                $my_post['comment_status']            = $accept_comments;
                $my_post['post_status']               = $post_status;
                $my_post['post_author']               = instamatic_utf8_encode($post_user_name);
                $my_post['instamatic_post_url']         = $url;
                $my_post['instamatic_post_date']        = $date;
                $postdate = gmdate("Y-m-d H:i:s", intval($date));
                if($post_date == '1')
                {
                    if($postdate !== FALSE)
                    {
                        $my_post['post_date_gmt'] = $postdate;
                    }
                    else
                    {
                        $postdatex = gmdate("Y-m-d H:i:s", intval($init_date));
                        $my_post['post_date_gmt'] = $postdatex;
                        $init_date = $init_date - 1;
                    }
                }
                else
                {
                    $postdatex = gmdate("Y-m-d H:i:s", intval($init_date));
                    $my_post['post_date_gmt'] = $postdatex;
                    $init_date = $init_date - 1;
                }
                if (isset($instamatic_Main_Settings['strip_by_id']) && $instamatic_Main_Settings['strip_by_id'] != '') {
                    $mock = new DOMDocument;
                    $strip_list = explode(',', $instamatic_Main_Settings['strip_by_id']);
                    $doc        = new DOMDocument();
                    $internalErrors = libxml_use_internal_errors(true);
                    $doc->loadHTML('<?xml encoding="utf-8" ?>' . $content);
                    libxml_use_internal_errors($internalErrors);
                    foreach ($strip_list as $strip_id) {
                        $element = $doc->getElementById(trim($strip_id));
                        if (isset($element)) {
                            $element->parentNode->removeChild($element);
                        }
                    }
                    $body = $doc->getElementsByTagName('body')->item(0);
                    if(isset($body->childNodes))
                    {
                        foreach ($body->childNodes as $child){
                            $mock->appendChild($mock->importNode($child, true));
                        }
                        $temp_cont = $mock->saveHTML();
                        if($temp_cont !== FALSE && $temp_cont != '')
                        {
                            $temp_cont = str_replace('<?xml encoding="utf-8" ?>', '', $temp_cont);$temp_cont = html_entity_decode($temp_cont);$temp_cont = trim($temp_cont);if(substr_compare($temp_cont, '</p>', -strlen('</p>')) === 0){$temp_cont = substr_replace($temp_cont ,"", -4);}if(substr( $temp_cont, 0, 3 ) === "<p>"){$temp_cont = substr($temp_cont, 3);}
                            $content = $temp_cont;
                        }
                    }
                }              
                if (isset($instamatic_Main_Settings['strip_by_class']) && $instamatic_Main_Settings['strip_by_class'] != '') {
                    $mock = new DOMDocument;
                    $strip_list = explode(',', $instamatic_Main_Settings['strip_by_class']);
                    $doc        = new DOMDocument();
                    $internalErrors = libxml_use_internal_errors(true);
                    $doc->loadHTML('<?xml encoding="utf-8" ?>' . $content);
                    libxml_use_internal_errors($internalErrors);
                    foreach ($strip_list as $strip_class) {
                        if(trim($strip_class) == '')
                        {
                            continue;
                        }
                        $finder    = new DomXPath($doc);
                        $classname = trim($strip_class);
                        $nodes     = $finder->query("//*[contains(@class, '$classname')]");
                        if ($nodes === FALSE) {
                            break;
                        }
                        foreach ($nodes as $node) {
                            $node->parentNode->removeChild($node);
                        }
                    }
                    $body = $doc->getElementsByTagName('body')->item(0);
                    if(isset($body->childNodes))
                    {
                        foreach ($body->childNodes as $child){
                            $mock->appendChild($mock->importNode($child, true));
                        }
                        $temp_cont = $mock->saveHTML();
                        if($temp_cont !== FALSE && $temp_cont != '')
                        {
                            $temp_cont = str_replace('<?xml encoding="utf-8" ?>', '', $temp_cont);$temp_cont = html_entity_decode($temp_cont);$temp_cont = trim($temp_cont);if(substr_compare($temp_cont, '</p>', -strlen('</p>')) === 0){$temp_cont = substr_replace($temp_cont ,"", -4);}if(substr( $temp_cont, 0, 3 ) === "<p>"){$temp_cont = substr($temp_cont, 3);}
                            $content = $temp_cont;
                        }
                    }
                }
                $content = preg_replace('{href="/(\w)}', 'href="https://instagram.com/$1', $content);
                if (isset($instamatic_Main_Settings['strip_links']) && $instamatic_Main_Settings['strip_links'] == 'on') {
                    $content = instamatic_strip_links($content);
                }
                $screenimageURL = '';
                $screens_attach_id = '';
                if (isset($instamatic_Main_Settings['phantom_screen']) && $instamatic_Main_Settings['phantom_screen'] == 'on')
                {
                    if($attach_screen == '1' || (strstr($post_content, '%%item_show_screenshot%%') !== false || strstr($post_content, '%%item_screenshot_url%%') !== false))
                    {
                        if(function_exists('shell_exec')) 
                        {
                            $disabled = explode(',', ini_get('disable_functions'));
                            if(!in_array('shell_exec', $disabled))
                            {
                                if (isset($instamatic_Main_Settings['phantom_path']) && $instamatic_Main_Settings['phantom_path'] != '') 
                                {
                                    $phantomjs_comm = $instamatic_Main_Settings['phantom_path'] . ' ';
                                }
                                else
                                {
                                    $phantomjs_comm = 'phantomjs ';
                                }
                                if (isset($instamatic_Main_Settings['screenshot_height']) && $instamatic_Main_Settings['screenshot_height'] != '') 
                                {
                                    $h = esc_attr($instamatic_Main_Settings['screenshot_height']);
                                }
                                else
                                {
                                    $h = '0';
                                }
                                if (isset($instamatic_Main_Settings['screenshot_width']) && $instamatic_Main_Settings['screenshot_width'] != '') 
                                {
                                    $w = esc_attr($instamatic_Main_Settings['screenshot_width']);
                                }
                                else
                                {
                                    $w = '1920';
                                }
                                $upload_dir = wp_upload_dir();
                                $dir_name   = $upload_dir['basedir'] . '/instamatic-files';
                                $dir_url    = $upload_dir['baseurl'] . '/instamatic-files';
                                global $wp_filesystem;
                                if ( ! is_a( $wp_filesystem, 'WP_Filesystem_Base') ){
                                    include_once(ABSPATH . 'wp-admin/includes/file.php');$creds = request_filesystem_credentials( site_url() );
                                    wp_filesystem($creds);
                                }
                                if (!$wp_filesystem->exists($dir_name)) {
                                    wp_mkdir_p($dir_name);
                                }
                                $screen_name = uniqid();
                                $screenimageName = $dir_name . '/' . $screen_name;
                                $screenimageURL = $dir_url . '/' . $screen_name . '.jpg';
                                if(isset($instamatic_Main_Settings['proxy_url']) && $instamatic_Main_Settings['proxy_url'] != '') 
                                {
                                    $phantomjs_comm .= '--proxy=' . trim($instamatic_Main_Settings['proxy_url']) . ' ';
                                    if (isset($instamatic_Main_Settings['proxy_auth']) && $instamatic_Main_Settings['proxy_auth'] != '') 
                                    {
                                        $phantomjs_comm .= '--proxy-auth=' . trim($instamatic_Main_Settings['proxy_auth']) . ' ';
                                    }
                                }
                                $cmdResult = shell_exec($phantomjs_comm . '"' . dirname(__FILE__) .'/res/phantomjs/phantom-screenshot.js"' . ' "'. dirname(__FILE__) . '" "' . $url . '" "' . $screenimageName . '" ' . $w . ' ' . $h . '  2>&1');
                                if($cmdResult === NULL || $cmdResult == '' || trim($cmdResult) === 'timeout' || stristr($cmdResult, 'sh: phantomjs: command not found') !== false)
                                {
                                    $screenimageURL = '';
                                }
                                else
                                {
                                    if($wp_filesystem->exists($screenimageName))
                                    {
                                        $wp_filetype = wp_check_filetype( $screen_name . '.jpg', null );
                                        $attachment = array(
                                          'post_mime_type' => $wp_filetype['type'],
                                          'post_title' => sanitize_file_name( $screen_name . '.jpg' ),
                                          'post_content' => '',
                                          'post_status' => 'inherit'
                                        );
                                        $screens_attach_id = wp_insert_attachment( $attachment, $screenimageName . '.jpg' );
                                        require_once( ABSPATH . 'wp-admin/includes/image.php' );
                                        require_once( ABSPATH . 'wp-admin/includes/media.php' );
                                        $attach_data = wp_generate_attachment_metadata( $screens_attach_id, $screenimageName . '.jpg' );
                                        wp_update_attachment_metadata( $screens_attach_id, $attach_data );
                                    }
                                    else
                                    {
                                        instamatic_log_to_file('Screenshot file not found after phantom exec: ' . $cmdResult);
                                    }
                                }
                            }
                            else
                            {
                                instamatic_log_to_file('shell_exec in disabled functions list. Please enable to on your server');
                            }
                        }
                        else
                        {
                            instamatic_log_to_file('shell_exec disabled. Please enable to on your server');
                        }
                    }
                }
                elseif (isset($instamatic_Main_Settings['puppeteer_screen']) && $instamatic_Main_Settings['puppeteer_screen'] == 'on')
                {
                    if($attach_screen == '1' || (strstr($post_content, '%%item_show_screenshot%%') !== false || strstr($post_content, '%%item_screenshot_url%%') !== false))
                    {
                        if(function_exists('shell_exec')) 
                        {
                            $disabled = explode(',', ini_get('disable_functions'));
                            if(!in_array('shell_exec', $disabled))
                            {
                                $phantomjs_comm = 'node ';
                                if (isset($instamatic_Main_Settings['screenshot_height']) && $instamatic_Main_Settings['screenshot_height'] != '') 
                                {
                                    $h = esc_attr($instamatic_Main_Settings['screenshot_height']);
                                }
                                else
                                {
                                    $h = '0';
                                }
                                if (isset($instamatic_Main_Settings['screenshot_width']) && $instamatic_Main_Settings['screenshot_width'] != '') 
                                {
                                    $w = esc_attr($instamatic_Main_Settings['screenshot_width']);
                                }
                                else
                                {
                                    $w = '1920';
                                }
                                if ($w < 350) {
                                    $w = 350;
                                }
                                if ($w > 1920) {
                                    $w = 1920;
                                }
                                $upload_dir = wp_upload_dir();
                                $dir_name   = $upload_dir['basedir'] . '/instamatic-files';
                                $dir_url    = $upload_dir['baseurl'] . '/instamatic-files';
                                global $wp_filesystem;
                                if ( ! is_a( $wp_filesystem, 'WP_Filesystem_Base') ){
                                    include_once(ABSPATH . 'wp-admin/includes/file.php');$creds = request_filesystem_credentials( site_url() );
                                    wp_filesystem($creds);
                                }
                                if (!$wp_filesystem->exists($dir_name)) {
                                    wp_mkdir_p($dir_name);
                                }
                                $screen_name = uniqid();
                                $screenimageName = $dir_name . '/' . $screen_name . '.jpg';
                                $screenimageURL = $dir_url . '/' . $screen_name . '.jpg';
                                $phantomjs_proxcomm = '"null"';
                                if (isset($instamatic_Main_Settings['proxy_url']) && $instamatic_Main_Settings['proxy_url'] != '') 
                                {
                                    $prx = explode(',', $instamatic_Main_Settings['proxy_url']);
                                    $randomness = array_rand($prx);
                                    $phantomjs_proxcomm = '"' . trim($prx[$randomness]);
                                    if (isset($instamatic_Main_Settings['proxy_auth']) && $instamatic_Main_Settings['proxy_auth'] != '') 
                                    {
                                        $prx_auth = explode(',', $instamatic_Main_Settings['proxy_auth']);
                                        if(isset($prx_auth[$randomness]) && trim($prx_auth[$randomness]) != '')
                                        {
                                            $phantomjs_proxcomm .= ':' . trim($prx_auth[$randomness]);
                                        }
                                    }
                                    $phantomjs_proxcomm .= '"';
                                }
                                $custom_user_agent = 'default';
                                $custom_cookies = 'default';
                                $user_pass = 'default';
                                $cmdResult = shell_exec($phantomjs_comm . '"' . dirname(__FILE__) .'/res/puppeteer/screenshot.js"' . ' "' . $url . '" "' . $screenimageName . '" ' . $w . ' ' . $h . ' ' . $phantomjs_proxcomm . '  "' . esc_html($custom_user_agent) . '" "' . esc_html($custom_cookies) . '" "' . esc_html($user_pass) . '" 2>&1');
                                if(stristr($cmdResult, 'sh: node: command not found') !== false || stristr($cmdResult, 'throw err;') !== false)
                                {
                                    $screenimageURL = '';
                                    instamatic_log_to_file('Error in puppeteer screenshot: exec: ' . $phantomjs_comm . '"' . dirname(__FILE__) .'/res/puppeteer/screenshot.js"' . ' "' . $url . '" "' . $screenimageName . '" ' . $w . ' ' . $h . ' ' . $phantomjs_proxcomm . '  "' . esc_html($custom_user_agent) . '" "' . esc_html($custom_cookies) . '" "' . esc_html($user_pass) . '" , reterr: ' . $cmdResult);
                                }
                                else
                                {
                                    if($wp_filesystem->exists($screenimageName))
                                    {
                                        $wp_filetype = wp_check_filetype( $screen_name . '.jpg', null );
                                        $attachment = array(
                                          'post_mime_type' => $wp_filetype['type'],
                                          'post_title' => sanitize_file_name( $screen_name . '.jpg' ),
                                          'post_content' => '',
                                          'post_status' => 'inherit'
                                        );
                                        $screens_attach_id = wp_insert_attachment( $attachment, $screenimageName);
                                        require_once( ABSPATH . 'wp-admin/includes/image.php' );
                                        require_once( ABSPATH . 'wp-admin/includes/media.php' );
                                        $attach_data = wp_generate_attachment_metadata( $screens_attach_id, $screenimageName);
                                        wp_update_attachment_metadata( $screens_attach_id, $attach_data );
                                    }
                                    else
                                    {
                                        instamatic_log_to_file('Screenshot file not found after puppeteer exec: ' . $cmdResult);
                                    }
                                }
                            }
                        }
                    }
                }
                if (strpos($post_content, '%%') !== false) {
                    $new_post_content = instamatic_replaceContentShortcodes($post_content, $title, $content, $url, $get_img, $description, $author, $author_link, $videoUrl, $likesCount, $locationId, $locationName, $commentsCount, $item_all_media, $screenimageURL, $ownerId);
                } else {
                    $new_post_content = $post_content;
                }
                if (strpos($post_title, '%%') !== false) {
                    $new_post_title = instamatic_replaceTitleShortcodes($post_title, $title, $content, $url);
                } else {
                    $new_post_title = $post_title;
                }
                $my_post['description']      = $description;
                $my_post['author']           = $author;
                $my_post['author_link']      = $author_link;
                $arr                         = instamatic_spin_and_translate($new_post_title, $new_post_content);
                $new_post_title              = $arr[0];
                $new_post_content            = $arr[1];
                if($auto_categories == '1')
                {
                    $extra_categories            = instamatic_getHashtags($new_post_content);
                }
                elseif($auto_categories == '4')
                {
                    $author = str_replace('/', ' ', $author);
                    $extra_categories            = array($author);
                }
                elseif($auto_categories == '2')
                {
                    $extra_categories            = instamatic_extractKeyWords($content);
                }
                elseif($auto_categories == '3')
                {
                    $extra_categories_hash       = instamatic_getHashtags($new_post_content);
                    $extra_categories_cont       = instamatic_extractKeyWords($content);
                    $extra_categories            = array_merge($extra_categories_hash, $extra_categories_cont); 
                }
                if (is_array($extra_categories) && count($extra_categories) > 0)
                {
                    $extra_categories            = implode(',', $extra_categories);
                }
                else
                {
                    $extra_categories            = '';
                }
                $my_post['extra_categories'] = $extra_categories;
                $my_post['screen_attach']    = $screens_attach_id;
                if($can_create_tag == '1')
                {
                    $item_tags            = instamatic_getHashtags($new_post_content);
                }
                elseif($can_create_tag == '4')
                {
                    $author = str_replace('/', ' ', $author);
                    $item_tags            = array($author);
                }
                elseif($can_create_tag == '2')
                {
                    $item_tags            = instamatic_extractKeyWords($content, 3);
                }
                elseif($can_create_tag == '3')
                {
                    $item_tags_hash       = instamatic_getHashtags($new_post_content);
                    $item_tags_cont       = instamatic_extractKeyWords($content, 3);
                    $item_tags            = array_merge($item_tags_hash, $item_tags_cont); 
                }
                if (is_array($item_tags) && count($item_tags) > 0)
                {
                    $item_tags                   = implode(', ', $item_tags);
                }
                else
                {
                    $item_tags = '';
                }
                
                if ($can_create_tag !== '0') {
                    $post_the_tags = ($item_create_tag != '' ? $item_create_tag . ', ' : '') . instamatic_utf8_encode($item_tags);
                } else if ($item_create_tag != '') {
                    $post_the_tags = instamatic_utf8_encode($item_create_tag);
                }
                else
                {
                    $post_the_tags = '';
                }
                $my_post['extra_tags']       = $post_the_tags;
                $my_post['tags_input'] = $post_the_tags;
                $new_post_title   = instamatic_replaceTitleShortcodesAgain($new_post_title, $extra_categories, $post_the_tags);
                $new_post_content = instamatic_replaceContentShortcodesAgain($new_post_content, $extra_categories, $post_the_tags);
                $title_count = -1;
                if (isset($instamatic_Main_Settings['min_word_title']) && $instamatic_Main_Settings['min_word_title'] != '') {
                    $title_count = str_word_count($new_post_title);
                    if ($title_count < intval($instamatic_Main_Settings['min_word_title'])) {
                        if (isset($instamatic_Main_Settings['enable_detailed_logging'])) {
                            instamatic_log_to_file('Skipping post "' . esc_html($new_post_title) . '", because title length < ' . $instamatic_Main_Settings['min_word_title']);
                        }
                        continue;
                    }
                }
                if (isset($instamatic_Main_Settings['max_word_title']) && $instamatic_Main_Settings['max_word_title'] != '') {
                    if ($title_count == -1) {
                        $title_count = str_word_count($new_post_title);
                    }
                    if ($title_count > intval($instamatic_Main_Settings['max_word_title'])) {
                        if (isset($instamatic_Main_Settings['enable_detailed_logging'])) {
                            instamatic_log_to_file('Skipping post "' . esc_html($new_post_title) . '", because title length > ' . $instamatic_Main_Settings['max_word_title']);
                        }
                        continue;
                    }
                }
                $content_count = -1;
                if (isset($instamatic_Main_Settings['min_word_content']) && $instamatic_Main_Settings['min_word_content'] != '') {
                    $content_count = str_word_count(instamatic_strip_html_tags($new_post_content));
                    if ($content_count < intval($instamatic_Main_Settings['min_word_content'])) {
                        if (isset($instamatic_Main_Settings['enable_detailed_logging'])) {
                            instamatic_log_to_file('Skipping post "' . esc_html($new_post_title) . '", because content length < ' . $instamatic_Main_Settings['min_word_content']);
                        }
                        continue;
                    }
                }
                if (isset($instamatic_Main_Settings['max_word_content']) && $instamatic_Main_Settings['max_word_content'] != '') {
                    if ($content_count == -1) {
                        $content_count = str_word_count(instamatic_strip_html_tags($new_post_content));
                    }
                    if ($content_count > intval($instamatic_Main_Settings['max_word_content'])) {
                        if (isset($instamatic_Main_Settings['enable_detailed_logging'])) {
                            instamatic_log_to_file('Skipping post "' . esc_html($new_post_title) . '", because content length > ' . $instamatic_Main_Settings['max_word_content']);
                        }
                        continue;
                    }
                }
                if (isset($instamatic_Main_Settings['banned_words']) && $instamatic_Main_Settings['banned_words'] != '') {
                    $continue    = false;
                    $banned_list = explode(',', $instamatic_Main_Settings['banned_words']);
                    foreach ($banned_list as $banned_word) {
                        if (stripos($new_post_content, trim($banned_word)) !== FALSE) {
                            if (isset($instamatic_Main_Settings['enable_detailed_logging'])) {
                                instamatic_log_to_file('Skipping post "' . esc_html($new_post_title) . '", because it\'s content contains banned word: ' . $banned_word);
                            }
                            $continue = true;
                            break;
                        }
                        if (stripos($new_post_title, trim($banned_word)) !== FALSE) {
                            if (isset($instamatic_Main_Settings['enable_detailed_logging'])) {
                                instamatic_log_to_file('Skipping post "' . esc_html($new_post_title) . '", because it\'s title contains banned word: ' . $banned_word);
                            }
                            $continue = true;
                            break;
                        }
                    }
                    if ($continue === true) {
                        continue;
                    }
                }
                if (isset($instamatic_Main_Settings['required_words']) && $instamatic_Main_Settings['required_words'] != '') {
                    $continue      = false;
                    $required_list = explode(',', $instamatic_Main_Settings['required_words']);
                    foreach ($required_list as $required_word) {
                        if (stripos($new_post_content, trim($required_word)) !== FALSE) {
                            continue;
                        }
                        if (stripos($new_post_title, trim($required_word)) !== FALSE) {
                            continue;
                        }
                        $continue = true;
                    }
                    if ($continue === true) {
                        instamatic_log_to_file('Skipping post "' . esc_html($new_post_title) . '", because it\'s content doesn\'t contain required word.');
                        continue;
                    }
                }
                $new_post_content = instamatic_utf8_encode(html_entity_decode($new_post_content));
                $new_post_content = str_replace('</ iframe>', '</iframe>', $new_post_content);
                if (isset($instamatic_Main_Settings['links_hide_google']) && $instamatic_Main_Settings['links_hide_google'] == 'on' && isset($instamatic_Main_Settings['apiKey']) && $instamatic_Main_Settings['apiKey'] != '') 
                {
                    preg_match_all('@(https?:\/\/([-\w\.]+[-\w])+(:\d+)?(\/([\w/_\.#-]*(\?\S+)?[^\.\s"\'])?)*)@i', $new_post_content, $matches);
                    foreach (array_unique($matches[0]) as $match) {
                        if(stristr($match, '//goo.gl') === false && !instamatic_endsWith($match, ".png") && !instamatic_endsWith($match, ".jpg") && !instamatic_endsWith($match, ".jpe") && !instamatic_endsWith($match, ".gif") && !instamatic_endsWith($match, ".tif") && !instamatic_endsWith($match, ".tiff") && !instamatic_endsWith($match, ".x-icon") && !instamatic_endsWith($match, ".svg") && !instamatic_endsWith($match, ".ico") && !instamatic_endsWith($match, ".icon"))
                        {
                            $new_post_content = str_replace($match, instamatic_url_handle($match), $new_post_content);        
                        }                            
                    }
                }
                if (isset($instamatic_Main_Settings['copy_images']) && $instamatic_Main_Settings['copy_images'] == 'on') {
                    $new_post_content = preg_replace("~\ssrcset=['\"](?:[^'\"]*)['\"]~i", ' ', $new_post_content);
                    preg_match_all('/[\'"](http|https|ftp|ftps)?:\/\/\S+\.(?:jpg|jpeg|png|gif)([^\'"]*)[\'"]/', $new_post_content, $matches);
                    if(isset($matches[0][0]))
                    {
                        $matches[0] = array_unique($matches[0]);
                        foreach($matches[0] as $match)
                        {
                            $match = trim($match, '"\'');
                            $file_path = instamatic_copy_image_locally($match);
                            if($file_path != false)
                            {
                                $file_path = str_replace('\\', '/', $file_path);
                                $new_post_content = str_replace($match, $file_path, $new_post_content);
                            }
                        }
                    }
                }
                if($ret_content == 1)
                {
                    return $new_post_content;
                }
                $my_post['post_content'] = $new_post_content;
                $my_post['post_title']           = instamatic_utf8_encode($new_post_title);
                $my_post['original_title']       = $title;
                $my_post['original_content']     = $content;
                $my_post['instamatic_timestamp']   = instamatic_get_date_now();
                $my_post['instamatic_post_format'] = $post_format;
                if (isset($default_category) && $default_category !== 'instamatic_no_category_12345678' && $default_category[0] !== 'instamatic_no_category_12345678') {
                    if(is_array($default_category))
                    {
                        $cat_list = '';
                        foreach($default_category as $dc)
                        {
                            $cat_list .= get_cat_name($dc) . ',';
                        }
                        $cat_list = trim($cat_list, ',');
                        $extra_categories_temp = trim( $cat_list . ',' .$extra_categories, ',');
                    }
                    else
                    {
                        $extra_categories_temp = trim(get_cat_name($default_category) . ',' .$extra_categories, ',');
                    }
                }
                else
                {
                    $extra_categories_temp = $extra_categories;
                }
                $my_post['meta_input'] = array('instamatic_featured_image' => $get_img, 'instamatic_featured_video' => $videoUrl, 'instamatic_post_cats' => $extra_categories_temp, 'instamatic_post_tags' => $post_the_tags);
                if ($enable_pingback == '1') {
                    $my_post['ping_status'] = 'open';
                } else {
                    $my_post['ping_status'] = 'closed';
                }
                $post_array[] = $my_post;
                $count++;
            }
            foreach ($post_array as $post) {
                remove_filter('content_save_pre', 'wp_filter_post_kses');
                remove_filter('content_filtered_save_pre', 'wp_filter_post_kses');remove_filter('title_save_pre', 'wp_filter_kses');
                $post_id = wp_insert_post($post, true);
                add_filter('content_save_pre', 'wp_filter_post_kses');
                add_filter('content_filtered_save_pre', 'wp_filter_post_kses');add_filter('title_save_pre', 'wp_filter_kses');
                if (!is_wp_error($post_id)) {
                    $posts_inserted++;
                    if (isset($post['instamatic_post_format']) && $post['instamatic_post_format'] != '' && $post['instamatic_post_format'] != 'post-format-standard') {
                        wp_set_post_terms($post_id, $post['instamatic_post_format'], 'post_format', true);
                    }
                    if($post['screen_attach'] != '')
                    {
                        $media_post = wp_update_post( array(
                            'ID'            => $post['screen_attach'],
                            'post_parent'   => $post_id,
                        ), true );

                        if( is_wp_error( $media_post ) ) {
                            instamatic_log_to_file( 'Failed to assign post attachment ' . $post['screen_attach'] . ' to post id ' . $post_id . ': ' . print_r( $media_post, 1 ) );
                        }
                    }
                    $featured_path = '';
                    $image_failed  = false;
                    if ($featured_image == '1') {
                        $get_img = $post['instamatic_post_image'];
                        if ($get_img != '') {
                            if (!instamatic_generate_featured_image($get_img, $post_id)) {
                                $image_failed = true;
                                if (isset($instamatic_Main_Settings['enable_detailed_logging'])) {
                                    instamatic_log_to_file('instamatic_generate_featured_image failed for ' . $get_img . '!');
                                }
                            } else {
                                $featured_path = $get_img;
                            }
                        } else {
                            $image_failed = true;
                        }
                    }
                    if ($image_failed || $featured_image !== '1') {
                        if ($image_url != '') {
                            $image_urlx = explode(',',$image_url);
                            $image_urlx = trim($image_urlx[array_rand($image_urlx)]);
                            $retim = false;
                            if(is_numeric($image_urlx) && $image_urlx > 0)
                            {
                                require_once(ABSPATH . 'wp-admin/includes/image.php');
                                require_once(ABSPATH . 'wp-admin/includes/media.php');
                                $res2 = set_post_thumbnail($post_id, $image_urlx);
                                if ($res2 === FALSE) {
                                }
                                else
                                {
                                    $retim = true;
                                }
                            }
                            if($retim == false)
                            {
                                stream_context_set_default( [
                                    'ssl' => [
                                        'verify_peer' => false,
                                        'verify_peer_name' => false,
                                    ],
                                ]);
                                error_reporting(0);
                                $url_headers = get_headers($image_urlx, 1);
                                error_reporting(E_ALL);
                                if (isset($url_headers['Content-Type'])) {
                                    if (is_array($url_headers['Content-Type'])) {
                                        $img_type = strtolower($url_headers['Content-Type'][0]);
                                    } else {
                                        $img_type = strtolower($url_headers['Content-Type']);
                                    }
                                    
                                    if (strstr($img_type, 'image/') !== false) {
                                        if (!instamatic_generate_featured_image($image_urlx, $post_id)) {
                                            $image_failed = true;
                                            if (isset($instamatic_Main_Settings['enable_detailed_logging'])) {
                                                instamatic_log_to_file('instamatic_generate_featured_image failed to default value: ' . $image_urlx . '!');
                                            }
                                        } else {
                                            $featured_path = $image_urlx;
                                        }
                                    }
                                }
                            }
                        }
                    }
                    if($featured_image == '1' && $featured_path == '' && isset($instamatic_Main_Settings['skip_no_img']) && $instamatic_Main_Settings['skip_no_img'] == 'on')
                    {
                        if (isset($instamatic_Main_Settings['enable_detailed_logging'])) {
                            instamatic_log_to_file('Skipping post "' . $post['post_title'] . '", because it failed to generate a featured image for: ' . $get_img . ' and ' . $image_url);
                        }
                        wp_delete_post($post_id, true);
                        $posts_inserted--;
                        continue;
                    }
                    if($remove_default == '1' && ($auto_categories !== '0' || (isset($default_category) && $default_category !== 'instamatic_no_category_12345678' && $default_category[0] !== 'instamatic_no_category_12345678')))
                    {
                        $default_categories = wp_get_post_categories($post_id);
                    }
                    if ($auto_categories !== '0') {
                        if ($post['extra_categories'] != '') {
                            $extra_cats = explode(',', $post['extra_categories']);
                            foreach($extra_cats as $extra_cat)
                            {
                                if($parent_category_id != '')
                                {
                                    $termid = instamatic_create_terms('category', $parent_category_id, trim($extra_cat));
                                }
                                else
                                {
                                    $termid = instamatic_create_terms('category', '0', trim($extra_cat));
                                }
                                wp_set_post_terms($post_id, $termid, 'category', true);
                            }
                        }
                    }
                    if (isset($default_category) && $default_category !== 'instamatic_no_category_12345678' && $default_category[0] !== 'instamatic_no_category_12345678') {
                        $cats   = array();
                        if(is_array($default_category))
                        {
                            $cats = $default_category;
                        }
                        else
                        {
                            $cats[] = $default_category;
                        }
                        wp_set_post_categories($post_id, $cats, true);
                    }
                    if($remove_default == '1' && ($auto_categories !== '0' || (isset($default_category) && $default_category !== 'instamatic_no_category_12345678' && $default_category[0] !== 'instamatic_no_category_12345678')))
                    {
                        $new_categories = wp_get_post_categories($post_id);
                        if(isset($default_categories) && !($default_categories == $new_categories))
                        {
                            foreach($default_categories as $dc)
                            {
                                $rem_cat = get_category( $dc );
                                wp_remove_object_terms( $post_id, $rem_cat->slug, 'category' );
                            }
                        }
                    }
                    if (isset($instamatic_Main_Settings['post_source_custom']) && $instamatic_Main_Settings['post_source_custom'] != '') {
                        $tax_rez = wp_set_object_terms( $post_id, $instamatic_Main_Settings['post_source_custom'], 'coderevolution_post_source', true);
                    }
                    else
                    {
                        $tax_rez = wp_set_object_terms( $post_id, 'Instamatic_' . $param, 'coderevolution_post_source', true);
                    }
                    if (is_wp_error($tax_rez)) {
                        if (isset($instamatic_Main_Settings['enable_detailed_logging'])) {
                            instamatic_log_to_file('wp_set_object_terms failed for: ' . $post_id . '!');
                        }
                    }
                    instamatic_addPostMeta($post_id, $post, $param, $featured_path);
                    if ($post['insert_comments'] && $post['insert_comments'] != '0' && is_numeric($post['insert_comments'])) {
                        $comment_num = intval($post['insert_comments']);
                        if($comment_num === -1)
                        {
                            $comment_num = rand(0,50);
                        }
                        try
                        {
                            $comments = instamatic_getMediaCommentsByURL($post['instamatic_post_url'], $comment_num);
                            if ($comments !== FALSE) {
                                $date          = current_time('mysql');
                                $comms_added   = 0;
                                if ((isset($instamatic_Main_Settings['spin_text']) && $instamatic_Main_Settings['spin_text'] !== 'disabled') || (isset($instamatic_Main_Settings['translate']) && $instamatic_Main_Settings['translate'] != 'disabled')) {
                                    $title_sep = ' 07543210745321 ';
                                    $comm_trans = '';
                                    foreach ($comments as $user => $comment) {
                                        $comm_trans .= instamatic_strip_html_tags($comment) . $title_sep;
                                    }
                                    $comm_trans = trim($comm_trans, $title_sep);
                                    if($comm_trans != '')
                                    {
                                        $arr = instamatic_spin_and_translate($comm_trans, 'hello');
                                        $comm_trans = $arr[0];
                                        $comm_trans = explode(trim($title_sep), $comm_trans);
                                        if(count($comm_trans) == count($comments))
                                        {
                                            $i = 0;
                                            foreach($comments as $user => $comm)
                                            {
                                                $comments[$user] = $comm_trans[$i];
                                                $i++;
                                            }
                                        }
                                    }
                                }
                                foreach ($comments as $user => $comment) {
                                    if ($comment_num > $comms_added) {
                                        $comm       = $comment;
                                        $comm = preg_replace('/@(\w+)/u', ' <a href="https://www.instagram.com/$1">@$1</a>', $comm);
                                        $author     = $user;
                                        $authorLink = "https://instagram.com/" . $author;
                                        $date       = date('Y-m-d H:i:s', time());
                                        if (trim($comm) != '') {
                                            $data = array(
                                                'comment_post_ID' => $post_id,
                                                'comment_author' => $author,
                                                'comment_author_email' => '',
                                                'comment_author_url' => $authorLink,
                                                'comment_content' => $comm,
                                                'comment_type' => '',
                                                'comment_parent' => 0,
                                                'user_id' => 1,
                                                'comment_author_IP' => '127.0.0.1',
                                                'comment_agent' => instamatic_get_random_user_agent(),
                                                'comment_date' => $date,
                                                'comment_approved' => 1
                                            );
                                            wp_insert_comment($data);
                                            $comms_added++;
                                        }
                                    } else {
                                        break;
                                    }
                                }
                            }
                            
                        }
                        catch(Exception $e)
                        {
                            instamatic_log_to_file('Exception thrown in Instagram comment fetching' . esc_html($e->getMessage()) . '!');
                        }
                    }
                } else {
                    instamatic_log_to_file('Failed to insert post into database! Title:' . $post['post_title'] . '! Error: ' . $post_id->get_error_message() . 'Error code: ' . $post_id->get_error_code() . 'Error data: ' . $post_id->get_error_data());
                    continue;
                }
            }
            unset($post_array);
        }
        catch (Exception $e) {
            instamatic_log_to_file('Exception thrown in rule running ' . esc_html($e->getMessage()) . '!');
            if($auto == 1)
                {
                    instamatic_clearFromList($param);
                }
            return 'fail';
        }
        
        if (isset($instamatic_Main_Settings['enable_detailed_logging'])) {
            instamatic_log_to_file('Rule ID ' . esc_html($param) . ' succesfully run! ' . esc_html($posts_inserted) . ' posts created!');
        }
        if (isset($instamatic_Main_Settings['send_email']) && $instamatic_Main_Settings['send_email'] == 'on' && $instamatic_Main_Settings['email_address'] !== '') {
            try {
                $to        = $instamatic_Main_Settings['email_address'];
                $subject   = '[instamatic] Rule running report - ' . instamatic_get_date_now();
                $message   = 'Rule ID ' . esc_html($param) . ' succesfully run! ' . esc_html($posts_inserted) . ' posts created!';
                $headers[] = 'From: iMediamatic Plugin <instamatic@noreply.net>';
                $headers[] = 'Reply-To: noreply@instamatic.com';
                $headers[] = 'X-Mailer: PHP/' . phpversion();
                $headers[] = 'Content-Type: text/html';
                $headers[] = 'Charset: ' . get_option('blog_charset', 'UTF-8');
                wp_mail($to, $subject, $message, $headers);
            }
            catch (Exception $e) {
                if (isset($instamatic_Main_Settings['enable_detailed_logging'])) {
                    instamatic_log_to_file('Failed to send mail: Exception thrown ' . esc_html($e->getMessage()) . '!');
                }
            }
        }
    }
    if ($posts_inserted == 0) {
        if($auto == 1)
                {
                    instamatic_clearFromList($param);
                }
        return 'nochange';
    } else {
        if($auto == 1)
                {
                    instamatic_clearFromList($param);
                }
        return 'ok';
    }
}


function instamatic_copy_image_locally($image_url)
{
    $upload_dir = wp_upload_dir();
    global $wp_filesystem;
    if ( ! is_a( $wp_filesystem, 'WP_Filesystem_Base') ){
        include_once(ABSPATH . 'wp-admin/includes/file.php');$creds = request_filesystem_credentials( site_url() );
        wp_filesystem($creds);
    }
    if(substr( $image_url, 0, 10 ) === "data:image")
    {
        $data = explode(',', $image_url);
        if(isset($data[1]))
        {
            $image_data = base64_decode($data[1]);
            if($image_data === FALSE)
            {
                return false;
            }
        }
        else
        {
            return false;
        }
        preg_match('{data:image/(.*?);}', $image_url ,$ex_matches);
        if(isset($ex_matches[1]))
        {
            $image_url = 'image.' . $ex_matches[1];
        }
        else
        {
            $image_url = 'image.jpg';
        }
    }
    else
    {
        $image_data = instamatic_get_web_page(html_entity_decode($image_url));
        if ($image_data === FALSE || strpos($image_data, '<Message>Access Denied</Message>') !== FALSE) {
            return false;
        }
    }
    $filename = basename($image_url);
    $filename = explode("?", $filename);
    $filename = $filename[0];
    $filename = urlencode($filename);
    $filename = str_replace('%', '-', $filename);
    $filename = str_replace('#', '-', $filename);
    $filename = str_replace('&', '-', $filename);
    $filename = str_replace('{', '-', $filename);
    $filename = str_replace('}', '-', $filename);
    $filename = str_replace('\\', '-', $filename);
    $filename = str_replace('<', '-', $filename);
    $filename = str_replace('>', '-', $filename);
    $filename = str_replace('*', '-', $filename);
    $filename = str_replace('/', '-', $filename);
    $filename = str_replace('$', '-', $filename);
    $filename = str_replace('\'', '-', $filename);
    $filename = str_replace('"', '-', $filename);
    $filename = str_replace(':', '-', $filename);
    $filename = str_replace('@', '-', $filename);
    $filename = str_replace('+', '-', $filename);
    $filename = str_replace('|', '-', $filename);
    $filename = str_replace('=', '-', $filename);
    $filename = str_replace('`', '-', $filename);
    $file_parts = pathinfo($filename);
    switch($file_parts['extension'])
    {
        case "":
        if(!instamatic_endsWith($filename, '.jpg'))
            $filename .= 'jpg';
        break;
        case NULL:
        if(!instamatic_endsWith($filename, '.jpg'))
            $filename .= '.jpg';
        break;
    }
    if (wp_mkdir_p($upload_dir['path'] . '/localimages'))
    {
        $file = $upload_dir['path'] . '/localimages/' . $filename;
        $ret_path = $upload_dir['url'] . '/localimages/' . $filename;
    }
    else
    {
        $file = $upload_dir['basedir'] . '/' . $filename;
        $ret_path = $upload_dir['baseurl'] . '/' . $filename;
    }
    if($wp_filesystem->exists($file))
    {
        $unid = uniqid();
        $file .= $unid . '.jpg';
        $ret_path .= $unid . '.jpg';
    }
    
    $ret = $wp_filesystem->put_contents($file, $image_data);
    if ($ret === FALSE) {
        return false;
    }
    $wp_filetype = wp_check_filetype( $file, null );
    $attachment = array(
        'post_mime_type' => $wp_filetype['type'],
        'post_title' => sanitize_file_name( $file ),
        'post_content' => '',
        'post_status' => 'inherit'
    );
    $screens_attach_id = wp_insert_attachment( $attachment, $file );
    require_once( ABSPATH . 'wp-admin/includes/image.php' );
    require_once( ABSPATH . 'wp-admin/includes/media.php' );
    $attach_data = wp_generate_attachment_metadata( $screens_attach_id, $file );
    wp_update_attachment_metadata( $screens_attach_id, $attach_data );
    return $ret_path;
}
function instamatic_getHashtags($string) {  
    $hashtags= array();  
    preg_match_all("/(#\w+)/u", $string, $matches);  
    if ($matches) {
        $hashtagsArray = array_count_values($matches[0]);
        $hashtags = array_keys($hashtagsArray);
    }
    return $hashtags;
}
function instamatic_unicode2html($str){
    $i=65535;
    while($i>0){
        $hex=dechex($i);
        $str=str_replace("\u$hex","&#$i;",$str);
        $i--;
     }
     return $str;
}
function instamatic_getMediaCommentsByURL($url, $comment_num)
{
    $comms = 1;
    $comments = array();
    $html = instamatic_get_web_page($url);
    if ($html === FALSE) {
        return false;
    }
    $html_arr = explode('"text":"', $html);
    $space = '';
    if(!isset($html_arr[1]))
    {
        $html_arr = explode('"text": "', $html);
        $space = ' ';
    }
    if(isset($html_arr[1]))
    {
        $first = true;
        foreach($html_arr as $ht)
        {
            if($comms > intval($comment_num))
            {
                break;
            }
            if($first === true)
            {
                $first = false;
                continue;
            }
            $ht2 = explode('"', $ht);
            $user_arr = explode('"username":' . $space . '"', $ht);
            $user_name = 'Administrator';
            if(isset($user_arr[1]))
            {
                $user_name = explode('"', $user_arr[1]);
                $user_name = $user_name[0];
            }
            if(function_exists('mb_convert_encoding'))
            {
                $comments[$user_name] = stripslashes(preg_replace_callback('/\\\\u([0-9a-fA-F]{4})/', function ($match) {
                    return mb_convert_encoding(pack('H*', $match[1]), 'UTF-8', 'UCS-2BE');
                }, preg_quote($ht2[0])));
            }
            else
            {
                $comments[$user_name] = html_entity_decode(instamatic_unicode2html($ht2[0]));
            }
            
            $comms++;
        }
    }
    return $comments;
}

$instamatic_fatal = false;
function instamatic_clear_flag_at_shutdown($param)
{
    $error = error_get_last();
    if ($error !== null && $error['type'] === E_ERROR && $GLOBALS['instamatic_fatal'] === false) {
        $GLOBALS['instamatic_fatal'] = true;
        $running = array();
        update_option('instamatic_running_list', $running);
        instamatic_log_to_file('[FATAL] Exit error: ' . $error['message'] . ', file: ' . $error['file'] . ', line: ' . $error['line'] . ' - rule ID: ' . $param . '!');
        instamatic_clearFromList($param);
    }
    else
    {
        instamatic_clearFromList($param);
    }
}

function instamatic_strip_links($content)
{
    $content = preg_replace('~<a(?:[^>]*)>~', "", $content);
    $content = preg_replace('~<\/a>~', "", $content);
    return $content;
}

add_filter('the_content', 'instamatic_add_affiliate_keyword');
add_filter('the_excerpt', 'instamatic_add_affiliate_keyword');
function instamatic_add_affiliate_keyword($content)
{
    $rules  = get_option('instamatic_keyword_list');
    if(!is_array($rules))
    {
       $rules = array();
    }
    $output = '';
    if (!empty($rules)) {
        foreach ($rules as $request => $value) {
            if (is_array($value) && isset($value[1]) && $value[1] != '') {
                $repl = $value[1];
            } else {
                $repl = $request;
            }
            if (isset($value[0]) && $value[0] != '') {
                $content = preg_replace('\'(?!((<.*?)|(<a.*?)))(\b' . preg_quote($request, '\'') . '\b)(?!(([^<>]*?)>)|([^>]*?<\/a>))\'i', '<a href="' . esc_url($value[0]) . '" target="_blank">' . esc_html($repl) . '</a>', $content);
            } else {
                $content = preg_replace('\'(?!((<.*?)|(<a.*?)))(\b' . preg_quote($request, '\'') . '\b)(?!(([^<>]*?)>)|([^>]*?<\/a>))\'i', esc_html($repl), $content);
            }
        }
    }
    return $content;
}
add_action('wp_ajax_instamatic_post_now', 'instamatic_instamatic_submit_post_callback');
function instamatic_instamatic_submit_post_callback()
{
    $run_id = $_POST['id'];
    $wp_post = get_post($run_id);
    if($wp_post != null)
    {
        instamatic_do_post($wp_post, true);
    }
    die();
}
add_action('admin_enqueue_scripts', 'instamatic_admin_do_post');
function instamatic_admin_do_post()
{
    wp_enqueue_script('instamatic-poster-script', plugins_url('scripts/postnow.js', __FILE__), array('jquery'), false, true);
}
function instamatic_meta_box_function($post)
{
    wp_register_style('instamatic-browser-style', plugins_url('styles/instamatic-browser.css', __FILE__), false, '1.0.0');
    wp_enqueue_style('instamatic-browser-style');
    wp_suspend_cache_addition(true);
    $index                     = get_post_meta($post->ID, 'instamatic_parent_rule', true);
    $title                     = get_post_meta($post->ID, 'instamatic_item_title', true);
    $cats                      = get_post_meta($post->ID, 'instamatic_extra_categories', true);
    $tags                      = get_post_meta($post->ID, 'instamatic_extra_tags', true);
    $img                       = get_post_meta($post->ID, 'instamatic_featured_img', true);
    $post_img                  = get_post_meta($post->ID, 'instamatic_post_img', true);
    $instamatic_timestamp        = get_post_meta($post->ID, 'instamatic_timestamp', true);
    $instamatic_post_date        = get_post_meta($post->ID, 'instamatic_post_date', true);
    $instamatic_post_url         = get_post_meta($post->ID, 'instamatic_post_url', true);
    $instamatic_post_id          = get_post_meta($post->ID, 'instamatic_post_id', true);
    $instamatic_enable_pingbacks = get_post_meta($post->ID, 'instamatic_enable_pingbacks', true);
    $instamatic_comment_status   = get_post_meta($post->ID, 'instamatic_comment_status', true);
    $instamatic_author           = get_post_meta($post->ID, 'instamatic_author', true);
    $instamatic_author_link      = get_post_meta($post->ID, 'instamatic_author_link', true);
    $ech = '<div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle"><div class="bws_hidden_help_text cr_min_260px">' . esc_html__("Post will be submitted respecting the configurations you made in the \'Posts to Instagram\' plugin menu section.", 'instamatic-instagram-post-generator') . '</div></div>&nbsp;<span id="instamatic_span">' . esc_html__("Manually submit post now:", 'instamatic-instagram-post-generator') . ' </span><br/><br/><form id="instamatic_form"><input class="button button-primary button-large" type="button" name="instamatic_submit_post" id="instamatic_submit_post" value="' . esc_html__('Post To Instagram Now!', 'instamatic-instagram-post-generator') . '" onclick="instamatic_post_now(' . $post->ID . ');"/></form><br/><hr/>';
    if (isset($index) && $index != '') {
        $ech .= '<table class="crf_table"><tr><td><b>' . esc_html__('Post Parent Rule:', 'instamatic-instagram-post-generator') . '</b></td><td>&nbsp;' . esc_html($index) . '</td></tr>';
        $ech .= '<tr><td><b>' . esc_html__('Post Original Title:', 'instamatic-instagram-post-generator') . '</b></td><td>&nbsp;' . esc_html($title) . '</td></tr>';
        if ($instamatic_author != '') {
            $ech .= '<tr><td><b>' . esc_html__('Parent Feed Author:', 'instamatic-instagram-post-generator') . '</b></td><td>&nbsp;' . esc_html($instamatic_author) . '</td></tr>';
        }
        if ($instamatic_author_link != '') {
            $ech .= '<tr><td><b>' . esc_html__('Parent Feed Author URL:', 'instamatic-instagram-post-generator') . '</b></td><td>&nbsp;' . esc_url($instamatic_author_link) . '</td></tr>';
        }
        if ($instamatic_timestamp != '') {
            $ech .= '<tr><td><b>' . esc_html__('Post Creation Date:', 'instamatic-instagram-post-generator') . '</b></td><td>&nbsp;' . esc_html($instamatic_timestamp) . '</td></tr>';
        }
        if ($cats != '') {
            $ech .= '<tr><td><b>' . esc_html__('Post Categories:', 'instamatic-instagram-post-generator') . '</b></td><td>&nbsp;' . esc_html($cats) . '</td></tr>';
        }
        if ($tags != '') {
            $ech .= '<tr><td><b>' . esc_html__('Post Tags:', 'instamatic-instagram-post-generator') . '</b></td><td>&nbsp;' . esc_html($tags) . '</td></tr>';
        }
        if ($img != '') {
            $ech .= '<tr><td><b>' . esc_html__('Featured Image:', 'instamatic-instagram-post-generator') . '</b></td><td>&nbsp;' . esc_url($img) . '</td></tr>';
        }
        if ($post_img != '') {
            $ech .= '<tr><td><b>' . esc_html__('Post Image:', 'instamatic-instagram-post-generator') . '</b></td><td>&nbsp;' . esc_url($post_img) . '</td></tr>';
        }
        if ($instamatic_post_date != '') {
            $ech .= '<tr><td><b>' . esc_html__('Item Source URL Date:', 'instamatic-instagram-post-generator') . '</b></td><td>&nbsp;' . esc_html($instamatic_post_date) . '</td></tr>';
        }
        if ($instamatic_post_url != '') {
            $ech .= '<tr><td><b>' . esc_html__('Item Source URL:', 'instamatic-instagram-post-generator') . '</b></td><td>&nbsp;' . esc_url($instamatic_post_url) . '</td></tr>';
        }
        if ($instamatic_post_id != '') {
            $ech .= '<tr><td><b>' . esc_html__('Item Source Post ID:', 'instamatic-instagram-post-generator') . '</b></td><td>&nbsp;' . esc_html($instamatic_post_id) . '</td></tr>';
        }
        if ($instamatic_enable_pingbacks != '') {
            $ech .= '<tr><td><b>' . esc_html__('Pingback/Trackback Status:', 'instamatic-instagram-post-generator') . '</b></td><td>&nbsp;' . esc_html($instamatic_enable_pingbacks) . '</td></tr>';
        }
        if ($instamatic_comment_status != '') {
            $ech .= '<tr><td><b>' . esc_html__('Comment Status:', 'instamatic-instagram-post-generator') . '</b></td><td>&nbsp;' . esc_html($instamatic_comment_status) . '</td></tr>';
        }
        $ech .= '</table><br/>';
    } else {
        $ech .= esc_html__('This is not an automatically generated post.', 'instamatic-instagram-post-generator');
    }
    echo $ech;
    wp_suspend_cache_addition(false);
}

function instamatic_addPostMeta($post_id, $post, $param, $featured_img)
{
    add_post_meta($post_id, 'instamatic_parent_rule', $param);
    add_post_meta($post_id, 'instamatic_enable_pingbacks', $post['instamatic_enable_pingbacks']);
    add_post_meta($post_id, 'instamatic_comment_status', $post['comment_status']);
    add_post_meta($post_id, 'instamatic_item_title', $post['original_title']);
    add_post_meta($post_id, 'instamatic_extra_categories', $post['extra_categories']);
    add_post_meta($post_id, 'instamatic_extra_tags', $post['extra_tags']);
    add_post_meta($post_id, 'instamatic_post_img', $post['instamatic_post_image']);
    add_post_meta($post_id, 'instamatic_featured_img', $featured_img);
    add_post_meta($post_id, 'instamatic_timestamp', $post['instamatic_timestamp']);
    add_post_meta($post_id, 'instamatic_post_url', $post['instamatic_post_url']);
    add_post_meta($post_id, 'instamatic_post_id', $post['instamatic_post_id']);
    add_post_meta($post_id, 'instamatic_post_date', $post['instamatic_post_date']);
    add_post_meta($post_id, 'instamatic_author', $post['author']);
    add_post_meta($post_id, 'instamatic_author_link', $post['author_link']);
}

function instamatic_require_all($dir) {
    global $wp_filesystem;
    if ( ! is_a( $wp_filesystem, 'WP_Filesystem_Base') ){
        include_once(ABSPATH . 'wp-admin/includes/file.php');$creds = request_filesystem_credentials( site_url() );
        wp_filesystem($creds);
    }
    $scan = glob("$dir/*");
    foreach ($scan as $path) {
        if ($wp_filesystem->is_dir($path)) {
            instamatic_require_all($path);
        }
        elseif (preg_match('/\.php$/', $path)) {
            
            include_once $path;
        }
    }
}
function instamatic_testPhantom()
{
    if(!function_exists('shell_exec')) {
        return 0;
    }
    $disabled = explode(',', ini_get('disable_functions'));
    if(in_array('shell_exec', $disabled))
    {
        return 0;
    }
    $instamatic_Main_Settings = get_option('instamatic_Main_Settings', false);
    if (isset($instamatic_Main_Settings['phantom_path']) && $instamatic_Main_Settings['phantom_path'] != '') 
    {
        $phantomjs_comm = $instamatic_Main_Settings['phantom_path'] . ' ';
    }
    else
    {
        $phantomjs_comm = 'phantomjs ';
    }
    $cmdResult = shell_exec($phantomjs_comm . '-h 2>&1');
    if(stristr($cmdResult, 'Usage') !== false)
    {
        return 1;
    }
    return 0;
}
function instamatic_url_is_image( $url ) {
    $url = str_replace(' ', '%20', $url);
    if ( ! filter_var( $url, FILTER_VALIDATE_URL ) ) {
        return FALSE;
    }
    $ext = array( 'jpeg', 'jpg', 'gif', 'png', 'jpe', 'tif', 'tiff', 'svg', 'ico' , 'webp', 'dds', 'heic', 'psd', 'pspimage', 'tga', 'thm', 'yuv', 'ai', 'eps', 'php');
    $info = (array) pathinfo( parse_url( $url, PHP_URL_PATH ) );
    if(!isset( $info['extension'] ))
    {
        return true;
    }
    return isset( $info['extension'] )
        && in_array( strtolower( $info['extension'] ), $ext, TRUE );
}


function instamatic_generate_featured_image($image_url, $post_id)
{
    global $wp_filesystem;
    $instamatic_Main_Settings = get_option('instamatic_Main_Settings', false);
    $upload_dir = wp_upload_dir();
    if ( ! is_a( $wp_filesystem, 'WP_Filesystem_Base') ){
        include_once(ABSPATH . 'wp-admin/includes/file.php');$creds = request_filesystem_credentials( site_url() );
        wp_filesystem($creds);
    }
    if (isset($instamatic_Main_Settings['no_local_image']) && $instamatic_Main_Settings['no_local_image'] == 'on') {
        
        if(!instamatic_url_is_image($image_url))
        {
            return false;
        }
        
        $file = $upload_dir['basedir'] . '/default_img_rss_echo.jpg';
        if(!$wp_filesystem->exists($file))
        {
            $image_data = instamatic_get_web_page(html_entity_decode(dirname(__FILE__) . "/images/icon.png"));
            if ($image_data === FALSE || strpos($image_data, '<Message>Access Denied</Message>') !== FALSE || strpos($image_data, 'ERROR: The requested URL could not be retrieved') !== FALSE) {
                return false;
            }
            $ret = $wp_filesystem->put_contents($file, $image_data);
            if ($ret === FALSE) {
                return false;
            }
        }
        $need_attach = false;
        $checking_id = get_option('instamatic_attach_id', false);
        if($checking_id === false)
        {
            $need_attach = true;
        }
        else
        {
            $atturl = wp_get_attachment_url($checking_id);
            if($atturl === false)
            {
                $need_attach = true;
            }
        }
        if($need_attach)
        {
            $filename = basename(dirname(__FILE__) . "/images/icon.png");
            $wp_filetype = wp_check_filetype($filename, null);
            if($wp_filetype['type'] == '')
            {
                $wp_filetype['type'] = 'image/png';
            }
            $attachment  = array(
                'post_mime_type' => $wp_filetype['type'],
                'post_title' => sanitize_file_name($filename),
                'post_content' => '',
                'post_status' => 'inherit'
            );
            
            $attach_id   = wp_insert_attachment($attachment, $file, $post_id);
            if ($attach_id === 0) {
                return false;
            }
            update_option('instamatic_attach_id', $attach_id);
            require_once(ABSPATH . 'wp-admin/includes/image.php');
            require_once(ABSPATH . 'wp-admin/includes/media.php');
            $attach_data = wp_generate_attachment_metadata($attach_id, $file);
            wp_update_attachment_metadata($attach_id, $attach_data);
        }
        else
        {
            $attach_id = $checking_id;
        }
        $res2 = set_post_thumbnail($post_id, $attach_id);
        if ($res2 === FALSE) {
            return false;
        }
        
        return true;
    }
    
    if ( ! is_a( $wp_filesystem, 'WP_Filesystem_Base') ){
        include_once(ABSPATH . 'wp-admin/includes/file.php');$creds = request_filesystem_credentials( site_url() );
        wp_filesystem($creds);
    }
    $image_data = $wp_filesystem->get_contents($image_url);
    if ($image_data === FALSE) {
        $image_data = instamatic_get_web_page($image_url);
        if ($image_data === FALSE || strpos($image_data, '<Message>Access Denied</Message>') !== FALSE) {
            return false;
        }
    }
    $filename = basename($image_url);
    $temp     = explode("?", $filename);
    $filename = $temp[0];
    $filename = str_replace('%', '-', $filename);
    $filename = str_replace('#', '-', $filename);
    $filename = str_replace('&', '-', $filename);
    $filename = str_replace('{', '-', $filename);
    $filename = str_replace('}', '-', $filename);
    $filename = str_replace('\\', '-', $filename);
    $filename = str_replace('<', '-', $filename);
    $filename = str_replace('>', '-', $filename);
    $filename = str_replace('*', '-', $filename);
    $filename = str_replace('/', '-', $filename);
    $filename = str_replace('$', '-', $filename);
    $filename = str_replace('\'', '-', $filename);
    $filename = str_replace('"', '-', $filename);
    $filename = str_replace(':', '-', $filename);
    $filename = str_replace('@', '-', $filename);
    $filename = str_replace('+', '-', $filename);
    $filename = str_replace('|', '-', $filename);
    $filename = str_replace('=', '-', $filename);
    $filename = str_replace('`', '-', $filename);
    $filename = stripslashes(preg_replace_callback('#(%[a-zA-Z0-9_]*)#', function($matches){ return rand(0, 9); }, preg_quote($filename)));
    $file_parts = pathinfo($filename);
    $post_title = get_the_title($post_id);
    if($post_title != '')
    {
        $post_title = remove_accents( $post_title );
        $invalid = array(
            ' '   => '-',
            '%20' => '-',
            '_'   => '-',
        );
        $post_title = str_replace( array_keys( $invalid ), array_values( $invalid ), $post_title );
        $post_title = preg_replace('/[\x{1F3F4}](?:\x{E0067}\x{E0062}\x{E0077}\x{E006C}\x{E0073}\x{E007F})|[\x{1F3F4}](?:\x{E0067}\x{E0062}\x{E0073}\x{E0063}\x{E0074}\x{E007F})|[\x{1F3F4}](?:\x{E0067}\x{E0062}\x{E0065}\x{E006E}\x{E0067}\x{E007F})|[\x{1F3F4}](?:\x{200D}\x{2620}\x{FE0F})|[\x{1F3F3}](?:\x{FE0F}\x{200D}\x{1F308})|[\x{0023}\x{002A}\x{0030}\x{0031}\x{0032}\x{0033}\x{0034}\x{0035}\x{0036}\x{0037}\x{0038}\x{0039}](?:\x{FE0F}\x{20E3})|[\x{1F415}](?:\x{200D}\x{1F9BA})|[\x{1F468}\x{1F469}](?:\x{200D}\x{1F467}\x{200D}\x{1F467})|[\x{1F468}\x{1F469}](?:\x{200D}\x{1F467}\x{200D}\x{1F466})|[\x{1F468}\x{1F469}](?:\x{200D}\x{1F467})|[\x{1F468}\x{1F469}](?:\x{200D}\x{1F466}\x{200D}\x{1F466})|[\x{1F468}\x{1F469}](?:\x{200D}\x{1F466})|[\x{1F468}](?:\x{200D}\x{1F468}\x{200D}\x{1F467}\x{200D}\x{1F467})|[\x{1F468}](?:\x{200D}\x{1F468}\x{200D}\x{1F466}\x{200D}\x{1F466})|[\x{1F468}](?:\x{200D}\x{1F468}\x{200D}\x{1F467}\x{200D}\x{1F466})|[\x{1F468}](?:\x{200D}\x{1F468}\x{200D}\x{1F467})|[\x{1F468}](?:\x{200D}\x{1F468}\x{200D}\x{1F466})|[\x{1F468}\x{1F469}](?:\x{200D}\x{1F469}\x{200D}\x{1F467}\x{200D}\x{1F467})|[\x{1F468}\x{1F469}](?:\x{200D}\x{1F469}\x{200D}\x{1F466}\x{200D}\x{1F466})|[\x{1F468}\x{1F469}](?:\x{200D}\x{1F469}\x{200D}\x{1F467}\x{200D}\x{1F466})|[\x{1F468}\x{1F469}](?:\x{200D}\x{1F469}\x{200D}\x{1F467})|[\x{1F468}\x{1F469}](?:\x{200D}\x{1F469}\x{200D}\x{1F466})|[\x{1F469}](?:\x{200D}\x{2764}\x{FE0F}\x{200D}\x{1F469})|[\x{1F469}\x{1F468}](?:\x{200D}\x{2764}\x{FE0F}\x{200D}\x{1F468})|[\x{1F469}](?:\x{200D}\x{2764}\x{FE0F}\x{200D}\x{1F48B}\x{200D}\x{1F469})|[\x{1F469}\x{1F468}](?:\x{200D}\x{2764}\x{FE0F}\x{200D}\x{1F48B}\x{200D}\x{1F468})|[\x{1F468}\x{1F469}](?:\x{200D}\x{1F9BD})|[\x{1F468}\x{1F469}](?:\x{200D}\x{1F9BC})|[\x{1F468}\x{1F469}](?:\x{200D}\x{1F9AF})|[\x{1F575}\x{1F3CC}\x{26F9}\x{1F3CB}](?:\x{FE0F}\x{200D}\x{2640}\x{FE0F})|[\x{1F575}\x{1F3CC}\x{26F9}\x{1F3CB}](?:\x{FE0F}\x{200D}\x{2642}\x{FE0F})|[\x{1F468}\x{1F469}](?:\x{200D}\x{1F692})|[\x{1F468}\x{1F469}](?:\x{200D}\x{1F680})|[\x{1F468}\x{1F469}](?:\x{200D}\x{2708}\x{FE0F})|[\x{1F468}\x{1F469}](?:\x{200D}\x{1F3A8})|[\x{1F468}\x{1F469}](?:\x{200D}\x{1F3A4})|[\x{1F468}\x{1F469}](?:\x{200D}\x{1F4BB})|[\x{1F468}\x{1F469}](?:\x{200D}\x{1F52C})|[\x{1F468}\x{1F469}](?:\x{200D}\x{1F4BC})|[\x{1F468}\x{1F469}](?:\x{200D}\x{1F3ED})|[\x{1F468}\x{1F469}](?:\x{200D}\x{1F527})|[\x{1F468}\x{1F469}](?:\x{200D}\x{1F373})|[\x{1F468}\x{1F469}](?:\x{200D}\x{1F33E})|[\x{1F468}\x{1F469}](?:\x{200D}\x{2696}\x{FE0F})|[\x{1F468}\x{1F469}](?:\x{200D}\x{1F3EB})|[\x{1F468}\x{1F469}](?:\x{200D}\x{1F393})|[\x{1F468}\x{1F469}](?:\x{200D}\x{2695}\x{FE0F})|[\x{1F471}\x{1F64D}\x{1F64E}\x{1F645}\x{1F646}\x{1F481}\x{1F64B}\x{1F9CF}\x{1F647}\x{1F926}\x{1F937}\x{1F46E}\x{1F482}\x{1F477}\x{1F473}\x{1F9B8}\x{1F9B9}\x{1F9D9}\x{1F9DA}\x{1F9DB}\x{1F9DC}\x{1F9DD}\x{1F9DE}\x{1F9DF}\x{1F486}\x{1F487}\x{1F6B6}\x{1F9CD}\x{1F9CE}\x{1F3C3}\x{1F46F}\x{1F9D6}\x{1F9D7}\x{1F3C4}\x{1F6A3}\x{1F3CA}\x{1F6B4}\x{1F6B5}\x{1F938}\x{1F93C}\x{1F93D}\x{1F93E}\x{1F939}\x{1F9D8}](?:\x{200D}\x{2640}\x{FE0F})|[\x{1F468}\x{1F469}](?:\x{200D}\x{1F9B2})|[\x{1F468}\x{1F469}](?:\x{200D}\x{1F9B3})|[\x{1F468}\x{1F469}](?:\x{200D}\x{1F9B1})|[\x{1F468}\x{1F469}](?:\x{200D}\x{1F9B0})|[\x{1F471}\x{1F64D}\x{1F64E}\x{1F645}\x{1F646}\x{1F481}\x{1F64B}\x{1F9CF}\x{1F647}\x{1F926}\x{1F937}\x{1F46E}\x{1F482}\x{1F477}\x{1F473}\x{1F9B8}\x{1F9B9}\x{1F9D9}\x{1F9DA}\x{1F9DB}\x{1F9DC}\x{1F9DD}\x{1F9DE}\x{1F9DF}\x{1F486}\x{1F487}\x{1F6B6}\x{1F9CD}\x{1F9CE}\x{1F3C3}\x{1F46F}\x{1F9D6}\x{1F9D7}\x{1F3C4}\x{1F6A3}\x{1F3CA}\x{1F6B4}\x{1F6B5}\x{1F938}\x{1F93C}\x{1F93D}\x{1F93E}\x{1F939}\x{1F9D8}](?:\x{200D}\x{2642}\x{FE0F})|[\x{1F441}](?:\x{FE0F}\x{200D}\x{1F5E8}\x{FE0F})|[\x{1F1E6}\x{1F1E7}\x{1F1E8}\x{1F1E9}\x{1F1F0}\x{1F1F2}\x{1F1F3}\x{1F1F8}\x{1F1F9}\x{1F1FA}](?:\x{1F1FF})|[\x{1F1E7}\x{1F1E8}\x{1F1EC}\x{1F1F0}\x{1F1F1}\x{1F1F2}\x{1F1F5}\x{1F1F8}\x{1F1FA}](?:\x{1F1FE})|[\x{1F1E6}\x{1F1E8}\x{1F1F2}\x{1F1F8}](?:\x{1F1FD})|[\x{1F1E6}\x{1F1E7}\x{1F1E8}\x{1F1EC}\x{1F1F0}\x{1F1F2}\x{1F1F5}\x{1F1F7}\x{1F1F9}\x{1F1FF}](?:\x{1F1FC})|[\x{1F1E7}\x{1F1E8}\x{1F1F1}\x{1F1F2}\x{1F1F8}\x{1F1F9}](?:\x{1F1FB})|[\x{1F1E6}\x{1F1E8}\x{1F1EA}\x{1F1EC}\x{1F1ED}\x{1F1F1}\x{1F1F2}\x{1F1F3}\x{1F1F7}\x{1F1FB}](?:\x{1F1FA})|[\x{1F1E6}\x{1F1E7}\x{1F1EA}\x{1F1EC}\x{1F1ED}\x{1F1EE}\x{1F1F1}\x{1F1F2}\x{1F1F5}\x{1F1F8}\x{1F1F9}\x{1F1FE}](?:\x{1F1F9})|[\x{1F1E6}\x{1F1E7}\x{1F1EA}\x{1F1EC}\x{1F1EE}\x{1F1F1}\x{1F1F2}\x{1F1F5}\x{1F1F7}\x{1F1F8}\x{1F1FA}\x{1F1FC}](?:\x{1F1F8})|[\x{1F1E6}\x{1F1E7}\x{1F1E8}\x{1F1EA}\x{1F1EB}\x{1F1EC}\x{1F1ED}\x{1F1EE}\x{1F1F0}\x{1F1F1}\x{1F1F2}\x{1F1F3}\x{1F1F5}\x{1F1F8}\x{1F1F9}](?:\x{1F1F7})|[\x{1F1E6}\x{1F1E7}\x{1F1EC}\x{1F1EE}\x{1F1F2}](?:\x{1F1F6})|[\x{1F1E8}\x{1F1EC}\x{1F1EF}\x{1F1F0}\x{1F1F2}\x{1F1F3}](?:\x{1F1F5})|[\x{1F1E6}\x{1F1E7}\x{1F1E8}\x{1F1E9}\x{1F1EB}\x{1F1EE}\x{1F1EF}\x{1F1F2}\x{1F1F3}\x{1F1F7}\x{1F1F8}\x{1F1F9}](?:\x{1F1F4})|[\x{1F1E7}\x{1F1E8}\x{1F1EC}\x{1F1ED}\x{1F1EE}\x{1F1F0}\x{1F1F2}\x{1F1F5}\x{1F1F8}\x{1F1F9}\x{1F1FA}\x{1F1FB}](?:\x{1F1F3})|[\x{1F1E6}\x{1F1E7}\x{1F1E8}\x{1F1E9}\x{1F1EB}\x{1F1EC}\x{1F1ED}\x{1F1EE}\x{1F1EF}\x{1F1F0}\x{1F1F2}\x{1F1F4}\x{1F1F5}\x{1F1F8}\x{1F1F9}\x{1F1FA}\x{1F1FF}](?:\x{1F1F2})|[\x{1F1E6}\x{1F1E7}\x{1F1E8}\x{1F1EC}\x{1F1EE}\x{1F1F2}\x{1F1F3}\x{1F1F5}\x{1F1F8}\x{1F1F9}](?:\x{1F1F1})|[\x{1F1E8}\x{1F1E9}\x{1F1EB}\x{1F1ED}\x{1F1F1}\x{1F1F2}\x{1F1F5}\x{1F1F8}\x{1F1F9}\x{1F1FD}](?:\x{1F1F0})|[\x{1F1E7}\x{1F1E9}\x{1F1EB}\x{1F1F8}\x{1F1F9}](?:\x{1F1EF})|[\x{1F1E6}\x{1F1E7}\x{1F1E8}\x{1F1EB}\x{1F1EC}\x{1F1F0}\x{1F1F1}\x{1F1F3}\x{1F1F8}\x{1F1FB}](?:\x{1F1EE})|[\x{1F1E7}\x{1F1E8}\x{1F1EA}\x{1F1EC}\x{1F1F0}\x{1F1F2}\x{1F1F5}\x{1F1F8}\x{1F1F9}](?:\x{1F1ED})|[\x{1F1E6}\x{1F1E7}\x{1F1E8}\x{1F1E9}\x{1F1EA}\x{1F1EC}\x{1F1F0}\x{1F1F2}\x{1F1F3}\x{1F1F5}\x{1F1F8}\x{1F1F9}\x{1F1FA}\x{1F1FB}](?:\x{1F1EC})|[\x{1F1E6}\x{1F1E7}\x{1F1E8}\x{1F1EC}\x{1F1F2}\x{1F1F3}\x{1F1F5}\x{1F1F9}\x{1F1FC}](?:\x{1F1EB})|[\x{1F1E6}\x{1F1E7}\x{1F1E9}\x{1F1EA}\x{1F1EC}\x{1F1EE}\x{1F1EF}\x{1F1F0}\x{1F1F2}\x{1F1F3}\x{1F1F5}\x{1F1F7}\x{1F1F8}\x{1F1FB}\x{1F1FE}](?:\x{1F1EA})|[\x{1F1E6}\x{1F1E7}\x{1F1E8}\x{1F1EC}\x{1F1EE}\x{1F1F2}\x{1F1F8}\x{1F1F9}](?:\x{1F1E9})|[\x{1F1E6}\x{1F1E8}\x{1F1EA}\x{1F1EE}\x{1F1F1}\x{1F1F2}\x{1F1F3}\x{1F1F8}\x{1F1F9}\x{1F1FB}](?:\x{1F1E8})|[\x{1F1E7}\x{1F1EC}\x{1F1F1}\x{1F1F8}](?:\x{1F1E7})|[\x{1F1E7}\x{1F1E8}\x{1F1EA}\x{1F1EC}\x{1F1F1}\x{1F1F2}\x{1F1F3}\x{1F1F5}\x{1F1F6}\x{1F1F8}\x{1F1F9}\x{1F1FA}\x{1F1FB}\x{1F1FF}](?:\x{1F1E6})|[\x{00A9}\x{00AE}\x{203C}\x{2049}\x{2122}\x{2139}\x{2194}-\x{2199}\x{21A9}-\x{21AA}\x{231A}-\x{231B}\x{2328}\x{23CF}\x{23E9}-\x{23F3}\x{23F8}-\x{23FA}\x{24C2}\x{25AA}-\x{25AB}\x{25B6}\x{25C0}\x{25FB}-\x{25FE}\x{2600}-\x{2604}\x{260E}\x{2611}\x{2614}-\x{2615}\x{2618}\x{261D}\x{2620}\x{2622}-\x{2623}\x{2626}\x{262A}\x{262E}-\x{262F}\x{2638}-\x{263A}\x{2640}\x{2642}\x{2648}-\x{2653}\x{265F}-\x{2660}\x{2663}\x{2665}-\x{2666}\x{2668}\x{267B}\x{267E}-\x{267F}\x{2692}-\x{2697}\x{2699}\x{269B}-\x{269C}\x{26A0}-\x{26A1}\x{26AA}-\x{26AB}\x{26B0}-\x{26B1}\x{26BD}-\x{26BE}\x{26C4}-\x{26C5}\x{26C8}\x{26CE}-\x{26CF}\x{26D1}\x{26D3}-\x{26D4}\x{26E9}-\x{26EA}\x{26F0}-\x{26F5}\x{26F7}-\x{26FA}\x{26FD}\x{2702}\x{2705}\x{2708}-\x{270D}\x{270F}\x{2712}\x{2714}\x{2716}\x{271D}\x{2721}\x{2728}\x{2733}-\x{2734}\x{2744}\x{2747}\x{274C}\x{274E}\x{2753}-\x{2755}\x{2757}\x{2763}-\x{2764}\x{2795}-\x{2797}\x{27A1}\x{27B0}\x{27BF}\x{2934}-\x{2935}\x{2B05}-\x{2B07}\x{2B1B}-\x{2B1C}\x{2B50}\x{2B55}\x{3030}\x{303D}\x{3297}\x{3299}\x{1F004}\x{1F0CF}\x{1F170}-\x{1F171}\x{1F17E}-\x{1F17F}\x{1F18E}\x{1F191}-\x{1F19A}\x{1F201}-\x{1F202}\x{1F21A}\x{1F22F}\x{1F232}-\x{1F23A}\x{1F250}-\x{1F251}\x{1F300}-\x{1F321}\x{1F324}-\x{1F393}\x{1F396}-\x{1F397}\x{1F399}-\x{1F39B}\x{1F39E}-\x{1F3F0}\x{1F3F3}-\x{1F3F5}\x{1F3F7}-\x{1F3FA}\x{1F400}-\x{1F4FD}\x{1F4FF}-\x{1F53D}\x{1F549}-\x{1F54E}\x{1F550}-\x{1F567}\x{1F56F}-\x{1F570}\x{1F573}-\x{1F57A}\x{1F587}\x{1F58A}-\x{1F58D}\x{1F590}\x{1F595}-\x{1F596}\x{1F5A4}-\x{1F5A5}\x{1F5A8}\x{1F5B1}-\x{1F5B2}\x{1F5BC}\x{1F5C2}-\x{1F5C4}\x{1F5D1}-\x{1F5D3}\x{1F5DC}-\x{1F5DE}\x{1F5E1}\x{1F5E3}\x{1F5E8}\x{1F5EF}\x{1F5F3}\x{1F5FA}-\x{1F64F}\x{1F680}-\x{1F6C5}\x{1F6CB}-\x{1F6D2}\x{1F6D5}\x{1F6E0}-\x{1F6E5}\x{1F6E9}\x{1F6EB}-\x{1F6EC}\x{1F6F0}\x{1F6F3}-\x{1F6FA}\x{1F7E0}-\x{1F7EB}\x{1F90D}-\x{1F93A}\x{1F93C}-\x{1F945}\x{1F947}-\x{1F971}\x{1F973}-\x{1F976}\x{1F97A}-\x{1F9A2}\x{1F9A5}-\x{1F9AA}\x{1F9AE}-\x{1F9CA}\x{1F9CD}-\x{1F9FF}\x{1FA70}-\x{1FA73}\x{1FA78}-\x{1FA7A}\x{1FA80}-\x{1FA82}\x{1FA90}-\x{1FA95}]/u', '', $post_title);
        
        $post_title = preg_replace('/\.(?=.*\.)/', '', $post_title);
        $post_title = preg_replace('/-+/', '-', $post_title);
        $post_title = str_replace('-.', '.', $post_title);
        $post_title = strtolower( $post_title );
        if($post_title == '')
        {
            $post_title = uniqid();
        }
        if(isset($file_parts['extension']))
        {
            switch($file_parts['extension'])
            {
                case "":
                $filename = sanitize_title($post_title) . '.jpg';
                break;
                case NULL:
                $filename = sanitize_title($post_title) . '.jpg';
                break;
                default:
                $filename = sanitize_title($post_title) . '.' . $file_parts['extension'];
                break;
            }
        }
        else
        {
            $filename = sanitize_title($post_title) . '.jpg';
        }
    }
    else
    {
        if(isset($file_parts['extension']))
        {
            switch($file_parts['extension'])
            {
                case "":
                if(!instamatic_endsWith($filename, '.jpg'))
                    $filename .= '.jpg';
                break;
                case NULL:
                if(!instamatic_endsWith($filename, '.jpg'))
                    $filename .= '.jpg';
                break;
                default:
                if(!instamatic_endsWith($filename, '.' . $file_parts['extension']))
                    $filename .= '.' . $file_parts['extension'];
                break;
            }
        }
        else
        {
            if(!instamatic_endsWith($filename, '.jpg'))
                $filename .= '.jpg';
        }
    }
    $filename = sanitize_file_name($filename);
    if (wp_mkdir_p($upload_dir['path']))
        $file = $upload_dir['path'] . '/' . $post_id . '-' . $filename;
    else
        $file = $upload_dir['basedir'] . '/' . $post_id . '-' . $filename;
    if ( ! is_a( $wp_filesystem, 'WP_Filesystem_Base') ){
        include_once(ABSPATH . 'wp-admin/includes/file.php');$creds = request_filesystem_credentials( site_url() );
        wp_filesystem($creds);
    }
    $ret = $wp_filesystem->put_contents($file, $image_data);
    if ($ret === FALSE) {
        return false;
    }
    $wp_filetype = wp_check_filetype($filename, null);
    if($wp_filetype['type'] == '')
    {
        $wp_filetype['type'] = 'image/png';
    }
    $attachment  = array(
        'post_mime_type' => $wp_filetype['type'],
        'post_title' => sanitize_file_name($filename),
        'post_content' => '',
        'post_status' => 'inherit'
    );
    
    if ((isset($instamatic_Main_Settings['resize_height']) && $instamatic_Main_Settings['resize_height'] !== '') || (isset($instamatic_Main_Settings['resize_width']) && $instamatic_Main_Settings['resize_width'] !== ''))
    {
        try
        {
            if(!class_exists('\Eventviva\ImageResize')){require_once (dirname(__FILE__) . "/res/ImageResize/ImageResize.php");}
            $imageRes = new ImageResize($file);
            $imageRes->quality_jpg = 98;
            if ((isset($instamatic_Main_Settings['resize_height']) && $instamatic_Main_Settings['resize_height'] !== '') && (isset($instamatic_Main_Settings['resize_width']) && $instamatic_Main_Settings['resize_width'] !== ''))
            {
                $imageRes->resizeToBestFit($instamatic_Main_Settings['resize_width'], $instamatic_Main_Settings['resize_height'], true);
            }
            elseif (isset($instamatic_Main_Settings['resize_width']) && $instamatic_Main_Settings['resize_width'] !== '')
            {
                $imageRes->resizeToWidth($instamatic_Main_Settings['resize_width'], true);
            }
            elseif (isset($instamatic_Main_Settings['resize_height']) && $instamatic_Main_Settings['resize_height'] !== '')
            {
                $imageRes->resizeToHeight($instamatic_Main_Settings['resize_height'], true);
            }
            $imageRes->save($file);
        }
        catch(Exception $e)
        {
            instamatic_log_to_file('Failed to resize featured image: ' . $image_url . ' to sizes ' . $instamatic_Main_Settings['resize_width'] . ' - ' . $instamatic_Main_Settings['resize_height'] . '. Exception thrown ' . esc_html($e->getMessage()) . '!');
        }
    }
    $attach_id   = wp_insert_attachment($attachment, $file, $post_id);
    if ($attach_id === 0) {
        return false;
    }
    require_once(ABSPATH . 'wp-admin/includes/image.php');
    require_once(ABSPATH . 'wp-admin/includes/media.php');
    $attach_data = wp_generate_attachment_metadata($attach_id, $file);
    wp_update_attachment_metadata($attach_id, $attach_data);
    $res2 = set_post_thumbnail($post_id, $attach_id);
    if ($res2 === FALSE) {
        return false;
    }
    $post_title = get_the_title($post_id);
    if($post_title != '')
    {
        update_post_meta($attach_id, '_wp_attachment_image_alt', $post_title);
    }
    return true;
}
function instamatic_endsWith($haystack, $needle)
{
    $length = strlen($needle);
    if ($length == 0) {
        return true;
    }

    return (substr($haystack, -$length) === $needle);
}
function instamatic_hour_diff($date1, $date2)
{
    $date1 = new DateTime($date1, instamatic_get_blog_timezone());
    $date2 = new DateTime($date2, instamatic_get_blog_timezone());
    
    $number1 = (int) $date1->format('U');
    $number2 = (int) $date2->format('U');
    return ($number1 - $number2) / 60;
}

function instamatic_add_hour($date, $hour)
{
    $date1 = new DateTime($date, instamatic_get_blog_timezone());
    $date1->modify("$hour hours");
    $date1 = (array)$date1;
    foreach ($date1 as $key => $value) {
        if ($key == 'date') {
            return $value;
        }
    }
    return $date;
}

function instamatic_minute_diff($date1, $date2)
{
    $date1 = new DateTime($date1, instamatic_get_blog_timezone());
    $date2 = new DateTime($date2, instamatic_get_blog_timezone());
    
    $number1 = (int) $date1->format('U');
    $number2 = (int) $date2->format('U');
    return ($number1 - $number2);
}

function instamatic_add_minute($date, $minute)
{
    $date1 = new DateTime($date, instamatic_get_blog_timezone());
    $date1->modify("$minute minutes");
    $date1 = (array)$date1;
    foreach ($date1 as $key => $value) {
        if ($key == 'date') {
            return $value;
        }
    }
    return $date;
}
function instamatic_get_blog_timezone() {

    $tzstring = get_option( 'timezone_string' );
    $offset   = get_option( 'gmt_offset' );

    if( empty( $tzstring ) && 0 != $offset && floor( $offset ) == $offset ){
        $offset_st = $offset > 0 ? "-$offset" : '+'.absint( $offset );
        $tzstring  = 'Etc/GMT'.$offset_st;
    }
    if( empty( $tzstring ) ){
        $tzstring = 'UTC';
    }
    $timezone = new DateTimeZone( $tzstring );
    return $timezone; 
}
function instamatic_wp_custom_css_files($src, $cont)
{
    wp_enqueue_style('instamatic-thumbnail-css-' . $cont, $src, __FILE__);
}

function instamatic_get_date_now($param = 'now')
{
    $date = new DateTime($param, instamatic_get_blog_timezone());
    $date = (array)$date;
    foreach ($date as $key => $value) {
        if ($key == 'date') {
            return $value;
        }
    }
    return '';
}

function instamatic_create_terms($taxonomy, $parent, $terms_str)
{
    $terms          = explode('/', $terms_str);
    $categories     = array();
    $parent_term_id = $parent;
    foreach ($terms as $term) {
        $res = term_exists($term, $taxonomy, $parent);
        if ($res != NULL && $res != 0 && count($res) > 0 && isset($res['term_id'])) {
            $parent_term_id = $res['term_id'];
            $categories[]   = $parent_term_id;
        } else {
            $new_term = wp_insert_term($term, $taxonomy, array(
                'parent' => $parent
            ));
            if (!is_wp_error( $new_term ) && $new_term != NULL && $new_term != 0 && count($new_term) > 0 && isset($new_term['term_id'])) {
                $parent_term_id = $new_term['term_id'];
                $categories[]   = $parent_term_id;
            }
        }
    }
    
    return $categories;
}
function instamatic_getExcerpt($the_content)
{
    $preview = instamatic_strip_html_tags($the_content);
    $preview = wp_trim_words($preview, 55);
    return $preview;
}

function instamatic_getPlainContent($the_content)
{
    $preview = instamatic_strip_html_tags($the_content);
    $preview = wp_trim_words($preview, 999999);
    return $preview;
}
function instamatic_getItemImage($img, $just_title)
{
    if($just_title == '')
    {
        $just_title = 'image';
    }    
    $preview = '<img src="' . esc_url($img) . '" alt="' . esc_html($just_title) . '" />';
    return $preview;
}
function instamatic_getItemEmbedVideo($video)
{
    if($video != '')
    {
        $preview = '<video class="crf_vido" controls>
  <source src="' . esc_url($video) . '">
Your browser does not support the video tag.
</video>';
    }
    else
    {
        $preview = '';
    }
    return $preview;
}
function instamatic_getItemImageInstagram($url, $description, $user)
{
    $preview = '<blockquote class="instagram-media" data-instgrm-captioned data-instgrm-permalink="' . esc_url($url) . '" data-instgrm-version="12" style=" background:#FFF; border:0; border-radius:3px; box-shadow:0 0 1px 0 rgba(0,0,0,0.5),0 1px 10px 0 rgba(0,0,0,0.15); margin: 1px; max-width:540px; min-width:326px; padding:0; width:99.375%; width:-webkit-calc(100% - 2px); width:calc(100% - 2px);"><div style="padding:16px;"> <a href="' . esc_url($url) . '" style=" background:#FFFFFF; line-height:0; padding:0 0; text-align:center; text-decoration:none; width:100%;" target="_blank"> <div style=" display: flex; flex-direction: row; align-items: center;"> <div style="background-color: #F4F4F4; border-radius: 50%; flex-grow: 0; height: 40px; margin-right: 14px; width: 40px;"></div> <div style="display: flex; flex-direction: column; flex-grow: 1; justify-content: center;"> <div style=" background-color: #F4F4F4; border-radius: 4px; flex-grow: 0; height: 14px; margin-bottom: 6px; width: 100px;"></div> <div style=" background-color: #F4F4F4; border-radius: 4px; flex-grow: 0; height: 14px; width: 60px;"></div></div></div><div style="padding: 19% 0;"></div> <div style="display:block; height:50px; margin:0 auto 12px; width:50px;"><svg width="50px" height="50px" viewBox="0 0 60 60" version="1.1" xmlns="https://www.w3.org/2000/svg" xmlns:xlink="https://www.w3.org/1999/xlink"><g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd"><g transform="translate(-511.000000, -20.000000)" fill="#000000"><g><path d="M556.869,30.41 C554.814,30.41 553.148,32.076 553.148,34.131 C553.148,36.186 554.814,37.852 556.869,37.852 C558.924,37.852 560.59,36.186 560.59,34.131 C560.59,32.076 558.924,30.41 556.869,30.41 M541,60.657 C535.114,60.657 530.342,55.887 530.342,50 C530.342,44.114 535.114,39.342 541,39.342 C546.887,39.342 551.658,44.114 551.658,50 C551.658,55.887 546.887,60.657 541,60.657 M541,33.886 C532.1,33.886 524.886,41.1 524.886,50 C524.886,58.899 532.1,66.113 541,66.113 C549.9,66.113 557.115,58.899 557.115,50 C557.115,41.1 549.9,33.886 541,33.886 M565.378,62.101 C565.244,65.022 564.756,66.606 564.346,67.663 C563.803,69.06 563.154,70.057 562.106,71.106 C561.058,72.155 560.06,72.803 558.662,73.347 C557.607,73.757 556.021,74.244 553.102,74.378 C549.944,74.521 548.997,74.552 541,74.552 C533.003,74.552 532.056,74.521 528.898,74.378 C525.979,74.244 524.393,73.757 523.338,73.347 C521.94,72.803 520.942,72.155 519.894,71.106 C518.846,70.057 518.197,69.06 517.654,67.663 C517.244,66.606 516.755,65.022 516.623,62.101 C516.479,58.943 516.448,57.996 516.448,50 C516.448,42.003 516.479,41.056 516.623,37.899 C516.755,34.978 517.244,33.391 517.654,32.338 C518.197,30.938 518.846,29.942 519.894,28.894 C520.942,27.846 521.94,27.196 523.338,26.654 C524.393,26.244 525.979,25.756 528.898,25.623 C532.057,25.479 533.004,25.448 541,25.448 C548.997,25.448 549.943,25.479 553.102,25.623 C556.021,25.756 557.607,26.244 558.662,26.654 C560.06,27.196 561.058,27.846 562.106,28.894 C563.154,29.942 563.803,30.938 564.346,32.338 C564.756,33.391 565.244,34.978 565.378,37.899 C565.522,41.056 565.552,42.003 565.552,50 C565.552,57.996 565.522,58.943 565.378,62.101 M570.82,37.631 C570.674,34.438 570.167,32.258 569.425,30.349 C568.659,28.377 567.633,26.702 565.965,25.035 C564.297,23.368 562.623,22.342 560.652,21.575 C558.743,20.834 556.562,20.326 553.369,20.18 C550.169,20.033 549.148,20 541,20 C532.853,20 531.831,20.033 528.631,20.18 C525.438,20.326 523.257,20.834 521.349,21.575 C519.376,22.342 517.703,23.368 516.035,25.035 C514.368,26.702 513.342,28.377 512.574,30.349 C511.834,32.258 511.326,34.438 511.181,37.631 C511.035,40.831 511,41.851 511,50 C511,58.147 511.035,59.17 511.181,62.369 C511.326,65.562 511.834,67.743 512.574,69.651 C513.342,71.625 514.368,73.296 516.035,74.965 C517.703,76.634 519.376,77.658 521.349,78.425 C523.257,79.167 525.438,79.673 528.631,79.82 C531.831,79.965 532.853,80.001 541,80.001 C549.148,80.001 550.169,79.965 553.369,79.82 C556.562,79.673 558.743,79.167 560.652,78.425 C562.623,77.658 564.297,76.634 565.965,74.965 C567.633,73.296 568.659,71.625 569.425,69.651 C570.167,67.743 570.674,65.562 570.82,62.369 C570.966,59.17 571,58.147 571,50 C571,41.851 570.966,40.831 570.82,37.631"></path></g></g></g></svg></div><div style="padding-top: 8px;"> <div style=" color:#3897f0; font-family:Arial,sans-serif; font-size:14px; font-style:normal; font-weight:550; line-height:18px;"> ' . esc_html__('View this on Instagram', 'instamatic-instagram-post-generator') . '</div></div><div style="padding: 12.5% 0;"></div> <div style="display: flex; flex-direction: row; margin-bottom: 14px; align-items: center;"><div> <div style="background-color: #F4F4F4; border-radius: 50%; height: 12.5px; width: 12.5px; transform: translateX(0px) translateY(7px);"></div> <div style="background-color: #F4F4F4; height: 12.5px; transform: rotate(-45deg) translateX(3px) translateY(1px); width: 12.5px; flex-grow: 0; margin-right: 14px; margin-left: 2px;"></div> <div style="background-color: #F4F4F4; border-radius: 50%; height: 12.5px; width: 12.5px; transform: translateX(9px) translateY(-18px);"></div></div><div style="margin-left: 8px;"> <div style=" background-color: #F4F4F4; border-radius: 50%; flex-grow: 0; height: 20px; width: 20px;"></div> <div style=" width: 0; height: 0; border-top: 2px solid transparent; border-left: 6px solid #f4f4f4; border-bottom: 2px solid transparent; transform: translateX(16px) translateY(-4px) rotate(30deg)"></div></div><div style="margin-left: auto;"> <div style=" width: 0px; border-top: 8px solid #F4F4F4; border-right: 8px solid transparent; transform: translateY(16px);"></div> <div style=" background-color: #F4F4F4; flex-grow: 0; height: 12px; width: 16px; transform: translateY(-4px);"></div> <div style=" width: 0; height: 0; border-top: 8px solid #F4F4F4; border-left: 8px solid transparent; transform: translateY(-4px) translateX(8px);"></div></div></div></a> <p style=" margin:8px 0 0 0; padding:0 4px;"> <a href="' . esc_url($url) . '" style=" color:#000; font-family:Arial,sans-serif; font-size:14px; font-style:normal; font-weight:normal; line-height:17px; text-decoration:none; word-wrap:break-word;" target="_blank">' . $description . '</a></p> <p style=" color:#c9c8cd; font-family:Arial,sans-serif; font-size:14px; line-height:17px; margin-bottom:0; margin-top:8px; overflow:hidden; padding:8px 0 7px; text-align:center; text-overflow:ellipsis; white-space:nowrap;">' . esc_html__('A post shared by', 'instamatic-instagram-post-generator') . ' @' . $user . '</p></div></blockquote>';
    return $preview;
}

function instamatic_getItemVideo($url, $description, $user)
{
    $preview = '<blockquote class="instagram-media" data-instgrm-captioned data-instgrm-permalink="' . esc_url($url) . '" data-instgrm-version="12" style=" background:#FFF; border:0; border-radius:3px; box-shadow:0 0 1px 0 rgba(0,0,0,0.5),0 1px 10px 0 rgba(0,0,0,0.15); margin: 1px; max-width:540px; min-width:326px; padding:0; width:99.375%; width:-webkit-calc(100% - 2px); width:calc(100% - 2px);"><div style="padding:16px;"> <a href="' . $url . '" style=" background:#FFFFFF; line-height:0; padding:0 0; text-align:center; text-decoration:none; width:100%;" target="_blank"> <div style=" display: flex; flex-direction: row; align-items: center;"> <div style="background-color: #F4F4F4; border-radius: 50%; flex-grow: 0; height: 40px; margin-right: 14px; width: 40px;"></div> <div style="display: flex; flex-direction: column; flex-grow: 1; justify-content: center;"> <div style=" background-color: #F4F4F4; border-radius: 4px; flex-grow: 0; height: 14px; margin-bottom: 6px; width: 100px;"></div> <div style=" background-color: #F4F4F4; border-radius: 4px; flex-grow: 0; height: 14px; width: 60px;"></div></div></div><div style="padding: 19% 0;"></div> <div style="display:block; height:50px; margin:0 auto 12px; width:50px;"><svg width="50px" height="50px" viewBox="0 0 60 60" version="1.1" xmlns="https://www.w3.org/2000/svg" xmlns:xlink="https://www.w3.org/1999/xlink"><g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd"><g transform="translate(-511.000000, -20.000000)" fill="#000000"><g><path d="M556.869,30.41 C554.814,30.41 553.148,32.076 553.148,34.131 C553.148,36.186 554.814,37.852 556.869,37.852 C558.924,37.852 560.59,36.186 560.59,34.131 C560.59,32.076 558.924,30.41 556.869,30.41 M541,60.657 C535.114,60.657 530.342,55.887 530.342,50 C530.342,44.114 535.114,39.342 541,39.342 C546.887,39.342 551.658,44.114 551.658,50 C551.658,55.887 546.887,60.657 541,60.657 M541,33.886 C532.1,33.886 524.886,41.1 524.886,50 C524.886,58.899 532.1,66.113 541,66.113 C549.9,66.113 557.115,58.899 557.115,50 C557.115,41.1 549.9,33.886 541,33.886 M565.378,62.101 C565.244,65.022 564.756,66.606 564.346,67.663 C563.803,69.06 563.154,70.057 562.106,71.106 C561.058,72.155 560.06,72.803 558.662,73.347 C557.607,73.757 556.021,74.244 553.102,74.378 C549.944,74.521 548.997,74.552 541,74.552 C533.003,74.552 532.056,74.521 528.898,74.378 C525.979,74.244 524.393,73.757 523.338,73.347 C521.94,72.803 520.942,72.155 519.894,71.106 C518.846,70.057 518.197,69.06 517.654,67.663 C517.244,66.606 516.755,65.022 516.623,62.101 C516.479,58.943 516.448,57.996 516.448,50 C516.448,42.003 516.479,41.056 516.623,37.899 C516.755,34.978 517.244,33.391 517.654,32.338 C518.197,30.938 518.846,29.942 519.894,28.894 C520.942,27.846 521.94,27.196 523.338,26.654 C524.393,26.244 525.979,25.756 528.898,25.623 C532.057,25.479 533.004,25.448 541,25.448 C548.997,25.448 549.943,25.479 553.102,25.623 C556.021,25.756 557.607,26.244 558.662,26.654 C560.06,27.196 561.058,27.846 562.106,28.894 C563.154,29.942 563.803,30.938 564.346,32.338 C564.756,33.391 565.244,34.978 565.378,37.899 C565.522,41.056 565.552,42.003 565.552,50 C565.552,57.996 565.522,58.943 565.378,62.101 M570.82,37.631 C570.674,34.438 570.167,32.258 569.425,30.349 C568.659,28.377 567.633,26.702 565.965,25.035 C564.297,23.368 562.623,22.342 560.652,21.575 C558.743,20.834 556.562,20.326 553.369,20.18 C550.169,20.033 549.148,20 541,20 C532.853,20 531.831,20.033 528.631,20.18 C525.438,20.326 523.257,20.834 521.349,21.575 C519.376,22.342 517.703,23.368 516.035,25.035 C514.368,26.702 513.342,28.377 512.574,30.349 C511.834,32.258 511.326,34.438 511.181,37.631 C511.035,40.831 511,41.851 511,50 C511,58.147 511.035,59.17 511.181,62.369 C511.326,65.562 511.834,67.743 512.574,69.651 C513.342,71.625 514.368,73.296 516.035,74.965 C517.703,76.634 519.376,77.658 521.349,78.425 C523.257,79.167 525.438,79.673 528.631,79.82 C531.831,79.965 532.853,80.001 541,80.001 C549.148,80.001 550.169,79.965 553.369,79.82 C556.562,79.673 558.743,79.167 560.652,78.425 C562.623,77.658 564.297,76.634 565.965,74.965 C567.633,73.296 568.659,71.625 569.425,69.651 C570.167,67.743 570.674,65.562 570.82,62.369 C570.966,59.17 571,58.147 571,50 C571,41.851 570.966,40.831 570.82,37.631"></path></g></g></g></svg></div><div style="padding-top: 8px;"> <div style=" color:#3897f0; font-family:Arial,sans-serif; font-size:14px; font-style:normal; font-weight:550; line-height:18px;"> ' . esc_html__('View this on Instagram', 'instamatic-instagram-post-generator') . '</div></div><div style="padding: 12.5% 0;"></div> <div style="display: flex; flex-direction: row; margin-bottom: 14px; align-items: center;"><div> <div style="background-color: #F4F4F4; border-radius: 50%; height: 12.5px; width: 12.5px; transform: translateX(0px) translateY(7px);"></div> <div style="background-color: #F4F4F4; height: 12.5px; transform: rotate(-45deg) translateX(3px) translateY(1px); width: 12.5px; flex-grow: 0; margin-right: 14px; margin-left: 2px;"></div> <div style="background-color: #F4F4F4; border-radius: 50%; height: 12.5px; width: 12.5px; transform: translateX(9px) translateY(-18px);"></div></div><div style="margin-left: 8px;"> <div style=" background-color: #F4F4F4; border-radius: 50%; flex-grow: 0; height: 20px; width: 20px;"></div> <div style=" width: 0; height: 0; border-top: 2px solid transparent; border-left: 6px solid #f4f4f4; border-bottom: 2px solid transparent; transform: translateX(16px) translateY(-4px) rotate(30deg)"></div></div><div style="margin-left: auto;"> <div style=" width: 0px; border-top: 8px solid #F4F4F4; border-right: 8px solid transparent; transform: translateY(16px);"></div> <div style=" background-color: #F4F4F4; flex-grow: 0; height: 12px; width: 16px; transform: translateY(-4px);"></div> <div style=" width: 0; height: 0; border-top: 8px solid #F4F4F4; border-left: 8px solid transparent; transform: translateY(-4px) translateX(8px);"></div></div></div></a> <p style=" margin:8px 0 0 0; padding:0 4px;"> <a href="' . $url . '" style=" color:#000; font-family:Arial,sans-serif; font-size:14px; font-style:normal; font-weight:normal; line-height:17px; text-decoration:none; word-wrap:break-word;" target="_blank">' . $description . '</a></p> <p style=" color:#c9c8cd; font-family:Arial,sans-serif; font-size:14px; line-height:17px; margin-bottom:0; margin-top:8px; overflow:hidden; padding:8px 0 7px; text-align:center; text-overflow:ellipsis; white-space:nowrap;">' . esc_html__('A post shared by', 'instamatic-instagram-post-generator') . ' @' . $user . '</p></div></blockquote>';
    return $preview;
}

function instamatic_getReadMoreButton($url)
{
    $link = '';
    if (isset($url)) {
        $link = '<a href="' . esc_url($url) . '" class="button purchase" target="_blank">' . esc_html__('Read More', 'instamatic-instagram-post-generator') . '</a>';
    }
    return $link;
}

add_action('init', 'instamatic_create_taxonomy', 0);
add_action( 'enqueue_block_editor_assets', 'instamatic_enqueue_block_editor_assets' );
function instamatic_enqueue_block_editor_assets() {
	wp_register_style('instamatic-browser-style', plugins_url('styles/instamatic-browser.css', __FILE__), false, '1.0.0');
    wp_enqueue_style('instamatic-browser-style');
	$block_js_display   = 'scripts/display-posts.js';
	wp_enqueue_script(
		'instamatic-display-block-js', 
        plugins_url( $block_js_display, __FILE__ ), 
        array(
			'wp-blocks',
			'wp-i18n',
			'wp-element',
		),
        '1.0.0'
	);
    $block_js_list   = 'scripts/list-posts.js';
	wp_enqueue_script(
		'instamatic-list-block-js', 
        plugins_url( $block_js_list, __FILE__ ), 
        array(
			'wp-blocks',
			'wp-i18n',
			'wp-element',
		),
        '1.0.0'
	);
    $block_js_list   = 'scripts/video-block.js';
	wp_enqueue_script(
		'instamatic-video-block-js', 
        plugins_url( $block_js_list, __FILE__ ), 
        array(
			'wp-blocks',
			'wp-i18n',
			'wp-element',
		),
        '1.0.0'
	);
    $block_js_list   = 'scripts/sidebar.js';
	wp_enqueue_script(
		'instamatic-sidebar-js', 
        plugins_url( $block_js_list, __FILE__ ), 
        array( 'wp-plugins', 'wp-edit-post', 'wp-element', 'wp-data' ),
        '1.0.0'
	);
}
function instamatic_create_taxonomy()
{
    $instamatic_Main_Settings = get_option('instamatic_Main_Settings', false);
    if (isset($instamatic_Main_Settings['instamatic_enabled']) && $instamatic_Main_Settings['instamatic_enabled'] === 'on') {
        if (isset($instamatic_Main_Settings['no_local_image']) && $instamatic_Main_Settings['no_local_image'] == 'on') {
            add_filter('wp_get_attachment_url', 'instamatic_replace_attachment_url', 10, 2);
            add_filter('wp_get_attachment_image_src', 'instamatic_replace_attachment_image_src', 10, 3);
            add_filter('post_thumbnail_html', 'instamatic_thumbnail_external_replace', 10, 6);
        }
    }
    if ( function_exists( 'register_block_type' ) ) {
        register_block_type( 'instamatic-instagram-post-generator/instamatic-display', array(
            'render_callback' => 'instamatic_display_posts_shortcode',
        ) );
        register_block_type( 'instamatic-instagram-post-generator/instamatic-list', array(
            'render_callback' => 'instamatic_list_posts',
        ) );
        register_block_type( 'instamatic-instagram-post-generator/instamatic-video', array(
            'render_callback' => 'instamatic_embed_Instagram_media',
        ) );
    }
    if(!taxonomy_exists('coderevolution_post_source'))
    {
        $labels = array(
            'name' => _x('Post Source', 'taxonomy general name', 'instamatic-instagram-post-generator'),
            'singular_name' => _x('Post Source', 'taxonomy singular name', 'instamatic-instagram-post-generator'),
            'search_items' => esc_html__('Search Post Source', 'instamatic-instagram-post-generator'),
            'popular_items' => esc_html__('Popular Post Source', 'instamatic-instagram-post-generator'),
            'all_items' => esc_html__('All Post Sources', 'instamatic-instagram-post-generator'),
            'parent_item' => null,
            'parent_item_colon' => null,
            'edit_item' => esc_html__('Edit Post Source', 'instamatic-instagram-post-generator'),
            'update_item' => esc_html__('Update Post Source', 'instamatic-instagram-post-generator'),
            'add_new_item' => esc_html__('Add New Post Source', 'instamatic-instagram-post-generator'),
            'new_item_name' => esc_html__('New Post Source Name', 'instamatic-instagram-post-generator'),
            'separate_items_with_commas' => esc_html__('Separate Post Source with commas', 'instamatic-instagram-post-generator'),
            'add_or_remove_items' => esc_html__('Add or remove Post Source', 'instamatic-instagram-post-generator'),
            'choose_from_most_used' => esc_html__('Choose from the most used Post Source', 'instamatic-instagram-post-generator'),
            'not_found' => esc_html__('No Post Sources found.', 'instamatic-instagram-post-generator'),
            'menu_name' => esc_html__('Post Source', 'instamatic-instagram-post-generator')
        );
        
        $args = array(
            'hierarchical' => false,
            'public' => false,
            'show_ui' => false,
            'show_in_menu' => false,
            'description' => 'Post Source',
            'labels' => $labels,
            'show_admin_column' => true,
            'update_count_callback' => '_update_post_term_count',
            'rewrite' => false
        );
        
        $add_post_type = array(
            'post',
            'page'
        );
        $xargs = array(
            'public'   => true,
            '_builtin' => false
        );
        $output = 'names'; 
        $operator = 'and';
        $post_types = get_post_types( $xargs, $output, $operator );
        if ( $post_types ) 
        {
            foreach ( $post_types  as $post_type ) {
                $add_post_type[] = $post_type;
            }
        }
        register_taxonomy('coderevolution_post_source', $add_post_type, $args);
        add_action('pre_get_posts', function($qry) {
            if (is_admin()) return;
            if (is_tax('coderevolution_post_source')){
                $qry->set_404();
            }
        });
    }
}

function instamatic_url_handle($href)
{
    $instamatic_Main_Settings = get_option('instamatic_Main_Settings', false);
    if (isset($instamatic_Main_Settings['links_hide_google']) && $instamatic_Main_Settings['links_hide_google'] == 'on') {
        $cloak_urls = true;
    } else {
        $cloak_urls = false;
    }
    if (isset($instamatic_Main_Settings['gapiKey'])) {
        $apiKey = trim($instamatic_Main_Settings['gapiKey']);
    } else {
        $apiKey = '';
    }
    if ($cloak_urls == true && $apiKey != '') {
        $instamatic_short_group = get_option('instamatic_short_group', false);
        $found = false;
        if($instamatic_short_group !== false)
        {
            $instamatic_short_group = explode('#', $instamatic_short_group);
            if(isset($instamatic_short_group[1]) && $instamatic_short_group[0] == $apiKey)
            {
                $instamatic_short_group = $instamatic_short_group[1];
                $found = true;
            }
        }
        if($found == false)
        {
            $url = 'https://api-ssl.Bitly.com/v4/groups';
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, $url);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

            $headers = [
                'Authorization: Bearer ' . $apiKey,
                'Accept: application/json',
                'Host: api-ssl.Bitly.com'
            ];
            curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
            curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 10);
            curl_setopt($ch, CURLOPT_TIMEOUT, 60);
            $serverOutput = json_decode(curl_exec($ch), true);
            curl_close($ch);
            if(isset($serverOutput['groups'][0]['guid']))
            {
                $instamatic_short_group = $serverOutput['groups'][0]['guid'];
                update_option('instamatic_short_group', false);
                $found = true;
            }
        }
        if($found == false)
        {
            return $href;
        }
        $url = 'https://api-ssl.Bitly.com/v4/shorten';
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 10);
        curl_setopt($ch, CURLOPT_TIMEOUT, 60);
        $headers = [
            'Authorization: Bearer ' . $apiKey,
            'Content-Type: application/json',
            'Host: api-ssl.Bitly.com'
        ];
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_POST, true);
        $fdata = "";
        $data['long_url'] = trim($href);
        $data['group_guid'] = $instamatic_short_group;
        $fdata = json_encode($data);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $fdata);
        $serverOutput = json_decode(curl_exec($ch), true);
        curl_close($ch);
        if (!isset($serverOutput['link']) || $serverOutput['link'] == '') {
            return $href;
        } else {
            return esc_url($serverOutput['link']);
        }  
    } else {
        return $href;
    }
}
function instamatic_post_url_handle($href)
{
    $instamatic_Main_Settings = get_option('instamatic_Main_Settings', false);
    if (isset($instamatic_Main_Settings['links_hide_google2']) && $instamatic_Main_Settings['links_hide_google2'] == 'on') {
        $cloak_urls = true;
    } else {
        $cloak_urls = false;
    }
    if (isset($instamatic_Main_Settings['gapiKey'])) {
        $apiKey = trim($instamatic_Main_Settings['gapiKey']);
    } else {
        $apiKey = '';
    }
    if ($cloak_urls == true && $apiKey != '') {
        $instamatic_short_group = get_option('instamatic_short_group', false);
        $found = false;
        if($instamatic_short_group !== false)
        {
            $instamatic_short_group = explode('#', $instamatic_short_group);
            if(isset($instamatic_short_group[1]) && $instamatic_short_group[0] == $apiKey)
            {
                $instamatic_short_group = $instamatic_short_group[1];
                $found = true;
            }
        }
        if($found == false)
        {
            $url = 'https://api-ssl.Bitly.com/v4/groups';
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, $url);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

            $headers = [
                'Authorization: Bearer ' . $apiKey,
                'Accept: application/json',
                'Host: api-ssl.Bitly.com'
            ];
            curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
            curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 10);
            curl_setopt($ch, CURLOPT_TIMEOUT, 60);
            $serverOutput = json_decode(curl_exec($ch), true);
            curl_close($ch);
            if(isset($serverOutput['groups'][0]['guid']))
            {
                $instamatic_short_group = $serverOutput['groups'][0]['guid'];
                update_option('instamatic_short_group', false);
                $found = true;
            }
        }
        if($found == false)
        {
            return $href;
        }
        $url = 'https://api-ssl.Bitly.com/v4/shorten';
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 10);
        curl_setopt($ch, CURLOPT_TIMEOUT, 60);
        $headers = [
            'Authorization: Bearer ' . $apiKey,
            'Content-Type: application/json',
            'Host: api-ssl.Bitly.com'
        ];
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_POST, true);
        $fdata = "";
        $data['long_url'] = trim($href);
        $data['group_guid'] = $instamatic_short_group;
        $fdata = json_encode($data);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $fdata);
        $serverOutput = json_decode(curl_exec($ch), true);
        curl_close($ch);
        if (!isset($serverOutput['link']) || $serverOutput['link'] == '') {
            return $href;
        } else {
            return esc_url($serverOutput['link']);
        }  
    } else {
        return $href;
    }
}
add_action('wp_loaded', 'instamatic_run_cron', 0);
function instamatic_run_cron()
{
    if(isset($_GET['run_instamatic']))
    {
        $instamatic_Main_Settings = get_option('instamatic_Main_Settings', false);
        if(isset($instamatic_Main_Settings['secret_word']) && $instamatic_Main_Settings['secret_word'] !== '')
        {
            if($_GET['run_instamatic'] == urlencode($instamatic_Main_Settings['secret_word']))
            {
                instamatic_cron();
                die();
            }
            elseif(preg_match('#' . urlencode($instamatic_Main_Settings['secret_word']) . '_(\d)#', $_GET['run_instamatic'], $m))
            {
                if(isset($m[1]))
                {
                    instamatic_run_rule($m[1]);
                    die();
                }
            }
        }            
    }
}
register_activation_hook(__FILE__, 'instamatic_activation_callback');
function instamatic_activation_callback($defaults = FALSE)
{
    if (!get_option('instamatic_posts_per_page') || $defaults === TRUE) {
        if ($defaults === FALSE) {
            add_option('instamatic_posts_per_page', '16');
        } else {
            update_option('instamatic_posts_per_page', '16');
        }
    }
    if (!get_option('instamatic_Main_Settings') || $defaults === TRUE) {
        $instamatic_Main_Settings = array(
            'instamatic_enabled' => 'on',
            'enable_metabox' => 'on',
            'app_id' => '',
            'app_secret' => '',
            'two_code' => '',
            'skip_no_img' => '',
            'gapiKey' => '',
            'links_hide_google2' => '',
            'links_hide_google' => '',
            'skip_old' => '',
            'skip_year' => '',
            'skip_month' => '',
            'skip_day' => '',
            'translate' => 'disabled',
            'translate_source' => 'disabled',
            'custom_html2' => '',
            'custom_html' => '',
            'strip_by_id' => '',
            'strip_by_class' => '',
            'google_trans_auth' => '',
            'sentence_list' => 'This is one %adjective %noun %sentence_ending
This is another %adjective %noun %sentence_ending
I %love_it %nouns , because they are %adjective %sentence_ending
My %family says this plugin is %adjective %sentence_ending
These %nouns are %adjective %sentence_ending',
            'sentence_list2' => 'Meet this %adjective %noun %sentence_ending
This is the %adjective %noun ever %sentence_ending
I %love_it %nouns , because they are the %adjective %sentence_ending
My %family says this plugin is very %adjective %sentence_ending
These %nouns are quite %adjective %sentence_ending',
            'variable_list' => 'adjective_very => %adjective;very %adjective;

adjective => clever;interesting;smart;huge;astonishing;unbelievable;nice;adorable;beautiful;elegant;fancy;glamorous;magnificent;helpful;awesome

noun_with_adjective => %noun;%adjective %noun

noun => plugin;WordPress plugin;item;ingredient;component;constituent;module;add-on;plug-in;addon;extension

nouns => plugins;WordPress plugins;items;ingredients;components;constituents;modules;add-ons;plug-ins;addons;extensions

love_it => love;adore;like;be mad for;be wild about;be nuts about;be crazy about

family => %adjective %family_members;%family_members

family_members => grandpa;brother;sister;mom;dad;grandma

sentence_ending => .;!;!!',
            'auto_clear_logs' => 'No',
            'enable_logging' => 'on',
            'instamatic_Main_Settings' => '',
            'enable_detailed_logging' => '',
            'disable_scripts' => '',
            'rule_timeout' => '3600',
            'strip_links' => '',
            'get_more' => '',
            'email_address' => '',
            'default_types_fb' => '',
            'send_email' => '',
            'rule_delay' => '',
            'best_password' => '',
            'phantom_path' => '',
            'phantom_screen' => '',
            'puppeteer_screen' => '',
            'screenshot_height' => '',
            'screenshot_width' => '',
            'best_user' => '',
            'spin_text' => 'disabled',
            'required_words' => '',
            'banned_words' => '',
            'max_word_content' => '',
            'min_word_content' => '',
            'max_word_title' => '',
            'min_word_title' => '',
            'skip_types' => '',
            'app_encrypt' => 'no',
            'resize_height' => '',
            'resize_width' => '',
            'no_local_image' => '',
            'copy_images' => '',
            'post_source_custom' => '',
            'proxy_url' => '',
            'proxy_auth' => ''
        );
        if ($defaults === FALSE) {
            add_option('instamatic_Main_Settings', $instamatic_Main_Settings);
        } else {
            update_option('instamatic_Main_Settings', $instamatic_Main_Settings);
        }
    }
    if (!get_option('instamatic_Instagram_Settings') || $defaults === TRUE) {
        $instamatic_Instagram_Settings = array(
            'instamatic_posting' => '',
            'run_background' => '',
            'instagram_format' => '%%post_title%% - %%post_link%%',
            'post_posts' => '',
            'post_pages' => '',
            'disabled_categories' => array(),
            'disable_tags' => '',
            'skip_img' => '',
            'always_manual' => 'on',
            'post_custom' => ''
        );
        if ($defaults === FALSE) {
            add_option('instamatic_Instagram_Settings', $instamatic_Instagram_Settings);
        } else {
            update_option('instamatic_Instagram_Settings', $instamatic_Instagram_Settings);
        }
    }
}
function instamatic_encrypt_decrypt($action, $string) {
    //PHP 5.4.9 req
    $output = false;
    $encrypt_method = "AES-256-CBC";
    $secret_key = 'This is my secret key';
    $secret_iv = 'This is my secret iv';
    $key = hash('sha256', $secret_key);
    $iv = substr(hash('sha256', $secret_iv), 0, 16);
    if( $action == 'encrypt' ) {
        $output = openssl_encrypt($string, $encrypt_method, $key, 0, $iv);
        $output = base64_encode($output);
    }
    else if( $action == 'decrypt' ){
        $output = openssl_decrypt(base64_decode($string), $encrypt_method, $key, 0, $iv);
    }
    return $output;
}

add_action('instamatic_new_post_cron', 'instamatic_do_post', 10, 1);
add_action('transition_post_status', 'instamatic_new_post', 10, 3);
function instamatic_new_post($new_status, $old_status, $post)
{
    if ('publish' !== $new_status or 'publish' === $old_status)
    {
        return;
    }
    else
    {
        if($old_status == 'auto-draft' && $new_status == 'publish' && !has_post_thumbnail($post->ID) && ((function_exists('has_blocks') && has_blocks($post)) || ($post->post_content == '' && function_exists('has_blocks') && !class_exists('Classic_Editor'))))
        {
            $delay_it_is_gutenberg = true;
        }
        else
        {
            $delay_it_is_gutenberg = false;
        }
    }
    $instamatic_Main_Settings = get_option('instamatic_Main_Settings', false);
    if (isset($instamatic_Main_Settings['instamatic_enabled']) && $instamatic_Main_Settings['instamatic_enabled'] == 'on') 
    {
        $instamatic_Instagram_Settings = get_option('instamatic_Instagram_Settings', false);
        if (isset($instamatic_Instagram_Settings['instamatic_posting']) && $instamatic_Instagram_Settings['instamatic_posting'] == 'on') {
            if (isset($instamatic_Instagram_Settings['delay_post']) && $instamatic_Instagram_Settings['delay_post'] != '' && is_numeric($instamatic_Instagram_Settings['delay_post'])) {
                if(wp_next_scheduled('instamatic_new_post_cron', array($post)) === false)
                {
                    if($delay_it_is_gutenberg && $instamatic_Instagram_Settings['delay_post'] < 2)
                    {
                        $instamatic_Instagram_Settings['delay_post'] = 2;
                    }
                    wp_schedule_single_event( time() + intval($instamatic_Instagram_Settings['delay_post']), 'instamatic_new_post_cron', array($post) );
                }
            }
            else
            {
                if (isset($instamatic_Instagram_Settings['run_background']) && $instamatic_Instagram_Settings['run_background'] == 'on') {
                    if($delay_it_is_gutenberg)
                    {
                        if(wp_next_scheduled('instamatic_new_post_cron', array($post)) === false)
                        {
                            wp_schedule_single_event( time() + 2, 'instamatic_new_post_cron', array($post) );
                        }
                    }
                    else
                    {
                        $unique_id = uniqid();
                        update_option('instamatic_do_post_uniqid', $unique_id);
                        $xcron_url = site_url( '?instamatic_do_post_cronjob=1&post_id=' . $post->ID . '&instamatic_do_post_key=' . $unique_id);
                        wp_remote_post( $xcron_url, array( 'timeout' => 1, 'blocking' => false, 'sslverify' => false ) );
                    }
                }
                else
                {
                    if($delay_it_is_gutenberg)
                    {
                        if(wp_next_scheduled('instamatic_new_post_cron', array($post)) === false)
                        {
                            wp_schedule_single_event( time() + 2, 'instamatic_new_post_cron', array($post) );
                        }
                    }
                    else
                    {
                        instamatic_do_post($post);
                    }
                }
            }
        }
    }
}
add_action('init', 'instamatic_do_post_callback', 0);
function instamatic_do_post_callback()
{
    $secretp_key = get_option('instamatic_do_post_uniqid', false);
    if (isset($_GET['instamatic_do_post_cronjob']) && $_GET['instamatic_do_post_cronjob'] == '1' && isset($_GET['post_id']) && is_numeric($_GET['post_id']) && $_GET['instamatic_do_post_key'] === $secretp_key)
    {
        $post = get_post($_GET['post_id']);
        if($post !== null)
        {
            instamatic_do_post($post);
            exit();
        }
    }
}

function instamatic_get_excerpt( $content, $length = 20, $more = '...' ) {
	$excerpt = strip_tags( trim( $content ) );
	$words = str_word_count( $excerpt, 2 );
	if ( count( $words ) > $length ) {
		$words = array_slice( $words, 0, $length, true );
		end( $words );
		$position = key( $words ) + strlen( current( $words ) );
		$excerpt = substr( $excerpt, 0, $position ) . $more;
	}
	return $excerpt;
}

function instamatic_do_post($post, $manual = false)
{
    global $wp_filesystem;
    if ( ! is_a( $wp_filesystem, 'WP_Filesystem_Base') ){
        include_once(ABSPATH . 'wp-admin/includes/file.php');$creds = request_filesystem_credentials( site_url() );
        wp_filesystem($creds);
    }
    $instamatic_Main_Settings = get_option('instamatic_Main_Settings', false);
    if (isset($instamatic_Main_Settings['rule_timeout']) && $instamatic_Main_Settings['rule_timeout'] != '') {
        $timeout = intval($instamatic_Main_Settings['rule_timeout']);
    } else {
        $timeout = 3600;
    }
    ini_set('safe_mode', 'Off');
    ini_set('max_execution_time', $timeout);
    ini_set('ignore_user_abort', 1);
    ini_set('user_agent', instamatic_get_random_user_agent());
    ignore_user_abort(true);
    set_time_limit($timeout);
    if (isset($instamatic_Main_Settings['instamatic_enabled']) && $instamatic_Main_Settings['instamatic_enabled'] == 'on') {
        $instamatic_Instagram_Settings = get_option('instamatic_Instagram_Settings', false);
        if ($manual || isset($instamatic_Instagram_Settings['instamatic_posting']) && $instamatic_Instagram_Settings['instamatic_posting'] == 'on') {
            if (!isset($instamatic_Main_Settings['app_id']) || $instamatic_Main_Settings['app_id'] == '') {
                instamatic_log_to_file('Please insert your ID in plugin settings before we can automatically publish on Instagram.');
                return;
            }
            if (!isset($instamatic_Main_Settings['app_secret']) || $instamatic_Main_Settings['app_secret'] == '') {
                instamatic_log_to_file('Please insert your Password in plugin settings before we can automatically publish on Instagram.');
                return;
            }
            if (isset($instamatic_Main_Settings['always_manual']) && $manual == true) {
                $go_manual = true;
            }
            else
            {
                $go_manual = false;
            }
            if (!$manual && isset($instamatic_Instagram_Settings['post_posts'])) {
                if ($go_manual != true && $instamatic_Instagram_Settings['post_posts'] == 'on' && 'post' === $post->post_type) {
                    instamatic_log_to_file('Skip post type: post');
                    return;
                }
            }
            if (!$manual && isset($instamatic_Instagram_Settings['post_pages'])) {
                if ($go_manual != true && $instamatic_Instagram_Settings['post_pages'] == 'on' && 'page' === $post->post_type) {
                    instamatic_log_to_file('Skip post type: page');
                    return;
                }
            }
            if (!$manual && isset($instamatic_Instagram_Settings['post_custom'])) {
                if ($go_manual != true && $instamatic_Instagram_Settings['post_custom'] == 'on' && 'page' != $post->post_type && 'post' != $post->post_type) {
                    instamatic_log_to_file('Skip post type: custom post');
                    return;
                }
            }
            $meta = get_post_meta($post->ID, "instamatic_published", true);
            if (!$manual && $go_manual != true && $meta == 'pub') {
                instamatic_log_to_file('This post was already published before, skipping it.');
                return;
            }
            $post_link = instamatic_post_url_handle(get_permalink($post->ID));
            $post_title       = html_entity_decode($post->post_title);
            $blog_title       = html_entity_decode(get_bloginfo('title'));
            $post_excerpt     = html_entity_decode($post->post_excerpt);
            $post_content     = do_shortcode(html_entity_decode($post->post_content));
            if(function_exists('do_blocks'))
            {
                $post_content     = do_blocks($post_content);
            }
            $post_content = apply_filters( 'the_content', $post_content);
            if($post_excerpt == '')
            {
                $post_excerpt = instamatic_get_excerpt($post_content);
            }
            $post_description = $post_excerpt;
            $author_obj       = get_user_by('id', $post->post_author);
            if(isset($author_obj->user_nicename))
            {
                $user_name        = $author_obj->user_nicename;
            }
            else
            {
                $user_name        = 'Administrator';
            }
            $featured_video = '';
            $featured_image   = '';
            wp_suspend_cache_addition(true);
            $metas = get_post_custom($post->ID);
            wp_suspend_cache_addition(false);
            $rez_meta = instamatic_preg_grep_keys('#.+?_featured_ima?ge?#i', $metas);
            if(count($rez_meta) > 0)
            {
                foreach($rez_meta as $rm)
                {
                    if(isset($rm[0]) && filter_var($rm[0], FILTER_VALIDATE_URL))
                    {
                        $featured_image = $rm[0];
                        break;
                    }
                }
            }
            if($featured_image == '')
            {
                $featured_image = instamatic_generate_thumbmail($post->ID);;
            }
            if($featured_image == '')
            {
                $dom     = new DOMDocument();
                $internalErrors = libxml_use_internal_errors(true);
                $dom->loadHTML($post_content);
                    libxml_use_internal_errors($internalErrors);
                $tags      = $dom->getElementsByTagName('img');
                foreach ($tags as $tag) {
                    $temp_get_img = $tag->getAttribute('src');
                    if ($temp_get_img != '') {
                        $temp_get_img = strtok($temp_get_img, '?');
                        $featured_image = rtrim($temp_get_img, '/');
                    }
                }
            }
            if($featured_image == '' && $featured_video == '')
            {
                instamatic_log_to_file('No featured image found for the post (skipping it): ' . $post->post_title);
                return;
            }
            if(filter_var($featured_image, FILTER_VALIDATE_URL))
            {
                if(isset($_SERVER['HTTP_HOST']) && $_SERVER['HTTP_HOST'] != '' && stristr($featured_image, $_SERVER['HTTP_HOST']) !== false)
                {
                        $featured_image_path = parse_url($featured_image, PHP_URL_PATH);
                        $featured_image = $_SERVER['DOCUMENT_ROOT'] . $featured_image_path;
                }
            }
            if (isset($instamatic_Instagram_Settings['skip_img']) && $instamatic_Instagram_Settings['skip_img'] != '') {
                $skip_img_arr = explode(',', $instamatic_Instagram_Settings['skip_img']);
                foreach($skip_img_arr as $skip_img1)
                {
                    $skip_img1 = trim($skip_img1);
                    if($go_manual != true && stristr($featured_image, $skip_img1) !== false)
                    {
                        instamatic_log_to_file('Featured image in the skipped images list: ' . $post->post_title);
                        return;
                    }
                }
            }
            $post_cats = get_post_meta($post->ID, 'instamatic_post_cats', true);
            if($post_cats == '')
            {
                $post_categories = wp_get_post_categories( $post->ID );
                foreach($post_categories as $c){
                    $cat = get_category( $c );
                    $post_cats .= $cat->name . ',';
                }
                $post_cats = trim($post_cats, ',');
            }
            if($post_cats != '')
            {
                $post_categories = explode(',', $post_cats);
            }
            else
            {
                $post_categories = array();
            }
            if(count($post_categories) == 0)
            {
                $terms = get_the_terms( $post->ID, 'product_cat' );
                if ( ! empty( $terms ) && ! is_wp_error( $terms ) ){
                    foreach ( $terms as $term ) {
                        $post_categories[] = $term->slug;
                    }
                    $post_cats = implode(',', $post_categories);
                }
                
            }
            foreach($post_categories as $pc)
            {
                if (!$manual && isset($instamatic_Instagram_Settings['disabled_categories']) && !empty($instamatic_Instagram_Settings['disabled_categories'])) {
                    foreach($instamatic_Instagram_Settings['disabled_categories'] as $disabled_cat)
                    {
                        if($go_manual != true && trim($pc) == get_cat_name($disabled_cat))
                        {
                            instamatic_log_to_file('Skipping category: ' . $pc);
                            return;
                        }
                    }
                }
            }
            $wp_post_tags = get_the_tags($post->ID);
            $post_tagz = "";
            $post_tagz_cnt = 0;
            if(is_array($wp_post_tags) && count($wp_post_tags) > 0)
            {
                foreach ($wp_post_tags as $tag) {
                    $post_tagz_cnt ++;
                    if ($post_tagz_cnt > 30) {
                        break;
                    }
                    if (!empty($post_tagz)) {
                        $post_tagz .= " ";
                    }
                    $post_tagz .= "#" . preg_replace("/[^ \w]+/", "", $tag->name);
                }
            }
            if($post_tagz != '')
            {
                $post_tags = explode(',', $post_tagz);
            }
            else
            {
                $post_tags = array();
            }
            if(count($post_tags) == 0)
            {
                $terms = get_the_terms( $post->ID, 'product_tag' );
                if ( ! empty( $terms ) && ! is_wp_error( $terms ) ){
                    foreach ( $terms as $term ) {
                        $post_tags[] = $term->slug;
                    }
                    $post_tagz = implode(',', $post_tags);
                }
                
            }
            $post_template    = $instamatic_Instagram_Settings['instagram_format'];
            $post_template    = replaceInstagramPostShortcodes($post_template, $post_link, $post_title, $blog_title, $post_excerpt, $post_content, $user_name, $featured_image, $post_cats, $post_tagz);
            if(strlen($post_template) > 2199)
            {
                $post_template = substr($post_template, 0, 2199);
            }
            foreach($post_tags as $pt)
            {
                if (!$manual && isset($instamatic_Instagram_Settings['disable_tags']) && $instamatic_Instagram_Settings['disable_tags'] != '') {
                    
                    $disable_tags = explode(",", $instamatic_Instagram_Settings['disable_tags']);
                    foreach($disable_tags as $disabled_tag)
                    {
                        if($go_manual != true && trim($pt) == trim($disabled_tag))
                        {
                            instamatic_log_to_file('Skipping tag: ' . $pt);
                            return;
                        }
                    }
                }
            }
            $post_added = false;
            {
                if(!class_exists('\GuzzleHttp\Client') || !class_exists('\Phpfastcache\Helper\Psr16Adapter'))
                {
                    require_once(dirname(__FILE__) . '/res/vendor-old/autoload.php');
                }
                require_once(dirname(__FILE__) . '/res/PHPImage/PHPImage.php');
                require_once(dirname(__FILE__) . "/res/Instagram-post/instagram-photo-video-upload-api.class.php");
                $my_proxy = '';
                if (isset($instamatic_Main_Settings['proxy_url']) && $instamatic_Main_Settings['proxy_url'] != '') 
                {
                    $prx = explode(',', $instamatic_Main_Settings['proxy_url']);
                    $randomness = array_rand($prx);
                    if (isset($instamatic_Main_Settings['proxy_auth']) && $instamatic_Main_Settings['proxy_auth'] != '') 
                    {
                        $prx_auth = explode(',', $instamatic_Main_Settings['proxy_auth']);
                        if(isset($prx_auth[$randomness]) && trim($prx_auth[$randomness]) != '')
                        {
                            $my_proxy = 'http://' . $prx_auth[$randomness] . '@' . $prx[$randomness];
                        }
                        else
                        {
                            $my_proxy = 'http://' . $prx[$randomness];
                        }
                    }
                    else
                    {
                        $my_proxy = 'http://' . $prx[$randomness];
                    }
                }
                $apiInstance = new InstagramLoginPassMethod( trim($instamatic_Main_Settings['app_id']), instamatic_encrypt_decrypt('decrypt', $instamatic_Main_Settings['app_secret']), $my_proxy );
                $rrez = $apiInstance->login();
                if ( isset( $rrez[ 'status' ] ) && $rrez[ 'status' ] === 'fail' )
                {
                    instamatic_log_to_file("Failed to log in to Instagram, please check if your username and password are correct!");
                }
                else
                {
                    if(!isset($rrez[ 'logged_in_user' ][ 'pk' ]))
                    {
                        instamatic_log_to_file("Invalid response from Instagram: " . print_r($rrez, true));
                        return;
                    }
                    $delete_file = false;
                    $restore_img = '';
                    try {
                        if(stristr($featured_image, '.png') !== false)
                        {
                            $featured_image_tmp = instamatic_png2jpg($featured_image);
                            if($featured_image_tmp !== false)
                            {
                                $restore_img = $featured_image;
                                $featured_image = $featured_image_tmp;
                                $delete_file = true;
                            }
                        }
                        $temp_img = $featured_image;
                        $isAscii = true;
                        $len = strlen($featured_image);
                        for ($i = 0; $i < $len; $i++) 
                        {
                            if (ord($featured_image[$i]) > 127) 
                            {
                                $isAscii = false;
                                break;
                            }
                        }
                        if($isAscii == true && !$wp_filesystem->is_file($featured_image))
                        {
                        }
                        else
                        {
                            try
                            {
                                if(!class_exists('\Eventviva\ImageResize')){require_once (dirname(__FILE__) . "/res/ImageResize/ImageResize.php");}
                                $imageRes = new ImageResize($featured_image);
                                $imageRes->quality_jpg = 98;
                                if($imageRes->getSourceWidth() != $imageRes->getSourceHeight())
                                {
                                    $min_ar = 0.5240740740740741;
                                    $max_ar = 1.25;
                                    $img_ar = $imageRes->getSourceHeight() / $imageRes->getSourceWidth();
                                    if($imageRes->getSourceWidth() >= 320 && $imageRes->getSourceWidth() <= 1080 && $img_ar >= $min_ar && $img_ar <= $max_ar)
                                    {
                                        $temp_img = $featured_image;
                                    }
                                    else
                                    {
                                        if(!($imageRes->getSourceWidth() == 1080 && $imageRes->getSourceHeight() == 566) || ($imageRes->getSourceWidth() == 1080 && $imageRes->getSourceHeight() == 1350))
                                        {
                                            if($imageRes->getSourceWidth() > $imageRes->getSourceHeight())
                                            {
                                                $imageRes->resize(1080, 566, true);
                                            }
                                            else
                                            {
                                                $imageRes->resize(1080, 1350, true);
                                            }
                                            $temp_img = get_temp_dir() . 'instamaticimg' . uniqid() . '.jpg';
                                            $imageRes->save($temp_img);
                                        }
                                    }
                                }
                            }
                            catch(Exception $e)
                            {
                                instamatic_log_to_file('Failed to resize image at posting: ' . $e->getMessage());
                            }
                        }
                        $delete = false;
                        if(!$wp_filesystem->exists($temp_img))
                        {
                            $the_temp_img_local = get_temp_dir() . 'instamaticlocal' . uniqid() . '.jpg';
                            instamatic_downloadFile($temp_img, $the_temp_img_local);
                            if($wp_filesystem->exists($the_temp_img_local))
                            {
                                $temp_img = $the_temp_img_local;
                                $delete = true;
                            }
                            try
                            {
                                if(!class_exists('\Eventviva\ImageResize')){require_once (dirname(__FILE__) . "/res/ImageResize/ImageResize.php");}
                                $imageRes = new ImageResize($temp_img);
                                $imageRes->quality_jpg = 98;
                                if($imageRes->getSourceWidth() != $imageRes->getSourceHeight())
                                {
                                    if(!($imageRes->getSourceWidth() == 1080 && $imageRes->getSourceHeight() == 566) || ($imageRes->getSourceWidth() == 1080 && $imageRes->getSourceHeight() == 1350))
                                    {
                                        if($imageRes->getSourceWidth() > $imageRes->getSourceHeight())
                                        {
                                            $imageRes->resize(1080, 566, true);
                                        }
                                        else
                                        {
                                            $imageRes->resize(1080, 1350, true);
                                        }
                                        $temp_img = get_temp_dir() . 'instamaticimg' . uniqid() . '.jpg';
                                        $imageRes->save($temp_img);
                                    }
                                }
                            }
                            catch(Exception $e)
                            {
                                instamatic_log_to_file('Failed to resize image at posting, stage 2: ' . $e->getMessage());
                            }
                        }
                        if (isset($instamatic_Main_Settings['enable_detailed_logging'])) {
                            instamatic_log_to_file('Uploading: ' . $temp_img . ' - template: ' . $post_template);
                        }
                        $za_img = $apiInstance->imageForFeed($temp_img);
                        $ppost = $apiInstance->uploadPhoto( $rrez[ 'logged_in_user' ][ 'pk' ], $za_img, $post_template, $post_link, 'timeline' );
                        if (isset($instamatic_Main_Settings['enable_detailed_logging'])) {
                            instamatic_log_to_file('Result: ' . print_r($ppost, true));
                        }
                        $post_added = TRUE;
                        if($delete == true)
                        {
                            if ($wp_filesystem->exists($temp_img)) {
                                $wp_filesystem->delete($temp_img);
                            }
                        }
                    } catch (Exception $e) {
                        instamatic_log_to_file("Exception while posting media to Instagram for " . $featured_image . ' : ' . $e->getMessage());
                    }
                    if($delete_file == true && $restore_img != '')
                    {
                        if ($wp_filesystem->exists($featured_image)) {
                            $wp_filesystem->delete($featured_image);
                        }
                        $featured_image = $restore_img;
                    }
                }
            }
        }
    }
}
function instamatic_downloadFile($url, $path)
{
    $newfname = $path;
    $file = fopen($url, 'rb');
    if ($file) {
        $newf = fopen($newfname, 'wb');
        if ($newf) {
            while(!feof($file)) {
                fwrite($newf, fread($file, 1024 * 8), 1024 * 8);
            }
        }
    }
    if ($file) {
        fclose($file);
    }
    if ($newf) {
        fclose($newf);
    }
}
function instamatic_png2jpg($filePath, $quality = 100) {
    $image = imagecreatefrompng($filePath);
    if($image === false)
    {
        instamatic_log_to_file('Failed to imagecreatefrompng in instamatic_png2jpg');
        return false;
    }
    $bg = imagecreatetruecolor(imagesx($image), imagesy($image));
    if($bg === false)
    {
        instamatic_log_to_file('Failed to imagecreatetruecolor in instamatic_png2jpg');
        return false;
    }
    $rez = imagefill($bg, 0, 0, imagecolorallocate($bg, 255, 255, 255));
    if($rez === false)
    {
        instamatic_log_to_file('Failed to imagefill in instamatic_png2jpg');
        return false;
    }
    $rez = imagealphablending($bg, TRUE);
    if($rez === false)
    {
        instamatic_log_to_file('Failed to imagealphablending in instamatic_png2jpg');
        return false;
    }
    $rez = imagecopy($bg, $image, 0, 0, 0, 0, imagesx($image), imagesy($image));
    if($rez === false)
    {
        instamatic_log_to_file('Failed to imagecopy in instamatic_png2jpg');
        return false;
    }
    imagedestroy($image);
    $upload_dir = wp_upload_dir();
    if (wp_mkdir_p($upload_dir['path'] . '/instatmp'))
    {
        $rnd_str = instamatic_generateRandomString();
        $filePath = $upload_dir['path'] . '/instatmp/' . $rnd_str . '.jpg';
        $retPath = $upload_dir['url'] . '/instatmp/' . $rnd_str . '.jpg';
    }
    else
    {
        $rnd_str = instamatic_generateRandomString();
        $filePath = $upload_dir['basedir'] . '/instatmp/' . $rnd_str . '.jpg';
        $retPath = $upload_dir['baseurl'] . '/instatmp/' . $rnd_str . '.jpg';
    }
    $rez = imagejpeg($bg, $filePath, $quality);
    if($rez === false)
    {
        instamatic_log_to_file('Failed to imagejpeg in instamatic_png2jpg: ' . $filePath);
        return false;
    }
    imagedestroy($bg);
    return $retPath;
}

function instamatic_generateRandomString($length = 6) {
    $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $charactersLength = strlen($characters);
    $randomString = '';
    for ($i = 0; $i < $length; $i++) {
        $randomString .= $characters[rand(0, $charactersLength - 1)];
    }
    return $randomString;
}


function instamatic_extractThumbnail($content) {
    $att = instamatic_getUrls($content);
    if(count($att) > 0)
    {
        foreach($att as $link)
        {
            $mime = instamatic_get_mime($link);
            if(stristr($mime, "image/") !== FALSE){
                return $link;
            }
        }
    }
    else
    {
        return '';
    }
    return '';
}
function instamatic_generate_thumbmail( $post_id )
    {
        $post = get_post($post_id);
        $post_parent_id = $post->post_parent === 0 ? $post->ID : $post->post_parent;
        
        if ( has_post_thumbnail($post_parent_id) )
        {
            if ($id_attachment = get_post_thumbnail_id($post_parent_id)) {
                $the_image  = wp_get_attachment_url($id_attachment, false);
                return $the_image;
            }
        }
        $attachments = array_values(get_children(array(
            'post_parent' => $post_parent_id, 
            'post_status' => 'inherit', 
            'post_type' => 'attachment', 
            'post_mime_type' => 'image', 
            'order' => 'ASC', 
            'orderby' => 'menu_order ID') 
        ));
        if( sizeof($attachments) > 0 ) {
            $the_image  = wp_get_attachment_url($attachments[0]->ID, false);
            return $the_image;
        }
        $image_url = instamatic_extractThumbnail($post->post_content);
        return $image_url;
    }
function instamatic_IsResourceLocal($url){
    global $wp_filesystem;
    if ( ! is_a( $wp_filesystem, 'WP_Filesystem_Base') ){
        include_once(ABSPATH . 'wp-admin/includes/file.php');$creds = request_filesystem_credentials( site_url() );
        wp_filesystem($creds);
    }
    if( empty( $url ) ){ return false; }
    $urlParsed = parse_url( $url );
    $host = $urlParsed['host'];
    if( empty( $host ) ){ 
        $doc_root = $_SERVER['DOCUMENT_ROOT'];
        $maybefile = $doc_root.$url;
        $fileexists = $wp_filesystem->exists ( $maybefile );
        if( $fileexists ){
            return true;        
        }
    }
    $host = str_replace('www.','',$host);
    $thishost = $_SERVER['HTTP_HOST'];
    $thishost = str_replace('www.','',$thishost);
    if( $host == $thishost ){
        return true;
    }
    return false;
}
function instamatic_getUrls($string) {
    $regex = '/https?\:\/\/[^\"\' \n\s]+/i';
    preg_match_all($regex, $string, $matches);
    return ($matches[0]);
}
function instamatic_get_mime ($filename) {
    $mime_types = array(
        'txt' => 'text/plain',
        'htm' => 'text/html',
        'html' => 'text/html',
        'php' => 'text/html',
        'css' => 'text/css',
        'js' => 'application/javascript',
        'json' => 'application/json',
        'xml' => 'application/xml',
        'swf' => 'application/x-shockwave-flash',
        'flv' => 'video/x-flv',
        'png' => 'image/png',
        'jpe' => 'image/jpeg',
        'jpeg' => 'image/jpeg',
        'jpg' => 'image/jpeg',
        'gif' => 'image/gif',
        'bmp' => 'image/bmp',
        'ico' => 'image/vnd.microsoft.icon',
        'tiff' => 'image/tiff',
        'mts' => 'video/mp2t',
        'tif' => 'image/tiff',
        'svg' => 'image/svg+xml',
        'svgz' => 'image/svg+xml',
        'zip' => 'application/zip',
        'rar' => 'application/x-rar-compressed',
        'exe' => 'application/x-msdownload',
        'msi' => 'application/x-msdownload',
        'cab' => 'application/vnd.ms-cab-compressed',
        'mp3' => 'audio/mpeg',
        'qt' => 'video/quicktime',
        'mov' => 'video/quicktime',
        'wmv' => 'video/x-ms-wmv',
        'mp4' => 'video/mp4',
        'm4p' => 'video/m4p',
        'm4v' => 'video/m4v',
        'mpg' => 'video/mpg',
        'mp2' => 'video/mp2',
        'mpe' => 'video/mpe',
        'mpv' => 'video/mpv',
        'm2v' => 'video/m2v',
        'm4v' => 'video/m4v',
        '3g2' => 'video/3g2',
        '3gpp' => 'video/3gpp',
        'f4v' => 'video/f4v',
        'f4p' => 'video/f4p',
        'f4a' => 'video/f4a',
        'f4b' => 'video/f4b',
        '3gp' => 'video/3gp',
        'avi' => 'video/x-msvideo',
        'mpeg' => 'video/mpeg',
        'mpegps' => 'video/mpeg',
        'webm' => 'video/webm',
        'mpeg4' => 'video/mp4',
        'mkv' => 'video/mkv',
        'pdf' => 'application/pdf',
        'psd' => 'image/vnd.adobe.photoshop',
        'ai' => 'application/postscript',
        'eps' => 'application/postscript',
        'ps' => 'application/postscript',
        'doc' => 'application/msword',
        'rtf' => 'application/rtf',
        'xls' => 'application/vnd.ms-excel',
        'ppt' => 'application/vnd.ms-powerpoint',
        'docx' => 'application/msword',
        'xlsx' => 'application/vnd.ms-excel',
        'pptx' => 'application/vnd.ms-powerpoint',
        'odt' => 'application/vnd.oasis.opendocument.text',
        'ods' => 'application/vnd.oasis.opendocument.spreadsheet',
    );
    $ext = array_values(array_slice(explode('.', $filename), -1));$ext = $ext[0];

    if(stristr($filename, 'dailymotion.com'))
    {
        return 'application/octet-stream';
    }
    if (function_exists('mime_content_type')) {
        error_reporting(0);
        $mimetype = mime_content_type($filename);
        error_reporting(E_ALL);
        if($mimetype == '')
        {
            if (array_key_exists($ext, $mime_types)) {
                return $mime_types[$ext];
            } else {
                return 'application/octet-stream';
            }
        }
        return $mimetype;
    }
    elseif (function_exists('finfo_open')) {
        $finfo = finfo_open(FILEINFO_MIME);
        $mimetype = finfo_file($finfo, $filename);
        finfo_close($finfo);
        if($mimetype === false)
        {
            if (array_key_exists($ext, $mime_types)) {
                return $mime_types[$ext];
            } else {
                return 'application/octet-stream';
            }
        }
        return $mimetype;

    } elseif (array_key_exists($ext, $mime_types)) {
        return $mime_types[$ext];
    } else {
        return 'application/octet-stream';
    }
}
function instamatic_hashtag_text($text)
{
    $text = '#' . $text;
    $text = str_replace(' ', ' #', $text);
    return $text;
}
function replaceInstagramPostShortcodes($content, $post_link, $post_title, $blog_title, $post_excerpt, $post_content, $user_name, $featured_image, $post_cats, $post_tagz)
{
    $matches = array();
    $i = 0;
    preg_match_all('~%regex\(\s*\"([^"]+?)\s*"\s*[,;]\s*\"([^"]*)\"\s*(?:[,;]\s*\"([^"]*?)\s*\")?(?:[,;]\s*\"([^"]*?)\s*\")?(?:[,;]\s*\"([^"]*?)\s*\")?\)%~si', $content, $matches);
    if (is_array($matches) && count($matches) && is_array($matches[0])) {
        for($i = 0; $i < count($matches[0]); $i++)
        {
            if (isset($matches[0][$i])) $fullmatch = $matches[0][$i];
            if (isset($matches[1][$i])) $search_in = replaceInstagramPostShortcodes($matches[1][$i], $post_link, $post_title, $blog_title, $post_excerpt, $post_content, $user_name, $featured_image, $post_cats, $post_tagz);
            if (isset($matches[2][$i])) $matchpattern = $matches[2][$i];
            if (isset($matches[3][$i])) $element = $matches[3][$i];
            if (isset($matches[4][$i])) $delimeter = $matches[4][$i];if (isset($matches[5][$i])) $counter = $matches[5][$i];
            if (isset($matchpattern)) {
               if (preg_match('<^[\/#%+~[\]{}][\s\S]*[\/#%+~[\]{}]$>', $matchpattern, $z)) {
                  $ret = preg_match_all($matchpattern, $search_in, $submatches, PREG_PATTERN_ORDER);
               }
               else {
                  $ret = preg_match_all('~'.$matchpattern.'~si', $search_in, $submatches, PREG_PATTERN_ORDER);
               }
            }
            if (isset($submatches)) {
               if (is_array($submatches)) {
                  $empty_elements = array_keys($submatches[0], "");
                  foreach ($empty_elements as $e) {
                     unset($submatches[0][$e]);
                  }
                  $submatches[0] = array_unique($submatches[0]);
                  if (!is_numeric($element)) {
                     $element = 0;
                  }if (!is_numeric($counter)) {
                     $counter = 0;
                  }
                  if(isset($submatches[(int)($element)]))
                  {
                      $matched = $submatches[(int)($element)];
                  }
                  else
                  {
                      $matched = '';
                  }
                  $matched = array_unique((array)$matched);
                  if (empty($delimeter) || $delimeter == 'null') {
                     if (isset($matched[$counter])) $matched = $matched[$counter];
                  }
                  else {
                     $matched = implode($delimeter, $matched);
                  }
                  if (empty($matched)) {
                     $content = str_replace($fullmatch, '', $content);
                  } else {
                     $content = str_replace($fullmatch, $matched, $content);
                  }
               }
            }
        }
    }
    $spintax = new Instamatic_Spintax();
    $content = $spintax->process($content);
    $pcxxx = explode('<!- template ->', $content);
    $content = $pcxxx[array_rand($pcxxx)];
    $content = str_replace('%%random_sentence%%', instamatic_random_sentence_generator(), $content);
    $content = str_replace('%%random_sentence2%%', instamatic_random_sentence_generator(false), $content);
    $content = instamatic_replaceSynergyShortcodes($content);
    $content = str_replace('%%post_link%%', $post_link, $content);
    $content = str_replace('%%post_title%%', $post_title, $content);
    $content = str_replace('%%post_title_hashtags%%', instamatic_hashtag_text($post_title), $content);
    $content = str_replace('%%blog_title%%', $blog_title, $content);
    $content = str_replace('%%post_excerpt%%', $post_excerpt, $content);
    $content = str_replace('%%post_content%%', strip_tags($post_content), $content);
    $content = str_replace('%%author_name%%', $user_name, $content);
    $content = str_replace('%%featured_image%%', $featured_image, $content);
    $content = str_replace('%%post_cats%%', $post_cats, $content);
    $content = str_replace('%%post_tags%%', $post_tagz, $content);
    $item_hash = instamatic_extractKeyWords($post_title, 3);
    $smart_hash = '';
    foreach ($item_hash as $ih)
    {
        $smart_hash .= '#' . esc_html($ih) . ' ';
    }
    $smart_hash = trim($smart_hash);
    $content = str_replace('%%smart_hashtags%%', $smart_hash, $content);
    return $content;
}

function instamatic_spin_text($title, $content, $alt = false)
{
    $instamatic_Main_Settings = get_option('instamatic_Main_Settings', false);
    $titleSeparator         = '[19459000]';
    $text                   = $title . ' ' . $titleSeparator . ' ' . $content;
    $text                   = html_entity_decode($text);
    preg_match_all("/<[^<>]+>/is", $text, $matches, PREG_PATTERN_ORDER);
    $htmlfounds         = array_filter(array_unique($matches[0]));
    $htmlfounds[]       = '&quot;';
    $imgFoundsSeparated = array();
    foreach ($htmlfounds as $key => $currentFound) {
        if (stristr($currentFound, '<img') && stristr($currentFound, 'alt')) {
            $altSeparator   = '';
            $colonSeparator = '';
            if (stristr($currentFound, 'alt="')) {
                $altSeparator   = 'alt="';
                $colonSeparator = '"';
            } elseif (stristr($currentFound, 'alt = "')) {
                $altSeparator   = 'alt = "';
                $colonSeparator = '"';
            } elseif (stristr($currentFound, 'alt ="')) {
                $altSeparator   = 'alt ="';
                $colonSeparator = '"';
            } elseif (stristr($currentFound, 'alt= "')) {
                $altSeparator   = 'alt= "';
                $colonSeparator = '"';
            } elseif (stristr($currentFound, 'alt=\'')) {
                $altSeparator   = 'alt=\'';
                $colonSeparator = '\'';
            } elseif (stristr($currentFound, 'alt = \'')) {
                $altSeparator   = 'alt = \'';
                $colonSeparator = '\'';
            } elseif (stristr($currentFound, 'alt= \'')) {
                $altSeparator   = 'alt= \'';
                $colonSeparator = '\'';
            } elseif (stristr($currentFound, 'alt =\'')) {
                $altSeparator   = 'alt =\'';
                $colonSeparator = '\'';
            }
            if (trim($altSeparator) != '') {
                $currentFoundParts = explode($altSeparator, $currentFound);
                $preAlt            = $currentFoundParts[1];
                $preAltParts       = explode($colonSeparator, $preAlt);
                $altText           = $preAltParts[0];
                if (trim($altText) != '') {
                    unset($preAltParts[0]);
                    $imgFoundsSeparated[] = $currentFoundParts[0] . $altSeparator;
                    $imgFoundsSeparated[] = $colonSeparator . implode('', $preAltParts);
                    $htmlfounds[$key]     = '';
                }
            }
        }
    }
    if (count($imgFoundsSeparated) != 0) {
        $htmlfounds = array_merge($htmlfounds, $imgFoundsSeparated);
    }
    preg_match_all("/<\!--.*?-->/is", $text, $matches2, PREG_PATTERN_ORDER);
    $newhtmlfounds = $matches2[0];
    preg_match_all("/\[.*?\]/is", $text, $matches3, PREG_PATTERN_ORDER);
    $shortcodesfounds = $matches3[0];
    $htmlfounds       = array_merge($htmlfounds, $newhtmlfounds, $shortcodesfounds);
    $in               = 0;
    $cleanHtmlFounds  = array();
    foreach ($htmlfounds as $htmlfound) {
        if ($htmlfound == '[19459000]') {
        } elseif (trim($htmlfound) == '') {
        } else {
            $cleanHtmlFounds[] = $htmlfound;
        }
    }
    $htmlfounds = $cleanHtmlFounds;
    $start      = 19459001;
    foreach ($htmlfounds as $htmlfound) {
        $text = str_replace($htmlfound, '[' . $start . ']', $text);
        $start++;
    }
    try {
        require_once(dirname(__FILE__) . "/res/instamatic-text-spinner.php");
        $phpTextSpinner = new PhpTextSpinner();
        if ($alt === FALSE) {
            $spinContent = $phpTextSpinner->spinContent($text);
        } else {
            $spinContent = $phpTextSpinner->spinContentAlt($text);
        }
        $translated = $phpTextSpinner->runTextSpinner($spinContent);
    }
    catch (Exception $e) {
        if (isset($instamatic_Main_Settings['enable_detailed_logging'])) {
            instamatic_log_to_file('Exception thrown in spinText ' . $e);
        }
        return false;
    }
    preg_match_all('{\[.*?\]}', $translated, $brackets);
    $brackets = $brackets[0];
    $brackets = array_unique($brackets);
    foreach ($brackets as $bracket) {
        if (stristr($bracket, '19')) {
            $corrrect_bracket = str_replace(' ', '', $bracket);
            $corrrect_bracket = str_replace('.', '', $corrrect_bracket);
            $corrrect_bracket = str_replace(',', '', $corrrect_bracket);
            $translated       = str_replace($bracket, $corrrect_bracket, $translated);
        }
    }
    if (stristr($translated, $titleSeparator)) {
        $start = 19459001;
        foreach ($htmlfounds as $htmlfound) {
            $translated = str_replace('[' . $start . ']', $htmlfound, $translated);
            $start++;
        }
        $contents = explode($titleSeparator, $translated);
        $title    = $contents[0];
        $content  = $contents[1];
    } else {
        if (isset($instamatic_Main_Settings['enable_detailed_logging'])) {
            instamatic_log_to_file('Failed to parse spinned content, separator not found');
        }
        return false;
    }
    return array(
        $title,
        $content
    );
}

function instamatic_builtin_spin_text($title, $content)
{
    $instamatic_Main_Settings = get_option('instamatic_Main_Settings', false);
    $titleSeparator         = '[19459000]';
    $text                   = $title . ' ' . $titleSeparator . ' ' . $content;
    $text                   = html_entity_decode($text);
    preg_match_all("/<[^<>]+>/is", $text, $matches, PREG_PATTERN_ORDER);
    $htmlfounds         = array_filter(array_unique($matches[0]));
    $htmlfounds[]       = '&quot;';
    $imgFoundsSeparated = array();
    foreach ($htmlfounds as $key => $currentFound) {
        if (stristr($currentFound, '<img') && stristr($currentFound, 'alt')) {
            $altSeparator   = '';
            $colonSeparator = '';
            if (stristr($currentFound, 'alt="')) {
                $altSeparator   = 'alt="';
                $colonSeparator = '"';
            } elseif (stristr($currentFound, 'alt = "')) {
                $altSeparator   = 'alt = "';
                $colonSeparator = '"';
            } elseif (stristr($currentFound, 'alt ="')) {
                $altSeparator   = 'alt ="';
                $colonSeparator = '"';
            } elseif (stristr($currentFound, 'alt= "')) {
                $altSeparator   = 'alt= "';
                $colonSeparator = '"';
            } elseif (stristr($currentFound, 'alt=\'')) {
                $altSeparator   = 'alt=\'';
                $colonSeparator = '\'';
            } elseif (stristr($currentFound, 'alt = \'')) {
                $altSeparator   = 'alt = \'';
                $colonSeparator = '\'';
            } elseif (stristr($currentFound, 'alt= \'')) {
                $altSeparator   = 'alt= \'';
                $colonSeparator = '\'';
            } elseif (stristr($currentFound, 'alt =\'')) {
                $altSeparator   = 'alt =\'';
                $colonSeparator = '\'';
            }
            if (trim($altSeparator) != '') {
                $currentFoundParts = explode($altSeparator, $currentFound);
                $preAlt            = $currentFoundParts[1];
                $preAltParts       = explode($colonSeparator, $preAlt);
                $altText           = $preAltParts[0];
                if (trim($altText) != '') {
                    unset($preAltParts[0]);
                    $imgFoundsSeparated[] = $currentFoundParts[0] . $altSeparator;
                    $imgFoundsSeparated[] = $colonSeparator . implode('', $preAltParts);
                    $htmlfounds[$key]     = '';
                }
            }
        }
    }
    if (count($imgFoundsSeparated) != 0) {
        $htmlfounds = array_merge($htmlfounds, $imgFoundsSeparated);
    }
    preg_match_all("/<\!--.*?-->/is", $text, $matches2, PREG_PATTERN_ORDER);
    $newhtmlfounds = $matches2[0];
    preg_match_all("/\[.*?\]/is", $text, $matches3, PREG_PATTERN_ORDER);
    $shortcodesfounds = $matches3[0];
    $htmlfounds       = array_merge($htmlfounds, $newhtmlfounds, $shortcodesfounds);
    $in               = 0;
    $cleanHtmlFounds  = array();
    foreach ($htmlfounds as $htmlfound) {
        if ($htmlfound == '[19459000]') {
        } elseif (trim($htmlfound) == '') {
        } else {
            $cleanHtmlFounds[] = $htmlfound;
        }
    }
    $htmlfounds = $cleanHtmlFounds;
    $start      = 19459001;
    foreach ($htmlfounds as $htmlfound) {
        $text = str_replace($htmlfound, '[' . $start . ']', $text);
        $start++;
    }
    try {
        $file=file(dirname(__FILE__)  .'/res/synonyms.dat');
		foreach($file as $line){
			$synonyms=explode('|',$line);
			foreach($synonyms as $word){
				if(trim($word) != ''){
                    $word=str_replace('/','\/',$word);
					if(preg_match('/\b'. $word .'\b/u', $text)) {
						$rand = array_rand($synonyms, 1);
						$text = preg_replace('/\b'.$word.'\b/u', trim($synonyms[$rand]), $text);
					}
                    $uword=ucfirst($word);
					if(preg_match('/\b'. $uword .'\b/u', $text)) {
						$rand = array_rand($synonyms, 1);
						$text = preg_replace('/\b'.$uword.'\b/u', ucfirst(trim($synonyms[$rand])), $text);
					}
				}
			}
		}
        $translated = $text;
    }
    catch (Exception $e) {
        if (isset($instamatic_Main_Settings['enable_detailed_logging'])) {
            instamatic_log_to_file('Exception thrown in spinText ' . $e);
        }
        return false;
    }
    preg_match_all('{\[.*?\]}', $translated, $brackets);
    $brackets = $brackets[0];
    $brackets = array_unique($brackets);
    foreach ($brackets as $bracket) {
        if (stristr($bracket, '19')) {
            $corrrect_bracket = str_replace(' ', '', $bracket);
            $corrrect_bracket = str_replace('.', '', $corrrect_bracket);
            $corrrect_bracket = str_replace(',', '', $corrrect_bracket);
            $translated       = str_replace($bracket, $corrrect_bracket, $translated);
        }
    }
    if (stristr($translated, $titleSeparator)) {
        $start = 19459001;
        foreach ($htmlfounds as $htmlfound) {
            $translated = str_replace('[' . $start . ']', $htmlfound, $translated);
            $start++;
        }
        $contents = explode($titleSeparator, $translated);
        $title    = $contents[0];
        $content  = $contents[1];
    } else {
        if (isset($instamatic_Main_Settings['enable_detailed_logging'])) {
            instamatic_log_to_file('Failed to parse spinned content, separator not found');
        }
        return false;
    }
    return array(
        $title,
        $content
    );
}

function instamatic_best_spin_text($title, $content)
{
    $instamatic_Main_Settings = get_option('instamatic_Main_Settings', false);
    if (!isset($instamatic_Main_Settings['best_user']) || $instamatic_Main_Settings['best_user'] == '' || !isset($instamatic_Main_Settings['best_password']) || $instamatic_Main_Settings['best_password'] == '') {
        instamatic_log_to_file('Please insert a valid "The Best Spinner" user name and password.');
        return FALSE;
    }
    $titleSeparator   = '[19459000]';
    $newhtml             = $title . ' ' . $titleSeparator . ' ' . $content;
    $url              = 'http://thebestspinner.com/api.php';
    $data             = array();
    $data['action']   = 'authenticate';
    $data['format']   = 'php';
    $data['username'] = $instamatic_Main_Settings['best_user'];
    $data['password'] = $instamatic_Main_Settings['best_password'];
    $ch               = curl_init();
    if ($ch === FALSE) {
        if (isset($instamatic_Main_Settings['enable_detailed_logging'])) {
            instamatic_log_to_file('Failed to init curl!');
        }
        return FALSE;
    }
    curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 10);
    curl_setopt($ch, CURLOPT_TIMEOUT, 60);
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_POST, true);
    $fdata = "";
    foreach ($data as $key => $val) {
        $fdata .= "$key=" . urlencode($val) . "&";
    }
    curl_setopt($ch, CURLOPT_POSTFIELDS, $fdata);
    curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_REFERER, $url);
    $html = curl_exec($ch);
    curl_close($ch);
    if ($html === FALSE) {
        if (isset($instamatic_Main_Settings['enable_detailed_logging'])) {
            instamatic_log_to_file('"The Best Spinner" failed to exec curl.');
        }
        return FALSE;
    }
    $output = unserialize($html);
    if ($output['success'] == 'true') {
        $session                = $output['session'];
        $data                   = array();
        $data['session']        = $session;
        $data['format']         = 'php';
        $data['protectedterms'] = '';
        $data['action']         = 'replaceEveryonesFavorites';
        $data['maxsyns']        = '100';
        $data['quality']        = '1';
        $ch = curl_init();
        if ($ch === FALSE) {
            if (isset($instamatic_Main_Settings['enable_detailed_logging'])) {
                instamatic_log_to_file('Failed to init curl');
            }
            return FALSE;
        }
        $newhtml = html_entity_decode($newhtml);
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 10);
        curl_setopt($ch, CURLOPT_TIMEOUT, 60);
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_REFERER, $url);
        $spinned = '';
        if(str_word_count($newhtml) > 4000)
        {
            while($newhtml != '')
            {
                $first30k = substr($newhtml, 0, 30000);
                $first30k = rtrim($first30k, '(*');
                $first30k = ltrim($first30k, ')*');
                $newhtml = substr($newhtml, 30000);
                $data['text']           = $first30k;
                $fdata = "";
                foreach ($data as $key => $val) {
                    $fdata .= "$key=" . urlencode($val) . "&";
                }
                curl_setopt($ch, CURLOPT_POSTFIELDS, $fdata);
                $output = curl_exec($ch);
                if ($output === FALSE) {
                    if (isset($instamatic_Main_Settings['enable_detailed_logging'])) {
                        instamatic_log_to_file('"The Best Spinner" failed to exec curl after auth.');
                    }
                    return FALSE;
                }
                $output = unserialize($output);
                if ($output['success'] == 'true') {
                    $spinned .= ' ' . $output['output'];
                } else {
                    if (isset($instamatic_Main_Settings['enable_detailed_logging'])) {
                        instamatic_log_to_file('"The Best Spinner" failed to spin article.');
                    }
                    return FALSE;
                }
            }
        }
        else
        {
            $data['text'] = $newhtml;
            $fdata = "";
            foreach ($data as $key => $val) {
                $fdata .= "$key=" . urlencode($val) . "&";
            }
            curl_setopt($ch, CURLOPT_POSTFIELDS, $fdata);
            $output = curl_exec($ch);
            if ($output === FALSE) {
                if (isset($instamatic_Main_Settings['enable_detailed_logging'])) {
                    instamatic_log_to_file('"The Best Spinner" failed to exec curl after auth.');
                }
                return FALSE;
            }
            $output = unserialize($output);
            if ($output['success'] == 'true') {
                $spinned = $output['output'];
            } else {
                if (isset($instamatic_Main_Settings['enable_detailed_logging'])) {
                    instamatic_log_to_file('"The Best Spinner" failed to spin article: ' . print_r($output, true));
                }
                return FALSE;
            }
        }
        curl_close($ch);
        $result = explode($titleSeparator, $spinned);
        if (count($result) < 2) {
            if (isset($instamatic_Main_Settings['enable_detailed_logging'])) {
                instamatic_log_to_file('"The Best Spinner" failed to spin article - titleseparator not found.' . print_r($output, true));
            }
            return FALSE;
        }
        $spintax = new Instamatic_Spintax();
        $result[0] = $spintax->process($result[0]);
        $result[1] = $spintax->process($result[1]);
        return $result;

    } else {
        if (isset($instamatic_Main_Settings['enable_detailed_logging'])) {
            instamatic_log_to_file('"The Best Spinner" authentification failed.');
        }
        return FALSE;
    }
}
class Instamatic_Spintax
{
    public function process($text)
    {
        return stripslashes(preg_replace_callback(
            '/\{(((?>[^\{\}]+)|(?R))*)\}/x',
            array($this, 'replace'),
            preg_quote($text)
        ));
    }
    public function replace($text)
    {
        $text = $this->process($text[1]);
        $parts = explode('|', $text);
        return $parts[array_rand($parts)];
    }
}

function instamatic_wordai_spin_text($title, $content)
{
    $instamatic_Main_Settings = get_option('instamatic_Main_Settings', false);
    if (!isset($instamatic_Main_Settings['best_user']) || $instamatic_Main_Settings['best_user'] == '' || !isset($instamatic_Main_Settings['best_password']) || $instamatic_Main_Settings['best_password'] == '') {
        instamatic_log_to_file('Please insert a valid "Wordai" user name and password.');
        return FALSE;
    }
    $titleSeparator   = '[19459000]';
    $quality = 'Readable';
    $html             = $title . ' ' . $titleSeparator . ' ' . $content;
    $email = $instamatic_Main_Settings['best_user'];
    $pass = $instamatic_Main_Settings['best_password'];
    $html = urlencode($html);
    $ch = curl_init('https://wai.wordai.com/api/rewrite');
    if($ch === false)
    {
        instamatic_log_to_file('Failed to init curl in wordai spinning.');
        return FALSE;
    }
    curl_setopt ($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt ($ch, CURLOPT_POST, 1);
    curl_setopt ($ch, CURLOPT_POSTFIELDS, "input=$html&uniqueness=2&rewrite_num=4&return_rewrites=true&email=$email&key=$pass");
	curl_setopt ($ch, CURLOPT_SSL_VERIFYHOST, 0);
    curl_setopt ($ch, CURLOPT_SSL_VERIFYPEER, 0);
    curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 10);
    curl_setopt($ch, CURLOPT_TIMEOUT, 60);
    $result = curl_exec($ch);
    if ($result === FALSE) {
        instamatic_log_to_file('"Wordai" failed to exec curl after auth: ' . curl_error($ch));
        curl_close ($ch);
        return FALSE;
    }
    curl_close ($ch);
    $result = json_decode($result);
    if(!isset($result->rewrites))
    {
        instamatic_log_to_file('"Wordai" unrecognized response: ' . print_r($result, true));
        return FALSE;
    }
    $result = explode($titleSeparator, $result->rewrites[0]);
    if (count($result) < 2) {
        if (isset($instamatic_Main_Settings['enable_detailed_logging'])) {
            instamatic_log_to_file('"Wordai" failed to spin article - titleseparator not found.');
        }
        return FALSE;
    }
    return $result;
}
function instamatic_spinrewriter_spin_text($title, $content)
{
    $instamatic_Main_Settings = get_option('instamatic_Main_Settings', false);
    if (!isset($instamatic_Main_Settings['best_user']) || $instamatic_Main_Settings['best_user'] == '' || !isset($instamatic_Main_Settings['best_password']) || $instamatic_Main_Settings['best_password'] == '') {
        instamatic_log_to_file('Please insert a valid "SpinRewriter" user name and password.');
        return FALSE;
    }
    $titleSeparator = '(19459000)';
    $quality = '50';
    $html = $title . ' ' . $titleSeparator . ' ' . $content;
    $html = preg_replace('/\s+/', ' ', $html);
    $html = urlencode($html);
    $data = array();
    $data['email_address'] = $instamatic_Main_Settings['best_user'];
    $data['api_key'] = $instamatic_Main_Settings['best_password'];
    $data['action'] = "unique_variation";
    $data['auto_protected_terms'] = "true";					
    $data['confidence_level'] = "high";							
    $data['auto_sentences'] = "true";							
    $data['auto_paragraphs'] = "false";							
    $data['auto_new_paragraphs'] = "false";						
    $data['auto_sentence_trees'] = "false";						
    $data['use_only_synonyms'] = "true";						
    $data['reorder_paragraphs'] = "false";						
    $data['nested_spintax'] = "false";
    if(str_word_count($html) >= 3950)
    {
        $result = '';
        while($html != '' && $html != ' ')
        {
            $words = explode("+", $html);
            $first30k = join("+", array_slice($words, 0, 3950));
            $html = join("+", array_slice($words, 3950));
            
            $data['text'] = $first30k;	
            $api_response = instamatic_spinrewriter_api_post($data);
            if ($api_response === FALSE) {
                instamatic_log_to_file('"SpinRewriter" failed to exec curl after auth.');
                return FALSE;
            }
            $api_response = json_decode($api_response);
            if(!isset($api_response->response) || !isset($api_response->status) || $api_response->status != 'OK')
            {
                if(isset($api_response->status) && $api_response->status == 'ERROR')
                {
                    if(isset($api_response->response) && $api_response->response == 'You can only submit entirely new text for analysis once every 7 seconds.')
                    {
                        $api_response = instamatic_spinrewriter_api_post($data);
                        if ($api_response === FALSE) {
                            instamatic_log_to_file('"SpinRewriter" failed to exec curl after auth (after resubmit).');
                            return FALSE;
                        }
                        $api_response = json_decode($api_response);
                        if(!isset($api_response->response) || !isset($api_response->status) || $api_response->status != 'OK')
                        {
                            instamatic_log_to_file('"SpinRewriter" failed to wait and resubmit spinning: ' . print_r($api_response, true) . ' params: ' . print_r($data, true));
                            return FALSE;
                        }
                    }
                    else
                    {
                        instamatic_log_to_file('"SpinRewriter" error response: ' . print_r($api_response, true) . ' params: ' . print_r($data, true));
                        return FALSE;
                    }
                }
                else
                {
                    instamatic_log_to_file('"SpinRewriter" error response: ' . print_r($api_response, true) . ' params: ' . print_r($data, true));
                    return FALSE;
                }
            }
            $api_response->response = str_replace(' ', '', $api_response->response);
            $spinned = urldecode($api_response->response);
            $result .= ' ' . $spinned;
        }
    }
    else
    {
        $data['text'] = $html;	
        $api_response = instamatic_spinrewriter_api_post($data);
        if ($api_response === FALSE) {
            instamatic_log_to_file('"SpinRewriter" failed to exec curl after auth.');
            return FALSE;
        }
        $api_response = json_decode($api_response);
        if(!isset($api_response->response) || !isset($api_response->status) || $api_response->status != 'OK')
        {
            if(isset($api_response->status) && $api_response->status == 'ERROR')
            {
                if(isset($api_response->response) && $api_response->response == 'You can only submit entirely new text for analysis once every 7 seconds.')
                {
                    $api_response = instamatic_spinrewriter_api_post($data);
                    if ($api_response === FALSE) {
                        instamatic_log_to_file('"SpinRewriter" failed to exec curl after auth (after resubmit).');
                        return FALSE;
                    }
                    $api_response = json_decode($api_response);
                    if(!isset($api_response->response) || !isset($api_response->status) || $api_response->status != 'OK')
                    {
                        instamatic_log_to_file('"SpinRewriter" failed to wait and resubmit spinning: ' . print_r($api_response, true) . ' params: ' . print_r($data, true));
                        return FALSE;
                    }
                }
                else
                {
                    instamatic_log_to_file('"SpinRewriter" error response: ' . print_r($api_response, true) . ' params: ' . print_r($data, true));
                    return FALSE;
                }
            }
            else
            {
                instamatic_log_to_file('"SpinRewriter" error response: ' . print_r($api_response, true) . ' params: ' . print_r($data, true));
                return FALSE;
            }
        }
        $api_response->response = str_replace(' ', '', $api_response->response);
        $result = urldecode($api_response->response);
    }
    $result = explode($titleSeparator, $result);
    if (count($result) < 2) {
        if (isset($instamatic_Main_Settings['enable_detailed_logging'])) {
            instamatic_log_to_file('"SpinRewriter" failed to spin article - titleseparator not found: ' . $api_response->response);
        }
        return FALSE;
    }
    return $result;
}
function instamatic_spinrewriter_api_post($data){
	$data_raw = "";
    
    $GLOBALS['wp_object_cache']->delete('crspinrewriter_spin_time', 'options');
    $spin_time = get_option('crspinrewriter_spin_time', false);
    if($spin_time !== false && is_numeric($spin_time))
    {
        $c_time = time();
        $spassed = $c_time - $spin_time;
        if($spassed < 10 && $spassed >= 0)
        {
            sleep(10 - $spassed);
        }
    }
    update_option('crspinrewriter_spin_time', time());
    
	foreach ($data as $key => $value){
		$data_raw = $data_raw . $key . "=" . urlencode($value) . "&";
	}
	$ch = curl_init();
    if($ch === false)
    {
        return false;
    }
	curl_setopt($ch, CURLOPT_URL, "http://www.spinrewriter.com/action/api");
	curl_setopt($ch, CURLOPT_POST, true);
	curl_setopt($ch, CURLOPT_POSTFIELDS, $data_raw);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 10);
    curl_setopt($ch, CURLOPT_TIMEOUT, 60);
	$response = trim(curl_exec($ch));
	curl_close($ch);
	return $response;
}
function instamatic_replaceExecludes($article, &$htmlfounds, $opt = false)
{
    $htmlurls = array();$article = preg_replace('{data-image-description="(?:[^\"]*?)"}i', '', $article);
	if($opt === true){
		preg_match_all( "/<a\s[^>]*href=(\"??)([^\" >]*?)\\1[^>]*>(.*?)<\/a>/s" ,$article,$matches,PREG_PATTERN_ORDER);
		$htmlurls=$matches[0];
	}
	$urls_txt = array();
	if($opt === true){
		preg_match_all('/https?:\/\/[^<\s]+/', $article,$matches_urls_txt);
		$urls_txt = $matches_urls_txt[0];
	}
	preg_match_all("/<[^<>]+>/is",$article,$matches,PREG_PATTERN_ORDER);
	$htmlfounds=$matches[0];
	preg_match_all('{\[nospin\].*?\[/nospin\]}s', $article,$matches_ns);
	$nospin = $matches_ns[0];
	$pattern="\[.*?\]";
	preg_match_all("/".$pattern."/s",$article,$matches2,PREG_PATTERN_ORDER);
	$shortcodes=$matches2[0];
	preg_match_all("/<script.*?<\/script>/is",$article,$matches3,PREG_PATTERN_ORDER);
	$js=$matches3[0];
	preg_match_all('/\d{2,}/s', $article,$matches_nums);
	$nospin_nums = $matches_nums[0];
	sort($nospin_nums);
	$nospin_nums = array_reverse($nospin_nums);
	$capped = array();
	if($opt === true){
		preg_match_all("{\b[A-Z][a-z']+\b[,]?}", $article,$matches_cap);
		$capped = $matches_cap[0];
		sort($capped);
		$capped=array_reverse($capped);
	}
	$curly_quote = array();
	if($opt === true){
		preg_match_all('{???.*????}', $article, $matches_curly_txt);
		$curly_quote = $matches_curly_txt[0];
		preg_match_all('{???.*????}', $article, $matches_curly_txt_s);
		$single_curly_quote = $matches_curly_txt_s[0];
		preg_match_all('{&quot;.*?&quot;}', $article, $matches_curly_txt_s_and);
		$single_curly_quote_and = $matches_curly_txt_s_and[0];
		preg_match_all('{&#8220;.*?&#8221}', $article, $matches_curly_txt_s_and_num);
		$single_curly_quote_and_num = $matches_curly_txt_s_and_num[0];
		$curly_quote_regular = array();
		preg_match_all('{".*?"}', $article, $matches_curly_txt_regular);
        $curly_quote_regular = $matches_curly_txt_regular[0];
		$curly_quote = array_merge($curly_quote , $single_curly_quote ,$single_curly_quote_and,$single_curly_quote_and_num,$curly_quote_regular);
	}
	$htmlfounds = array_merge($nospin, $shortcodes, $js, $htmlurls, $htmlfounds, $curly_quote, $urls_txt, $nospin_nums, $capped);
	$htmlfounds = array_filter(array_unique($htmlfounds));
	$i=1;
	foreach($htmlfounds as $htmlfound){
		$article=str_replace($htmlfound,'('.str_repeat('*', $i).')',$article);	
		$i++;
	}
    $article = str_replace(':(*', ': (*', $article);
	return $article;
}
function instamatic_restoreExecludes($article, $htmlfounds){
	$i=1;
	foreach($htmlfounds as $htmlfound){
		$article=str_replace( '('.str_repeat('*', $i).')', $htmlfound, $article);
		$i++;
	}
	$article = str_replace(array('[nospin]','[/nospin]'), '', $article);
    $article = preg_replace('{\(?\*[\s*]+\)?}', '', $article);
	return $article;
}
function instamatic_fix_spinned_content($final_content, $spinner)
{
    if ($spinner == 'wordai') {
        $final_content = str_replace('-LRB-', '(', $final_content);
        $final_content = preg_replace("/{\*\|.*?}/", '*', $final_content);
        preg_match_all('/{\)[^}]*\|\)[^}]*}/', $final_content, $matches_brackets);
        $matches_brackets = $matches_brackets[0];
        foreach ($matches_brackets as $matches_bracket) {
            $matches_bracket_clean = str_replace( array('{','}') , '', $matches_bracket);
            $matches_bracket_parts = explode('|',$matches_bracket_clean);
            $final_content = str_replace($matches_bracket, $matches_bracket_parts[0], $final_content);
        }
    }
    elseif ($spinner == 'spinrewriter' || $spinner == 'translate') {
        $final_content = preg_replace('{\(\s(\**?\))\.}', '($1', $final_content);
        $final_content = preg_replace('{\(\s(\**?\))\s\(}', '($1(', $final_content);
        $final_content = preg_replace('{\s(\(\**?\))\.(\s)}', "$1$2", $final_content);
        $final_content = str_replace('( *', '(*', $final_content);
        $final_content = str_replace('* )', '*)', $final_content);
        $final_content = str_replace('& #', '&#', $final_content);
        $final_content = str_replace('& ldquo;', '"', $final_content);
        $final_content = str_replace('& rdquo;', '"', $final_content);
    }
    return $final_content;
}
function instamatic_spin_and_translate($post_title, $final_content)
{
    $instamatic_Main_Settings = get_option('instamatic_Main_Settings', false);
    if (isset($instamatic_Main_Settings['spin_text']) && $instamatic_Main_Settings['spin_text'] !== 'disabled') {
        
        $htmlfounds = array();
        $final_content = instamatic_replaceExecludes($final_content, $htmlfounds, false);
        
        
        if ($instamatic_Main_Settings['spin_text'] == 'builtin') {
            $translation = instamatic_builtin_spin_text($post_title, $final_content);
        } elseif ($instamatic_Main_Settings['spin_text'] == 'wikisynonyms') {
            $translation = instamatic_spin_text($post_title, $final_content, false);
        } elseif ($instamatic_Main_Settings['spin_text'] == 'freethesaurus') {
            $translation = instamatic_spin_text($post_title, $final_content, true);
        } elseif ($instamatic_Main_Settings['spin_text'] == 'best') {
            $translation = instamatic_best_spin_text($post_title, $final_content);
        } elseif ($instamatic_Main_Settings['spin_text'] == 'wordai') {
            $translation = instamatic_wordai_spin_text($post_title, $final_content);
        } elseif ($instamatic_Main_Settings['spin_text'] == 'spinrewriter') {
            $translation = instamatic_spinrewriter_spin_text($post_title, $final_content);
        }
        if ($translation !== FALSE) {
            if (is_array($translation) && isset($translation[0]) && isset($translation[1])) {
                $post_title    = $translation[0];
                $final_content = $translation[1];
                
                $final_content = instamatic_fix_spinned_content($final_content, $instamatic_Main_Settings['spin_text']);
                $final_content = instamatic_restoreExecludes($final_content, $htmlfounds);
                
            } else {
                $final_content = instamatic_restoreExecludes($final_content, $htmlfounds);
                if (isset($instamatic_Main_Settings['enable_detailed_logging'])) {
                    instamatic_log_to_file('Text Spinning failed - malformed data ' . $instamatic_Main_Settings['spin_text']);
                }
            }
        } else {
            $final_content = instamatic_restoreExecludes($final_content, $htmlfounds);
            if (isset($instamatic_Main_Settings['enable_detailed_logging'])) {
                instamatic_log_to_file('Text Spinning Failed - returned false ' . $instamatic_Main_Settings['spin_text']);
            }
        }
    }
    if (isset($instamatic_Main_Settings['translate']) && $instamatic_Main_Settings['translate'] != 'disabled') {
        if(isset($instamatic_Main_Settings['translate_source']) && $instamatic_Main_Settings['translate_source'] != '')
        {
            $tr = $instamatic_Main_Settings['translate_source'];
        }
        else
        {
            $tr = 'auto';
        }
        $htmlfounds = array();
        $final_content = instamatic_replaceExecludes($final_content, $htmlfounds, false);
        
        $translation = instamatic_translate($post_title, $final_content, $tr, $instamatic_Main_Settings['translate']);
        if (is_array($translation) && isset($translation[1]))
        {
            $translation[1] = preg_replace('#(?<=[\*(])\s+(?=[\*)])#', '', $translation[1]);
            $translation[1] = preg_replace('#([^(*\s]\s)\*+\)#', '$1', $translation[1]);
            $translation[1] = preg_replace('#\(\*+([\s][^)*\s])#', '$1', $translation[1]);
            $translation[1] = instamatic_restoreExecludes($translation[1], $htmlfounds);
        }
        else
        {
            $final_content = instamatic_restoreExecludes($final_content, $htmlfounds);
        }
        if ($translation !== FALSE) {
            if (is_array($translation) && isset($translation[0]) && isset($translation[1])) {
                $post_title    = $translation[0];
                $final_content = $translation[1];
                $final_content = str_replace('</ iframe>', '</iframe>', $final_content);
                if(stristr($final_content, '<head>') !== false)
                {
                    $d = new DOMDocument;
                    $mock = new DOMDocument;
                    $internalErrors = libxml_use_internal_errors(true);
                    $d->loadHTML('<?xml encoding="utf-8" ?>' . $final_content);
                    libxml_use_internal_errors($internalErrors);
                    $body = $d->getElementsByTagName('body')->item(0);
                    foreach ($body->childNodes as $child)
                    {
                        $mock->appendChild($mock->importNode($child, true));
                    }
                    $new_post_content_temp = $mock->saveHTML();
                    if($new_post_content_temp !== '' && $new_post_content_temp !== false)
                    {
						$new_post_content_temp = str_replace('<?xml encoding="utf-8" ?>', '', $new_post_content_temp);
                        $final_content = preg_replace("/_addload\(function\(\){([^<]*)/i", "", $new_post_content_temp); 
                    }
                }
                $final_content = htmlspecialchars_decode($final_content);
                $final_content = str_replace('</ ', '</', $final_content);
                $final_content = str_replace(' />', '/>', $final_content);
                $final_content = str_replace('< br/>', '<br/>', $final_content);
                $final_content = str_replace('< / ', '</', $final_content);
                $final_content = str_replace(' / >', '/>', $final_content);
                $final_content = preg_replace('/[\x00-\x1F\x7F\xA0]/u', '', $final_content);
                $post_title = preg_replace('{&\s*#\s*(\d+)\s*;}', '&#$1;', $post_title);
$post_title = htmlspecialchars_decode($post_title);
                $post_title = str_replace('</ ', '</', $post_title);
                $post_title = str_replace(' />', '/>', $post_title);
                $post_title = preg_replace('/[\x00-\x1F\x7F\xA0]/u', '', $post_title);
            } else {
                if (isset($instamatic_Main_Settings['enable_detailed_logging'])) {
                    instamatic_log_to_file('Translation failed - malformed data!');
                }
            }
        } else {
            if (isset($instamatic_Main_Settings['enable_detailed_logging'])) {
                instamatic_log_to_file('Translation Failed - returned false!');
            }
        }
    }
    return array(
        $post_title,
        $final_content
    );
}

function instamatic_translate($title, $content, $from, $to)
{
    $ch                     = FALSE;
    $instamatic_Main_Settings = get_option('instamatic_Main_Settings', false);
    try {
        if($from == 'disabled')
        {
            $from = 'auto';
        }
        if($from != 'en' && $from == $to)
        {
            $from = 'en';
        }
        elseif($from == 'en' && $from == $to)
        {
            return false;
        }
        if (isset($instamatic_Main_Settings['google_trans_auth']) && trim($instamatic_Main_Settings['google_trans_auth']) != '')
        {
            require_once(dirname(__FILE__) . "/res/translator-api.php");
            $ch = curl_init();
            if ($ch === FALSE) {
                if (isset($instamatic_Main_Settings['enable_detailed_logging'])) {
                    instamatic_log_to_file('Failed to init cURL in translator!');
                }
                return false;
            }
            curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
            curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 10);
            curl_setopt($ch, CURLOPT_TIMEOUT, 10);
            $GoogleTranslatorAPI = new GoogleTranslatorAPI($ch, $instamatic_Main_Settings['google_trans_auth']);
            $translated = '';
            $translated_title = '';
            if($content != '')
            {
                if(strlen($content) > 30000)
                {
                    while($content != '')
                    {
                        $first30k = substr($content, 0, 30000);
                        $content = substr($content, 30000);
                        $translated_temp       = $GoogleTranslatorAPI->translateText($first30k, $from, $to);
                        $translated .= ' ' . $translated_temp;
                    }
                }
                else
                {
                    $translated       = $GoogleTranslatorAPI->translateText($content, $from, $to);
                }
            }
            if($title != '')
            {
                $translated_title = $GoogleTranslatorAPI->translateText($title, $from, $to);
            }
            curl_close($ch);
        }
        else
        {
            require_once(dirname(__FILE__) . "/res/instamatic-translator.php");
            $ch = curl_init();
            if ($ch === FALSE) {
                if (isset($instamatic_Main_Settings['enable_detailed_logging'])) {
                    instamatic_log_to_file('Failed to init cURL in translator!');
                }
                return false;
            }
            if (isset($instamatic_Main_Settings['proxy_url']) && $instamatic_Main_Settings['proxy_url'] != '') 
            {
                $prx = explode(',', $instamatic_Main_Settings['proxy_url']);
                $randomness = array_rand($prx);
                curl_setopt( $ch, CURLOPT_PROXY, trim($prx[$randomness]));
                curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 10);
                curl_setopt($ch, CURLOPT_TIMEOUT, 60);
                if (isset($instamatic_Main_Settings['proxy_auth']) && $instamatic_Main_Settings['proxy_auth'] != '') 
                {
                    $prx_auth = explode(',', $instamatic_Main_Settings['proxy_auth']);
                    if(isset($prx_auth[$randomness]) && trim($prx_auth[$randomness]) != '')
                    {
                        curl_setopt( $ch, CURLOPT_PROXYUSERPWD, trim($prx_auth[$randomness]) );
                    }
                }
            }
            curl_setopt($ch, CURLOPT_USERAGENT, instamatic_get_random_user_agent());
            $GoogleTranslator = new GoogleTranslator($ch);
            $translated = '';
            $translated_title = '';
            if($content != '')
            {
                if(strlen($content) > 13000)
                {
                    while($content != '')
                    {
                        $first30k = substr($content, 0, 13000);
                        $content = substr($content, 13000);
                        $translated_temp       = $GoogleTranslator->translateText($first30k, $from, $to);
                        if (strpos($translated, '<h2>The page you have attempted to translate is already in ') !== false) {
                            throw new Exception('Page content already in ' . $to);
                        }
                        if (strpos($translated, 'Error 400 (Bad Request)!!1') !== false) {
                            throw new Exception('Unexpected error while translating page!');
                        }
                        if(substr_compare($translated_temp, '</pre>', -strlen('</pre>')) === 0){$translated_temp = substr_replace($translated_temp ,"", -6);}if(substr( $translated_temp, 0, 5 ) === "<pre>"){$translated_temp = substr($translated_temp, 5);}
                        $translated .= ' ' . $translated_temp;
                    }
                }
                else
                {
                    $translated       = $GoogleTranslator->translateText($content, $from, $to);
                    if (strpos($translated, '<h2>The page you have attempted to translate is already in ') !== false) {
                        throw new Exception('Page content already in ' . $to);
                    }
                    if (strpos($translated, 'Error 400 (Bad Request)!!1') !== false) {
                        throw new Exception('Unexpected error while translating page!');
                    }
                }
            }
            if($title != '')
            {
                $translated_title = $GoogleTranslator->translateText($title, $from, $to);
            }
            if (strpos($translated_title, '<h2>The page you have attempted to translate is already in ') !== false) {
                throw new Exception('Page title already in ' . $to);
            }
            if (strpos($translated_title, 'Error 400 (Bad Request)!!1') !== false) {
                throw new Exception('Unexpected error while translating page title!');
            }
            curl_close($ch);
        }
    }
    catch (Exception $e) {
        curl_close($ch);
        if (isset($instamatic_Main_Settings['enable_detailed_logging'])) {
            instamatic_log_to_file('Exception thrown in GoogleTranslator ' . $e);
        }
        return false;
    }
    if(substr_compare($translated_title, '</pre>', -strlen('</pre>')) === 0){$title = substr_replace($translated_title ,"", -6);}else{$title = $translated_title;}if(substr( $title, 0, 5 ) === "<pre>"){$title = substr($title, 5);}
    if(substr_compare($translated, '</pre>', -strlen('</pre>')) === 0){$text = substr_replace($translated ,"", -6);}else{$text = $translated;}if(substr( $text, 0, 5 ) === "<pre>"){$text = substr($text, 5);}
    $text  = preg_replace('/' . preg_quote('html lang=') . '.*?' . preg_quote('>') . '/', '', $text);
    $text  = preg_replace('/' . preg_quote('!DOCTYPE') . '.*?' . preg_quote('<') . '/', '', $text);
    $text  = preg_replace('#https:\/\/translate\.google\.com\/translate\?hl=en&amp;prev=_t&amp;sl=en&amp;tl=pl&amp;u=([^><"\'\s\n]*)#i', urldecode('$1'), $text);
    return array(
        $title,
        $text
    );
}

function instamatic_strip_html_tags($str)
{
    $str = html_entity_decode($str);
    $str = preg_replace('/(<|>)\1{2}/is', '', $str);
    $str = preg_replace(array(
        '@<head[^>]*?>.*?</head>@siu',
        '@<style[^>]*?>.*?</style>@siu',
        '@<script[^>]*?.*?</script>@siu',
        '@<noscript[^>]*?.*?</noscript>@siu'
    ), "", $str);
    $str = strip_tags($str);
    return $str;
}

function instamatic_DOMinnerHTML(DOMNode $element)
{
    $innerHTML = "";
    $children  = $element->childNodes;
    
    foreach ($children as $child) {
        $innerHTML .= $element->ownerDocument->saveHTML($child);
    }
    
    return $innerHTML;
}

function instamatic_url_exists($url)
{
    stream_context_set_default( [
        'ssl' => [
            'verify_peer' => false,
            'verify_peer_name' => false,
        ],
    ]);
    error_reporting(0);
    $headers = get_headers($url);
    error_reporting(E_ALL);
    if (!isset($headers[0]) || strpos($headers[0], '200') === false)
        return false;
    return true;
}

register_activation_hook(__FILE__, 'instamatic_check_version');
function instamatic_check_version()
{
    if (!function_exists('curl_init')) {
        echo '<h3>'.esc_html__('Please enable curl PHP extension. Please contact your hosting provider\'s support to help you in this matter.', 'instagram-post-generator', 'instamatic-instagram-post-generator').'</h3>';
        die;
    }
    global $wp_version;
    if (!current_user_can('activate_plugins')) {
        echo '<p>' . esc_html__('You are not allowed to activate plugins!', 'instamatic-instagram-post-generator') . '</p>';
        die;
    }
    $php_version_required = '7.2';
    $wp_version_required  = '2.7';
    
    if (version_compare(PHP_VERSION, $php_version_required, '<')) {
        deactivate_plugins(basename(__FILE__));
        echo '<p>' . sprintf(esc_html__('This plugin can not be activated because it requires a PHP version greater than %1$s. Please update your PHP version before you activate it.', 'instamatic-instagram-post-generator'), $php_version_required) . '</p>';
        die;
    }
    
    if (version_compare($wp_version, $wp_version_required, '<')) {
        deactivate_plugins(basename(__FILE__));
        echo '<p>' . sprintf(esc_html__('This plugin can not be activated because it requires a WordPress version greater than %1$s. Please go to Dashboard -> Updates to get the latest version of WordPress.', 'instamatic-instagram-post-generator'), $wp_version_required) . '</p>';
        die;
    }
}

add_action('admin_init', 'instamatic_register_mysettings');
function instamatic_register_mysettings()
{
    if(isset($_POST['btnCheckApp']))
    {
        $instamatic_Main_Settings = get_option('instamatic_Main_Settings', false);
        if(isset($instamatic_Main_Settings['app_id']) && trim($instamatic_Main_Settings['app_id']) != '' && isset($instamatic_Main_Settings['app_secret']) && trim($instamatic_Main_Settings['app_secret']) != '')
        {
            $my_proxy = '';
            if (isset($instamatic_Main_Settings['proxy_url']) && $instamatic_Main_Settings['proxy_url'] != '') 
            {
                    $prx = explode(',', $instamatic_Main_Settings['proxy_url']);
                    $randomness = array_rand($prx);
                    if (isset($instamatic_Main_Settings['proxy_auth']) && $instamatic_Main_Settings['proxy_auth'] != '') 
                    {
                        $prx_auth = explode(',', $instamatic_Main_Settings['proxy_auth']);
                        if(isset($prx_auth[$randomness]) && trim($prx_auth[$randomness]) != '')
                        {
                            $my_proxy = 'http://' . $prx_auth[$randomness] . '@' . $prx[$randomness];
                        }
                        else
                        {
                            $my_proxy = 'http://' . $prx[$randomness];
                        }
                    }
                    else
                    {
                        $my_proxy = 'http://' . $prx[$randomness];
                    }
            }
            if(!class_exists('\GuzzleHttp\Client') || !class_exists('\Phpfastcache\Helper\Psr16Adapter'))
            {
                require_once(dirname(__FILE__) . '/res/vendor-old/autoload.php');
            }
            require_once (dirname(__FILE__) . "/res/Instagram-post/instagram-photo-video-upload-api.class.php");
            
            $apiInstance = new InstagramLoginPassMethod( trim($instamatic_Main_Settings['app_id']), instamatic_encrypt_decrypt('decrypt', $instamatic_Main_Settings['app_secret']), $my_proxy );
            $rrez = $apiInstance->login();

            if ( isset( $rrez[ 'status' ] ) && $rrez[ 'status' ] === 'fail' )
            {
                instamatic_log_to_file('Login failed: ' . print_r($rrez, true));
                update_option('instamatic_login_try', 'Failed to log in to your account, please check login details.');
            }
            else
            {
                update_option('instamatic_login_try', 'Login successful.');
            }
        }
        else
        {
            update_option('instamatic_login_try', 'Please enter your Instagram login info in plugin settings.');
        }
    }
    instamatic_cron_schedule();
    if(isset($_GET['instamatic_page']))
    {
        $curent_page = $_GET["instamatic_page"];
    }
    else
    {
        $curent_page = '';
    }
    $all_rules = get_option('instamatic_rules_list', array());
    $rules_count = count($all_rules);
    $rules_per_page = get_option('instamatic_posts_per_page', 16);
    $max_pages = ceil($rules_count/$rules_per_page);
    if($max_pages == 0)
    {
        $max_pages = 1;
    }
    $last_url = (instamatic_isSecure() ? "https" : "http") . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
    if(stristr($last_url, 'instamatic_items_panel') !== false && (!is_numeric($curent_page) || $curent_page > $max_pages || $curent_page <= 0))
    {
        if(stristr($last_url, 'instamatic_page=') === false)
        {
            if(stristr($last_url, '?') === false)
            {
                $last_url .= '?instamatic_page=' . $max_pages;
            }
            else
            {
                $last_url .= '&instamatic_page=' . $max_pages;
            }
        }
        else
        {
            if(isset($_GET['instamatic_page']))
            {
                $curent_page = $_GET["instamatic_page"];
            }
            else
            {
                $curent_page = '';
            }
            if(is_numeric($curent_page))
            {
                $last_url = str_replace('instamatic_page=' . $curent_page, 'instamatic_page=' . $max_pages, $last_url);
            }
            else
            {
                if(stristr($last_url, '?') === false)
                {
                    $last_url .= '?instamatic_page=' . $max_pages;
                }
                else
                {
                    $last_url .= '&instamatic_page=' . $max_pages;
                }
            }
        }
        instamatic_redirect($last_url);
    }
    register_setting('instamatic_option_group', 'instamatic_Main_Settings');
    register_setting('instamatic_option_group2', 'instamatic_Instagram_Settings');
    if (is_multisite()) {
        if (!get_option('instamatic_Main_Settings')) {
            instamatic_activation_callback(TRUE);
        }
    }
}
function instamatic_redirect($url, $statusCode = 301)
{
   if(!function_exists('wp_redirect'))
   {
       include_once( ABSPATH . 'wp-includes/pluggable.php' );
   }
   wp_redirect($url, $statusCode);
   die();
}
function instamatic_get_plugin_url()
{
    return plugins_url('', __FILE__);
}

function instamatic_get_file_url($url)
{
    return esc_url(instamatic_get_plugin_url() . '/' . $url);
}

function instamatic_admin_load_files()
{
    wp_register_style('instamatic-browser-style', plugins_url('styles/instamatic-browser.css', __FILE__), false, '1.0.0');
    wp_enqueue_style('instamatic-browser-style');
    wp_enqueue_script('jquery');
    wp_enqueue_script('media-upload');
    wp_enqueue_script('thickbox');
    wp_enqueue_style('thickbox');
    wp_register_style('instamatic-custom-style', plugins_url('styles/coderevolution-style.css', __FILE__), false, '1.0.0');
    wp_enqueue_style('instamatic-custom-style');
}

function instamatic_random_sentence_generator($first = true)
{
    $instamatic_Main_Settings = get_option('instamatic_Main_Settings', false);
    if ($first == false) {
        $r_sentences = $instamatic_Main_Settings['sentence_list2'];
    } else {
        $r_sentences = $instamatic_Main_Settings['sentence_list'];
    }
    $r_variables = $instamatic_Main_Settings['variable_list'];
    $r_sentences = trim($r_sentences);
    $r_variables = trim($r_variables, ';');
    $r_variables = trim($r_variables);
    $r_sentences = str_replace("\r\n", "\n", $r_sentences);
    $r_sentences = str_replace("\r", "\n", $r_sentences);
    $r_sentences = explode("\n", $r_sentences);
    $r_variables = str_replace("\r\n", "\n", $r_variables);
    $r_variables = str_replace("\r", "\n", $r_variables);
    $r_variables = explode("\n", $r_variables);
    $r_vars      = array();
    for ($x = 0; $x < count($r_variables); $x++) {
        $var = explode("=>", trim($r_variables[$x]));
        if (isset($var[1])) {
            $key          = strtolower(trim($var[0]));
            $words        = explode(";", trim($var[1]));
            $r_vars[$key] = $words;
        }
    }
    $max_s    = count($r_sentences) - 1;
    $rand_s   = rand(0, $max_s);
    $sentence = $r_sentences[$rand_s];
    $sentence = str_replace(' ,', ',', ucfirst(instamatic_replace_words($sentence, $r_vars)));
    $sentence = str_replace(' .', '.', $sentence);
    $sentence = str_replace(' !', '!', $sentence);
    $sentence = str_replace(' ?', '?', $sentence);
    $sentence = trim($sentence);
    return $sentence;
}

function instamatic_get_word($key, $r_vars)
{
    if (isset($r_vars[$key])) {
        
        $words  = $r_vars[$key];
        $w_max  = count($words) - 1;
        $w_rand = rand(0, $w_max);
        return instamatic_replace_words(trim($words[$w_rand]), $r_vars);
    } else {
        return "";
    }
    
}

function instamatic_replace_words($sentence, $r_vars)
{
    
    if (str_replace('%', '', $sentence) == $sentence)
        return $sentence;
    
    $words = explode(" ", $sentence);
    
    $new_sentence = array();
    for ($w = 0; $w < count($words); $w++) {
        
        $word = trim($words[$w]);
        
        if ($word != '') {
            if (preg_match('/^%([^%\n]*)$/', $word, $m)) {
                $varkey         = trim($m[1]);
                $new_sentence[] = instamatic_get_word($varkey, $r_vars);
            } else {
                $new_sentence[] = $word;
            }
        }
    }
    return implode(" ", $new_sentence);
}

function instamatic_fb_locales()
{
    return array(
        'af_ZA', // Afrikaans
        'ak_GH', // Akan
        'am_ET', // Amharic
        'ar_AR', // Arabic
        'as_IN', // Assamese
        'ay_BO', // Aymara
        'az_AZ', // Azerbaijani
        'be_BY', // Belarusian
        'bg_BG', // Bulgarian
        'bn_IN', // Bengali
        'br_FR', // Breton
        'bs_BA', // Bosnian
        'ca_ES', // Catalan
        'cb_IQ', // Sorani Kurdish
        'ck_US', // Cherokee
        'co_FR', // Corsican
        'cs_CZ', // Czech
        'cx_PH', // Cebuano
        'cy_GB', // Welsh
        'da_DK', // Danish
        'de_DE', // German
        'el_GR', // Greek
        'en_GB', // English (UK)
        'en_IN', // English (India)
        'en_PI', // English (Pirate)
        'en_UD', // English (Upside Down)
        'en_US', // English (US)
        'eo_EO', // Esperanto
        'es_CL', // Spanish (Chile)
        'es_CO', // Spanish (Colombia)
        'es_ES', // Spanish (Spain)
        'es_LA', // Spanish
        'es_MX', // Spanish (Mexico)
        'es_VE', // Spanish (Venezuela)
        'et_EE', // Estonian
        'eu_ES', // Basque
        'fa_IR', // Persian
        'fb_LT', // Leet Speak
        'ff_NG', // Fulah
        'fi_FI', // Finnish
        'fo_FO', // Faroese
        'fr_CA', // French (Canada)
        'fr_FR', // French (France)
        'fy_NL', // Frisian
        'ga_IE', // Irish
        'gl_ES', // Galician
        'gn_PY', // Guarani
        'gu_IN', // Gujarati
        'gx_GR', // Classical Greek
        'ha_NG', // Hausa
        'he_IL', // Hebrew
        'hi_IN', // Hindi
        'hr_HR', // Croatian
        'hu_HU', // Hungarian
        'hy_AM', // Armenian
        'id_ID', // Indonesian
        'ig_NG', // Igbo
        'is_IS', // Icelandic
        'it_IT', // Italian
        'ja_JP', // Japanese
        'ja_KS', // Japanese (Kansai)
        'jv_ID', // Javanese
        'ka_GE', // Georgian
        'kk_KZ', // Kazakh
        'km_KH', // Khmer
        'kn_IN', // Kannada
        'ko_KR', // Korean
        'ku_TR', // Kurdish (Kurmanji)
        'ky_KG', // Kyrgyz
        'la_VA', // Latin
        'lg_UG', // Ganda
        'li_NL', // Limburgish
        'ln_CD', // Lingala
        'lo_LA', // Lao
        'lt_LT', // Lithuanian
        'lv_LV', // Latvian
        'mg_MG', // Malagasy
        'mi_NZ', // Maori
        'mk_MK', // Macedonian
        'ml_IN', // Malayalam
        'mn_MN', // Mongolian
        'mr_IN', // Marathi
        'ms_MY', // Malay
        'mt_MT', // Maltese
        'my_MM', // Burmese
        'nb_NO', // Norwegian (bokmal)
        'nd_ZW', // Ndebele
        'ne_NP', // Nepali
        'nl_BE', // Dutch (Belgi??)
        'nl_NL', // Dutch
        'nn_NO', // Norwegian (nynorsk)
        'ny_MW', // Chewa
        'or_IN', // Oriya
        'pa_IN', // Punjabi
        'pl_PL', // Polish
        'ps_AF', // Pashto
        'pt_BR', // Portuguese (Brazil)
        'pt_PT', // Portuguese (Portugal)
        'qu_PE', // Quechua
        'rm_CH', // Romansh
        'ro_RO', // Romanian
        'ru_RU', // Russian
        'rw_RW', // Kinyarwanda
        'sa_IN', // Sanskrit
        'sc_IT', // Sardinian
        'se_NO', // Northern S??mi
        'si_LK', // Sinhala
        'sk_SK', // Slovak
        'sl_SI', // Slovenian
        'sn_ZW', // Shona
        'so_SO', // Somali
        'sq_AL', // Albanian
        'sr_RS', // Serbian
        'sv_SE', // Swedish
        'sy_SY', // Swahili
        'sw_KE', // Syriac
        'sz_PL', // Silesian
        'ta_IN', // Tamil
        'te_IN', // Telugu
        'tg_TJ', // Tajik
        'th_TH', // Thai
        'tk_TM', // Turkmen
        'tl_PH', // Filipino
        'tl_ST', // Klingon
        'tr_TR', // Turkish
        'tt_RU', // Tatar
        'tz_MA', // Tamazight
        'uk_UA', // Ukrainian
        'ur_PK', // Urdu
        'uz_UZ', // Uzbek
        'vi_VN', // Vietnamese
        'wo_SN', // Wolof
        'xh_ZA', // Xhosa
        'yi_DE', // Yiddish
        'yo_NG', // Yoruba
        'zh_CN', // Simplified Chinese (China)
        'zh_HK', // Traditional Chinese (Hong Kong)
        'zh_TW', // Traditional Chinese (Taiwan)
        'zu_ZA', // Zulu
        'zz_TR' // Zazaki
    );
}
function instamatic_language_keys()
{
    return array(
        'af', // Afrikaans
        'ak', // Akan
        'am', // Amharic
        'ar', // Arabic
        'as', // Assamese
        'ay', // Aymara
        'az', // Azerbaijani
        'be', // Belarusian
        'bg', // Bulgarian
        'bn', // Bengali
        'br', // Breton
        'bs', // Bosnian
        'ca', // Catalan
        'cb', // Sorani Kurdish
        'ck', // Cherokee
        'co', // Corsican
        'cs', // Czech
        'cx', // Cebuano
        'cy', // Welsh
        'da', // Danish
        'de', // German
        'el', // Greek
        'en', // English (UK)
        'en', // English (India)
        'en', // English (Pirate)
        'en', // English (Upside Down)
        'en', // English (US)
        'eo', // Esperanto
        'es', // Spanish (Chile)
        'es', // Spanish (Colombia)
        'es', // Spanish (Spain)
        'es', // Spanish
        'es', // Spanish (Mexico)
        'es', // Spanish (Venezuela)
        'et', // Estonian
        'eu', // Basque
        'fa', // Persian
        'fb', // Leet Speak
        'ff', // Fulah
        'fi', // Finnish
        'fo', // Faroese
        'fr', // French (Canada)
        'fr', // French (France)
        'fy', // Frisian
        'ga', // Irish
        'gl', // Galician
        'gn', // Guarani
        'gu', // Gujarati
        'gx', // Classical Greek
        'ha', // Hausa
        'he', // Hebrew
        'hi', // Hindi
        'hr', // Croatian
        'hu', // Hungarian
        'hy', // Armenian
        'id', // Indonesian
        'ig', // Igbo
        'is', // Icelandic
        'it', // Italian
        'ja', // Japanese
        'ja', // Japanese (Kansai)
        'jv', // Javanese
        'ka', // Georgian
        'kk', // Kazakh
        'km', // Khmer
        'kn', // Kannada
        'ko', // Korean
        'ku', // Kurdish (Kurmanji)
        'ky', // Kyrgyz
        'la', // Latin
        'lg', // Ganda
        'li', // Limburgish
        'ln', // Lingala
        'lo', // Lao
        'lt', // Lithuanian
        'lv', // Latvian
        'mg', // Malagasy
        'mi', // Maori
        'mk', // Macedonian
        'ml', // Malayalam
        'mn', // Mongolian
        'mr', // Marathi
        'ms', // Malay
        'mt', // Maltese
        'my', // Burmese
        'nb', // Norwegian (bokmal)
        'nd', // Ndebele
        'ne', // Nepali
        'nl', // Dutch (Belgi??)
        'nl', // Dutch
        'nn', // Norwegian (nynorsk)
        'ny', // Chewa
        'or', // Oriya
        'pa', // Punjabi
        'pl', // Polish
        'ps', // Pashto
        'pt', // Portuguese (Brazil)
        'pt', // Portuguese (Portugal)
        'qu', // Quechua
        'rm', // Romansh
        'ro', // Romanian
        'ru', // Russian
        'rw', // Kinyarwanda
        'sa', // Sanskrit
        'sc', // Sardinian
        'se', // Northern S??mi
        'si', // Sinhala
        'sk', // Slovak
        'sl', // Slovenian
        'sn', // Shona
        'so', // Somali
        'sq', // Albanian
        'sr', // Serbian
        'sv', // Swedish
        'sy', // Swahili
        'sw', // Syriac
        'sz', // Silesian
        'ta', // Tamil
        'te', // Telugu
        'tg', // Tajik
        'th', // Thai
        'tk', // Turkmen
        'tl', // Filipino
        'tl', // Klingon
        'tr', // Turkish
        'tt', // Tatar
        'tz', // Tamazight
        'uk', // Ukrainian
        'ur', // Urdu
        'uz', // Uzbek
        'vi', // Vietnamese
        'wo', // Wolof
        'xh', // Xhosa
        'yi', // Yiddish
        'yo', // Yoruba
        'zh', // Simplified Chinese (China)
        'zh', // Traditional Chinese (Hong Kong)
        'zh', // Traditional Chinese (Taiwan)
        'zu', // Zulu
        'zz' // Zazaki
    );
    
}

require(dirname(__FILE__) . "/res/instamatic-main.php");
require(dirname(__FILE__) . "/res/instamatic-rules-list.php");
require(dirname(__FILE__) . "/res/instamatic-instagram-list.php");
require(dirname(__FILE__) . "/res/instamatic-logs.php");
?>