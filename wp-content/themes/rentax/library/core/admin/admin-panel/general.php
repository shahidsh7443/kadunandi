<?php 
	
	function rentax_customize_general_tab($wp_customize, $theme_name){
	
		$wp_customize->add_section( 'rentax_general_settings' , array(
		    'title'      => esc_html__( 'General Settings', 'rentax' ),
		    'priority'   => 0,
		) );
		
		
		/* logo image */ 
		
		$wp_customize->add_setting( 'rentax_general_settings_logo' , array(
			'default'     => '',
			'transport'   => 'refresh',
			'sanitize_callback' => 'sanitize_text_field'
		) );

		$wp_customize->add_setting( 'rentax_general_settings_logo_inverse' , array(
			'default'     => '',
			'transport'   => 'refresh',
			'sanitize_callback' => 'sanitize_text_field'
		) );
		
		$wp_customize->add_setting( 'rentax_general_settings_logo_text' , array(
		    'default'     => '',
		    'transport'   => 'refresh',
			'sanitize_callback' => 'sanitize_text_field'
		) );

		$wp_customize->add_setting( 'rentax_general_settings_loader' , array(
		    'default'     => '',
		    'transport'   => 'refresh',
			'sanitize_callback' => 'sanitize_text_field'
		) );
		
		
		$wp_customize->add_control(
	        new WP_Customize_Image_Control(
	            $wp_customize,
	            'rentax_general_settings_logo',
				array(
				   'label'      => esc_html__( 'Logo image light', 'rentax' ),
				   'section'    => 'rentax_general_settings',
				   'context'    => 'rentax_general_settings_logo',
				   'settings'   => 'rentax_general_settings_logo',
				   'priority'   => 50
				)
	       )
	    );

	    $wp_customize->add_control(
	        new WP_Customize_Image_Control(
	            $wp_customize,
	            'rentax_general_settings_logo_inverse',
				array(
				   'label'      => esc_html__( 'Logo image dark', 'rentax' ),
				   'section'    => 'rentax_general_settings',
				   'context'    => 'rentax_general_settings_logo_inverse',
				   'settings'   => 'rentax_general_settings_logo_inverse',
				   'priority'   => 60
				)
	       )
	    );

		$wp_customize->add_control(
			'rentax_general_settings_logo_text',
			array(
				'label'    => esc_html__( 'Logo Text', 'rentax' ),
				'section'  => 'rentax_general_settings',
				'settings' => 'rentax_general_settings_logo_text',
				'type'     => 'text',
				'priority'   => 70
			)
		);
	   
		$wp_customize->add_control(
			'rentax_general_settings_loader',
			array(
				'label'    => esc_html__( 'Loader', 'rentax' ),
				'section'  => 'rentax_general_settings',
				'settings' => 'rentax_general_settings_loader',
				'type'     => 'select',
				'choices'  => array(
					'off'  => esc_html__( 'Off', 'rentax' ),
					'usemain' => esc_html__( 'Use on main', 'rentax' ),
					'useall' => esc_html__( 'Use on all pages', 'rentax' ),
				),
				'priority'   => 110
			)
		);

		$wp_customize->add_setting( 'rentax_general_settings_live_editor' , array(
		    'default'     => '0',
		    'transport'   => 'refresh',
			'sanitize_callback' => 'sanitize_text_field'
		) );
		$wp_customize->add_control(
			'rentax_general_settings_live_editor',
			array(
				'label'    => esc_html__( 'Front Editor Button', 'rentax' ),
				'description' => esc_html__( 'Show button for Visual CSS Style Editor', 'rentax' ),
				'section'  => 'rentax_general_settings',
				'settings' => 'rentax_general_settings_live_editor',
				'type'     => 'select',
				'choices'  => array(
					'0'    => esc_html__( 'Off', 'rentax' ),
					'1'    => esc_html__( 'On', 'rentax' ),
				),
				'priority'   => 170
			)
		);


		
		
	}
	
	