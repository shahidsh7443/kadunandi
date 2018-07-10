<?php
    function rentax_customize_blog_tab($wp_customize, $theme_name){

        $wp_customize->add_section( 'rentax_blog_settings' , array(
            'title'      => esc_html__( 'Blog', 'rentax' ),
            'priority'   => 12,
        ) );

        $wp_customize->add_setting( 'rentax_blog_settings_date' , array(
			'default'     => '1',
			'transport'   => 'refresh',
            'theme_supports' => 'rentax_customize_opt',
		    'sanitize_callback' => 'esc_attr',
		) );
        
		$wp_customize->add_setting( 'rentax_blog_settings_author_name' , array(
			'default'     => '1',
			'transport'   => 'refresh',
            'theme_supports' => 'rentax_customize_opt',
		    'sanitize_callback' => 'esc_attr',
		) );

		$wp_customize->add_setting( 'rentax_blog_settings_author' , array(
			'default'     => '1',
			'transport'   => 'refresh',
            'theme_supports' => 'rentax_customize_opt',
		    'sanitize_callback' => 'esc_attr',
		) );

		$wp_customize->add_setting( 'rentax_blog_settings_comments' , array(
			'default'     => '1',
			'transport'   => 'refresh',
            'theme_supports' => 'rentax_customize_opt',
		    'sanitize_callback' => 'esc_attr',
		) );

        $wp_customize->add_setting( 'rentax_blog_settings_categories' , array(
			'default'     => '1',
			'transport'   => 'refresh',
            'theme_supports' => 'rentax_customize_opt',
		    'sanitize_callback' => 'esc_attr',
		) );

		$wp_customize->add_setting( 'rentax_blog_settings_tags' , array(
			'default'     => '1',
			'transport'   => 'refresh',
            'theme_supports' => 'rentax_customize_opt',
		    'sanitize_callback' => 'esc_attr',
		) );
		
        $wp_customize->add_setting( 'rentax_blog_settings_share' , array(
            'default'     => '1',
            'transport'   => 'refresh',
            'theme_supports' => 'rentax_customize_opt',
            'sanitize_callback' => 'esc_attr',
        ) );
        
        $wp_customize->add_setting( 'rentax_blog_settings_readmore' , array(
            'default'     => esc_html__( 'Read more', 'rentax' ),
            'transport'   => 'refresh',
            'theme_supports' => 'rentax_customize_opt',
		    'sanitize_callback' => 'esc_html',
        ) );


        $wp_customize->add_control(
            'rentax_blog_settings_date',
            array(
                'label'    => esc_html__( 'Display Date on blog posts', 'rentax' ),
                'section'  => 'rentax_blog_settings',
                'settings' => 'rentax_blog_settings_date',
                'type'     => 'select',
                'choices'  => array(
                    '0'  => esc_html__( 'Off', 'rentax' ),
                    '1' => esc_html__( 'On', 'rentax' ),
                ),
                'priority'   => 50
            )
        );
        
        $wp_customize->add_control(
            'rentax_blog_settings_author_name',
            array(
                'label'    => esc_html__( 'Display Author name on blog page and single post', 'rentax' ),
                'section'  => 'rentax_blog_settings',
                'settings' => 'rentax_blog_settings_author_name',
                'type'     => 'select',
                'choices'  => array(
                    '0'  => esc_html__( 'Off', 'rentax' ),
                    '1' => esc_html__( 'On', 'rentax' ),
                ),
                'priority'   => 60
            )
        );
        
        $wp_customize->add_control(
            'rentax_blog_settings_author',
            array(
                'label'    => esc_html__( 'Display About Author block on single post', 'rentax' ),
                'section'  => 'rentax_blog_settings',
                'settings' => 'rentax_blog_settings_author',
                'type'     => 'select',
                'choices'  => array(
                    '0'  => esc_html__( 'Off', 'rentax' ),
                    '1' => esc_html__( 'On', 'rentax' ),
                ),
                'priority'   => 70
            )
        );
        
        $wp_customize->add_control(
            'rentax_blog_settings_comments',
            array(
                'label'    => esc_html__( 'Display Comments on single post', 'rentax' ),
                'section'  => 'rentax_blog_settings',
                'settings' => 'rentax_blog_settings_comments',
                'type'     => 'select',
                'choices'  => array(
                    '0'  => esc_html__( 'Off', 'rentax' ),
                    '1' => esc_html__( 'On', 'rentax' ),
                ),
                'priority'   => 80
            )
        );
        
        $wp_customize->add_control(
            'rentax_blog_settings_categories',
            array(
                'label'    => esc_html__( 'Display Categories', 'rentax' ),
                'section'  => 'rentax_blog_settings',
                'settings' => 'rentax_blog_settings_categories',
                'type'     => 'select',
                'choices'  => array(
                    '0'  => esc_html__( 'Off', 'rentax' ),
                    '1' => esc_html__( 'On', 'rentax' ),
                ),
                'priority'   => 90
            )
        );
        
        $wp_customize->add_control(
            'rentax_blog_settings_tags',
            array(
                'label'    => esc_html__( 'Display Tags', 'rentax' ),
                'section'  => 'rentax_blog_settings',
                'settings' => 'rentax_blog_settings_tags',
                'type'     => 'select',
                'choices'  => array(
                    'off'  => esc_html__( 'Off', 'rentax' ),
                    'on' => esc_html__( 'On', 'rentax' ),
                ),
                'priority'   => 100
            )
        );
        
        $wp_customize->add_control(
            'rentax_blog_settings_share',
            array(
                'label'    => esc_html__( 'Display share buttons on single post', 'rentax' ),
                'section'  => 'rentax_blog_settings',
                'settings' => 'rentax_blog_settings_share',
                'type'     => 'select',
                'choices'  => array(
                    'off'  => esc_html__( 'Off', 'rentax' ),
                    'on' => esc_html__( 'On', 'rentax' ),
                ),
                'priority'   => 110
            )
        );
        


        $wp_customize->add_control(
            'rentax_blog_settings_readmore',
            array(
                'label'    => esc_html__( 'Read More button text', 'rentax' ),
                'section'  => 'rentax_blog_settings',
                'settings' => 'rentax_blog_settings_readmore',
                'type'     => 'textfield',
                'priority'   => 10
            )
        );


    }
?>