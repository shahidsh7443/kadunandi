<?php
global $post;
/**
 * Shortcode attributes
 * @var $atts
 * @var $cats
 * @var $offers
 * @var $css_animation
 * Shortcode class
 * @var $this WPBakeryShortCode_Section_Autos_Cat
 */

$atts = vc_map_get_attributes( $this->getShortcode(), $atts );
extract( $atts );

$figure = '';

if( $cats == '' ):
	$out = '<p>'.esc_html__('No Body Types selected. To fix this, please login to your WP Admin area and set the body types you want to show by editing this shortcode and setting one or more body types in the multi checkbox field "Body Types".', 'rentax');
else:

$out = $css_animation != '' ? '<div class="animated" data-animation="' . esc_attr($css_animation) . '">' : '<div>';
$out .= '

	';

$out .= '</div>';
endif;
echo $out;
?>
<ul class="list-type" id="dislist">

	<li class="list-type__item">
		<a class="list-type__link" href="http://localhost/kadunandi/auto-body/sedans/">
			<div class="list-type__inner">
				<img src="http://localhost/kadunandi/wp-content/uploads/2018/07/sedan.png" alt="Sedans">
				<div class="decor-1 center-block"></div>
				<div class="list-type__name">Sedans</div>
				<div class="list-type__info">25 Sedans </div>
			</div>
		</a>
	</li>

	<li class="list-type__item">
		<a class="list-type__link" href="http://localhost/kadunandi/auto-body/luxury-cars/">
			<div class="list-type__inner">
				<img src="http://localhost/kadunandi/wp-content/uploads/2018/07/innova1-1.png" alt="Luxury Cars">
				<div class="decor-1 center-block"></div>
				<div class="list-type__name">Innova</div>
				<div class="list-type__info">25 Innova </div>
			</div>
		</a>
	</li>

	<li class="list-type__item">
		<a class="list-type__link" href="http://localhost/kadunandi/auto-body/suvs/">
			<div class="list-type__inner">
				<img src="http://localhost/kadunandi/wp-content/uploads/2018/07/crysta-3.png" alt="SUVS">
				<div class="decor-1 center-block"></div>
				<div class="list-type__name">Innova Crysta</div>
				<div class="list-type__info">5 Innova Crysta</div>
			</div>
		</a>
	</li>

	<li class="list-type__item">
		<a class="list-type__link" href="http://localhost/kadunandi/auto-body/sports/">
			<div class="list-type__inner">
				<img src="http://localhost/kadunandi/wp-content/uploads/2018/07/tempo-4.png" alt="Sports">
				<div class="decor-1 center-block"></div>
				<div class="list-type__name">Tempo Traveller</div>
				<div class="list-type__info">5 Tempo Traveller</div>
			</div>
		</a>
	</li>

	<li class="list-type__item">
		<a class="list-type__link" href="http://localhost/kadunandi/auto-body/taxi-sedans/">
			<div class="list-type__inner">
				<img src="http://localhost/kadunandi/wp-content/uploads/2018/07/Buus-3.png" alt="Taxi Sedans">
				<div class="decor-1 center-block"></div>
				<div class="list-type__name">Bus</div>
				<div class="list-type__info">5 Bus </div>
			</div>
		</a>
	</li>

</ul>
