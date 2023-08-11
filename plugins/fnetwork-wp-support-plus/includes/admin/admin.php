<?php 

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

final class WPSupportPlusAdmin {
	
	public function __construct() {
		add_action( 'admin_enqueue_scripts', array( $this, 'loadScripts') );
		add_action( 'admin_menu', array($this,'custom_menu_page') );
		
	}
	
	function loadScripts(){
		wp_enqueue_script( 'jquery' );
		wp_enqueue_script( 'jquery-ui-core' );
		wp_enqueue_style('wpce_admin', WCE_PLUGIN_URL . 'asset/css/admin.css');
	}
	
	function custom_menu_page(){
		add_menu_page( 'WP Support Plus', 'Support Plus', 'manage_support_plus_ticket', 'wp-support-plus', array($this,'tickets'),WCE_PLUGIN_URL.'asset/images/support.png', '51.66' );
		add_submenu_page( 'wp-support-plus', 'WP Support Plus Statistics', 'Statistics', 'manage_support_plus_agent', 'wp-support-plus-statistics', array($this,'statistics') );
		add_submenu_page( 'wp-support-plus', 'WP Support Plus Settings', 'Settings', 'manage_options', 'wp-support-plus-settings', array($this,'settings') );
		add_submenu_page( 'wp-support-plus', 'WP Support Plus Support', 'Support', 'manage_options', 'wp-support-plus-support', array($this,'support') );
	}
	
	function tickets(){
		//Load Bootstrap
		#wp_enqueue_script('wpce_bootstrap', WCE_PLUGIN_URL . 'asset/js/bootstrap/js/bootstrap.min.js');
		#wp_enqueue_style('wpce_bootstrap', WCE_PLUGIN_URL . 'asset/js/bootstrap/css/bootstrap.min.css');
		wp_enqueue_script('wpce_display_ticket', WCE_PLUGIN_URL . 'asset/js/display_ticket.js');
		
		wp_enqueue_style('wpce_display_ticket', WCE_PLUGIN_URL . 'asset/css/display_ticket.css');
		$localize_script_data=array(
				'wpsp_ajax_url'=>admin_url( 'admin-ajax.php' ),
				'wpsp_site_url'=>site_url(),
				'plugin_url'=>WCE_PLUGIN_URL,
				'plugin_dir'=>WCE_PLUGIN_DIR
		);
		wp_localize_script( 'wpce_display_ticket', 'display_ticket_data', $localize_script_data );
		
		wp_enqueue_script('wpce_text_editor', WCE_PLUGIN_URL . 'asset/js/nicEdit-latest.js');
		$localize_data_nicEdit=array('plugin_url'=>WCE_PLUGIN_URL);
		wp_localize_script( 'wpce_text_editor', 'editor_data', $localize_data_nicEdit );
		
		global $current_user;
		get_currentuserinfo();
		
		?>
		<div class="panel panel-primary wpsp_admin_panel">
		  <div class="panel-heading">
		    <h3 class="panel-title"><?php _e('WP Support Plus','wp-support-plus-responsive');?></h3>
		    <span class="wpsp_support_admin_welcome"><?php _e('Welcome, '.$current_user->display_name,'wp-support-plus-responsive');?></span>
		  </div>
		  <div class="panel-body">
		    <?php include_once( WCE_PLUGIN_DIR.'includes/admin/display_ticket.php' );?>
		  </div>
		</div>
		<?php 
	}
	
	function settings(){
		//Load Bootstrap
		#wp_enqueue_script('wpce_bootstrap', WCE_PLUGIN_URL . 'asset/js/bootstrap/js/bootstrap.min.js');
		#wp_enqueue_style('wpce_bootstrap', WCE_PLUGIN_URL . 'asset/js/bootstrap/css/bootstrap.min.css');
		wp_enqueue_script('wpce_admin_settings', WCE_PLUGIN_URL . 'asset/js/admin_settings.js');
		wp_enqueue_style('wpce_admin_settings', WCE_PLUGIN_URL . 'asset/css/admin_settings.css');
		
		$localize_script_data=array(
				'wpsp_ajax_url'=>admin_url( 'admin-ajax.php' ),
				'wpsp_site_url'=>site_url(),
				'plugin_url'=>WCE_PLUGIN_URL,
				'plugin_dir'=>WCE_PLUGIN_DIR
		);
		wp_localize_script( 'wpce_admin_settings', 'display_ticket_data', $localize_script_data );
		
		add_thickbox();
		
		?>
		<div class="panel panel-primary wpsp_admin_panel" >
		  <div class="panel-heading">
		    <h3 class="panel-title"><?php _e('WP Support Plus Settings','wp-support-plus-responsive');?></h3>
		  </div>
		  <div class="panel-body">
		    <?php include_once( WCE_PLUGIN_DIR.'includes/admin/admin_settings.php' );?>
		  </div>
		</div>
		<?php 
	}
	
	function support(){
		?>
		<iframe src="http://pradeepmakone.com/wpsupportplus/support/" style="width: 90%;height: 550px;border: 4px solid #ffffff;"></iframe>
		<?php 
	}
	
	function statistics(){
		#wp_enqueue_script('wpce_bootstrap', WCE_PLUGIN_URL . 'asset/js/bootstrap/js/bootstrap.min.js');
		#wp_enqueue_style('wpce_bootstrap', WCE_PLUGIN_URL . 'asset/js/bootstrap/css/bootstrap.min.css');
		?>
		<div class="panel panel-primary wpsp_admin_panel">
		  <div class="panel-heading">
		    <h3 class="panel-title"><?php _e('WP Support Plus Statistics','wp-support-plus-responsive');?></h3>
		  </div>
		  <div class="panel-body">
		    <?php include_once( WCE_PLUGIN_DIR.'includes/admin/statistics.php' );?>
		  </div>
		</div>
		<?php 
	}
}

$GLOBALS['WPSupportPlusAdmin'] =new WPSupportPlusAdmin();
?>
