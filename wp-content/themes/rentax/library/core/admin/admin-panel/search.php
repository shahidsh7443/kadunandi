<?php

	function rentax_customize_search_tab($wp_customize, $theme_name){
	
		$wp_customize->add_section( 'rentax_search_settings' , array(
		    'title'      => esc_html__( 'Search', 'rentax' ),
		    'priority'   => 8,
		) );

		
		$wp_customize->add_setting( 'rentax_search_placeholder' , array(
				'default'     => '',
				'transport'   => 'refresh',
				'sanitize_callback' => 'sanitize_text_field'
		) );

		$wp_customize->add_setting( 'rentax_search_description' , array(
				'default'     => '',
				'transport'   => 'refresh',
				'sanitize_callback' => 'sanitize_text_field'
		) );



		$wp_customize->add_control(
			'rentax_search_placeholder',
			array(
				'label'    => esc_html__( 'Search Placeholder', 'rentax' ),
				'section'  => 'rentax_search_settings',
				'settings' => 'rentax_search_placeholder',
				'type'     => 'text',
				'priority'   => 10
			)
		);

		$wp_customize->add_control(
			'rentax_search_description',
			array(
				'label'    => esc_html__( 'Search Description', 'rentax' ),
				'section'  => 'rentax_search_settings',
				'settings' => 'rentax_search_description',
				'type'     => 'text',
				'priority'   => 20
			)
		);
		
	}
		
?>