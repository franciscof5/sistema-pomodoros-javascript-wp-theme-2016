<?php
/**
 * WCFM plugin controllers
 *
 * Plugin Venodrs Manage Controller
 *
 * @author 		WC Lovers
 * @package 	wcfm/controllers/vendors
 * @version   3.4.7
 */

class WCFM_Vendors_Manage_Profile_Controller {
	
	public function __construct() {
		global $WCFM;
		
		$this->processing();
	}
	
	public function processing() {
		global $WCFM, $wpdb, $wcfm_vendor_manage_profile_form_data;
		
		$wcfm_vendor_manage_profile_form_data = array();
	  parse_str($_POST['wcfm_vendor_manage_profile_form'], $wcfm_vendor_manage_profile_form_data);
	  
	  $vendor_id = absint( $wcfm_vendor_manage_profile_form_data['vendor_id'] );
	  
	  if( $vendor_id ) {
	  	$wcfm_vendor_manage_profile_fields = apply_filters( 'wcfm_vendor_manage_profile_fields', array( 'first_name'          => 'first_name',
																																																			'last_name'           => 'last_name',
																																																		) );
			
			foreach( $wcfm_vendor_manage_profile_fields as $wcfm_vendor_manage_profile_field_key => $wcfm_vendor_manage_profile_field ) {
				update_user_meta( $vendor_id, $wcfm_vendor_manage_profile_field_key, $wcfm_vendor_manage_profile_form_data[$wcfm_vendor_manage_profile_field] );
			}
	  	
	  	do_action( 'wcfm_vendor_manage_profile_update', $vendor_id, $wcfm_vendor_manage_profile_form_data );
	  }
		
		echo '{"status": true, "message": "' . __( 'Profile saved successfully', 'wc-frontend-manager' ) . '"}';
		 
		die;
	}
}