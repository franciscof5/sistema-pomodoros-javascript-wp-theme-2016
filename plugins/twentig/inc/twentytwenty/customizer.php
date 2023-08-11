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
function twentig_twentytwenty_register_control_types( $wp_customize ) {
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
add_action( 'customize_register', 'twentig_twentytwenty_register_control_types' );

/**
 * Add new Customizer parameters.
 *
 * @param WP_Customize_Manager $wp_customize Theme Customizer object.
 */
function twentig_twentytwenty_customize_register( $wp_customize ) {

	/*
	 * Site Identity
	 */
	$wp_customize->add_setting(
		'twentig_custom_logo_transparent',
		array(
			'theme_supports' => array( 'custom-logo' ),
		)
	);

	$custom_logo_args = get_theme_support( 'custom-logo' );
	$wp_customize->add_control(
		new WP_Customize_Cropped_Image_Control(
			$wp_customize,
			'twentig_custom_logo_transparent',
			array(
				'label'         => __( 'Transparent Header Logo', 'twentig' ),
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
		'twentig_header_tagline',
		array(
			'default'           => 1,
			'sanitize_callback' => 'absint',
		)
	);

	$wp_customize->add_control(
		'twentig_header_tagline',
		array(
			'label'    => __( 'Display Tagline', 'twentig' ),
			'type'     => 'checkbox',
			'section'  => 'title_tagline',
			'priority' => 10,
		)
	);

	$wp_customize->add_setting(
		'twentig_logo_mobile_width',
		array(
			'sanitize_callback' => 'twentig_sanitize_integer',
		)
	);

	$wp_customize->add_control(
		new Twentig_Customize_Range_Control(
			$wp_customize,
			'twentig_logo_mobile_width',
			array(
				'label'       => __( 'Logo Width on Mobile (px)', 'twentig' ),
				'section'     => 'title_tagline',
				'input_attrs' => array(
					'min'  => '20',
					'max'  => '280',
					'step' => '10',
				),
				'priority'    => 12,
			)
		)
	);

	/*
	 * Colors
	 */

	$wp_customize->get_setting( 'accent_hue_active' )->transport = 'refresh';

	$wp_customize->get_control( 'accent_hue_active' )->choices = array(
		'default' => __( 'Default', 'twentig' ),
		'custom'  => __( 'Custom Hue', 'twentig' ),
		'hex'     => __( 'Custom Hexadecimal Color', 'twentig' ),
	);

	$wp_customize->add_setting(
		'twentig_accent_hex_color',
		array(
			'default'           => '',
			'sanitize_callback' => 'sanitize_hex_color',
		)
	);

	$wp_customize->add_control(
		new WP_Customize_Color_Control(
			$wp_customize,
			'twentig_accent_hex_color',
			array(
				'description' => __( 'Caution: make sure that the color is accessible throughout the site (header, content, footer).', 'twentig' ),
				'section'     => 'colors',
				'priority'    => 19,
			)
		)
	);

	$wp_customize->add_control(
		new Twentig_Customize_Title_Control(
			$wp_customize,
			'twentig_colors_section_title',
			array(
				'label'    => __( 'Twentig Colors', 'twentig' ),
				'section'  => 'colors',
				'settings' => array(),
				'priority' => 20,
			)
		)
	);

	$wp_customize->add_setting(
		'twentig_page_header_no_background',
		array(
			'default'           => 0,
			'sanitize_callback' => 'absint',
		)
	);

	$wp_customize->add_control(
		'twentig_page_header_no_background',
		array(
			'label'    => __( 'Apply “Background Color” to the page title section', 'twentig' ),
			'section'  => 'colors',
			'type'     => 'checkbox',
			'priority' => 21,
		)
	);

	$wp_customize->add_setting(
		'twentig_accessible_colors',
		array(
			'default'           => array(),
			'type'              => 'theme_mod',
			'sanitize_callback' => 'twentig_twentytwenty_sanitize_accessible_colors',
		)
	);

	$wp_customize->add_setting(
		'twentig_footer_background_color',
		array(
			'default'           => '',
			'sanitize_callback' => 'sanitize_hex_color',
		)
	);

	$wp_customize->add_control(
		new WP_Customize_Color_Control(
			$wp_customize,
			'twentig_footer_background_color',
			array(
				'label'       => __( 'Footer Background Color', 'twentig' ),
				'description' => __( 'Apply a custom color to the footer.', 'twentig' ),
				'section'     => 'colors',
				'priority'    => 22,
			)
		)
	);

	$wp_customize->add_setting(
		'twentig_subtle_background_color',
		array(
			'default'           => '',
			'transport'         => 'postMessage',
			'sanitize_callback' => 'sanitize_hex_color',
		)
	);

	/*
	 * Cover Template
	 */

	$wp_customize->add_control(
		new Twentig_Customize_Title_Control(
			$wp_customize,
			'twentig_cover_section_twentig_title',
			array(
				'label'    => __( 'Twentig Settings', 'twentig' ),
				'section'  => 'cover_template_options',
				'settings' => array(),
			)
		)
	);

	$wp_customize->add_setting(
		'twentig_cover_vertical_align',
		array(
			'default'           => '',
			'transport'         => 'postMessage',
			'sanitize_callback' => 'twentig_sanitize_choices',
		)
	);

	$wp_customize->add_control(
		'twentig_cover_vertical_align',
		array(
			'label'   => __( 'Content Vertical Alignment', 'twentig' ),
			'section' => 'cover_template_options',
			'type'    => 'select',
			'choices' => array(
				'center' => __( 'Middle', 'twentig' ),
				''       => __( 'Bottom', 'twentig' ),
			),
		)
	);

	$wp_customize->add_setting(
		'twentig_cover_page_height',
		array(
			'default'           => '',
			'transport'         => 'postMessage',
			'sanitize_callback' => 'twentig_sanitize_choices',
		)
	);

	$wp_customize->add_control(
		'twentig_cover_page_height',
		array(
			'label'   => __( 'Page Cover Height', 'twentig' ),
			'section' => 'cover_template_options',
			'type'    => 'select',
			'choices' => array(
				'medium' => _x( 'Medium', 'height', 'twentig' ),
				''       => _x( 'Full', 'height', 'twentig' ),
			),
		)
	);

	$wp_customize->add_setting(
		'twentig_cover_page_scroll_indicator',
		array(
			'default'           => 1,
			'transport'         => 'postMessage',
			'sanitize_callback' => 'absint',
		)
	);

	$wp_customize->add_control(
		'twentig_cover_page_scroll_indicator',
		array(
			'label'   => __( 'Display scroll indicator on page cover', 'twentig' ),
			'section' => 'cover_template_options',
			'type'    => 'checkbox',
		)
	);

	$wp_customize->add_setting(
		'twentig_cover_post_height',
		array(
			'default'           => '',
			'transport'         => 'postMessage',
			'sanitize_callback' => 'twentig_sanitize_choices',
		)
	);

	$wp_customize->add_control(
		'twentig_cover_post_height',
		array(
			'label'   => __( 'Post Cover Height', 'twentig' ),
			'section' => 'cover_template_options',
			'type'    => 'select',
			'choices' => array(
				'medium' => _x( 'Medium', 'height', 'twentig' ),
				''       => _x( 'Full', 'height', 'twentig' ),
			),
		)
	);

	/*
	 * Twentig Options Panel
	 */

	$wp_customize->add_panel(
		'twentig_twentytwenty_panel',
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
			'panel'    => 'twentig_twentytwenty_panel',
			'priority' => 1,
		)
	);

	$wp_customize->add_setting(
		'twentig_text_width',
		array(
			'default'           => '',
			'transport'         => 'postMessage',
			'sanitize_callback' => 'twentig_sanitize_choices',
		)
	);

	$wp_customize->add_control(
		'twentig_text_width',
		array(
			'label'   => __( 'Text Width', 'twentig' ),
			'section' => 'twentig_layout_section',
			'type'    => 'radio',
			'choices' => array(
				''       => _x( 'Narrow (default)', 'text width', 'twentig' ),
				'medium' => _x( 'Medium', 'text width', 'twentig' ),
				'wide'   => _x( 'Wide', 'text width', 'twentig' ),
			),
		)
	);

	/*
	 * Fonts
	 */

	$wp_customize->add_section(
		'twentig_fonts_section',
		array(
			'title'    => __( 'Fonts', 'twentig' ),
			'panel'    => 'twentig_twentytwenty_panel',
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
			'default'           => '',
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
					esc_html__( 'Standard Fonts', 'twentig' )       => array(
						''           => __( 'Default Theme Font', 'twentig' ),
						'sans-serif' => __( 'System UI Font', 'twentig' ),
					),
					esc_html__( 'Curated Google Fonts', 'twentig' ) => twentig_get_body_fonts(),
					esc_html__( 'Additional Fonts', 'twentig' )     => array(
						'custom-google-font' => __( 'Custom Google Font', 'twentig' ),
					),
				),
			)
		)
	);

	$wp_customize->add_setting(
		'twentig_body_font_custom',
		array(
			'sanitize_callback' => 'sanitize_text_field',
		)
	);

	$wp_customize->add_control(
		'twentig_body_font_custom',
		array(
			'label'       => __( 'Custom Body Font', 'twentig' ),
			'section'     => 'twentig_fonts_section',
			'type'        => 'text',
			'input_attrs' => array(
				'placeholder' => __( 'Font Name', 'twentig' ),
			),
			'description' => sprintf(
				/* translators: link to Google Fonts website */
				__( 'It’s recommended that the 400 italic and 700 styles be available for your <a href="%s" target="_blank">Google Font</a>.', 'twentig' ),
				'https://fonts.google.com/'
			),
		)
	);

	$wp_customize->add_setting(
		'twentig_body_font_fallback',
		array(
			'default'           => 'sans-serif',
			'transport'         => 'postMessage',
			'sanitize_callback' => 'twentig_sanitize_choices',
		)
	);

	$wp_customize->add_control(
		'twentig_body_font_fallback',
		array(
			'label'   => __( 'Fallback Body Font', 'twentig' ),
			'section' => 'twentig_fonts_section',
			'type'    => 'select',
			'choices' => array(
				'sans-serif' => 'sans-serif',
				'serif'      => 'serif',
				'monospace'  => 'monospace',
				'cursive'    => 'cursive',
			),
		)
	);

	$wp_customize->add_setting(
		'twentig_body_font_size',
		array(
			'default'           => twentig_get_default_body_font_size(),
			'transport'         => 'postMessage',
			'sanitize_callback' => 'twentig_sanitize_choices',
		)
	);

	$wp_customize->add_control(
		'twentig_body_font_size',
		array(
			'label'   => __( 'Body Font Size', 'twentig' ),
			'section' => 'twentig_fonts_section',
			'type'    => 'select',
			'choices' => array(
				'small'  => _x( 'Small', 'font size', 'twentig' ),
				'medium' => _x( 'Medium', 'font size', 'twentig' ),
				'large'  => _x( 'Large', 'font size', 'twentig' ),
			),
		)
	);

	$wp_customize->add_setting(
		'twentig_body_line_height',
		array(
			'default'           => '',
			'transport'         => 'postMessage',
			'sanitize_callback' => 'twentig_sanitize_choices',
		)
	);

	$wp_customize->add_control(
		'twentig_body_line_height',
		array(
			'label'   => __( 'Body Line Height', 'twentig' ),
			'section' => 'twentig_fonts_section',
			'type'    => 'select',
			'choices' => array(
				''       => _x( 'Tight', 'line height', 'twentig' ),
				'medium' => _x( 'Medium', 'line height', 'twentig' ),
				'loose'  => _x( 'Loose', 'line height', 'twentig' ),
			),
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
			'default'           => '',
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
					esc_html__( 'Standard Fonts', 'twentig' )       => array(
						''           => __( 'Default Theme Font', 'twentig' ),
						'sans-serif' => __( 'System UI Font', 'twentig' ),
					),
					esc_html__( 'Curated Google Fonts', 'twentig' ) => twentig_get_heading_fonts(),
					esc_html__( 'Additional Fonts', 'twentig' )     => array(
						'custom-google-font' => __( 'Custom Google Font', 'twentig' ),
					),
				),
			)
		)
	);

	$wp_customize->add_setting(
		'twentig_heading_font_custom',
		array(
			'sanitize_callback' => 'sanitize_text_field',
		)
	);

	$wp_customize->add_control(
		'twentig_heading_font_custom',
		array(
			'label'       => __( 'Custom Headings Font', 'twentig' ),
			'section'     => 'twentig_fonts_section',
			'type'        => 'text',
			'input_attrs' => array(
				'placeholder' => __( 'Font Name', 'twentig' ),
			),
			'description' => sprintf(
				/* translators: link to Google Fonts website */
				__( 'If the Headings Font is set as Secondary Font, it’s recommended that the 600 or 700 styles be available for your <a href="%s" target="_blank">Google Font</a>.', 'twentig' ),
				'https://fonts.google.com/'
			),
		)
	);

	$wp_customize->add_setting(
		'twentig_heading_font_fallback',
		array(
			'default'           => 'sans-serif',
			'transport'         => 'postMessage',
			'sanitize_callback' => 'twentig_sanitize_choices',
		)
	);

	$wp_customize->add_control(
		'twentig_heading_font_fallback',
		array(
			'label'   => __( 'Fallback Headings Font', 'twentig' ),
			'section' => 'twentig_fonts_section',
			'type'    => 'select',
			'choices' => array(
				'sans-serif' => 'sans-serif',
				'serif'      => 'serif',
				'monospace'  => 'monospace',
				'cursive'    => 'cursive',
			),
		)
	);

	$wp_customize->add_setting(
		'twentig_heading_font_weight',
		array(
			'default'           => '700',
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
			'transport'         => 'postMessage',
			'sanitize_callback' => 'twentig_sanitize_choices',
		)
	);

	$wp_customize->add_control(
		'twentig_heading_letter_spacing',
		array(
			'label'   => __( 'Headings Letter Spacing', 'twentig' ),
			'section' => 'twentig_fonts_section',
			'type'    => 'select',
			'choices' => array(
				''       => _x( 'Tight', 'letter spacing', 'twentig' ),
				'normal' => _x( 'Normal', 'letter spacing', 'twentig' ),
			),
		)
	);

	$wp_customize->add_setting(
		'twentig_h1_font_size',
		array(
			'default'           => '',
			'transport'         => 'postMessage',
			'sanitize_callback' => 'twentig_sanitize_choices',
		)
	);

	$wp_customize->add_control(
		'twentig_h1_font_size',
		array(
			'label'   => __( 'Heading 1 Font Size', 'twentig' ),
			'section' => 'twentig_fonts_section',
			'type'    => 'select',
			'choices' => array(
				'small'  => _x( 'Small', 'font size', 'twentig' ),
				'medium' => _x( 'Medium', 'font size', 'twentig' ),
				'large'  => _x( 'Large', 'font size', 'twentig' ),
				''       => _x( 'Larger', 'font size', 'twentig' ),
			),
		)
	);

	$wp_customize->add_control(
		new Twentig_Customize_Title_Control(
			$wp_customize,
			'twentig_fonts_section_title_secondary',
			array(
				'label'    => __( 'Secondary Elements', 'twentig' ),
				'section'  => 'twentig_fonts_section',
				'settings' => array(),
			)
		)
	);

	$wp_customize->add_setting(
		'twentig_secondary_font',
		array(
			'default'           => 'heading',
			'transport'         => 'postMessage',
			'sanitize_callback' => 'twentig_sanitize_choices',
		)
	);

	$wp_customize->add_control(
		'twentig_secondary_font',
		array(
			'label'       => __( 'Secondary Font', 'twentig' ),
			'section'     => 'twentig_fonts_section',
			'type'        => 'select',
			'choices'     => array(
				'body'    => __( 'Body Font', 'twentig' ),
				'heading' => __( 'Headings Font', 'twentig' ),
			),
			'description' => __( 'Applies to meta, footer, button, caption, input…', 'twentig' ),
		)
	);

	$wp_customize->add_control(
		new Twentig_Customize_Title_Control(
			$wp_customize,
			'twentig_fonts_section_title_logo',
			array(
				'label'       => __( 'Site Title', 'twentig' ),
				'section'     => 'twentig_fonts_section',
				'settings'    => array(),
				'description' => __( 'As you’ve selected an image for the Logo, font settings for the Site Title are unavailable.', 'twentig' ),
			)
		)
	);

	$wp_customize->add_setting(
		'twentig_logo_font',
		array(
			'default'           => '',
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
					esc_html__( 'Standard Fonts', 'twentig' )       => array(
						''           => __( 'Default Theme Font', 'twentig' ),
						'sans-serif' => __( 'System UI Font', 'twentig' ),
					),
					esc_html__( 'Curated Google Fonts', 'twentig' ) => twentig_get_heading_fonts(),
					esc_html__( 'Additional Fonts', 'twentig' )     => array(
						'custom-google-font' => __( 'Custom Google Font', 'twentig' ),
					),
				),
			)
		)
	);

	$wp_customize->add_setting(
		'twentig_logo_font_custom',
		array(
			'sanitize_callback' => 'sanitize_text_field',
		)
	);

	$wp_customize->add_control(
		'twentig_logo_font_custom',
		array(
			'label'       => __( 'Custom Site Title Font', 'twentig' ),
			'section'     => 'twentig_fonts_section',
			'type'        => 'text',
			'input_attrs' => array(
				'placeholder' => __( 'Font Name', 'twentig' ),
			),
			'description' => sprintf(
				/* translators: link to Google Fonts website */
				__( 'Enter a <a href="%s" target="_blank">Google Font</a> name.', 'twentig' ),
				'https://fonts.google.com/'
			),
		)
	);

	$wp_customize->add_setting(
		'twentig_logo_font_fallback',
		array(
			'default'           => 'sans-serif',
			'transport'         => 'postMessage',
			'sanitize_callback' => 'twentig_sanitize_choices',
		)
	);

	$wp_customize->add_control(
		'twentig_logo_font_fallback',
		array(
			'label'   => __( 'Fallback Site Title Font', 'twentig' ),
			'section' => 'twentig_fonts_section',
			'type'    => 'select',
			'choices' => array(
				'sans-serif' => 'sans-serif',
				'serif'      => 'serif',
				'monospace'  => 'monospace',
				'cursive'    => 'cursive',
			),
		)
	);

	$wp_customize->add_setting(
		'twentig_logo_font_weight',
		array(
			'default'           => '700',
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
			'choices' => array(
				'400' => 'Regular 400',
				'700' => 'Bold 700',
			),
		)
	);

	$wp_customize->add_setting(
		'twentig_logo_font_size',
		array(
			'transport'         => 'postMessage',
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
					'min'  => '14',
					'max'  => '72',
					'step' => 1,
				),
			)
		)
	);

	$wp_customize->add_setting(
		'twentig_logo_mobile_font_size',
		array(
			'sanitize_callback' => 'twentig_sanitize_integer',
		)
	);

	$wp_customize->add_control(
		new Twentig_Customize_Range_Control(
			$wp_customize,
			'twentig_logo_mobile_font_size',
			array(
				'label'       => __( 'Site Title Font Size on Mobile (px)', 'twentig' ),
				'section'     => 'twentig_fonts_section',
				'input_attrs' => array(
					'min'  => '14',
					'max'  => '72',
					'step' => '1',
				),
			)
		)
	);

	$wp_customize->add_setting(
		'twentig_logo_letter_spacing',
		array(
			'transport'         => 'postMessage',
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
					'min'  => '-0.1',
					'max'  => '0.2',
					'step' => '0.01',
				),
			)
		)
	);

	$wp_customize->add_setting(
		'twentig_logo_text_transform',
		array(
			'default'           => '',
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
				''           => _x( 'None', 'text transform', 'twentig' ),
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
				'label'    => __( 'Menu', 'twentig' ),
				'section'  => 'twentig_fonts_section',
				'settings' => array(),
			)
		)
	);

	$wp_customize->add_setting(
		'twentig_menu_font',
		array(
			'default'           => 'heading',
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
			'default'           => '500',
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
			'choices' => array(
				'400' => 'Regular 400',
				'700' => 'Bold 700',
			),
		)
	);

	$wp_customize->add_setting(
		'twentig_menu_font_size',
		array(
			'default'           => '',
			'transport'         => 'postMessage',
			'sanitize_callback' => 'twentig_sanitize_choices',
		)
	);

	$wp_customize->add_control(
		'twentig_menu_font_size',
		array(
			'label'   => __( 'Menu Font Size', 'twentig' ),
			'section' => 'twentig_fonts_section',
			'type'    => 'select',
			'choices' => array(
				'small'  => _x( 'Small', 'font size', 'twentig' ),
				'medium' => _x( 'Medium', 'font size', 'twentig' ),
				''       => _x( 'Large', 'font size', 'twentig' ),
				'larger' => _x( 'Larger', 'font size', 'twentig' ),
			),
		)
	);

	$wp_customize->add_setting(
		'twentig_menu_text_transform',
		array(
			'default'           => '',
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
			'panel'    => 'twentig_twentytwenty_panel',
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
			'default'           => '',
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
				''            => __( 'Default', 'twentig' ),
				'inline-left' => __( 'Menu on Left', 'twentig' ),
				'stack'       => _x( 'Stack', 'layout', 'twentig' ),
			),
		)
	);

	$wp_customize->add_setting(
		'twentig_header_width',
		array(
			'default'           => 'wider',
			'transport'         => 'postMessage',
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
				'wide'  => _x( 'Wide (1200px)', 'width', 'twentig' ),
				'wider' => _x( 'Wider (1680px)', 'width', 'twentig' ),
				'full'  => _x( 'Full', 'width', 'twentig' ),
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
			'default'           => '',
			'transport'         => 'postMessage',
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
			'default'           => '',
			'transport'         => 'postMessage',
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
		'twentig_menu_color',
		array(
			'default'           => 'accent',
			'sanitize_callback' => 'twentig_sanitize_choices',
		)
	);

	$wp_customize->add_control(
		'twentig_menu_color',
		array(
			'label'   => __( 'Menu Link Color', 'twentig' ),
			'section' => 'twentig_header_section',
			'type'    => 'select',
			'choices' => array(
				'accent'    => __( 'Primary Color', 'twentig' ),
				'secondary' => __( 'Secondary Color', 'twentig' ),
				'text'      => __( 'Text Color', 'twentig' ),
			),
		)
	);

	$wp_customize->add_setting(
		'twentig_menu_hover',
		array(
			'default'           => 'underline',
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
				'none'      => _x( 'None', 'style', 'twentig' ),
				'underline' => _x( 'Underline', 'adjective', 'twentig' ),
				'border'    => __( 'Border', 'twentig' ),
				'color'     => __( 'Color', 'twentig' ),
			),
		)
	);

	$wp_customize->add_control(
		new Twentig_Customize_Title_Control(
			$wp_customize,
			'twentig_header_section_title_toggles',
			array(
				'label'    => __( 'Menu & Search Buttons', 'twentig' ),
				'section'  => 'twentig_header_section',
				'settings' => array(),
			)
		)
	);

	$wp_customize->add_setting(
		'twentig_burger_icon',
		array(
			'default'           => 0,
			'sanitize_callback' => 'absint',
		)
	);

	$wp_customize->add_control(
		'twentig_burger_icon',
		array(
			'label'   => __( 'Replace the menu icon (horizontal dots) with a hamburger icon', 'twentig' ),
			'section' => 'twentig_header_section',
			'type'    => 'checkbox',
		)
	);

	$wp_customize->add_setting(
		'twentig_toggle_label',
		array(
			'default'           => 1,
			'sanitize_callback' => 'absint',
		)
	);

	$wp_customize->add_control(
		'twentig_toggle_label',
		array(
			'label'   => __( 'Display label for menu and search buttons', 'twentig' ),
			'section' => 'twentig_header_section',
			'type'    => 'checkbox',
		)
	);

	$wp_customize->add_control(
		new Twentig_Customize_Title_Control(
			$wp_customize,
			'twentig_header_section_title_socials',
			array(
				'label'       => __( 'Social Icons', 'twentig' ),
				'section'     => 'twentig_header_section',
				'description' => sprintf(
					/* translators: link to theme options panel */
					__( 'Visit the <a href="%s">Additional Settings panel</a> to set the locations and style of the social icons.', 'twentig' ),
					"javascript:wp.customize.section( 'twentig_additional_section' ).focus();"
				),
				'settings'    => array(),
			)
		)
	);

	/*
	 * Footer
	 */

	$wp_customize->add_section(
		'twentig_footer_section',
		array(
			'title'    => __( 'Footer', 'twentig' ),
			'panel'    => 'twentig_twentytwenty_panel',
			'priority' => 15,
		)
	);

	$wp_customize->add_control(
		new Twentig_Customize_Title_Control(
			$wp_customize,
			'twentig_footer_section_title_layout',
			array(
				'label'    => __( 'Layout', 'twentig' ),
				'section'  => 'twentig_footer_section',
				'settings' => array(),
			)
		)
	);

	$wp_customize->add_setting(
		'twentig_footer_layout',
		array(
			'default'           => '',
			'sanitize_callback' => 'twentig_sanitize_choices',
		)
	);

	$wp_customize->add_control(
		'twentig_footer_layout',
		array(
			'label'   => __( 'Bottom Footer Layout', 'twentig' ),
			'section' => 'twentig_footer_section',
			'type'    => 'select',
			'choices' => array(
				''              => __( 'Default', 'twentig' ),
				'inline-left'   => __( 'Inline with Menu on Left', 'twentig' ),
				'inline-right'  => __( 'Inline with Menu on Right', 'twentig' ),
				'inline-center' => _x( 'Inline Center', 'layout', 'twentig' ),
				'stack'         => _x( 'Stack', 'layout', 'twentig' ),
				'custom'        => __( 'Blocks', 'twentig' ),
				'hidden'        => _x( 'Hidden', 'layout', 'twentig' ),
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
		'twentig_footer_widget_layout',
		array(
			'default'           => '',
			'sanitize_callback' => 'twentig_sanitize_choices',
		)
	);

	$wp_customize->add_control(
		'twentig_footer_widget_layout',
		array(
			'label'       => __( 'Widgets Layout', 'twentig' ),
			'section'     => 'twentig_footer_section',
			'type'        => 'select',
			'choices'     => array(
				''    => __( 'Column (default)', 'twentig' ),
				'row' => __( 'Row', 'twentig' ),
			),
			'description' => __( 'For Row layout, Footer #1 area is above Footer #2 area, and the widgets are displayed inline inside each area.', 'twentig' ),
		)
	);

	$wp_customize->add_setting(
		'twentig_footer_width',
		array(
			'default'           => '',
			'transport'         => 'postMessage',
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
				''      => _x( 'Wide (1200px)', 'width', 'twentig' ),
				'wider' => _x( 'Wider (1680px)', 'width', 'twentig' ),
				'full'  => _x( 'Full', 'width', 'twentig' ),
			),
		)
	);

	$wp_customize->add_control(
		new Twentig_Customize_Title_Control(
			$wp_customize,
			'twentig_footer_section_title_styles',
			array(
				'label'    => __( 'Styles', 'twentig' ),
				'section'  => 'twentig_footer_section',
				'settings' => array(),
			)
		)
	);

	$wp_customize->add_setting(
		'twentig_footer_font_size',
		array(
			'default'           => '',
			'sanitize_callback' => 'twentig_sanitize_choices',
		)
	);

	$wp_customize->add_control(
		'twentig_footer_font_size',
		array(
			'label'   => __( 'Footer Font Size', 'twentig' ),
			'section' => 'twentig_footer_section',
			'type'    => 'select',
			'choices' => array(
				'small'  => _x( 'Small', 'font size', 'twentig' ),
				'medium' => _x( 'Medium', 'font size', 'twentig' ),
				''       => _x( 'Large', 'font size', 'twentig' ),
			),
		)
	);

	$wp_customize->add_setting(
		'twentig_footer_link_color',
		array(
			'default'           => 'accent',
			'sanitize_callback' => 'twentig_sanitize_choices',
		)
	);

	$wp_customize->add_control(
		'twentig_footer_link_color',
		array(
			'label'   => __( 'Footer Link Color', 'twentig' ),
			'section' => 'twentig_footer_section',
			'type'    => 'select',
			'choices' => array(
				'accent'    => __( 'Primary Color', 'twentig' ),
				'secondary' => __( 'Secondary Color', 'twentig' ),
				'text'      => __( 'Text Color', 'twentig' ),
			),
		)
	);

	$wp_customize->add_control(
		new Twentig_Customize_Title_Control(
			$wp_customize,
			'twentig_footer_section_title_credit',
			array(
				'label'    => __( 'Footer Credit', 'twentig' ),
				'section'  => 'twentig_footer_section',
				'settings' => array(),
			)
		)
	);

	$wp_customize->add_setting(
		'twentig_footer_credit',
		array(
			'default'           => '',
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
				''               => __( 'Default', 'twentig' ),
				'copyright-only' => __( 'Copyright Only', 'twentig' ),
				'custom'         => _x( 'Custom', 'footer credit', 'twentig' ),
				'none'           => _x( 'None', 'footer credit', 'twentig' ),
			),
		)
	);

	$wp_customize->add_setting(
		'twentig_footer_credit_text',
		array(
			'sanitize_callback' => 'twentig_twentytwenty_sanitize_credit',
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

	$wp_customize->add_control(
		new Twentig_Customize_Title_Control(
			$wp_customize,
			'twentig_footer_section_title_socials',
			array(
				'label'       => __( 'Social Icons', 'twentig' ),
				'section'     => 'twentig_footer_section',
				'description' => sprintf(
					/* translators: link to theme options panel */
					__( 'Visit the <a href="%s">Additional Settings panel</a> to set the locations and style of the social icons.', 'twentig' ),
					"javascript:wp.customize.section( 'twentig_additional_section' ).focus();"
				),
				'settings'    => array(),
			)
		)
	);

	/*
	 * Page
	 */

	$wp_customize->add_section(
		'twentig_page_section',
		array(
			'title'    => _x( 'Page', 'Customizer Section Title', 'twentig' ),
			'panel'    => 'twentig_twentytwenty_panel',
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
			'default'           => '',
			'sanitize_callback' => 'twentig_sanitize_choices',
		)
	);

	$wp_customize->add_control(
		'twentig_page_hero_layout',
		array(
			'label'       => __( 'Featured Image Layout', 'twentig' ),
			'section'     => 'twentig_page_section',
			'type'        => 'select',
			'choices'     => array(
				''             => __( 'Default', 'twentig' ),
				'narrow-image' => _x( 'Narrow', 'image width', 'twentig' ),
				'full-image'   => __( 'Full Width', 'twentig' ),
				'no-image'     => __( 'No Image', 'twentig' ),
			),
			'description' => sprintf(
				/* translators: link to cover template panel */
				__( 'Visit the <a href="%s">Cover Template panel</a> if you want to change the settings of the cover.', 'twentig' ),
				"javascript:wp.customize.section( 'cover_template_options' ).focus();"
			),
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
			'default'           => '',
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
				''      => __( 'Default', 'twentig' ),
				'stack' => _x( 'Stack', 'layout', 'twentig' ),
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
			'panel'    => 'twentig_twentytwenty_panel',
			'priority' => 25,
		)
	);

	$wp_customize->add_control(
		new Twentig_Customize_Title_Control(
			$wp_customize,
			'twentig_blog_section_archives_title',
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
			'default'           => '',
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
				''           => __( 'Default', 'twentig' ),
				'stack'      => _x( 'Stack', 'layout', 'twentig' ),
				'grid-basic' => __( 'Grid', 'twentig' ),
				'grid-card'  => __( 'Card Grid', 'twentig' ),
			),
		)
	);

	$wp_customize->add_setting(
		'twentig_blog_columns',
		array(
			'default'           => '3',
			'transport'         => 'postMessage',
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
				__( 'Set the post content in the <a href="%s">Theme Options panel</a>.', 'twentig' ),
				"javascript:wp.customize.section( 'options' ).focus();"
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
			'default'           => 0,
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
		'twentig_blog_image_ratio',
		array(
			'default'           => '',
			'transport'         => 'postMessage',
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
		'twentig_blog_meta',
		array(
			'default'           => array(
				'top-categories',
				'author',
				'post-date',
				'comments',
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
					'top-categories' => __( 'Categories above Title', 'twentig' ),
					'author'         => __( 'Author', 'twentig' ),
					'post-date'      => __( 'Date', 'twentig' ),
					'categories'     => __( 'Categories', 'twentig' ),
					'comments'       => _x( 'Comment', 'noun', 'twentig' ),
					'tags'           => __( 'Tags', 'twentig' ),
				),
			)
		)
	);

	$wp_customize->add_setting(
		'twentig_blog_meta_icon',
		array(
			'default'           => 1,
			'sanitize_callback' => 'absint',
		)
	);

	$wp_customize->add_control(
		'twentig_blog_meta_icon',
		array(
			'section' => 'twentig_blog_section',
			'label'   => __( 'Display meta icons', 'twentig' ),
			'type'    => 'checkbox',
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
		'twentig_post_hero_layout',
		array(
			'default'           => '',
			'sanitize_callback' => 'twentig_sanitize_choices',
		)
	);

	$wp_customize->add_control(
		'twentig_post_hero_layout',
		array(
			'label'       => __( 'Featured Image Layout', 'twentig' ),
			'section'     => 'twentig_blog_section',
			'type'        => 'select',
			'choices'     => array(
				''             => __( 'Default', 'twentig' ),
				'narrow-image' => _x( 'Narrow', 'image width', 'twentig' ),
				'full-image'   => __( 'Full Width', 'twentig' ),
				'no-image'     => __( 'No Image', 'twentig' ),
			),
			'description' => sprintf(
				/* translators: link to cover template panel */
				__( 'Visit the <a href="%s">Cover Template panel</a> if you want to change the settings of the cover.', 'twentig' ),
				"javascript:wp.customize.section( 'cover_template_options' ).focus();"
			),
		)
	);

	$wp_customize->add_setting(
		'twentig_post_excerpt',
		array(
			'default'           => 1,
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
		'twentig_post_meta',
		array(
			'default'           => array(
				'top-categories',
				'author',
				'post-date',
				'comments',
				'tags',
			),
			'sanitize_callback' => 'twentig_sanitize_multi_choices',
		)
	);

	$wp_customize->add_control(
		new Twentig_Customize_Checkbox_Multiple_Control(
			$wp_customize,
			'twentig_post_meta',
			array(
				'label'   => __( 'Post Meta', 'twentig' ),
				'section' => 'twentig_blog_section',
				'choices' => array(
					'top-categories' => __( 'Categories above Title', 'twentig' ),
					'author'         => __( 'Author', 'twentig' ),
					'post-date'      => __( 'Date', 'twentig' ),
					'categories'     => __( 'Categories', 'twentig' ),
					'comments'       => _x( 'Comment', 'noun', 'twentig' ),
					'tags'           => __( 'Tags', 'twentig' ),
				),
			)
		)
	);

	$wp_customize->add_setting(
		'twentig_post_navigation',
		array(
			'default'           => '',
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
				''      => __( 'Default', 'twentig' ),
				'image' => __( 'Image', 'twentig' ),
				'none'  => _x( 'None', 'navigation', 'twentig' ),
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
	 * Additional Settings
	 */

	$wp_customize->add_section(
		'twentig_additional_section',
		array(
			'title'    => __( 'Additional Settings', 'twentig' ),
			'panel'    => 'twentig_twentytwenty_panel',
			'priority' => 40,
		)
	);

	$wp_customize->add_control(
		new Twentig_Customize_Title_Control(
			$wp_customize,
			'twentig_additional_section_title_styles',
			array(
				'label'    => __( 'Elements Style', 'twentig' ),
				'section'  => 'twentig_additional_section',
				'settings' => array(),
			)
		)
	);

	$wp_customize->add_setting(
		'twentig_separator_style',
		array(
			'default'           => '',
			'sanitize_callback' => 'twentig_sanitize_choices',
		)
	);

	$wp_customize->add_control(
		'twentig_separator_style',
		array(
			'label'   => __( 'Separator Style', 'twentig' ),
			'section' => 'twentig_additional_section',
			'type'    => 'select',
			'choices' => array(
				''        => __( 'Default', 'twentig' ),
				'minimal' => _x( 'Minimal', 'style', 'twentig' ),
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
		'twentig_button_hover',
		array(
			'default'           => '',
			'sanitize_callback' => 'twentig_sanitize_choices',
		)
	);

	$wp_customize->add_control(
		'twentig_button_hover',
		array(
			'label'   => __( 'Button Hover Style', 'twentig' ),
			'section' => 'twentig_additional_section',
			'type'    => 'select',
			'choices' => array(
				''      => _x( 'Underline', 'adjective', 'twentig' ),
				'color' => __( 'Color', 'twentig' ),
			),
		)
	);

	$wp_customize->add_setting(
		'twentig_button_uppercase',
		array(
			'default'           => 1,
			'sanitize_callback' => 'absint',
		)
	);

	$wp_customize->add_control(
		'twentig_button_uppercase',
		array(
			'label'   => __( 'Make the button text uppercase', 'twentig' ),
			'section' => 'twentig_additional_section',
			'type'    => 'checkbox',
		)
	);

	$wp_customize->add_control(
		new Twentig_Customize_Title_Control(
			$wp_customize,
			'twentig_additional_section_title_socials',
			array(
				'label'    => __( 'Social Icons', 'twentig' ),
				'section'  => 'twentig_additional_section',
				'settings' => array(),
			)
		)
	);

	$wp_customize->add_setting(
		'twentig_socials_location',
		array(
			'default'           => array(
				'modal-desktop',
				'modal-mobile',
				'footer',
			),
			'sanitize_callback' => 'twentig_sanitize_multi_choices',
		)
	);

	$wp_customize->add_control(
		new Twentig_Customize_Checkbox_Multiple_Control(
			$wp_customize,
			'twentig_socials_location',
			array(
				'label'   => __( 'Social Icons Locations', 'twentig' ),
				'section' => 'twentig_additional_section',
				'choices' => array(
					'primary-menu'  => __( 'Desktop Horizontal Menu', 'twentig' ),
					'modal-desktop' => __( 'Desktop Expanded Menu', 'twentig' ),
					'modal-mobile'  => __( 'Mobile Menu', 'twentig' ),
					'footer'        => __( 'Footer', 'twentig' ),
				),
			)
		)
	);

	$wp_customize->add_setting(
		'twentig_socials_style',
		array(
			'default'           => '',
			'sanitize_callback' => 'twentig_sanitize_choices',
		)
	);

	$wp_customize->add_control(
		'twentig_socials_style',
		array(
			'label'   => __( 'Social Icons Style', 'twentig' ),
			'section' => 'twentig_additional_section',
			'type'    => 'select',
			'choices' => array(
				''                 => __( 'Default', 'twentig' ),
				'logos-only'       => __( 'Logos Only', 'twentig' ),
				'logos-only-large' => __( 'Logos Only - Large Size', 'twentig' ),
			),
		)
	);

	$wp_customize->add_control(
		new Twentig_Customize_Title_Control(
			$wp_customize,
			'twentig_additional_section_title_cf7',
			array(
				'label'    => 'Contact Form 7',
				'section'  => 'twentig_additional_section',
				'settings' => array(),
			)
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
			'section'         => 'twentig_additional_section',
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
				'panel'       => 'twentig_twentytwenty_panel',
				'button_text' => esc_html__( 'Subscribe', 'twentig' ),
				'button_url'  => 'https://twentig.com/newsletter?utm_source=wp-dash&utm_medium=customizer&utm_campaign=newsletter',
				'priority'    => 50,
			)
		)
	);
}
add_action( 'customize_register', 'twentig_twentytwenty_customize_register', 11 );

/**
 * Sanitizes accessible colors array.
 *
 * @param array $value The value we want to sanitize.
 */
function twentig_twentytwenty_sanitize_accessible_colors( $value ) {

	$value = is_array( $value ) ? $value : array();

	foreach ( $value as $area => $values ) {
		foreach ( $values as $context => $color_val ) {
			$value[ $area ][ $context ] = sanitize_hex_color( $color_val );
		}
	}

	return $value;
}

/**
 * Sanitizes credit content.
 *
 * @param string $content The credit content.
 */
function twentig_twentytwenty_sanitize_credit( $content ) {
	$kses_defaults = wp_kses_allowed_html( 'post' );
	$svg_args      = array(
		'svg'   => array(
			'class'           => true,
			'aria-hidden'     => true,
			'aria-labelledby' => true,
			'role'            => true,
			'xmlns'           => true,
			'width'           => true,
			'height'          => true,
			'viewbox'         => true,
			'style'           => true,
		),
		'g'     => array( 'fill' => true ),
		'title' => array( 'title' => true ),
		'path'  => array(
			'd'    => true,
			'fill' => true,
		),
	);

	$allowed_tags = array_merge( $kses_defaults, $svg_args );
	return wp_kses( $content, $allowed_tags );
}

/**
 * Enqueue scripts for customizer preview.
 */
function twentig_twentytwenty_customize_preview_init() {
	wp_enqueue_script( 'twentig-twentytwenty-customize-preview', TWENTIG_ASSETS_URI . '/js/twentytwenty-customize-preview.js', array( 'customize-preview' ), TWENTIG_VERSION, true );
}
add_action( 'customize_preview_init', 'twentig_twentytwenty_customize_preview_init', 11 );

/**
 * Enqueue scripts for customizer controls.
 */
function twentig_twentytwenty_customize_controls_enqueue_scripts() {
	wp_enqueue_script(
		'twentig-twentytwenty-customize-controls',
		TWENTIG_ASSETS_URI . '/js/twentytwenty-customize-controls.js',
		array(),
		TWENTIG_VERSION,
		true
	);

	wp_localize_script(
		'twentig-twentytwenty-customize-controls',
		'twentigCustomizerSettings',
		array(
			'colorVars'    => array(
				'footer' => array( 'setting' => 'twentig_footer_background_color' ),
			),
			'fonts'        => twentig_get_fonts(),
			'fontVariants' => twentig_get_font_styles(),
			'fontPresets'  => twentig_twentytwenty_get_font_presets(),
		)
	);

	wp_enqueue_style(
		'twentig-customize-controls',
		TWENTIG_ASSETS_URI . '/css/customize-controls.css',
		array(),
		TWENTIG_VERSION
	);
}
add_action( 'customize_controls_enqueue_scripts', 'twentig_twentytwenty_customize_controls_enqueue_scripts', 11 );

/**
 * Outputs an Underscore template that generates dynamically the CSS for instant display in the Customizer preview.
 */
function twentig_twentytwenty_customizer_live_css_template() {
	?>

	<script type="text/html" id="tmpl-twentig-customizer-live-style">

		<# 
		var body_font        = data.twentig_body_font;
		var body_font_custom = data.twentig_body_font_custom;
		var body_font_stack  = "'NonBreakingSpaceOverride', 'Hoefler Text', Garamond, 'Times New Roman', serif";

		if ( body_font ) {
			if ( 'sans-serif' === body_font ) {
				body_font_stack = "-apple-system, BlinkMacSystemFont, 'Segoe UI', Helvetica Neue, Helvetica, sans-serif";
			} else if ( 'custom-google-font' === body_font ) {
				if ( body_font_custom ) {
					body_font_stack = "'" + body_font_custom + "', sans-serif";
				}
			} else {
				body_font_stack = "'" + body_font + "', sans-serif";
			}
		}

		var heading_font        = data.twentig_heading_font;
		var heading_font_custom = data.twentig_heading_font_custom;
		var heading_font_stack  = "'Inter var', -apple-system, BlinkMacSystemFont, 'Helvetica Neue', Helvetica, sans-serif";

		if ( heading_font ) {
			if ( 'sans-serif' === heading_font ) {
				heading_font_stack = "-apple-system, BlinkMacSystemFont, 'Segoe UI', Helvetica Neue, Helvetica, sans-serif";
			} else if ( 'custom-google-font' === heading_font ) {
				if ( heading_font_custom ) {
					heading_font_stack = "'" + heading_font_custom + "', sans-serif";
				}
			} else {
				heading_font_stack = "'" + heading_font + "', sans-serif";
			}
		}

		var heading_font_weight  = data.twentig_heading_font_weight;
		var secondary_font       = data.twentig_secondary_font;
		var secondary_font_stack = 'body' === secondary_font ? body_font_stack : heading_font_stack;
		var menu_font            = data.twentig_menu_font;
		var menu_font_weight     = data.twentig_menu_font_weight;
		var logo_font            = data.twentig_logo_font;
		var logo_font_custom     = data.twentig_logo_font_custom;
		var logo_font_weight     = data.twentig_logo_font_weight;
		var logo_font_size       = data.twentig_logo_font_size;
		var logo_letter_spacing  = data.twentig_logo_letter_spacing;
		var subtle_color         = data.twentig_subtle_background_color;

		logo_font = 'custom-google-font' === logo_font ? logo_font_custom : logo_font;
		#>

		<# if ( body_font || heading_font ) { #>
			body,
			.entry-content,
			.entry-content p,
			.entry-content ol,
			.entry-content ul,
			.widget_text p,
			.widget_text ol,
			.widget_text ul,
			.widget-content .rssSummary,
			.comment-content p,			
			.has-drop-cap:not(:focus):first-letter { font-family: {{ body_font_stack }}; }

			h1, h2, h3, h4, h5, h6, .entry-content h1, .entry-content h2, .entry-content h3, .entry-content h4, .entry-content h5, .entry-content h6, .faux-heading, .site-title, .pagination-single a { font-family: {{ heading_font_stack }}; }

			table {font-size: inherit;} 
		<# } #>	

		.intro-text,
		input,
		textarea,
		select,
		button, 
		.button, 
		.faux-button, 
		.wp-block-button__link,
		.wp-block-file__button,			
		.primary-menu li.menu-button > a,
		.entry-content .wp-block-pullquote,
		.entry-content .wp-block-quote.is-style-large,
		.entry-content cite,
		.entry-content figcaption,
		.wp-caption-text,
		.entry-content .wp-caption-text,
		.widget-content cite,
		.widget-content figcaption,
		.widget-content .wp-caption-text,
		.entry-categories,
		.post-meta,
		.comment-meta, 
		.comment-footer-meta,
		.author-bio,
		.comment-respond p.comment-notes, 
		.comment-respond p.logged-in-as,
		.entry-content .wp-block-archives,
		.entry-content .wp-block-categories,
		.entry-content .wp-block-latest-posts,
		.entry-content .wp-block-latest-comments,
		.pagination,
		#site-footer,						
		.widget:not(.widget-text),
		.footer-menu,
		label,
		.toggle .toggle-text { font-family: {{ secondary_font_stack }}; }

		<# if ( 'body' === menu_font ) { #>
			ul.primary-menu, ul.modal-menu { font-family: {{ body_font_stack }}; }
		<# } else { #>	
			ul.primary-menu, ul.modal-menu { font-family: {{ heading_font_stack }}; }
		<# } #>

		<# if ( heading_font_weight ) { #>
			h1, .heading-size-1, h2, h3, h4, h5, h6, .faux-heading, .archive-title, .site-title, .pagination-single a { font-weight: {{ heading_font_weight }} ; }
		<# } #>

		<# if ( menu_font_weight ) { #>
			ul.primary-menu, ul.modal-menu ul li a, ul.modal-menu > li .ancestor-wrapper a { font-weight: {{ menu_font_weight }}; }
		<# } #>	

		#site-header .site-title {
			<# if ( logo_font ) { #>
				font-family: '{{ logo_font }}', sans-serif;
			<# } #>	
			<# if ( logo_font_weight ) { #>
				font-weight: {{ logo_font_weight }};
			<# } #>
			<# if ( logo_font_size ) { #>
				font-size: {{ logo_font_size }}px;
			<# } #>	
			<# if ( logo_letter_spacing ) { #>
			letter-spacing: {{ logo_letter_spacing }}em;
			<# } #>
		}		

		<# if ( subtle_color ) { #>
			:root .has-subtle-background-background-color { background-color: {{ subtle_color }}; }
			:root .has-subtle-background-color.has-text-color { color: {{ subtle_color }}; }
		<# } #>	

	</script>
	<?php
}
add_action( 'customize_controls_print_footer_scripts', 'twentig_twentytwenty_customizer_live_css_template' );
