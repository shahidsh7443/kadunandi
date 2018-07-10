<?php 
	
	function rentax_customize_footer_tab($wp_customize){

		$wp_customize->add_section( 'rentax_footer_settings' , array(
		    'title'      => esc_html__( 'Footer', 'rentax' ),
		    'priority'   => 25,
		) );

		$wp_customize->add_setting( 'rentax_footer_settings_copyright' , array(
            'default'     => esc_html__( 'Copyright 2016. Design by Pix-Theme', 'rentax' ),
            'transport'   => 'refresh',
		    'sanitize_callback' => 'wp_kses_post'
        ) );

        $wp_customize->add_control(
            'rentax_footer_settings_copyright',
            array(
                'label'    => esc_html__( 'Footer Copyright Text', 'rentax' ),
                'section'  => 'rentax_footer_settings',
                'settings' => 'rentax_footer_settings_copyright',
                'type'     => 'textarea',
                'priority'   => 10
            )
        );

        $wp_customize->add_setting( 'rentax_footer_block' , array(
			'default'     => '0',
			'transport'   => 'refresh',
			'sanitize_callback' => 'esc_html'
		) );
		$staticBlocks = rentax_get_staticblock_option_array();
        $wp_customize->add_control(
			'rentax_footer_block',
			array(
				'label'    => esc_html__( 'Footer Block', 'rentax' ),
				'section'  => 'rentax_footer_settings',
				'settings' => 'rentax_footer_block',
				'type'     => 'select',
				'choices'  => $staticBlocks,
				'priority' => 20
			)
		);

		$wp_customize->add_setting( 'rentax_footer_logo' , array(
				'default'     => '',
				'transport'   => 'refresh',
				'sanitize_callback' => 'sanitize_text_field'
		) );
		$wp_customize->add_control(
	        new WP_Customize_Image_Control(
	            $wp_customize,
	            'rentax_footer_logo',
				array(
				   'label'      => esc_html__( 'Logo image light', 'rentax' ),
				   'section'    => 'rentax_footer_settings',
				   'settings'   => 'rentax_footer_logo',
				   'priority'   => 25
				)
	       )
	    );

		$wp_customize->add_setting( 'rentax_footer_bg_image' , array(
				'default'     => '',
				'transport'   => 'refresh',
				'sanitize_callback' => 'sanitize_text_field'
		) );
		$wp_customize->add_control(
	        new WP_Customize_Image_Control(
	            $wp_customize,
	            'rentax_footer_bg_image',
				array(
				   'label'      => esc_html__( 'Background image', 'rentax' ),
				   'section'    => 'rentax_footer_settings',
				   'settings'   => 'rentax_footer_bg_image',
				   'priority'   => 30
				)
	       )
	    );

		$wp_customize->add_setting( 'rentax_footer_decor' , array(
				'default'     => '1',
				'sanitize_callback' => 'sanitize_text_field'
		) );
        $wp_customize->add_control(
            'rentax_footer_decor',
            array(
                'label'    => esc_html__( 'Show Decor', 'rentax' ),
                'description'   => '',
                'section'  => 'rentax_footer_settings',
                'settings' => 'rentax_footer_decor',
                'type'     => 'select',
                'choices'  => array(
                    '1' => esc_html__( 'Yes', 'rentax' ),
                    '0'  => esc_html__( 'No', 'rentax' ),
                ),
                'priority'   => 40
            )
        );

	}
		
?>