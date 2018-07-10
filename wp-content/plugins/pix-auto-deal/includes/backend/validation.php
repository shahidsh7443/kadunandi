<?php 
	$Settings = new PIXAD_Settings();
	$options  = $Settings->getSettings( 'WP_OPTIONS', '_jp_autos_validation', true );
	
	// Fix undefined index notice
	$options['auto-version_req']		= isset( $options['auto-version_req'] ) ? $options['auto-version_req'] : '';
	$options['auto-year_req']			= isset( $options['auto-year_req'] ) ? $options['auto-year_req'] : '';
	$options['auto-mileage_req']		= isset( $options['auto-mileage_req'] ) ? $options['auto-mileage_req'] : '';
	$options['auto-fuel_req']			= isset( $options['auto-fuel_req'] ) ? $options['auto-fuel_req'] : '';
	$options['auto-engine_req']			= isset( $options['auto-engine_req'] ) ? $options['auto-engine_req'] : '';
	$options['auto-horsepower_req']		= isset( $options['auto-horsepower_req'] ) ? $options['auto-horsepower_req'] : '';
	$options['auto-transmission_req']	= isset( $options['auto-transmission_req'] ) ? $options['auto-transmission_req'] : '';
	$options['auto-drive_req']			= isset( $options['auto-drive_req'] ) ? $options['auto-drive_req'] : '';
	$options['auto-doors_req']			= isset( $options['auto-doors_req'] ) ? $options['auto-doors_req'] : '';
	$options['auto-seats_req']			= isset( $options['auto-seats_req'] ) ? $options['auto-seats_req'] : '';
	$options['auto-color_req']			= isset( $options['auto-color_req'] ) ? $options['auto-color_req'] : '';
	$options['auto-condition_req']		= isset( $options['auto-condition_req'] ) ? $options['auto-condition_req'] : '';
	$options['auto-vin_req']			= isset( $options['auto-vin_req'] ) ? $options['auto-vin_req'] : '';
	$options['auto-price_req']			= isset( $options['auto-price_req'] ) ? $options['auto-price_req'] : '';
	$options['auto-price-type_req']		= isset( $options['auto-price-type_req'] ) ? $options['auto-price-type_req'] : '';
	$options['auto-warranty_req']		= isset( $options['auto-warranty_req'] ) ? $options['auto-warranty_req'] : '';
	$options['auto-currency_req']		= isset( $options['auto-currency_req'] ) ? $options['auto-currency_req'] : '';
	$options['first-name_req']			= isset( $options['first-name_req'] ) ? $options['first-name_req'] : '';
	$options['last-name_req']			= isset( $options['last-name_req'] ) ? $options['last-name_req'] : '';
	$options['seller-company_req']		= isset( $options['seller-company_req'] ) ? $options['seller-company_req'] : '';
	$options['seller-phone_req']		= isset( $options['seller-phone_req'] ) ? $options['seller-phone_req'] : '';
	$options['seller-country_req']		= isset( $options['seller-country_req'] ) ? $options['seller-country_req'] : '';
	$options['seller-state_req']		= isset( $options['seller-state_req'] ) ? $options['seller-state_req'] : '';
	$options['seller-town_req']			= isset( $options['seller-town_req'] ) ? $options['seller-town_req'] : '';
	
	$options['auto-version_show']		= isset( $options['auto-version_show'] ) ? $options['auto-version_show'] : '';
	$options['auto-year_show']			= isset( $options['auto-year_show'] ) ? $options['auto-year_show'] : '';
	$options['auto-mileage_show']		= isset( $options['auto-mileage_show'] ) ? $options['auto-mileage_show'] : '';
	$options['auto-fuel_show']			= isset( $options['auto-fuel_show'] ) ? $options['auto-fuel_show'] : '';
	$options['auto-engine_show']		= isset( $options['auto-engine_show'] ) ? $options['auto-engine_show'] : '';
	$options['auto-horsepower_show']	= isset( $options['auto-horsepower_show'] ) ? $options['auto-horsepower_show'] : '';
	$options['auto-transmission_show']	= isset( $options['auto-transmission_show'] ) ? $options['auto-transmission_show'] : '';
	$options['auto-drive_show']			= isset( $options['auto-drive_show'] ) ? $options['auto-drive_show'] : '';
	$options['auto-doors_show']			= isset( $options['auto-doors_show'] ) ? $options['auto-doors_show'] : '';
	$options['auto-seats_show']			= isset( $options['auto-seats_show'] ) ? $options['auto-seats_show'] : '';
	$options['auto-color_show']			= isset( $options['auto-color_show'] ) ? $options['auto-color_show'] : '';
	$options['auto-condition_show']		= isset( $options['auto-condition_show'] ) ? $options['auto-condition_show'] : '';
	$options['auto-vin_show']			= isset( $options['auto-vin_show'] ) ? $options['auto-vin_show'] : '';
	$options['auto-price_show']			= isset( $options['auto-price_show'] ) ? $options['auto-price_show'] : '';
	$options['auto-price-type_show']	= isset( $options['auto-price-type_show'] ) ? $options['auto-price-type_show'] : '';
	$options['auto-warranty_show']		= isset( $options['auto-warranty_show'] ) ? $options['auto-warranty_show'] : '';
	$options['auto-currency_show']		= isset( $options['auto-currency_show'] ) ? $options['auto-currency_show'] : '';
	$options['first-name_show']			= isset( $options['first-name_show'] ) ? $options['first-name_show'] : '';
	$options['last-name_show']			= isset( $options['last-name_show'] ) ? $options['last-name_show'] : '';
	$options['seller-company_show']		= isset( $options['seller-company_show'] ) ? $options['seller-company_show'] : '';
	$options['seller-phone_show']		= isset( $options['seller-phone_show'] ) ? $options['seller-phone_show'] : '';
	$options['seller-country_show']		= isset( $options['seller-country_show'] ) ? $options['seller-country_show'] : '';
	$options['seller-state_show']		= isset( $options['seller-state_show'] ) ? $options['seller-state_show'] : '';
	$options['seller-town_show']		= isset( $options['seller-town_show'] ) ? $options['seller-town_show'] : '';
	
	// If fired save button
	if( isset( $_POST['save'] ) ) {
		$args = array();
		foreach( $_POST as $key => $value ) {
			if( $key !== 'save' ) {
				$args[$key] = $value;
			}
		}
		$Settings->update( 'WP_OPTIONS', '_jp_autos_validation', serialize( $args ) );
	}
?>

<!-- Validation Settings -->
<div class="pixad-panel validation">
	<div class="pixad-panel-heading">
		<span class="pixad-panel-title"><?php _e( 'Validation Settings', TEXTDOMAIN ); ?></span>
	</div>
	<div class="pixad-panel-body">
		<form method="post" class="pixad-form-horizontal" role="form">
		
			<table class="pixad-table">
				<thead>
					<tr class="pixad-primary">
						<th><?php _e( 'Input Field', TEXTDOMAIN ); ?> <i class="fa fa-question-circle" title="Auto Fields" data-toggle="tooltip" data-placement="top"></i></th>
						<th><?php _e( 'Required', TEXTDOMAIN ); ?> <i class="fa fa-question-circle" title="Check this if you want this field to be marked as required when users adding new autos." data-toggle="tooltip" data-placement="top"></i></th>
						<th><?php _e( 'Show', TEXTDOMAIN ); ?> <i class="fa fa-question-circle" title="Check this if you want to show this field to be visible on autos page & add / edit auto frontpage." data-toggle="tooltip" data-placement="top"></i></th>
					</tr>
				</thead>
				<tbody>
					<form method="post">
					<tr>
						<td><?php _e( 'Auto Make', TEXTDOMAIN ); ?></td>
						<td><input name="auto-make_req" type="checkbox" checked disabled></td>
						<td><input name="auto-make_show" type="checkbox" checked disabled></td>
					</tr>
					<tr>
						<td><?php _e( 'Auto Model', TEXTDOMAIN ); ?></td>
						<td><input name="auto-model_req" type="checkbox" checked disabled></td>
						<td><input name="auto-model_show" type="checkbox" checked disabled></td>
					</tr>
					<tr>
						<td><?php _e( 'Auto Version', TEXTDOMAIN ); ?></td>
						<td><input name="auto-version_req" type="checkbox" <?php checked( 'on', $options['auto-version_req'], true ); ?>></td>
						<td><input name="auto-version_show" type="checkbox" <?php checked( 'on', $options['auto-version_show'], true ); ?>></td>
					</tr>
					<tr>
						<td><?php _e( 'Auto Year', TEXTDOMAIN ); ?></td>
						<td><input name="auto-year_req" type="checkbox" <?php checked( 'on', $options['auto-year_req'], true ); ?>></td>
						<td><input name="auto-year_show" type="checkbox" <?php checked( 'on', $options['auto-year_show'], true ); ?>></td>
					</tr>
					<tr>
						<td><?php _e( 'Auto Mileage', TEXTDOMAIN ); ?></td>
						<td><input name="auto-mileage_req" type="checkbox" <?php checked( 'on', $options['auto-mileage_req'], true ); ?>></td>
						<td><input name="auto-mileage_show" type="checkbox" <?php checked( 'on', $options['auto-mileage_show'], true ); ?>></td>
					</tr>
					<tr>
						<td><?php _e( 'Auto Fuel', TEXTDOMAIN ); ?></td>
						<td><input name="auto-fuel_req" type="checkbox" <?php checked( 'on', $options['auto-fuel_req'], true ); ?>></td>
						<td><input name="auto-fuel_show" type="checkbox" <?php checked( 'on', $options['auto-fuel_show'], true ); ?>></td>
					</tr>
					<tr>
						<td><?php _e( 'Auto Engine', TEXTDOMAIN ); ?></td>
						<td><input name="auto-engine_req" type="checkbox" <?php checked( 'on', $options['auto-engine_req'], true ); ?>></td>
						<td><input name="auto-engine_show" type="checkbox" <?php checked( 'on', $options['auto-engine_show'], true ); ?>></td>
					</tr>
					<tr>
						<td><?php _e( 'Auto Horsepower', TEXTDOMAIN ); ?></td>
						<td><input name="auto-horsepower_req" type="checkbox" <?php checked( 'on', $options['auto-horsepower_req'], true ); ?>></td>
						<td><input name="auto-horsepower_show" type="checkbox" <?php checked( 'on', $options['auto-horsepower_show'], true ); ?>></td>
					</tr>
					<tr>
						<td><?php _e( 'Auto Transmission', TEXTDOMAIN ); ?></td>
						<td><input name="auto-transmission_req" type="checkbox" <?php checked( 'on', $options['auto-transmission_req'], true ); ?>></td>
						<td><input name="auto-transmission_show" type="checkbox" <?php checked( 'on', $options['auto-transmission_show'], true ); ?>></td>
					</tr>
					<tr>
						<td><?php _e( 'Auto Drive', TEXTDOMAIN ); ?></td>
						<td><input name="auto-drive_req" type="checkbox" <?php checked( 'on', $options['auto-drive_req'], true ); ?>></td>
						<td><input name="auto-drive_show" type="checkbox" <?php checked( 'on', $options['auto-drive_show'], true ); ?>></td>
					</tr>
					<tr>
						<td><?php _e( 'Auto Doors', TEXTDOMAIN ); ?></td>
						<td><input name="auto-doors_req" type="checkbox" <?php checked( 'on', $options['auto-doors_req'], true ); ?>></td>
						<td><input name="auto-doors_show" type="checkbox" <?php checked( 'on', $options['auto-doors_show'], true ); ?>></td>
					</tr>
					<tr>
						<td><?php _e( 'Auto Seats', TEXTDOMAIN ); ?></td>
						<td><input name="auto-seats_req" type="checkbox" <?php checked( 'on', $options['auto-seats_req'], true ); ?>></td>
						<td><input name="auto-seats_show" type="checkbox" <?php checked( 'on', $options['auto-seats_show'], true ); ?>></td>
					</tr>
					<tr>
						<td><?php _e( 'Auto Color', TEXTDOMAIN ); ?></td>
						<td><input name="auto-color_req" type="checkbox" <?php checked( 'on', $options['auto-color_req'], true ); ?>></td>
						<td><input name="auto-color_show" type="checkbox" <?php checked( 'on', $options['auto-color_show'], true ); ?>></td>
					</tr>
					<tr>
						<td><?php _e( 'Auto Condition', TEXTDOMAIN ); ?></td>
						<td><input name="auto-condition_req" type="checkbox" <?php checked( 'on', $options['auto-condition_req'], true ); ?>></td>
						<td><input name="auto-condition_show" type="checkbox" <?php checked( 'on', $options['auto-condition_show'], true ); ?>></td>
					</tr>
					<tr>
						<td><?php _e( 'Auto VIN', TEXTDOMAIN ); ?></td>
						<td><input name="auto-vin_req" type="checkbox" <?php checked( 'on', $options['auto-vin_req'], true ); ?>></td>
						<td><input name="auto-vin_show" type="checkbox" <?php checked( 'on', $options['auto-vin_show'], true ); ?>></td>
					</tr>
					<tr>
						<td><?php _e( 'Auto Price', TEXTDOMAIN ); ?></td>
						<td><input name="auto-price_req" type="checkbox" <?php checked( 'on', $options['auto-price_req'], true ); ?>></td>
						<td><input name="auto-price_show" type="checkbox" <?php checked( 'on', $options['auto-price_show'], true ); ?>></td>
					</tr>
					<tr>
						<td><?php _e( 'Auto Price Type', TEXTDOMAIN ); ?></td>
						<td><input name="auto-price-type_req" type="checkbox" <?php checked( 'on', $options['auto-price-type_req'], true ); ?>></td>
						<td><input name="auto-price-type_show" type="checkbox" <?php checked( 'on', $options['auto-price-type_show'], true ); ?>></td>
					</tr>
					<tr>
						<td><?php _e( 'Auto Warranty', TEXTDOMAIN ); ?></td>
						<td><input name="auto-warranty_req" type="checkbox" <?php checked( 'on', $options['auto-warranty_req'], true ); ?>></td>
						<td><input name="auto-warranty_show" type="checkbox" <?php checked( 'on', $options['auto-warranty_show'], true ); ?>></td>
					</tr>
					<tr>
						<td><?php _e( 'Auto Currency', TEXTDOMAIN ); ?></td>
						<td><input name="auto-currency_req" type="checkbox" <?php checked( 'on', $options['auto-currency_req'], true ); ?>></td>
						<td><input name="auto-currency_show" type="checkbox" <?php checked( 'on', $options['auto-currency_show'], true ); ?>></td>
					</tr>
					<tr>
						<td><?php _e( 'Seller First Name', TEXTDOMAIN ); ?></td>
						<td><input name="first-name_req" type="checkbox" <?php checked( 'on', $options['first-name_req'], true ); ?>></td>
						<td><input name="first-name_show" type="checkbox" <?php checked( 'on', $options['first-name_show'], true ); ?>></td>
					</tr>
					<tr>
						<td><?php _e( 'Seller Last Name', TEXTDOMAIN ); ?></td>
						<td><input name="last-name_req" type="checkbox" <?php checked( 'on', $options['last-name_req'], true ); ?>></td>
						<td><input name="last-name_show" type="checkbox" <?php checked( 'on', $options['last-name_show'], true ); ?>></td>
					</tr>
					<tr>
						<td><?php _e( 'Seller Company', TEXTDOMAIN ); ?></td>
						<td><input name="seller-company_req" type="checkbox" <?php checked( 'on', $options['seller-company_req'], true ); ?>></td>
						<td><input name="seller-company_show" type="checkbox" <?php checked( 'on', $options['seller-company_show'], true ); ?>></td>
					</tr>
					<tr>
						<td><?php _e( 'Seller Email', TEXTDOMAIN ); ?></td>
						<td><input name="none" type="checkbox" checked disabled></td>
						<td><input name="none" type="checkbox" checked disabled></td>
					</tr>
					<tr>
						<td><?php _e( 'Seller Phone', TEXTDOMAIN ); ?></td>
						<td><input name="seller-phone_req" type="checkbox" <?php checked( 'on', $options['seller-phone_req'], true ); ?>></td>
						<td><input name="seller-phone_show" type="checkbox" <?php checked( 'on', $options['seller-phone_show'], true ); ?>></td>
					</tr>
					<tr>
						<td><?php _e( 'Seller Country', TEXTDOMAIN ); ?></td>
						<td><input name="seller-country_req" type="checkbox" <?php checked( 'on', $options['seller-country_req'], true ); ?>></td>
						<td><input name="seller-country_show" type="checkbox" <?php checked( 'on', $options['seller-country_show'], true ); ?>></td>
					</tr>
					<tr>
						<td><?php _e( 'Seller State', TEXTDOMAIN ); ?></td>
						<td><input name="seller-state_req" type="checkbox" <?php checked( 'on', $options['seller-state_req'], true ); ?>></td>
						<td><input name="seller-state_show" type="checkbox" <?php checked( 'on', $options['seller-state_show'], true ); ?>></td>
					</tr>
					<tr>
						<td><?php _e( 'Seller Town', TEXTDOMAIN ); ?></td>
						<td><input name="seller-town_req" type="checkbox" <?php checked( 'on', $options['seller-town_req'], true ); ?>></td>
						<td><input name="seller-town_show" type="checkbox" <?php checked( 'on', $options['seller-town_show'], true ); ?>></td>
					</tr>
					<tr>
						<td colspan="3"><input name="save" type="submit" class="add-new-h2" value="<?php _e( 'Save', TEXTDOMAIN ); ?>"></td>
					</tr>
					</form>
				</tbody>
			</table>
		
		</form>
	</div>
</div><!-- / Validation Settings -->

<script>
jQuery( document ).ready(function($) {
	$('[data-toggle="tooltip"]').tooltip();
});
</script>