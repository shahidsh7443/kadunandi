<?php

function rentax_customize_envato_tab($wp_customize, $theme_name) {

	/// Envato ///

	$wp_customize->add_section('rentax_envato_settings', array(
		'title' => esc_html__('Envato', 'rentax') ,
		'priority' => 90,
		'description' => ''
	));


    $wp_customize->add_setting( 'rentax_envato_show' , array(
			'default'     => '0',
			'transport' => 'refresh',
			'sanitize_callback' => 'wp_kses_post'
	) );
    $wp_customize->add_control(
        'rentax_envato_show',
        array(
            'label'    => esc_html__( 'Show Envato', 'rentax' ),
            'description'   => '',
            'section'  => 'rentax_envato_settings',
            'settings' => 'rentax_envato_show',
            'type'     => 'select',
            'choices'  => array(
                '0'  => esc_html__( 'No', 'rentax' ),
                '1' => esc_html__( 'Yes', 'rentax' ),
            ),
            'priority'   => 1
        )
    );
	
	$wp_customize->add_setting('rentax_envato_currency', array(
		'default' => '',
		'transport' => 'refresh',
		'sanitize_callback' => 'wp_kses_post',

	));
	$wp_customize->add_control('rentax_envato_currency', array(
		'label' => esc_html__('Envato Currency', 'rentax') ,
		'section' => 'rentax_envato_settings',
		'settings' => 'rentax_envato_currency',
		'description' => ''
	));
	
	$wp_customize->add_setting('rentax_envato_price', array(
		'default' => '',
		'transport' => 'refresh',
		'sanitize_callback' => 'wp_kses_post',

	));
	$wp_customize->add_control('rentax_envato_price', array(
		'label' => esc_html__('Envato Price', 'rentax') ,
		'section' => 'rentax_envato_settings',
		'settings' => 'rentax_envato_price',
		'description' => ''
	));
	
	$wp_customize->add_setting('rentax_envato_link', array(
		'default' => '',
		'transport' => 'refresh',
		'sanitize_callback' => 'esc_url',

	));	
	$wp_customize->add_control('rentax_envato_link', array(
		'label' => esc_html__('Envato Link', 'rentax') ,
		'section' => 'rentax_envato_settings',
		'settings' => 'rentax_envato_link',
		'description' => ''
	));

	// ////////////////////////////////////////////////////////

}