<?php 
function sw_import_files() { 
  return array(
		array(
			'import_file_name'             => 'Home 1',
			'page_title'				   => 'Home',
			'local_import_file'            => trailingslashit( get_template_directory() ) . 'lib/import/demo-1/data.xml',
			'local_import_widget_file'     => trailingslashit( get_template_directory() ) . 'lib/import/demo-1/widgets.json',
				'local_import_revslider'  		 => array( 
					'slide1' => trailingslashit( get_template_directory() ) . 'lib/import/demo-1/home-page-1.zip' 
				),
			'local_import_options'         => array(
			array(
				'file_path'   => trailingslashit( get_template_directory() ) . 'lib/import/demo-1/theme_options.txt',
				'option_name' => 'maxshop_theme',
				),
			),
			'menu_locate'									 => array(
				'primary_menu' => esc_html__( 'Primary Menu', 'maxshop' ),   /* menu location => menu name for that location */
				'vertical_menu' => esc_html__( 'Left menu shop 5', 'maxshop' )
			),
			'import_preview_image_url'     => get_template_directory_uri() . '/lib/import/demo-1/home.png',
			'import_notice'                => __( 'After you import this demo, you will have to setup the slider separately. This import maybe finish on 10-15 minutes', 'maxshop' ),
			'preview_url'                  => esc_url( 'http://demo.wpthemego.com/themes/sw_maxshop/' ),
		),
	
		array(
			'import_file_name'             => 'Home 2',
			'page_title'				   => 'Home Page 2',
			'local_import_file'            => trailingslashit( get_template_directory() ) . 'lib/import/demo-1/data.xml',
			'local_import_widget_file'     => trailingslashit( get_template_directory() ) . 'lib/import/demo-1/widgets.json',
			'local_import_revslider'  		 => array( 
				'slide1' => trailingslashit( get_template_directory() ) . 'lib/import/demo-1/home-page-1.zip' 
			),
			'local_import_options'         => array(
			array(
				'file_path'   => trailingslashit( get_template_directory() ) . 'lib/import/demo-2/theme_options.txt',
				'option_name' => 'maxshop_theme',
				),
			),
			'menu_locate'									 => array(
				'primary_menu' => esc_html__( 'Primary Menu', 'maxshop' ),   /* menu location => menu name for that location */
				'vertical_menu' => esc_html__( 'Left menu shop 5', 'maxshop' )
			),
			'import_preview_image_url'     => get_template_directory_uri() . '/lib/import/demo-2/home2.png',
			'import_notice'                => __( 'After you import this demo, you will have to setup the slider separately. This import maybe finish on 10-15 minutes', 'maxshop' ),
			'preview_url'                  => esc_url( 'http://demo.wpthemego.com/themes/sw_maxshop/?page_id=4435&header_style=style2&footer_style=default' ),
		),
		
		array(
			'import_file_name'             => 'Home 3',
			'page_title'				   => 'Home Page 3',
			'local_import_file'            => trailingslashit( get_template_directory() ) . 'lib/import/demo-1/data.xml',
			'local_import_widget_file'     => trailingslashit( get_template_directory() ) . 'lib/import/demo-1/widgets.json',
			'local_import_revslider'  		 => array( 
					'slide1' => trailingslashit( get_template_directory() ) . 'lib/import/demo-1/home-page-1.zip' 
				),
				'local_import_options'         => array(
			array(
				'file_path'   => trailingslashit( get_template_directory() ) . 'lib/import/demo-3/theme_options.txt',
				'option_name' => 'maxshop_theme',
				),
			),
			'menu_locate'									 => array(
				'primary_menu' => esc_html__( 'Primary Menu', 'maxshop' ),   /* menu location => menu name for that location */
				'vertical_menu' => esc_html__( 'Left menu shop 5', 'maxshop' )
			),
			'import_preview_image_url'     => get_template_directory_uri() . '/lib/import/demo-3/home3.png',
			'import_notice'                => __( 'After you import this demo, you will have to setup the slider separately. This import maybe finish on 10-15 minutes', 'maxshop' ),
			'preview_url'                  => esc_url( 'http://demo.wpthemego.com/themes/sw_maxshop/?page_id=4440&header_style=style3&scheme=blue&footer_style=default' ),
		),
		
		array(
				'import_file_name'             => 'Home 4',
				'page_title'				   => 'Home Page 4',
				'local_import_file'            => trailingslashit( get_template_directory() ) . 'lib/import/demo-1/data.xml',
				'local_import_widget_file'     => trailingslashit( get_template_directory() ) . 'lib/import/demo-1/widgets.json',
				'local_import_revslider'  		 => array( 
					'slide1' => trailingslashit( get_template_directory() ) . 'lib/import/demo-1/home-page-1.zip' 
				),
				'local_import_options'         => array(
			array(
				'file_path'   => trailingslashit( get_template_directory() ) . 'lib/import/demo-4/theme_options.txt',
				'option_name' => 'maxshop_theme',
				),
			),
			'menu_locate'									 => array(
				'primary_menu' => esc_html__( 'Primary Menu', 'maxshop' ),   /* menu location => menu name for that location */
				'vertical_menu' => esc_html__( 'Left menu shop 5', 'maxshop' )
			),			
			'import_preview_image_url'     => get_template_directory_uri() . '/lib/import/demo-4/home4.png',
			'import_notice'                => __( 'After you import this demo, you will have to setup the slider separately. This import maybe finish on 10-15 minutes', 'maxshop' ),
			'preview_url'                  => esc_url( 'http://demo.wpthemego.com/themes/sw_maxshop/?page_id=4189&header_style=style4&scheme=green&footer_style=default' ),
		),
		
		array(
			'import_file_name'             => 'Home 5',
			'page_title'				 => 'Home Page 5',
			'local_import_file'            => trailingslashit( get_template_directory() ) . 'lib/import/demo-1/data.xml',
			'local_import_widget_file'     => trailingslashit( get_template_directory() ) . 'lib/import/demo-1/widgets.json',
			'local_import_revslider'  		 => array( 
				'slide1' => trailingslashit( get_template_directory() ) . 'lib/import/demo-1/home-page-1.zip',
			),
			'local_import_options'         => array(
				array(
					'file_path'   => trailingslashit( get_template_directory() ) . 'lib/import/demo-5/theme_options.txt',
					'option_name' => 'maxshop_theme',
				),
			),
			'menu_locate'									 => array(
				'primary_menu' => esc_html__( 'Primary Menu', 'maxshop' ),   /* menu location => menu name for that location */
				'vertical_menu' => esc_html__( 'Left menu shop 5', 'maxshop' )
			),
			'import_preview_image_url'     => get_template_directory_uri() . '/lib/import/demo-5/home5.png',
			'import_notice'                => __( 'After you import this demo, you will have to setup the slider separately. This import maybe finish on 10-15 minutes', 'maxshop' ),
			'preview_url'                  => esc_url( 'http://demo.wpthemego.com/themes/sw_maxshop/?page_id=4152&header_style=style5&scheme=cyan&footer_style=default' ),
		),
		
		array(
			'import_file_name'             => 'Home 6',
			'page_title'					=> 'Home Page 6',
			'local_import_file'            => trailingslashit( get_template_directory() ) . 'lib/import/demo-1/data.xml',
			'local_import_widget_file'     => trailingslashit( get_template_directory() ) . 'lib/import/demo-1/widgets.json',
			'local_import_revslider'  		 => array( 
				'slide1' => trailingslashit( get_template_directory() ) . 'lib/import/demo-1/home-page-1.zip',
			),
			'local_import_options'         => array(
				array(
					'file_path'   => trailingslashit( get_template_directory() ) . 'lib/import/demo-6/theme_options.txt',
					'option_name' => 'maxshop_theme',
				),
			),
			'menu_locate'									 => array(
				'primary_menu' => esc_html__( 'Primary Menu', 'maxshop' ),   /* menu location => menu name for that location */
				'vertical_menu' => esc_html__( 'Left menu shop 5', 'maxshop' )
			),
			'import_preview_image_url'     => get_template_directory_uri() . '/lib/import/demo-6/home6.png',
			'import_notice'                => __( 'After you import this demo, you will have to setup the slider separately. This import maybe finish on 10-15 minutes', 'maxshop' ),
			'preview_url'                  => esc_url( 'http://demo.wpthemego.com/themes/sw_maxshop/?page_id=7061&header_style=style6&scheme=default&footer_style=default' ),
		),
		
		array(
			'import_file_name'             => 'Home 7',
			'page_title'				   => 'Home Page 7',
			'local_import_file'            => trailingslashit( get_template_directory() ) . 'lib/import/demo-1/data.xml',
			'local_import_widget_file'     => trailingslashit( get_template_directory() ) . 'lib/import/demo-1/widgets.json',
			'local_import_revslider'  		 => array( 
				'slide1' => trailingslashit( get_template_directory() ) . 'lib/import/demo-1/home-page-1.zip',
			),
			'local_import_options'         => array(
			array(
				'file_path'   => trailingslashit( get_template_directory() ) . 'lib/import/demo-7/theme_options.txt',
				'option_name' => 'maxshop_theme',
				),
			),
			'menu_locate'									 => array(
				'primary_menu' => esc_html__( 'Primary Menu', 'maxshop' ),   /* menu location => menu name for that location */
				'vertical_menu' => esc_html__( 'Left menu shop 5', 'maxshop' )
			),
			'import_preview_image_url'     => get_template_directory_uri() . '/lib/import/demo-7/home7.png',
			'import_notice'                => __( 'After you import this demo, you will have to setup the slider separately. This import maybe finish on 10-15 minutes', 'maxshop' ),
			'preview_url'                  => esc_url( 'http://demo.wpthemego.com/themes/sw_maxshop/?page_id=7068&header_style=style7&scheme=default&footer_style=default' ),
		),
		
		array(
			'import_file_name'             => 'Home 8',
			'page_title'				   => 'Home Page 8',
			'local_import_file'            => trailingslashit( get_template_directory() ) . 'lib/import/demo-1/data.xml',
			'local_import_widget_file'     => trailingslashit( get_template_directory() ) . 'lib/import/demo-1/widgets.json',
			'local_import_revslider'  		 => array( 
				'slide1' => trailingslashit( get_template_directory() ) . 'lib/import/demo-8/home-page-8.zip',
			),
			'local_import_options'         => array(
				array(
					'file_path'   => trailingslashit( get_template_directory() ) . 'lib/import/demo-8/theme_options.txt',
					'option_name' => 'maxshop_theme',
				),
			),
			'menu_locate'									 => array(
				'primary_menu' => esc_html__( 'Primary Menu', 'maxshop' ),   /* menu location => menu name for that location */
				'vertical_menu' => esc_html__( 'Left menu shop 5', 'maxshop' )
			),
			'import_preview_image_url'     => get_template_directory_uri() . '/lib/import/demo-8/home8.png',
			'import_notice'                => __( 'After you import this demo, you will have to setup the slider separately. This import maybe finish on 10-15 minutes', 'maxshop' ),
			'preview_url'                  => esc_url( 'http://demo.wpthemego.com/themes/sw_maxshop/?page_id=7073&header_style=style8&scheme=default&footer_style=style8' ),
		),
		
		array(
			'import_file_name'             => 'Home 9',
			'page_title'				   => 'Home Page 9',
			'local_import_file'            => trailingslashit( get_template_directory() ) . 'lib/import/demo-1/data.xml',
			'local_import_widget_file'     => trailingslashit( get_template_directory() ) . 'lib/import/demo-1/widgets.json',
			'local_import_revslider'  		 => array( 
				'slide1' => trailingslashit( get_template_directory() ) . 'lib/import/demo-9/home-page-9.zip',
			),
			'local_import_options'         => array(
				array(
					'file_path'   => trailingslashit( get_template_directory() ) . 'lib/import/demo-9/theme_options.txt',
					'option_name' => 'maxshop_theme',
				),
			),
			'menu_locate'									 => array(
				'primary_menu' => esc_html__( 'Primary Menu', 'maxshop' ),   /* menu location => menu name for that location */
				'vertical_menu' => esc_html__( 'Left menu shop 5', 'maxshop' )
			),
			'import_preview_image_url'     => get_template_directory_uri() . '/lib/import/demo-9/home9.png',
			'import_notice'                => __( 'After you import this demo, you will have to setup the slider separately. This import maybe finish on 10-15 minutes', 'maxshop' ),
			'preview_url'                  => esc_url( 'http://demo.wpthemego.com/themes/sw_maxshop/?page_id=7259&header_style=style9&scheme=default&footer_style=style9' ),
		)
	);
}
add_filter( 'pt-ocdi/import_files', 'sw_import_files' );

