<?php
/**
 * GENERAL ARRAY OPTIONS
 */

$general = array(

	'general'  => array(

		array(
	        'title'		=> __( 'General', 'yith-woocommerce-advanced-product-options' ),
	        'type'		=> 'title',
	        'desc'		=> '',
	        'id'		=> 'yith_wapo_settings_type'
	    ),
	    array(
			'title'     => __( 'Show add-ons', 'yith-woocommerce-advanced-product-options' ),
			'id'        => 'yith_wapo_settings_formposition',
			'type'      => 'select',
			'options'   => array(
				'before'       => __( 'Before "Add to cart" button', 'yith-woocommerce-advanced-product-options' ),
				'after'    => __( 'After "Add to cart" button', 'yith-woocommerce-advanced-product-options' )
			),
			'default'   => 'before'
		),
	    array(
	        'title'		=> __( '"Add to cart" button label', 'yith-woocommerce-advanced-product-options' ),
	        'type'		=> 'text',
	        'desc'		=> __( 'Change button label.', 'yith-woocommerce-advanced-product-options' ),
	        'id'  		=> 'yith_wapo_settings_addtocartlabel',
	        'default' 	=> 'Select Options',
	        'css'     	=> 'min-width: 350px;',
		    'desc_tip'	=> true,
	    ),
	    array(
	        'type' 		=> 'sectionend',
	        'id' 		=> 'yith_wapo_settings_end'
	    ),

		array(
	        'title'		=> __( 'Add-ons', 'yith-woocommerce-advanced-product-options' ),
	        'type'		=> 'title',
	        'desc'		=> '',
	        'id'		=> 'yith_wapo_settings_type'
	    ),
	    array(
	        'title'		=> __( 'Show add-on titles', 'yith-woocommerce-advanced-product-options' ),
	        'type'		=> 'checkbox',
	        'id'  		=> 'yith_wapo_settings_showlabeltype',
	        'default' 	=> 'yes',
	    ),
	    array(
	        'title'		=> __( 'Show add-on images', 'yith-woocommerce-advanced-product-options' ),
	        'type'		=> 'checkbox',
	        'id'  		=> 'yith_wapo_settings_showimagetype',
	        'default' 	=> 'yes',
	    ),
	    array(
	        'title'		=> __( 'Show add-on descriptions', 'yith-woocommerce-advanced-product-options' ),
	        'type'		=> 'checkbox',
	        'id'  		=> 'yith_wapo_settings_showdescrtype',
	        'default' 	=> 'yes',
	    ),
	    array(
	        'type' 		=> 'sectionend',
	        'id' 		=> 'yith_wapo_settings_end'
	    ),

		array(
	        'title'		=> __( 'Options', 'yith-woocommerce-advanced-product-options' ),
	        'type'		=> 'title',
	        'desc'		=> '',
	        'id'		=> 'yith_wapo_settings_options'
	    ),
	    array(
	        'title'		=> __( 'Show option images', 'yith-woocommerce-advanced-product-options' ),
	        'type'		=> 'checkbox',
	        'id'  		=> 'yith_wapo_settings_showimageopt',
	        'default' 	=> 'yes',
	    ),
	    array(
	        'title'		=> __( 'Show option descriptions', 'yith-woocommerce-advanced-product-options' ),
	        'type'		=> 'checkbox',
	        'id'  		=> 'yith_wapo_settings_showdescropt',
	        'default' 	=> 'yes',
	    ),
	    array(
            'name'    	=> __( 'Option image', 'yith-woocommerce-cart-messages' ),
            'type'    	=> 'yith_wapo_upload',
            'id'      	=> 'yith_wapo_settings_tooltip_icon',
            'default' 	=>	YITH_WAPO_ASSETS_URL . '/img/description-icon.png',
        ),
	    array(
	        'type' 		=> 'sectionend',
	        'id' 		=> 'yith_wapo_settings_end'
	    ),


		array(
	        'title'		=> __( 'Tooltip', 'yith-woocommerce-advanced-product-options' ),
	        'type'		=> 'title',
	        'desc'		=> '',
	        'id'		=> 'yith_wapo_settings_upload'
	    ),
	    array(
			'id'        => 'yith-wapo-enable-tooltip',
			'title'     => __( 'Enable tooltip', 'yith-woocommerce-advanced-product-options' ),
			'type'      => 'checkbox',
			'desc'      => __( 'Enable tooltip on options', 'yith-woocommerce-advanced-product-options' ),
			'default'   => 'yes'
		),
		array(
			'id'        => 'yith-wapo-tooltip-position',
			'title'     => __( 'Tooltip position', 'yith-woocommerce-advanced-product-options' ),
			'desc'      => __( 'Select tooltip position', 'yith-woocommerce-advanced-product-options' ),
			'type'      => 'select',
			'options'   => array(
				'top'       => __( 'Top', 'yith-woocommerce-advanced-product-options' ),
				'bottom'    => __( 'Bottom', 'yith-woocommerce-advanced-product-options' )
			),
			'default'   => 'top'
		),
		array(
			'id'        => 'yith-wapo-tooltip-animation',
			'title'     => __( 'Tooltip animation', 'yith-woocommerce-advanced-product-options' ),
			'desc'      => __( 'Select tooltip animation', 'yith-woocommerce-advanced-product-options' ),
			'type'      => 'select',
			'options'   => array(
				'fade'     => __( 'Fade in', 'yith-woocommerce-advanced-product-options' ),
				'slide'    => __( 'Slide in', 'yith-woocommerce-advanced-product-options' )
			),
			'default'   => 'fade'
		),
		array(
			'id'        => 'yith-wapo-tooltip-background',
			'title'     => __( 'Tooltip background', 'yith-woocommerce-advanced-product-options' ),
			'desc'      => __( 'Pick a color', 'yith-woocommerce-advanced-product-options' ),
			'type'      => 'color',
			'default'   => '#222222'
		),
		array(
			'id'        => 'yith-wapo-tooltip-text-color',
			'title'     => __( 'Tooltip text color', 'yith-woocommerce-advanced-product-options' ),
			'desc'      => __( 'Pick a color', 'yith-woocommerce-advanced-product-options' ),
			'type'      => 'color',
			'default'   => '#ffffff'
		),
	    array(
	        'type' 		=> 'sectionend',
	        'id' 		=> 'yith_wapo_settings_end'
	    ),
	    
		array(
	        'title'		=> __( 'Uploading options', 'yith-woocommerce-advanced-product-options' ),
	        'type'		=> 'title',
	        'desc'		=> '',
	        'id'		=> 'yith_wapo_settings_upload'
	    ),
	    array(
	        'title'		=> __( 'Uploading folder name', 'yith-woocommerce-advanced-product-options' ),
	        'type'		=> 'text',
	        'desc'		=> __( 'Changes will only affect future uploads.', 'yith-woocommerce-advanced-product-options' ),
	        'id'  		=> 'yith_wapo_settings_uploadfolder',
	        'default' 	=> 'yith_advanced_product_options',
	        'css'     	=> 'min-width: 350px;',
		    'desc_tip'	=> true,
	    ),
	    array(
	        'title'		=> __( 'Uploading file types', 'yith-woocommerce-advanced-product-options' ),
	        'type'		=> 'text',
	        'desc'		=> __( 'Separate file extensions using commas. Ex: .gif, .jpg, .png', 'yith-woocommerce-advanced-product-options' ),
	        'id'  		=> 'yith_wapo_settings_filetypes',
	        'default' 	=> '.gif, .jpg, .png, .rar, .txt, .zip',
	        'css'     	=> 'min-width: 350px;',
		    'desc_tip'	=>  true,
	    ),
	    array(
	        'type' 		=> 'sectionend',
	        'id' 		=> 'yith_wapo_settings_end'
	    ),

	)

);

return apply_filters( 'yith_wapo_panel_general_options', $general );