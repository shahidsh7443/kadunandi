<?php 
	/**  Theme_index  **/

	/* Define library Theme path */

    $rentax_themeFiles = array(
        'styles_scripts',
        'functions',
		'filters',
	    'vc_templates',
	    'blog',
	    'comment_walker',
		'menu_walker',
		'woo',
	    'pagenavi',
        'import'
    );

    rentax_load_files($rentax_themeFiles, '/library/theme/');


	add_action('after_setup_theme', 'rentax_theme_support_setup');
	//add_theme_support( 'wc-product-gallery-zoom' );
    add_theme_support( 'wc-product-gallery-lightbox' );
    add_theme_support( 'wc-product-gallery-slider' );
	function rentax_theme_support_setup(){
		add_theme_support('rentax_customize_opt');
		add_theme_support('default_customize_opt');
		add_image_size('rentax-auto-thumb', 117, 66, true);
		add_image_size('rentax-thumb', 117, 66, false);
		add_image_size('rentax-body-thumb', 200, 130, false);
		add_image_size('rentax-auto-cat', 235, 196, true);
	    add_image_size('rentax-auto-single', 850, 480, false);
	    add_image_size('rentax_latest_item_feature', 470, 392, true);
	    add_image_size('rentax_latest_item', 320, 181, true);
	    add_image_size('rentax-post-thumb', 470, 280, true);
	}

	if ( ! isset( $content_width ) ) {
		$content_width = 1200;
	}

?>