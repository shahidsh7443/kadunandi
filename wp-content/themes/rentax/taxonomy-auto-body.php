<?php 
/* The taxonomy for displaying autos by body type. */
global $post, $PIXAD_Autos;
$orderby_arr = array('date', 'title');
$data = array_map( 'esc_attr', $_REQUEST );
$args = $per_page_arr = $order_arr = array();
$per_page = 10;
$order = 'date-desc';
foreach($data as $key=>$val){
    if( property_exists('PIXAD_Autos', $key) && $key == 'order' ){
        $order = $val;
        $temp = explode('-', $val);

        if(isset($temp[0]) && in_array($temp[0], $orderby_arr)){
            $args['orderby'] = $temp[0];
            $args['order'] = strtoupper($temp[1]);
            $args['metakey'] = '';
        }
        elseif(isset($temp[0]) && !in_array($temp[0], $orderby_arr)){
            $args['orderby'] = array( 'meta_value_num' => strtoupper($temp[1]) );
            $args['metakey'] = $temp[0];
        }
    } elseif( property_exists('PIXAD_Autos', $key) && $key == 'per_page' ) {
        $per_page =
        $args[$key] = $val;
    } elseif( $key != 'action' && $key != 'nonce'){
        $args[$key] = $val;
    }
}
$args['body'] = get_queried_object()->slug;
$Query = $args;
$Settings = new PIXAD_Settings(); 
$settings = $Settings->getSettings( 'WP_OPTIONS', '_pixad_autos_settings', true );

$validate = $Settings->getSettings( 'WP_OPTIONS', '_pixad_autos_validation', true ); // Get validation settings
$validate = pixad::validation( $validate ); // Fix undefined index notice

$rentax_loop = new WP_Query( $PIXAD_Autos->Query_Args( $Query ) );

$custom = isset ($wp_query) ? get_post_custom($wp_query->get_queried_object_id()) : '';
$layout = isset ($custom['pix_page_layout']) ? $custom['pix_page_layout'][0] : '2';
$sidebar = isset ($custom['pix_selected_sidebar'][0]) ? $custom['pix_selected_sidebar'][0] : 'sidebar-1';
if (!is_active_sidebar($sidebar)) $layout = '1';

$per_page_arr = array(
		10 => esc_html__( '10 Autos', 'rentax' ),
		20 => esc_html__( '20 Autos', 'rentax' ),
		30 => esc_html__( '30 Autos', 'rentax' ),
);

$order_arr = array(
		'date-desc' => esc_html__( 'Last Added', 'rentax' ),
		'date-asc' => esc_html__( 'First Added', 'rentax' ),
		'_auto_price-asc' => esc_html__( 'Cheap First', 'rentax' ),
		'_auto_price-desc' => esc_html__( 'Expensive First', 'rentax' ),
);


?>

<?php get_header();?>

<div class="container">
					<div class="row">

						<?php rentax_show_sidebar('left', $custom, 1) ?>

						<div class="<?php if ($layout == 1):?>col-md-12<?php else:?>col-md-9<?php endif;?>">
							<main class="main-content">
								<div class="sorting" id="pix-sorting">

									<div class="sorting__inner">
										<div class="sorting__item">
											<span class="sorting__title"><?php  esc_html_e( 'Show on page', 'rentax' ); ?></span>
											<div class="select jelect">
												<input id="jelect-page" name="page" value="0" data-text="imagemin" type="text" class="jelect-input">
												<div tabindex="0" role="button" class="jelect-current"><?php echo wp_kses_post( $per_page_arr[$per_page] ); ?></div>
												<ul class="jelect-options">
													<li data-val="10" class="jelect-option <?php echo ($per_page == 10 ? 'jelect-option_state_active' : ''); ?>"><?php echo wp_kses_post( $per_page_arr[10] ); ?></li>
													<li data-val="20" class="jelect-option <?php echo ($per_page == 20 ? 'jelect-option_state_active' : ''); ?>"><?php echo wp_kses_post( $per_page_arr[20] ); ?></li>
													<li data-val="30" class="jelect-option <?php echo ($per_page == 30 ? 'jelect-option_state_active' : ''); ?>"><?php echo wp_kses_post( $per_page_arr[30] ); ?></li>
												</ul>
											</div>
										</div>
										<div class="sorting__item">
											<span class="sorting__title"><?php  esc_html_e( 'Sort by', 'rentax' ); ?></span>
											<div class="select jelect">
												<input id="jelect-sort" name="sort" value="0" data-text="imagemin" type="text" class="jelect-input">
												<div tabindex="0" role="button" class="jelect-current"><?php echo wp_kses_post( $order_arr[$order] ); ?></div>
												<ul class="jelect-options">
													<li data-val="date-desc" class="jelect-option <?php echo ($order == 'date-desc' ? 'jelect-option_state_active' : ''); ?>"><?php echo wp_kses_post( $order_arr['date-desc'] ); ?></li>
													<li data-val="date-asc" class="jelect-option <?php echo ($order == 'date-asc' ? 'jelect-option_state_active' : ''); ?>"><?php echo wp_kses_post( $order_arr['date-asc'] ); ?></li>
													<li data-val="_auto_price-asc" class="jelect-option <?php echo ($order == '_auto_price-asc' ? 'jelect-option_state_active' : ''); ?>"><?php echo wp_kses_post( $order_arr['_auto_price-asc'] ); ?></li>
													<li data-val="_auto_price-desc" class="jelect-option <?php echo ($order == '_auto_price-desc' ? 'jelect-option_state_active' : ''); ?>"><?php echo wp_kses_post( $order_arr['_auto_price-desc'] ); ?></li>
												</ul>
											</div>
										</div>
									</div>
								</div><!-- end sorting -->

								<div class="pix-dynamic-content">

									<div class="pix-ajax-loader">
										<div id="cssload-wrapper">
											<div class="cssload-loader">
												<div class="cssload-line"></div>
												<div class="cssload-line"></div>
												<div class="cssload-line"></div>
												<div class="cssload-line"></div>
												<div class="cssload-line"></div>
												<div class="cssload-line"></div>
												<div class="cssload-subline"></div>
												<div class="cssload-subline"></div>
												<div class="cssload-subline"></div>
												<div class="cssload-subline"></div>
												<div class="cssload-subline"></div>
												<div class="cssload-loader-circle-1"><div class="cssload-loader-circle-2"></div></div>
												<div class="cssload-needle"></div>
												<div class="cssload-loading"><?php esc_html_e('loading', 'rentax') ?></div>
											</div>
										</div>
									</div>

									<div id="pixad-listing">
									<?php while ( $rentax_loop->have_posts() ) : $rentax_loop->the_post(); ?>
										<article class="card clearfix" id="post-<?php the_ID(); ?>">
											<div class="card__img">
												<?php if( has_post_thumbnail() ): ?>
													<a href="<?php the_permalink(); ?>">
														<?php the_post_thumbnail('rentax-auto-cat', array('class' => 'img-responsive')); ?>
													</a>
												<?php else: ?>
													<img class="no-image" src="<?php echo PIXADRO_CAR_URI .'assets/img/no_image.jpg'; ?>" alt="no-image">
												<?php endif; ?>
											</div>
											<div class="card__inner">
												<h2 class="card__title ui-title-inner"><a href="<?php the_permalink(); ?>" title="<?php echo esc_attr($strip_title); ?>"><?php the_title(); ?></a></h2>
												<div class="decor-1"></div>
												<div class="card__description">
													<p><?php the_excerpt() ?></p>
												</div>
												<!-- Car Details -->
												<ul class="card__list list-unstyled">

													<?php if( $validate['auto-fuel_show'] ): ?>
													<li class="card-list__row">
													  <span class="card-list__title"><?php esc_html_e( 'Fuel:', 'rentax' ); ?></span>

													  <?php if( $PIXAD_Autos->get_meta('_auto_fuel') ): ?>
														<span class="card-list__info"><?php echo wp_kses_post( $PIXAD_Autos->get_meta('_auto_fuel') ); ?></span>
													  <?php endif; ?>
													</li>
													<?php endif; ?>

													<?php if( $validate['auto-mileage_show'] ): ?>
													<li class="card-list__row"><!-- Mileage -->
													  <span class="card-list__title"><?php esc_html_e( 'Mileage:', 'rentax' ); ?></span>

													  <?php if( $PIXAD_Autos->get_meta('_auto_mileage') ): ?>
														<span class="card-list__info"><?php echo number_format($PIXAD_Autos->get_meta('_auto_mileage')); ?></span>
													  <?php endif; ?>
													</li>
													<?php endif; ?>

													<?php if( $validate['auto-year_show'] ): ?>
													<li class="card-list__row">
													  <span class="card-list__title"><?php esc_html_e( 'Year:', 'rentax' ); ?></span>

													  <?php if( $PIXAD_Autos->get_meta('_auto_year') ): ?>
														<span class="card-list__info"><?php echo wp_kses_post($PIXAD_Autos->get_meta('_auto_year')) ?></span>
													  <?php endif; ?>
													</li>
													<?php endif; ?>

													<?php if( $validate['seller-country_show'] ): ?>
													<li class="card-list__row">
													  <span class="card-list__title"><?php esc_html_e( 'Location:', 'rentax' ); ?></span>
													  <?php $country = new PIXAD_Country(); ?>

													  <?php if( $PIXAD_Autos->get_meta('_seller_country') ): ?>
														<span class="card-list__info"><?php $country->text_output( $PIXAD_Autos->get_meta('_seller_country') ); ?></span>
													  <?php endif; ?>
													</li>
													<?php endif; ?>




												<?php if( $validate['auto-condition_show'] && $PIXAD_Autos->get_meta('_auto_condition') ): ?>
													<li class="card-list__row">
														<span class="card-list__title"><?php esc_html_e( 'Condition:', 'rentax' ); ?></span>
													<?php if( $PIXAD_Autos->get_meta('_auto_condition') == 'used' ): ?>
														<span class="card-list__info"><?php esc_html_e( 'Used', 'rentax' ); ?></span>
													<?php else: ?>
														<span class="card-list__info"><?php esc_html_e( 'New', 'rentax' ); ?></span>
													<?php endif; ?>
													</li>
												<?php endif; ?>

												<?php if( $validate['auto-drive_show'] && $PIXAD_Autos->get_meta('_auto_drive') ): ?>
													<li class="card-list__row">
														<span class="card-list__title"><?php esc_html_e( 'Drive:', 'rentax' ); ?></span>
													<?php if( $PIXAD_Autos->get_meta('_auto_drive') == 'left' ): ?>
														<span class="card-list__info"><?php esc_html_e( 'Left drive', 'rentax' ); ?></span>
													<?php else: ?>
														<span class="card-list__info"><?php esc_html_e( 'Right drive', 'rentax' ); ?></span>
													<?php endif; ?>
													</li>
												<?php endif; ?>

												<?php if( $validate['auto-engine_show'] && $PIXAD_Autos->get_meta('_autoesc_html_engine') ): ?>
													<li class="card-list__row">
														<span class="card-list__title"><?php esc_html_e( 'Engine:', 'rentax' ); ?></span>
														<span class="card-list__info"><?php echo wp_kses_post($PIXAD_Autos->get_meta('_autoesc_html_engine')) ?> <?php esc_html_e( 'cm3', 'rentax' ); ?></span>
													</li>
												<?php endif; ?>

												<?php if( $validate['auto-horsepower_show'] && $PIXAD_Autos->get_meta('_auto_horsepower') ): ?>
													<li class="card-list__row">
														<span class="card-list__title"><?php esc_html_e( 'Horsepower:', 'rentax' ); ?></span>
														<span class="card-list__info"><?php echo wp_kses_post($PIXAD_Autos->get_meta('_auto_horsepower')).' '.esc_html__( 'hp', 'rentax' ); ?></span>
													</li>
												<?php endif; ?>

												<?php if( $validate['auto-doors_show'] && $PIXAD_Autos->get_meta('_auto_doors') ): ?>
													<li class="card-list__row">
														<span class="card-list__title"><?php esc_html_e( 'Doors :', 'rentax' ); ?></span>
														<span class="card-list__info"><?php echo wp_kses_post($PIXAD_Autos->get_meta('_auto_doors')).' '.esc_html__( 'doors', 'rentax' ); ?></span>
													</li>
												<?php endif; ?>

												<?php if( get_the_date() ): ?>
												<li><span><?php echo get_the_date(); ?></span></li>
												<?php endif; ?>

												</ul><!-- / Car Details -->

												<?php if( $validate['auto-price_show'] ): ?>
													<div class="card__price"><?php esc_html_e( 'Price / month:' , 'rentax') ?><span class="card__price-number"><?php echo wp_kses_post($PIXAD_Autos->get_price()); ?></span></div>
												<?php endif; ?>

											</div>

										</article>
									<?php endwhile; ?>

									<?php echo pixad_wp_pagenavi() ?>
									</div>

								</div>

							</main><!-- end main-content -->
						</div><!-- end col -->

						<?php rentax_show_sidebar('right', $custom, 1) ?>

					</div><!-- end row -->
				</div>

<?php get_footer();?>
