<?php
/**
 * Customizer
 *
 * @package twentig
 */

/**
 * Register custom control types.
 *
 * @param WP_Customize_Manager $wp_customize Theme Customizer object.
 */
function twentig_twentyone_register_control_types( $wp_customize ) {
	require TWENTIG_PATH . 'inc/theme-tools/class-twentig-customize-checkbox-multiple-control.php';
	require TWENTIG_PATH . 'inc/theme-tools/class-twentig-customize-select-optgroup-control.php';
	require TWENTIG_PATH . 'inc/theme-tools/class-twentig-customize-dropdown-pages-private-control.php';
	require TWENTIG_PATH . 'inc/theme-tools/class-twentig-customize-dropdown-reusable-blocks-control.php';
	require TWENTIG_PATH . 'inc/theme-tools/class-twentig-customize-font-presets-control.php';
	require TWENTIG_PATH . 'inc/theme-tools/class-twentig-customize-title-control.php';
	require TWENTIG_PATH . 'inc/theme-tools/class-twentig-customize-range-control.php';
	require TWENTIG_PATH . 'inc/theme-tools/class-twentig-customize-more-section.php';
	$wp_customize->register_section_type( 'Twentig_Customize_Range_Control' );
	$wp_customize->register_section_type( 'Twentig_Customize_Title_Control' );
	$wp_customize->register_section_type( 'Twentig_Customize_More_Section' );
}
add_action( 'customize_register', 'twentig_twentyone_register_control_types' );

/**
 * Add new Customizer parameters.
 *
 * @param WP_Customize_Manager $wp_customize Theme Customizer object.
 */
function twentig_twentyone_customize_register( $wp_customize ) {

	/*
	 * Site Identity
	 */
	$wp_customize->add_setting(
		'twentig_custom_logo_alt',
		array(
			'theme_supports' => array( 'custom-logo' ),
		)
	);

	$custom_logo_args = get_theme_support( 'custom-logo' );
	$wp_customize->add_control(
		new WP_Customize_Cropped_Image_Control(
			$wp_customize,
			'twentig_custom_logo_alt',
			array(
				'label'         => __( 'Alternate Logo', 'twentig' ),
				'description'   => __( 'White version of the logo for transparent header and footer with dark background.', 'twentig' ),
				'section'       => 'title_tagline',
				'priority'      => 9,
				'height'        => isset( $custom_logo_args[0]['height'] ) ? $custom_logo_args[0]['height'] : null,
				'width'         => isset( $custom_logo_args[0]['width'] ) ? $custom_logo_args[0]['width'] : null,
				'flex_height'   => isset( $custom_logo_args[0]['flex-height'] ) ? $custom_logo_args[0]['flex-height'] : null,
				'flex_width'    => isset( $custom_logo_args[0]['flex-width'] ) ? $custom_logo_args[0]['flex-width'] : null,
				'button_labels' => array(
					'select'       => __( 'Select logo' ),
					'change'       => __( 'Change logo' ),
					'remove'       => __( 'Remove' ),
					'default'      => __( 'Default' ),
					'placeholder'  => __( 'No logo selected' ),
					'frame_title'  => __( 'Select logo' ),
					'frame_button' => __( 'Choose logo' ),
				),
			)
		)
	);

	$wp_customize->add_setting(
		'twentig_hide_tagline',
		array(
			'default'           => 0,
			'sanitize_callback' => 'absint',
		)
	);

	$wp_customize->add_control(
		'twentig_hide_tagline',
		array(
			'label'    => __( 'Hide Tagline', 'twentig' ),
			'type'     => 'checkbox',
			'section'  => 'title_tagline',
			'priority' => 10,
		)
	);

	$wp_customize->add_setting(
		'twentig_logo_width',
		array(
			'sanitize_callback' => 'twentig_sanitize_integer',
		)
	);

	$wp_customize->add_control(
		new Twentig_Customize_Range_Control(
			$wp_customize,
			'twentig_logo_width',
			array(
				'label'       => __( 'Logo Width (px)', 'twentig' ),
				'section'     => 'title_tagline',
				'input_attrs' => array(
					'min'  => 20,
					'max'  => 300,
					'step' => 10,
				),
				'priority'    => 11,
			)
		)
	);

	$wp_customize->add_setting(
		'twentig_logo_width_mobile',
		array(
			'sanitize_callback' => 'twentig_sanitize_integer',
		)
	);

	$wp_customize->add_control(
		new Twentig_Customize_Range_Control(
			$wp_customize,
			'twentig_logo_width_mobile',
			array(
				'label'       => __( 'Logo Width on Mobile (px)', 'twentig' ),
				'section'     => 'title_tagline',
				'input_attrs' => array(
					'min'  => 20,
					'max'  => 300,
					'step' => 10,
				),
				'priority'    => 12,
			)
		)
	);

	/*
	 * Colors
	 */

	// Get the palette from theme-supports.
	$palette        = get_theme_support( 'editor-color-palette' );
	$palette_colors = array();
	if ( isset( $palette[0] ) && is_array( $palette[0] ) ) {
		foreach ( $palette[0] as $palette_color ) {
			$palette_colors[] = $palette_color['color'];
		}
	}

	$wp_customize->add_setting(
		'twentig_inner_background_color',
		array(
			'sanitize_callback' => 'sanitize_hex_color',
		)
	);
	$wp_customize->add_control(
		new Twenty_Twenty_One_Customize_Color_Control(
			$wp_customize,
			'twentig_inner_background_color',
			array(
				'section' => 'colors',
				'label'   => __( 'Inner Background Color', 'twentig' ),
				'palette' => $palette_colors,
			)
		)
	);

	$colors = array(
		array(
			'label' => __( 'Body', 'twentig' ),
			'id'    => 'body',
		),
		array( 'twentig_primary_color', __( 'Text Color', 'twentig' ) ),
		array( 'twentig_content_link_color', __( 'Content Link Color', 'twentig' ) ),
		array(
			'label' => __( 'Buttons', 'twentig' ),
			'id'    => 'buttons',
		),
		array( 'twentig_button_background_color', __( 'Background Color', 'twentig' ) ),
		array( 'twentig_button_text_color', __( 'Text Color', 'twentig' ) ),
		array( 'twentig_button_hover_background_color', __( 'Hover Background Color', 'twentig' ) ),
		array(
			'label' => __( 'Header', 'twentig' ),
			'id'    => 'header',
		),
		array( 'twentig_header_background_color', __( 'Background Color', 'twentig' ) ),
		array( 'twentig_branding_color', __( 'Site Title Color', 'twentig' ) ),
		array( 'twentig_header_link_color', __( 'Link Color', 'twentig' ) ),
		array( 'twentig_header_link_hover_color', __( 'Link Hover/Active Color', 'twentig' ) ),
		array(
			'label' => __( 'Footer', 'twentig' ),
			'id'    => 'footer',
		),
		array( 'twentig_footer_background_color', __( 'Background Color', 'twentig' ) ),
		array( 'twentig_footer_text_color', __( 'Text Color', 'twentig' ) ),
		array( 'twentig_footer_link_color', __( 'Link Color', 'twentig' ) ),
		array(
			'label' => __( 'Footer Widgets', 'twentig' ),
			'id'    => 'widgets',
		),
		array( 'twentig_widgets_background_color', __( 'Background Color', 'twentig' ) ),
		array( 'twentig_widgets_text_color', __( 'Text Color', 'twentig' ) ),
		array( 'twentig_widgets_link_color', __( 'Link Color', 'twentig' ) ),
	);

	foreach ( $colors as $color ) {
		if ( isset( $color['label'] ) ) {
			$wp_customize->add_control(
				new Twentig_Customize_Title_Control(
					$wp_customize,
					'twentig_colors_title_' . sanitize_title( $color['id'] ),
					array(
						'label'    => $color['label'],
						'section'  => 'colors',
						'settings' => array(),
					)
				)
			);
		} else {
			$wp_customize->add_setting(
				$color[0],
				array(
					'sanitize_callback' => 'sanitize_hex_color',
				)
			);
			$wp_customize->add_control(
				new Twenty_Twenty_One_Customize_Color_Control(
					$wp_customize,
					$color[0],
					array(
						'section' => 'colors',
						'label'   => $color[1],
						'palette' => $palette_colors,
					)
				)
			);
		}
	}

	$wp_customize->get_control( 'twentig_colors_title_body' )->priority = -1;

	$wp_customize->add_setting(
		'twentig_subtle_background_color',
		array(
			'transport'         => 'postMessage',
			'sanitize_callback' => 'sanitize_hex_color',
		)
	);

	/*
	 * Twentig Options Panel
	 */

	$wp_customize->add_panel(
		'twentig_twentytwentyone_panel',
		array(
			'title'    => __( 'Twentig Options', 'twentig' ),
			'priority' => 150,
		)
	);

	/**
	 * Site Layout
	 */

	$wp_customize->add_section(
		'twentig_layout_section',
		array(
			'title'    => __( 'Site Layout', 'twentig' ),
			'panel'    => 'twentig_twentytwentyone_panel',
			'priority' => 1,
		)
	);

	$wp_customize->add_setting(
		'twentig_site_width',
		array(
			'sanitize_callback' => 'twentig_sanitize_integer',
		)
	);

	$wp_customize->add_control(
		new Twentig_Customize_Range_Control(
			$wp_customize,
			'twentig_site_width',
			array(
				'label'       => __( 'Site Max-Width (px)', 'twentig' ),
				'section'     => 'twentig_layout_section',
				'input_attrs' => array(
					'min'  => 1200,
					'max'  => 2000,
					'step' => 20,
				),
			)
		)
	);

	$wp_customize->add_setting(
		'twentig_default_width',
		array(
			'transport'         => 'postMessage',
			'default'           => 610,
			'sanitize_callback' => 'twentig_sanitize_integer',
		)
	);

	$wp_customize->add_control(
		new Twentig_Customize_Range_Control(
			$wp_customize,
			'twentig_default_width',
			array(
				'label'       => __( 'Text Width (px)', 'twentig' ),
				'section'     => 'twentig_layout_section',
				'input_attrs' => array(
					'min'  => 600,
					'max'  => 1000,
					'step' => 10,
				),
			)
		)
	);

	$wp_customize->add_setting(
		'twentig_wide_width',
		array(
			'transport'         => 'postMessage',
			'default'           => 1240,
			'sanitize_callback' => 'twentig_sanitize_integer',
		)
	);

	$wp_customize->add_control(
		new Twentig_Customize_Range_Control(
			$wp_customize,
			'twentig_wide_width',
			array(
				'label'       => __( 'Wide Width (px)', 'twentig' ),
				'section'     => 'twentig_layout_section',
				'input_attrs' => array(
					'min'  => 1000,
					'max'  => 1400,
					'step' => 10,
				),
			)
		)
	);

	/*
	 * Fonts
	 */

	$wp_customize->add_section(
		'twentig_fonts_section',
		array(
			'title'    => __( 'Fonts', 'twentig' ),
			'panel'    => 'twentig_twentytwentyone_panel',
			'priority' => 5,
		)
	);

	$wp_customize->add_control(
		new Twentig_Customize_Font_Presets_Control(
			$wp_customize,
			'twentig_font_presets',
			array(
				'section'  => 'twentig_fonts_section',
				'settings' => array(),
			)
		)
	);

	$wp_customize->add_control(
		new Twentig_Customize_Title_Control(
			$wp_customize,
			'twentig_fonts_section_title_body',
			array(
				'label'    => __( 'Body', 'twentig' ),
				'section'  => 'twentig_fonts_section',
				'settings' => array(),
			)
		)
	);

	$wp_customize->add_setting(
		'twentig_body_font',
		array(
			'transport'         => 'postMessage',
			'sanitize_callback' => 'twentig_sanitize_fonts',
		)
	);

	$wp_customize->add_control(
		new Twentig_Customize_Select_Optgroup_Control(
			$wp_customize,
			'twentig_body_font',
			array(
				'label'   => __( 'Body Font', 'twentig' ),
				'section' => 'twentig_fonts_section',
				'choices' => array(
					esc_html__( 'Default Theme Font', 'twentig' )      => array(
						'' => __( 'System UI Font', 'twentig' ),
					),
					esc_html__( 'Curated Google Fonts', 'twentig' )    => twentig_twentyone_get_font_choices( 'body', true ),
					esc_html__( 'Additional Google Fonts', 'twentig' ) => twentig_twentyone_get_font_choices( 'body', false ),
				),
			)
		)
	);

	$wp_customize->add_setting(
		'twentig_body_font_size',
		array(
			'default'           => 20,
			'transport'         => 'postMessage',
			'sanitize_callback' => 'twentig_sanitize_integer',
		)
	);

	$wp_customize->add_control(
		new Twentig_Customize_Range_Control(
			$wp_customize,
			'twentig_body_font_size',
			array(
				'label'       => __( 'Body Font Size (px)', 'twentig' ),
				'section'     => 'twentig_fonts_section',
				'input_attrs' => array(
					'min'  => 16,
					'max'  => 22,
					'step' => 1,
				),
			)
		)
	);

	$wp_customize->add_setting(
		'twentig_body_line_height',
		array(
			'default'           => 1.7,
			'transport'         => 'postMessage',
			'sanitize_callback' => 'twentig_sanitize_float',
		)
	);

	$wp_customize->add_control(
		new Twentig_Customize_Range_Control(
			$wp_customize,
			'twentig_body_line_height',
			array(
				'label'       => __( 'Body Line Height', 'twentig' ),
				'section'     => 'twentig_fonts_section',
				'input_attrs' => array(
					'min'  => 1,
					'max'  => 2,
					'step' => 0.1,
				),
			)
		)
	);

	$wp_customize->add_control(
		new Twentig_Customize_Title_Control(
			$wp_customize,
			'twentig_fonts_section_title_headings',
			array(
				'label'    => __( 'Headings', 'twentig' ),
				'section'  => 'twentig_fonts_section',
				'settings' => array(),
			)
		)
	);

	$wp_customize->add_setting(
		'twentig_heading_font',
		array(
			'transport'         => 'postMessage',
			'sanitize_callback' => 'twentig_sanitize_fonts',
		)
	);

	$wp_customize->add_control(
		new Twentig_Customize_Select_Optgroup_Control(
			$wp_customize,
			'twentig_heading_font',
			array(
				'label'   => __( 'Headings Font', 'twentig' ),
				'section' => 'twentig_fonts_section',
				'choices' => array(
					esc_html__( 'Default Theme Font', 'twentig' )      => array(
						'' => __( 'System Font', 'twentig' ),
					),
					esc_html__( 'Curated Google Fonts', 'twentig' )    => twentig_twentyone_get_font_choices( 'heading', true ),
					esc_html__( 'Additional Google Fonts', 'twentig' ) => twentig_twentyone_get_font_choices( 'heading', false ),
				),
			)
		)
	);

	$wp_customize->add_setting(
		'twentig_heading_font_weight',
		array(
			'default'           => '400',
			'transport'         => 'postMessage',
			'sanitize_callback' => 'twentig_sanitize_font_weight',
		)
	);

	$wp_customize->add_control(
		'twentig_heading_font_weight',
		array(
			'label'   => __( 'Headings Font Weight', 'twentig' ),
			'section' => 'twentig_fonts_section',
			'type'    => 'select',
			'choices' => array(),
		)
	);

	$wp_customize->add_setting(
		'twentig_heading_letter_spacing',
		array(
			'default'           => 0,
			'transport'         => 'postMessage',
			'sanitize_callback' => 'twentig_sanitize_float',
		)
	);

	$wp_customize->add_control(
		new Twentig_Customize_Range_Control(
			$wp_customize,
			'twentig_heading_letter_spacing',
			array(
				'label'       => __( 'Headings Letter Spacing', 'twentig' ),
				'section'     => 'twentig_fonts_section',
				'input_attrs' => array(
					'min'  => -0.05,
					'max'  => 0.05,
					'step' => 0.001,
				),
			)
		)
	);

	$wp_customize->add_setting(
		'twentig_h1_font_size',
		array(
			'default'           => 96,
			'transport'         => 'postMessage',
			'sanitize_callback' => 'twentig_sanitize_integer',
		)
	);

	$wp_customize->add_control(
		new Twentig_Customize_Range_Control(
			$wp_customize,
			'twentig_h1_font_size',
			array(
				'label'       => __( 'Page Title Font Size (px)', 'twentig' ),
				'section'     => 'twentig_fonts_section',
				'input_attrs' => array(
					'min'  => 56,
					'max'  => 96,
					'step' => 1,
				),
			)
		)
	);

	$wp_customize->add_control(
		new Twentig_Customize_Title_Control(
			$wp_customize,
			'twentig_fonts_section_title_tertiary_font',
			array(
				'label'    => __( 'Secondary Elements', 'twentig' ),
				'section'  => 'twentig_fonts_section',
				'settings' => array(),
			)
		)
	);

	$wp_customize->add_setting(
		'twentig_secondary_elements_font',
		array(
			'default'           => 'body',
			'transport'         => 'postMessage',
			'sanitize_callback' => 'twentig_sanitize_choices',
		)
	);

	$wp_customize->add_control(
		'twentig_secondary_elements_font',
		array(
			'label'       => __( 'Secondary Elements Font', 'twentig' ),
			'section'     => 'twentig_fonts_section',
			'type'        => 'select',
			'choices'     => array(
				'body'    => __( 'Body Font', 'twentig' ),
				'heading' => __( 'Headings Font', 'twentig' ),
			),
			'description' => __( 'Applies to meta, footer, buttons, captions, inputs…', 'twentig' ),
		)
	);

	$wp_customize->add_control(
		new Twentig_Customize_Title_Control(
			$wp_customize,
			'twentig_fonts_section_title_logo',
			array(
				'label'    => __( 'Site Title', 'twentig' ),
				'section'  => 'twentig_fonts_section',
				'settings' => array(),
			)
		)
	);

	$wp_customize->add_setting(
		'twentig_logo_font',
		array(
			'transport'         => 'postMessage',
			'sanitize_callback' => 'twentig_sanitize_fonts',
		)
	);

	$wp_customize->add_control(
		new Twentig_Customize_Select_Optgroup_Control(
			$wp_customize,
			'twentig_logo_font',
			array(
				'label'   => __( 'Site Title Font', 'twentig' ),
				'section' => 'twentig_fonts_section',
				'choices' => array(
					esc_html__( 'Default Theme Font', 'twentig' )      => array(
						'' => __( 'Headings Font', 'twentig' ),
					),
					esc_html__( 'Curated Google Fonts', 'twentig' )    => twentig_twentyone_get_font_choices( 'heading', true ),
					esc_html__( 'Additional Google Fonts', 'twentig' ) => twentig_twentyone_get_font_choices( 'heading', false ),
				),
			)
		)
	);

	$wp_customize->add_setting(
		'twentig_logo_font_weight',
		array(
			'default'           => '400',
			'transport'         => 'postMessage',
			'sanitize_callback' => 'twentig_sanitize_font_weight',
		)
	);

	$wp_customize->add_control(
		'twentig_logo_font_weight',
		array(
			'label'   => __( 'Site Title Font Weight', 'twentig' ),
			'section' => 'twentig_fonts_section',
			'type'    => 'select',
			'choices' => array(),
		)
	);

	$wp_customize->add_setting(
		'twentig_logo_font_size',
		array(
			'transport'         => 'postMessage',
			'default'           => 24,
			'sanitize_callback' => 'twentig_sanitize_integer',
		)
	);

	$wp_customize->add_control(
		new Twentig_Customize_Range_Control(
			$wp_customize,
			'twentig_logo_font_size',
			array(
				'label'       => __( 'Site Title Font Size (px)', 'twentig' ),
				'section'     => 'twentig_fonts_section',
				'input_attrs' => array(
					'min'  => 10,
					'max'  => 80,
					'step' => 1,
				),
			)
		)
	);

	$wp_customize->add_setting(
		'twentig_logo_font_size_mobile',
		array(
			'transport'         => 'postMessage',
			'sanitize_callback' => 'twentig_sanitize_integer',
		)
	);

	$wp_customize->add_control(
		new Twentig_Customize_Range_Control(
			$wp_customize,
			'twentig_logo_font_size_mobile',
			array(
				'label'       => __( 'Site Title Font Size on Mobile (px)', 'twentig' ),
				'section'     => 'twentig_fonts_section',
				'input_attrs' => array(
					'min'  => 10,
					'max'  => 80,
					'step' => 1,
				),
			)
		)
	);

	$wp_customize->add_setting(
		'twentig_logo_letter_spacing',
		array(
			'transport'         => 'postMessage',
			'default'           => 0,
			'sanitize_callback' => 'twentig_sanitize_float',
		)
	);

	$wp_customize->add_control(
		new Twentig_Customize_Range_Control(
			$wp_customize,
			'twentig_logo_letter_spacing',
			array(
				'label'       => __( 'Site Title Letter Spacing', 'twentig' ),
				'section'     => 'twentig_fonts_section',
				'input_attrs' => array(
					'min'  => -0.1,
					'max'  => 0.1,
					'step' => 0.001,
				),
			)
		)
	);

	$wp_customize->add_setting(
		'twentig_logo_text_transform',
		array(
			'default'           => 'uppercase',
			'transport'         => 'postMessage',
			'sanitize_callback' => 'twentig_sanitize_choices',
		)
	);

	$wp_customize->add_control(
		'twentig_logo_text_transform',
		array(
			'label'   => __( 'Site Title Text Transform', 'twentig' ),
			'section' => 'twentig_fonts_section',
			'type'    => 'select',
			'choices' => array(
				'none'       => _x( 'None', 'text transform', 'twentig' ),
				'uppercase'  => __( 'Uppercase', 'twentig' ),
				'lowercase'  => __( 'Lowercase', 'twentig' ),
				'capitalize' => __( 'Capitalize', 'twentig' ),
			),
		)
	);

	$wp_customize->add_control(
		new Twentig_Customize_Title_Control(
			$wp_customize,
			'twentig_fonts_section_title_menu',
			array(
				'label'    => __( 'Primary Menu', 'twentig' ),
				'section'  => 'twentig_fonts_section',
				'settings' => array(),
			)
		)
	);

	$wp_customize->add_setting(
		'twentig_menu_font',
		array(
			'default'           => 'body',
			'transport'         => 'postMessage',
			'sanitize_callback' => 'twentig_sanitize_choices',
		)
	);

	$wp_customize->add_control(
		'twentig_menu_font',
		array(
			'label'   => __( 'Menu Font', 'twentig' ),
			'section' => 'twentig_fonts_section',
			'type'    => 'select',
			'choices' => array(
				'body'    => __( 'Body Font', 'twentig' ),
				'heading' => __( 'Headings Font', 'twentig' ),
			),
		)
	);

	$wp_customize->add_setting(
		'twentig_menu_font_weight',
		array(
			'default'           => '400',
			'transport'         => 'postMessage',
			'sanitize_callback' => 'twentig_sanitize_font_weight',
		)
	);

	$wp_customize->add_control(
		'twentig_menu_font_weight',
		array(
			'label'   => __( 'Menu Font Weight', 'twentig' ),
			'section' => 'twentig_fonts_section',
			'type'    => 'select',
			'choices' => array(),
		)
	);

	$wp_customize->add_setting(
		'twentig_menu_font_size',
		array(
			'transport'         => 'postMessage',
			'default'           => 20,
			'sanitize_callback' => 'twentig_sanitize_integer',
		)
	);

	$wp_customize->add_control(
		new Twentig_Customize_Range_Control(
			$wp_customize,
			'twentig_menu_font_size',
			array(
				'label'       => __( 'Menu Font Size (px)', 'twentig' ),
				'section'     => 'twentig_fonts_section',
				'input_attrs' => array(
					'min'  => 14,
					'max'  => 22,
					'step' => 1,
				),
			)
		)
	);

	$wp_customize->add_setting(
		'twentig_menu_letter_spacing',
		array(
			'default'           => 0,
			'transport'         => 'postMessage',
			'sanitize_callback' => 'twentig_sanitize_float',
		)
	);

	$wp_customize->add_control(
		new Twentig_Customize_Range_Control(
			$wp_customize,
			'twentig_menu_letter_spacing',
			array(
				'label'       => __( 'Menu Letter Spacing', 'twentig' ),
				'section'     => 'twentig_fonts_section',
				'input_attrs' => array(
					'min'  => -0.1,
					'max'  => 0.1,
					'step' => 0.001,
				),
			)
		)
	);

	$wp_customize->add_setting(
		'twentig_menu_text_transform',
		array(
			'transport'         => 'postMessage',
			'sanitize_callback' => 'twentig_sanitize_choices',
		)
	);

	$wp_customize->add_control(
		'twentig_menu_text_transform',
		array(
			'label'   => __( 'Menu Text Transform', 'twentig' ),
			'section' => 'twentig_fonts_section',
			'type'    => 'select',
			'choices' => array(
				''           => _x( 'None', 'text transform', 'twentig' ),
				'uppercase'  => __( 'Uppercase', 'twentig' ),
				'lowercase'  => __( 'Lowercase', 'twentig' ),
				'capitalize' => __( 'Capitalize', 'twentig' ),
			),
		)
	);

	/*
	 * Header
	 */

	$wp_customize->add_section(
		'twentig_header_section',
		array(
			'title'    => __( 'Header', 'twentig' ),
			'panel'    => 'twentig_twentytwentyone_panel',
			'priority' => 10,
		)
	);

	$wp_customize->add_control(
		new Twentig_Customize_Title_Control(
			$wp_customize,
			'twentig_header_section_title_header',
			array(
				'label'    => __( 'Layout', 'twentig' ),
				'section'  => 'twentig_header_section',
				'settings' => array(),
			)
		)
	);

	$wp_customize->add_setting(
		'twentig_header_layout',
		array(
			'sanitize_callback' => 'twentig_sanitize_choices',
		)
	);

	$wp_customize->add_control(
		'twentig_header_layout',
		array(
			'label'   => __( 'Header Layout', 'twentig' ),
			'section' => 'twentig_header_section',
			'type'    => 'select',
			'choices' => array(
				''              => __( 'Default', 'twentig' ),
				'inline-left'   => is_rtl() ? __( 'Menu on Right', 'twentig' ) : __( 'Menu on Left', 'twentig' ),
				'inline-center' => __( 'Centered Menu', 'twentig' ),
				'stack-left'    => is_rtl() ? _x( 'Stack on Right', 'layout', 'twentig' ) : _x( 'Stack on Left', 'layout', 'twentig' ),
				'stack-center'  => _x( 'Centered Stack', 'layout', 'twentig' ),
			),
		)
	);

	$wp_customize->add_setting(
		'twentig_header_width',
		array(
			'sanitize_callback' => 'twentig_sanitize_choices',
		)
	);

	$wp_customize->add_control(
		'twentig_header_width',
		array(
			'label'   => __( 'Header Width', 'twentig' ),
			'section' => 'twentig_header_section',
			'type'    => 'select',
			'choices' => array(
				''     => _x( 'Wide', 'width', 'twentig' ),
				'full' => _x( 'Full', 'width', 'twentig' ),
			),
		)
	);

	$wp_customize->add_setting(
		'twentig_header_padding',
		array(
			'default'           => 'large',
			'sanitize_callback' => 'twentig_sanitize_choices',
		)
	);

	$wp_customize->add_control(
		'twentig_header_padding',
		array(
			'label'   => __( 'Header Padding', 'twentig' ),
			'section' => 'twentig_header_section',
			'type'    => 'select',
			'choices' => array(
				'small'  => _x( 'Small', 'width', 'twentig' ),
				'medium' => _x( 'Medium', 'width', 'twentig' ),
				'large'  => _x( 'Large', 'width', 'twentig' ),
			),
		)
	);

	$wp_customize->add_setting(
		'twentig_header_sticky',
		array(
			'default'           => 0,
			'sanitize_callback' => 'absint',
		)
	);

	$wp_customize->add_control(
		'twentig_header_sticky',
		array(
			'label'   => __( 'Sticky Header', 'twentig' ),
			'section' => 'twentig_header_section',
			'type'    => 'checkbox',
		)
	);

	$wp_customize->add_setting(
		'twentig_header_decoration',
		array(
			'sanitize_callback' => 'twentig_sanitize_choices',
		)
	);

	$wp_customize->add_control(
		'twentig_header_decoration',
		array(
			'label'   => __( 'Header Decoration', 'twentig' ),
			'section' => 'twentig_header_section',
			'type'    => 'select',
			'choices' => array(
				''       => _x( 'None', 'decoration', 'twentig' ),
				'border' => __( 'Border', 'twentig' ),
				'shadow' => __( 'Shadow', 'twentig' ),
			),
		)
	);

	$wp_customize->add_setting(
		'twentig_header_breakpoint',
		array(
			'default'           => 'mobile',
			'sanitize_callback' => 'twentig_sanitize_choices',
		)
	);

	$wp_customize->add_control(
		'twentig_header_breakpoint',
		array(
			'label'   => __( 'Header Breakpoint', 'twentig' ),
			'section' => 'twentig_header_section',
			'type'    => 'select',
			'choices' => array(
				'mobile'           => __( 'Mobile', 'twentig' ),
				'tablet'           => __( 'Portrait Tablet', 'twentig' ),
				'tablet-landscape' => __( 'Landscape Tablet', 'twentig' ),
			),
		)
	);

	$wp_customize->add_control(
		new Twentig_Customize_Title_Control(
			$wp_customize,
			'twentig_header_section_title_menu',
			array(
				'label'       => __( 'Menu', 'twentig' ),
				'section'     => 'twentig_header_section',
				'description' => sprintf(
					/* translators: link to fonts panel */
					__( 'Visit the <a href="%s">Fonts panel</a> to set the menu font.', 'twentig' ),
					"javascript:wp.customize.control( 'twentig_menu_font' ).focus();"
				),
				'settings'    => array(),
			)
		)
	);

	$wp_customize->add_setting(
		'twentig_menu_spacing',
		array(
			'sanitize_callback' => 'twentig_sanitize_choices',
		)
	);

	$wp_customize->add_control(
		'twentig_menu_spacing',
		array(
			'label'   => __( 'Menu Item Spacing', 'twentig' ),
			'section' => 'twentig_header_section',
			'type'    => 'select',
			'choices' => array(
				''       => _x( 'Small', 'spacing', 'twentig' ),
				'medium' => _x( 'Medium', 'spacing', 'twentig' ),
				'large'  => _x( 'Large', 'spacing', 'twentig' ),
			),
		)
	);

	$wp_customize->add_setting(
		'twentig_menu_hover',
		array(
			'sanitize_callback' => 'twentig_sanitize_choices',
		)
	);

	$wp_customize->add_control(
		'twentig_menu_hover',
		array(
			'label'   => __( 'Menu Link Hover/Active Style', 'twentig' ),
			'section' => 'twentig_header_section',
			'type'    => 'select',
			'choices' => array(
				''       => __( 'Default', 'twentig' ),
				'border' => __( 'Border', 'twentig' ),
				'none'   => __( 'None', 'twentig' ),
			),
		)
	);

	$wp_customize->add_control(
		new Twentig_Customize_Title_Control(
			$wp_customize,
			'twentig_header_section_other_elements',
			array(
				'label'    => __( 'Additional Elements', 'twentig' ),
				'section'  => 'twentig_header_section',
				'settings' => array(),
			)
		)
	);

	$wp_customize->add_setting(
		'twentig_header_social_icons',
		array(
			'default'           => 0,
			'sanitize_callback' => 'absint',
		)
	);

	$wp_customize->add_control(
		'twentig_header_social_icons',
		array(
			'label'   => __( 'Convert menu social links into social icons', 'twentig' ),
			'section' => 'twentig_header_section',
			'type'    => 'checkbox',
		)
	);

	$wp_customize->add_setting(
		'twentig_header_button',
		array(
			'default'           => 0,
			'sanitize_callback' => 'absint',
		)
	);

	$wp_customize->add_control(
		'twentig_header_button',
		array(
			'label'   => __( 'Convert last menu item into a button', 'twentig' ),
			'section' => 'twentig_header_section',
			'type'    => 'checkbox',
		)
	);

	$wp_customize->add_setting(
		'twentig_header_search',
		array(
			'default'           => 0,
			'sanitize_callback' => 'absint',
		)
	);

	$wp_customize->add_control(
		'twentig_header_search',
		array(
			'label'   => __( 'Display a search bar', 'twentig' ),
			'section' => 'twentig_header_section',
			'type'    => 'checkbox',
		)
	);

	/*
	 * Footer
	 */

	$wp_customize->add_section(
		'twentig_footer_section',
		array(
			'title'    => __( 'Footer', 'twentig' ),
			'panel'    => 'twentig_twentytwentyone_panel',
			'priority' => 15,
		)
	);

	$wp_customize->add_control(
		new Twentig_Customize_Title_Control(
			$wp_customize,
			'twentig_footer_section_title_layout',
			array(
				'label'    => __( 'Footer', 'twentig' ),
				'section'  => 'twentig_footer_section',
				'settings' => array(),
			)
		)
	);

	$wp_customize->add_setting(
		'twentig_footer_layout',
		array(
			'sanitize_callback' => 'twentig_sanitize_choices',
		)
	);

	$wp_customize->add_control(
		'twentig_footer_layout',
		array(
			'label'   => __( 'Footer Layout', 'twentig' ),
			'section' => 'twentig_footer_section',
			'type'    => 'select',
			'choices' => array(
				''       => __( 'Default', 'twentig' ),
				'inline' => __( 'Inline', 'twentig' ),
				'stack'  => _x( 'Stack', 'layout', 'twentig' ),
				'custom' => __( 'Blocks', 'twentig' ),
				'hidden' => __( 'Hidden', 'twentig' ),
			),
		)
	);

	$wp_customize->add_setting(
		'twentig_footer_content',
		array(
			'default'           => 0,
			'sanitize_callback' => 'twentig_sanitize_block_id',
		)
	);

	$wp_customize->add_control(
		new Twentig_Customize_Dropdown_Reusable_Blocks_Control(
			$wp_customize,
			'twentig_footer_content',
			array(
				'label'       => __( 'Footer Content', 'twentig' ),
				'section'     => 'twentig_footer_section',
				'description' => sprintf(
					/* translators: %s: URL to the Reusable Blocks admin page. */
					__( 'Create the footer with <a href="%s" target="_blank" class="external-link">Reusable Blocks</a>.', 'twentig' ),
					esc_url_raw( admin_url( 'edit.php?post_type=wp_block' ) )
				),
			)
		)
	);

	$wp_customize->add_setting(
		'twentig_footer_width',
		array(
			'sanitize_callback' => 'twentig_sanitize_choices',
		)
	);

	$wp_customize->add_control(
		'twentig_footer_width',
		array(
			'label'   => __( 'Footer Width', 'twentig' ),
			'section' => 'twentig_footer_section',
			'type'    => 'select',
			'choices' => array(
				''     => _x( 'Wide', 'width', 'twentig' ),
				'full' => _x( 'Full', 'width', 'twentig' ),
			),
		)
	);

	$wp_customize->add_setting(
		'twentig_footer_credit',
		array(
			'sanitize_callback' => 'twentig_sanitize_choices',
		)
	);

	$wp_customize->add_control(
		'twentig_footer_credit',
		array(
			'label'   => __( 'Credit', 'twentig' ),
			'section' => 'twentig_footer_section',
			'type'    => 'select',
			'choices' => array(
				''       => __( 'Default', 'twentig' ),
				'custom' => _x( 'Custom', 'footer credit', 'twentig' ),
				'none'   => _x( 'None', 'footer credit', 'twentig' ),
			),
		)
	);

	$wp_customize->add_setting(
		'twentig_footer_credit_text',
		array(
			'sanitize_callback' => 'wp_kses_post',
		)
	);

	$wp_customize->add_control(
		'twentig_footer_credit_text',
		array(
			'label'       => __( 'Custom Credit', 'twentig' ),
			'section'     => 'twentig_footer_section',
			'type'        => 'text',
			'description' => __( 'To automatically display the current year, insert <code>[Y]</code>', 'twentig' ),
		)
	);

	$wp_customize->add_setting(
		'twentig_footer_branding',
		array(
			'default'           => 1,
			'sanitize_callback' => 'absint',
		)
	);

	$wp_customize->add_control(
		'twentig_footer_branding',
		array(
			'label'   => __( 'Display site title/logo', 'twentig' ),
			'section' => 'twentig_footer_section',
			'type'    => 'checkbox',
		)
	);

	$wp_customize->add_setting(
		'twentig_footer_social_icons',
		array(
			'default'           => 1,
			'sanitize_callback' => 'absint',
		)
	);

	$wp_customize->add_control(
		'twentig_footer_social_icons',
		array(
			'label'   => __( 'Convert menu social links into social icons', 'twentig' ),
			'section' => 'twentig_footer_section',
			'type'    => 'checkbox',
		)
	);

	$wp_customize->add_setting(
		'twentig_footer_link_style',
		array(
			'sanitize_callback' => 'twentig_sanitize_choices',
		)
	);

	$wp_customize->add_control(
		'twentig_footer_link_style',
		array(
			'label'   => __( 'Footer Link Style', 'twentig' ),
			'section' => 'twentig_footer_section',
			'type'    => 'select',
			'choices' => array(
				''        => _x( 'Underline', 'style', 'twentig' ),
				'minimal' => _x( 'Underline on hover', 'style', 'twentig' ),
			),
		)
	);

	$wp_customize->add_control(
		new Twentig_Customize_Title_Control(
			$wp_customize,
			'twentig_footer_section_title_styles',
			array(
				'label'    => __( 'Footer Widgets', 'twentig' ),
				'section'  => 'twentig_footer_section',
				'settings' => array(),
			)
		)
	);

	$wp_customize->add_setting(
		'twentig_footer_widgets_columns',
		array(
			'default'           => '3',
			'sanitize_callback' => 'twentig_sanitize_choices',
		)
	);

	$wp_customize->add_control(
		'twentig_footer_widgets_columns',
		array(
			'label'   => __( 'Columns', 'twentig' ),
			'section' => 'twentig_footer_section',
			'type'    => 'select',
			'choices' => array(
				'1' => '1',
				'2' => '2',
				'3' => '3',
				'4' => '4',
			),
		)
	);

	$wp_customize->add_setting(
		'twentig_footer_widgets_width',
		array(
			'sanitize_callback' => 'twentig_sanitize_choices',
		)
	);

	$wp_customize->add_control(
		'twentig_footer_widgets_width',
		array(
			'label'   => __( 'Footer Widgets Width', 'twentig' ),
			'section' => 'twentig_footer_section',
			'type'    => 'select',
			'choices' => array(
				''     => _x( 'Wide', 'width', 'twentig' ),
				'full' => _x( 'Full', 'width', 'twentig' ),
			),
		)
	);

	/*
	 * Page
	 */

	$wp_customize->add_section(
		'twentig_page_section',
		array(
			'title'    => _x( 'Page', 'Customizer Section Title', 'twentig' ),
			'panel'    => 'twentig_twentytwentyone_panel',
			'priority' => 20,
		)
	);

	$wp_customize->add_control(
		new Twentig_Customize_Title_Control(
			$wp_customize,
			'twentig_page_section_title_standard',
			array(
				'label'    => __( 'Standard Pages', 'twentig' ),
				'section'  => 'twentig_page_section',
				'settings' => array(),
			)
		)
	);

	$wp_customize->add_setting(
		'twentig_page_hero_layout',
		array(
			'sanitize_callback' => 'twentig_sanitize_choices',
		)
	);

	$wp_customize->add_control(
		'twentig_page_hero_layout',
		array(
			'label'   => __( 'Featured Image Layout', 'twentig' ),
			'section' => 'twentig_page_section',
			'type'    => 'select',
			'choices' => array(
				''             => __( 'Default', 'twentig' ),
				'narrow-image' => _x( 'Narrow', 'image width', 'twentig' ),
				'full-image'   => __( 'Full Width', 'twentig' ),
				'no-image'     => __( 'No Image', 'twentig' ),
				'cover'        => __( 'Cover', 'twentig' ),
				'cover-full'   => __( 'Fullscreen Cover', 'twentig' ),
			),
		)
	);

	$wp_customize->add_setting(
		'twentig_page_image_placement',
		array(
			'default'           => 'below',
			'sanitize_callback' => 'twentig_sanitize_choices',
		)
	);

	$wp_customize->add_control(
		'twentig_page_image_placement',
		array(
			'label'   => __( 'Featured Image Placement', 'twentig' ),
			'section' => 'twentig_page_section',
			'type'    => 'select',
			'choices' => array(
				'above' => __( 'Above', 'twentig' ),
				'below' => __( 'Below', 'twentig' ),
			),
		)
	);

	$wp_customize->add_setting(
		'twentig_page_title_width',
		array(
			'default'           => 'wide',
			'sanitize_callback' => 'twentig_sanitize_choices',
		)
	);

	$wp_customize->add_control(
		'twentig_page_title_width',
		array(
			'label'   => __( 'Page Title Width', 'twentig' ),
			'section' => 'twentig_page_section',
			'type'    => 'select',
			'choices' => array(
				'text-width' => _x( 'Text Width', 'twentig' ),
				'wide'       => _x( 'Wide', 'width', 'twentig' ),
			),
		)
	);

	$wp_customize->add_setting(
		'twentig_page_title_text_align',
		array(
			'sanitize_callback' => 'twentig_sanitize_choices',
		)
	);

	$wp_customize->add_control(
		'twentig_page_title_text_align',
		array(
			'label'   => __( 'Page Title Text Alignment', 'twentig' ),
			'section' => 'twentig_page_section',
			'type'    => 'select',
			'choices' => array(
				''       => is_rtl() ? __( 'Right', 'twentig' ) : __( 'Left', 'twentig' ),
				'center' => __( 'Center', 'twentig' ),
			),
		)
	);

	$wp_customize->add_setting(
		'twentig_page_title_border',
		array(
			'default'           => 1,
			'sanitize_callback' => 'absint',
		)
	);

	$wp_customize->add_control(
		'twentig_page_title_border',
		array(
			'section' => 'twentig_page_section',
			'label'   => __( 'Display a separator between the title and the content', 'twentig' ),
			'type'    => 'checkbox',
		)
	);

	$wp_customize->add_control(
		new Twentig_Customize_Title_Control(
			$wp_customize,
			'twentig_page_section_title_search',
			array(
				'label'    => __( 'Search Page', 'twentig' ),
				'section'  => 'twentig_page_section',
				'settings' => array(),
			)
		)
	);

	$wp_customize->add_setting(
		'twentig_page_search_layout',
		array(
			'sanitize_callback' => 'twentig_sanitize_choices',
		)
	);

	$wp_customize->add_control(
		'twentig_page_search_layout',
		array(
			'label'   => __( 'Search Results Layout', 'twentig' ),
			'section' => 'twentig_page_section',
			'type'    => 'select',
			'choices' => array(
				''            => __( 'Default', 'twentig' ),
				'blog-layout' => __( 'Blog', 'twentig' ),
			),
		)
	);

	$wp_customize->add_control(
		new Twentig_Customize_Title_Control(
			$wp_customize,
			'twentig_page_section_title_404',
			array(
				'label'    => __( '404 Page', 'twentig' ),
				'section'  => 'twentig_page_section',
				'settings' => array(),
			)
		)
	);

	$wp_customize->add_setting(
		'twentig_page_404',
		array(
			'default'           => '0',
			'sanitize_callback' => 'absint',
		)
	);

	$wp_customize->add_control(
		new Twentig_Customize_Dropdown_Pages_Private_Control(
			$wp_customize,
			'twentig_page_404',
			array(
				'label'       => __( 'Custom 404 Page', 'twentig' ),
				'section'     => 'twentig_page_section',
				'description' => __( 'To set a 404 page, you’ll first need to create a private page (to prevent search engines from indexing this page).', 'twentig' ),
			)
		)
	);

	/*
	 * Blog
	 */

	$wp_customize->add_section(
		'twentig_blog_section',
		array(
			'title'    => __( 'Blog', 'twentig' ),
			'panel'    => 'twentig_twentytwentyone_panel',
			'priority' => 25,
		)
	);

	$wp_customize->add_control(
		new Twentig_Customize_Title_Control(
			$wp_customize,
			'twentig_blog_section_posts_title',
			array(
				'label'    => __( 'Posts Page', 'twentig' ),
				'section'  => 'twentig_blog_section',
				'settings' => array(),
			)
		)
	);

	$wp_customize->add_setting(
		'twentig_blog_layout',
		array(
			'default'           => 'stack',
			'sanitize_callback' => 'twentig_sanitize_choices',
		)
	);

	$wp_customize->add_control(
		'twentig_blog_layout',
		array(
			'label'   => __( 'Blog Layout', 'twentig' ),
			'section' => 'twentig_blog_section',
			'type'    => 'select',
			'choices' => array(
				'stack' => _x( 'Stack', 'layout', 'twentig' ),
				'grid'  => __( 'Grid', 'twentig' ),
			),
		)
	);

	$wp_customize->add_setting(
		'twentig_blog_sidebar',
		array(
			'default'           => 0,
			'sanitize_callback' => 'absint',
		)
	);

	$wp_customize->add_control(
		'twentig_blog_sidebar',
		array(
			'label'       => __( 'Display sidebar', 'twentig' ),
			'section'     => 'twentig_blog_section',
			'type'        => 'checkbox',
			'description' => sprintf(
				/* translators: link to widgets panel */
				__( 'Create the sidebar in the <a href="%s">Widgets panel</a>.', 'twentig' ),
				"javascript:wp.customize.panel( 'widgets' ).focus();"
			),
		)
	);

	$wp_customize->add_setting(
		'twentig_blog_style',
		array(
			'default'           => 'separator',
			'sanitize_callback' => 'twentig_sanitize_choices',
		)
	);

	$wp_customize->add_control(
		'twentig_blog_style',
		array(
			'label'   => __( 'Blog Style', 'twentig' ),
			'section' => 'twentig_blog_section',
			'type'    => 'select',
			'choices' => array(
				'minimal'     => __( 'Minimal', 'twentig' ),
				'separator'   => __( 'Separator', 'twentig' ),
				'card-shadow' => __( 'Card with shadow', 'twentig' ),
				'card-border' => __( 'Card with border', 'twentig' ),
			),
		)
	);

	$wp_customize->add_setting(
		'twentig_blog_columns',
		array(
			'default'           => '3',
			'sanitize_callback' => 'twentig_sanitize_choices',
		)
	);

	$wp_customize->add_control(
		'twentig_blog_columns',
		array(
			'label'   => __( 'Columns', 'twentig' ),
			'section' => 'twentig_blog_section',
			'type'    => 'select',
			'choices' => array(
				'2' => '2',
				'3' => '3',
			),
		)
	);

	$wp_customize->add_setting(
		'twentig_blog_image',
		array(
			'default'           => 1,
			'sanitize_callback' => 'absint',
		)
	);

	$wp_customize->add_control(
		'twentig_blog_image',
		array(
			'section' => 'twentig_blog_section',
			'label'   => __( 'Display featured image', 'twentig' ),
			'type'    => 'checkbox',
		)
	);

	$wp_customize->add_setting(
		'twentig_blog_image_placement',
		array(
			'default'           => 'below',
			'sanitize_callback' => 'twentig_sanitize_choices',
		)
	);

	$wp_customize->add_control(
		'twentig_blog_image_placement',
		array(
			'label'   => __( 'Featured Image Placement', 'twentig' ),
			'section' => 'twentig_blog_section',
			'type'    => 'select',
			'choices' => array(
				'above' => __( 'Above', 'twentig' ),
				'below' => __( 'Below', 'twentig' ),
			),
		)
	);

	$wp_customize->add_setting(
		'twentig_blog_image_width',
		array(
			'default'           => 'wide',
			'sanitize_callback' => 'twentig_sanitize_choices',
		)
	);

	$wp_customize->add_control(
		'twentig_blog_image_width',
		array(
			'label'   => __( 'Featured Image Width', 'twentig' ),
			'section' => 'twentig_blog_section',
			'type'    => 'select',
			'choices' => array(
				'text-width' => __( 'Text Width', 'twentig' ),
				'wide'       => __( 'Wide', 'twentig' ),
			),
		)
	);

	$wp_customize->add_setting(
		'twentig_blog_image_ratio',
		array(
			'sanitize_callback' => 'twentig_sanitize_choices',
		)
	);

	$wp_customize->add_control(
		'twentig_blog_image_ratio',
		array(
			'label'   => __( 'Featured Image Aspect Ratio', 'twentig' ),
			'section' => 'twentig_blog_section',
			'type'    => 'select',
			'choices' => array(
				''     => _x( 'Original', 'image aspect ratio', 'twentig' ),
				'20-9' => '20:9',
				'16-9' => '16:9',
				'3-2'  => '3:2',
				'4-3'  => '4:3',
				'1-1'  => __( 'Square', 'twentig' ),
				'3-4'  => '3:4',
				'2-3'  => '2:3',
			),
		)
	);

	$wp_customize->add_setting(
		'twentig_blog_title_size',
		array(
			'sanitize_callback' => 'twentig_sanitize_choices',
		)
	);

	$wp_customize->add_control(
		'twentig_blog_title_size',
		array(
			'label'   => __( 'Posts Title Font Size', 'twentig' ),
			'section' => 'twentig_blog_section',
			'type'    => 'select',
			'choices' => array(
				''            => __( 'Default', 'twentig' ),
				'medium'      => __( 'Medium', 'twentig' ),
				'h4'          => 'H4',
				'h3'          => 'H3',
				'extra-large' => __( 'Extra Large', 'twentig' ),
				'h2'          => 'H2',
			),
		)
	);

	$wp_customize->add_setting(
		'twentig_blog_content',
		array(
			'default'           => 1,
			'sanitize_callback' => 'absint',
		)
	);

	$wp_customize->add_control(
		'twentig_blog_content',
		array(
			'label'       => __( 'Display post content', 'twentig' ),
			'section'     => 'twentig_blog_section',
			'type'        => 'checkbox',
			'description' => sprintf(
				/* translators: link to theme options panel */
				__( 'Set the post content in the <a href="%s">Excerpt Settings panel</a>.', 'twentig' ),
				"javascript:wp.customize.section( 'excerpt_settings' ).focus();"
			),
		)
	);

	$wp_customize->add_setting(
		'twentig_blog_excerpt_length',
		array(
			'sanitize_callback' => 'twentig_sanitize_integer',
		)
	);

	$wp_customize->add_control(
		'twentig_blog_excerpt_length',
		array(
			'label'       => __( 'Excerpt Length (words)', 'twentig' ),
			'section'     => 'twentig_blog_section',
			'type'        => 'number',
			'input_attrs' => array(
				'min'  => 10,
				'step' => 1,
			),
		)
	);

	$wp_customize->add_setting(
		'twentig_blog_excerpt_more',
		array(
			'default'           => 1,
			'sanitize_callback' => 'absint',
		)
	);

	$wp_customize->add_control(
		'twentig_blog_excerpt_more',
		array(
			'label'   => __( 'Display “Continue reading”', 'twentig' ),
			'section' => 'twentig_blog_section',
			'type'    => 'checkbox',
		)
	);

	$wp_customize->add_setting(
		'twentig_blog_text_align',
		array(
			'sanitize_callback' => 'twentig_sanitize_choices',
		)
	);

	$wp_customize->add_control(
		'twentig_blog_text_align',
		array(
			'label'   => __( 'Text Alignment', 'twentig' ),
			'section' => 'twentig_blog_section',
			'type'    => 'select',
			'choices' => array(
				''       => is_rtl() ? __( 'Right', 'twentig' ) : __( 'Left', 'twentig' ),
				'center' => __( 'Center', 'twentig' ),
			),
		)
	);

	$wp_customize->add_setting(
		'twentig_blog_meta',
		array(
			'default'           => array(
				'date',
				'categories',
				'tags',
			),
			'sanitize_callback' => 'twentig_sanitize_multi_choices',
		)
	);

	$wp_customize->add_control(
		new Twentig_Customize_Checkbox_Multiple_Control(
			$wp_customize,
			'twentig_blog_meta',
			array(
				'label'   => __( 'Post Meta', 'twentig' ),
				'section' => 'twentig_blog_section',
				'choices' => array(
					'date'       => __( 'Date', 'twentig' ),
					'author'     => __( 'Author', 'twentig' ),
					'categories' => __( 'Categories', 'twentig' ),
					'tags'       => __( 'Tags', 'twentig' ),
					'comments'   => _x( 'Comment', 'noun', 'twentig' ),
				),
			)
		)
	);

	$wp_customize->add_setting(
		'twentig_blog_meta_label',
		array(
			'default'           => 1,
			'sanitize_callback' => 'absint',
		)
	);

	$wp_customize->add_control(
		'twentig_blog_meta_label',
		array(
			'section' => 'twentig_blog_section',
			'label'   => __( 'Display meta label', 'twentig' ),
			'type'    => 'checkbox',
		)
	);

	$wp_customize->add_setting(
		'twentig_blog_pagination',
		array(
			'sanitize_callback' => 'twentig_sanitize_choices',
		)
	);

	$wp_customize->add_control(
		'twentig_blog_pagination',
		array(
			'label'   => __( 'Pagination Style', 'twentig' ),
			'section' => 'twentig_blog_section',
			'type'    => 'select',
			'choices' => array(
				''        => __( 'Default', 'twentig' ),
				'minimal' => __( 'Minimal', 'twentig' ),
				'center'  => __( 'Minimal Center', 'twentig' ),
			),
		)
	);

	$wp_customize->add_control(
		new Twentig_Customize_Title_Control(
			$wp_customize,
			'twentig_blog_section_single_title',
			array(
				'label'    => __( 'Single Post', 'twentig' ),
				'section'  => 'twentig_blog_section',
				'settings' => array(),
			)
		)
	);

	$wp_customize->add_setting(
		'twentig_post_sidebar',
		array(
			'default'           => 0,
			'sanitize_callback' => 'absint',
		)
	);

	$wp_customize->add_control(
		'twentig_post_sidebar',
		array(
			'label'       => __( 'Display sidebar', 'twentig' ),
			'section'     => 'twentig_blog_section',
			'type'        => 'checkbox',
			'description' => sprintf(
				/* translators: link to widgets panel */
				__( 'Create the sidebar in the <a href="%s">Widgets panel</a>.', 'twentig' ),
				"javascript:wp.customize.panel( 'widgets' ).focus();"
			),
		)
	);

	$wp_customize->add_setting(
		'twentig_post_hero_layout',
		array(
			'sanitize_callback' => 'twentig_sanitize_choices',
		)
	);

	$wp_customize->add_control(
		'twentig_post_hero_layout',
		array(
			'label'   => __( 'Featured Image Layout', 'twentig' ),
			'section' => 'twentig_blog_section',
			'type'    => 'select',
			'choices' => array(
				''             => __( 'Default', 'twentig' ),
				'narrow-image' => _x( 'Narrow', 'image width', 'twentig' ),
				'full-image'   => __( 'Full Width', 'twentig' ),
				'no-image'     => __( 'No Image', 'twentig' ),
				'cover'        => __( 'Cover', 'twentig' ),
				'cover-full'   => __( 'Fullscreen Cover', 'twentig' ),
			),
		)
	);

	$wp_customize->add_setting(
		'twentig_post_image_placement',
		array(
			'default'           => 'below',
			'sanitize_callback' => 'twentig_sanitize_choices',
		)
	);

	$wp_customize->add_control(
		'twentig_post_image_placement',
		array(
			'label'   => __( 'Featured Image Placement', 'twentig' ),
			'section' => 'twentig_blog_section',
			'type'    => 'select',
			'choices' => array(
				'above' => __( 'Above', 'twentig' ),
				'below' => __( 'Below', 'twentig' ),
			),
		)
	);

	$wp_customize->add_setting(
		'twentig_post_title_width',
		array(
			'default'           => 'wide',
			'sanitize_callback' => 'twentig_sanitize_choices',
		)
	);

	$wp_customize->add_control(
		'twentig_post_title_width',
		array(
			'label'   => __( 'Post Title Width', 'twentig' ),
			'section' => 'twentig_blog_section',
			'type'    => 'select',
			'choices' => array(
				'text-width' => _x( 'Text Width', 'twentig' ),
				'wide'       => _x( 'Wide', 'width', 'twentig' ),
			),
		)
	);

	$wp_customize->add_setting(
		'twentig_post_title_text_align',
		array(
			'sanitize_callback' => 'twentig_sanitize_choices',
		)
	);

	$wp_customize->add_control(
		'twentig_post_title_text_align',
		array(
			'label'   => __( 'Post Title Text Alignment', 'twentig' ),
			'section' => 'twentig_blog_section',
			'type'    => 'select',
			'choices' => array(
				''       => is_rtl() ? __( 'Right', 'twentig' ) : __( 'Left', 'twentig' ),
				'center' => __( 'Center', 'twentig' ),
			),
		)
	);

	$wp_customize->add_setting(
		'twentig_post_h1_font_size',
		array(
			'transport'         => 'postMessage',
			'sanitize_callback' => 'twentig_sanitize_integer',
		)
	);

	$wp_customize->add_control(
		new Twentig_Customize_Range_Control(
			$wp_customize,
			'twentig_post_h1_font_size',
			array(
				'label'       => __( 'Post Title Font Size (px)', 'twentig' ),
				'section'     => 'twentig_blog_section',
				'input_attrs' => array(
					'min'  => 56,
					'max'  => 96,
					'step' => 1,
				),
			)
		)
	);

	$wp_customize->add_setting(
		'twentig_post_excerpt',
		array(
			'default'           => 0,
			'sanitize_callback' => 'absint',
		)
	);

	$wp_customize->add_control(
		'twentig_post_excerpt',
		array(
			'label'   => __( 'Display manual excerpt below the title', 'twentig' ),
			'section' => 'twentig_blog_section',
			'type'    => 'checkbox',
		)
	);

	$wp_customize->add_setting(
		'twentig_post_title_border',
		array(
			'default'           => 1,
			'sanitize_callback' => 'absint',
		)
	);

	$wp_customize->add_control(
		'twentig_post_title_border',
		array(
			'section' => 'twentig_blog_section',
			'label'   => __( 'Display a separator between the title and the content', 'twentig' ),
			'type'    => 'checkbox',
		)
	);

	$wp_customize->add_setting(
		'twentig_post_top_meta',
		array(
			'default'           => array(),
			'sanitize_callback' => 'twentig_sanitize_multi_choices',
		)
	);

	$wp_customize->add_control(
		new Twentig_Customize_Checkbox_Multiple_Control(
			$wp_customize,
			'twentig_post_top_meta',
			array(
				'label'   => __( 'Post Meta below Title', 'twentig' ),
				'section' => 'twentig_blog_section',
				'choices' => array(
					'date'       => __( 'Date', 'twentig' ),
					'author'     => __( 'Author', 'twentig' ),
					'categories' => __( 'Categories', 'twentig' ),
					'tags'       => __( 'Tags', 'twentig' ),
					'comments'   => _x( 'Comment', 'noun', 'twentig' ),
				),
			)
		)
	);

	$wp_customize->add_setting(
		'twentig_post_bottom_meta',
		array(
			'default'           => array(
				'date',
				'author',
				'categories',
				'tags',
			),
			'sanitize_callback' => 'twentig_sanitize_multi_choices',
		)
	);

	$wp_customize->add_control(
		new Twentig_Customize_Checkbox_Multiple_Control(
			$wp_customize,
			'twentig_post_bottom_meta',
			array(
				'label'   => __( 'Post Meta below Content', 'twentig' ),
				'section' => 'twentig_blog_section',
				'choices' => array(
					'date'       => __( 'Date', 'twentig' ),
					'author'     => __( 'Author', 'twentig' ),
					'categories' => __( 'Categories', 'twentig' ),
					'tags'       => __( 'Tags', 'twentig' ),
				),
			)
		)
	);

	$wp_customize->add_setting(
		'twentig_post_navigation',
		array(
			'sanitize_callback' => 'twentig_sanitize_choices',
		)
	);

	$wp_customize->add_control(
		'twentig_post_navigation',
		array(
			'label'   => __( 'Navigation', 'twentig' ),
			'section' => 'twentig_blog_section',
			'type'    => 'select',
			'choices' => array(
				''     => __( 'Default', 'twentig' ),
				'none' => _x( 'None', 'navigation', 'twentig' ),
			),
		)
	);

	$wp_customize->add_setting(
		'twentig_blog_comments',
		array(
			'default'           => 1,
			'sanitize_callback' => 'absint',
		)
	);

	$wp_customize->add_control(
		'twentig_blog_comments',
		array(
			'section' => 'twentig_blog_section',
			'label'   => __( 'Display comments section', 'twentig' ),
			'type'    => 'checkbox',
		)
	);

	/*
	 * Custom Post Types.
	 */

	$wp_customize->add_section(
		'twentig_cpt_section',
		array(
			'title'           => __( 'Custom Post Types', 'twentig' ),
			'panel'           => 'twentig_twentytwentyone_panel',
			'active_callback' => function() {
				return ! empty( twentig_twentyone_get_cpt() );
			},
			'priority'        => 30,
		)
	);

	$wp_customize->add_setting(
		'twentig_cpt_archive_layout',
		array(
			'sanitize_callback' => 'twentig_sanitize_choices',
		)
	);

	$wp_customize->add_control(
		'twentig_cpt_archive_layout',
		array(
			'label'   => __( 'Archive Layout', 'twentig' ),
			'section' => 'twentig_cpt_section',
			'type'    => 'select',
			'choices' => array(
				''     => __( 'Default', 'twentig' ),
				'blog' => __( 'Blog', 'twentig' ),
			),
		)
	);

	$wp_customize->add_setting(
		'twentig_cpt_single_layout',
		array(
			'sanitize_callback' => 'twentig_sanitize_choices',
		)
	);

	$wp_customize->add_control(
		'twentig_cpt_single_layout',
		array(
			'label'   => __( 'Single Post Layout', 'twentig' ),
			'section' => 'twentig_cpt_section',
			'type'    => 'select',
			'choices' => array(
				''     => __( 'Default', 'twentig' ),
				'post' => __( 'Post', 'twentig' ),
				'page' => __( 'Page', 'twentig' ),
			),
		)
	);

	/*
	 * Additional Settings
	 */

	$wp_customize->add_section(
		'twentig_additional_section',
		array(
			'title'    => __( 'Additional Settings', 'twentig' ),
			'panel'    => 'twentig_twentytwentyone_panel',
			'priority' => 40,
		)
	);

	$wp_customize->add_setting(
		'twentig_links_style',
		array(
			'sanitize_callback' => 'twentig_sanitize_choices',
		)
	);

	$wp_customize->add_control(
		'twentig_links_style',
		array(
			'label'       => __( 'Links Style', 'twentig' ),
			'section'     => 'twentig_additional_section',
			'type'        => 'select',
			'choices'     => array(
				''        => _x( 'Default', 'style', 'twentig' ),
				'minimal' => _x( 'Minimal', 'style', 'twentig' ),
			),
			'description' => __( 'The minimal style removes the background focus style and the post titles underline.', 'twentig' ),
		)
	);

	$wp_customize->add_setting(
		'twentig_border_thickness',
		array(
			'sanitize_callback' => 'twentig_sanitize_choices',
		)
	);

	$wp_customize->add_control(
		'twentig_border_thickness',
		array(
			'label'       => __( 'Border Thickness', 'twentig' ),
			'description' => __( 'Applies to buttons, separators, inputs, and elements with border.', 'twentig' ),
			'section'     => 'twentig_additional_section',
			'type'        => 'select',
			'choices'     => array(
				'thin' => _x( 'Thin', 'border thickness', 'twentig' ),
				''     => _x( 'Thick', 'border thickness', 'twentig' ),
			),
		)
	);

	$wp_customize->add_setting(
		'twentig_button_shape',
		array(
			'default'           => 'square',
			'sanitize_callback' => 'twentig_sanitize_choices',
		)
	);

	$wp_customize->add_control(
		'twentig_button_shape',
		array(
			'label'   => __( 'Button Shape', 'twentig' ),
			'section' => 'twentig_additional_section',
			'type'    => 'select',
			'choices' => array(
				'square'  => _x( 'Square', 'button shape', 'twentig' ),
				'rounded' => _x( 'Rounded', 'button shape', 'twentig' ),
				'pill'    => _x( 'Pill', 'button shape', 'twentig' ),
			),
		)
	);

	$wp_customize->add_setting(
		'twentig_button_size',
		array(
			'sanitize_callback' => 'twentig_sanitize_choices',
		)
	);

	$wp_customize->add_control(
		'twentig_button_size',
		array(
			'label'   => __( 'Button Size', 'twentig' ),
			'section' => 'twentig_additional_section',
			'type'    => 'select',
			'choices' => array(
				'small'  => __( 'Small', 'twentig' ),
				'medium' => __( 'Medium', 'twentig' ),
				''       => __( 'Large', 'twentig' ),
			),
		)
	);

	$wp_customize->add_setting(
		'twentig_button_text_transform',
		array(
			'sanitize_callback' => 'twentig_sanitize_choices',
		)
	);

	$wp_customize->add_control(
		'twentig_button_text_transform',
		array(
			'label'   => __( 'Button Text Transform', 'twentig' ),
			'section' => 'twentig_additional_section',
			'type'    => 'select',
			'choices' => array(
				''          => _x( 'None', 'text transform', 'twentig' ),
				'uppercase' => __( 'Uppercase', 'twentig' ),
			),
		)
	);

	/*
	 * Performance Settings
	 */

	$wp_customize->add_section(
		'twentig_performance_section',
		array(
			'title'    => __( 'Performance', 'twentig' ),
			'panel'    => 'twentig_twentytwentyone_panel',
			'priority' => 50,
		)
	);



	$wp_customize->add_setting(
		'twentig_theme_minify_css',
		array(
			'default'           => 0,
			'sanitize_callback' => 'absint',
		)
	);

	$wp_customize->add_control(
		'twentig_theme_minify_css',
		array(
			'section' => 'twentig_performance_section',
			'label'   => __( 'Minify the theme stylesheet to reduce its load time.', 'twentig' ),
			'type'    => 'checkbox',
		)
	);

	$wp_customize->add_setting(
		'twentig_page_contact',
		array(
			'default'           => 0,
			'sanitize_callback' => 'absint',
		)
	);

	$wp_customize->add_control(
		'twentig_page_contact',
		array(
			'section'         => 'twentig_performance_section',
			'label'           => 'Contact Form 7',
			'type'            => 'dropdown-pages',
			'description'     => __( 'Only loads the Contact Form 7 scripts on the selected page.', 'twentig' ),
			'active_callback' => function() {
				return class_exists( 'WPCF7_ContactForm' );
			},
		)
	);

	$wp_customize->add_section(
		new Twentig_Customize_More_Section(
			$wp_customize,
			'twentig_more',
			array(
				'title'       => esc_html__( 'Get more for free', 'twentig' ),
				'panel'       => 'twentig_twentytwentyone_panel',
				'button_text' => esc_html__( 'Subscribe', 'twentig' ),
				'button_url'  => 'https://twentig.com/newsletter?utm_source=wp-dash&utm_medium=customizer&utm_campaign=newsletter',
				'priority'    => 50,
			)
		)
	);

}
add_action( 'customize_register', 'twentig_twentyone_customize_register', 11 );

/**
 * Enqueue scripts for customizer preview.
 */
function twentig_twentyone_customize_preview_init() {
	wp_enqueue_script( 'twentig-twentyone-customize-preview', TWENTIG_ASSETS_URI . '/js/twentytwentyone-customize-preview.js', array( 'customize-preview' ), TWENTIG_VERSION, true );
}
add_action( 'customize_preview_init', 'twentig_twentyone_customize_preview_init', 11 );

/**
 * Enqueue scripts for customizer controls.
 */
function twentig_twentyone_customize_controls_enqueue_scripts() {

	wp_register_script( 'selectWoo', TWENTIG_ASSETS_URI . '/js/selectWoo.min.js', array( 'jquery' ), '1.0.8', true );

	wp_enqueue_script(
		'twentig-twentyone-customize-controls',
		TWENTIG_ASSETS_URI . '/js/twentytwentyone-customize-controls.js',
		array( 'selectWoo' ),
		TWENTIG_VERSION,
		true
	);

	wp_localize_script(
		'twentig-twentyone-customize-controls',
		'twentigCustomizerSettings',
		array(
			'fonts'        => twentig_twentyone_get_fonts(),
			'fontVariants' => twentig_twentyone_get_font_styles(),
			'fontPresets'  => twentig_twentyone_get_font_presets(),
		)
	);

	wp_enqueue_style(
		'selectWoo',
		TWENTIG_ASSETS_URI . '/css/selectWoo.min.css',
		array(),
		'1.0.8'
	);

	wp_enqueue_style(
		'twentig-customize-controls',
		TWENTIG_ASSETS_URI . '/css/customize-controls.css',
		array(),
		TWENTIG_VERSION
	);
}
add_action( 'customize_controls_enqueue_scripts', 'twentig_twentyone_customize_controls_enqueue_scripts', 11 );

/**
 * Outputs an Underscore template that generates dynamically the CSS for instant display in the Customizer preview.
 */
function twentig_twentyone_customizer_live_css_template() {
	?>
	<script type="text/html" id="tmpl-twentig-customizer-live-style">

		<# 
		var body_font              = data.twentig_body_font ? data.twentig_body_font : '-apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, Oxygen-Sans, Ubuntu, Cantarell, "Helvetica Neue", sans-serif';
		var body_font_size         = data.twentig_body_font_size;
		var body_line_height       = data.twentig_body_line_height;	
		var heading_font           = data.twentig_heading_font ? data.twentig_heading_font : '-apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, Oxygen-Sans, Ubuntu, Cantarell, "Helvetica Neue", sans-serif';	
		var heading_font_weight    = data.twentig_heading_font_weight;
		var heading_letter_spacing = data.twentig_heading_letter_spacing ? data.twentig_heading_letter_spacing : '0';
		var tertiary_font          = data.twentig_secondary_elements_font;
		var tertiary_font          = 'body' === tertiary_font ? 'var(--font-base)' : 'var(--font-headings)';
		var menu_font              = data.twentig_menu_font;
		var menu_font_weight       = data.twentig_menu_font_weight;
		var menu_font_size         = data.twentig_menu_font_size;
		var menu_letter_spacing    = data.twentig_menu_letter_spacing ? data.twentig_menu_letter_spacing : '0';
		var logo_font              = data.twentig_logo_font;
		var logo_font_weight       = data.twentig_logo_font_weight;
		var logo_font_size         = data.twentig_logo_font_size;
		var logo_mobile_font_size  = data.twentig_logo_font_size_mobile;
		var logo_transform         = data.twentig_logo_text_transform;
		var logo_letter_spacing    = data.twentig_logo_letter_spacing;
		var subtle_color           = data.twentig_subtle_background_color;
		var wide_width             = data.twentig_wide_width;
		var default_width          = data.twentig_default_width;
		var h1_font_size           = data.twentig_h1_font_size;
		var post_h1_font_size      = data.twentig_post_h1_font_size;
		#>

		:root{
			--font-base: {{ body_font }};

			<# if ( body_font_size ) { #>
				--global--font-size-base: {{ parseInt( body_font_size ) / 16 }}rem;
			<# } #>
			<# if ( body_line_height ) { #>
				--global--line-height-body: {{ body_line_height }};
			<# } #>

			--font-headings: {{ heading_font }};

			<# if ( heading_font_weight ) { #>
				--heading--font-weight: {{ heading_font_weight }};
				--heading--font-weight-page-title: {{ heading_font_weight }};
			<# } #>
			<# if ( heading_letter_spacing ) { #>
				--global--letter-spacing: {{ heading_letter_spacing }}em;
				--heading--letter-spacing-h5: {{ heading_letter_spacing }}em;
				--heading--letter-spacing-h6: {{ heading_letter_spacing }}em;
			<# } #>

			--global--font-tertiary: {{ tertiary_font }};

			<# if ( h1_font_size ) { #>
				--global--font-size-xxl: {{ parseInt( h1_font_size ) / 16 }}rem;
			<# } #>

			<# if ( wide_width ) { #>
				--max--alignwide-width: {{ wide_width }}px;
			<# } #>
			<# if ( default_width ) { #>
				--max--aligndefault-width: {{ default_width }}px;
			<# } #>

			<# if ( 'heading' === menu_font )  { #>
				--primary-nav--font-family: var(--font-headings);
			<# } else { #>
				--primary-nav--font-family: var(--font-base);
			<# } #>

			<# if ( menu_font_weight ) { #>
				--primary-nav--font-weight: {{ menu_font_weight }};
			<# } #>

			<# if ( menu_font_size ) { #>
				--primary-nav--font-size: {{ parseInt( menu_font_size ) / 16 }}rem;
			<# } #>

			<# if ( menu_letter_spacing ) { #>
				--primary-nav--letter-spacing: {{ menu_letter_spacing }}em;
			<# } #>

			<# if ( logo_font_size ) { #>
				--branding--title--font-size: {{ logo_font_size }}px;
				--branding--title--font-size-mobile: {{ logo_font_size }}px;
			<# } #>	

			<# if ( logo_mobile_font_size ) { #>
				--branding--title--font-size-mobile: {{ logo_mobile_font_size }}px;
			<# } #>
		}

		@media ( min-width: 822px ) { 
			.single-post h1.entry-title{
				<# if ( post_h1_font_size ) { #>
					font-size: {{ parseInt( post_h1_font_size ) / 16 }}rem;
				<# } else { #>
					font-size: {{ parseInt( h1_font_size ) / 16 }}rem;
				<# } #>
			}
		}

		.site-header .site-title, .site-footer > .site-info .site-name {
			<# if ( logo_font ) { #>
				font-family: {{ logo_font }};
			<# } #>	
			<# if ( logo_font_weight ) { #>
				font-weight: {{ logo_font_weight }};
			<# } #>			
			<# if ( logo_letter_spacing ) { #>
				letter-spacing: {{ logo_letter_spacing }}em;
			<# } #>
			<# if ( logo_transform ) { #>
				text-transform: {{ logo_transform }};
			<# } #>	
		}		

		<# if ( subtle_color ) { #>
			:root .has-subtle-background-color, :root .has-subtle-background-background-color { background-color: {{ subtle_color }}; }
			:root .has-subtle-color { color: {{ subtle_color }}; }
		<# } #>	

		<# if ( body_font_size && body_font_size > 20 ) { #>
			@media(max-width:651px) {
				:root { --global--font-size-base: 1.25rem; }
			}
		<# } #>

	</script>
	<?php
}
add_action( 'customize_controls_print_footer_scripts', 'twentig_twentyone_customizer_live_css_template' );

/**
 * Register widget area.
 */
function twentig_twentyone_widgets_init() {
	register_sidebar(
		array(
			'name'          => esc_html__( 'Blog Sidebar', 'twentig' ),
			'id'            => 'sidebar-blog',
			'description'   => esc_html__( 'Add widgets here to appear in your blog sidebar.', 'twentig' ),
			'before_widget' => '<section id="%1$s" class="widget %2$s">',
			'after_widget'  => '</section>',
			'before_title'  => '<h3 class="widget-title">',
			'after_title'   => '</h3>',
		)
	);
}
add_action( 'widgets_init', 'twentig_twentyone_widgets_init' );
