<?php
if( ! defined( 'ABSPATH' ) ) 
	exit; // Exit if accessed directly

while ( $rentax_loop->have_posts() ) : $rentax_loop->the_post();
	$pixad_out .= '
	<article class="card clearfix" id="post-'.get_the_ID().'">
		<div class="card__img">';
			if( has_post_thumbnail() ):
				$pixad_out .= '<a href="'.get_the_permalink().'">
					'.get_the_post_thumbnail( get_the_ID(), 'rentax-auto-cat', array('class' => 'img-responsive')).'
				</a>';
			else:
				$pixad_out .= '<img class="no-image" src="'.PIXAD_AUTO_URI .'assets/img/no_image.jpg" alt="no-image">';
			endif;
			if( get_post_meta(get_the_ID(), 'pixad_auto_featured', true) ){
				$pixad_out .= '<span class="card__wrap-label"><span class="card__label">'.wp_kses_post(get_post_meta(get_the_ID(), 'pixad_auto_featured', true)).'</span></span>';
			}
	$pixad_out .= '
		</div>
		<div class="card__inner">
			<h2 class="card__title ui-title-inner"><a href="'.get_the_permalink().'" title="'.esc_attr($strip_title).'">'.get_the_title().'</a></h2>
			<div class="decor-1"></div>
			<div class="card__description">
				<p>'.get_the_excerpt().'</p>
			</div>
			<!-- Car Details -->
			<ul class="card__list list-unstyled">';

			if( $validate['auto-fuel_show'] ):
			$pixad_out .= '
				<li class="card-list__row">
				  <span class="card-list__title">'.esc_html__( 'Fuel:', 'rentax' ).'</span>';

				  if( $this->get_meta('_auto_fuel') ):
					$pixad_out .= '<span class="card-list__info">'.wp_kses_post(( $this->get_meta('_auto_fuel') )).'</span>';
				  endif;
			$pixad_out .= '
				</li>';
			endif;

				if( $validate['auto-mileage_show'] ):
			$pixad_out .= '
				<li class="card-list__row"><!-- Mileage -->
				  <span class="card-list__title">'.esc_html__( 'Mileage:', 'rentax' ).'</span>';

				  if( $this->get_meta('_auto_mileage') ):
					$pixad_out .= '<span class="card-list__info">'.number_format($this->get_meta('_auto_mileage')).'</span>';
				  endif;
			$pixad_out .= '
				</li>';
				endif;

				if( $validate['auto-year_show'] ):
			$pixad_out .= '
				<li class="card-list__row">
				  <span class="card-list__title">'.esc_html__( 'Year:', 'rentax' ).'</span>';

				  if( $this->get_meta('_auto_year') ):
					$pixad_out .= '<span class="card-list__info">'.wp_kses_post($this->get_meta('_auto_year')).'</span>';
				  endif;
			$pixad_out .= '
				</li>';
				endif;

//				if( $validate['seller-country_show'] ):
//
//			$pixad_out .= '
//				<li class="card-list__row">
//				  <span class="card-list__title">'.esc_html__( 'Location:', 'rentax' ).'</span>';
//
//
////				  if( $this->get_meta('_seller_country') ):
////					$pixad_out .= '<span class="card-list__info">'.$country->text_output( $this->get_meta('_seller_country') ).'</span>';
////				  endif;
//			$pixad_out .= '
//				</li>';
//				endif;

				if( $validate['auto-condition_show'] && $this->get_meta('_auto_condition') ):
			$pixad_out .= '
					<li class="card-list__row">
						<span class="card-list__title">'.esc_html__( 'Condition:', 'rentax' ).'</span>';
					if( $this->get_meta('_auto_condition') == 'used' ):
						$pixad_out .= '<span class="card-list__info">'.esc_html__( 'Used', 'rentax' ).'</span>';
					else:
						$pixad_out .= '<span class="card-list__info">'.esc_html__( 'New', 'rentax' ).'</span>';
					endif;
			$pixad_out .= '
					</li>';
				endif;

				if( $validate['auto-drive_show'] && $this->get_meta('_auto_drive') ):
			$pixad_out .= '
					<li class="card-list__row">
						<span class="card-list__title">'.esc_html__( 'Drive:', 'rentax' ).'</span>';
					if( $this->get_meta('_auto_drive') == 'left' ):
						$pixad_out .= '<span class="card-list__info">'.esc_html__( 'Left drive', 'rentax' ).'</span>';
					else:
						$pixad_out .= '<span class="card-list__info">'.esc_html__( 'Right drive', 'rentax' ).'</span>';
					endif;
			$pixad_out .= '
					</li>';
				endif;

				if( $validate['auto-engine_show'] && $this->get_meta('_autoesc_html_engine') ):
			$pixad_out .= '
					<li class="card-list__row">
						<span class="card-list__title">'.esc_html__( 'Engine:', 'rentax' ).'</span>
						<span class="card-list__info">'.wp_kses_post($this->get_meta('_autoesc_html_engine')).' '.esc_html__( 'cm3', 'rentax' ).'</span>
					</li>';
				endif;

				if( $validate['auto-horsepower_show'] && $this->get_meta('_auto_horsepower') ):
			$pixad_out .= '
					<li class="card-list__row">
						<span class="card-list__title">'.esc_html__( 'Horsepower:', 'rentax' ).'</span>
						<span class="card-list__info">'.wp_kses_post($this->get_meta('_auto_horsepower')).' '.esc_html__( 'hp', 'rentax' ).'</span>
					</li>';
				endif;

				if( $validate['auto-doors_show'] && $this->get_meta('_auto_doors') ):
			$pixad_out .= '
					<li class="card-list__row">
						<span class="card-list__title">'.esc_html__( 'Doors :', 'rentax' ).'</span>
						<span class="card-list__info">'.wp_kses_post($this->get_meta('_auto_doors')).' '.esc_html__( 'doors', 'rentax' ).'</span>
					</li>';
				endif;

				if( get_the_date() ):
				$pixad_out .= '<li><span>'.get_the_date().'</span></li>';
				endif;

			$pixad_out .= '
			</ul><!-- / Car Details -->';

			if( $validate['auto-price_show'] ):
				$pixad_out .= '<div class="card__price">'.esc_html__( 'Price / month:' , 'rentax').'<span class="card__price-number">'.wp_kses_post($this->get_price()).'</span></div>';
			endif;

	$pixad_out .= '
		</div>

	</article>';
endwhile;

$pixad_out .= $this->pagenavi($rentax_loop->max_num_pages, $_REQUEST['paged']);

?>
