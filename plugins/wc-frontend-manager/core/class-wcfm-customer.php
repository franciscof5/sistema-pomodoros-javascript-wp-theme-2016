<?php
/**
 * WCFM plugin core
 *
 * Plugin Cutomer Support Controller
 *
 * @author 		WC Lovers
 * @package 	wcfm/core
 * @version   3.4.6
 */
 
class WCFM_Customer {

	public function __construct() {
		global $WCFM;
		
		if ( !is_admin() || defined('DOING_AJAX') ) {
			if( $is_allow_customers = apply_filters( 'wcfm_is_allow_customers', true ) ) {
				// WC Customer Query Var Filter
				add_filter( 'wcfm_query_vars', array( &$this, 'customers_wcfm_query_vars' ), 20 );
				add_filter( 'wcfm_endpoint_title', array( &$this, 'customers_wcfm_endpoint_title' ), 20, 2 );
				add_action( 'init', array( &$this, 'customers_wcfm_init' ), 20 );
				
				// WCFM Customer Endpoint Edit
				add_filter( 'wcfm_endpoints_slug', array( $this, 'wcfm_customers_endpoints_slug' ) );
				
				// WC Customer Menu Filter
				add_filter( 'wcfm_menus', array( &$this, 'customers_wcfm_menus' ), 20 );
				
				// Customers Load WCFMu Scripts
				add_action( 'wcfm_load_scripts', array( &$this, 'wcfm_customers_load_scripts' ), 30 );
				add_action( 'after_wcfm_load_scripts', array( &$this, 'wcfm_customers_load_scripts' ), 30 );
				
				// Customers Load WCFMu Styles
				add_action( 'wcfm_load_styles', array( &$this, 'wcfm_customers_load_styles' ), 30 );
				add_action( 'after_wcfm_load_styles', array( &$this, 'wcfm_customers_load_styles' ), 30 );
				
				// Customers Load WCFMu views
				add_action( 'wcfm_load_views', array( &$this, 'wcfm_customers_load_views' ), 30 );
				add_action( 'before_wcfm_load_views', array( &$this, 'wcfm_customers_load_views' ), 30 );
				
				// Customers Ajax Controllers
				add_action( 'after_wcfm_ajax_controller', array( &$this, 'wcfm_customers_ajax_controller' ) );
			}
		}
	}
	
	/**
   * WCFM Customers Query Var
   */
  function customers_wcfm_query_vars( $query_vars ) {
  	$wcfm_modified_endpoints = (array) get_option( 'wcfm_endpoints' );
  	
		$query_customers_vars = array(
			'wcfm-customers'                 => ! empty( $wcfm_modified_endpoints['wcfm-customers'] ) ? $wcfm_modified_endpoints['wcfm-customers'] : 'wcfm-customers',
			'wcfm-customers-manage'          => ! empty( $wcfm_modified_endpoints['wcfm-customers-manage'] ) ? $wcfm_modified_endpoints['wcfm-customers-manage'] : 'wcfm-customers-manage',
			'wcfm-customers-details'         => ! empty( $wcfm_modified_endpoints['wcfm-customers-details'] ) ? $wcfm_modified_endpoints['wcfm-customers-details'] : 'wcfm-customers-details',
		);
		
		$query_vars = array_merge( $query_vars, $query_customers_vars );
		
		return $query_vars;
  }
  
  /**
   * WCFM Customers End Point Title
   */
  function customers_wcfm_endpoint_title( $title, $endpoint ) {
  	global $wp;
  	switch ( $endpoint ) {
  		case 'wcfm-customers' :
				$title = __( 'Customers Dashboard', 'wc-frontend-manager' );
			break;
			case 'wcfm-customers-manage' :
				$title = __( 'Customers Manager', 'wc-frontend-manager' );
			break;
			case 'wcfm-customers-details' :
				$title = __( 'Customers Details', 'wc-frontend-manager' );
			break;
  	}
  	
  	return $title;
  }
  
  /**
   * WCFM Customers Endpoint Intialize
   */
  function customers_wcfm_init() {
  	global $WCFM_Query;
	
		// Intialize WCFM End points
		$WCFM_Query->init_query_vars();
		$WCFM_Query->add_endpoints();
		
		if( !get_option( 'wcfm_updated_end_point_wcfm_customers' ) ) {
			// Flush rules after endpoint update
			flush_rewrite_rules();
			update_option( 'wcfm_updated_end_point_wcfm_customers', 1 );
		}
  }
  
  /**
	 * WCFM Customers Endpoiint Edit
	 */
  function wcfm_customers_endpoints_slug( $endpoints ) {
		
		$customers_endpoints = array(
													'wcfm-customers'  		      => 'wcfm-customers',
													'wcfm-customers-manage'  	  => 'wcfm-customers-manage',
													'wcfm-customers-details'    => 'wcfm-customers-details'
													);
		$endpoints = array_merge( $endpoints, $customers_endpoints );
		
		return $endpoints;
	}
  
  /**
   * WCFM Customers Menu
   */
  function customers_wcfm_menus( $menus ) {
  	global $WCFM;
  	
		$customers_menus = array( 'wcfm-customers' => array(   'label'  => __( 'Customers', 'wc-frontend-manager'),
																													 'url'       => get_wcfm_customers_url(),
																													 'icon'      => 'user-circle-o',
																													 'priority'  => 46
																													) );
		$menus = array_merge( $menus, $customers_menus );
		
  	return $menus;
  }
  
  /**
   * Customers Scripts
   */
  public function wcfm_customers_load_scripts( $end_point ) {
	  global $WCFM;
    
	  switch( $end_point ) {
	  	case 'wcfm-customers':
      	$WCFM->library->load_datatable_lib();
	    	wp_enqueue_script( 'wcfm_customers_js', $WCFM->library->js_lib_url . 'customers/wcfm-script-customers.js', array('jquery', 'dataTables_js'), $WCFM->version, true );
	    	
	    	// Screen manager
	    	$wcfm_screen_manager = (array) get_option( 'wcfm_screen_manager' );
	    	$wcfm_screen_manager_data = array();
	    	if( isset( $wcfm_screen_manager['customer'] ) ) $wcfm_screen_manager_data = $wcfm_screen_manager['customer'];
	    	if( !isset( $wcfm_screen_manager_data['admin'] ) ) {
					$wcfm_screen_manager_data['admin'] = $wcfm_screen_manager_data;
					$wcfm_screen_manager_data['vendor'] = $wcfm_screen_manager_data;
				}
				if( wcfm_is_vendor() ) {
					$wcfm_screen_manager_data = $wcfm_screen_manager_data['vendor'];
				} else {
					$wcfm_screen_manager_data = $wcfm_screen_manager_data['admin'];
				}
	    	wp_localize_script( 'wcfm_customers_js', 'wcfm_customers_screen_manage', $wcfm_screen_manager_data );
      break;
      
      case 'wcfm-customers-manage':
	  		wp_enqueue_script( 'wcfm_customers_manage_js', $WCFM->library->js_lib_url . 'customers/wcfm-script-customers-manage.js', array('jquery'), $WCFM->version, true );
	  	break;
      
      case 'wcfm-customers-details':
	    	wp_enqueue_script( 'wcfm_customers_details_js', $WCFM->library->js_lib_url . 'customers/wcfm-script-customers-details.js', array('jquery'), $WCFM->version, true );
      break;
	  }
	}
	
	/**
   * Customers Styles
   */
	public function wcfm_customers_load_styles( $end_point ) {
	  global $WCFM, $WCFMu;
		
	  switch( $end_point ) {
	    case 'wcfm-customers':
	    	wp_enqueue_style( 'wcfm_customers_css',  $WCFM->library->css_lib_url . 'customers/wcfm-style-customers.css', array(), $WCFM->version );
		  break;
		  
		  case 'wcfm-customers-manage':
		  	wp_enqueue_style( 'collapsible_css',  $WCFM->library->css_lib_url . 'wcfm-style-collapsible.css', array(), $WCFM->version );
	  		wp_enqueue_style( 'wcfm_customers_manage_css',  $WCFM->library->css_lib_url . 'customers/wcfm-style-customers-manage.css', array(), $WCFM->version );
	  	break;
		  
		  case 'wcfm-customers-details':
		  	wp_enqueue_style( 'collapsible_css',  $WCFM->library->css_lib_url . 'wcfm-style-collapsible.css', array(), $WCFM->version );
	    	wp_enqueue_style( 'wcfm_customers_details_css',  $WCFM->library->css_lib_url . 'customers/wcfm-style-customers-details.css', array(), $WCFM->version );
		  break;
	  }
	}
	
	/**
   * Customers Views
   */
  public function wcfm_customers_load_views( $end_point ) {
	  global $WCFM, $WCFMu;
	  
	  switch( $end_point ) {
	  	case 'wcfm-customers':
        require_once( $WCFM->library->views_path . 'customers/wcfm-view-customers.php' );
      break;
      
      case 'wcfm-customers-manage':
        require_once( $WCFM->library->views_path . 'customers/wcfm-view-customers-manage.php' );
      break;
      
      case 'wcfm-customers-details':
        require_once( $WCFM->library->views_path . 'customers/wcfm-view-customers-details.php' );
      break;
	  }
	}
	
	/**
   * Customers Ajax Controllers
   */
  public function wcfm_customers_ajax_controller() {
  	global $WCFM, $WCFMu;
  	
  	$controllers_path = $WCFM->plugin_path . 'controllers/customers/';
  	
  	$controller = '';
  	if( isset( $_POST['controller'] ) ) {
  		$controller = $_POST['controller'];
  		
  		switch( $controller ) {
  			case 'wcfm-customers':
					require_once( $controllers_path . 'wcfm-controller-customers.php' );
					new WCFM_Customers_Controller();
				break;
				
				case 'wcfm-customers-manage':
					require_once( $controllers_path . 'wcfm-controller-customers-manage.php' );
					new WCFM_Customers_Manage_Controller();
				break;
				
				case 'wcfm-customers-details':
					require_once( $controllers_path . 'wcfm-controller-customers-details.php' );
					new WCFM_Customers_Details_Controller();
				break;
  		}
  	}
  }
}