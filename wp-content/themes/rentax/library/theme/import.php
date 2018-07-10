<?php

function rentax_import_files() {
    return array(
		array(
            'import_file_name'              => esc_html__( 'Rentax Theme', 'rentax' ),
            'local_import_file'             => get_template_directory().'/library/demo-files/content.xml',
            'local_import_widget_file'      => '',
            'local_import_customizer_file'  => '',
            'import_preview_image_url'      => '',
            'import_notice'                 => '',
        ),
    );
}
add_filter( 'pt-ocdi/import_files', 'rentax_import_files' );


function rentax_after_import( $selected_import ) {

    $menu_arr = array();
    $main_menu = get_term_by('name', 'main', 'nav_menu');
    if(is_object($main_menu))
        $menu_arr['primary_nav'] = $main_menu->term_id;
    set_theme_mod( 'nav_menu_locations', $menu_arr );

    set_theme_mod( 'rentax_header_menu_add_position', 'left' );

    update_option("pixad_body_thumbsedans", content_url().'/uploads/2016/05/sedan.png');
    update_option("pixad_body_thumbluxury-cars", content_url().'/uploads/2016/05/lux.png');
    update_option("pixad_body_thumbsuvs", content_url().'/uploads/2016/05/suv.png');
    update_option("pixad_body_thumbsports", content_url().'/uploads/2016/05/sport.png');
    update_option("pixad_body_thumbtaxi-sedans", content_url().'/uploads/2016/05/sedantax.png');
    update_option("pixad_body_thumbtaxi-suvs", content_url().'/uploads/2016/05/suvt.png');

    $slider_array = array(
        get_template_directory()."/library/revslider/home_slider.zip",
    );

    $front_page_id = get_page_by_title( 'Home' );
    $blog_page_id  = get_page_by_title( 'Blog' );

    update_option( 'show_on_front', 'page' );
    update_option( 'page_on_front', $front_page_id->ID );
    update_option( 'page_for_posts', $blog_page_id->ID );
    set_theme_mod( 'rentax_footer_block', '2279' );

    $absolute_path = __FILE__;
    $path_to_file = explode( 'wp-content', $absolute_path );
    $path_to_wp = $path_to_file[0];

    require_once( $path_to_wp.'/wp-load.php' );
    require_once( $path_to_wp.'/wp-includes/functions.php');

    $slider = new RevSlider();

    foreach($slider_array as $filepath){
     $slider->importSliderFromPost(true,true,$filepath);
    }

}
add_action( 'pt-ocdi/after_import', 'rentax_after_import' );

?>