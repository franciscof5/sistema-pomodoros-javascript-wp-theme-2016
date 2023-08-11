<?php

/* #######################################################################

	Theme Options

####################################################################### */

function meanthemes_register_theme_customizer( $wp_customize ) {

	//
	// General Settings
	//

	$wp_customize->add_section(
	    'meanthemes_general_options',
	    array(
	        'title'     => __('General Settings','meanthemes'),
	        'priority'  => 0
	    )
	);

	$wp_customize->add_setting(
	     'auto_excerpt',
	     array(
	         'default'    =>  false,
	         'transport'  =>  'postMessage'
	     )
	 );


	$wp_customize->add_control(
	    'auto_excerpt',
	    array(
	        'section'   => 'meanthemes_general_options',
	        'label'     => __('Auto Excerpt on Blog?','meanthemes'),
	        'type'      => 'checkbox',
	        'priority' => 98
	    )
	);

	$wp_customize->add_setting(
	     'auto_excerpt_length',
	     array(
	         'default'    =>  '40'
	     )
	 );


	$wp_customize->add_control(
	    'auto_excerpt_length',
	    array(
	        'section'   => 'meanthemes_general_options',
	        'label'     => __('Auto Excerpt Length on Blog (Words)','meanthemes'),
	        'type'      => 'text',
	        'priority' => 99
	    )
	);





	$wp_customize->add_setting(
	     'hide_logo_text',
	     array(
	         'default'    =>  false,
	     )
	 );


	$wp_customize->add_control(
	    'hide_logo_text',
	    array(
	        'section'   => 'meanthemes_general_options',
	        'label'     => __('Hide Plain Text logo?','meanthemes'),
	        'type'      => 'checkbox',
	        'priority'  => 1
	    )
	);

	$wp_customize->add_setting(
	     'hide_tagline',
	     array(
	         'default'    =>  true,
	     )
	 );


	$wp_customize->add_control(
	    'hide_tagline',
	    array(
	        'section'   => 'meanthemes_general_options',
	        'label'     => __('Hide Tagline?','meanthemes'),
	        'type'      => 'checkbox',
	        'priority'  => 2
	    )
	);

	$wp_customize->add_setting(
	     'hide_sidebar',
	     array(
	         'default'    =>  true,
	     )
	 );


	$wp_customize->add_control(
	    'hide_sidebar',
	    array(
	        'section'   => 'meanthemes_general_options',
	        'label'     => __('Hide Global Sidebar?','meanthemes'),
	        'type'      => 'checkbox',
	        'priority'  => 4
	    )
	);

	$wp_customize->add_setting(
	     'alt_sidebar',
	     array(
	         'default'    =>  false,
	     )
	 );


	$wp_customize->add_control(
	    'alt_sidebar',
	    array(
	        'section'   => 'meanthemes_general_options',
	        'label'     => __('Use Alternate Global Sidebar?','meanthemes'),
	        'type'      => 'checkbox',
	        'priority'  => 5
	    )
	);



	$wp_customize->add_setting(
	     'hide_slab',
	     array(
	         'default'    =>  false,
	     )
	 );


	$wp_customize->add_control(
	    'hide_slab',
	    array(
	        'section'   => 'meanthemes_general_options',
	        'label'     => __('Hide Lead Text on homepage?','meanthemes'),
	        'type'      => 'checkbox',
	        'priority'  => 5
	    )
	);

	$wp_customize->add_setting(
	     'use_subtle_layout',
	     array(
	         'default'    =>  false,
	     )
	 );


	$wp_customize->add_control(
	    'use_subtle_layout',
	    array(
	        'section'   => 'meanthemes_general_options',
	        'label'     => __('Use "Subtle" Layout for Posts &amp; Pages? (e.g. no big lead image on posts/pages with overlaid title)','meanthemes'),
	        'type'      => 'checkbox',
	        'priority'  => 6
	    )
	);


	$wp_customize->add_setting(
	     'center_header',
	     array(
	         'default'    =>  false,
	     )
	 );


	$wp_customize->add_control(
	    'center_header',
	    array(
	        'section'   => 'meanthemes_general_options',
	        'label'     => __('Center Header','meanthemes'),
	        'type'      => 'checkbox',
	        'priority'  => 7
	    )
	);

	$wp_customize->add_setting(
	     'use_black_social_share',
	     array(
	         'default'    =>  false,
	     )
	 );


	 $wp_customize->add_control(
	     'use_black_social_share',
	     array(
	         'section'   => 'meanthemes_general_options',
	         'label'     => __('Use Black Social Share icons on posts?','meanthemes'),
	         'type'      => 'checkbox',
	         'priority'  => 7
	     )
	 );

	 $wp_customize->add_setting(
	      'hide_social_share',
	      array(
	          'default'    =>  false,
	      )
	  );


	$wp_customize->add_control(
	    'hide_social_share',
	    array(
	        'section'   => 'meanthemes_general_options',
	        'label'     => __('Hide Social Share on posts?','meanthemes'),
	        'type'      => 'checkbox',
	        'priority'  => 8
	    )
	);

	 $wp_customize->add_setting(
	     'hide_comments',
	     array(
	         'default'    =>  false,
	     )
	 );


	$wp_customize->add_control(
	    'hide_comments',
	    array(
	        'section'   => 'meanthemes_general_options',
	        'label'     => __('Hide Comments? - W,P,L,O,C,K,E,R,.C,O,M','meanthemes'),
	        'type'      => 'checkbox',
	        'priority'  => 9
	    )
	);


	$wp_customize->add_setting(
	     'show_comments_page',
	     array(
	         'default'    =>  false,
	     )
	 );


	$wp_customize->add_control(
	    'show_comments_page',
	    array(
	        'section'   => 'meanthemes_general_options',
	        'label'     => __('Enable Comments on Pages?','meanthemes'),
	        'type'      => 'checkbox',
	        'priority'  => 9
	    )
	);



	$wp_customize->add_setting(
	    'twitter_username',
	    array(
	        'default'   => '',
	    )
	);

	$wp_customize->add_control(
	    'twitter_username',
	    array(
	        'section'  => 'meanthemes_general_options',
	        'label'    => __('Twitter Username','meanthemes'),
	        'type'     => 'text',
	        'priority'  => 10
	    )
	);


	$wp_customize->add_setting(
			'show_comments_archive',
			array(
					'default'    =>  false,
			)
	);


$wp_customize->add_control(
		'show_comments_archive',
		array(
				'section'   => 'meanthemes_general_options',
				'label'     => __('Show Comment Count on Home/Archive?','meanthemes'),
				'type'      => 'checkbox',
				'priority'  => 98
		)
);






	//
	// Menu Settings
	//

	$wp_customize->add_section(
	    'menu_options',
	    array(
	        'title'     => __('Menu Settings','meanthemes'),
	        'priority'  => 1
	    )
	);



	$wp_customize->add_setting(
		     'use_standard_menu',
		     array(
		         'default'    =>  false,
		     )
		 );


		$wp_customize->add_control(
		    'use_standard_menu',
		    array(
		        'section'   => 'menu_options',
		        'label'     => __('Use Standard Desktop Menu?','meanthemes'),
		        'type'      => 'checkbox',
		        'priority'  => 9
		    )
		);




		$wp_customize->add_setting(
		     'use_standard_menu_screenwidth',
		     array(
		         'default'    =>  '767',
		     )
		 );


		$wp_customize->add_control(
		    'use_standard_menu_screenwidth',
		    array(
		        'section'   => 'menu_options',
		        'label'     => __('Activate mobile menu at (only use in conjunction with "Standard Desktop" Menu)','meanthemes'),
		        'type'      => 'text',
		        'priority'  => 10
		    )
		);






		$wp_customize->add_setting(
		     'hide_menu_icon',
		     array(
		         'default'    =>  false,
		     )
		 );


		$wp_customize->add_control(
		    'hide_menu_icon',
		    array(
		        'section'   => 'menu_options',
		        'label'     => __('Hide Menu Icon?','meanthemes'),
		        'type'      => 'checkbox',
		        'priority'  => 1
		    )
		);



	$wp_customize->add_setting(
		    'recent_posts_count',
		    array(
		        'default'   => '10',
		    )
		);

		$wp_customize->add_control(
		    'recent_posts_count',
		    array(
		        'section'  => 'menu_options',
		        'label'    => __('Amount of Recent Posts on Navigation Overlay','meanthemes'),
		        'type'     => 'text',
		        'priority'  => 4
		    )
		);

		$wp_customize->add_setting(
		     'hide_recent_posts_overlay',
		     array(
		         'default'    =>  false,
		     )
		 );


		$wp_customize->add_control(
		    'hide_recent_posts_overlay',
		    array(
		        'section'   => 'menu_options',
		        'label'     => __('Hide Recent Posts Title on Navigation Overlay?','meanthemes'),
		        'type'      => 'checkbox',
		        'priority'  => 3
		    )
		);

		$wp_customize->add_setting(
		     'hide_navigation_overlay',
		     array(
		         'default'    =>  false,
		     )
		 );


		$wp_customize->add_control(
		    'hide_navigation_overlay',
		    array(
		        'section'   => 'menu_options',
		        'label'     => __('Hide Navigation Title on Navigation?','meanthemes'),
		        'type'      => 'checkbox',
		        'priority'  => 2
		    )
		);


	//
	// Background Colours
	//
	$wp_customize->add_section(
	    'bg_colors',
	    array(
	        'title'     => __('Background & Border Colors','meanthemes'),
	        'priority'  => 50
	    )
	);



	$wp_customize->add_setting(
	    'bg_color_header',
	    array(
	        'default'   => '#282a2a'
	    )
	);

	$wp_customize->add_control(
	    new WP_Customize_Color_Control(
	        $wp_customize,
	        'bg_color_header',
	        array(
	            'label'      => __( 'Header Background Colour', 'meanthemes' ),
	            'section'    => 'bg_colors',
	            'settings'   => 'bg_color_header',
	            'priority'  => 0
	        )
	    )
	);

	$wp_customize->add_setting(
	    'bg_color_sitenav',
	    array(
	        'default'   => '#1e1f1f'
	    )
	);

	$wp_customize->add_control(
	    new WP_Customize_Color_Control(
	        $wp_customize,
	        'bg_color_sitenav',
	        array(
	            'label'      => __( 'Site Navigation Overlay Background Color', 'meanthemes' ),
	            'section'    => 'bg_colors',
	            'settings'   => 'bg_color_sitenav',
	            'priority'  => 1
	        )
	    )
	);


	$wp_customize->add_setting(
	    'bg_color_sitehead',
	    array(
	        'default'   => '#000000'
	    )
	);

	$wp_customize->add_control(
	    new WP_Customize_Color_Control(
	        $wp_customize,
	        'bg_color_sitehead',
	        array(
	            'label'      => __( 'Page & Post Lead Background Color', 'meanthemes' ),
	            'section'    => 'bg_colors',
	            'settings'   => 'bg_color_sitehead',
	            'priority'  => 1
	        )
	    )
	);

	$wp_customize->add_setting(
	    'bg_color_widgets',
	    array(
	        'default'   => '#ffffff'
	    )
	);

	$wp_customize->add_control(
	    new WP_Customize_Color_Control(
	        $wp_customize,
	        'bg_color_widgets',
	        array(
	            'label'      => __( 'Footer Widgets Background', 'meanthemes' ),
	            'section'    => 'bg_colors',
	            'settings'   => 'bg_color_widgets',
	            'priority'  => 1
	        )
	    )
	);

	$wp_customize->add_setting(
	    'bg_color_body',
	    array(
	        'default'   => '#f4f4f4'
	    )
	);

	$wp_customize->add_control(
	    new WP_Customize_Color_Control(
	        $wp_customize,
	        'bg_color_body',
	        array(
	            'label'      => __( 'Body Background', 'meanthemes' ),
	            'section'    => 'bg_colors',
	            'settings'   => 'bg_color_body',
	            'priority'  => 1
	        )
	    )
	);

	$wp_customize->add_setting(
	    'bg_color_post',
	    array(
	        'default'   => '#ffffff',
	    )
	);

	$wp_customize->add_control(
	    new WP_Customize_Color_Control(
	        $wp_customize,
	        'bg_color_post',
	        array(
	            'label'      => __( 'Post background', 'meanthemes' ),
	            'section'    => 'bg_colors',
	            'settings'   => 'bg_color_post',
	            'priority'  => 1
	        )
	    )
	);


	$wp_customize->add_setting(
			'bg_color_footer',
			array(
					'default'   => '#f6f4f4',
			)
	);

	$wp_customize->add_control(
			new WP_Customize_Color_Control(
					$wp_customize,
					'bg_color_footer',
					array(
							'label'      => __( 'Footer background', 'meanthemes' ),
							'section'    => 'bg_colors',
							'priority'  => 1
					)
			)
	);




	$wp_customize->add_setting(
	    'button_color',
	    array(
	        'default'   => '#06b25b'
	    )
	);

	$wp_customize->add_control(
	    new WP_Customize_Color_Control(
	        $wp_customize,
	        'button_color',
	        array(
	            'label'      => __( 'Button Color', 'meanthemes' ),
	            'section'    => 'bg_colors',
	            'settings'   => 'button_color',
	            'priority'  => 9
	        )
	    )
	);


	$wp_customize->add_setting(
	    'button_color_hover',
	    array(
	        'default'   => '#474747'
	    )
	);

	$wp_customize->add_control(
	    new WP_Customize_Color_Control(
	        $wp_customize,
	        'button_color_hover',
	        array(
	            'label'      => __( 'Button Hover Color', 'meanthemes' ),
	            'section'    => 'bg_colors',
	            'settings'   => 'button_color_hover',
	            'priority'  => 10
	        )
	    )
	);



	$wp_customize->add_setting(
	    'bg_color_slab',
	    array(
	        'default'   => '#ffffff'
	    )
	);

	$wp_customize->add_control(
	    new WP_Customize_Color_Control(
	        $wp_customize,
	        'bg_color_slab',
	        array(
	            'label'      => __( 'Home Intro Background Color', 'meanthemes' ),
	            'section'    => 'bg_colors',
	            'settings'   => 'bg_color_slab',
	            'priority'  => 11
	        )
	    )
	);


	$wp_customize->add_setting(
	    'bg_color_format_link',
	    array(
	        'default'   => '#06b25b'
	    )
	);

	$wp_customize->add_control(
	    new WP_Customize_Color_Control(
	        $wp_customize,
	        'bg_color_format_link',
	        array(
	            'label'      => __( 'Link Format Background Color', 'meanthemes' ),
	            'section'    => 'bg_colors',
	            'settings'   => 'bg_color_format_link',
	            'priority'  => 12
	        )
	    )
	);


	$wp_customize->add_setting(
	    'bg_color_flexslider',
	    array(
	        'default'   => '#06b25b'
	    )
	);

	$wp_customize->add_control(
	    new WP_Customize_Color_Control(
	        $wp_customize,
	        'bg_color_flexslider',
	        array(
	            'label'      => __( 'Gallery Format Background Color', 'meanthemes' ),
	            'section'    => 'bg_colors',
	            'settings'   => 'bg_color_flexslider',
	            'priority'  => 13
	        )
	    )
	);

	$wp_customize->add_setting(
	    'bg_color_comment_title',
	    array(
	        'default'   => '#414141'
	    )
	);

	$wp_customize->add_control(
	    new WP_Customize_Color_Control(
	        $wp_customize,
	        'bg_color_comment_title',
	        array(
	            'label'      => __( 'Comments title Background Color', 'meanthemes' ),
	            'section'    => 'bg_colors',
	            'settings'   => 'bg_color_comment_title',
	            'priority'  => 14
	        )
	    )
	);


	$wp_customize->add_setting(
	    'bg_color_archive_post_image',
	    array(
	        'default'   => '#000000'
	    )
	);

	$wp_customize->add_control(
	    new WP_Customize_Color_Control(
	        $wp_customize,
	        'bg_color_archive_post_image',
	        array(
	            'label'      => __( 'Archive/Index Post Image Background Color', 'meanthemes' ),
	            'section'    => 'bg_colors',
	            'settings'   => 'bg_color_archive_post_image',
	            'priority'  => 15
	        )
	    )
	);

	$wp_customize->add_setting(
	    'bg_color_flex_caption',
	    array(
	        'default'   => '#fdfdfd'
	    )
	);

	$wp_customize->add_control(
	    new WP_Customize_Color_Control(
	        $wp_customize,
	        'bg_color_flex_caption',
	        array(
	            'label'      => __( 'Archive/Index Post Image Background Color', 'meanthemes' ),
	            'section'    => 'bg_colors',
	            'settings'   => 'bg_color_flex_caption',
	            'priority'  => 16
	        )
	    )
	);





	$wp_customize->add_setting(
	    'border_color_blockquote',
	    array(
	        'default'   => '#6fce6f'
	    )
	);

	$wp_customize->add_control(
	    new WP_Customize_Color_Control(
	        $wp_customize,
	        'border_color_blockquote',
	        array(
	            'label'      => __( 'Border Color Blockquote', 'meanthemes' ),
	            'section'    => 'bg_colors',
	            'settings'   => 'border_color_blockquote',
	            'priority'  => 98
	        )
	    )
	);

	$wp_customize->add_setting(
	    'border_color',
	    array(
	        'default'   => '#e1e2e2'
	    )
	);

	$wp_customize->add_control(
	    new WP_Customize_Color_Control(
	        $wp_customize,
	        'border_color',
	        array(
	            'label'      => __( 'Border Color', 'meanthemes' ),
	            'section'    => 'bg_colors',
	            'settings'   => 'border_color',
	            'priority'  => 99
	        )
	    )
	);


	//
	// Font Colours
	//
	$wp_customize->add_setting(
	        'color_blog_title',
	        array(
	            'default'     => '#ffffff'
	        )
	    );

	$wp_customize->add_control(
	    new WP_Customize_Color_Control(
	        $wp_customize,
	        'color_blog_title',
	        array(
	            'label'      => __( 'Blog Title', 'meanthemes' ),
	            'section'    => 'colors',
	            'settings'   => 'color_blog_title',
	            'priority'  => 1
	        )
	    )
	);

	$wp_customize->add_setting(
	        'color_blog_title_hover',
	        array(
	            'default'     => '#fafafa',
	        )
	    );

	$wp_customize->add_control(
	    new WP_Customize_Color_Control(
	        $wp_customize,
	        'color_blog_title_hover',
	        array(
	            'label'      => __( 'Blog Title Hover', 'meanthemes' ),
	            'section'    => 'colors',
	            'settings'   => 'color_blog_title_hover',
	            'priority'  => 2
	        )
	    )
	);

	$wp_customize->add_setting(
	        'color_blog_tagline',
	        array(
	            'default'     => '#939494'
	        )
	    );

	$wp_customize->add_control(
	    new WP_Customize_Color_Control(
	        $wp_customize,
	        'color_blog_tagline',
	        array(
	            'label'      => __( 'Blog Tagline', 'meanthemes' ),
	            'section'    => 'colors',
	            'settings'   => 'color_blog_tagline',
	            'priority'  => 3
	        )
	    )
	);


	$wp_customize->add_setting(
	        'color_main',
	        array(
	            'default'     => '#434343'
	        )
	    );

	$wp_customize->add_control(
	    new WP_Customize_Color_Control(
	        $wp_customize,
	        'color_main',
	        array(
	            'label'      => __( 'Main Text', 'meanthemes' ),
	            'section'    => 'colors',
	            'settings'   => 'color_main',
	            'priority'  => 4
	        )
	    )
	);


	$wp_customize->add_setting(
	        'color_headings',
	        array(
	            'default'     => '#1d1c1c'
	        )
	    );

	$wp_customize->add_control(
	    new WP_Customize_Color_Control(
	        $wp_customize,
	        'color_headings',
	        array(
	            'label'      => __( 'Heading Colour', 'meanthemes' ),
	            'section'    => 'colors',
	            'settings'   => 'color_headings',
	            'priority'  => 5
	        )
	    )
	);



	$wp_customize->add_setting(
	        'color_link',
	        array(
	            'default'     => '#06b25b'
	        )
	    );

	$wp_customize->add_control(
	    new WP_Customize_Color_Control(
	        $wp_customize,
	        'color_link',
	        array(
	            'label'      => __( 'Main Link', 'meanthemes' ),
	            'section'    => 'colors',
	            'settings'   => 'color_link',
	            'priority'  => 6
	        )
	    )
	);

	$wp_customize->add_setting(
	        'color_link_hover',
	        array(
	            'default'     => '#1d1c1c',
	        )
	    );

	$wp_customize->add_control(
	    new WP_Customize_Color_Control(
	        $wp_customize,
	        'color_link_hover',
	        array(
	            'label'      => __( 'Main Link Hover', 'meanthemes' ),
	            'section'    => 'colors',
	            'settings'   => 'color_link_hover',
	            'priority'  => 7
	        )
	    )
	);

	$wp_customize->add_setting(
	        'color_meta',
	        array(
	            'default'     => '#d2d2d2'
	        )
	    );


	$wp_customize->add_control(
	    new WP_Customize_Color_Control(
	        $wp_customize,
	        'color_meta',
	        array(
	            'label'      => __( 'Meta Text', 'meanthemes' ),
	            'section'    => 'colors',
	            'settings'   => 'color_meta',
	            'priority'  => 8
	        )
	    )
	);

	$wp_customize->add_setting(
	        'color_meta_link_hover',
	        array(
	            'default'     => '#404040'
	        )
	    );


	$wp_customize->add_control(
	    new WP_Customize_Color_Control(
	        $wp_customize,
	        'color_meta_link_hover',
	        array(
	            'label'      => __( 'Meta Text Link Hover', 'meanthemes' ),
	            'section'    => 'colors',
	            'settings'   => 'color_meta_link_hover',
	            'priority'  => 9
	        )
	    )
	);






    $wp_customize->add_setting(
            'color_archive_title_link',
            array(
                'default'     => '#404040'
            )
        );

        $wp_customize->add_control(
            new WP_Customize_Color_Control(
                $wp_customize,
                'color_archive_title_link',
                array(
                    'label'      => __( 'Archive Title Link', 'meanthemes' ),
                    'section'    => 'colors',
                    'settings'   => 'color_archive_title_link',
                    'priority'  => 10
                )
            )
        );

        $wp_customize->add_setting(
                'color_archive_title_link_hover',
                array(
                    'default'     => '#06b25b'
                )
            );

        $wp_customize->add_control(
            new WP_Customize_Color_Control(
                $wp_customize,
                'color_archive_title_link_hover',
                array(
                    'label'      => __( 'Archive Title Link Hover', 'meanthemes' ),
                    'section'    => 'colors',
                    'settings'   => 'color_archive_title_link_hover',
                    'priority'  => 11
                )
            )
        );


        $wp_customize->add_setting(
                'color_nav_link',
                array(
                    'default'     => '#ffffff'
                )
            );

        $wp_customize->add_control(
            new WP_Customize_Color_Control(
                $wp_customize,
                'color_nav_link',
                array(
                    'label'      => __( 'Navigation Overlay Link', 'meanthemes' ),
                    'section'    => 'colors',
                    'settings'   => 'color_nav_link',
                    'priority'  => 12
                )
            )
        );



        $wp_customize->add_setting(
                'color_nav_link_hover',
                array(
                    'default'     => '#06b25b'
                )
            );

        $wp_customize->add_control(
            new WP_Customize_Color_Control(
                $wp_customize,
                'color_nav_link_hover',
                array(
                    'label'      => __( 'Navigation Overlay Link Hover', 'meanthemes' ),
                    'section'    => 'colors',
                    'settings'   => 'color_nav_link_hover',
                    'priority'  => 13
                )
            )
        );


        $wp_customize->add_setting(
                'color_amp',
                array(
                    'default'     => '#60686a'
                )
            );

        $wp_customize->add_control(
            new WP_Customize_Color_Control(
                $wp_customize,
                'color_amp',
                array(
                    'label'      => __( 'Ampersand Color', 'meanthemes' ),
                    'section'    => 'colors',
                    'settings'   => 'color_amp',
                    'priority'  => 14
                )
            )
        );


        $wp_customize->add_setting(
                'color_single_lead',
                array(
                    'default'     => '#ffffff'
                )
            );

        $wp_customize->add_control(
            new WP_Customize_Color_Control(
                $wp_customize,
                'color_single_lead',
                array(
                    'label'      => __( 'Page &amp; Post Lead Color', 'meanthemes' ),
                    'section'    => 'colors',
                    'settings'   => 'color_single_lead',
                    'priority'  => 15
                )
            )
        );

       $wp_customize->add_setting(
               'color_single_lead_hover',
               array(
                   'default'     => '#cccccc'
               )
           );

       $wp_customize->add_control(
           new WP_Customize_Color_Control(
               $wp_customize,
               'color_single_lead_hover',
               array(
                   'label'      => __( 'Page &amp; Post Lead Meta Hover Color', 'meanthemes' ),
                   'section'    => 'colors',
                   'settings'   => 'color_single_lead_hover',
                   'priority'  => 16
               )
           )
       );

       $wp_customize->add_setting(
               'color_menu_control',
               array(
                   'default'     => '#ffffff'
               )
           );

       $wp_customize->add_control(
           new WP_Customize_Color_Control(
               $wp_customize,
               'color_menu_control',
               array(
                   'label'      => __( 'Menu Link/Icon Color', 'meanthemes' ),
                   'section'    => 'colors',
                   'settings'   => 'color_menu_control',
                   'priority'  => 17
               )
           )
       );


       $wp_customize->add_setting(
               'color_link_format',
               array(
                   'default'     => '#ffffff'
               )
           );

       $wp_customize->add_control(
           new WP_Customize_Color_Control(
               $wp_customize,
               'color_link_format',
               array(
                   'label'      => __( 'Link Format Color', 'meanthemes' ),
                   'section'    => 'colors',
                   'settings'   => 'color_link_format',
                   'priority'  => 18
               )
           )
       );


       $wp_customize->add_setting(
               'color_link_format_hover',
               array(
                   'default'     => '#404040'
               )
           );

       $wp_customize->add_control(
           new WP_Customize_Color_Control(
               $wp_customize,
               'color_link_format_hover',
               array(
                   'label'      => __( 'Link Format Color', 'meanthemes' ),
                   'section'    => 'colors',
                   'settings'   => 'color_link_format_hover',
                   'priority'  => 19
               )
           )
       );

       $wp_customize->add_setting(
               'color_link_comment_title',
               array(
                   'default'     => '#ffffff'
               )
           );

       $wp_customize->add_control(
           new WP_Customize_Color_Control(
               $wp_customize,
               'color_link_comment_title',
               array(
                   'label'      => __( 'Commment Title Color', 'meanthemes' ),
                   'section'    => 'colors',
                   'settings'   => 'color_link_comment_title',
                   'priority'  => 19
               )
           )
       );



       $wp_customize->add_setting(
               'color_footer_widget_link',
               array(
                   'default'     => '#414141'
               )
           );

       $wp_customize->add_control(
           new WP_Customize_Color_Control(
               $wp_customize,
               'color_footer_widget_link',
               array(
                   'label'      => __( 'Footer Widget Link Color', 'meanthemes' ),
                   'section'    => 'colors',
                   'settings'   => 'color_footer_widget_link',
                   'priority'  => 21
               )
           )
       );

       $wp_customize->add_setting(
               'color_footer_widget_link_hover',
               array(
                   'default'     => '#06b25b'
               )
           );

       $wp_customize->add_control(
           new WP_Customize_Color_Control(
               $wp_customize,
               'color_footer_widget_link_hover',
               array(
                   'label'      => __( 'Footer Widget Link Hover Color', 'meanthemes' ),
                   'section'    => 'colors',
                   'settings'   => 'color_footer_widget_link_hover',
                   'priority'  => 22
               )
           )
       );


			$wp_customize->add_setting(
							'color_footer',
							array(
									'default'     => '#414141'
							)
					);

			$wp_customize->add_control(
					new WP_Customize_Color_Control(
							$wp_customize,
							'color_footer',
							array(
									'label'      => __( 'Footer Text &amp; Footer Links', 'meanthemes' ),
									'section'    => 'colors',
									'priority'  => 23
							)
					)
			);


			$wp_customize->add_setting(
							'color_footer_link_hover',
							array(
									'default'     => '#06b25b'
							)
					);

			$wp_customize->add_control(
					new WP_Customize_Color_Control(
							$wp_customize,
							'color_footer_link_hover',
							array(
									'label'      => __( 'Footer Link Hover', 'meanthemes' ),
									'section'    => 'colors',
									'priority'  => 23
							)
					)
			);


        //
        // Fonts
        //

        $wp_customize->add_section(
            'meanthemes_font',
            array(
                'title'     => __('Fonts','meanthemes'),
                'priority'  => 2
            )
        );

        $wp_customize->add_setting(
            'font_main',
            array(
                'default'   => 'Noto Serif',
                'transport' => 'postMessage'
            )
        );

        $wp_customize->add_control(
            'font_main',
            array(
                'section'  => 'meanthemes_font',
                'label'    => __('Main Font','meanthemes'),
                'type'     => 'select',
                'choices'  => array(
                    'Noto Serif' => 'Noto Serif (Default)',
                    'LeagueGothicRegular' => 'League Gothic',
                    'Helvetica Neue' => 'Helvetica Neue',
                    'helvetica' => 'Helvetica',
                    'arial'     => 'Arial',
                    'verdana'   => 'Verdana',
                    'times'     => 'Times New Roman',
                    'georgia'   => 'Georgia',
                    'courier'   => 'Courier New'
                ),
                'priority' => 1
            )
        );

        $wp_customize->add_setting(
            'font_headings',
            array(
                'default'   => 'Lato',
                'transport' => 'postMessage'
            )
        );

        $wp_customize->add_control(
            'font_headings',
            array(
                'section'  => 'meanthemes_font',
                'label'    => __('Heading & Meta Font','meanthemes'),
                'type'     => 'select',
                'choices'  => array(
                    'Lato' => 'Lato Black (Default)',
                    'Noto Serif' => 'Noto Serif',
                    'LeagueGothicRegular' => 'League Gothic',
                    'Helvetica Neue' => 'Helvetica Neue',
                    'helvetica' => 'Helvetica',
                    'arial'     => 'Arial',
                    'verdana'   => 'Verdana',
                    'times'     => 'Times New Roman',
                    'georgia'   => 'Georgia',
                    'courier'   => 'Courier New'
                ),
                'priority' => 2
            )
        );


        $wp_customize->add_setting(
            'font_uppercase',
            array(
                'default'   => true,
                'transport' => 'postMessage'
            )
        );

        $wp_customize->add_control(
            'font_uppercase',
            array(
                'section'   => 'meanthemes_font',
                'label'     => __('Uppercase all "Titles"?','meanthemes'),
                'type'      => 'checkbox',
                'priority' => 3
            )
        );

        //
        // Fonts
        //

        $wp_customize->add_section(
            'font_advanced',
            array(
                'title'     => __('Fonts Advanced','meanthemes'),
                'description'	=>	__( 'We support Google web fonts, Typekit and Adobe Web fonts. Paste their code in to the Font Service Code block below then enter the font family as they tell you to in the Font Family textboxes for Heading &amp; Main. Finally choose your font-weight. <br /><br /><strong>You need to save and publish to view your changes</strong>.' , 'meanthemes' ),
                'priority'  => 69
            )
        );

        //
        // Font Service
        //
        class Font_Service_Control extends WP_Customize_Control {
            public $type = 'font_advanced_service';

            public function render_content() {
                ?>
                    <label>
                        <span class="customize-control-title"><?php echo esc_html( $this->label ); ?></span>
                        <textarea rows="7" style="width:100%;" <?php $this->link(); ?>><?php echo esc_textarea( $this->value() ); ?></textarea>
                    </label>
                <?php
            }
        }
        $wp_customize->add_setting( 'font_advanced_service' );
        $wp_customize->add_control(
            new Font_Service_Control(
                $wp_customize, 'font_advanced_service',
                array(
                    'label' => 'Service Code',
                    'section' => 'font_advanced',
                    'settings' => 'font_advanced_service',
                    'priority' => 1,
                )
            )
        );

        $wp_customize->add_setting(
            'font_advanced_service_main',
            array(
                'default'   => '',
                'transport' => 'postMessage'
            )
        );


        $wp_customize->add_control(
            'font_advanced_service_main',
            array(
                'section'   => 'font_advanced',
                'label'     => __( 'Main Font Family' , 'meanthemes' ),
                'type'      => 'text',
                'priority' => 2
            )
        );


        $wp_customize->add_setting(
            'font_advanced_service_main_weight',
            array(
                'default'   => '400',
                'transport' => 'postMessage'
            )
        );

        $wp_customize->add_control(
            'font_advanced_service_main_weight',
            array(
                'section'  => 'font_advanced',
                'label'    => __('Font Weight for Main','meanthemes'),
                'type'     => 'select',
                'priority' => 3,
                'choices'  => array(
                    '100' => 'Thin (100)',
                    '200' => 'Extra-light (200)',
                    '300' => 'Light (300)',
                    '400'     => 'Normal (400)',
                    '500'   => 'Medium (500)',
                    '600'     => 'Semi-Bold (600)',
                    '700'   => 'Bold (700)',
                    '800'   => 'Extra-Bold (800)',
                    '900' => 'Ultra-Bold (900)'
                )
            )
        );

        $wp_customize->add_setting(
            'font_advanced_service_heading_weight',
            array(
                'default'   => '600',
                'transport' => 'postMessage'
            )
        );

        $wp_customize->add_control(
            'font_advanced_service_heading_weight',
            array(
                'section'  => 'font_advanced',
                'label'    => __('Font Weight for Headings & Meta','meanthemes'),
                'type'     => 'select',
                'priority' => 4,
                'choices'  => array(
                    '100' => 'Thin (100)',
                    '200' => 'Extra-light (200)',
                    '300' => 'Light (300)',
                    '400'     => 'Normal (400)',
                    '500'   => 'Medium (500)',
                    '600'     => 'Semi-Bold (600)',
                    '700'   => 'Bold (700)',
                    '800'   => 'Extra-Bold (800)',
                    '900' => 'Ultra-Bold (900)'
                )
            )
        );

        $wp_customize->add_setting(
            'font_advanced_service_main_oblique',
            array(
                'default'   => false,
                'transport' => 'postMessage'
            )
        );

        $wp_customize->add_control(
            'font_advanced_service_main_oblique',
            array(
                'section'   => 'font_advanced',
                'label'     => __('Italicise Main?','meanthemes'),
                'type'      => 'checkbox',
                'priority' => 3
            )
        );

        $wp_customize->add_setting(
            'font_advanced_service_heading_oblique',
            array(
                'default'   => false,
                'transport' => 'postMessage'
            )
        );

        $wp_customize->add_control(
            'font_advanced_service_heading_oblique',
            array(
                'section'   => 'font_advanced',
                'label'     => __('Italicise Heading &amp; Meta?','meanthemes'),
                'type'      => 'checkbox',
                'priority' => 4
            )
        );

        $wp_customize->add_setting(
            'font_advanced_service_headings',
            array(
                'default'   => '',
                'transport' => 'postMessage'
            )
        );


        $wp_customize->add_control(
            'font_advanced_service_headings',
            array(
                'section'   => 'font_advanced',
                'label'     => __( 'Heading &amp; Meta Font Family' , 'meanthemes' ),
                'type'      => 'text',
                'priority' => 3
            )
        );


        //
        // Image uploads
        //

        $wp_customize->add_section(
            'meanthemes_image_options',
            array(
                'title'     => __('Image Uploads','meanthemes'),
                'description' => '',
                'priority'  => 70
            )
        );

        $wp_customize->add_setting(
            'meanthemes_logo_image_retina',
            array(
                'default'      => '',
                'transport'    => 'postMessage',
                'priority' => 0
            )
        );


        $wp_customize->add_control(
            new WP_Customize_Image_Control(
                $wp_customize,
                'meanthemes_logo_image_retina',
                array(
                    'label'    => __('Logo (Retina)','meanthemes'),
                    'settings' => 'meanthemes_logo_image_retina',
                    'section'  => 'meanthemes_image_options'
                )
            )
        );

        $wp_customize->add_setting(
            'meanthemes_logo_image',
            array(
                'default'      => '',
                'transport'    => 'postMessage',
                'priority' => 1
            )
        );


        $wp_customize->add_control(
            new WP_Customize_Image_Control(
                $wp_customize,
                'meanthemes_logo_image',
                array(
                    'label'    => __('Logo','meanthemes'),
                    'settings' => 'meanthemes_logo_image',
                    'section'  => 'meanthemes_image_options'
                )
            )
        );

        $wp_customize->add_setting(
            'favicon_image',
            array(
                'default'      => '',
                'transport'    => 'postMessage',
                'priority' => 2
            )
        );


        $wp_customize->add_control(
            new WP_Customize_Image_Control(
                $wp_customize,
                'favicon_image',
                array(
                    'label'    => __('Upload Favicon (32x32px)','meanthemes'),
                    'settings' => 'favicon_image',
                    'section'  => 'meanthemes_image_options'
                )
            )
        );

        $wp_customize->add_setting(
            'appleicon_image',
            array(
                'default'      => '',
                'transport'    => 'postMessage',
                'priority' => 2
            )
        );


        $wp_customize->add_control(
            new WP_Customize_Image_Control(
                $wp_customize,
                'appleicon_image',
                array(
                    'label'    => __('Upload Apple Touch Icon (144x144px)','meanthemes'),
                    'settings' => 'appleicon_image',
                    'section'  => 'meanthemes_image_options'
                )
            )
        );

        $wp_customize->add_setting(
            'meanthemes_background_image',
            array(
                'default'      => '',
                'transport'    => 'postMessage'
            )
        );


        $wp_customize->add_control(
            new WP_Customize_Image_Control(
                $wp_customize,
                'meanthemes_background_image',
                array(
                    'label'    => __('Post & Page Lead Image (over 1680x650 is ideal)','meanthemes'),
                    'settings' => 'meanthemes_background_image',
                    'section'  => 'meanthemes_image_options'
                )
            )
        );

        $wp_customize->add_setting(
            'body_background_tile_image',
            array(
                'default'      => '',
                'transport'    => 'postMessage'
            )
        );


        $wp_customize->add_control(
            new WP_Customize_Image_Control(
                $wp_customize,
                'body_background_tile_image',
                array(
                    'label'    => __('Body Background Tile','meanthemes'),
                    'settings' => 'body_background_tile_image',
                    'section'  => 'meanthemes_image_options'
                )
            )
        );



        //
        // Image settings
        //

        $wp_customize->add_section(
            'image_settings',
            array(
                'title'     => __('Image Settings','meanthemes'),
                'description' => __('You can choose to override the featured image settings here. Set a width, height and hard crop. <strong> Do not include values e.g. just enter 1100 and not 1100px</strong>. Once done please install and run the <a href="http://wordpress.org/plugins/regenerate-thumbnails/" target="_blank">Regenerate Thumbnails</a> plugin.','meanthemes'),
                'priority'  => 70
            )
        );


        $wp_customize->add_setting(
             'use_image_settings',
             array(
                 'default'    =>  false,
                 'transport'  =>  'postMessage',
                 'priority' => 1
             )
         );


        $wp_customize->add_control(
            'use_image_settings',
            array(
                'section'   => 'image_settings',
                'label'     => __('Override image settings with below?','meanthemes'),
                'type'      => 'checkbox'
            )
        );

        $wp_customize->add_setting(
            'image_width',
            array(
                'default'      => '1100',
                'transport'    => 'postMessage',
                'priority' => 2
            )
        );

        $wp_customize->add_control(
            'image_width',
            array(
                'section'   => 'image_settings',
                'label'     => __('Set image width (default is 1100)','meanthemes'),
                'type'      => 'text'
            )
        );


       $wp_customize->add_setting(
            'image_height',
            array(
                'default'      => '9999',
                'transport'    => 'postMessage',
                'priority' => 3
            )
        );

        $wp_customize->add_control(
            'image_height',
            array(
                'section'   => 'image_settings',
                'label'     => __('Set image height (leave 9999 for unfixed height)','meanthemes'),
                'type'      => 'text'
            )
        );


       $wp_customize->add_setting(
            'image_crop',
            array(
                'default'    =>  false,
                'transport'  =>  'postMessage',
                'priority' => 4
            )
        );


       $wp_customize->add_control(
           'image_crop',
           array(
               'section'   => 'image_settings',
               'label'     => __('Hard crop all images?','meanthemes'),
               'type'      => 'checkbox'
           )
       );

       $wp_customize->add_setting(
            'image_center',
            array(
                'default'    =>  false,
                'transport'  =>  'postMessage',
                'priority' => 4
            )
        );


       $wp_customize->add_control(
           'image_center',
           array(
               'section'   => 'image_settings',
               'label'     => __('Center all featured images?','meanthemes'),
               'type'      => 'checkbox'
           )
       );





        class Custom_CSS_Control extends WP_Customize_Control {
            public $type = 'custom_css';

            public function render_content() {
                ?>
                    <label>
                        <span class="customize-control-title"><?php echo esc_html( $this->label ); ?></span>
                        <textarea rows="7" style="width:100%;" <?php $this->link(); ?>><?php echo esc_textarea( $this->value() ); ?></textarea>
                    </label>
                <?php
            }
        }

             //
             // CUSTOM TEXT
             //

             class Text_Control extends WP_Customize_Control {
                 public $type = 'text_control';

                 public function render_content() {
                     ?>
                         <label>
                             <span class="customize-control-title"><?php echo esc_html( $this->label ); ?></span>
                             <textarea rows="9" style="width:100%;" <?php $this->link(); ?>><?php echo esc_textarea( $this->value() ); ?></textarea>
                         </label>
                     <?php
                 }
             }


             class Text_Control2 extends WP_Customize_Control {
                 public $type = 'text_control2';

                 public function render_content() {
                     ?>
                         <label>
                             <span class="customize-control-title"><?php echo esc_html( $this->label ); ?></span>
                             <textarea rows="9" style="width:100%;" <?php $this->link(); ?>><?php echo esc_textarea( $this->value() ); ?></textarea>
                         </label>
                     <?php
                 }
             }

             class Text_Control3 extends WP_Customize_Control {
                 public $type = 'text_control3';

                 public function render_content() {
                     ?>
                         <label>
                             <span class="customize-control-title"><?php echo esc_html( $this->label ); ?></span>
                             <textarea rows="9" style="width:100%;" <?php $this->link(); ?>><?php echo esc_textarea( $this->value() ); ?></textarea>
                         </label>
                     <?php
                 }
             }


             $wp_customize->add_section(
             	    'text_settings',
             	    array(
             	        'title' => __('Custom Text','meanthemes'),
             	        'priority' => 71,
             	    )
             	);




           $wp_customize->add_setting( 'home_slab', array(
           		'default' => "<span class='slabtext'>I am Wharton</span> <span class='slabtext'>I'm Lean <span class='amp'>&amp;</span> I'm Keen</span>",
                ) );
           $wp_customize->add_control(
               new Custom_CSS_Control( $wp_customize, 'text_control2',
                   array(
                       'label' => 'Home Headline text',
                       'section' => 'text_settings',
                       'settings' => 'home_slab',
                       'priority' => 1
                   )
               )
           );


        	$wp_customize->get_setting( 'home_slab' )->transport = 'postMessage';


        	   $wp_customize->add_setting( 'home_slab_404', array(
        	   		'default' => "<span class='slabtext'>No Page Here</span> <span class='slabtext'>Oh Dear!</span>",
        	        ) );
        	   $wp_customize->add_control(
        	       new Custom_CSS_Control( $wp_customize, 'text_control3',
        	           array(
        	               'label' => '404 Headline Text',
        	               'section' => 'text_settings',
        	               'settings' => 'home_slab_404',
        	               'priority' => 2
        	           )
        	       )
        	   );

          	$wp_customize->get_setting( 'home_slab_404' )->transport = 'postMessage';

        	$wp_customize->add_setting( 'footer_tagline', array(
        	   		'default' => '&copy; 2014 Wharton. Built by <a href="http://www.meanthemes.com" target="_blank">MeanThemes</a>',
        	        ) );
        	   $wp_customize->add_control(
        	       new Custom_CSS_Control( $wp_customize, 'text_control',
        	           array(
        	               'label' => 'Footer Tagline',
        	               'section' => 'text_settings',
        	               'settings' => 'footer_tagline',
        	               'priority' => 3
        	           )
        	       )
        	   );

        		$wp_customize->get_setting( 'footer_tagline' )->transport = 'postMessage';




        $wp_customize->add_setting(
            'text_navigation',
            array(
                'default'   => __('Navigation','meanthemes'),
                'transport' => 'postMessage'
            )
        );

        $wp_customize->add_control(
            'text_navigation',
            array(
                'section'  => 'text_settings',
                'label'    => __('Navigation Menu Overlay Title','meanthemes'),
                'type'     => 'text',
                'priority' => 4
            )
        );


        $wp_customize->add_setting(
            'text_posts',
            array(
                'default'   => __('10 Most recent posts','meanthemes'),
                'transport' => 'postMessage'
            )
        );

        $wp_customize->add_control(
            'text_posts',
            array(
                'section'  => 'text_settings',
                'label'    => __('Recent Posts Menu Overlay Title','meanthemes'),
                'type'     => 'text',
                'priority' => 4
            )
        );

        $wp_customize->add_setting(
            'text_menu_icon',
            array(
                'default'   => __('Menu','meanthemes'),
                'transport' => 'postMessage'
            )
        );

        $wp_customize->add_control(
            'text_menu_icon',
            array(
                'section'  => 'text_settings',
                'label'    => __('"Menu" Text','meanthemes'),
                'type'     => 'text',
                'priority' => 4
            )
        );


        $wp_customize->add_setting(
            'text_logo_alt',
            array(
                'default'   => __('Logo Alt','meanthemes'),
                'transport' => 'postMessage'
            )
        );

        $wp_customize->add_control(
            'text_logo_alt',
            array(
                'section'  => 'text_settings',
                'label'    => __('Logo Alt Text','meanthemes'),
                'type'     => 'text',
                'priority' => 5
            )
        );


        $wp_customize->add_setting(
            'text_logo_title',
            array(
                'default'   => __('Logo Title','meanthemes'),
                'transport' => 'postMessage'
            )
        );

        $wp_customize->add_control(
            'text_logo_title',
            array(
                'section'  => 'text_settings',
                'label'    => __('Logo Title Text','meanthemes'),
                'type'     => 'text',
                'priority' => 6
            )
        );










        //
        // CUSTOM CSS
        //


        $wp_customize->add_section(
        	    'custom_css',
        	    array(
        	        'title' => __('Custom CSS Block','meanthtmes'),
        	        'priority' => 72,
        	    )
        	);


        $wp_customize->add_setting( 'custom_css' );
        $wp_customize->add_control(
            new Custom_CSS_Control( $wp_customize, 'custom_css',
                array(
                    'label' => __( 'Enter Your Custom CSS' , 'meanthemes' ),
                    'section' => 'custom_css',
                    'settings' => 'custom_css'
                )
            )
        );


        $wp_customize->add_section(
        	    'google_analytics_settings',
        	    array(
        	        'title' => __('Google Analytics JavaScript','meanthtmes'),
        	        'priority' => 73,
        	    )
        	);

          //
          // GOOGLE ANALYTICS
          //
          class Google_Analytics_Control extends WP_Customize_Control {
              public $type = 'google_analytics';

              public function render_content() {
                  ?>
                      <label>
                          <span class="customize-control-title"><?php echo esc_html( $this->label ); ?></span>
                          <textarea rows="7" style="width:100%;" <?php $this->link(); ?>><?php echo esc_textarea( $this->value() ); ?></textarea>
                      </label>
                  <?php
              }
          }
          $wp_customize->add_setting( 'google_analytics' );
          $wp_customize->add_control(
              new Google_Analytics_Control(
                  $wp_customize, 'google_analytics',
                  array(
                      'label' => 'Google Analytics Script',
                      'section' => 'google_analytics_settings',
                      'settings' => 'google_analytics',
                      'priority' => 10,
                  )
              )
          );









}
add_action( 'customize_register', 'meanthemes_register_theme_customizer' );


// Make options change live...
function meanthemes_customizer_live_preview() {

    wp_enqueue_script(
        'meanthemes-theme-customizer',
        get_template_directory_uri() . '/framework/js/theme-customizer.js',
        array( 'jquery', 'customize-preview' ),
				MEANTHEMES_THEME_VER,
        true
    );

}
add_action( 'customize_preview_init', 'meanthemes_customizer_live_preview' );



// Add CSS to theme...

function meanthemes_customizer_css() {
    ?>
    <style>
    <?php

    	$color_blog_title = get_theme_mod( 'color_blog_title' );


    	if ( $color_blog_title !== "#ffffff" && $color_blog_title !== false ) {


     ?>
    .blog-title, .blog-title a {
    	color: <?php echo $color_blog_title; ?>
    }
    <?php

    	}
    ?>
    <?php

    	$color_blog_title_hover = get_theme_mod( 'color_blog_title_hover' );

    	if ( $color_blog_title_hover !== "#fafafa" && $color_blog_title_hover !== false ) {


     ?>

    .blog-title a:hover {
    	color: <?php echo $color_blog_title_hover; ?>
    }
    <?php

    	}
    ?>
    <?php

    	$color_blog_tagline = get_theme_mod( 'color_blog_tagline' );

    	if ( $color_blog_tagline !== "#939494" && $color_blog_tagline !== false ) {


     ?>
      .blog-tagline {
    	color: <?php echo $color_blog_tagline; ?>
    }
    <?php

    	}
    ?>
	<?php

		$color_main = get_theme_mod( 'color_main' );

		if ( $color_main !== "#434343" && $color_main !== false ) {


	 ?>
    	body { color: <?php echo $color_main; ?>; }
    <?php

    	}
    ?>
    <?php

        $color_link_pagination = get_theme_mod( 'color_link_pagination' );

        if ( $color_link_pagination !== "#414141" && $color_link_pagination !== false ) {

     ?>
    		.pagination a { color: <?php echo $color_link_pagination; ?>; }
    <?php

    	} ?>

    <?php

        $color_link_pagination_hover = get_theme_mod( 'color_link_pagination_hover' );

        if ( $color_link_pagination_hover !== "#414141" && $color_link_pagination_hover !== false ) {

     ?>
    		.pagination a:hover { color: <?php echo $color_link_pagination_hover; ?>; }
    <?php

    	} ?>

    <?php

        $color_link_comment_title = get_theme_mod( 'color_link_comment_title' );

        if ( $color_link_comment_title !== "#ffffff" && $color_link_comment_title !== false ) {

     ?>
    		#respond-title a { color: <?php echo $color_link_comment_title; ?>; }
    <?php

    	} ?>

    <?php

        $color_link_format = get_theme_mod( 'color_link_format' );

        if ( $color_link_format !== "#ffffff" && $color_link_format !== false ) {

     ?>
    		.format-link h3.link a { color: <?php echo $color_link_format; ?>; }
    <?php

    	}

        $color_link_format_hover = get_theme_mod( 'color_link_format_hover' );

        if ( $color_link_format_hover !== "#404040" && $color_link_format_hover !== false ) {

     ?>
    		.format-link h3.link a:hover { color: <?php echo $color_link_format_hover; ?>; }
    <?php

    	 	}
    ?>
    <?php

	    $color_link = get_theme_mod( 'color_link' );

	    if ( $color_link !== "#06b25b" && $color_link !== false ) {

     ?>
   		a, a.more-link:hover, .widget a:hover, footer.footer a:hover { color: <?php echo $color_link; ?>; }
    <?php

   	 	}
    ?>
    <?php $color_link_hover = get_theme_mod( 'color_link_hover' );

    if ( $color_link_hover !== "#1d1c1c" && $color_link_hover !== false ) {

     ?>
    	a:hover { color: <?php echo $color_link_hover; ?>; }
    <?php } ?>
    <?php $color_meta = get_theme_mod( 'color_meta' );

    if ( $color_meta !== "#d2d2d2" && $color_meta !== false ) {

     ?>
        ul.meta,
        ul.meta a,
        .post-tags.tag,
        .post-tags.tag a { color: <?php echo $color_meta; ?>; }
    <?php } ?>
    <?php $color_meta_link_hover = get_theme_mod( 'color_meta_link_hover' );
    if ( $color_meta_link_hover !== "#404040" && $color_meta_link_hover !== false ) {

     ?>
        ul.meta a:hover,
        .post-tags.tag a:hover { color: <?php echo $color_meta_link_hover; ?>; }

    <?php } ?>
    <?php $color_archive_title_link = get_theme_mod( 'color_archive_title_link' );

    if ( $color_archive_title_link !== "#404040" && $color_archive_title_link !== false ) {

     ?>
    	.main-archive h2 a { color: <?php echo $color_archive_title_link; ?>; }
    <?php } ?>
    <?php $color_archive_title_link_hover = get_theme_mod( 'color_archive_title_link_hover' );

    if ( $color_archive_title_link_hover !== "#06b25b" && $color_archive_title_link_hover !== false ) {

     ?>
   		.main-archive h2 a:hover { color: <?php echo $color_archive_title_link_hover; ?>; }
    <?php } ?>
    <?php $color_headings = get_theme_mod( 'color_headings' );

    if ( $color_headings !== "#1d1c1c" && $color_headings !== false ) {

     ?>
        h1, h2, h3, h4, h5, h6 {
        	color: <?php echo $color_headings; ?>;
        }
    <?php } ?>
    <?php $color_nav_link = get_theme_mod( 'color_nav_link' );

    if ( $color_nav_link !== "#ffffff" && $color_nav_link !== false ) {

     ?>
        .site-navigation a, .site-navigation h4, .sitenav-main a {
        	color: <?php echo $color_nav_link; ?>;
        }
    <?php } ?>
    <?php $color_nav_link_hover = get_theme_mod( 'color_nav_link_hover' );

    if ( $color_nav_link_hover !== "#06b25b" && $color_nav_link_hover !== false ) {

     ?>
        .site-navigation ul li.sfHover a,
        .site-navigation ul li a:hover,
        .site-navigation li.current_page_item a,
        .site-navigation li.current-menu-item a,
        .site-navigation li.current_page_ancestor a,
        .site-navigation li.current_page_parent a,
        .site-navigation li.current-post-ancestor a,
        .site-navigation li.current-page-ancestor a,
        .site-navigation a:hover,
        .sitenav-main ul li.sfHover a,
        .sitenav-main ul li a:hover,
        .sitenav-main li.current_page_item a,
        .sitenav-main li.current-menu-item a,
        .sitenav-main li.current_page_ancestor a,
        .sitenav-main li.current_page_parent a,
        .sitenav-main li.current-post-ancestor a,
        .sitenav-main li.current-page-ancestor a,
        .sitenav-main a:hover {
        	color: <?php echo $color_nav_link_hover; ?>;
        }
    <?php } ?>
    <?php $color_menu_control = get_theme_mod( 'color_menu_control' );

    if ( $color_menu_control !== "#ffffff" && $color_menu_control !== false ) {

     ?>
        #menu-control {
        	color: <?php echo $color_menu_control; ?>;
        }
        #menu-control:after,
        #menu-control:before {
        	border-color: <?php echo $color_menu_control; ?>;
        }
    <?php } ?>
    <?php $color_amp = get_theme_mod( 'color_amp' );

    if ( $color_amp !== "#60686a" && $color_amp !== false ) {

     ?>
        h1 .amp {
        	color: <?php echo $color_amp; ?> !important;
        }
    <?php } ?>
    <?php $color_single_lead = get_theme_mod( 'color_single_lead' );

    if ( $color_single_lead !== "#ffffff" && $color_single_lead !== false ) {

     ?>
        .lead h1,
        .lead .meta.top,
        .lead .meta.top a {
        	color: <?php echo $color_single_lead; ?>;
        }
    <?php } ?>
	<?php $color_single_lead_hover = get_theme_mod( 'color_single_lead_hover' );

	if ( $color_single_lead_hover !== "#cccccc" && $color_single_lead_hover !== false ) {

	 ?>
	    .lead .meta.top a:hover {
	    	color: <?php echo $color_single_lead_hover; ?>;
	    }
	<?php } ?>

	<?php $color_footer_widget_link = get_theme_mod( 'color_footer_widget_link' );

	if ( $color_footer_widget_link !== "#414141" && $color_footer_widget_link !== false ) {

	 ?>
	    .footer-widgets .widget a {
	    	color: <?php echo $color_footer_widget_link; ?>;
	    }
	<?php } ?>
	<?php $color_footer_widget_link_hover = get_theme_mod( 'color_footer_widget_link_hover' );

	if ( $color_footer_widget_link_hover !== "#06b25b" && $color_footer_widget_link_hover !== false ) {

	 ?>
	    .footer-widgets .widget a:hover {
	    	color: <?php echo $color_footer_widget_link_hover; ?>;
	    }
	<?php } ?>
	<?php $color_footer = get_theme_mod( 'color_footer' );

	if ( $color_footer !== "#414141" && $color_footer !== false ) {

	?>
			footer.footer, footer.footer a {
				color: <?php echo $color_footer; ?>;
			}
	<?php } ?>
	<?php $color_footer_link_hover = get_theme_mod( 'color_footer_link_hover' );

	if ( $color_footer_link_hover !== "#06b25b" && $color_footer_link_hover !== false ) {

	?>
			footer.footer a:hover {
				color: <?php echo $color_footer_link_hover; ?>;
			}
	<?php } ?>


	<?php if( get_theme_mod( 'font_uppercase', '1' ) == '1' ) {
	?>
	.blog-title, article h1, h2, h3,h4, h5, h6,.blog-tagline,.more-link,.meta,.pagination,.comment-reply-link,button,input[type=submit],#menu-control,.site-navigation .sitenav-posts,footer.footer {
		text-transform: uppercase;
	}
	<?php } ?>
    <?php $font_main = get_theme_mod( 'font_main' );

    if ( $font_main !== "Noto Serif" && $font_main !== false ) {

     ?>
        body, input[type=text], input[type=email], input[type=tel],
        input[type=url], input[type=password], textarea,
        input[type=submit] {
        	font-family: <?php echo $font_main; ?>;
        	<?php if ( $font_main == "LeagueGothicRegular" ) { ?>
        	font-weight: 400;
        	<?php } ?>
        }

    <?php } ?>
    <?php $font_headings = get_theme_mod( 'font_headings' );

    if ( $font_headings !== "Lato" && $font_headings !== false ) {

     ?>
        .blog-title,.blog-tagline,h1, h2, h3,h4, h5, h6,.more-link,.meta,.pagination,.comment-reply-link,button,input[type=submit],#menu-control,.site-navigation,footer.footer, .sitenav-main, body.mean-container .mean-nav {
        	font-family: <?php echo $font_headings; ?>;
        	<?php if ( $font_headings == "LeagueGothicRegular" ) { ?>
        	font-weight: 400;
        	<?php } ?>
        }
    <?php } ?>
    <?php $font_advanced_service_main = get_theme_mod( 'font_advanced_service_main' );

    if ( $font_advanced_service_main && $font_advanced_service_main !== false ) {

     ?>
        body, input[type=text], input[type=email], input[type=tel],
        input[type=url], input[type=password], textarea,
        input[type=submit] {
        	font-family: <?php echo $font_advanced_service_main; ?>;
        	font-weight: <?php echo get_theme_mod( 'font_advanced_service_main_weight' ); ?>;
        	<?php
        	$font_advanced_service_main_oblique = get_theme_mod( 'font_advanced_service_main_oblique' );

        	if ( $font_advanced_service_main_oblique ) {

        	?>
        	font-style: oblique;
        	<?php } ?>
        }
    <?php } ?>
    <?php $font_advanced_service_headings = get_theme_mod( 'font_advanced_service_headings' );

    if ( $font_advanced_service_headings && $font_advanced_service_headings !== false ) {

     ?>
        .blog-title,.blog-tagline,article h1, h2, h3,h4, h5, h6,.more-link,.meta,.pagination,.comment-reply-link,button,input[type=submit],#menu-control,.site-navigation,footer.footer {
        	font-family: <?php echo $font_advanced_service_headings; ?>;
        	font-weight: <?php echo get_theme_mod( 'font_advanced_service_heading_weight' ); ?>;
        	<?php
        	$font_advanced_service_heading_oblique = get_theme_mod( 'font_advanced_service_heading_oblique' );

        	if ( $font_advanced_service_heading_oblique ) {

        	?>
        	font-style: oblique;
        	<?php } else { ?>
        	font-style: normal;
        	<?php } ?>
        }
    <?php } ?>
    <?php

        $bg_color_flex_caption = get_theme_mod( 'bg_color_flex_caption' );

        if ( $bg_color_flex_caption !== "#fdfdfd" && $bg_color_flex_caption !== false ) {

     ?>
    		.flex-caption { background-color: <?php echo $bg_color_flex_caption; ?>; }
    <?php

    	} ?>
    <?php

        $bg_color_archive_post_image = get_theme_mod( 'bg_color_archive_post_image' );

        if ( $bg_color_archive_post_image !== "#000" && $bg_color_archive_post_image !== false ) {

     ?>
    		.post-image { background-color: <?php echo $bg_color_archive_post_image; ?>; }
    <?php

    	} ?>
    <?php $bg_color_sitenav = get_theme_mod( 'bg_color_sitenav' );

    if ( $bg_color_sitenav !== "#1e1f1f" && $bg_color_sitenav !== false ) {

     ?>
        .site-navigation,
        body.mean-container .mean-bar,
        body.mean-container .mean-nav {
        	background-color: <?php echo $bg_color_sitenav; ?>;
        }
    <?php } ?>
 <?php $bg_color_comment_title = get_theme_mod( 'bg_color_comment_title' );

 if ( $bg_color_comment_title !== "#414141" && $bg_color_comment_title !== false ) {

  ?>
      #respond-title a  {
     	background-color: <?php echo $bg_color_comment_title; ?>;
     }
 <?php } ?>
 <?php $bg_color_flexslider = get_theme_mod( 'bg_color_flexslider' );

 if ( $bg_color_flexslider !== "#06b25b" && $bg_color_flexslider !== false ) {

  ?>
      a.flex-next, a.flex-prev  {
     	background-color: <?php echo $bg_color_flexslider; ?>;
     }
 <?php } ?>
    <?php $bg_color_format_link = get_theme_mod( 'bg_color_format_link' );

    if ( $bg_color_format_link !== "#06b25b" && $bg_color_format_link !== false ) {

     ?>
         .format-link h3.link a  {
        	background-color: <?php echo $bg_color_format_link; ?>;
        }
    <?php } ?>
    <?php $bg_color_slab = get_theme_mod( 'bg_color_slab' );

    if ( $bg_color_slab !== "#ffffff" && $bg_color_slab !== false ) {

     ?>
        .slab {
        	background-color: <?php echo $bg_color_slab; ?>;
        }
    <?php } ?>
    <?php $bg_color_header = get_theme_mod( 'bg_color_header' );

    if ( $bg_color_header !== "#282a2a" && $bg_color_header !== false ) {

     ?>
        header.header {
        	background-color: <?php echo $bg_color_header; ?>;
        }
    <?php } ?>
    <?php $bg_color_sitehead = get_theme_mod( 'bg_color_sitehead' );

    if ( $bg_color_sitehead !== "#000" && $bg_color_sitehead !== false ) {

     ?>
        .lead {
        	background-color: <?php echo $bg_color_sitehead; ?>;
        }
    <?php } ?>
    <?php $bg_color_widgets = get_theme_mod( 'bg_color_widgets' );

    if ( $bg_color_widgets !== "#ffffff" && $bg_color_widgets !== false ) {

     ?>
        .footer-widgets {
        	background-color: <?php echo $bg_color_widgets; ?>;
        }
    <?php } ?>
    <?php $bg_color_body = get_theme_mod( 'bg_color_body' );

    if ( $bg_color_body !== "#f4f4f4" && $bg_color_body !== false ) {

     ?>
        body {
        	background-color: <?php echo $bg_color_body; ?>;
        }
    <?php } ?>
    <?php $body_background_tile_image = get_theme_mod( 'body_background_tile_image' );

    if ( $body_background_tile_image !== "" && $body_background_tile_image !== false ) {

     ?>
        body {
        	background-image: url(<?php echo $body_background_tile_image; ?>);
        }

    <?php } ?>
    <?php $bg_color_post = get_theme_mod( 'bg_color_post' );

    if ( $bg_color_post !== "#ffffff" && $bg_color_post !== false ) {

     ?>
	    .inner, .post .inner {
	    	background-color: <?php echo $bg_color_post; ?>;
	    }

    <?php } ?>
		<?php $bg_color_footer = get_theme_mod( 'bg_color_footer' );

		if ( $bg_color_footer !== "#f6f4f4" && $bg_color_footer !== false ) {

		?>
			footer.footer {
				background-color: <?php echo $bg_color_footer; ?>;
			}

		<?php } ?>

    <?php $button_color = get_theme_mod( 'button_color' );

    if ( $button_color !== "#06b25b" && $button_color !== false ) {

     ?>
    button,
    input[type=submit],
     .form-submit input {
    	background: <?php echo $button_color; ?>;
    }
    <?php } ?>
    <?php $button_color_hover = get_theme_mod( 'button_color_hover' );

    if ( $button_color_hover !== "#474747" && $button_color_hover !== false ) {

     ?>

    button:hover,
    input[type=submit]:hover,
     .form-submit input:hover {
    	background: <?php echo $button_color_hover; ?>;
    }
    <?php } ?>
    <?php $border_color = get_theme_mod( 'border_color' );

    if ( $border_color !== "#e1e2e2" && $border_color !== false ) {

     ?>
        .pagination, .older-posts {
        	border-color: <?php echo $border_color; ?>;
        }

    <?php } ?>
    <?php $border_color_blockquote = get_theme_mod( 'border_color_blockquote' );

    if ( $border_color_blockquote !== "#6fce6f" && $border_color_blockquote !== false ) {

     ?>
        blockquote {
        	border-color: <?php echo $border_color_blockquote; ?>;
        }

    <?php } ?>
    <?php

    $image_center = get_theme_mod( 'image_center' );

    if ($image_center) { ?>
    .post-image {
    	width: 100%;
    }
    .post-image img {
    	margin-left: auto;
    	margin-right: auto;
    }
    <?php } ?>
    <?php if( get_theme_mod( 'use_standard_menu', '0' ) == '1' ) {

    	// Get screenwidth in EMs
    	$screenWidth = get_theme_mod( 'use_standard_menu_screenwidth', '767' );

    	$emWidth = ($screenWidth/16) . 'em';

     ?>

	    @media only screen and (max-width: <?php echo $emWidth; ?>) { /* <?php echo $screenWidth . 'px'; ?> */
	    	.d-menu header.header {
	    		text-align: center;
	    	}
	    	.d-menu header.header .logo, .d-menu header.header .blog-tagline {
	    		float: none;
	    		text-align: center;
	    	}
		}
    <?php } ?>
    <?php
    // Custom CSS
    echo get_theme_mod( 'custom_css', '' );
    ?>

    </style>
    <?php
}
add_action( 'wp_head', 'meanthemes_customizer_css' );

?>
