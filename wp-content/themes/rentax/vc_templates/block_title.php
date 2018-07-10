<?php
/**
 * Shortcode attributes
 * @var $atts
 * @var $title
 * @var $after_title
 * @var $titlepos
 * @var $title_color
 * @var $css_animation
 * Shortcode class
 * @var $this WPBakeryShortCode_Block_Title
 */
$atts = vc_map_get_attributes( $this->getShortcode(), $atts );
extract( $atts );

$titlepos = $titlepos == '' ? 'text-center' : $titlepos;
$pix_title_class = 'pix'.rand();
$color = $title_color == '' ? '' : ' <style scoped> .'.$pix_title_class.' *{color: '.esc_attr($title_color).'}</style>';
$fullcontent = ($content == '') ? '' : '<div class="ui-subtitle-block_mod-a '.esc_attr($titlepos).'">'.do_shortcode($content).'</div>';

$out = $css_animation != '' ? '<div class="animated" data-animation="' . esc_attr($css_animation) . '">' : '';
$out .= '

	<div class="section-title-box '.esc_attr($pix_title_class).'" >
		'.$color.'
		<h2 class="ui-title-block ui-title-block_mod-a '.esc_attr($titlepos).'">'.wp_kses_post($title).'</h2>
        '.$fullcontent.'
	</div>
  		';
$out .= $css_animation != '' ? '</div>' : '';
echo $out;
