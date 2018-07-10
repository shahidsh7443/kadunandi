<?php

// Exit if accessed directly
if( ! defined( 'ABSPATH' ) ) 
	exit;

/**
 * Fire Action on Plugin Installation
 *
 * @since 0.1
 */
class PIXAD_Auto_Install {
	/**
	 * Insert Default Data into Database
	 *
	 * @since 0.1
	 */
	static function install() {
		global $wpdb;
		
		/**
		 * Insert Default Settings "_pixad_autos_settings"
		 * ===========================================
		 * @since 0.1
		 */
		if( ! get_option( '_pixad_auto_settings' ) ) {
			$pixad_autos_settings = array(
				'mode'						=> 'pixads',
				'autos_site_currency'		=> 'USD',
				'autos_thousand'            => ',',
				'autos_decimal'             => '.',
				'autos_decimal_number'      => '2',
				'autos_max_price'			=> '1000',
				'autos_per_page'			=> '10',
				'autos_equipment'			=> '0',
			);
			update_option( '_pixad_autos_settings', serialize( $pixad_autos_settings ) );
		}
		
		if( ! get_option('_pixad_autos_validation' ) ) {
			$defaults = array(
				'auto-version_req' => '',
				'auto-version_show' => 'on',
				'auto-year_req' => 'on',
				'auto-year_show' => 'on',
				'auto-mileage_req' => 'on',
				'auto-mileage_show' => 'on',
				'auto-fuel_req' => 'on',
				'auto-fuel_show' => 'on',
				'auto-engine_req' => 'on',
				'auto-engine_show' => 'on',
				'auto-horsepower_req' => 'on',
				'auto-horsepower_show' => 'on',
				'auto-transmission_req' => 'on',
				'auto-transmission_show' => 'on',
				'auto-drive_req' => 'on',
				'auto-drive_show' => 'on',
				'auto-doors_req' => 'on',
				'auto-doors_show' => 'on',
				'auto-seats_req' => 'on',
				'auto-seats_show' => 'on',
				'auto-color_req' => '',
				'auto-color_show' => 'on',
				'auto-condition_req' => 'on',
				'auto-condition_show' => 'on',
				'auto-vin_req' => '',
				'auto-vin_show' => 'on',
				'auto-price_req' => 'on',
				'auto-price_show' => 'on',
				'auto-price-type_req' => 'on',
				'auto-price-type_show' => 'on',
				'auto-warranty_req' => 'on',
				'auto-warranty_show' => 'on',
				'auto-currency_req' => 'on',
				'auto-currency_show' => 'on',
				'first-name_req' => 'on',
				'first-name_show' => 'on',
				'last-name_req' => 'on',
				'last-name_show' => 'on',
				'seller-company_req' => '',
				'seller-company_show' => 'on',
				'seller-phone_req' => 'on',
				'seller-phone_show' => 'on',
				'seller-country_req' => 'on',
				'seller-country_show' => 'on',
				'seller-state_req' => '',
				'seller-state_show' => 'on',
				'seller-town_req' => 'on',
				'seller-town_show' => 'on'
			);
			update_option( '_pixad_autos_validation', serialize( $defaults ) );
		}
		
		/**
		 * Insert Default Currencies "_pixad_currencies"
		 * ==========================================
		 * @since 0.4
		 */
		if( !get_option( '_pixad_autos_currencies' ) ) {
			$pixad_autos_currencies = array(
				'USD' => array(
						'iso'		=> 'USD',
						'name'		=> 'United States Dollar',
						'symbol'	=> '&#36;',
						'position'	=> 'left'
				),
				'EUR' => array(
					'iso'		=> 'EUR',
					'name'		=> 'Euro Member Countries',
					'symbol'	=> '&#8364;',
					'position'	=> 'left'
				),
				'GBP' => array(
					'iso'		=> 'GBP',
					'name'		=> 'United Kingdom Pound',
					'symbol'	=> '&#163;',
					'position'	=> 'left'
				),

			);
			update_option( '_pixad_autos_currencies', serialize( $pixad_autos_currencies ) );
		}


    }
}
register_activation_hook( PIXAD_AUTO_DIR . 'pixad-autos.php', array( 'PIXAD_Auto_Install', 'install' ) );
?>