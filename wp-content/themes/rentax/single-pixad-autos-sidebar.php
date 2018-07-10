 <?php /* The Template for displaying all single autos. */
global $post;

$Settings = new PIXAD_Settings();
$validate = $Settings->getSettings( 'WP_OPTIONS', '_pixad_autos_validation', true ); // Get validation settings
$validate = pixad::validation( $validate );
$Auto = new PIXAD_Autos();
$Auto->Query_Args( array('auto_id' => $post->ID) );

$has_video = false;

$video_attachments = array();
$videos = pixad_get_attach_video($post->ID);
//$videos = explode(',', $videos[0]);
if(isset($videos[0]) && $videos[0] != '') {
	$video_attachments = get_posts( array(
		'post_type' => 'attachment',
		'include' => $videos[0]
	) );
}

if(count($video_attachments)>0 || pixad_get_external_video($post->ID) != '') {
	$has_video = true;
}

$custom =  get_post_custom($post->ID);

$pix_options = get_option('pix_general_settings');

?>
<div class="col-md-4">
	<aside class="sidebar">
		<section class="widget">
			<h3 class="widget-title"><?php  esc_html_e( 'Specifications', 'rentax' ) ?></h3>
			<div class="decor-1"></div>
			<div class="widget-content">
				<dl class="list-descriptions list-unstyled">
					<?php if( $Auto->get_make() ): ?>
					<!-- Make -->
						<dt><?php esc_html_e( 'Make:', 'rentax' ); ?></dt>
						<dd><?php echo wp_kses_post( $Auto->get_make()) ?></dd>
					<?php endif; ?>
					
					<?php if( $Auto->get_model() ): ?>
					<!-- Model -->
						<dt><?php esc_html_e( 'Model:', 'rentax' ); ?></dt>
						<dd class="right"><?php echo wp_kses_post( $Auto->get_model()) ?></dd>
					<!-- / Model -->
					<?php endif; ?>

					<?php if( $validate['auto-year_show'] && $Auto->get_meta('_auto_year') ): ?>
					<!-- Made Year -->
						<dt class="left"><?php esc_html_e( 'Made Year:', 'rentax' ); ?></dt>
						<dd class="right"><?php echo wp_kses_post( $Auto->get_meta('_auto_year')) ?></dd>
					<!-- / Made Year -->
					<?php endif; ?>
					
					<?php if( $validate['auto-mileage_show'] && $Auto->get_meta('_auto_mileage') ): ?>
					<!-- Mileage -->
						<dt class="left"><?php esc_html_e( 'Mileage:', 'rentax' ); ?></dt>
						<dd class="right"><?php echo number_format($Auto->get_meta('_auto_mileage')); ?></dd>
					<!-- / Mileage -->
					<?php endif; ?>
					
					<?php if( $validate['auto-vin_show'] && $Auto->get_meta('_auto_vin') ): ?>
					<!-- VIN -->
						<dt class="left"><?php esc_html_e( 'VIN:', 'rentax' ); ?></dt>
						<dd class="right"><?php echo wp_kses_post( $Auto->get_meta('_auto_vin')) ?></dd>
					<!-- / VIN -->
					<?php endif; ?>
					
					<?php if( $validate['auto-version_show'] && $Auto->get_meta('_auto_version') ): ?>
					<!-- Version -->
						<dt class="left"><?php esc_html_e( 'Version:', 'rentax' ); ?></dt>
						<dd class="right"><?php echo wp_kses_post( $Auto->get_meta('_auto_version')) ?></dd>
					<!-- / Version -->
					<?php endif; ?>
					
					<?php if( $validate['auto-fuel_show'] && $Auto->get_meta('_auto_fuel') ): ?>
					<!-- Fuel -->
						<dt class="left"><?php esc_html_e( 'Fuel:', 'rentax' ); ?></dt>
						<dd class="right"><?php echo wp_kses_post( $Auto->get_meta('_auto_fuel')); ?></dd>
					<!-- / Fuel -->
					<?php endif; ?>
					
					<?php if( $validate['auto-engine_show'] && $Auto->get_meta('_auto_engine') ): ?>
					<!-- Engine -->
						<dt class="left"><?php esc_html_e( 'Engine (cm3):', 'rentax' ); ?></dt>
						<dd class="right"><?php echo wp_kses_post( $Auto->get_meta('_auto_engine')) ?></dd>
					<!-- / Engine -->
					<?php endif; ?>
					
					<?php if( $validate['auto-horsepower_show'] && $Auto->get_meta('_auto_horsepower') ): ?>
					<!-- Horsepower -->
						<dt class="left"><?php esc_html_e( 'Horsepower (hp):', 'rentax' ); ?></dt>
						<dd class="right"><?php echo wp_kses_post( $Auto->get_meta('_auto_horsepower')) ?></dd>
					<!-- / Horsepower -->
					<?php endif; ?>
					
					<?php if( $validate['auto-transmission_show'] && $Auto->get_meta('_auto_transmission') ) : ?>
					<!-- Transmission -->
						<dt class="left"><?php esc_html_e( 'Transmission:', 'rentax' ); ?></dt>
						<dd class="right"><?php echo wp_kses_post( $Auto->get_meta('_auto_transmission') ) ?></dd>
					<!-- / Transmission -->
					<?php endif; ?>
					
					<?php if( $validate['auto-doors_show'] && $Auto->get_meta('_auto_doors') ): ?>
					<!-- Doors -->
						<dt class="left"><?php esc_html_e( 'Doors:', 'rentax' ); ?></dt>
						<dd class="right"><?php echo wp_kses_post( $Auto->get_meta('_auto_doors')) ?></dd>
					<!-- / Doors -->
					<?php endif; ?>

					<?php if( $validate['auto-condition_show'] && $Auto->get_meta('_auto_condition') ): ?>
					<!-- Condition -->
						<dt class="left"><?php esc_html_e( 'Condition:', 'rentax' ); ?></dt>
						<dd class="right"><?php echo wp_kses_post( $Auto->get_meta('_auto_condition') ); ?></dd>
					<!-- / Condition -->
					<?php endif; ?>
					
					<?php if( $validate['auto-drive_show'] && $Auto->get_meta('_auto_drive') ): ?>
					<!-- Drive -->
						<dt class="left"><?php esc_html_e( 'Drive:', 'rentax' ); ?></dt>
						<dd class="right"><?php echo wp_kses_post( $Auto->get_meta('_auto_drive').' drive' ); ?></dd>
					<!-- / Drive -->
					<?php endif; ?>
					
					<?php if( $validate['auto-seats_show'] && $Auto->get_meta('_auto_seats') ): ?>
					<!-- Seats -->
						<dt class="left"><?php esc_html_e( 'Seats:', 'rentax' ); ?></dt>
						<dd class="right"><?php echo wp_kses_post( $Auto->get_meta('_auto_seats')) ?></dd>
					<!-- / Seats -->
					<?php endif; ?>
					
					<?php if( $validate['auto-color_show'] && $Auto->get_meta('_auto_color') ): ?>
					<!-- Color -->
						<dt class="left"><?php esc_html_e( 'Color:', 'rentax' ); ?></dt>
						<dd class="right"><?php echo wp_kses_post( $Auto->get_meta('_auto_color')) ?></dd>
					<!-- / Color -->
					<?php endif; ?>
					
					<?php if( $validate['auto-price_show'] && $Auto->get_meta('_auto_price') ): ?>
					<!-- Price -->
						<dt class="left"><?php esc_html_e( 'Price:', 'rentax' ); ?></dt>
						<dd class="right"><?php echo wp_kses_post( $Auto->get_price()) ?></dd>
					<!-- / Price -->
					<?php endif; ?>
					
					<?php if( $validate['auto-price-type_show'] && $Auto->get_meta('_auto_price_type') ): ?>
					<!-- Price Type -->
						<dt class="left"><?php esc_html_e( 'Price Type:', 'rentax' ); ?></dt>
						<dd class="right"><?php echo wp_kses_post( $Auto->get_meta('_auto_price_type') ); ?></dd>
					<!-- / Price Type -->
					<?php endif; ?>
					
					<?php if( $validate['auto-warranty_show'] && $Auto->get_meta('_auto_warranty') ): ?>
					<!-- Warranty -->
						<dt class="left"><?php esc_html_e( 'Warranty:', 'rentax' ); ?></dt>
						<dd class="right"><?php echo wp_kses_post( $Auto->get_meta('_auto_warranty') ); ?></dd>
					<!-- / Warranty -->
					<?php endif; ?>

				</dl>
			</div>
		</section>

	<?php if ($has_video) : ?>
		<section class="widget widget-banner">
			<h3 class="widget-title">car video</h3>
			<div class="decor-1"></div>
			<div class="widget-content">


				<div class="widget-slider owl-carousel owl-theme owl-theme_mod-d enable-owl-carousel" data-pagination="true" data-single-item="true" data-auto-play="7000" data-transition-style="fade" data-main-text-animation="true" data-after-init-delay="3000" data-after-move-delay="1000" data-stop-on-hover="true" style="opacity: 1; display: block;">

					<?php if(pixad_get_external_video($post->ID)): ?>
						<div class="widget-slider__item">
							<a href="<?php echo esc_url( pixad_get_external_video($post->ID) )?>" data-rel="prettyPhoto">
								<img class="img-responsive" src="<?php echo esc_url(pixad_get_external_video_img($post->ID)) ?>" height="250" width="306" alt="Vimeo">
							</a>
						</div>
					<?php endif; ?>

					<?php if(count($video_attachments)>0): ?>
						<?php foreach($video_attachments as $video):  ?>
						<div class="widget-slider__item">
							<video controls="controls">
							<?php $video_ogg = $video_mp4 = $video_webm = false; ?>
							<?php if($video->post_mime_type == 'video/mp4' && !$video_mp4): $video_mp4 = true; ?>
								<source src="<?php echo esc_url($video->guid); ?>" type='video/mp4; codecs="avc1.42E01E, mp4a.40.2"'>
							<?php endif; ?>
							<?php if($video->post_mime_type == 'video/webm' && !$video_webm): $video_webm = true; ?>
								<source src="<?php echo esc_url($video->guid); ?>" type='video/webm; codecs="vp8, vorbis"'>
							<?php endif; ?>
							<?php if($video->post_mime_type == 'video/ogg' && !$video_ogg): $video_ogg = true; ?>
								<source src="<?php echo esc_url($video->guid); ?>" type='video/ogg; codecs="theora, vorbis"'>
								<?php esc_html_e('Video is not supporting by your browser', 'rentax'); ?>
								<a href="<?php echo esc_url($video->guid); ?>"><?php esc_html_e('Download Video', 'rentax'); ?></a>
							<?php endif; ?>
							</video>
						</div>
						<?php endforeach; ?>
					<?php endif; ?>

				</div>
			</div>
		</section>
	<?php endif; ?>


		<section class="widget">
			<h3 class="widget-title">relates cars</h3>
			<div class="decor-1"></div>
			<?php
				$custom_taxterms = wp_get_object_terms( $post->ID, 'auto-body', array('fields' => 'ids') );
				// arguments
				$args = array(
					'post_type' => 'pixad-autos',
					'posts_per_page' => 3, // you may edit this number
					'orderby' => 'rand',
					'tax_query' => array(
					    array(
					        'taxonomy' => 'auto-body',
					        'field' => 'id',
					        'terms' => $custom_taxterms
					    )
					),
					'post__not_in' => array ($post->ID),
				);
				$related_items = new WP_Query( $args );

				// loop over query
				if ($related_items->have_posts()) :
				echo '<div class="widget-content">';
				while ( $related_items->have_posts() ) :
					$related_items->the_post();
					$Auto_Related = new PIXAD_Autos();
					$Auto_Related->Query_Args( array('auto_id' => $post->ID) );
				?>
					<section class="widget-post1 clearfix">
						<div class="widget-post1__img">
							<a href="<?php the_permalink(); ?>" title="<?php the_title_attribute(); ?>">
								<?php if( has_post_thumbnail() ): ?>
									<?php the_post_thumbnail('thumbnail', array('class' => 'img-responsive')); ?>
								<?php else: ?>
									<img class="img-responsive no-image" src="<?php echo PIXADRO_CAR_URI .'assets/img/no_image.jpg'; ?>" alt="no-image">
								<?php endif; ?>
							</a>
						</div>
						<div class="widget-post1__inner">
							<h3 class="widget-post1__title"><a href="<?php the_permalink(); ?>" title="<?php the_title_attribute(); ?>"><?php the_title(); ?></a></h3>
							<div class="widget-post1__price"><?php esc_html_e( 'Price/month:' , 'rentax') ?> <?php echo wp_kses_post($Auto_Related->get_price()) ?></div>
							<div class="widget-post1__description"><?php esc_html_e( 'Cullam semper aibe vestibulum' , 'rentax') ?></div>
						</div>
					</section>
				<?php
				endwhile;
				echo '</div>';
				endif;
			?>
		</section>

		<div class="widget widget_mod-b">
			<div class="wrap-social-block wrap-social-block_mod-a">
				<?php echo do_shortcode('[share]'); ?>
			</div>
		</div>
	</aside>
</div>

