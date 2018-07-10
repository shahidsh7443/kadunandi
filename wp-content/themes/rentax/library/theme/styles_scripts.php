<?php

add_action('wp_enqueue_scripts', 'rentax_load_styles_and_scripts');
add_filter('body_class','rentax_browser_body_class');

// Enqueue the Google fonts
function rentax_fonts_url() {
	$fonts_url = '';

	/* Translators: If there are characters in your language that are not
	* supported by Raleway, translate this to 'off'. Do not translate
	* into your own language.
	*/
	$raleway = esc_html_x( 'on', 'Exo font: on or off', 'rentax' );

	if ( 'off' !== $raleway ) {
		$font_families = array();

		if ( 'off' !== $raleway ) {
			$font_families[] = 'Exo:100,200,300,400,500,600,700,800,900|Ubuntu:400,700';
		}

		$query_args = array(
		'family' => urlencode( implode( '|', $font_families ) ),
		'subset' => urlencode( 'latin,latin-ext' )
		);

		$fonts_url = add_query_arg( $query_args, 'https://fonts.googleapis.com/css' );
	}

	return esc_url_raw( $fonts_url );
}

function rentax_load_styles_and_scripts(){

    wp_enqueue_style('style', get_stylesheet_uri());

    /* PRIMARY CSS */
    wp_enqueue_style('rentax-master', get_stylesheet_directory_uri() . '/css/master.css');
   

    if ( class_exists( 'WooCommerce' )){
        wp_enqueue_style('woocommerce', get_template_directory_uri() . '/woocommerce/assets/css/woocommerce.css');
        wp_enqueue_style('woocommerce-layout', get_template_directory_uri() . '/woocommerce/assets/css/woocommerce-layout.css');
    }
	
    /* PLUGIN CSS */
    wp_enqueue_style('owl', get_stylesheet_directory_uri() . '/assets/owl-carousel/owl.carousel.css');
    wp_enqueue_style('owltheme', get_stylesheet_directory_uri() . '/assets/owl-carousel/owl.theme.css');
    wp_enqueue_style('prettyphoto', get_stylesheet_directory_uri() . '/assets/prettyphoto/css/prettyPhoto.css');
    wp_enqueue_style('isotope', get_stylesheet_directory_uri() . '/assets/isotope/isotope.css');
    wp_enqueue_style('nouislider_css', get_stylesheet_directory_uri() . '/assets/nouislider/jquery.nouislider.css');

    wp_enqueue_style('rentax-fonts', rentax_fonts_url());
    wp_enqueue_style('font-awesome', get_template_directory_uri() . '/fonts/fontawesome/css/font-awesome.min.css');

    /* MAIN CSS */

    /* HEADER CSS */
    wp_enqueue_style('rentax-header', get_template_directory_uri() . '/assets/header/header.css');
    wp_enqueue_style('rentax-header-yamm', get_template_directory_uri() . '/assets/header/yamm.css');

    // jQuery
    wp_enqueue_script('migrate', get_template_directory_uri() . '/js/jquery-migrate-1.2.1.js', array('jquery') , '3.3', false);

    // Bootstrap Core JavaScript
    wp_enqueue_script('bootstrap', get_template_directory_uri() . '/assets/bootstrap/js/bootstrap.min.js', array('jquery') , '3.3', false);
    wp_enqueue_script('modernizr', get_template_directory_uri() . '/js/modernizr.custom.js', array('jquery') , '3.3', false);
    wp_enqueue_script( 'smoothscroll', get_template_directory_uri() . '/js/smoothscroll.min.js', array('jquery') , NULL, true );

    if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}

	wp_enqueue_script( 'html5shiv', get_template_directory_uri() . '/js/html5shiv.js' );
	wp_script_add_data( 'html5shiv', 'conditional', 'lt IE 9' );

    // User agent
    wp_enqueue_script('cssua', get_template_directory_uri() . '/js/cssua.min.js', array() , '3.3', true);

    // Waypoint
    wp_enqueue_script('waypoints', get_template_directory_uri() . '/js/waypoints.min.js', array() , '3.3', true);

    // Isotope filter
    wp_enqueue_script('isotope', get_template_directory_uri() . '/assets/isotope/jquery.isotope.min.js', array() , '3.3', true);
    wp_enqueue_script('masonry', get_template_directory_uri() . '/assets/events/masonry.pkgd.min.js', array() , '3.3', true);
    wp_enqueue_script('easypiechart', get_template_directory_uri() . '/assets/rendro-easy-pie-chart/jquery.easypiechart.min.js', array() , '3.3', true);
// Nouislider
    wp_enqueue_script('nouislider_js', get_template_directory_uri() . '/assets/nouislider/nouislider.min.js', array() , '3.3', true);
    wp_enqueue_script('wNumb', get_template_directory_uri() . '/assets/nouislider/wNumb.min.js', array() , '3.3', true);


    // Owl Carousel
    wp_enqueue_script('owl-carousel', get_template_directory_uri() . '/assets/owl-carousel/owl.carousel.min.js', array() , '3.3', true);

    // Jelect
    wp_enqueue_script('jelect', get_template_directory_uri() . '/assets/jelect/jquery.jelect.js', array() , '3.3', true);
	
	// Jarallax
	wp_register_script('jarallax', get_template_directory_uri() . '/assets/jarallax/jarallax.js', array('jquery') , '3.3', true);

    // Flexslider
    wp_enqueue_script('flexslider', get_template_directory_uri() . '/assets/flexslider/jquery.flexslider.js', array() , '3.3', true);

    // Google Maps
    //wp_enqueue_script('google-maps', rentax_google_map_url(), array( 'jquery' ), null , true);

     // Flexslider
    wp_enqueue_script('rentax-degrees360js', get_template_directory_uri() . '/assets/degrees360/js/main.js', array() , '1.1', true);
    wp_enqueue_style('rentax-degrees360css', get_stylesheet_directory_uri() . '/assets/degrees360/css/style.css');

    wp_enqueue_script('slidebar', get_template_directory_uri() . '/assets/header/slidebar.js', array('jquery') , '1.1', true);
    wp_enqueue_script('rentax-header', get_template_directory_uri() . '/assets/header/header.js', array('jquery') , '1.1', true);
    wp_enqueue_script('slidebars', get_template_directory_uri() . '/assets/header/slidebars.js', array('jquery') , '1.1', true);

    wp_enqueue_script('prettyphoto', get_template_directory_uri() . '/assets/prettyphoto/js/jquery.prettyPhoto.js', array() , '3.1.6', true);

    wp_enqueue_script('rentax-custom', get_template_directory_uri() . '/js/custom.js', array() , '1.1', true);

    wp_enqueue_style('rentax-dynamic-styles', admin_url('admin-ajax.php').'?action=dynamic_styles&pageID='.get_the_ID());

}

function rentax_google_map_url() {
	$query_args = array(
		'sensor' => urlencode( 'false' ),
	);
	$map_url = add_query_arg( $query_args, 'http://maps.googleapis.com/maps/api/js' );
	return esc_url_raw( $map_url );
}

function rentax_dynamic_styles() {
	include( get_template_directory().'/css/dynamic-styles.php' );
	exit;
}
add_action('wp_ajax_dynamic_styles', 'rentax_dynamic_styles');
add_action('wp_ajax_nopriv_dynamic_styles', 'rentax_dynamic_styles');

function rentax_browser_body_class($classes = '') {
    $classes[] = 'animated-css';
    $classes[] = 'layout-switch';

    if (rentax_get_option('header_settings_type')){
        $headerType = rentax_get_option('header_settings_type');
        $classes[] =  'home-construction-v' . $headerType;
    }

    return $classes;
}

?>