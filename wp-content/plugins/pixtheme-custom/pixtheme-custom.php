<?php
/***********************************

	Plugin Name:  PixthemeCustom
	Plugin URI:   http://templines.com/
	Description:  Additional functionality for PixTheme
	Version:      1.0
	Author:       PixTheme
	Author URI:   http://templines.com
	License:      GPLv2 or later	
	Text Domain:  PixThemeCustom
	Domain Path:  /languages/
	
***********************************/
if ( ! defined( 'ABSPATH' ) ) {
	exit; // disable direct access
}

/** Register widget for brands */


require_once('pixtheme-custom-widgets.php');
require_once('shortcode.php');

function register_pixtheme_custom_widget() {
    if (class_exists('YITH_WCBR')){
        register_widget( 'Pixtheme_Brands_Widget' );
    }
	if (class_exists('YITH_WCBR')){
		register_widget( 'Pixtheme_StaticBlock_Widget' );
	}
}
add_action( 'widgets_init', 'register_pixtheme_custom_widget' );


if ( ! class_exists( 'PixthemeCustom' ) ) :

/************* STATICBLOCK ***************/

	class PixthemeCustom {
		
		static function pixtheme_init(){
			$labels = array(
				'name'               => _x( 'Static Blocks', 'post type general name', 'PixTheme' ),
				'singular_name'      => _x( 'Static Block', 'post type singular name', 'PixTheme' ),
				'menu_name'          => _x( 'Static Blocks', 'admin menu', 'PixTheme' ),
				'name_admin_bar'     => _x( 'Static Block', 'add new on admin bar', 'PixTheme' ),
				'add_new'            => _x( 'Add New', 'book', 'PixTheme' ),
				'add_new_item'       => __( 'Add New Block', 'PixTheme' ),
				'new_item'           => __( 'New Block', 'PixTheme' ),
				'edit_item'          => __( 'Edit Block', 'PixTheme' ),
				'view_item'          => __( 'View Block', 'PixTheme' ),
				'all_items'          => __( 'All Blocks', 'PixTheme' ),
				'search_items'       => __( 'Search Block', 'PixTheme' ),
				'parent_item_colon'  => __( 'Parent Block:', 'PixTheme' ),
				'not_found'          => __( 'No blocks found.', 'PixTheme' ),
				'not_found_in_trash' => __( 'No blocks found in Trash.', 'PixTheme' )
			);
	
			$args = array(
				'labels'             => $labels,
				'public'             => true,
				'publicly_queryable' => true,
				'show_ui'            => true,
				'show_in_menu'       => true,
				'query_var'          => true,
				'rewrite'            => array( 'slug' => 'staticblock' ),
				'capability_type'    => 'post',
				'has_archive'        => 'staticblocks',
				'hierarchical'       => false,
				'menu_position'      => 8,
				'supports'           => array( 'title', 'editor',  'thumbnail', 'page-attributes', 'comments' ),
				'menu_icon'			 => get_template_directory_uri() . "/images/pix-static.png"
			);
		
	
	        register_post_type( 'staticblocks', $args );
		}
		
		
		
		
		
		

		
		
	}
	
	if(!function_exists('pix_show_productpage_static_block')) {
			function pix_show_productpage_static_block() {
			    $product = get_post(get_the_ID());
				// Do not show this on variable products
				if ( $product->product_type <> 'variable' ) {
					$args = array(
						'post_type'        => 'staticblocks',
						'post_status'      => 'publish',
					);
					$staticBlocksData = get_posts( $args );
					foreach($staticBlocksData as $_block){
						$staticBlocks[$_block->ID] = $_block->post_title;
					}
				
				
					
		
					
					$staticblock = get_post_meta( $product->ID, '_static_bottom', true );
		
					echo '<div class="show_if_simple show_if_variable">';
					pixtheme_wp_select_multiple( array( 
						'id' => '_static_bottom', 
						'label' => __( 'Static Block Description', 'PixTheme' ), 
						'options' => $staticBlocks, 
						'name' => '_static_bottom[]',
						'desc_tip' => true, 
						'description' => __( 'Select the block to display at the bottom of the product page' , 'PixTheme'),
						'value' => explode(",",$staticblock)
					) );
			
					echo '</div>';
				}
			}
		}
		
		
		if(!function_exists('pixtheme_add_bottom_block_product')) {
			function pixtheme_add_bottom_block_product() {
				$output = "";
				$product = get_post(get_the_ID());
				$staticblockIDs = get_post_meta( $product->ID, '_static_bottom', true );
				$staticblockIDsExploded = explode(',',$staticblockIDs);
				foreach($staticblockIDsExploded as $_staticblockID){
					if (!is_numeric($_staticblockID)) continue;
					$staticblock = get_post($_staticblockID);
					$output .= '<div class="container">' . apply_filters( 'the_content',$staticblock->post_content) . '</div>';
				}
				
				echo $output;
			}
		}
		
		
		
		if(!function_exists('pixtheme_woocommerce_product_quick_edit_save')) {
			function pixtheme_woocommerce_product_quick_edit_save($product_id){
				
				if ( isset( $_REQUEST['_static_bottom'] ) ){
					if (!get_post_meta( $product_id, '_static_bottom', true )){
						add_post_meta($product_id, '_static_bottom', wc_clean( implode(",",$_REQUEST['_static_bottom'] )));
					}else{
						update_post_meta( $product_id, '_static_bottom', wc_clean( implode(",",$_REQUEST['_static_bottom'] )) );	
					}
					
				}else{
					if (get_post_meta( $product_id, '_static_bottom', true )){
						update_post_meta( $product_id, '_static_bottom', wc_clean( "," ) );	
					}
				}
			}
		}
				
		
		
		
		if(!function_exists('pixtheme_staticblocks_get')) {
		    function pixtheme_staticblocks_get () {
		        $return_array = array();
		        $args = array( 'post_type' => 'staticblocks', 'posts_per_page' => 30);     
				$myposts = get_posts( $args );
		        $i=0;
		        foreach ( $myposts as $post ) {
		            $i++;
		            $return_array[$i]['label'] = get_the_title($post->ID);
		            $return_array[$i]['value'] = $post->ID;
		        } 
		        wp_reset_postdata();
		        return $return_array;
		    }
		}
		
		
		if(!function_exists('pixtheme_staticblocks_show')) {
		    function pixtheme_staticblocks_show ($id = false) {
		        echo pixtheme_staticblocks_single($id);
		    }
		}
		
		
		if(!function_exists('pixtheme_staticblocks_single')) {
		    function pixtheme_staticblocks_single($id = false) {
		    	if(!$id) return;
		    	
		    	$output = false;
		    	
		    	$output = wp_cache_get( $id, 'pixtheme_staticblocks_single' );
		    	
			    if ( !$output ) {
			   
			        $args = array( 'include' => $id,'post_type' => 'staticblocks', 'posts_per_page' => 1);
			        $output = '';
			        $myposts = get_posts( $args );
			        foreach ( $myposts as $post ) {
			        	setup_postdata($post);
						
			        	$output = do_shortcode(get_the_content($post->ID));
			        	
						$shortcodes_custom_css = get_post_meta( $post->ID, '_wpb_shortcodes_custom_css', true );
						if ( ! empty( $shortcodes_custom_css ) ) {
							$output .= '<style type="text/css" data-type="vc_shortcodes-custom-css">';
							$output .= $shortcodes_custom_css;
							$output .= '</style>';
						}
			        } 
			        wp_reset_postdata();
			        
			        wp_cache_add( $id, $output, 'pixtheme_staticblocks_single' );
			    }
			    
		        return $output;
		   }
		}
		
		
		


function pixtheme_post_type_link_filter_function( $post_link, $id = 0, $leavename = FALSE ) {
    if ( strpos('%portfolio_category%', $post_link)  < 0 ) {
      return $post_link;
    }
    $post = get_post($id);
    if ( !is_object($post) || $post->post_type != 'portfolio' ) {
      return $post_link;
    }
    $terms = wp_get_object_terms($post->ID, 'portfolio_category');
    if ( !$terms ) {
      return str_replace('portfolio/category/%portfolio_category%/', '', $post_link);
    }
    return str_replace('%portfolio_category%', $terms[0]->slug, $post_link);
}
  
add_filter('post_type_link', 'pixtheme_post_type_link_filter_function', 1, 3);


		
		
		
endif;



add_action( 'init', array('PixthemeCustom','pixtheme_init') );
add_action( 'woocommerce_product_options_advanced', 'pix_show_productpage_static_block', 55 );
add_action('save_post','pixtheme_woocommerce_product_quick_edit_save');
add_action('woocommerce_after_single_product_summary','pixtheme_add_bottom_block_product',15);


/************** Multiselect Field***************/
function pixtheme_wp_select_multiple( $field ) {
    global $thepostid, $post, $woocommerce;

    $thepostid              = empty( $thepostid ) ? $post->ID : $thepostid;
    $field['class']         = isset( $field['class'] ) ? $field['class'] : 'select short';
    $field['wrapper_class'] = isset( $field['wrapper_class'] ) ? $field['wrapper_class'] : '';
    $field['name']          = isset( $field['name'] ) ? $field['name'] : $field['id'];
    $field['value']         = isset( $field['value'] ) ? $field['value'] : ( get_post_meta( $thepostid, $field['id'], true ) ? get_post_meta( $thepostid, $field['id'], true ) : array() );

    echo '<p class="form-field ' . esc_attr( $field['id'] ) . '_field ' . esc_attr( $field['wrapper_class'] ) . '"><label for="' . esc_attr( $field['id'] ) . '">' . wp_kses_post( $field['label'] ) . '</label><select id="' . esc_attr( $field['id'] ) . '" name="' . esc_attr( $field['name'] ) . '" class="' . esc_attr( $field['class'] ) . '" multiple="multiple">';

    foreach ( $field['options'] as $key => $value ) {

        echo '<option value="' . esc_attr( $key ) . '" ' . ( in_array( $key, $field['value'] ) ? 'selected="selected"' : '' ) . '>' . esc_html( $value ) . '</option>';

    }

    echo '</select> ';

    if ( ! empty( $field['description'] ) ) {

        if ( isset( $field['desc_tip'] ) && false !== $field['desc_tip'] ) {
            echo '<img class="help_tip" data-tip="' . esc_attr( $field['description'] ) . '" src="' . esc_url( WC()->plugin_url() ) . '/assets/images/help.png" height="16" width="16" />';
        } else {
            echo '<span class="description">' . wp_kses_post( $field['description'] ) . '</span>';
        }

    }
    echo '</p>';
}
/********************************************/


?>