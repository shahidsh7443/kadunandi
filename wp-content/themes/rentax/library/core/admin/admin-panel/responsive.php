<?php

	function rentax_customize_responsive_tab($wp_customize, $theme_name){
	
		$wp_customize->add_section( 'rentax_responsive_settings' , array(
		    'title'      => esc_html__( 'Responsive', 'rentax' ),
		    'priority'   => 7,
		) );

		$wp_customize->add_setting( 'rentax_general_settings_responsive' , array(
		    'default'     => '',
		    'transport'   => 'refresh',
			'sanitize_callback' => 'sanitize_text_field'
		) );

		$wp_customize->add_setting( 'rentax_mobile_sticky' , array(
				'default'     => '',
				'transport'   => 'refresh',
				'sanitize_callback' => 'sanitize_text_field'
		) );

		$wp_customize->add_setting( 'rentax_mobile_topbar' , array(
				'default'     => '',
				'transport'   => 'refresh',
				'sanitize_callback' => 'sanitize_text_field'
		) );

		$wp_customize->add_setting( 'rentax_tablet_minicart' , array(
				'default'     => '',
				'transport'   => 'refresh',
				'sanitize_callback' => 'sanitize_text_field'
		) );

		$wp_customize->add_setting( 'rentax_tablet_search' , array(
				'default'     => '',
				'transport'   => 'refresh',
				'sanitize_callback' => 'sanitize_text_field'
		) );

		$wp_customize->add_setting( 'rentax_tablet_phone' , array(
				'default'     => '',
				'transport'   => 'refresh',
				'sanitize_callback' => 'sanitize_text_field'
		) );

		$wp_customize->add_setting( 'rentax_tablet_socials' , array(
				'default'     => '',
				'transport'   => 'refresh',
				'sanitize_callback' => 'sanitize_text_field'
		) );



		$wp_customize->add_control(
			'rentax_general_settings_responsive',
			array(
				'label'    => esc_html__( 'Responsive', 'rentax' ),
				'section'  => 'rentax_responsive_settings',
				'settings' => 'rentax_general_settings_responsive',
				'type'     => 'select',
				'choices'  => array(
					'off'  => esc_html__( 'Off', 'rentax' ),
					'on'   => esc_html__( 'On', 'rentax' ),
				),
				'priority'   => 5
			)
		);

		$wp_customize->add_control(
            'rentax_mobile_sticky',
            array(
                'label'    => esc_html__( 'Header Mobile Behavior', 'rentax' ),
                'description'   => esc_html__( 'Off header sticky or fixed on mobile', 'rentax' ),
                'section'  => 'rentax_responsive_settings',
                'settings' => 'rentax_mobile_sticky',
                'type'     => 'select',
                'choices'  => array(
                    ''  => esc_html__( 'Global', 'rentax' ),
                    'mobile-no-sticky' => esc_html__( 'No Sticky', 'rentax' ),
		            'mobile-no-fixed' => esc_html__( 'No Fixed', 'rentax' ),
                ),
                'priority'   => 10
            )
        );

        $wp_customize->add_control(
            'rentax_mobile_topbar',
            array(
                'label'    => esc_html__( 'Header Mobile Behavior', 'rentax' ),
                'description'   => esc_html__( 'Off header top bar on mobile', 'rentax' ),
                'section'  => 'rentax_responsive_settings',
                'settings' => 'rentax_mobile_sticky',
                'type'     => 'select',
                'choices'  => array(
                    ''  => esc_html__( 'Global', 'rentax' ),
                    'no-mobile-topbar' => esc_html__( 'Off', 'rentax' ),
                ),
                'priority'   => 20
            )
        );

        $wp_customize->add_control(
            'rentax_tablet_minicart',
            array(
                'label'    => esc_html__( 'Tablet Minicart', 'rentax' ),
                'description'   => esc_html__( 'Off header cart on tablet', 'rentax' ),
                'section'  => 'rentax_responsive_settings',
                'settings' => 'rentax_tablet_minicart',
                'type'     => 'select',
                'choices'  => array(
                    ''  => esc_html__( 'Global', 'rentax' ),
                    'no-tablet-minicart' => esc_html__( 'Off', 'rentax' ),
                ),
                'priority'   => 30
            )
        );

        $wp_customize->add_control(
            'rentax_tablet_search',
            array(
                'label'    => esc_html__( 'Tablet Search', 'rentax' ),
                'description'   => esc_html__( 'Off header search on tablet', 'rentax' ),
                'section'  => 'rentax_responsive_settings',
                'settings' => 'rentax_tablet_search',
                'type'     => 'select',
                'choices'  => array(
                    ''  => esc_html__( 'Global', 'rentax' ),
                    'no-tablet-search' => esc_html__( 'Off', 'rentax' ),
                ),
                'priority'   => 40
            )
        );

        $wp_customize->add_control(
            'rentax_tablet_phone',
            array(
                'label'    => esc_html__( 'Tablet Header Phone', 'rentax' ),
                'description'   => esc_html__( 'Off header phone on tablet', 'rentax' ),
                'section'  => 'rentax_responsive_settings',
                'settings' => 'rentax_tablet_phone',
                'type'     => 'select',
                'choices'  => array(
                    ''  => esc_html__( 'Global', 'rentax' ),
                    'no-tablet-phone' => esc_html__( 'Off', 'rentax' ),
                ),
                'priority'   => 50
            )
        );

        $wp_customize->add_control(
            'rentax_tablet_socials',
            array(
                'label'    => esc_html__( 'Tablet Socials', 'rentax' ),
                'description'   => esc_html__( 'Off header social icons on tablet', 'rentax' ),
                'section'  => 'rentax_responsive_settings',
                'settings' => 'rentax_tablet_socials',
                'type'     => 'select',
                'choices'  => array(
                    ''  => esc_html__( 'Global', 'rentax' ),
                    'no-tablet-socials' => esc_html__( 'Off', 'rentax' ),
                ),
                'priority'   => 60
            )
        );
		
	}
		
?>