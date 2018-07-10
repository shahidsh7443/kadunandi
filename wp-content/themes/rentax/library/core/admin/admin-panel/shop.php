<?php
	
	function rentax_customize_shop_tab($wp_customize, $theme_name){

		$rentax_pix_slider = array( 0 => esc_html__( 'No RevSlider', 'rentax' ) );
		if (class_exists('RevSlider')) {
			$arr = array( 0 => esc_html__( 'No RevSlider', 'rentax' ) );

			$pix_sliders 	= new RevSlider();
			$pix_arrSliders = $pix_sliders->getArrSliders();

			foreach($pix_arrSliders as $slider){
			  $arr[$slider->getAlias()] = $slider->getTitle();
			}
			if($arr){
			  $rentax_pix_slider = $arr;
			}

		}

		$wp_customize->add_section( 'rentax_shop_settings' , array(
		    'title'      => esc_html__( 'Shop', 'rentax' ),
		    'priority'   => 10,
		) );

		$wp_customize->add_setting( 'rentax_shop_header_slider' , array(
			'default'     => 0,
			'transport'   => 'refresh',
			'sanitize_callback' => 'sanitize_text_field'
		) );

		$wp_customize->add_setting( 'rentax_shop_header_image' , array(
			'default'     => '',
			'transport'   => 'refresh',
			'sanitize_callback' => 'sanitize_text_field'
		) );

		$wp_customize->add_control(
			'rentax_shop_header_slider',
			array(
				'label'    => esc_html__( 'Header RevSlider On Main Shop Page', 'rentax' ),
				'section'  => 'rentax_shop_settings',
				'settings' => 'rentax_shop_header_slider',
				'type'     => 'select',
				'choices'  => $rentax_pix_slider
			)
		);

        $wp_customize->add_control(
	        new WP_Customize_Image_Control(
	            $wp_customize,
	            'rentax_shop_header_image',
				array(
				   'label'      => esc_html__( 'Header Image', 'rentax' ),
				   'section'    => 'rentax_shop_settings',
				   'context'    => 'rentax_shop_header_image',
				   'settings'   => 'rentax_shop_header_image',
				   'priority'   => 10
				)
	       )
	    );


				
	}
?>