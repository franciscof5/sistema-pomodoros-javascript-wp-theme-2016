<?php 
/**
 * Magcast Theme Customizer support
 *
 * @package Theme Horse
 * @subpackage Magcast
 * @since Magcast 1.0
 */
?>
<?php
/**
 * Implement Theme Customizer additions and adjustments.
 *
 * @since Magcast 1.0
 *
 */
if ( ! class_exists( 'WP_Customize_Section' ) ) {
	return null;
}
function magcast_textarea_register($wp_customize){
	class Magcast_Customize_Magcast_upgrade extends WP_Customize_Control {
		public function render_content() { ?>
		<div class="theme-info">
			<a title="<?php esc_attr_e( 'Review Magcast', 'magcast' ); ?>" href="<?php echo esc_url( 'http://wordpress.org/support/view/theme-reviews/magcast' ); ?>" target="_blank">
			<?php esc_html_e( 'Rate Magcast', 'magcast' ); ?>
			</a>
			<a href="<?php echo esc_url( 'https://www.themehorse.com/theme-instruction/magcast/' ); ?>" title="<?php esc_attr_e( 'Magcast Theme Instructions', 'magcast' ); ?>" target="_blank">
			<?php esc_html_e( 'Theme Instructions', 'magcast' ); ?>
			</a>
			<a href="<?php echo esc_url( 'https://www.themehorse.com/support-forum/' ); ?>" title="<?php esc_attr_e( 'Support Forum', 'magcast' ); ?>" target="_blank">
			<?php esc_html_e( 'Support Forum', 'magcast' ); ?>
			</a>
			<a href="<?php echo esc_url( 'https://www.themehorse.com/preview/magcast/' ); ?>" title="<?php esc_attr_e( 'Magcast Demo', 'magcast' ); ?>" target="_blank">
			<?php esc_html_e( 'View Demo', 'magcast' ); ?>
			</a>
		</div>
		<?php
		}
	}
	class Magcast_Customize_Magcast_checkbox_title extends WP_Customize_Control {
		public function render_content() { ?>
			<span class="customize-control-title customize-control-checkbox-title"><?php esc_html_e( 'Display Infobar/ Search Icon', 'magcast' );?> </span>
		<?php }
	}
	class Magcast_Customize_Category_Control extends WP_Customize_Control {
		/**
		* The type of customize control being rendered.
		*/
		public $type = 'multiple-select';
		/**
		* Displays the multiple select on the customize screen.
		*/
		public function render_content() {
		global $magcast_settings, $magcast_array_of_default_settings;
		$magcast_settings = wp_parse_args(  get_option( 'magcast_theme_settings', array() ),  magcast_get_option_defaults());
		$magcast_categories = get_categories(); ?>
			<label>
				<span class="customize-control-title"><?php echo esc_html( $this->label ); ?></span>
				<select <?php $this->link(); ?> multiple="multiple">
				<?php
					foreach ( $magcast_categories as $category) :?>
						<option value="<?php echo $category->cat_ID; ?>" <?php if ( in_array( $category->cat_ID, $magcast_settings[ 'magcast_categories' ]) ) { echo 'selected="selected"';}?>><?php echo $category->cat_name; ?></option>
					<?php endforeach; ?>
				</select>
			</label>
		<?php 
		}
	}

	class Magcast_Customize_drop_down_Category_Control extends WP_Customize_Control {
      /**
		* The type of customize control being rendered.
		*/
		public $type = 'select';
		/**
		* Displays the multiple select on the customize screen.
		*/
		public function render_content() {
		global $magcast_settings, $magcast_array_of_default_settings;
		$magcast_settings = wp_parse_args(  get_option( 'magcast_theme_settings', array() ),  magcast_get_option_defaults());
		$magcast_categories = get_categories(); ?>
			<label>
				<span class="customize-control-title"><?php echo esc_html( $this->label ); ?></span>
				<select <?php $this->link(); ?>>
				<?php
					foreach ( $magcast_categories as $category) :?>
						<option value="<?php echo $category->cat_ID; ?>" <?php if ( in_array( $category->cat_ID, $magcast_settings[ 'magcast_categories' ]) ) { echo 'selected="selected"';}?>><?php echo $category->cat_name; ?></option>
					<?php endforeach; ?>
				</select>
			</label>
		<?php 
		}
	}
}
	/**
	 * Upsell customizer section.
	 *
	 * @since  1.0.0
	 * @access public
	 */
	class Magcast_Customize_Section_Upsell extends WP_Customize_Section {

		/**
		 * The type of customize section being rendered.
		 *
		 * @since  1.0.0
		 * @access public
		 * @var    string
		 */
		public $type = 'upsell';

		/**
		 * Custom button text to output.
		 *
		 * @since  1.0.0
		 * @access public
		 * @var    string
		 */
		public $pro_text = '';

		/**
		 * Custom pro button URL.
		 *
		 * @since  1.0.0
		 * @access public
		 * @var    string
		 */
		public $pro_url = '';

		/**
		 * Add custom parameters to pass to the JS via JSON.
		 *
		 * @since  1.0.0
		 * @access public
		 * @return void
		 */
		public function json() {
			$json = parent::json();

			$json['pro_text'] = $this->pro_text;
			$json['pro_url']  = esc_url( $this->pro_url );

			return $json;
		}

		/**
		 * Outputs the Underscore.js template.
		 *
		 * @since  1.0.0
		 * @access public
		 * @return void
		 */
		protected function render_template() { ?>

			<li id="accordion-section-{{ data.id }}" class="accordion-section control-section control-section-{{ data.type }} cannot-expand">
				<h3 class="accordion-section-title">
					{{ data.title }}

					<# if ( data.pro_text && data.pro_url ) { #>
						<a href="{{ data.pro_url }}" class="upgrade-to-pro" target="_blank">{{ data.pro_text }}</a>
					<# } #>
				</h3>
			</li>
		<?php }
	}
function magcast_customize_register($wp_customize){
	$wp_customize->add_panel( 'magcast_theme_options', array(
	'priority'       => 10,
	'capability'     => 'edit_theme_options',
	'title'          => __('Magcast Theme Options', 'magcast')
	));
	global $magcast_settings, $magcast_array_of_default_settings;
	$magcast_settings = wp_parse_args(  get_option( 'magcast_theme_settings', array() ),  magcast_get_option_defaults());
/********************Magcast Upgrade ******************************************/
	$wp_customize->add_section('magcast_upgrade', array(
		'title'					=> __('Magcast Support', 'magcast'),
		'priority'				=> 500,
	));
	$wp_customize->add_setting( 'magcast_theme_settings[magcast_upgrade]', array(
		'default'				=> false,
		'capability'			=> 'edit_theme_options',
		'sanitize_callback'	=> 'wp_filter_nohtml_kses',
	));
	$wp_customize->add_control(
		new Magcast_Customize_Magcast_upgrade(
		$wp_customize,
		'magcast_upgrade',
			array(
				'label'					=> __('Magcast Upgrade','magcast'),
				'section'				=> 'magcast_upgrade',
				'settings'				=> 'magcast_theme_settings[magcast_upgrade]',
			)
		)
	);
	/********************Layout Options ******************************************/
	$wp_customize->add_section('magcast_layout_options', array(
		'title'					=> __('Layout Options', 'magcast'),
		'priority'				=> 100,
		'panel'					=>'magcast_theme_options'
	));
	$wp_customize->add_setting('magcast_theme_settings[magcast_design_layout]', array(
		'default'				=> 'on',
		'sanitize_callback'	=> 'magcast_sanitize_choices',
		'type' 					=> 'option',
		'capability' 			=> 'manage_options'
	));
	$wp_customize->add_control('magcast_theme_settings[magcast_design_layout]', array(
		'label'					=> __('Site Layout','magcast'),
		'section'				=> 'magcast_layout_options',
		'settings'				=> 'magcast_theme_settings[magcast_design_layout]',
		'type'					=> 'radio',
		'checked'				=> 'checked',
		'choices'				=> array(
			'on'					=> __('Wide Layout','magcast'),
			'off'					=> __('Narrow Layout','magcast'),
		),
	));
	/********************Content Layout ******************************************/
	$wp_customize->add_setting('magcast_theme_settings[magcast_content_layout]', array(
		'default'				=> 'right',
		'sanitize_callback'	=> 'magcast_sanitize_choices',
		'type' 					=> 'option',
		'capability' 			=> 'manage_options'
	));
	$wp_customize->add_control('magcast_theme_settings[magcast_content_layout]', array(
		'label'					=> __('Content Layout','magcast'),
		'description'			=> __('Below options are global setting. Set individual layout from specific page/ post.','magcast'),
		'section'				=> 'magcast_layout_options',
		'settings'				=> 'magcast_theme_settings[magcast_content_layout]',
		'type'					=> 'radio',
		'checked'				=> 'checked',
		'choices'				=> array(
			'right'				=> __('Right Sidebar','magcast'),
			'left'				=> __('Left Sidebar','magcast'),
			'nosidebar'			=> __('No Sidebar','magcast'),
			'fullwidth'			=> __('No Sidebar Full Width','magcast'),
		),
	));
/********************Custom Header ******************************************/
	$wp_customize->add_section('magcast_custom_header_setting', array(
		'title'					=> __('Header Options', 'magcast'),
		'priority'				=> 110,
		'panel'					=>'magcast_theme_options'
	));
	$wp_customize->add_setting('magcast_theme_settings[magcast_header_design]', array(
		'default'				=> 'sitetitle_social_icons_search',
		'sanitize_callback'	=> 'magcast_sanitize_choices',
		'type' 					=> 'option',
		'capability' 			=> 'manage_options'
	));
	$wp_customize->add_control('magcast_theme_settings[magcast_header_design]', array(
		'priority'				=>120,
		'label'					=> __('Display Header Style', 'magcast'),
		'section'				=> 'magcast_custom_header_setting',
		'settings'				=> 'magcast_theme_settings[magcast_header_design]',
		'type'					=> 'radio',
		'checked'				=> 'checked',
			'choices'			=> array(
			'sitetitle_social_icons_search'		=> __('Site Title/ Social Profiles/ Search Form','magcast'),
			'sitetitle_add'		=> __('Site Title/ Add','magcast'),
			),
	));
	
	$wp_customize->add_setting( 'magcast_theme_settings[magcast_custom_header_setting]', array(
		'default'				=> false,
		'capability'			=> 'edit_theme_options',
		'sanitize_callback'	=> 'wp_filter_nohtml_kses',
	));
	$wp_customize->add_control(
		new Magcast_Customize_Magcast_checkbox_title(
		$wp_customize,
		'magcast_custom_header_setting',
			array(
				'priority'				=> 140,
				'section'				=> 'magcast_custom_header_setting',
				'settings'				=> 'magcast_theme_settings[magcast_custom_header_setting]',
			)
		)
	);
	$wp_customize->add_setting('magcast_theme_settings[magcast_hide_date]', array(
		'default'					=>0,
		'sanitize_callback'		=>'magcast_sanitize_integer',
		'type' 						=> 'option',
		'capability' 				=> 'manage_options'
	));
	$wp_customize->add_control( 'magcast_hide_date', array(
		'priority'					=>150,
		'label'						=> __('Hide Infobar Date', 'magcast'),
		'section'					=> 'magcast_custom_header_setting',
		'settings'					=> 'magcast_theme_settings[magcast_hide_date]',
		'type'						=> 'checkbox',
	));
	$wp_customize->add_setting('magcast_theme_settings[magcast_hide_infobar]', array(
		'default'					=>0,
		'sanitize_callback'		=>'magcast_sanitize_integer',
		'type' 						=> 'option',
		'capability' 				=> 'manage_options'
	));
	$wp_customize->add_control( 'magcast_hide_infobar', array(
		'priority'					=>155,
		'label'						=> __('Hide Infobar', 'magcast'),
		'section'					=> 'magcast_custom_header_setting',
		'settings'					=> 'magcast_theme_settings[magcast_hide_infobar]',
		'type'						=> 'checkbox',
	));
	$wp_customize->add_setting('magcast_theme_settings[magcast_hide_top_search]', array(
		'default'					=>0,
		'sanitize_callback'		=>'magcast_sanitize_integer',
		'type' 						=> 'option',
		'capability' 				=> 'manage_options'
	));
	$wp_customize->add_control( 'magcast_hide_top_search', array(
		'priority'					=>160,
		'label'						=> __('Hide Top Search Icon', 'magcast'),
		'section'					=> 'magcast_custom_header_setting',
		'settings'					=> 'magcast_theme_settings[magcast_hide_top_search]',
		'type'						=> 'checkbox',
	));
	$wp_customize->add_setting('magcast_theme_settings[magcast_search_header_settings]', array(
		'default'					=>1,
		'sanitize_callback'		=>'magcast_sanitize_integer',
		'type' 						=> 'option',
		'capability' 				=> 'manage_options'
	));
	$wp_customize->add_control( 'magcast_search_header_settings', array(
		'priority'					=>170,
		'label'						=> __('Hide Navigation Search Icon', 'magcast'),
		'section'					=> 'magcast_custom_header_setting',
		'settings'					=> 'magcast_theme_settings[magcast_search_header_settings]',
		'type'						=> 'checkbox',
	));
/********************Home Page Blog Category Setting ******************************************/
	$wp_customize->add_section(
		'magcast_category_section', array(
		'title' 						=> __('Home Page Blog Category Setting','magcast'),
		'description'				=> __('Only posts that belong to the categories selected here will be displayed on the front page. ( You may select multiple categories by holding down the Ctrl/Command key. ) ','magcast'),
		'priority'					=> 130,
		'panel'					=>'magcast_theme_options'
	));
	$wp_customize->add_setting( 'magcast_theme_settings[magcast_categories]', array(
		'default'					=>array(),
		'sanitize_callback'		=> 'magcast_sanitize_category',
		'type' 						=> 'option',
		'capability' 				=> 'manage_options'
	));
	$wp_customize->add_control(
		new Magcast_Customize_Category_Control(
		$wp_customize,
			'magcast_theme_settings[magcast_categories]',
			array(
			'label'					=> __('Front page posts categories','magcast'),
			'section'				=> 'magcast_category_section',
			'settings'				=> 'magcast_theme_settings[magcast_categories]',
			'type'					=> 'multiple-select',
			)
		)
	);
	$wp_customize->add_setting( 'magcast_theme_settings[magcast_disable_setting]', array(
		'default'					=> 0,
		'sanitize_callback'		=> 'magcast_sanitize_integer',
		'type' 						=> 'option',
		'capability' 				=> 'manage_options'
	));
	$wp_customize->add_control( 'magcast_disable_setting', array(
		'label'						=> __('Check to Default Settings', 'magcast'),
		'section'					=> 'magcast_category_section',
		'settings'					=> 'magcast_theme_settings[magcast_disable_setting]',
		'type'						=> 'checkbox',
	));
	/******************** Featured Slider Options  ***********************************/
	$wp_customize->add_section( 'magcast_page_post_options', array(
		'title' 						=> __('Featured Slider Options','magcast'),
		'priority'					=> 270,
		'panel'					=>'magcast_theme_options'
	));
	$wp_customize->add_setting('magcast_theme_settings[magcast_slider_quantity]', array(
		'default'					=> '4',
		'sanitize_callback'		=> 'magcast_sanitize_slider_quantity',
		'type' 						=> 'option',
		'capability' 				=> 'manage_options'
	));
	$wp_customize->add_control('magcast_slider_quantity', array(
		'priority'					=>230,
		'label'						=> __('Number of Slides', 'magcast'),
		'section'					=> 'magcast_page_post_options',
		'settings'					=> 'magcast_theme_settings[magcast_slider_quantity]',
		'type'						=> 'text',
	) );
	// featured post
	for ( $i=1; $i <= $magcast_settings['magcast_slider_quantity'] ; $i++ ) {
		$wp_customize->add_setting('magcast_theme_settings[magcast_featured_post_slider]['. $i.']', array(
			'default'					=>'',
			'sanitize_callback'		=>'magcast_sanitize_integer',
			'type' 						=> 'option',
			'capability' 				=> 'manage_options'
		));
		$wp_customize->add_control( 'magcast_featured_post_slider]['. $i .']', array(
			'priority'					=> 30 . $i,
			'label'						=> __('Enter Post ID #', 'magcast') . $i ,
			'section'					=> 'magcast_page_post_options',
			'settings'					=> 'magcast_theme_settings[magcast_featured_post_slider]['. $i .']',
			'type'						=> 'text',
		));
	}
	$wp_customize->add_setting( 'magcast_theme_settings[magcast_hide_slider_date]', array(
		'default'					=> 0,
		'sanitize_callback'		=> 'magcast_sanitize_integer',
		'type' 						=> 'option',
		'capability' 				=> 'manage_options'
	));
	$wp_customize->add_control( 'magcast_hide_slider_date', array(
		'priority'					=>420,
		'label'						=> __('Disable Date', 'magcast'),
		'section'					=> 'magcast_page_post_options',
		'settings'					=> 'magcast_theme_settings[magcast_hide_slider_date]',
		'type'						=> 'checkbox',
	));
	$wp_customize->add_setting( 'magcast_theme_settings[magcast_hide_slider_author]', array(
		'default'					=> 0,
		'sanitize_callback'		=> 'magcast_sanitize_integer',
		'type' 						=> 'option',
		'capability' 				=> 'manage_options'
	));
	$wp_customize->add_control( 'magcast_hide_slider_author', array(
		'priority'					=>425,
		'label'						=> __('Disable Author', 'magcast'),
		'section'					=> 'magcast_page_post_options',
		'settings'					=> 'magcast_theme_settings[magcast_hide_slider_author]',
		'type'						=> 'checkbox',
	));
	$wp_customize->add_setting('magcast_theme_settings[magcast_exclude_slider_post]', array(
		'default'					=>0,
		'sanitize_callback'		=>'magcast_sanitize_integer',
		'type' 						=> 'option',
		'capability' 				=> 'manage_options'
	));
	$wp_customize->add_setting( 'magcast_theme_settings[magcast_disable_slider]', array(
		'default'					=> 1,
		'sanitize_callback'		=> 'magcast_sanitize_integer',
		'type' 						=> 'option',
		'capability' 				=> 'manage_options'
	));
	$wp_customize->add_control( 'magcast_disable_slider', array(
		'priority'					=>430,
		'label'						=> __('Disable Slider', 'magcast'),
		'section'					=> 'magcast_page_post_options',
		'settings'					=> 'magcast_theme_settings[magcast_disable_slider]',
		'type'						=> 'checkbox',
	));
	$wp_customize->add_control( 'magcast_exclude_slider_post', array(
		'priority'					=>500,
		'label'						=> __('Check to exclude', 'magcast'),
		'description'				=>__('Exclude Slider post from Homepage posts?','magcast'),
		'section'					=> 'magcast_page_post_options',
		'settings'					=> 'magcast_theme_settings[magcast_exclude_slider_post]',
		'type'						=> 'checkbox',
	));
	/******************** Highlighted Post ******************************************/
	$wp_customize->add_section( 'magcast_highligted_post', array(
		'title'					=> __('Post Ticker', 'magcast'),
		'priority'				=> 300,
		'panel'					=>'magcast_theme_options'
	));
	$wp_customize->add_setting('magcast_theme_settings[magcast_hide_highligted_options]', array(
		'default'					=>'off',
		'sanitize_callback'		=>'magcast_sanitize_choices',
		'type' 						=> 'option',
		'capability' 				=> 'manage_options'
	));
	$wp_customize->add_control( 'magcast_theme_settings[magcast_hide_highligted_options]', array(
		'priority'					=>310,
		'label'						=> __('Post Ticker Options', 'magcast'),
		'section'					=> 'magcast_highligted_post',
		'settings'					=> 'magcast_theme_settings[magcast_hide_highligted_options]',
		'type'						=> 'radio',
		'checked'				=> 'checked',
		'choices'				=> array(
			'on'								=> __('ON','magcast'),
			'off'								=> __('OFF','magcast'),
			'only_magazine'				=> __('Show on Magazine Template only','magcast'),
			'only_blog_magazine'			=> __('Show on Blog/Magazine Template only','magcast'),
		),
	));
	$wp_customize->add_setting('magcast_theme_settings[magcast_post_num_highligted]', array(
		'default'					=>'3',
		'sanitize_callback'		=>'magcast_sanitize_integer',
		'type' 						=> 'option',
		'capability' 				=> 'manage_options'
	));
	$wp_customize->add_control( 'magcast_post_num_highligted', array(
		'priority'					=>320,
		'label'						=> __('Number of Post', 'magcast'),
		'section'					=> 'magcast_highligted_post',
		'settings'					=> 'magcast_theme_settings[magcast_post_num_highligted]',
		'type'						=> 'text',
	));
	$wp_customize->add_setting('magcast_theme_settings[magcast_highligted_title]', array(
		'default'					=>'',
		'sanitize_callback'		=>'sanitize_text_field',
		'type' 						=> 'option',
		'capability' 				=> 'manage_options'
	));
	$wp_customize->add_control( 'magcast_highligted_title', array(
		'priority'					=>330,
		'label'						=> __('Post Ticker Title', 'magcast'),
		'section'					=> 'magcast_highligted_post',
		'settings'					=> 'magcast_theme_settings[magcast_highligted_title]',
		'type'						=> 'text',
	));
	$wp_customize->add_setting( 'magcast_theme_settings[magcast_dropdown_categories]', array(
		'default'					=> array(),
		'sanitize_callback'		=> 'magcast_sanitize_select',
		'type' 						=> 'option',
		'capability' 				=> 'manage_options'
	));
	$wp_customize->add_control(
		new Magcast_Customize_drop_down_Category_Control(
		$wp_customize,
			'magcast_theme_settings[magcast_dropdown_categories]',
			array(
			'label'					=> __('Select Post Category','magcast'),
			'priority'					=>340,
			'section'				=> 'magcast_highligted_post',
			'settings'				=> 'magcast_theme_settings[magcast_dropdown_categories]',
			'type'	=>'select'
			)
		)
	);
	/******************** Social Profiles Options ******************************************/
	$wp_customize->add_section( 'magcast_social_icon_options', array(
		'title'					=> __('Social Profiles Options', 'magcast'),
		'priority'				=> 400,
		'panel'					=>'magcast_theme_options'
	));
	$wp_customize->add_setting('magcast_theme_settings[magcast_hide_header_social_icon]', array(
		'default'					=>0,
		'sanitize_callback'		=>'magcast_sanitize_integer',
		'type' 						=> 'option',
		'capability' 				=> 'manage_options'
	));
	$wp_customize->add_control( 'magcast_hide_header_social_icon', array(
		'priority'					=>410,
		'label'						=> __('Hide Header Social Icons', 'magcast'),
		'section'					=> 'magcast_social_icon_options',
		'settings'					=> 'magcast_theme_settings[magcast_hide_header_social_icon]',
		'type'						=> 'checkbox',
	));
	$wp_customize->add_setting('magcast_theme_settings[magcast_hide_footer_social_icon]', array(
		'default'					=>0,
		'sanitize_callback'		=>'magcast_sanitize_integer',
		'type' 						=> 'option',
		'capability' 				=> 'manage_options'
	));
	$wp_customize->add_control( 'magcast_hide_footer_social_icon', array(
		'priority'					=>420,
		'label'						=> __('Hide Footer Social Icons', 'magcast'),
		'section'					=> 'magcast_social_icon_options',
		'settings'					=> 'magcast_theme_settings[magcast_hide_footer_social_icon]',
		'type'						=> 'checkbox',
	));
}
/********************Sanitize the values ******************************************/
function magcast_sanitize_choices( $input, $setting ) {
    global $wp_customize;
    $control = $wp_customize->get_control( $setting->id );
    if ( array_key_exists( $input, $control->choices ) ) {
        return $input;
    } else {
        return $setting->default;
    }
}
function magcast_sanitize_integer( $input) {
    return absint($input);
}
function magcast_sanitize_category( $input ) {
	if ( $input != '' ) {
		$args = array(
						'type'			=> 'post',
						'child_of'      => 0,
						'parent'        => '',
						'orderby'       => 'name',
						'order'         => 'ASC',
						'hide_empty'    => 0,
						'hierarchical'  => 0,
						'taxonomy'      => 'category',
					); 
		
		$magcast_categories = ( get_categories( $args ) );

		$category_list 	=	array();
		
		foreach ( $magcast_categories as $category )
			$category_list 	=	array_merge( $category_list, array( $category->term_id ) );

		if ( count( array_intersect( $input, $category_list ) ) == count( $input ) ) {
	    	return $input;
	    } 
	    else {
    		return '';
   		}
    }
    else {
    	return '';
    }
}
function magcast_sanitize_select( $input) {
	if ( $input != '' ) {
		return $input;
	}else{
		return '';
	}
}
function magcast_sanitize_slider_quantity( $input ) {
	if(is_numeric($input)){
	return $input;
	}
}
function magcast_customizer_control_scripts() {

	wp_enqueue_script(
		'magcast-customize-controls',
		get_template_directory_uri() . '/inc/admin/js/magcast_customizer.js',
		array(), '3.0',
		true
	);

	wp_enqueue_style( 'magcast-customize-controls',
	 get_template_directory_uri() . '/inc/admin/css/customize-controls.css' );

}

add_action( 'customize_controls_enqueue_scripts', 'magcast_customizer_control_scripts', 0 );

function magcast_customize_custom_sections( $wp_customize ) {

	// Register custom section types.
	$wp_customize->register_section_type( 'Magcast_Customize_Section_Upsell' );

	// Register sections.
	$wp_customize->add_section(
		new Magcast_Customize_Section_Upsell(
			$wp_customize,
			'theme_upsell',
			array(
				'title'    => esc_html__( 'Magcast Pro', 'magcast' ),
				'pro_text' => esc_html__( 'Upgrade to Pro', 'magcast' ),
				'pro_url'  => 'https://www.themehorse.com/themes/magcast',
				'priority' => 1,
			)
		)
	);

}

add_action( 'customize_register', 'magcast_customize_custom_sections');
add_action('customize_register', 'magcast_textarea_register');
add_action('customize_register', 'magcast_customize_register');
?>
