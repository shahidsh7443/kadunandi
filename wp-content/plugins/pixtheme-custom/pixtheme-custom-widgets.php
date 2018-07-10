<?php

// prevent direct file access
if( ! defined( 'ABSPATH' ) ) {
    header( 'Status: 403 Forbidden' );
    header( 'HTTP/1.1 403 Forbidden' );
    exit;
}



class Pixtheme_Brands_Widget extends WP_Widget {


    function __construct() {

        parent::__construct(
            'Pixtheme_Brands_Widget',
            __( 'Pixtheme Brands Widget', 'pixtheme-brands-widget' ),
            array(
                'description' => __( 'Displays your brand list in widget', 'pixtheme-brands-widget' ),
            )
        );
    }

    public function widget( $args, $instance ) {

        $title = isset( $instance['title'] ) ? $instance['title'] : '';
        $count = isset( $instance['count'] ) ? $instance['count'] : 2;
        $title = apply_filters( 'widget_title', $title );

        echo $args['before_widget'];

        if ( ! empty( $title ) ) {
            echo $args['before_title'] . $title . $args['after_title'];
        }

        $html = '<div class="product-sidebar-slider product-brand-container vertical-slider slide-controls-top">
                <ul class="bxslider" data-mode="vertical" data-slide-margin="0" data-min-slides="'.$count.'" data-move-slides="1" data-pager="false" data-pager-custom="null" data-controls="true">';

        $brands = $this->getBrandsAll();
        foreach ($brands as $_brand){
            $thumbnail_id = absint( get_woocommerce_term_meta( $_brand->term_id, 'thumbnail_id', true ) );

            if ( $thumbnail_id ) {
                $image = wp_get_attachment_image_src( $thumbnail_id, 'yith_wcbr_logo_size' );
                $html .= '<li>
                        <a class="product-brand_item" href="'.esc_url(get_term_link( $_brand )).'">
                            <img src="'.esc_url($image[0]).'" alt="'.esc_attr($_brand->name).'">
                        </a>
                    </li>';
            }else{
                $html .= '<li>
                        <a class="product-brand_item" href="'.esc_url(get_term_link( $_brand )).'">
                            '.esc_attr($_brand->name).'
                        </a>
                    </li>';
            }

        }

        $html .= '</ul></div>';

        echo $html;

        echo $args['after_widget'];
    }

    public function form( $instance ) {
        $count = isset( $instance['count'] ) ? $instance['count'] : 2;
        $title = isset( $instance['title'] ) ? $instance['title'] : 'Brands';
        ?>
        <p>
            <label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e( 'Title:', 'pixtheme-brands-widget' ); ?></label>
            <input class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" type="text" value="<?php echo esc_attr( $title ); ?>" />
        </p>
        <p>
            <label for="<?php echo $this->get_field_id( 'count' ); ?>"><?php _e( 'Count:', 'pixtheme-brands-widget' ); ?></label>
            <input class="widefat" id="<?php echo $this->get_field_id( 'count' ); ?>" name="<?php echo $this->get_field_name( 'count' ); ?>" type="text" value="<?php echo esc_attr( $count ); ?>" />
        </p>
        <?php
    }


    public function update( $new_instance, $old_instance ) {
        $instance = array();
        $instance['title'] = ( ! empty( $new_instance['title'] ) ) ? sanitize_text_field( $new_instance['title'] ) : '';
        $instance['count'] = ( ! empty( $new_instance['count'] ) ) ? sanitize_text_field( $new_instance['count'] ) : 2;
        return $instance;
    }

    private function getBrandsAll(){
        $taxonomies = array('yith_product_brand');
        $args = array(
            'fields'            => 'all',

        );
        $terms = get_terms($taxonomies, $args);
        return $terms;
    }

}



class Pixtheme_StaticBlock_Widget extends WP_Widget {


    function __construct() {

        parent::__construct(
            'Pixtheme_StaticBlock_Widget',
            __( 'Pixtheme Static Block Widget', 'pixtheme-staticblock-widget' ),
            array(
                'description' => __( 'Displays your static block in widget', 'pixtheme-staticblock-widget' ),
            )
        );
    }

    public function widget( $args, $instance ) {

        $title = isset( $instance['title'] ) ? $instance['title'] : '';
        $blockId = isset( $instance['block_id'] ) ? $instance['block_id'] : 0;
        $title = apply_filters( 'widget_title', $title );

        echo $args['before_widget'];

        /*if ( ! empty( $title ) ) {
            echo $args['before_title'] . $title . $args['after_title'];
        }*/

        $html = '<div class="product-sidebar-block sidebar-product">';

        $html .= pixtheme_get_staticblock_content($blockId);

        $html .= '</div>';

        echo $html;

        echo $args['after_widget'];
    }

    public function form( $instance ) {
        $title = isset( $instance['title'] ) ? $instance['title'] : 'Static Block';
        $blockId = isset( $instance['block_id'] ) ? $instance['block_id'] : '';
        $blocks = $this->getBlocksAll();


        ?>
        <p>
            <label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e( 'Title:', 'pixtheme-staticblock-widget' ); ?></label>
            <input class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" type="text" value="<?php echo esc_attr( $title ); ?>" />
        </p>

        <p>
            <label for="<?php echo $this->get_field_id( 'block_id' ); ?>"><?php _e( 'Static Block:', 'pixtheme-staticblock-widget' ); ?></label>
            <select class="widefat" id="<?php echo $this->get_field_id( 'block_id' ); ?>" name="<?php echo $this->get_field_name( 'block_id' ); ?>">
                <?php foreach ($blocks as $block):?>
                    <option <?php if ($blockId == $block->ID):?>selected="selected"<?php endif;?> value=<?php echo $block->ID?>""><?php echo $block->post_title?></option>
                <?php endforeach?>
            </select>
        </p>



        <?php
    }


    public function update( $new_instance, $old_instance ) {
        $instance = array();
        $instance['title'] = ( ! empty( $new_instance['title'] ) ) ? sanitize_text_field( $new_instance['title'] ) : '';
        $instance['block_id'] = ( ! empty( $new_instance['block_id'] ) ) ? sanitize_text_field( $new_instance['block_id'] ) : '';
        return $instance;
    }

    private function getBlocksAll(){
        $args = array(
            'post_type'        => 'staticblocks',
            'post_status'      => 'publish',
        );

        $blocks = get_posts($args);

        return $blocks;
    }

}
