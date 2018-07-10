<?php
global $post;
/**
 * Shortcode attributes
 * @var $atts
 * @var $carousel
 * @var $slide_type
 * @var $count
 * @var $models
 * Shortcode class
 * @var $this WPBakeryShortCode_Section_Autos
 */

$atts = vc_map_get_attributes( $this->getShortcode(), $atts );
extract( $atts );

$slide_type = !empty($slide_type) ? $slide_type : 'ids';
$carousel = $carousel == 1 ? 'owl-carousel enable-owl-carousel' : '';

$out = '<div>';
$out .= '
			<div class="slider-grid '.esc_attr($carousel).' owl-theme owl-theme_mod-c" data-pagination="true" data-single-item="true" data-auto-play="7000" data-transition-style="fade" data-main-text-animation="true" data-after-init-delay="3000" data-after-move-delay="1000" data-stop-on-hover="true">
			';
$Auto = new PIXAD_Autos();
if( $slide_type == 'ids' ) :

	preg_match_all( '/section_autos_slide([^\]]+)/i', $content, $matches, PREG_OFFSET_CAPTURE );
	$tab_titles = array();
	if ( isset( $matches[1] ) ) {
		$tab_titles = $matches[1];
	}

	$tabs_ids = array();

	foreach ( $tab_titles as $tab ) {
		$tab_atts = shortcode_parse_atts( $tab[0] );
		$tabs_ids[] = isset( $tab_atts['item_1'] ) ? $tab_atts['item_1'] : 0;
		$tabs_ids[] = isset( $tab_atts['item_2'] ) ? $tab_atts['item_2'] : 0;
		$tabs_ids[] = isset( $tab_atts['item_3'] ) ? $tab_atts['item_3'] : 0;
		$tabs_ids[] = isset( $tab_atts['item_4'] ) ? $tab_atts['item_4'] : 0;
		$tabs_ids[] = isset( $tab_atts['item_5'] ) ? $tab_atts['item_5'] : 0;
	}

	$args = array(
		'post_type' => 'pixad-autos',
		'orderby' => 'post__in',
		'post__in' => $tabs_ids,
		'posts_per_page' => 25,
	);

else :

	$models_to_query = get_objects_in_term( explode( ",", $models ), 'auto-model');
	$args = array(
				'post_type' => 'pixad-autos',
				'orderby' => 'date',
				'post__in' => $models_to_query,
				'order' => 'DESC',
			);
	if( is_numeric($count) )
		$args['showposts'] = $count;
	else
		$args['posts_per_page'] = 5;
endif;

	$wp_query = new WP_Query( $args );

	if ($wp_query->have_posts()):
		$i = $j = 0;
		while ($wp_query->have_posts()) :

						$class = ($i % 5) == 0 ? 'rentax_latest_item_feature' : 'rentax_latest_item';
						$wp_query->the_post();

						$featured = get_post_meta($post->ID, 'pixad_auto_featured', true) != '' ? '<a class="slider-grid__btn btn btn-default btn-effect" href="javascript:void(0);"><span class="btn-inner">'.esc_html__('FEATURED', 'rentax').'</span></a>' : '';

						$link = get_the_permalink($post->ID);

						$thumbnail = get_the_post_thumbnail($post->ID, $class, array('class' => 'img-responsive'));

						$Auto->Query_Args( array('auto_id' => $post->ID) );
if( $i % 5 == 0 ){
$out .= '

			<div class="slider-grid__item">
                <div class="row">
                  <div class="col-md-5">
                    <div class="slider-grid__inner slider-grid__inner_mod-a">
                        <a href="'.esc_url($link).'">'.wp_kses_post($thumbnail).'</a>
                        '.$featured.'
                        <div class="slider-grid__wrap-name">
                            <span class="slider-grid__name">'.wp_kses_post(get_the_title()).'</span>
                            <span class="slider-grid__price">'.wp_kses_post($Auto->get_price()).'</span>
                        </div>
                    </div>
                  </div>';
} elseif( $i % 5 == 1 ) {
$out .= '

                  <div class="col-md-7">
                    <div class="row">
                      <div class="col-sm-6">
                        <div class="slider-grid__inner slider-grid__inner_mod-b">
                            <a href="'.esc_url($link).'">'.wp_kses_post($thumbnail).'</a>
                            <span class="slider-grid__name">'.wp_kses_post(get_the_title()).'</span>
                            <a href="'.esc_url($link).'">
								<div class="slider-grid__hover">
									<span class="slider-grid__price">'.wp_kses_post($Auto->get_price()).'</span>
									<ul class="slider-grid__info list-unstyled">
										<li><i class="icon icon-speedometer"></i>'.wp_kses_post($Auto->get_meta('_auto_mileage')).'</li>
										<li><i class="icon icon-paper-plane"></i>'.wp_kses_post($Auto->get_meta('_auto_year')).'</li>
									</ul>
								</div>
							</a>
                        </div>
                      </div>';
} elseif( $i % 5 == 2 ) {
$out .= '
                      <div class="col-sm-6">
                        <div class="slider-grid__inner slider-grid__inner_mod-b">
                            <a href="'.esc_url($link).'">'.wp_kses_post($thumbnail).'</a>
                            <span class="slider-grid__name">'.wp_kses_post(get_the_title()).'</span>
                            <a href="'.esc_url($link).'">
								<div class="slider-grid__hover">
									<span class="slider-grid__price">'.wp_kses_post($Auto->get_price()).'</span>
									<ul class="slider-grid__info list-unstyled">
										<li><i class="icon icon-speedometer"></i>'.wp_kses_post($Auto->get_meta('_auto_mileage')).'</li>
										<li><i class="icon icon-paper-plane"></i>'.wp_kses_post($Auto->get_meta('_auto_year')).'</li>
									</ul>
								</div>
							</a>
                        </div>
                      </div>
                    </div>';
} elseif( $i % 5 == 3 ) {
$out .= '
                    <div class="row">
                      <div class="col-sm-6">
                        <div class="slider-grid__inner slider-grid__inner_mod-b">
                            <a href="'.esc_url($link).'">'.wp_kses_post($thumbnail).'</a>
                            <span class="slider-grid__name">'.wp_kses_post(get_the_title()).'</span>
                            <a href="'.esc_url($link).'">
								<div class="slider-grid__hover">
									<span class="slider-grid__price">'.wp_kses_post($Auto->get_price()).'</span>
									<ul class="slider-grid__info list-unstyled">
										<li><i class="icon icon-speedometer"></i>'.wp_kses_post($Auto->get_meta('_auto_mileage')).'</li>
										<li><i class="icon icon-paper-plane"></i>'.wp_kses_post($Auto->get_meta('_auto_year')).'</li>
									</ul>
								</div>
							</a>
                        </div>
                      </div>';
} elseif( $i % 5 == 4 ) {
	$out .= '
                      <div class="col-sm-6">
                        <div class="slider-grid__inner slider-grid__inner_mod-b">
	                        <a href="' . esc_url($link) . '">' . wp_kses_post($thumbnail) . '</a>
                            <span class="slider-grid__name">' . wp_kses_post(get_the_title()) . '</span>
                            <a href="'.esc_url($link).'">
								<div class="slider-grid__hover">
									<span class="slider-grid__price">' . wp_kses_post($Auto->get_price()) . '</span>
									<ul class="slider-grid__info list-unstyled">
										<li><i class="icon icon-speedometer"></i>' . wp_kses_post($Auto->get_meta('_auto_mileage')) . '</li>
										<li><i class="icon icon-paper-plane"></i>' . wp_kses_post($Auto->get_meta('_auto_year')) . '</li>
									</ul>
								</div>
							</a>
                        </div>
                      </div>';

$out .= '
                    </div>
                  </div>
                </div>
              </div>
        ';
}
			$i++;
		endwhile;
	endif;
 
$out .= '            
		</div>
	</div>';

echo $out;