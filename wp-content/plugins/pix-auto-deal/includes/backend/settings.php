<!-- General Settings -->
<?php 
// Exit if accessed directly
if( ! defined( 'ABSPATH' ) ) exit;
	
$Settings = new PIXAD_Settings();
$options = $Settings->getSettings( 'WP_OPTIONS', '_pixad_autos_settings', true );

$_POST['autos_site_currency']		= isset( $_POST['autos_site_currency'] ) ? $_POST['autos_site_currency'] : '';
$_POST['autos_thousand']			= isset( $_POST['autos_thousand'] ) ? $_POST['autos_thousand'] : '';
$_POST['autos_decimal']			    = isset( $_POST['autos_decimal'] ) ? $_POST['autos_decimal'] : '';
$_POST['autos_decimal_number']		= isset( $_POST['autos_decimal_number'] ) ? $_POST['autos_decimal_number'] : '';
$_POST['autos_max_price']			= isset( $_POST['autos_max_price'] ) ? $_POST['autos_max_price'] : '';
$_POST['autos_per_page']			= isset( $_POST['autos_per_page'] ) ? $_POST['autos_per_page'] : '';
$_POST['autos_equipment']			= isset( $_POST['autos_equipment'] ) ? $_POST['autos_equipment'] : '';

$currencies = unserialize( get_option( '_pixad_autos_currencies' ) );

##############################################################
# SAVE GENERAL SETTINGS INTO DATABASE
##############################################################
if( isset( $_POST['action'] ) && $_POST['action'] == 'save' ):
	
	$args = array(
		'autos_site_currency'		=> esc_attr($_POST['autos_site_currency']),
		'autos_thousand'			=> esc_attr($_POST['autos_thousand']),
		'autos_decimal'			    => esc_attr($_POST['autos_decimal']),
		'autos_decimal_number'		=> esc_attr($_POST['autos_decimal_number']),
		'autos_max_price'			=> esc_attr($_POST['autos_max_price']),
		'autos_per_page'			=> esc_attr($_POST['autos_per_page']),
		'autos_equipment'			=> esc_attr($_POST['autos_equipment']),
	);
	
	// Save General Settings
	$Settings->update( 'WP_OPTIONS', '_pixad_autos_settings', serialize( $args ) );
	
endif; ?>
<div class="pixad-panel">
	<div class="pixad-panel-heading">
		<span class="pixad-panel-title"><?php esc_html_e( 'General Settings', 'pixautodeal' ); ?></span>
	</div>
	<div class="pixad-panel-body">
		<form method="post" class="pixad-form-horizontal" role="form">
			<input type="hidden" name="action" value="save">
			
			<div class="pixad-form-group">
				<label class="col-lg-2 pixad-control-label"></label>
				<div class="col-lg-9"><h3><?php esc_html_e( 'General Settings', 'pixautodeal' ); ?></h3></div>
			</div>

			<div class="pixad-form-group">
				<label class="col-lg-2 pixad-control-label">
					<?php esc_html_e( 'Site currency', 'pixautodeal' ); ?>
					<i class="fa fa-question-circle" title="<?php esc_html_e( 'Set site currency.', 'pixautodeal' ); ?>" data-toggle="tooltip" data-placement="top"></i>
				</label>
				<div class="col-lg-9">
					<select name="autos_site_currency" class="pixad-form-control">
					<?php if( $currencies ): foreach( $currencies as $currency ): ?>

						<option value="<?php echo $currency['iso']; ?>" <?php selected( $options['autos_site_currency'], $currency['iso'], true ); ?>><?php echo $currency['iso']; ?></option>

					<?php endforeach; else: ?>

						<option value="EUR" <?php selected( $options['autos_site_currency'], 'EUR', true ); ?>><?php echo 'EUR'; ?></option>
						<option value="USD" <?php selected( $options['autos_site_currency'], 'USD', true ); ?>><?php echo 'USD'; ?></option>

					<?php endif; ?>
					</select>
				</div>
			</div>

			<div class="pixad-form-group">
				<label class="col-lg-2 pixad-control-label">
					<?php esc_html_e( 'Thousand Separator', 'pixautodeal' ); ?>
					<i class="fa fa-question-circle" title="<?php esc_html_e( 'This sets the thousand separator of displayed prices.', 'pixautodeal' ); ?>" data-toggle="tooltip" data-placement="top"></i>
				</label>
				<div class="col-lg-9">
					<input name="autos_thousand" class="pixad-form-control" value="<?php echo isset($options['autos_thousand']) ? esc_attr($options['autos_thousand']) : ',' ?>">
				</div>
			</div>

			<div class="pixad-form-group">
				<label class="col-lg-2 pixad-control-label">
					<?php esc_html_e( 'Decimal Separator', 'pixautodeal' ); ?>
					<i class="fa fa-question-circle" title="<?php esc_html_e( 'This sets the decimal separator of displayed prices.', 'pixautodeal' ); ?>" data-toggle="tooltip" data-placement="top"></i>
				</label>
				<div class="col-lg-9">
					<input name="autos_decimal" class="pixad-form-control" value="<?php echo isset($options['autos_decimal']) ? esc_attr($options['autos_decimal']) : '.' ?>">
				</div>
			</div>

			<div class="pixad-form-group">
				<label class="col-lg-2 pixad-control-label">
					<?php esc_html_e( 'Number of Decimals', 'pixautodeal' ); ?>
					<i class="fa fa-question-circle" title="<?php esc_html_e( 'This sets the number of decimal points shown in displayed prices.', 'pixautodeal' ); ?>" data-toggle="tooltip" data-placement="top"></i>
				</label>
				<div class="col-lg-9">
					<input name="autos_decimal_number" class="pixad-form-control" value="<?php echo isset($options['autos_decimal_number']) ? esc_attr($options['autos_decimal_number']) : '2' ?>">
				</div>
			</div>

			<div class="pixad-form-group">
				<label class="col-lg-2 pixad-control-label">
					<?php esc_html_e( 'Slider max price', 'pixautodeal' ); ?>
					<i class="fa fa-question-circle" title="<?php esc_html_e( 'Set max price for price slider. If max price in slider set to this position, will be shown all autos more expensive than min price.', 'pixautodeal' ); ?>" data-toggle="tooltip" data-placement="top"></i>
				</label>
				<div class="col-lg-9">
					<input name="autos_max_price" class="pixad-form-control" value="<?php echo esc_attr($options['autos_max_price']) ?>">
				</div>
			</div>

			<div class="pixad-form-group">
				<label class="col-lg-2 pixad-control-label">
					<?php esc_html_e( 'Autos per page', 'pixautodeal' ); ?>
					<i class="fa fa-question-circle" title="<?php esc_html_e( 'Set how many posts will be shown per page.', 'pixautodeal' ); ?>" data-toggle="tooltip" data-placement="top"></i>
				</label>
				<div class="col-lg-9">
					<select name="autos_per_page" class="pixad-form-control">
						<?php pixad_get_options_range( 1, 20, $options['autos_per_page'] ); ?>
					</select>
				</div>
			</div>

			<div class="pixad-form-group">
				<label class="col-lg-2 pixad-control-label">
					<?php esc_html_e( 'Show disabled equipment', 'pixautodeal' ); ?>
					<i class="fa fa-question-circle" title="<?php esc_html_e( 'If Yes, enabled and disabled equipment will be displayed on single auto page.', 'pixautodeal' ); ?>" data-toggle="tooltip" data-placement="top"></i>
				</label>
				<div class="col-lg-9">
					<?php $equip_display = isset($options['autos_equipment']) ? $options['autos_equipment'] : 0; ?>
					<select name="autos_equipment" class="pixad-form-control">
						<option value="0" <?php selected( $equip_display, '0', true ); ?>><?php esc_html_e( 'No', 'pixautodeal' ); ?></option>
						<option value="1" <?php selected( $equip_display, '1', true ); ?>><?php esc_html_e( 'Yes', 'pixautodeal' ); ?></option>
					</select>
				</div>
			</div>

			<div class="pixad-form-group">
				<label class="col-lg-2 pixad-control-label"></label>
				<div class="col-lg-9">
					<?php submit_button(); ?>
				</div>
			</div>
			
		</form>
	</div>
</div>
<script>
jQuery( document ).ready(function($) {
	$('[data-toggle="tooltip"]').tooltip();
});
</script>
<!-- / General Settings -->