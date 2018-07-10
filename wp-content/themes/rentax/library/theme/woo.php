<?php

/********** WOOCOMERCE **********/
add_filter( 'woocommerce_enqueue_styles', '__return_empty_array' );

add_filter( 'loop_shop_per_page', create_function( '$cols', 'return '.rentax_get_option('rentax_products_per_page','6').';' ), 20 );

if (!function_exists('rentax_loop_columns')) {
	function rentax_loop_columns() {
		return 3; // 3 products per row
	}
}
add_filter('loop_shop_columns', 'rentax_loop_columns');


function rentax_product_cat_register_meta() {
	//register_meta( 'term', 'cat_icon', 'rentax_sanitize_cat_icon' );
}
/**
 * Sanitize the details custom meta field.
 *
 * @param  string $details The existing details field.
 * @return string          The sanitized details field
 */

function rentax_sanitize_cat_icon( $cat_icon ) {
	return esc_attr( $cat_icon );
}

add_action( 'product_cat_add_form_fields', 'rentax_product_cat_add_details_meta' );
/**
 * Add a details metabox to the Add New Product Category page.
 *
 * For adding a details metabox to the WordPress admin when
 * creating new product categories in WooCommerce.
 *
 */
function rentax_product_cat_add_details_meta() {
	wp_nonce_field( basename( __FILE__ ), 'rentax_product_cat_details_nonce' );
	?>
	<div class="form-field">
		<label for="rentax-product-cat_icon"><?php esc_html_e( 'Icon Class', 'rentax' ); ?></label>
		<input name="rentax-product-cat_icon" id="rentax-product-cat_icon">
		<p class="description"><?php esc_html_e( 'Icon class for category (auto15)', 'rentax' ); ?></p>
	</div>
	<?php
}

add_action( 'product_cat_edit_form_fields', 'rentax_product_cat_edit_details_meta' );
/**
 * Add a details metabox to the Edit Product Category page.
 *
 * For adding a details metabox to the WordPress admin when
 * editing an existing product category in WooCommerce.
 *
 * @param  object $term The existing term object.
 */
function rentax_product_cat_edit_details_meta( $term ) {
	$product_cat_icon = get_woocommerce_term_meta( $term->term_id, 'cat_icon', true );
	if ( ! $product_cat_icon ) {
		$product_cat_icon = '';
	}

	?>
	<tr class="form-field">
		<th scope="row" valign="top"><label for="rentax-product-cat_icon"><?php esc_html_e( 'Icon', 'rentax' ); ?></label></th>
		<td>
			<?php wp_nonce_field( basename( __FILE__ ), 'rentax_product_cat_details_nonce' ); ?>
			<input type="text" name="rentax-product-cat_icon" id="rentax-product-cat_icon" value="<?php echo esc_attr( $product_cat_icon ) ? esc_attr( $product_cat_icon ) : ''; ?>">
			<p class="description"><?php esc_html_e( 'Icon class for category (auto15)', 'rentax' ); ?></p>
		</td>
	</tr>
	<?php
}

add_action( 'create_product_cat', 'rentax_product_cat_details_meta_save' );
add_action( 'edit_product_cat', 'rentax_product_cat_details_meta_save' );
/**
 * Save Product Category details meta.
 *
 * Save the product_cat details meta POSTed from the
 * edit product_cat page or the add product_cat page.
 *
 * @param  int $term_id The term ID of the term to update.
 */
function rentax_product_cat_details_meta_save( $term_id ) {
	if ( ! isset( $_POST['rentax_product_cat_details_nonce'] ) || ! wp_verify_nonce( $_POST['rentax_product_cat_details_nonce'], basename( __FILE__ ) ) ) {
		return;
	}
	$old_details = get_woocommerce_term_meta( $term_id, 'cat_icon', true );
	$new_details = isset( $_POST['rentax-product-cat_icon'] ) ? $_POST['rentax-product-cat_icon'] : '';
	if ( $old_details && '' === $new_details ) {
		delete_woocommerce_term_meta( $term_id, 'cat_icon' );
	} else if ( $old_details !== $new_details ) {
		update_woocommerce_term_meta(
			$term_id,
			'cat_icon',
			rentax_sanitize_cat_icon( $new_details )
		);
	}
}


function rentax_is_woo_page () {
        if(  function_exists ( "is_woocommerce" ) && is_woocommerce()){
                return true;
        }
        $woocommerce_keys   =   array ( "woocommerce_shop_page_id" ,
                                        "woocommerce_terms_page_id" ,
                                        "woocommerce_cart_page_id" ,
                                        "woocommerce_checkout_page_id" ,
                                        "woocommerce_pay_page_id" ,
                                        "woocommerce_thanks_page_id" ,
                                        "woocommerce_myaccount_page_id" ,
                                        "woocommerce_edit_address_page_id" ,
                                        "woocommerce_view_order_page_id" ,
                                        "woocommerce_change_password_page_id" ,
                                        "woocommerce_logout_page_id" ,
                                        "woocommerce_lost_password_page_id" ) ;
        foreach ( $woocommerce_keys as $wc_page_id ) {
                if ( get_the_ID () == get_option ( $wc_page_id , 0 ) ) {
                        return true ;
                }
        }
        return false;
}
