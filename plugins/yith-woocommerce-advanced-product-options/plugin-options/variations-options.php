<?php
/**
 * GENERAL ARRAY OPTIONS
 */

$variations = array(

	'variations'  => array(

		array(
			'title' => __( 'Manage variations', 'yith-woocommerce-advanced-product-options' ),
			'type' => 'title',
			'desc' => '',
			'id' => 'yith-wccl-general-options'
		),

		array(
			'title'    => __( 'Attribute behavior', 'yith-wccl' ),
			'desc'     => __( 'Choose attribute style after selection.', 'yith-wccl' ),
			'id'       => 'yith-wccl-attributes-style',
			'default'  => 'hide',
			'type'     => 'radio',
			'options'  => array(
				'hide'  => __( 'Hide attributes', 'yith-wccl' ),
				'grey'  => __( 'Blur attributes', 'yith-wccl' )
			),
			'desc_tip' =>  true
		),

		array(
			'id'        => 'yith-wccl-enable-tooltip',
			'title'     => __( 'Enable tooltip', 'yith-woocommerce-advanced-product-options' ),
			'type'      => 'checkbox',
			'desc'      => __( 'Enable tooltip on attributes', 'yith-woocommerce-advanced-product-options' ),
			'default'   => 'yes'
		),

		array(
			'id'        => 'yith-wccl-tooltip-position',
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
			'id'        => 'yith-wccl-tooltip-animation',
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
			'id'        => 'yith-wccl-tooltip-background',
			'title'     => __( 'Tooltip background', 'yith-woocommerce-advanced-product-options' ),
			'desc'      => __( 'Pick a color', 'yith-woocommerce-advanced-product-options' ),
			'type'      => 'color',
			'default'   => '#222222'
		),

		array(
			'id'        => 'yith-wccl-tooltip-text-color',
			'title'     => __( 'Tooltip text color', 'yith-woocommerce-advanced-product-options' ),
			'desc'      => __( 'Pick a color', 'yith-woocommerce-advanced-product-options' ),
			'type'      => 'color',
			'default'   => '#ffffff'
		),

		array(
			'id'        => 'yith-wccl-enable-description',
			'title'     => __( 'Show attribute description', 'yith-woocommerce-advanced-product-options' ),
			'type'      => 'checkbox',
			'desc'      => __( 'Show description below attributes in single product page', 'yith-woocommerce-advanced-product-options' ),
			'default'   => 'yes'
		),

		array(
			'id'        => 'yith-wccl-enable-in-loop',
			'title'     => __( 'Enable plugin in archive page', 'yith-woocommerce-advanced-product-options' ),
			'type'      => 'checkbox',
			'desc'      => __( 'Allow attribute selection in archive shop page', 'yith-woocommerce-advanced-product-options' ),
			'default'   => 'yes'
		),

		array(
			'id'        => 'yith-wccl-position-in-loop',
			'title'     => __( 'Show add-ons', 'yith-woocommerce-advanced-product-options' ),
			'desc'      => __( 'Show add-ons in archive shop page', 'yith-woocommerce-advanced-product-options' ),
			'type'      => 'select',
			'options'   => array(
				'before'    => __( 'Before \'Add to cart\' button', 'yith-woocommerce-advanced-product-options' ),
				'after'    => __( 'After \'Add to cart\' button', 'yith-woocommerce-advanced-product-options' )
			),
			'default'   => 'after'
		),

		array(
			'id'        => 'yith-wccl-add-to-cart-label',
			'title'     => __( '\'Add to cart\' button label', 'yith-woocommerce-advanced-product-options' ),
			'type'      => 'text',
			'desc'      => __( '\'Add to cart\' button label in archive page (for variable products only)', 'yith-woocommerce-advanced-product-options' ),
			'default'   => __( 'Add to cart', 'yith-woocommerce-advanced-product-options' )
		),

		array(
			'type'      => 'sectionend',
			'id'        => 'yith-wccl-general-options'
		)
	)
);

return apply_filters( 'yith_wapo_panel_variations_options', $variations );