<?php
/***** Active Plugin ********/
require_once( get_template_directory().'/lib/class-tgm-plugin-activation.php' );

add_action( 'tgmpa_register', 'ya_register_required_plugins' );
function ya_register_required_plugins() {
    $plugins = array(
		array(
            'name'               => 'Woocommerce', 
            'slug'               => 'woocommerce', 
            'required'           => true, 
			'version'			 => '3.2.6'
        ),
		
        array(
            'name'               => 'SW Woocommerce', 
			'version'			 => '1.2.0',
            'slug'               => 'sw_woocommerce', 
            'source'             => get_template_directory() . '/lib/plugins/sw_woocommerce.zip', 
            'required'           => true, 
        ), 
		array(
            'name'               => 'SW Core', 
			'version'			 => '1.2.4',
            'slug'               => 'sw_core', 
            'source'             => get_template_directory() . '/lib/plugins/sw_core.zip', 
            'required'           => true, 
        ),
		array(
            'name'               => 'SW Ajax WooCommerce Search', 
			'version'			 => '1.1.2',
            'slug'               => 'sw_ajax_woocommerce_search', 
            'source'             => get_template_directory() . '/lib/plugins/sw_ajax_woocommerce_search.zip', 
            'required'           => true, 
        ),
		array(
            'name'               => 'SW WooSwatches', 
			'version'			 => '1.0.2',
            'slug'               => 'sw_wooswatches', 
            'source'             => get_template_directory() . '/lib/plugins/sw_wooswatches.zip', 
            'required'           => true, 
        ),
		array(
            'name'               => 'Visual Composer', 
			'version'			 => '5.4.5',
            'slug'               => 'js_composer', 
            'source'             => get_template_directory() . '/lib/plugins/js_composer.zip', 
            'required'           => true, 
        ),
		array(
            'name'               => 'Revolution Slider', 
			'version'			 => '5.4.6.3.1',
            'slug'               => 'revslider', 
            'source'             => get_template_directory() . '/lib/plugins/revslider.zip', 
            'required'           => true, 
        ),
		array(
            'name'               => 'One Click Install', 
            'slug'               => 'one-click-demo-import', 
            'source'             => get_template_directory() . '/lib/plugins/one-click-demo-import.zip', 
            'required'           => true, 
        ),			
		array(
            'name'     			 => 'MailChimp for WordPress Lite',
            'slug'      		 => 'mailchimp-for-wp',
            'required' 			 => true,
        ), 
		array(
            'name'      		 => 'Image Widget',
            'slug'     			 => 'image-widget',
            'required' 			 => false,
        ),
		array(
            'name'      		 => 'Contact Form 7',
            'slug'     			 => 'contact-form-7',
            'required' 			 => false,
        ),
		 array(
            'name'      		 => 'YITH Woocommerce Compare',
            'slug'      		 => 'yith-woocommerce-compare',
            'required'			 => false,			
        ),
		 array(
            'name'     			 => 'YITH Woocommerce Wishlist',
            'slug'      		 => 'yith-woocommerce-wishlist',
            'required' 			 => false,
        ), 
		array(
            'name'     			 => 'Wordpress Seo',
            'slug'      		 => 'wordpress-seo',
            'required'  		 => true,
        ),

    );
    $config = array();
	if( ya_options()->getCpanelValue('developer_mode') ): 
		$plugins[] = array(
			'name'               => esc_html__( 'Less Compile', 'maxshop' ), 
			'slug'               => 'lessphp', 
			'source'             => get_template_directory() . '/lib/plugins/lessphp.zip', 
			'required'           => true, 
		);
	endif;
    tgmpa( $plugins, $config );

}
add_action( 'vc_before_init', 'Ya_vcSetAsTheme' );
function Ya_vcSetAsTheme() {
    vc_set_as_theme();
}	