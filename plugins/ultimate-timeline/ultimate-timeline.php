<?php
/*
Plugin Name: WordPress Ultimate Timeline
Plugin URI: http://codecanyon.net/item/wordpress-ultimate-timeline/7411135?ref=SamBerson
Description: WordPress Ultimate Timeline is a new plugin which enables you to build visually attractive timelines for your WordPress site.	
Version: 1.7.2
Author: Sam Berson
Author URI: http://www.samberson.com/
Text Domain: ultimate-timeline, timeline
Domain Path: /languages/

 * @package Ultimate Timeline
 */

/**
 * Base Constants
 */
define('UT_URL', plugin_dir_url( __FILE__ ));
define('UT_ROOT', basename(__DIR__));
define('UT_PATH', plugin_dir_path( __FILE__ ));



// Include ACF
global $acf;
 
if( !$acf ) {
    define( 'ACF_LITE' , true );
    include_once('includes/acf/acf.php' );
}

include_once('includes/acf-repeater/acf-repeater.php' );
if(!class_exists('acf_field_date_time_picker_plugin')) {
	include_once('includes/acf-field-date-time-picker/date_time_picker-v4.php' );
}
include_once('includes/acf/acf-field-groups.php' );


// Includes
foreach ( glob( UT_PATH . "/classes/class.*.php") as $filename) {
    include $filename;
}

// Includes
foreach ( glob( UT_PATH . "/includes/*.php") as $filename) {
    include $filename;
}

// Activation Hook
function timeline_activation_hook() {
	$helpers = new TimelineHelpers();
	$helpers->timeline_activation();
}
register_activation_hook( __FILE__, 'timeline_activation_hook');
