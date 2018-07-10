<?php
 
add_action( 'init', 'rentax_integrateWithVC', 200 );

function rentax_integrateWithVC() {

	if (!function_exists('vc_map'))
		return FALSE;

	global $theme_name;


	$theme_name = 'rentax';

	vc_remove_element( "vc_gallery" );
	vc_remove_element( "vc_images_carousel" );
	vc_remove_element( "vc_posts_slider" );

	$args = array( 'taxonomy' => 'portfolio_category', 'hide_empty' => '0');
	$categories = get_categories($args);
	$cats = array();
	$i = 0;
	foreach($categories as $category){
		if(is_object($category)){
			if($i==0){
				$default = $category->slug;
				$i++;
			}
			$cats[$category->name] = $category->term_id;
		}
	}
	
	if ( class_exists( 'WooCommerce' ) ) {
		$args = array( 'taxonomy' => 'product_cat', 'hide_empty' => '0');
		$categories_woo = get_categories($args);
		$cats_woo = array();
		$i = 0;
		foreach($categories_woo as $category){
			if($i==0){
				$default = $category->slug;
				$i++;
			}
			$cats_woo[$category->name] = $category->term_id;
		}
	}
		
	/** Fonts Icon Loader */

	$vc_icons_data = rentax_init_vc_icons();
	
	$add_css_animation = array(
		'type' => 'dropdown',
		'heading' => esc_html__( 'CSS Animation', 'rentax' ),
		'param_name' => 'css_animation',
		'admin_label' => true,
		'value' => array(
			esc_html__( 'No', 'rentax' ) => '',
			esc_html__( 'bounce', 'rentax' ) => 'bounce',
			esc_html__( 'flash', 'rentax' ) => 'flash',
			esc_html__( 'pulse', 'rentax' ) => 'pulse',
			esc_html__( 'rubberBand', 'rentax' ) => 'rubberBand',
			esc_html__( 'shake', 'rentax' ) => 'shake',
			esc_html__( 'swing', 'rentax' ) => 'swing',
			esc_html__( 'tada', 'rentax' ) => 'tada',
			esc_html__( 'wobble', 'rentax' ) => 'wobble',
			esc_html__( 'jello', 'rentax' ) => 'jello',
			
			esc_html__( 'bounceIn', 'rentax' ) => 'bounceIn',
			esc_html__( 'bounceInDown', 'rentax' ) => 'bounceInDown',
			esc_html__( 'bounceInLeft', 'rentax' ) => 'bounceInLeft',
			esc_html__( 'bounceInRight', 'rentax' ) => 'bounceInRight',
			esc_html__( 'bounceInUp', 'rentax' ) => 'bounceInUp',
			esc_html__( 'bounceOut', 'rentax' ) => 'bounceOut',
			esc_html__( 'bounceOutDown', 'rentax' ) => 'bounceOutDown',
			esc_html__( 'bounceOutLeft', 'rentax' ) => 'bounceOutLeft',
			esc_html__( 'bounceOutRight', 'rentax' ) => 'bounceOutRight',
			esc_html__( 'bounceOutUp', 'rentax' ) => 'bounceOutUp',
			
			esc_html__( 'fadeIn', 'rentax' ) => 'fadeIn',
			esc_html__( 'fadeInDown', 'rentax' ) => 'fadeInDown',
			esc_html__( 'fadeInDownBig', 'rentax' ) => 'fadeInDownBig',
			esc_html__( 'fadeInLeft', 'rentax' ) => 'fadeInLeft',
			esc_html__( 'fadeInLeftBig', 'rentax' ) => 'fadeInLeftBig',
			esc_html__( 'fadeInRight', 'rentax' ) => 'fadeInRight',
			esc_html__( 'fadeInRightBig', 'rentax' ) => 'fadeInRightBig',
			esc_html__( 'fadeInUp', 'rentax' ) => 'fadeInUp',
			esc_html__( 'fadeInUpBig', 'rentax' ) => 'fadeInUpBig',			
			esc_html__( 'fadeOut', 'rentax' ) => 'fadeOut',
			esc_html__( 'fadeOutDown', 'rentax' ) => 'fadeOutDown',
			esc_html__( 'fadeOutDownBig', 'rentax' ) => 'fadeOutDownBig',
			esc_html__( 'fadeOutLeft', 'rentax' ) => 'fadeOutLeft',
			esc_html__( 'fadeOutLeftBig', 'rentax' ) => 'fadeOutLeftBig',
			esc_html__( 'fadeOutRight', 'rentax' ) => 'fadeOutRight',
			esc_html__( 'fadeOutRightBig', 'rentax' ) => 'fadeOutRightBig',
			esc_html__( 'fadeOutUp', 'rentax' ) => 'fadeOutUp',
			esc_html__( 'fadeOutUpBig', 'rentax' ) => 'fadeOutUpBig',
			
			esc_html__( 'flip', 'rentax' ) => 'flip',
			esc_html__( 'flipInX', 'rentax' ) => 'flipInX',
			esc_html__( 'flipInY', 'rentax' ) => 'flipInY',
			esc_html__( 'flipOutX', 'rentax' ) => 'flipOutX',
			esc_html__( 'flipOutY', 'rentax' ) => 'flipOutY',
			
			esc_html__( 'lightSpeedIn', 'rentax' ) => 'lightSpeedIn',
			esc_html__( 'lightSpeedOut', 'rentax' ) => 'lightSpeedOut',
			
			esc_html__( 'rotateIn', 'rentax' ) => 'rotateIn',
			esc_html__( 'rotateInDownLeft', 'rentax' ) => 'rotateInDownLeft',
			esc_html__( 'rotateInDownRight', 'rentax' ) => 'rotateInDownRight',
			esc_html__( 'rotateInUpLeft', 'rentax' ) => 'rotateInUpLeft',
			esc_html__( 'rotateInUpRight', 'rentax' ) => 'rotateInUpRight',			
			esc_html__( 'rotateOut', 'rentax' ) => 'rotateOut',
			esc_html__( 'rotateOutDownLeft', 'rentax' ) => 'rotateOutDownLeft',
			esc_html__( 'rotateOutDownRight', 'rentax' ) => 'rotateOutDownRight',
			esc_html__( 'rotateOutUpLeft', 'rentax' ) => 'rotateOutUpLeft',
			esc_html__( 'rotateOutUpRight', 'rentax' ) => 'rotateOutUpRight',
			
			esc_html__( 'slideInUp', 'rentax' ) => 'slideInUp',
			esc_html__( 'slideInDown', 'rentax' ) => 'slideInDown',
			esc_html__( 'slideInLeft', 'rentax' ) => 'slideInLeft',
			esc_html__( 'slideInRight', 'rentax' ) => 'slideInRight',
			esc_html__( 'slideOutUp', 'rentax' ) => 'slideOutUp',			
			esc_html__( 'slideOutDown', 'rentax' ) => 'slideOutDown',
			esc_html__( 'slideOutLeft', 'rentax' ) => 'slideOutLeft',
			esc_html__( 'slideOutRight', 'rentax' ) => 'slideOutRight',
			
			esc_html__( 'zoomIn', 'rentax' ) => 'zoomIn',
			esc_html__( 'zoomInDown', 'rentax' ) => 'zoomInDown',
			esc_html__( 'zoomInLeft', 'rentax' ) => 'zoomInLeft',
			esc_html__( 'zoomInRight', 'rentax' ) => 'zoomInRight',
			esc_html__( 'zoomInUp', 'rentax' ) => 'zoomInUp',			
			esc_html__( 'zoomOut', 'rentax' ) => 'zoomOut',
			esc_html__( 'zoomOutDown', 'rentax' ) => 'zoomOutDown',
			esc_html__( 'zoomOutLeft', 'rentax' ) => 'zoomOutLeft',
			esc_html__( 'zoomOutRight', 'rentax' ) => 'zoomOutRight',
			esc_html__( 'zoomOutUp', 'rentax' ) => 'zoomOutUp',
			
			esc_html__( 'hinge', 'rentax' ) => 'hinge',			
			esc_html__( 'rollIn', 'rentax' ) => 'rollIn',
			esc_html__( 'rollOut', 'rentax' ) => 'rollOut',
			
		),
		'description' => esc_html__( 'Select type of animation if you want this element to be animated when it enters into the browsers viewport. Note: Works only in modern browsers.', 'rentax' )
	);



	$jarallax = array(
		array(
			'type' => 'attach_image',
			'heading' => "Background Image",
			'param_name' => 'bgimage',
			'value' => '',
			'description' => esc_html__( "Background image ", 'rentax' ),
			'group' => esc_html__( 'Theme Options', 'rentax' ),
		),
		array(
			'type' => 'dropdown',
			'heading' => "Background Style",
			'param_name' => 'bgstyle',
			'value' => array(
				esc_html__( "Default", 'rentax' ) => '',
				esc_html__( "Parallax", 'rentax' ) => 'jarallax',
				esc_html__( "Fixed", 'rentax' ) => 'attachment',
			),
			'description' => esc_html__( "Image background style", 'rentax' ),
			'group' => esc_html__( 'Theme Options', 'rentax' ),
		),
		array(
			'type' => 'dropdown',
			'heading' => esc_html__( "Stretch Content", 'rentax' ),
			'param_name' => 'jarstretch',
			'value' => array('No', 'Yes'),
			'description' => esc_html__( 'Select stretching options for content.', 'rentax' ),
			'dependency' => array(
				'element' => 'bgstyle',
				'value' => 'jarallax',
			),
			'group' => esc_html__( 'Theme Options', 'rentax' ),
		),
		array(
			'type' => 'dropdown',
			'heading' => esc_html__( "Type", 'rentax' ),
			'param_name' => 'jartype',
			'value' => array('Default', 'scale', 'opacity', 'scroll-opacity', 'scale-opacity'),
			'description' => '',
			'dependency' => array(
				'element' => 'bgstyle',
				'value' => 'jarallax',
			),
			'group' => esc_html__( 'Theme Options', 'rentax' ),
		),
		array(
			"type" => "textfield",
			"heading" => esc_html__( "Speed", 'rentax' ),
			"param_name" => "jarspeed",
			"value" => '',
			"description" => esc_html__( "Provide numbers from -1.0 to 2.0", 'rentax' ),
			'dependency' => array(
				'element' => 'bgstyle',
				'value' => 'jarallax',
			),
			'group' => esc_html__( 'Theme Options', 'rentax' ),
		),

		array(
			'type' => 'dropdown',
			'heading' => "Text Color",
			'param_name' => 'ptextcolor',
			'value' => array("Default" , "White" , "Black"),
			'description' => esc_html__( "Text Color", 'rentax' ),
			'group' => esc_html__( 'Theme Options', 'rentax' ),
		),

	);

	$attributes1 = array(
		array(
			'type' => 'dropdown',
			'heading' => esc_html__( 'Padding', 'rentax' ),
			'param_name' => 'ppadding',
			'value' => array(
				esc_html__( "No Padding", 'rentax' ) => 'vc_row-no-padding',
				esc_html__( "Both", 'rentax' ) => 'vc_row-padding-both',
				esc_html__( "Top", 'rentax' ) => 'vc_row-padding-top',
				esc_html__( "Bottom", 'rentax' ) => 'vc_row-padding-bottom',
			),
			'description' => esc_html__( 'Top, bottom, both', 'rentax' ),
			'group' => esc_html__( 'Theme Options', 'rentax' ),
		),
	);

	$attributes2 = array(
		array(
			'type' => 'dropdown',
			'heading' => "Show Section Decor",
			'param_name' => 'pdecor',
			'value' => array(
				esc_html__( "No", 'rentax' ) => 'no',
				esc_html__( "Both", 'rentax' ) => 'both',
				esc_html__( "Top", 'rentax' ) => 'top',
				esc_html__( "Bottom", 'rentax' ) => 'bottom',
				esc_html__( "Bottom V Decor", 'rentax' ) => 'main-slider',
			),
			'description' => esc_html__( "Show decor for section.", 'rentax' ),
			'group' => esc_html__( 'Theme Options', 'rentax' ),
		),
		array(
			'type' => 'dropdown',
			'heading' => "Section Decor Color",
			'param_name' => 'pdecor_color',
			'value' => array(
				esc_html__( "Default", 'rentax' ) => 'default',
				esc_html__( "Color", 'rentax' ) => 'colorize',
			),
			'dependency' => array(
				'element' => 'pdecor',
				'value' => array('both', 'top'),
			),
			'description' => esc_html__( "Decor color. Default Black.", 'rentax' ),
			'group' => esc_html__( 'Theme Options', 'rentax' ),
		),
		array(
			'type' => 'dropdown',
			'heading' => "Text Color",
			'param_name' => 'ptextcolor',
			'value' => array("Default" , "White" , "Black"),
			'description' => esc_html__( "Text Color", 'rentax' ),
			'group' => esc_html__( 'Theme Options', 'rentax' ),
		),
	);

	$attributes = array_merge($attributes1, $jarallax, $attributes2);
	vc_add_params( 'vc_row', $attributes );
	vc_add_params( 'vc_row_inner', $jarallax );
	vc_add_params( 'vc_column', $jarallax );
	
	
	vc_map(
		array(
			'name' => esc_html__( 'Title', 'rentax' ),
			'base' => 'block_title',
			'class' => 'pix-theme-icon',
			'category' => esc_html__( 'Rentax', 'rentax'),
			'params' => array(
				array(
					'type' => 'textfield',
					'holder' => 'div',
					'class' => '',
					'heading' => esc_html__( 'Title', 'rentax' ),
					'param_name' => 'title',
					'value' => esc_html__( 'I am Title', 'rentax' ),
					'description' => esc_html__( 'Title param.', 'rentax' )
				),	
				 
				array(
					'type' => 'dropdown',
					'heading' => esc_html__( 'Title Position', 'rentax' ),
					'param_name' => 'titlepos',
					'value' => array(
						esc_html__( 'Center', 'rentax' ) => 'text-center',
						esc_html__( 'Left', 'rentax' ) => 'text-left',
						esc_html__( 'Right', 'rentax' ) => 'text-right',
					),
					'description' => esc_html__( 'Center, left or right', 'rentax' ),
				),
				array(
					'type' => 'colorpicker',
					'heading' => esc_html__( 'Title Color', 'rentax' ),
					'param_name' => 'title_color',
					'value' => '',
					'description' => '',
				),	
				$add_css_animation,
				array(
					'type' => 'textarea_html',
					'holder' => 'div',
					'class' => '',
					'heading' => esc_html__( 'Content', 'rentax' ),
					'param_name' => 'content',
					'value' => wp_kses_post(__( '<p>I am test text block. Click edit button to change this text.</p>', 'rentax' ) ),
					'description' => esc_html__( 'Enter your content.', 'rentax' )
				)
			)
		) 
	);
	
	if ( class_exists( 'WPBakeryShortCode' ) ) {
		class WPBakeryShortCode_Block_Title extends WPBakeryShortCode {
			
		}
	}
	

	//////// Services  ////////
	vc_map( array(
		'name' => esc_html__( 'Amount Section', 'rentax' ),
		'base' => 'section_amounts',
		'class' => 'pix-theme-icon',
		'as_parent' => array('only' => 'section_amount'), // Use only|except attributes to limit child shortcodes (separate multiple values with comma)
		'content_element' => true,
		'show_settings_on_create' => false,
		'category' => esc_html__( 'Rentax', 'rentax'),
		'params' => array(
			$add_css_animation,
		),
		'js_view' => 'VcColumnView',

	) );
	$params1 = array(
				array(
					'type' => 'textfield',
					'holder' => 'div',
					'class' => '',
					'heading' => esc_html__( 'Title', 'rentax' ),
					'param_name' => 'title',
					'value' => esc_html__( 'Project', 'rentax' ),
					'description' => esc_html__( 'Title.', 'rentax' )
				),
				array(
					'type' => 'textfield',
					'holder' => 'div',
					'class' => '',
					'heading' => esc_html__( 'Amount', 'rentax' ),
					'param_name' => 'amount',
					'value' => esc_html__( '999', 'rentax' ),
					'description' => esc_html__( 'Amount.', 'rentax' )
				),
			);
	if(!function_exists('fil_init')){
		$params = $params1;
	}else{
		$params = array_merge($params1, rentax_get_vc_icons($vc_icons_data));
	}
	vc_map(
		array(
			'name' => esc_html__( 'Amount Box', 'rentax' ),
			'base' => 'section_amount',
			'class' => 'pix-theme-icon',
			'as_child' => array('only' => 'section_amounts'),
			'content_element' => true,
			'params' => $params,
		)
	);
	if ( class_exists( 'WPBakeryShortCodesContainer' ) ) {
		class WPBakeryShortCode_Section_Amounts extends WPBakeryShortCodesContainer {
		}
	}
	if ( class_exists( 'WPBakeryShortCode' ) ) {
		class WPBakeryShortCode_Section_Amount extends WPBakeryShortCode {
		}
	}
	/////////////////////////////////

	/// section_banner
	vc_map(
		array(
			'name' => esc_html__( 'Welcome Banner', 'rentax' ),
			'base' => 'section_banner',
			'class' => 'pix-theme-icon',
			'category' => esc_html__( 'Rentax', 'rentax'),
			'params' => array(
				array(
					'type' => 'textfield',
					'holder' => 'div',
					'class' => '',
					'heading' => esc_html__( 'Title', 'rentax' ),
					'param_name' => 'title',
					'value' => esc_html__( 'AUTOZONE', 'rentax' ),
					'description' => esc_html__( 'Button Title', 'rentax' )
				),
				array(
					'type' => 'textfield',
					'holder' => 'div',
					'class' => '',
					'heading' => esc_html__( 'Advanced Title', 'rentax' ),
					'param_name' => 'adv_title',
					'value' => esc_html__( 'WELCOME TO', 'rentax' ),
					'description' => esc_html__( 'Text before main title', 'rentax' )
				),
				array(
					'type' => 'checkbox',
					'class' => '',
					'heading' => esc_html__( 'Use Decor', 'rentax' ),
					'param_name' => 'use_decor',
					'value' => 'true',
					'description' => esc_html__( 'Marked if checked.', 'rentax' )
				),
				array(
					'type' => 'attach_image',
					'heading' => esc_html__( 'Image 1', 'rentax' ),
					'param_name' => 'image1',
					'value' => '',
					'description' => esc_html__( 'Select image from media library.', 'rentax' )
				),
				array(
					'type' => 'textfield',
					'holder' => 'div',
					'class' => '',
					'heading' => esc_html__( 'Image Text 1', 'rentax' ),
					'param_name' => 'img_text1',
					'value' => '',
					'description' => esc_html__( 'Text on image', 'rentax' )
				),
				array(
					'type' => 'vc_link',
					'holder' => 'div',
					'class' => '',
					'heading' => esc_html__( 'Link 1', 'rentax' ),
					'param_name' => 'link1',
					'value' => esc_html__( 'https:/rentax.com', 'rentax' ),
					'description' => esc_html__( 'Button link', 'rentax' ),
				),
				array(
					'type' => 'attach_image',
					'heading' => esc_html__( 'Image 2', 'rentax' ),
					'param_name' => 'image2',
					'value' => '',
					'description' => esc_html__( 'Select image from media library.', 'rentax' )
				),
				array(
					'type' => 'textfield',
					'holder' => 'div',
					'class' => '',
					'heading' => esc_html__( 'Image Text 2', 'rentax' ),
					'param_name' => 'img_text2',
					'value' => '',
					'description' => esc_html__( 'Button description', 'rentax' )
				),
				array(
					'type' => 'vc_link',
					'holder' => 'div',
					'class' => '',
					'heading' => esc_html__( 'Link 2', 'rentax' ),
					'param_name' => 'link2',
					'value' => esc_html__( 'https:/rentax.com', 'rentax' ),
					'description' => esc_html__( 'Button link', 'rentax' ),
				),
				array(
					'type' => 'attach_image',
					'heading' => esc_html__( 'Image 3', 'rentax' ),
					'param_name' => 'image3',
					'value' => '',
					'description' => esc_html__( 'Select image from media library.', 'rentax' )
				),
				array(
					'type' => 'textfield',
					'holder' => 'div',
					'class' => '',
					'heading' => esc_html__( 'Image Text 3', 'rentax' ),
					'param_name' => 'img_text3',
					'value' => '',
					'description' => esc_html__( 'Button description', 'rentax' )
				),
				array(
					'type' => 'vc_link',
					'holder' => 'div',
					'class' => '',
					'heading' => esc_html__( 'Link 3', 'rentax' ),
					'param_name' => 'link3',
					'value' => esc_html__( 'https:/rentax.com', 'rentax' ),
					'description' => esc_html__( 'Button link', 'rentax' ),
				),
				array(
					'type' => 'attach_image',
					'heading' => esc_html__( 'Image 4', 'rentax' ),
					'param_name' => 'image4',
					'value' => '',
					'description' => esc_html__( 'Select image from media library.', 'rentax' )
				),
				array(
					'type' => 'textfield',
					'holder' => 'div',
					'class' => '',
					'heading' => esc_html__( 'Image Text 4', 'rentax' ),
					'param_name' => 'img_text4',
					'value' => '',
					'description' => esc_html__( 'Button description', 'rentax' )
				),
				array(
					'type' => 'vc_link',
					'holder' => 'div',
					'class' => '',
					'heading' => esc_html__( 'Link 4', 'rentax' ),
					'param_name' => 'link4',
					'value' => esc_html__( 'https:/rentax.com', 'rentax' ),
					'description' => esc_html__( 'Button link', 'rentax' ),
				),
				$add_css_animation,
				array(
					'type' => 'textarea_html',
					'holder' => 'div',
					'class' => '',
					'heading' => esc_html__( 'Content', 'rentax' ),
					'param_name' => 'content',
					'value' => esc_html__( 'THE ONLINE AUTOS WORLD', 'rentax' ),
					'description' => esc_html__( 'Banner Text', 'rentax' ),
				),
			)
		) 
	);
	if ( class_exists( 'WPBakeryShortCode' ) ) {
		class WPBakeryShortCode_Section_Banner extends WPBakeryShortCode {
			
		}
	}
	


	//////// Services  ////////
	vc_map( array(
		'name' => esc_html__( 'Services', 'rentax' ),
		'base' => 'section_services',
		'class' => 'pix-theme-icon',
		'as_parent' => array('only' => 'section_service'), // Use only|except attributes to limit child shortcodes (separate multiple values with comma)
		'content_element' => true,
		'show_settings_on_create' => false,
		'category' => esc_html__( 'Rentax', 'rentax'),
		'params' => array(
			array(
				'type' => 'dropdown',
				'heading' => esc_html__( 'Carousel', 'rentax' ),
				'param_name' => 'disable_carousel',
				'value' => array(
					esc_html__('Enable', 'rentax') => 1,
					esc_html__('Disable', 'rentax') => 0,
				),
				'description' => esc_html__( 'On/off carousel', 'rentax' )
			),
			$add_css_animation,
		),
		'js_view' => 'VcColumnView',

	) );
	$params1 = array(
				array(
					'type' => 'textfield',
					'heading' => esc_html__( 'Title', 'rentax' ),
					'param_name' => 'title',
					'description' => esc_html__( 'Title info.', 'rentax' )
				),
				array(
					'type' => 'textfield',
					'heading' => esc_html__( 'Strong Title', 'rentax' ),
					'param_name' => 'title_strong',
					'description' => esc_html__( 'Strong part of title text.', 'rentax' )
				),
			);
	$params2 = array(
				array(
					'type' => 'vc_link',
					'heading' => esc_html__( 'Link', 'rentax' ),
					'param_name' => 'link',
					'description' => esc_html__( 'Service page link.', 'rentax' )
				),
				$add_css_animation,
				array(
					"type" => "textarea_html",
					"holder" => "div",
					"class" => "",
					"heading" => esc_html__( "Info", 'rentax' ),
					"param_name" => "content",
					"value" => esc_html__( 'I am test text block. Click edit button to change this text.', 'rentax' ),
					"description" => esc_html__( "Enter information.", 'rentax' ),
				),
			);
	if(!function_exists('fil_init')){
		$params = array_merge($params1, $params2);
	}else{
		$params = array_merge($params1, rentax_get_vc_icons($vc_icons_data), $params2);
	}
	vc_map( 
		array(
			'name' => esc_html__( 'Service Box', 'rentax' ),
			'base' => 'section_service',
			'class' => 'pix-theme-icon',
			'as_child' => array('only' => 'section_services'),
			'content_element' => true,
			'params' => $params,
		) 
	);
	if ( class_exists( 'WPBakeryShortCodesContainer' ) ) {
		class WPBakeryShortCode_Section_Services extends WPBakeryShortCodesContainer {
		}
	}
	if ( class_exists( 'WPBakeryShortCode' ) ) {
		class WPBakeryShortCode_Section_Service extends WPBakeryShortCode {
		}
	}
	/////////////////////////////////
	
	
	/// section_imagescarousel
	vc_map(
		array(
			"name" => esc_html__( "Images Carousel", 'rentax' ),
			"base" => "section_imagescarousel",
			"class" => "pix-theme-icon",
			"category" => esc_html__( "Rentax", 'rentax'),
			"params" => array(
				array(
					'type' => 'attach_images',
					'heading' => esc_html__( 'Images', 'rentax' ),
					'param_name' => 'images',
					'value' => '',
					'description' => esc_html__( 'Select images from media library.', 'rentax' )
				),
				array(
					'type' => 'textfield',
					'heading' => esc_html__( 'Image size', 'rentax' ),
					'param_name' => 'img_size',
					'value' => 'thumbnail',
					'description' => esc_html__( 'Enter image size. Example: thumbnail, medium, large, full or other sizes defined by current theme. Alternatively enter image size in pixels: 200x100 (Width x Height). Leave empty to use "thumbnail" size. If used slides per view, this will be used to define carousel wrapper size.', 'rentax' ),
				),
				array(
					'type' => 'textfield',
					'heading' => esc_html__( 'Auto Play', 'rentax' ),
					'param_name' => 'autoplay',
					'value' => '4000',
					'description' => esc_html__( 'Enter autoplay speed in milliseconds. 0 is turn off autoplay.', 'rentax' ),
				),
				$add_css_animation,
			)
		) 
	);
	if ( class_exists( 'WPBakeryShortCode' ) ) {
		class WPBakeryShortCode_Section_Imagescarousel extends WPBakeryShortCode {
			
		}
	}
	
	

	
	//////////////////////////////////////////////////////////////////////
	
		
	/// block_posts
	vc_map(
		array(
			"name" => esc_html__( "News Block", 'rentax' ),
			"base" => "block_posts",
			"class" => "pix-theme-icon3",
			"category" => esc_html__( "Rentax", 'rentax'),
			"params" => array(
				array(
					"type" => "textfield",
					"heading" => esc_html__( "Title", 'rentax' ),
					"param_name" => "title",
					"value" => esc_html__( "Latest News", 'rentax' ),
					"description" => esc_html__( "", 'rentax' ),
				),
				array(
					'type' => 'textfield',
					'heading' => esc_html__( 'Button Text', 'rentax' ),
					'param_name' => 'btn_text',
					'value' => esc_html__( 'READ BLOG', 'rentax' ),
					'description' => esc_html__( 'Leave empty to hide bytton.', 'rentax' ),
				),
				array(
					'type' => 'vc_link',
					'heading' => esc_html__( 'Link For All News', 'rentax' ),
					'param_name' => 'link',
					'value' => '',
					'description' => '',
				),
				array(
					'type' => 'dropdown',
					'heading' => esc_html__( 'Color scheme', 'rentax' ),
					'param_name' => 'skin',
					'value' => array(
						esc_html__( "Light", 'rentax' ) => 'pix-lastnews-light',
						esc_html__( "Dark", 'rentax' ) => 'pix-lastnews-dark',
					),
					'description' => '',
				),
				array(
					"type" => "textarea_html",
					"holder" => "div",
					"class" => "",
					"heading" => esc_html__( "Title Content", 'rentax' ),
					"param_name" => "content",
					"value" => esc_html__( "READ our latest blog news", 'rentax' ),
					"description" => esc_html__( "Enter your title content.", 'rentax' ),
				),
				$add_css_animation,
			)
		)
	);
	if ( class_exists( 'WPBakeryShortCode' ) ) {
		class WPBakeryShortCode_Block_Posts extends WPBakeryShortCode {

		}
	}
	//////////////////////////////////////////////////////////////////////



	/// section_3d
	vc_map(
		array(
			"name" => esc_html__( "3D Viewer", 'rentax' ),
			"base" => "section_3d",
			"class" => "pix-theme-icon1",
			"category" => esc_html__( 'Rentax', 'rentax'),
			"params" => array(
				array(
					'type' => 'attach_image',
					'heading' => esc_html__( 'Image', 'rentax' ),
					'param_name' => 'image',
					'value' => '',
					'description' => esc_html__( 'Select image from media library.', 'rentax' )
				),
				array(
					"type" => "textfield",
					"holder" => "div",
					"class" => "",
					"heading" => esc_html__( "Number of frames", 'rentax' ),
					"param_name" => "number",
					"value" => '16',
					"description" => esc_html__( "Default 16", 'rentax' )
				),
			)
		)
	);
	if ( class_exists( 'WPBakeryShortCode' ) ) {
		class WPBakeryShortCode_Section_3d extends WPBakeryShortCode {

		}
	}



	/// section_map
	vc_map(
		array(
			"name" => esc_html__( "Google Map", 'rentax' ),
			"base" => "section_map",
			"class" => "pix-theme-icon",
			"category" => esc_html__( 'Rentax', 'rentax'),
			"params" => array(
				array(
					'type' => 'attach_image',
					'heading' => esc_html__( 'Marker Image', 'rentax' ),
					'param_name' => 'image',
					'value' => '',
					'description' => esc_html__( 'Select image from media library.', 'rentax' )
				),
				array(
					"type" => "textfield",
					"holder" => "div",
					"heading" => esc_html__( "Address", 'rentax' ),
					"param_name" => "address",
					"value" => '',
					"description" => esc_html__( "Example: San Diego, CA", 'rentax' )
				),
				array(
					"type" => "textfield",
					"holder" => "div",
					"heading" => esc_html__( "Map Width", 'rentax' ),
					"param_name" => "width",
					"value" => '',
					"description" => esc_html__( "Default 90%", 'rentax' )
				),
				array(
					"type" => "textfield",
					"holder" => "div",
					"heading" => esc_html__( "Map Height", 'rentax' ),
					"param_name" => "height",
					"value" => '',
					"description" => esc_html__( "Default 500px", 'rentax' )
				),
				array(
					"type" => "textfield",
					"holder" => "div",
					"heading" => esc_html__( "Zoom", 'rentax' ),
					"param_name" => "zoom",
					"value" => '',
					"description" => esc_html__( "Zoom 0-20. Default 8.", 'rentax' )
				),
				array(
					"type" => "dropdown",
					"heading" => esc_html__( "Scroll Wheel", 'rentax' ),
					"param_name" => "scrollwheel",
					'value' => array(
						esc_html__( "Off", 'rentax' ) => 'false',
						esc_html__( "On", 'rentax' ) => 'true',
					),
					"description" => esc_html__( "Zoom map with scroll", 'rentax' )
				),
			)
		)
	);
	if ( class_exists( 'WPBakeryShortCode' ) ) {
		class WPBakeryShortCode_Section_Map extends WPBakeryShortCode {

		}
	}


			
	//////// Carousel Reviews ////////
	vc_map( array(
		'name' => esc_html__( 'Reviews', 'rentax' ),
		'base' => 'section_reviews',
		'class' => 'pix-theme-icon', 
		'as_parent' => array('only' => 'section_review'),
		'content_element' => true,
		'show_settings_on_create' => true,
		'category' => esc_html__( 'Rentax', 'rentax'),
		
		'params' => array(
			array(
				'type' => 'dropdown',
				'heading' => esc_html__( 'Reviews per page', 'rentax' ),
				'param_name' => 'reviews_per_page',
				'value' => array(
					esc_html__( "3", 'rentax' ) => 3,
					esc_html__( "2", 'rentax' ) => 2,
					esc_html__( "1", 'rentax' ) => 1,
				),
				'description' => esc_html__( 'Select number of columns.', 'rentax' )
			),
			array(
				'type' => 'dropdown',
				'heading' => esc_html__( 'Carousel', 'rentax' ),
				'param_name' => 'disable_carousel',
				'value' => array(
					esc_html__('Enable', 'rentax') => 1,
					esc_html__('Disable', 'rentax') => 0,
				),
				'description' => esc_html__( 'On/off carousel', 'rentax' )
			),
		),
		
		
		'js_view' => 'VcColumnView',
		
	) );
	vc_map( array(
		'name' => esc_html__( 'Review', 'rentax' ),
		'base' => 'section_review',
		'class' => 'pix-theme-icon', 
		'as_child' => array('only' => 'section_reviews'),
		'content_element' => true,
		'params' => array(
			array(
				'type' => 'textfield',
				'heading' => esc_html__( 'Title', 'rentax' ),
				'param_name' => 'title',
				'description' => esc_html__( 'Review title.', 'rentax' )
			),
			array(
				'type' => 'attach_image',
				'heading' => esc_html__( 'Image', 'rentax' ),
				'param_name' => 'image',
				'description' => esc_html__( 'Select image.', 'rentax' )
			),
			array(
				'type' => 'textfield',
				'heading' => esc_html__( 'Name', 'rentax' ),
				'param_name' => 'name',
				'description' => esc_html__( 'Person name.', 'rentax' )
			),
			array(
				'type' => 'textfield',
				'heading' => esc_html__( 'Position', 'rentax' ),
				'param_name' => 'position',
				'description' => esc_html__( 'Text under the name.', 'rentax' )
			),
			array(
				"type" => "textarea_html",
				"holder" => "div",
				"class" => "",
				"heading" => esc_html__( "Review Text", 'rentax' ),
				"param_name" => "content",
				"value" => wp_kses_post(__( "<p>I am test text block. Click edit button to change this text.</p>", 'rentax' )),
				"description" => esc_html__( "Enter text.", 'rentax' )
			),
		)
	) );
	if ( class_exists( 'WPBakeryShortCodesContainer' ) ) {
		class WPBakeryShortCode_Section_Reviews extends WPBakeryShortCodesContainer {
		}
	}
	if ( class_exists( 'WPBakeryShortCode' ) ) {
		class WPBakeryShortCode_Section_Review extends WPBakeryShortCode {
		}
	}
	/////////////////////////////////	



	/// section_team
	//////// Our Team ////////
	vc_map( array(
		'name' => esc_html__( 'Team slider', 'rentax' ),
		'base' => 'section_team',
		'class' => 'pix-theme-icon', 
		'as_parent' => array('only' => 'section_team_member'),
		'content_element' => true,
		'show_settings_on_create' => true,
		'category' => esc_html__( 'Rentax', 'rentax'),
		'params' => array(
			array(
				'type' => 'dropdown',
				'heading' => esc_html__( 'Carousel', 'rentax' ),
				'param_name' => 'carousel',
				'value' => array(
					esc_html__( "Disable", 'rentax' ) => 'disable-owl-carousel',
					esc_html__( "Enable", 'rentax' ) => 'owl-carousel enable-owl-carousel',
				),
				'description' => esc_html__( 'On/off carousel', 'rentax' )
			),
			
			$add_css_animation,
		),
		'js_view' => 'VcColumnView',
		
	) );
	vc_map( array(
		'name' => esc_html__( 'Team Member', 'rentax' ),
		'base' => 'section_team_member',
		'class' => 'pix-theme-icon', 
		'as_child' => array('only' => 'section_team'),
		'content_element' => true,
		'params' => array(
			array(
				'type' => 'attach_image',
				'heading' => esc_html__( 'Image', 'rentax' ),
				'param_name' => 'image',
				'description' => esc_html__( 'Select image.', 'rentax' )
			),
			array(
				'type' => 'textfield',
				'heading' => esc_html__( 'Name', 'rentax' ),
				'param_name' => 'name',
				'description' => esc_html__( 'Team member name.', 'rentax' )
			),
			array(
				'type' => 'textfield',
				'heading' => esc_html__( 'Position', 'rentax' ),
				'param_name' => 'position',
				'description' => esc_html__( 'Member position.', 'rentax' )
			),
			array(
				'type' => 'textfield',
				'heading' => esc_html__( 'Skill Level', 'rentax' ),
				'param_name' => 'skill',
				'description' => esc_html__( 'From 0 to 100%', 'rentax' )
			),
			array(
				'type' => 'textfield',
				'heading' => esc_html__( 'Social Link 1', 'rentax' ),
				'param_name' => 'scn1',
				'description' => esc_html__( 'https://www.facebook.com/', 'rentax' )
			),
			array(
				'type' => 'textfield',
				'heading' => esc_html__( 'Social Network Icon 1', 'rentax' ),
				'param_name' => 'scn_icon1',
				'description' => wp_kses_post(__( 'Add icon social_facebook_circle <a href="//fortawesome.github.io/Font-Awesome/icons/" target="_blank">See all icons</a>', 'rentax' )),
			),
			array(
				'type' => 'textfield',
				'heading' => esc_html__( 'Social Link 2', 'rentax' ),
				'param_name' => 'scn2',
				'description' => esc_html__( 'https://twitter.com/', 'rentax' )
			),
			array(
				'type' => 'textfield',
				'heading' => esc_html__( 'Social Network Icon 2', 'rentax' ),
				'param_name' => 'scn_icon2',
				'description' => wp_kses_post(__( 'Add icon social_twitter_circle <a href="//fortawesome.github.io/Font-Awesome/icons/" target="_blank">See all icons</a>', 'rentax' )),
			),
			array(
				'type' => 'textfield',
				'heading' => esc_html__( 'Social Link 3', 'rentax' ),
				'param_name' => 'scn3',
				'description' => esc_html__( 'https://www.pinterest.com/', 'rentax' )
			),
			array(
				'type' => 'textfield',
				'heading' => esc_html__( 'Social Network Icon 3', 'rentax' ),
				'param_name' => 'scn_icon3',
				'description' => wp_kses_post(__( 'Add icon social_pinterest_circle <a href="//fortawesome.github.io/Font-Awesome/icons/" target="_blank">See all icons</a>', 'rentax' )),
			),
			array(
				'type' => 'textfield',
				'heading' => esc_html__( 'Social Link 4', 'rentax' ),
				'param_name' => 'scn4',
				'description' => esc_html__( 'https://plus.google.com/', 'rentax' )
			),
			array(
				'type' => 'textfield',
				'heading' => esc_html__( 'Social Network Icon 4', 'rentax' ),
				'param_name' => 'scn_icon4',
				'description' => wp_kses_post(__( 'Add icon social_googleplus_circle <a href="//fortawesome.github.io/Font-Awesome/icons/" target="_blank">See all icons</a>', 'rentax' )),
			),
			$add_css_animation,
			array(
				"type" => "textarea_html",
				"holder" => "div",
				"class" => "",
				"heading" => esc_html__( "Info", 'rentax' ),
				"param_name" => "content", 
				"value" => wp_kses_post(__( "<p>I am test text block. Click edit button to change this text.</p>", 'rentax' )),
				"description" => esc_html__( "Enter information.", 'rentax' )
			),
		)
	) );
	if ( class_exists( 'WPBakeryShortCodesContainer' ) ) {
		class WPBakeryShortCode_Section_Team extends WPBakeryShortCodesContainer {
		}
	}
	if ( class_exists( 'WPBakeryShortCode' ) ) {
		class WPBakeryShortCode_Section_Team_Member extends WPBakeryShortCode {
		}
	}
	////////////////////////
	
	
	/// section_brands
	vc_map( array(
		'name' => esc_html__( 'Brands Section', 'rentax' ),
		'base' => 'section_brands',
		'class' => 'pix-theme-icon1',
		'as_parent' => array('only' => 'section_brand'),
		'content_element' => true,
		'show_settings_on_create' => true,
		'category' => esc_html__( 'Rentax', 'rentax'),
		'params' => array(
			array(
				'type' => 'textfield',
				'heading' => esc_html__( 'Brands per page', 'rentax' ),
				'param_name' => 'brands_per_page',
				'description' => esc_html__( 'Select number of columns. Default 5.', 'rentax' )
			),
			array(
				'type' => 'dropdown',
				'heading' => esc_html__( 'Carousel', 'rentax' ),
				'param_name' => 'disable_carousel',
				'value' => array(
					esc_html__('Enable', 'rentax') => 1,
					esc_html__('Disable', 'rentax') => 0,
				),
				'description' => esc_html__( 'On/off carousel', 'rentax' )
			),
		),
		'js_view' => 'VcColumnView',

	) );
	vc_map( array(
		'name' => esc_html__( 'Brand', 'rentax' ),
		'base' => 'section_brand',
		'class' => 'pix-theme-icon1',
		'as_child' => array('only' => 'section_brands'),
		'content_element' => true,
		'params' => array(
			array(
				'type' => 'attach_image',
				'heading' => esc_html__( 'Image', 'rentax' ),
				'param_name' => 'image',
				'value' => '',
				'description' => esc_html__( 'Select image from media library.', 'rentax' )
			),
			array(
				"type" => "vc_link",
				"holder" => "div",
				"class" => "",
				"heading" => esc_html__( "url", 'rentax' ),
				"param_name" => "url",
				"value" => esc_html__( "https://wordpress.com", 'rentax' ),
				"description" => '',
			),
		)
	) );
	if ( class_exists( 'WPBakeryShortCodesContainer' ) ) {
		class WPBakeryShortCode_Section_Brands extends WPBakeryShortCodesContainer {
		}
	}
	if ( class_exists( 'WPBakeryShortCode' ) ) {
		class WPBakeryShortCode_Section_Brand extends WPBakeryShortCode {
		}
	}
	////////////////////////
	
	
	//////// Social Buttons ////////
	vc_map( array(
		'name' => esc_html__( 'Social Buttons', 'rentax' ),
		'base' => 'socialbuts',
		'class' => 'pix-theme-icon', 
		'as_parent' => array('only' => 'socialbut'), // Use only|except attributes to limit child shortcodes (separate multiple values with comma)
		'content_element' => true,
		'show_settings_on_create' => false,
		'category' => esc_html__( 'Rentax', 'rentax'),	
		'js_view' => 'VcColumnView',
		'params' => array(),
		
	) );
	$params1 = array(
				array(
					'type' => 'textfield',
					'heading' => esc_html__( 'Title', 'rentax' ),
					'param_name' => 'title',
					'description' => esc_html__( 'Social title.', 'rentax' )
				),
			);
	$params2 = array(
				array(
					'type' => 'vc_link',
					'holder' => 'div',
					'heading' => esc_html__( 'Link', 'rentax' ),
					'param_name' => 'link',
					'description' => esc_html__( 'Social link.', 'rentax' )
				),
			);
	if(!function_exists('fil_init')){
		$params = array_merge($params1, $params2);
	}else{
		$params = array_merge($params1, rentax_get_vc_icons($vc_icons_data), $params2);
	}
	vc_map( array(
		'name' => esc_html__( 'Social Button', 'rentax' ),
		'base' => 'socialbut',
		'class' => 'pix-theme-icon', 
		'as_child' => array('only' => 'socialbuts'),
		'content_element' => true,
		'params' => $params,
	) );
	if ( class_exists( 'WPBakeryShortCodesContainer' ) ) {
		class WPBakeryShortCode_Socialbuts extends WPBakeryShortCodesContainer {
		}
	}
	if ( class_exists( 'WPBakeryShortCode' ) ) {
		class WPBakeryShortCode_Socialbut extends WPBakeryShortCode {
		}
	}
	////////////////////////



	if ( class_exists( 'WooCommerce' ) ) {
		/// section_woocommerce
		//////// Woocommerce Products ////////
		vc_map(
			array(
				"name" => esc_html__( "Woocommerce Products", 'rentax' ),
				"base" => "section_woocommerce",
				"class" => "pix-theme-icon",
				"category" => esc_html__( 'Rentax', 'rentax'),
				"params" => array(
					array(
						'type' => 'checkbox',
						'heading' => esc_html__( 'Categories', 'rentax' ),
						'param_name' => 'cats',
						'value' => $cats_woo,
						'description' => esc_html__( 'Select categories to show', 'rentax' )
					),
					array(
						'type' => 'textfield',
						'heading' => esc_html__( 'Items Count', 'rentax' ),
						'param_name' => 'count',
						'description' => esc_html__( 'Select number products.', 'rentax' )
					),
					array(
						'type' => 'dropdown',
						'heading' => esc_html__( 'Carousel', 'rentax' ),
						'param_name' => 'carousel',
						'value' => array(
							esc_html__( "Enable", 'rentax' ) => 'owl-carousel enable-owl-carousel',
							esc_html__( "Disable", 'rentax' ) => 'disable-owl-carousel',
						),
						'description' => ''
					),
					array(
						'type' => 'dropdown',
						'heading' => esc_html__( 'Slider Controls', 'rentax' ),
						'param_name' => 'controls',
						'value' => array(
							esc_html__( "Default", 'rentax' ) => '',
							esc_html__( "Controls Right", 'rentax' ) => 'full-width-slider-controls-right',
							esc_html__( "Controls Left", 'rentax' ) => 'full-width-slider-controls-left',
						),
						'description' => esc_html__( 'Select controls position.', 'rentax' )
					),
					array(
						'type' => 'textfield',
						'heading' => esc_html__( 'Min slides', 'rentax' ),
						'param_name' => 'min_slides',
						'description' => esc_html__( 'Min slides on page. Default 4.', 'rentax' )
					),
					$add_css_animation,
				)
			)
		);
		if ( class_exists( 'WPBakeryShortCode' ) ) {
			class WPBakeryShortCode_Section_Woocommerce extends WPBakeryShortCode {

			}
		}



		vc_map(
			array(
				"name" => esc_html__( "Woocommerce Category", 'rentax' ),
				"base" => "section_woocommerce_cat",
				"class" => "pix-theme-icon",
				"category" => esc_html__( 'Rentax', 'rentax'),
				"params" => array(
					array(
						'type' => 'checkbox',
						'heading' => esc_html__( 'Categories', 'rentax' ),
						'param_name' => 'cats',
						'value' => $cats_woo,
						'description' => esc_html__( 'Select categories to show', 'rentax' )
					),
					array(
						'type' => 'textfield',
						'heading' => esc_html__( 'Items Count', 'rentax' ),
						'param_name' => 'count',
						'description' => esc_html__( 'Select number products.', 'rentax' )
					),
					array(
						'type' => 'dropdown',
						'heading' => esc_html__( 'Carousel', 'rentax' ),
						'param_name' => 'carousel',
						'value' => array(
							esc_html__( "Enable", 'rentax' ) => 'owl-carousel enable-owl-carousel',
							esc_html__( "Disable", 'rentax' ) => 'disable-owl-carousel',
						),
						'description' => ''
					),
					array(
						'type' => 'dropdown',
						'heading' => esc_html__( 'Slider Controls', 'rentax' ),
						'param_name' => 'controls',
						'value' => array(
							esc_html__( "Default", 'rentax' ) => '',
							esc_html__( "Controls Right", 'rentax' ) => 'full-width-slider-controls-right',
							esc_html__( "Controls Left", 'rentax' ) => 'full-width-slider-controls-left',
						),
						'description' => esc_html__( 'Select controls position.', 'rentax' )
					),
					array(
						'type' => 'textfield',
						'heading' => esc_html__( 'Min slides', 'rentax' ),
						'param_name' => 'min_slides',
						'description' => esc_html__( 'Min slides on page. Default 4.', 'rentax' )
					),
					$add_css_animation,
				)
			)
		);
		if ( class_exists( 'WPBakeryShortCode' ) ) {
			class WPBakeryShortCode_Section_Woocommerce_Cat extends WPBakeryShortCode {

			}
		}
	}
	//} ////// <= End vc_inline


	if ( class_exists( 'Pix_Autos' ) ) {

		$args = array( 'taxonomy' => 'auto-model', 'hide_empty' => '0');
		$auto_model_categories = get_categories($args);
		$auto_models = array();
		$i = 0;
		foreach($auto_model_categories as $category){
			if(is_object($category)){
				if($i==0){
					$default = $category->slug;
					$i++;
				}
				$auto_models[$category->name] = $category->term_id;
			}
		}
		//////// Pixad_Autos Latest Offers ////////
		vc_map( array(
			'name' => esc_html__( 'Latest Autos', 'rentax' ),
			'base' => 'section_autos',
			'class' => 'pix-theme-icon',
			'as_parent' => array('only' => 'section_autos_slide'), // Use only|except attributes to limit child shortcodes (separate multiple values with comma)
			'content_element' => true,
			'show_settings_on_create' => true,
			'category' => esc_html__( 'Rentax', 'rentax'),
			'js_view' => 'VcColumnView',
			'params' => array(
				array(
					'type' => 'dropdown',
					'heading' => esc_html__( 'Slide Type', 'rentax' ),
					'param_name' => 'slide_type',
					'value' => array(
						__('Items by ID', 'rentax') => 'ids',
						__('Items by Date', 'rentax') => 'idate',
					),
					'description' => esc_html__( 'Select items by IDs or latest by date', 'rentax' )
				),
				array(
					'type' => 'dropdown',
					'heading' => esc_html__( 'Items Count', 'rentax' ),
					'param_name' => 'count',
					'value' => array(5, 10, 15, 20, 25),
					'dependency' => array(
						'element' => 'slide_type',
						'value' => array('idate'),
					),
					'description' => esc_html__( 'Select items number to show', 'rentax' ),
				),
				array(
					'type' => 'checkbox',
					'heading' => esc_html__( 'Auto Models', 'rentax' ),
					'param_name' => 'models',
					'value' => $auto_models,
					'description' => esc_html__( 'Select auto models to show', 'rentax' ),
					'dependency' => array(
							'element' => 'slide_type',
							'value' => array('idate'),
					)
				),
				array(
					'type' => 'dropdown',
					'heading' => esc_html__( 'Carousel', 'rentax' ),
					'param_name' => 'carousel',
					'value' => array(
							__('Enable', 'rentax') => 1,
							__('Disable', 'rentax') => 0,
					),
					'description' => esc_html__( 'On/off carousel', 'rentax' )
				),
			),

		) );
		vc_map( array(
			'name' => esc_html__( 'Autos Slide', 'rentax' ),
			'base' => 'section_autos_slide',
			'class' => 'pix-theme-icon',
			'as_child' => array('only' => 'section_autos'),
			'content_element' => true,
			'params' => array(
				array(
					'type' => 'textfield',
					'heading' => esc_html__( 'Main Item ID', 'rentax' ),
					'param_name' => 'item_1',
					'description' => esc_html__( 'Item with large image. Input item ID', 'rentax' ),
				),
				array(
					'type' => 'textfield',
					'heading' => esc_html__( 'Second Item ID', 'rentax' ),
					'param_name' => 'item_2',
					'description' => esc_html__( 'Input item ID', 'rentax' ),
				),
				array(
					'type' => 'textfield',
					'heading' => esc_html__( 'Third Item ID', 'rentax' ),
					'param_name' => 'item_3',
					'description' => esc_html__( 'Input item ID', 'rentax' ),
				),
				array(
					'type' => 'textfield',
					'heading' => esc_html__( 'Fourth Item ID', 'rentax' ),
					'param_name' => 'item_4',
					'description' => esc_html__( 'Input item ID', 'rentax' ),
				),
				array(
					'type' => 'textfield',
					'heading' => esc_html__( 'Fifth Item ID', 'rentax' ),
					'param_name' => 'item_5',
					'description' => esc_html__( 'Input item ID', 'rentax' ),
				),
			)
		) );
		if ( class_exists( 'WPBakeryShortCodesContainer' ) ) {
			class WPBakeryShortCode_Section_Autos extends WPBakeryShortCodesContainer {
			}
		}
		if ( class_exists( 'WPBakeryShortCode' ) ) {
			class WPBakeryShortCode_Section_Autos_Slide extends WPBakeryShortCode {
			}
		}


		$args = array( 'taxonomy' => 'auto-body', 'hide_empty' => '0');
		$auto_categories = get_categories($args);
		$auto_cats = array();
		$i = 0;
		foreach($auto_categories as $category){
			if(is_object($category)){
				$auto_cats[$category->name] = $category->slug;
			}
		}
		//////// Pixad_Autos Body Types ////////
		vc_map(
			array(
				"name" => esc_html__( "Auto Body Types", 'rentax' ),
				"base" => "section_autos_cat",
				"class" => "pix-theme-icon",
				"category" => esc_html__( 'Rentax', 'rentax'),
				"params" => array(
					array(
						'type' => 'checkbox',
						'heading' => esc_html__( 'Body Types', 'rentax' ),
						'param_name' => 'cats',
						'value' => $auto_cats,
						'description' => esc_html__( 'Select body types to show', 'rentax' )
					),
					array(
						'type' => 'textfield',
						'heading' => esc_html__( 'Offer Text', 'rentax' ),
						'param_name' => 'offers',
						'value' => esc_html__( 'Offers', 'rentax' ),
						'description' => esc_html__( 'Offers number text', 'rentax' ),
					),
					$add_css_animation,
				)
			)
		);
		if ( class_exists( 'WPBakeryShortCode' ) ) {
			class WPBakeryShortCode_Section_Autos_Cat extends WPBakeryShortCode {

			}
		}
	}
	//} ////// <= End vc_inline


///////////////////////////////////// Standart Pix-Theme Widgets /////////////////////////////////////

	/// box_icon
	$params1 = array(
				array(
					"type" => "textfield",
					"holder" => "div",
					"class" => "",
					"heading" => esc_html__( "Title", 'rentax' ),
					"param_name" => "title",
					"value" => esc_html__( "I am title", 'rentax' ),
					"description" => esc_html__( "Add Title ", 'rentax' )
				),
			);
	$params2 = array(
				array(
					'type' => 'dropdown',
					'heading' => esc_html__( 'Icon Position', 'rentax' ),
					'param_name' => 'position',
					'value' => array(
						esc_html__( "Left", 'rentax' ) => 'icon-left',
						esc_html__( "Right", 'rentax' ) => 'icon-right',
						esc_html__( "Center", 'rentax' ) => 'icon-center',
					),
					'description' => '',
				),
				array(
					'type' => 'vc_link',
					'holder' => 'div',
					'class' => '',
					'heading' => esc_html__( 'Link', 'rentax' ),
					'param_name' => 'link',
					'value' => esc_html__( 'https:/rentax.com', 'rentax' ),
					'description' => esc_html__( 'Button link', 'rentax' )
				),
				array(
					'type' => 'textfield',
					'holder' => 'div',
					'class' => '',
					'heading' => esc_html__( 'Button Text', 'rentax' ),
					'param_name' => 'btn_text',
					'value' => '',
					'description' => '',
				),
				$add_css_animation,
				array(
					"type" => "textarea_html",
					"holder" => "div",
					"class" => "",
					"heading" => esc_html__( "Content", 'rentax' ),
					"param_name" => "content",
					"value" => wp_kses_post(__( "<p>I am test text block. Click edit button to change this text.</p>", 'rentax' )),
					"description" => esc_html__( "Enter your content.", 'rentax' )
				)
			);
	if(!function_exists('fil_init')){
		$params = array_merge($params1, $params2);
	}else{
		$params = array_merge($params1, rentax_get_vc_icons($vc_icons_data), $params2);
	}
	


	if(isset($_GET['vc_action']) && $_GET['vc_action'] == 'vc_inline'){
		wp_enqueue_style('rentax-theme', get_stylesheet_directory_uri() . '/css/editor_styles.css');
	}

	return true;
	
}


?>