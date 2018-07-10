<?php
// Exit if accessed directly
if( ! defined( 'ABSPATH' ) ) exit;

/**
 * My Profile Widget
 *
 * @since 0.1
 */
class Pixad_Auto_Widget_By_Make extends WP_Widget {
	/**
	 * Register widget with WordPress.
	 */
	function __construct() {
		parent::__construct( 'pixad_auto_widget_by_make', __( 'Auto: By Make', 'pixad' ), array( 'description' => __( 'Filter autos by make.', 'pixad' ), ) );
	}

	/**
	 * Front-end display of widget.
	 *
	 * @see WP_Widget::widget()
	 *
	 * @param array $args     Widget arguments.
	 * @param array $instance Saved values from database.
	 */
	public function widget( $args, $instance ) {
		global $post;

		 ?>
		<section class="widget block_content widget_mod-a pixad-filter" data-type="check" data-field="make">
		<?php if( empty( $args['before_title'] ) ): ?>
			<h3 class="widget-title">
			<span>
		<?php endif; ?>

		<?php
		if ( ! empty( $instance['title'] ) ) {
			echo $args['before_title'].apply_filters( 'widget_title', $instance['title'] ). $args['after_title'];
		}
		?>

		<?php if( empty( $args['before_title'] ) ): ?>
			</span>
			</h3>
			<div class="decor-1"></div>
		<?php endif; ?>

		<div class="widget-content">

			<?php
			$args_tax = array( 'taxonomy' => 'auto-model', 'hide_empty' => '1');
			$autos_categories = get_categories ($args_tax);
			if( $autos_categories ):
				echo '<ul class="list-categories list-unstyled">';
				foreach($autos_categories as $auto_cat) :
					$get_make = isset($_REQUEST['make']) ? explode(',',$_REQUEST['make']) : array();
					?>
					<li class="list-categories__item">
						<input data-type="check" data-field="make" type="checkbox" <?php echo in_array($auto_cat->slug, $get_make) ? 'checked' : ''; ?> name="pixad-make" id="<?php echo esc_attr($auto_cat->slug) ?>" value="<?php echo esc_attr($auto_cat->slug) ?>">
						<label for="<?php echo esc_attr($auto_cat->slug) ?>"><?php echo wp_kses_post($auto_cat->name) ?></label>
					</li>
					<?php
				endforeach;
				echo '</ul>';
				//echo '<a class="list-categories__more" href="javascript:void(0);">'.__( 'VIEW MORE', 'pixad' ).'</a>';
			endif;
			?>

		</div>
		</section>
		<?php

	}

	/**
	 * Back-end widget form.
	 *
	 * @see WP_Widget::form()
	 *
	 * @param array $instance Previously saved values from database.
	 */
	public function form( $instance ) {
		$title = ! empty( $instance['title'] ) ? $instance['title'] : __( 'By Make', 'pixad' );
		?>
		<p>
			<label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e( 'Title:', 'pixad' ); ?></label>
			<input class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" type="text" value="<?php echo esc_attr( $title ); ?>">
		</p>
		<?php
	}

	/**
	 * Sanitize widget form values as they are saved.
	 *
	 * @see WP_Widget::update()
	 *
	 * @param array $new_instance Values just sent to be saved.
	 * @param array $old_instance Previously saved values from database.
	 *
	 * @return array Updated safe values to be saved.
	 */
	public function update( $new_instance, $old_instance ) {
		$instance = array();
		$instance['title'] = ( ! empty( $new_instance['title'] ) ) ? strip_tags( $new_instance['title'] ) : '';

		return $instance;
	}
}

class Pixad_Auto_Widget_Filter extends WP_Widget {
	/**
	 * Register widget with WordPress.
	 */
	function __construct() {
		parent::__construct( 'pixad_auto_widget_filter', __( 'Auto: Filter', 'pixad' ), array( 'description' => __( 'Filter autos by price, body type, fuel, transmission.', 'pixad' ), ) );
	}

	/**
	 * Front-end display of widget.
	 *
	 * @see WP_Widget::widget()
	 *
	 * @param array $args     Widget arguments.
	 * @param array $instance Saved values from database.
	 */
	public function widget( $args, $instance ) {
		global $post;
		$Settings	= new PIXAD_Settings();
		$settings	= $Settings->getSettings( 'WP_OPTIONS', '_pixad_autos_settings', true );
		$currency = pixad_get_currencies($settings['autos_site_currency']);
		$before_title = $args['before_title'];
		$after_title = $args['after_title'];
		?>
		<div class="wrap-filter">
			<?php
			if($instance['price']) {
			?>
				<section class="widget block_content widget_mod-a pixad-filter" data-type="number" data-field="price">
			<?php
				if (!empty($instance['price_title'])) {
					echo $before_title . apply_filters('widget_title', $instance['price_title']) . $after_title;
					$get_price = isset($_REQUEST['price']) ? explode(',',$_REQUEST['price']) : array();
				}
				?>
					<div class="widget-content">
						<div class="slider-price" id="slider-price"></div>
						<span class="slider-price__wrap-input">
							<input data-type="number" data-field="price" class="slider-price__input" id="slider-price_min" name="pixad-price">
							<span>-</span>
							<input data-type="number" data-field="price" class="slider-price__input" id="slider-price_max" name="pixad-price">
							<input type="hidden" id="pix-min-price" value="<?php echo isset($get_price[0]) ? esc_attr($get_price[0]) : ''; ?>">
							<input type="hidden" id="pix-max-price" value="<?php echo isset($get_price[1]) ? esc_attr($get_price[1]) : ''; ?>">
							<input type="hidden" id="pix-max-slider-price" value="<?php echo esc_attr($settings['autos_max_price']) ?>">
							<input type="hidden" id="pix-currency-symbol" value="<?php echo esc_attr($currency['symbol']) ?>">
						</span>
					</div>
				</section>
			<?php
			}
			?>
			<?php
			if($instance['body']) {
			?>
				<section class="widget block_content widget_mod-a pixad-filter" data-type="check" data-field="body">
			<?php
				if (!empty($instance['body_title'])) {
					echo $before_title . apply_filters('widget_title', $instance['body_title']) . $after_title;
				}
				$args_tax = array( 'taxonomy' => 'auto-body', 'hide_empty' => '1');
				$autos_bodies = get_categories ($args_tax);
				if( $autos_bodies ):
					$get_body = isset($_REQUEST['body']) ? explode(',',$_REQUEST['body']) : array();
					echo '<div class="widget-content">
							<ul class="list-categories list-unstyled">';
					foreach($autos_bodies as $auto_body) :
						?>
						<li class="list-categories__item">
							<input data-type="check" data-field="body" type="checkbox" <?php echo in_array($auto_body->slug, $get_body) ? 'checked' : ''; ?> name="pixad-body" id="<?php echo esc_attr($auto_body->slug) ?>" value="<?php echo esc_attr($auto_body->slug) ?>">
							<label for="<?php echo esc_attr($auto_body->slug) ?>"><?php echo wp_kses_post($auto_body->name) ?></label>
						</li>
						<?php
					endforeach;
					echo '</ul>
					</div>';
				endif;
				?>
				</section>
			<?php
			}
			?>
			<?php
			if($instance['fuel']) {
			?>
				<section class="widget block_content widget_mod-a pixad-filter" data-type="jelect" data-field="fuel">
			<?php
				if (!empty($instance['fuel_title'])) {
					echo $before_title . apply_filters('widget_title', $instance['fuel_title']) . $after_title;
				}
				?>
					<div class="widget-content">
						<div  class="select select_mod-a jelect">
							<input data-type="jelect" data-field="fuel" id="pixad-fuel" name="pixad-fuel" value="" data-text="imagemin" type="text" class="jelect-input">
							<div tabindex="0" role="button" class="jelect-current"><?php esc_html_e( 'All Fuel Types', 'pixad') ?></div>
							<ul class="jelect-options">
								<li data-val="" class="jelect-option jelect-option_state_active"><?php esc_html_e( 'All Fuel Types', 'pixad') ?></li>
								<li data-val="petrol" class="jelect-option"><?php esc_html_e( 'Petrol', 'pixad') ?></li>
								<li data-val="diesel" class="jelect-option"><?php esc_html_e( 'Diesel', 'pixad') ?></li>
								<li data-val="hybrid" class="jelect-option"><?php esc_html_e( 'Hybrid', 'pixad') ?></li>
								<li data-val="electric" class="jelect-option"><?php esc_html_e( 'Electric', 'pixad') ?></li>
							</ul>
						</div>
					</div>
				</section>
			<?php
			}
			?>
		</div>

		<div class="btn">
			<div class="btn-filter wrap__btn-skew-r js-filter">
				<?php
					$path = '';
					if(substr_count($_SERVER['REQUEST_URI'], '/page/') > 0){
						$path = preg_split('/\/page\//', $_SERVER['REQUEST_URI']);
						$path = $path[0].'/';
					}else{
						$path = preg_split('/\?/', $_SERVER['REQUEST_URI']);
						$path = $path[0];
					}
				?>
				<button data-href="<?php echo esc_url($_SERVER['SERVER_NAME'] . $path)?>" id="pixad-reset-button" class="btn-skew-r btn-effect"><span class="btn-skew-r__inner"><?php echo wp_kses_post($instance['btn_title']) ?></span></button>

			</div>
		</div>

		<?php
	}

	/**
	 * Back-end widget form.
	 *
	 * @see WP_Widget::form()
	 *
	 * @param array $instance Previously saved values from database.
	 */
	public function form( $instance ) {
		$price = ! empty( $instance['price'] ) ? $instance['price'] : 1;
		$price_title = ! empty( $instance['price_title'] ) ? $instance['price_title'] : __( 'Price Range', 'pixad' );
		$body = ! empty( $instance['body'] ) ? $instance['body'] : 1;
		$body_title = ! empty( $instance['body_title'] ) ? $instance['body_title'] : __( 'Vehicle Body Type', 'pixad' );
		$fuel = ! empty( $instance['fuel'] ) ? $instance['fuel'] : 1;
		$fuel_title = ! empty( $instance['fuel_title'] ) ? $instance['fuel_title'] : __( 'Fuel Type', 'pixad' );
		$btn_title = ! empty( $instance['btn_title'] ) ? $instance['btn_title'] : __( 'Filter Vehicles', 'pixad' );
		?>
		<p>
			<input class="checkbox" id="<?php echo $this->get_field_id( 'price' ); ?>" name="<?php echo $this->get_field_name( 'price' ); ?>" type="checkbox"  value="<?php echo esc_attr( $price ); ?>" <?php checked( $price, 1, true ); ?>>
			<label for="<?php echo $this->get_field_id( 'price' ); ?>"><?php _e( 'Show Price Range:' ); ?></label>
		</p>
		<p>
			<label for="<?php echo $this->get_field_id( 'price_title' ); ?>"><?php _e( 'Price Block Title:' ); ?></label>
			<input class="widefat" id="<?php echo $this->get_field_id( 'price_title' ); ?>" name="<?php echo $this->get_field_name( 'price_title' ); ?>" type="text" value="<?php echo esc_attr( $price_title ); ?>">
		</p>
		<p>
			<input class="checkbox" id="<?php echo $this->get_field_id( 'body' ); ?>" name="<?php echo $this->get_field_name( 'body' ); ?>" type="checkbox"  value="<?php echo esc_attr( $body ); ?>" <?php checked( $body, 1, true ); ?>>
			<label for="<?php echo $this->get_field_id( 'body' ); ?>"><?php _e( 'Show Vehicle Body Type:' ); ?></label>
		</p>
		<p>
			<label for="<?php echo $this->get_field_id( 'body_title' ); ?>"><?php _e( 'Vehicle Body Type Title:' ); ?></label>
			<input class="widefat" id="<?php echo $this->get_field_id( 'body_title' ); ?>" name="<?php echo $this->get_field_name( 'body_title' ); ?>" type="text" value="<?php echo esc_attr( $body_title ); ?>">
		</p>
		<p>
			<input class="checkbox" id="<?php echo $this->get_field_id( 'fuel' ); ?>" name="<?php echo $this->get_field_name( 'fuel' ); ?>" type="checkbox"  value="<?php echo esc_attr( $fuel ); ?>" <?php checked( $fuel, 1, true ); ?>>
			<label for="<?php echo $this->get_field_id( 'fuel' ); ?>"><?php _e( 'Show Fuel Type:' ); ?></label>
		</p>
		<p>
			<label for="<?php echo $this->get_field_id( 'fuel_title' ); ?>"><?php _e( 'Fuel Type Title:' ); ?></label>
			<input class="widefat" id="<?php echo $this->get_field_id( 'fuel_title' ); ?>" name="<?php echo $this->get_field_name( 'fuel_title' ); ?>" type="text" value="<?php echo esc_attr( $fuel_title ); ?>">
		</p>

		<p>
			<label for="<?php echo $this->get_field_id( 'btn_title' ); ?>"><?php _e( 'Button Title:' ); ?></label>
			<input class="widefat" id="<?php echo $this->get_field_id( 'btn_title' ); ?>" name="<?php echo $this->get_field_name( 'btn_title' ); ?>" type="text" value="<?php echo esc_attr( $btn_title ); ?>">
		</p>
		<?php
	}

	/**
	 * Sanitize widget form values as they are saved.
	 *
	 * @see WP_Widget::update()
	 *
	 * @param array $new_instance Values just sent to be saved.
	 * @param array $old_instance Previously saved values from database.
	 *
	 * @return array Updated safe values to be saved.
	 */
	public function update( $new_instance, $old_instance ) {

		$instance = array();
		$instance['price'] = ( ! empty( $new_instance['price'] ) ) ? strip_tags( $new_instance['price'] ) : 1;
		$instance['price_title'] = ( ! empty( $new_instance['price_title'] ) ) ? strip_tags( $new_instance['price_title'] ) : '';
		$instance['body'] = ( ! empty( $new_instance['body'] ) ) ? strip_tags( $new_instance['body'] ) : 1;
		$instance['body_title'] = ( ! empty( $new_instance['body_title'] ) ) ? strip_tags( $new_instance['body_title'] ) : '';
		$instance['fuel'] = ( ! empty( $new_instance['fuel'] ) ) ? strip_tags( $new_instance['fuel'] ) : 1;
		$instance['fuel_title'] = ( ! empty( $new_instance['fuel_title'] ) ) ? strip_tags( $new_instance['fuel_title'] ) : '';

		$instance['btn_title'] = ( ! empty( $new_instance['btn_title'] ) ) ? strip_tags( $new_instance['btn_title'] ) : '';

		return $instance;
	}
}
/**
 * Register Widget
 *
 * @since 1.0
 */
function register_pixad_auto_filter_widgets() {
    register_widget( 'Pixad_Auto_Widget_By_Make' );
    register_widget( 'Pixad_Auto_Widget_Filter' );
}
add_action( 'widgets_init', 'register_pixad_auto_filter_widgets' );
?>