<?php

	function rentax_header_type_callback( $control ) {
	    if ( $control->manager->get_setting('rentax_header_type')->value() == 'header3' ) {
	        return true;
	    } else {
	        return false;
	    }
	}

	function rentax_header_type12_callback( $control ) {
	    if ( $control->manager->get_setting('rentax_header_type')->value() != 'header3' ) {
	        return true;
	    } else {
	        return false;
	    }
	}

	function rentax_header_background_callback( $control ) {
	    if (  in_array($control->manager->get_setting('rentax_header_background')->value(), array('trans-white', 'trans-black')) ) {
	        return true;
	    } else {
	        return false;
	    }
	}

	function rentax_header_menu_callback( $control ) {
	    if (  $control->manager->get_setting('rentax_header_menu')->value() != 0 ) {
	        return true;
	    } else {
	        return false;
	    }
	}

	function rentax_customize_header_tab($wp_customize, $theme_name){

		$wp_customize->add_panel('rentax_header_panel',  array(
            'title' => 'Header',
            'priority' => 5,
            )
        );

		$wp_customize->add_section( 'rentax_header_settings' , array(
		    'title'      => esc_html__( 'General Settings', 'rentax' ),
		    'priority'   => 5,
			'panel' => 'rentax_header_panel'
		) );

		$wp_customize->add_setting( 'rentax_header_type' , array(
				'default'     => 'header1',
				'transport'   => 'refresh',
				'sanitize_callback' => 'esc_attr'
		) );
		$wp_customize->add_control(
            'rentax_header_type',
            array(
                'label'    => esc_html__( 'Type', 'rentax' ),
                'section'  => 'rentax_header_settings',
                'settings' => 'rentax_header_type',
                'type'     => 'select',
                'choices'  => array(
                    'header1'  => esc_html__( 'Classic', 'rentax' ),
                    'header2' => esc_html__( 'Shop', 'rentax' ),
		            'header3' => esc_html__( 'Sidebar', 'rentax' ),
                ),
                'priority'   => 10
            )
        );


		$wp_customize->add_setting( 'rentax_header_sidebar_view' , array(
				'default'     => 'fixed',
				'transport'   => 'refresh',
				'sanitize_callback' => 'esc_attr'
		) );
		$wp_customize->add_control(
            'rentax_header_sidebar_view',
            array(
                'label'    => esc_html__( 'Sidebar View', 'rentax' ),
                'section'  => 'rentax_header_settings',
                'settings' => 'rentax_header_sidebar_view',
                'type'     => 'select',
                'choices'  => array(
                    'fixed'  => esc_html__( 'Fixed', 'rentax' ),
                    'horizontal' => esc_html__( 'Horizontal Button', 'rentax' ),
		            'vertical' => esc_html__( 'Vertical Button', 'rentax' ),
                ),
                'active_callback' => 'rentax_header_type_callback',
                'priority'   => 20
            )
        );


		$wp_customize->add_setting( 'rentax_header_sticky' , array(
				'default'     => '0',
				'transport'   => 'refresh',
				'sanitize_callback' => 'esc_attr'
		) );
		$wp_customize->add_control(
            'rentax_header_sticky',
            array(
                'label'         => esc_html__( 'Behavior', 'rentax' ),
                'section'       => 'rentax_header_settings',
                'settings'      => 'rentax_header_sticky',
                'type'          => 'select',
                'choices'       => array(
                    '0' => esc_html__( 'Default', 'rentax' ),
                    'sticky'  => esc_html__( 'Sticky', 'rentax' ),
		            'fixed'  => esc_html__( 'Fixed', 'rentax' ),
                ),
                'priority'   => 30
            )
        );


		$wp_customize->add_setting( 'rentax_header_menu' , array(
				'default'     => '1',
				'transport'   => 'refresh',
				'sanitize_callback' => 'esc_attr'
		) );
		$wp_customize->add_control(
            'rentax_header_menu',
            array(
                'label'    => esc_html__( 'Menu', 'rentax' ),
                'section'  => 'rentax_header_settings',
                'settings' => 'rentax_header_menu',
                'type'     => 'select',
                'choices'  => array(
                    '1'  => esc_html__( 'On', 'rentax' ),
                    '0' => esc_html__( 'Off', 'rentax' ),
                ),
                'priority'   => 40
            )
        );


		$wp_customize->add_setting( 'rentax_header_menu_add' , array(
				'default'     => '',
				'transport'   => 'refresh',
				'sanitize_callback' => 'esc_attr'
		) );
		$args = array(
			'taxonomy' => 'nav_menu',
			'hide_empty' => true,
		);
		$menus = get_terms( $args );
		$menus_arr = array();
		$menus_arr[''] = esc_html__( 'Select Menu', 'rentax' );
		foreach ($menus as $key => $value) {
			if(is_object($value)) {
				$menus_arr[$value->term_id] = $value->name;
			}
		}
        $wp_customize->add_control(
            'rentax_header_menu_add',
            array(
                'label'         => esc_html__( 'Additional Menu', 'rentax' ),
                'section'       => 'rentax_header_settings',
                'settings'      => 'rentax_header_menu_add',
                'type'          => 'select',
                'choices'       => $menus_arr,
                'active_callback' => 'rentax_header_type12_callback',
                'priority'   => 50
            )
        );


		$wp_customize->add_setting( 'rentax_header_menu_add_position' , array(
				'default'     => '',
				'transport'   => 'refresh',
				'sanitize_callback' => 'esc_attr'
		) );
		$wp_customize->add_control(
            'rentax_header_menu_add_position',
            array(
                'label'    => esc_html__( 'Additional Menu Position', 'rentax' ),
                'section'  => 'rentax_header_settings',
                'settings' => 'rentax_header_menu_add_position',
                'type'     => 'select',
                'choices'  => array(
                    'left'  => esc_html__( 'Left Sidebar', 'rentax' ),
                    'right' => esc_html__( 'Right Sidebar', 'rentax' ),
		            'top' => esc_html__( 'Top Sidebar', 'rentax' ),
		            'bottom'  => esc_html__( 'Bottom Sidebar', 'rentax' ),
                    'screen' => esc_html__( 'Full Screen', 'rentax' ),
		            'disable' => esc_html__( 'Disabled', 'rentax' ),
                ),
                'active_callback' => 'rentax_header_type12_callback',
                'priority'   => 60
            )
        );


        $wp_customize->add_setting( 'rentax_header_advanced_page' , array(
				'default'     => '0',
				'transport'   => 'postMessage',
				'sanitize_callback' => 'esc_attr'
		) );
		$wp_customize->add_control(
            'rentax_header_advanced_page',
            array(
                'label'    => esc_html__( 'Advanced Options on Page', 'rentax' ),
                'description'   => '',
                'section'  => 'rentax_header_settings',
                'settings' => 'rentax_header_advanced_page',
                'type'     => 'select',
                'choices'  => array(
                    '0' => esc_html__( 'Off', 'rentax' ),
                    '1'  => esc_html__( 'On', 'rentax' ),
                ),
                'priority'   => 70
            )
        );



		/// HEADER STYLE ///

		$wp_customize->add_section( 'rentax_header_settings_style' , array(
		    'title'      => esc_html__( 'Style', 'rentax' ),
		    'priority'   => 10,
			'panel' => 'rentax_header_panel'
		) );


		$wp_customize->add_setting( 'rentax_header_layout' , array(
				'default'     => 'normal',
				'transport'   => 'refresh',
				'sanitize_callback' => 'esc_attr'
		) );
		$wp_customize->add_control(
            'rentax_header_layout',
            array(
                'label'    => esc_html__( 'Layout', 'rentax' ),
                'section'  => 'rentax_header_settings_style',
                'settings' => 'rentax_header_layout',
                'type'     => 'select',
                'choices'  => array(
                    'normal'  => esc_html__( 'Normal', 'rentax' ),
                    'boxed' => esc_html__( 'Boxed', 'rentax' ),
		            'full' => esc_html__( 'Full Width', 'rentax' ),
                ),
                'priority'   => 10
            )
        );


		$wp_customize->add_setting( 'rentax_header_background' , array(
				'default'     => 'trans-black',
				'transport'   => 'refresh',
				'sanitize_callback' => 'esc_attr'
		) );
		$wp_customize->add_control(
            'rentax_header_background',
            array(
                'label'    => esc_html__( 'Background', 'rentax' ),
                'description'   => esc_html__( 'Background header color', 'rentax' ),
                'section'  => 'rentax_header_settings_style',
                'settings' => 'rentax_header_background',
                'type'     => 'select',
                'choices'  => array(
                    ''  => esc_html__( 'Default', 'rentax' ),
                    'white' => esc_html__( 'White', 'rentax' ),
		            'black' => esc_html__( 'Black', 'rentax' ),
	                'trans-white' => esc_html__( 'Transparent White', 'rentax' ),
		            'trans-black' => esc_html__( 'Transparent Black', 'rentax' ),
                ),
                'priority'   => 20
            )
        );


		$wp_customize->add_setting( 'rentax_header_transparent' , array(
				'default'     => '0',
				'transport'   => 'refresh',
				'sanitize_callback' => 'esc_attr'
		) );
		$wp_customize->add_control(
            'rentax_header_transparent',
            array(
                'label'    => esc_html__( 'Transparent', 'rentax' ),
                'section'  => 'rentax_header_settings_style',
                'settings' => 'rentax_header_transparent',
                'type'     => 'select',
                'choices'  => array(
                    '0' => "0.0",
					'1' => "0.1",
					'2' => "0.2",
					'3' => "0.3",
					'4' => "0.4",
					'5' => "0.5",
					'6' => "0.6",
					'7' => "0.7",
					'8' => "0.8",
					'9' => "0.9",
                ),
                'priority'   => 30
            )
        );


        $wp_customize->add_setting( 'rentax_header_menu_animation' , array(
				'default'     => 'overlay',
				'transport'   => 'refresh',
				'sanitize_callback' => 'esc_attr'
		) );
		$wp_customize->add_control(
            'rentax_header_menu_animation',
            array(
                'label'         => esc_html__( 'Sidebar Menu Animation', 'rentax' ),
                'description'   => esc_html__( 'Overlay or reveal Sidebar menu animation', 'rentax' ),
                'section'       => 'rentax_header_settings_style',
                'settings'      => 'rentax_header_menu_animation',
                'type'          => 'select',
                'choices'       => array(
                    'overlay' => esc_html__( 'Overlay', 'rentax' ),
                    'reveal'  => esc_html__( 'Reveal', 'rentax' ),
                ),
                'priority'   => 40
            )
        );


		$wp_customize->add_setting( 'rentax_header_hover_effect' , array(
				'default'     => '0',
				'transport'   => 'refresh',
				'sanitize_callback' => 'esc_attr'
		) );
		$wp_customize->add_control(
            'rentax_header_hover_effect',
            array(
                'label'    => esc_html__( 'Menu Hover Effect', 'rentax' ),
                'section'  => 'rentax_header_settings_style',
                'settings' => 'rentax_header_hover_effect',
                'type'     => 'select',
                'choices'  => array(
                    '0' => esc_html__( 'Without effect', 'rentax' ),
					'1' => "a",
					'3' => "b",
					'4' => "c",
					'6' => "d",
					'7' => "e",
					'8' => "f",
					'9' => "g",
					'11' => "h",
					'12' => "i",
		            '13' => "j",
					'14' => "k",
		            '17' => "l",
					'18' => "m",
                ),
                'active_callback' => 'rentax_header_menu_callback',
                'priority'   => 50
            )
        );


		$wp_customize->add_setting( 'rentax_header_marker' , array(
				'default'     => 'menu-marker-arrow',
				'transport'   => 'refresh',
				'sanitize_callback' => 'esc_attr'
		) );
		$wp_customize->add_control(
			'rentax_header_marker',
			array(
				'label'    => esc_html__( 'Menu Markers', 'rentax' ),
				'section'  => 'rentax_header_settings_style',
				'settings' => 'rentax_header_marker',
				'type'     => 'select',
				'choices'  => array(
						'menu-marker-arrow'  => esc_html__( 'Arrows', 'rentax' ),
						'menu-marker-dot' => esc_html__( 'Dots', 'rentax' ),
						'no-marker' => esc_html__( 'Without markers', 'rentax' ),
				),
				'active_callback' => 'rentax_header_menu_callback',
				'priority'   => 60
			)
		);




        /// HEADER ELEMENTS ///

		$wp_customize->add_section( 'rentax_header_settings_elements' , array(
		    'title'      => esc_html__( 'Elements', 'rentax' ),
		    'priority'   => 15,
			'panel' => 'rentax_header_panel'
		) );


		$wp_customize->add_setting( 'rentax_header_bar' , array(
				'default'     => '0',
				'transport'   => 'refresh',
				'sanitize_callback' => 'esc_attr'
		) );
		$wp_customize->add_control(
			'rentax_header_bar',
			array(
				'label'    => esc_html__( 'Top Bar', 'rentax' ),
				'section'  => 'rentax_header_settings_elements',
				'settings' => 'rentax_header_bar',
				'type'     => 'select',
				'choices'  => array(
						'1'  => esc_html__( 'On', 'rentax' ),
						'0' => esc_html__( 'Off', 'rentax' ),
				),
				'priority'   => 10
			)
		);


		$wp_customize->add_setting( 'rentax_header_minicart' , array(
				'default'     => '1',
				'transport'   => 'refresh',
				'sanitize_callback' => 'esc_attr'
		) );
		$wp_customize->add_control(
            'rentax_header_minicart',
            array(
                'label'    => esc_html__( 'Minicart', 'rentax' ),
                'section'  => 'rentax_header_settings_elements',
                'settings' => 'rentax_header_minicart',
                'type'     => 'select',
                'choices'  => array(
                    '1'  => esc_html__( 'On', 'rentax' ),
                    '0' => esc_html__( 'Off', 'rentax' ),
                ),
                'priority'   => 20
            )
        );


		$wp_customize->add_setting( 'rentax_header_search' , array(
				'default'     => '1',
				'transport'   => 'refresh',
				'sanitize_callback' => 'esc_attr'
		) );
		$wp_customize->add_control(
            'rentax_header_search',
            array(
                'label'    => esc_html__( 'Search', 'rentax' ),
                'section'  => 'rentax_header_settings_elements',
                'settings' => 'rentax_header_search',
                'type'     => 'select',
                'choices'  => array(
                    '1'  => esc_html__( 'On', 'rentax' ),
                    '0' => esc_html__( 'Off', 'rentax' ),
                ),
                'priority'   => 30
            )
        );


		$wp_customize->add_setting( 'rentax_header_socials' , array(
				'default'     => '1',
				'transport'   => 'refresh',
				'sanitize_callback' => 'esc_attr'
		) );
		$wp_customize->add_control(
            'rentax_header_socials',
            array(
                'label'    => esc_html__( 'Socials', 'rentax' ),
                'section'  => 'rentax_header_settings_elements',
                'settings' => 'rentax_header_socials',
                'type'     => 'select',
                'choices'  => array(
                    '1'  => esc_html__( 'On', 'rentax' ),
                    '0' => esc_html__( 'Off', 'rentax' ),
                ),
                'priority'   => 40
            )
        );




		/// HEADER ELEMENTS POSITION ///

		$wp_customize->add_section( 'rentax_header_settings_elements_position' , array(
		    'title'      => esc_html__( 'Elements Position', 'rentax' ),
		    'priority'   => 20,
			'panel' => 'rentax_header_panel'
		) );


		$wp_customize->add_setting( 'rentax_header_topbarbox_1_position' , array(
				'default'     => 'left',
				'transport'   => 'refresh',
				'sanitize_callback' => 'esc_attr'
		) );
		$wp_customize->add_control(
            'rentax_header_topbarbox_1_position',
            array(
                'label'    => esc_html__( 'Top Bar Email', 'rentax' ),
                'section'  => 'rentax_header_settings_elements_position',
                'settings' => 'rentax_header_topbarbox_1_position',
                'type'     => 'select',
                'choices'  => array(
                    'left'  => esc_html__( 'Left', 'rentax' ),
                    'right' => esc_html__( 'Right', 'rentax' ),
                ),
                'priority'   => 50
            )
        );

		$wp_customize->add_setting( 'rentax_header_topbarbox_2_position' , array(
				'default'     => 'right',
				'transport'   => 'refresh',
				'sanitize_callback' => 'esc_attr'
		) );
		$wp_customize->add_control(
            'rentax_header_topbarbox_2_position',
            array(
                'label'    => esc_html__( 'Top Bar Menu', 'rentax' ),
                'section'  => 'rentax_header_settings_elements_position',
                'settings' => 'rentax_header_topbarbox_2_position',
                'type'     => 'select',
                'choices'  => array(
                    'left'  => esc_html__( 'Left', 'rentax' ),
                    'right' => esc_html__( 'Right', 'rentax' ),
                ),
                'priority'   => 60
            )
        );


		$wp_customize->add_setting( 'rentax_header_navibox_1_position' , array(
				'default'     => 'left',
				'transport'   => 'refresh',
				'sanitize_callback' => 'esc_attr'
		) );
		$wp_customize->add_control(
            'rentax_header_navibox_1_position',
            array(
                'label'    => esc_html__( 'Logo', 'rentax' ),
                'section'  => 'rentax_header_settings_elements_position',
                'settings' => 'rentax_header_navibox_1_position',
                'type'     => 'select',
                'choices'  => array(
                    'left'  => esc_html__( 'Left', 'rentax' ),
                    'right' => esc_html__( 'Right', 'rentax' ),
                ),
                'priority'   => 70
            )
        );


		$wp_customize->add_setting( 'rentax_header_navibox_2_position' , array(
				'default'     => 'right',
				'transport'   => 'refresh',
				'sanitize_callback' => 'esc_attr'
		) );
		$wp_customize->add_control(
            'rentax_header_navibox_2_position',
            array(
                'label'    => esc_html__( 'Main Menu', 'rentax' ),
                'section'  => 'rentax_header_settings_elements_position',
                'settings' => 'rentax_header_navibox_2_position',
                'type'     => 'select',
                'choices'  => array(
                    'left'  => esc_html__( 'Left', 'rentax' ),
                    'right' => esc_html__( 'Right', 'rentax' ),
                ),
                'priority'   => 80
            )
        );


		$wp_customize->add_setting( 'rentax_header_navibox_3_position' , array(
				'default'     => 'right',
				'transport'   => 'refresh',
				'sanitize_callback' => 'esc_attr'
		) );
		$wp_customize->add_control(
            'rentax_header_navibox_3_position',
            array(
                'label'    => esc_html__( 'Socials And Phone', 'rentax' ),
                'section'  => 'rentax_header_settings_elements_position',
                'settings' => 'rentax_header_navibox_3_position',
                'type'     => 'select',
                'choices'  => array(
                    'left'  => esc_html__( 'Left', 'rentax' ),
                    'right' => esc_html__( 'Right', 'rentax' ),
                ),
                'priority'   => 90
            )
        );


		$wp_customize->add_setting( 'rentax_header_navibox_4_position' , array(
				'default'     => 'right',
				'transport'   => 'refresh',
				'sanitize_callback' => 'esc_attr'
		) );
		$wp_customize->add_control(
            'rentax_header_navibox_4_position',
            array(
                'label'    => esc_html__( 'Minicart', 'rentax' ),
                'section'  => 'rentax_header_settings_elements_position',
                'settings' => 'rentax_header_navibox_4_position',
                'type'     => 'select',
                'choices'  => array(
                    'left'  => esc_html__( 'Left', 'rentax' ),
                    'right' => esc_html__( 'Right', 'rentax' ),
                ),
                'priority'   => 100
            )
        );


		$wp_customize->add_setting( 'rentax_header_adm_bar' , array(
				'default'     => '0',
				'sanitize_callback' => 'esc_attr'
		) );
        $wp_customize->add_control(
            'rentax_header_adm_bar',
            array(
                'label'    => esc_html__( 'Admin Bar Opacity', 'rentax' ),
                'description'   => '',
                'section'  => 'rentax_header_settings_elements_position',
                'settings' => 'rentax_header_adm_bar',
                'type'     => 'select',
                'choices'  => array(
                    '0'  => esc_html__( 'No', 'rentax' ),
                    '1' => esc_html__( 'Yes', 'rentax' ),
                ),
                'priority'   => 110
            )
        );





        /// HEADER INFO ///

		$wp_customize->add_section( 'rentax_header_settings_info' , array(
		    'title'      => esc_html__( 'Phone and email', 'rentax' ),
		    'priority'   => 25,
			'panel' => 'rentax_header_panel'
		) );


		$wp_customize->add_setting( 'rentax_header_phone' , array(
				'default'     => '',
				'transport'   => 'refresh',
				'sanitize_callback' => 'esc_attr'
		) );
		$wp_customize->add_control(
			'rentax_header_phone',
			array(
				'label'    => esc_html__( 'Phone', 'rentax' ),
				'section'  => 'rentax_header_settings_info',
				'settings' => 'rentax_header_phone',
				'type'     => 'text',
				'priority'   => 10
			)
		);


		$wp_customize->add_setting( 'rentax_header_email' , array(
				'default'     => '',
				'transport'   => 'refresh',
				'sanitize_callback' => 'esc_attr'
		) );
		$wp_customize->add_control(
			'rentax_header_email',
			array(
				'label'    => esc_html__( 'Email', 'rentax' ),
				'section'  => 'rentax_header_settings_info',
				'settings' => 'rentax_header_email',
				'type'     => 'text',
				'priority'   => 20
			)
		);



		/// HEADER BACKGROUND ///

		$wp_customize->add_section( 'rentax_header_settings_bg' , array(
		    'title'      => esc_html__( 'Background', 'rentax' ),
		    'priority'   => 30,
			'panel' => 'rentax_header_panel'
		) );


		$wp_customize->add_setting( 'rentax_header_bg_image' , array(
				'default'     => '',
				'transport'   => 'refresh',
				'sanitize_callback' => 'esc_attr'
		) );
		$wp_customize->add_control(
	        new WP_Customize_Image_Control(
	            $wp_customize,
	            'rentax_header_bg_image',
				array(
				   'label'      => esc_html__( 'Background image', 'rentax' ),
				   'section'    => 'rentax_header_settings_bg',
				   'context'    => 'rentax_header_bg_image',
				   'settings'   => 'rentax_header_bg_image',
				   'priority'   => 10
				)
	       )
	    );

	    $wp_customize->add_setting( 'rentax_header_bg_color' , array(
				'default'     => '#000000',
				'transport'   => 'refresh',
				'sanitize_callback' => 'esc_attr'
		) );
		$wp_customize->add_control(
	        new WP_Customize_Color_Control(
	            $wp_customize,
	            'rentax_header_bg_color',
				array(
				   'label'      => esc_html__( 'Overlay Color', 'rentax' ),
				   'section'    => 'rentax_header_settings_bg',
				   'settings'   => 'rentax_header_bg_color',
				   'priority'   => 20
				)
	       )
	    );

		$wp_customize->add_setting( 'rentax_header_bg_opacity' , array(
				'default'     => '8',
				'transport'   => 'refresh',
				'sanitize_callback' => 'esc_attr'
		) );
		$wp_customize->add_control(
            'rentax_header_bg_opacity',
            array(
                'label'    => esc_html__( 'Overlay Opacity', 'rentax' ),
                'section'  => 'rentax_header_settings_bg',
                'settings' => 'rentax_header_bg_opacity',
                'type'     => 'select',
                'choices'  => array(
                    '0' => "0.0",
					'1' => "0.1",
					'2' => "0.2",
					'3' => "0.3",
					'4' => "0.4",
					'5' => "0.5",
					'6' => "0.6",
					'7' => "0.7",
					'8' => "0.8",
					'9' => "0.9",
                ),
                'priority'   => 30
            )
        );

	}
		
?>