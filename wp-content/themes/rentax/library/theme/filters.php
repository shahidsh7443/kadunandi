<?php
/**
 * The template for registering metabox.
 *
 * @package PixTheme
 * @since 1.0
 */

add_filter( 'rentax_header_settings', 'rentax_header_settings_var' );
function rentax_header_settings_var( $post_ID=0 ){

	$rentax['page_layout'] = isset($post_ID) && $post_ID>0 && get_post_meta($post_ID, 'page_layout', 1) != '' ? get_post_meta($post_ID, 'page_layout', 1) : rentax_get_option('page_layout','wide');

	/// Header global parameters
	$rentax['header_type'] = isset($post_ID) && $post_ID>0 && get_post_meta($post_ID, 'header_type', 1) != '' ? get_post_meta($post_ID, 'header_type', 1) : rentax_get_option('header_type','header1');
	$rentax['header_sidebar_view'] = $rentax['header_type'] == 'header3' ? (get_post_meta($post_ID, 'header_sidebar_view', 1) != '' ? get_post_meta($post_ID, 'header_sidebar_view', 1) : rentax_get_option('header_sidebar_view','fixed')) : '';
	$rentax['header_background'] = isset($post_ID) && $post_ID>0 && get_post_meta($post_ID, 'header_background', 1) != '' ? get_post_meta($post_ID, 'header_background', 1) : (rentax_get_option('header_background','trans-black'));
	$rentax['header_transparent'] = isset($post_ID) && $post_ID>0 && get_post_meta($post_ID, 'header_transparent', 1) != '' ? get_post_meta($post_ID, 'header_transparent', 1) : rentax_get_option('header_transparent','0');
	$rentax['header_hover_effect'] = isset($post_ID) && $post_ID>0 && get_post_meta($post_ID, 'header_hover_effect', 1) != '' ? get_post_meta($post_ID, 'header_hover_effect', 1) : rentax_get_option('header_hover_effect','0');
	$rentax['header_marker'] = isset($post_ID) && $post_ID>0 && get_post_meta($post_ID, 'header_marker', 1) != '' ? get_post_meta($post_ID, 'header_marker', 1) : rentax_get_option('header_marker','menu-marker-arrow');
	$rentax['header_layout'] = isset($post_ID) && $post_ID>0 && get_post_meta($post_ID, 'header_layout', 1) != '' ? get_post_meta($post_ID, 'header_layout', 1) : rentax_get_option('header_layout','normal');
	$rentax['header_bar'] = isset($post_ID) && $post_ID>0 && get_post_meta($post_ID, 'header_bar', 1) != '' ? get_post_meta($post_ID, 'header_bar', 1) : rentax_get_option('header_bar','0');
	$rentax['header_sticky'] = isset($post_ID) && $post_ID>0 && get_post_meta($post_ID, 'header_sticky', 1) != '' ? get_post_meta($post_ID, 'header_sticky', 1) : rentax_get_option('header_sticky','sticky');
	$rentax['mobile_sticky'] = isset($post_ID) && $post_ID>0 && get_post_meta($post_ID, 'mobile_sticky', 1) != '' ? get_post_meta($post_ID, 'mobile_sticky', 1) : rentax_get_option('mobile_sticky','');

	/// Header menu settings
	$rentax['header_menu'] = isset($post_ID) && $post_ID>0 && get_post_meta($post_ID, 'header_menu', 1) != '' ? get_post_meta($post_ID, 'header_menu', 1) : rentax_get_option('header_menu','1');
	$rentax['header_menu_add'] = isset($post_ID) && $post_ID>0 && get_post_meta($post_ID, 'header_menu_add', 1) != '' ? get_post_meta($post_ID, 'header_menu_add', 1) : rentax_get_option('header_menu_add','');
	$rentax['header_menu_add_position'] = isset($post_ID) && $post_ID>0 && get_post_meta($post_ID, 'header_menu_add_position', 1) != '' ? get_post_meta($post_ID, 'header_menu_add_position', 1) : rentax_get_option('header_menu_add_position','disable');
	$rentax['header_menu_animation'] = isset($post_ID) && $post_ID>0 && get_post_meta($post_ID, 'header_menu_animation', 1) != '' ? get_post_meta($post_ID, 'header_menu_animation', 1) : rentax_get_option('header_menu_animation','overlay');

	/// Header widgets
	$rentax['header_minicart'] = isset($post_ID) && $post_ID>0 && get_post_meta($post_ID, 'header_minicart', 1) != '' ? get_post_meta($post_ID, 'header_minicart', 1) : rentax_get_option('header_minicart','1');
	$rentax['header_search'] = isset($post_ID) && $post_ID>0 && get_post_meta($post_ID, 'header_search', 1) != '' ? get_post_meta($post_ID, 'header_search', 1) : rentax_get_option('header_search','1');
	$rentax['header_socials'] = isset($post_ID) && $post_ID>0 && get_post_meta($post_ID, 'header_socials', 1) != '' ? get_post_meta($post_ID, 'header_socials', 1) : rentax_get_option('header_socials','1');


	$class = '';
	foreach($rentax as $key => $val){
		if(!in_array($key, array('header_transparent', 'header_sticky', 'mobile_sticky', 'header_menu_animation')))
		$class .= $val.'-';
	}
	$rentax['header_uniq_class'] = substr($class, 0, -1);

	$rentax['header_phone'] = isset($post_ID) && $post_ID>0 && get_post_meta($post_ID, 'header_phone', 1) != '' ? get_post_meta($post_ID, 'header_phone', 1) : rentax_get_option('header_phone', '');
	$rentax['header_email'] = isset($post_ID) && $post_ID>0 && get_post_meta($post_ID, 'header_email', 1) != '' ? get_post_meta($post_ID, 'header_email', 1) : rentax_get_option('header_email', '');

	/// Header elements position
	$rentax['header_topbarbox_1_position'] = isset($post_ID) && $post_ID>0 && get_post_meta($post_ID, 'header_topbarbox_1_position', 1) != '' ? get_post_meta($post_ID, 'header_topbarbox_1_position', 1) : rentax_get_option('header_topbarbox_1_position','left',0);
	$rentax['header_topbarbox_2_position'] = isset($post_ID) && $post_ID>0 && get_post_meta($post_ID, 'header_topbarbox_2_position', 1) != '' ? get_post_meta($post_ID, 'header_topbarbox_2_position', 1) : rentax_get_option('header_topbarbox_2_position','right',0);
	$rentax['header_navibox_1_position'] = isset($post_ID) && $post_ID>0 && get_post_meta($post_ID, 'header_navibox_1_position', 1) != '' ? get_post_meta($post_ID, 'header_navibox_1_position', 1) : rentax_get_option('header_navibox_1_position','left');
	$rentax['header_navibox_2_position'] = isset($post_ID) && $post_ID>0 && get_post_meta($post_ID, 'header_navibox_2_position', 1) != '' ? get_post_meta($post_ID, 'header_navibox_2_position', 1) : rentax_get_option('header_navibox_2_position','right');
	$rentax['header_navibox_3_position'] = isset($post_ID) && $post_ID>0 && get_post_meta($post_ID, 'header_navibox_3_position', 1) != '' ? get_post_meta($post_ID, 'header_navibox_3_position', 1) : rentax_get_option('header_navibox_3_position','right');
	$rentax['header_navibox_4_position'] = isset($post_ID) && $post_ID>0 && get_post_meta($post_ID, 'header_navibox_4_position', 1) != '' ? get_post_meta($post_ID, 'header_navibox_4_position', 1) : rentax_get_option('header_navibox_4_position','right');

	/// Responsive
	$rentax['mobile_sticky'] = isset($post_ID) && $post_ID>0 && get_post_meta($post_ID, 'mobile_sticky', 1) != '' ? get_post_meta($post_ID, 'mobile_sticky', 1) : rentax_get_option('mobile_sticky','');
	$rentax['mobile_topbar'] = isset($post_ID) && $post_ID>0 && get_post_meta($post_ID, 'mobile_topbar', 1) != '' ? get_post_meta($post_ID, 'mobile_topbar', 1) : rentax_get_option('mobile_topbar','');
	$rentax['tablet_minicart'] = isset($post_ID) && $post_ID>0 && get_post_meta($post_ID, 'tablet_minicart', 1) != '' ? get_post_meta($post_ID, 'tablet_minicart', 1) : rentax_get_option('tablet_minicart','');
	$rentax['tablet_search'] = isset($post_ID) && $post_ID>0 && get_post_meta($post_ID, 'tablet_search', 1) != '' ? get_post_meta($post_ID, 'tablet_search', 1) : rentax_get_option('tablet_search','');
	$rentax['tablet_phone'] = isset($post_ID) && $post_ID>0 && get_post_meta($post_ID, 'tablet_phone', 1) != '' ? get_post_meta($post_ID, 'tablet_phone', 1) : rentax_get_option('tablet_phone','');
	$rentax['tablet_socials'] = isset($post_ID) && $post_ID>0 && get_post_meta($post_ID, 'tablet_socials', 1) != '' ? get_post_meta($post_ID, 'tablet_socials', 1) : rentax_get_option('tablet_socials','');


	/// Logo
	$rentax['logo'] = isset($post_ID) && $post_ID>0 && get_post_meta($post_ID, 'header_logo', 1) != '' ? get_post_meta($post_ID, 'header_logo', 1) : rentax_get_option('general_settings_logo','');
	$rentax['logo_inverse'] = isset($post_ID) && $post_ID>0 && get_post_meta($post_ID, 'header_logo_inverse', 1) != '' ? get_post_meta($post_ID, 'header_logo_inverse', 1) : rentax_get_option('general_settings_logo_inverse','');


	return $rentax;
}


function rentax_footer_script( $script ){
	$out = '';
	if( get_theme_mods('rentax_header_adm_bar') ){
		$out .= "
		<script>
			jQuery(document).ready(function($){
				$('html').addClass('html-margin-top');
                $('#wpadminbar').addClass('wpadmin-opacity');
            });
         </script>";
	}
	if ( !empty($script) ) {
		$out .= $script;
	}
	return $out;
}
add_filter( 'rentax_script_footer', 'rentax_footer_script' );


function rentax_footer_envato() {
	$show = rentax_get_option('envato_show', '0');
	$currency = rentax_get_option('envato_currency', '');
	$price = rentax_get_option('envato_price', '');
	$link = rentax_get_option('envato_link', '');
	if($show && $price != '')
    echo '
	<div class="promo-set">
	    <a href="'.esc_url($link).'" class="envato-logo-small"></a>
	    <a href="'.esc_url($link).'" class="envato-promo-link"><span class="currency-promo">'.wp_kses_post($currency).'</span>'.wp_kses_post($price).'</a>
	</div>
';
}
add_action( 'wp_footer', 'rentax_footer_envato' );


add_filter('rwmb_meta_boxes', 'rentax_register_meta_boxes');
function rentax_register_meta_boxes( $meta_boxes ) {
	
    $meta_boxes[] = array(
        'id' => 'post_format',
        'title' => esc_html__( 'Post Format Options', 'rentax' ),
        'post_types' => array( 'post' ),
        'context' => 'normal',
        'priority' => 'low',
        'fields' => array(
            array(
                'name' => esc_html__('Post Standared:', 'rentax' ),
                'id'   => 'post_standared',
                'type' => 'file_advanced',
                'max_file_uploads' => 4,
                'mime_type' => 'application,audio,video,image',
            ),
            array(
                'name' => esc_html__('Post Gallery:','rentax'),
                'id'   => 'post_gallery',
                'type' => 'plupload_image',
                'max_file_uploads' => 25,
            ),
            array(
                'name'  => esc_html__('Quote Source:', 'rentax'),
                'id'    => 'post_quote_source',
                'desc'  => '',
                'type'  => 'text',
                'std'   => '',
            ),
            array(
                'name'  => esc_html__('Quote Content:', 'rentax'),
                'id'    => 'post_quote_content',
                'desc'  => '',
                'type'  => 'textarea',
                'std'   => '',
            ),
            array(
                'name'  => esc_html__('Video','rentax'),
                'id'    => 'post_video',
                'desc'  => 'Video URL',
                'type'  => 'textarea',
                'std'   => '',
            )
        )

    );

    return $meta_boxes;
}