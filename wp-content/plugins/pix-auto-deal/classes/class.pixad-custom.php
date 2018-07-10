<?php
if( ! class_exists( 'pixad' ) ) {
	
	class pixad {
		
		static public function check( $option, $default ) {
			if( empty( $option ) )
				return $default;
			else 
				return $option;
		}
		
		static public function sanitize_post() {
			$details = array(
				'_auto_title'			=> isset( $_POST['auto-title'] ) 		? sanitize_text_field( $_POST['auto-title'] ) : '',
				'_auto_description'		=> isset( $_POST['auto-description'] ) 	? $_POST['auto-description'] : '',
				'_auto_make'			=> isset( $_POST['auto-make'] ) 		? sanitize_text_field( $_POST['auto-make'] ) : '',
				'_auto_model'			=> isset( $_POST['auto-model'] )		? sanitize_text_field( $_POST['auto-model'] ) : '',
				'_auto_version'			=> isset( $_POST['auto-version'] ) 		? sanitize_text_field( $_POST['auto-version'] ) : '',
				'_auto_year'			=> isset( $_POST['auto-year'] ) 		? sanitize_text_field( $_POST['auto-year'] ) : '',
				'_auto_transmission'	=> isset( $_POST['auto-transmission'] ) ? sanitize_text_field( $_POST['auto-transmission'] ) : '',
				'_auto_doors'			=> isset( $_POST['auto-doors'] ) 		? sanitize_text_field( $_POST['auto-doors'] ) : '',
				'_auto_fuel'			=> isset( $_POST['auto-fuel'] ) 	    ? sanitize_text_field( $_POST['auto-fuel'] ) : '',
				'_auto_condition'		=> isset( $_POST['auto-condition'] ) 	? sanitize_text_field( $_POST['auto-condition'] ) : '',
				'_auto_drive'			=> isset( $_POST['auto-drive'] ) 		? sanitize_text_field( $_POST['auto-drive'] ) : '',
				'_auto_color'			=> isset( $_POST['auto-color'] ) 		? sanitize_text_field( $_POST['auto-color'] ) : '',
				'_auto_price'			=> isset( $_POST['auto-price'] ) 		? sanitize_text_field( $_POST['auto-price'] ) : '',
				'_auto_price_type'		=> isset( $_POST['auto-price-type'] ) 	? sanitize_text_field( $_POST['auto-price-type'] ) : '',
				'_auto_warranty'		=> isset( $_POST['auto-warranty'] ) 	? sanitize_text_field( $_POST['auto-warranty'] ) : '',
				'_auto_currency'		=> isset( $_POST['currency'] ) 			? sanitize_text_field( $_POST['currency'] ) : '',
				'_auto_mileage'			=> isset( $_POST['auto-mileage'] ) 		? sanitize_text_field( $_POST['auto-mileage'] ) : '',
				'_auto_vin'				=> isset( $_POST['auto-vin'] ) 			? sanitize_text_field( $_POST['auto-vin'] ) : '',
				'_auto_engine'			=> isset( $_POST['auto-engine'] ) 		? sanitize_text_field( $_POST['auto-engine'] ) : '',
				'_auto_horsepower'		=> isset( $_POST['auto-horsepower'] )	? sanitize_text_field( $_POST['auto-horsepower'] ) : '',
				'_auto_seats'			=> isset( $_POST['auto-seats'] ) 		? sanitize_text_field( $_POST['auto-seats'] ) : '',
				'_auto_equipment'		=> isset( $_POST['auto-equipment'] ) 	? sanitize_term( $_POST['auto-equipment'], 'auto-equipment', '' ) : '',
				'_auto_images'			=> isset( $_POST['auto-images'] ) 		? sanitize_text_field( $_POST['auto-images'] ) : '',
				'_seller_first_name'	=> isset( $_POST['seller-first-name'] ) ? sanitize_text_field( $_POST['seller-first-name'] ) : '',
				'_seller_last_name'		=> isset( $_POST['seller-last-name'] ) 	? sanitize_text_field( $_POST['seller-last-name'] ) : '',
				'_seller_email'			=> isset( $_POST['seller-email'] ) 		? sanitize_text_field( $_POST['seller-email'] ) : '',
				'_seller_phone'			=> isset( $_POST['seller-phone'] ) 		? sanitize_text_field( $_POST['seller-phone'] ) : '',
				'_seller_company'		=> isset( $_POST['seller-company'] ) 	? sanitize_text_field( $_POST['seller-company'] ) : '',
				'_seller_town'			=> isset( $_POST['seller-town'] ) 		? sanitize_text_field( $_POST['seller-town'] ) : '',
				'_seller_country'		=> isset( $_POST['seller-country'] ) 	? sanitize_text_field( $_POST['seller-country'] ) : '',
				'_seller_state'			=> isset( $_POST['seller-state'] ) 		? sanitize_text_field( $_POST['seller-state'] ) : '',
				'_seller_location'	    => isset( $_POST['seller-location'] ) 	? sanitize_text_field( $_POST['seller-location'] ) : '',
				'_seller_location_lat'	=> isset( $_POST['seller-location-lat'] ) 	? sanitize_text_field( $_POST['seller-location-lat'] ) : '',
				'_seller_location_long'	=> isset( $_POST['seller-location-long'] ) 	? sanitize_text_field( $_POST['seller-location-long'] ) : '',
			);
			return $details;
		}
		
		static public function validation( $validate ) {
			$validation['auto-version_req']			= isset( $validate['auto-version_req'] ) 		? $validate['auto-version_req'] : '';
			$validation['auto-year_req']			= isset( $validate['auto-year_req'] ) 			? $validate['auto-year_req'] : '';
			$validation['auto-mileage_req']			= isset( $validate['auto-mileage_req'] ) 		? $validate['auto-mileage_req'] : '';
			$validation['auto-fuel_req']			= isset( $validate['auto-fuel_req'] ) 			? $validate['auto-fuel_req'] : '';
			$validation['auto-engine_req']			= isset( $validate['auto-engine_req'] ) 		? $validate['auto-engine_req'] : '';
			$validation['auto-horsepower_req']		= isset( $validate['auto-horsepower_req'] ) 	? $validate['auto-horsepower_req'] : '';
			$validation['auto-transmission_req']	= isset( $validate['auto-transmission_req'] )	? $validate['auto-transmission_req'] : '';
			$validation['auto-drive_req']			= isset( $validate['auto-drive_req'] ) 			? $validate['auto-drive_req'] : '';
			$validation['auto-doors_req']			= isset( $validate['auto-doors_req'] ) 			? $validate['auto-doors_req'] : '';
			$validation['auto-seats_req']			= isset( $validate['auto-seats_req'] ) 			? $validate['auto-seats_req'] : '';
			$validation['auto-color_req']			= isset( $validate['auto-color_req'] ) 			? $validate['auto-color_req'] : '';
			$validation['auto-condition_req']		= isset( $validate['auto-condition_req'] ) 		? $validate['auto-condition_req'] : '';
			$validation['auto-vin_req']				= isset( $validate['auto-vin_req'] ) 			? $validate['auto-vin_req'] : '';
			$validation['auto-price_req']			= isset( $validate['auto-price_req'] ) 			? $validate['auto-price_req'] : '';
			$validation['auto-price-type_req']		= isset( $validate['auto-price-type_req'] ) 	? $validate['auto-price-type_req'] : '';
			$validation['auto-warranty_req']		= isset( $validate['auto-warranty_req'] ) 		? $validate['auto-warranty_req'] : '';
			$validation['auto-currency_req']		= isset( $validate['auto-currency_req'] ) 		? $validate['auto-currency_req'] : '';
			$validation['first-name_req']			= isset( $validate['first-name_req'] ) 			? $validate['first-name_req'] : '';
			$validation['last-name_req']			= isset( $validate['last-name_req'] ) 			? $validate['last-name_req'] : '';
			$validation['seller-company_req']		= isset( $validate['seller-company_req'] ) 		? $validate['seller-company_req'] : '';
			$validation['seller-phone_req']			= isset( $validate['seller-phone_req'] ) 		? $validate['seller-phone_req'] : '';
			$validation['seller-country_req']		= isset( $validate['seller-country_req'] ) 		? $validate['seller-country_req'] : '';
			$validation['seller-state_req']			= isset( $validate['seller-state_req'] ) 		? $validate['seller-state_req'] : '';
			$validation['seller-town_req']			= isset( $validate['seller-town_req'] ) 		? $validate['seller-town_req'] : '';
			$validation['auto-version_show']		= isset( $validate['auto-version_show'] ) 		? $validate['auto-version_show'] : '';
			$validation['auto-year_show']			= isset( $validate['auto-year_show'] ) 			? $validate['auto-year_show'] : '';
			$validation['auto-mileage_show']		= isset( $validate['auto-mileage_show'] ) 		? $validate['auto-mileage_show'] : '';
			$validation['auto-fuel_show']			= isset( $validate['auto-fuel_show'] ) 			? $validate['auto-fuel_show'] : '';
			$validation['auto-engine_show']			= isset( $validate['auto-engine_show'] ) 		? $validate['auto-engine_show'] : '';
			$validation['auto-horsepower_show']		= isset( $validate['auto-horsepower_show'] ) 	? $validate['auto-horsepower_show'] : '';
			$validation['auto-transmission_show']	= isset( $validate['auto-transmission_show'] ) 	? $validate['auto-transmission_show'] : '';
			$validation['auto-drive_show']			= isset( $validate['auto-drive_show'] ) 		? $validate['auto-drive_show'] : '';
			$validation['auto-doors_show']			= isset( $validate['auto-doors_show'] ) 		? $validate['auto-doors_show'] : '';
			$validation['auto-seats_show']			= isset( $validate['auto-seats_show'] ) 		? $validate['auto-seats_show'] : '';
			$validation['auto-color_show']			= isset( $validate['auto-color_show'] ) 		? $validate['auto-color_show'] : '';
			$validation['auto-condition_show']		= isset( $validate['auto-condition_show'] ) 	? $validate['auto-condition_show'] : '';
			$validation['auto-vin_show']			= isset( $validate['auto-vin_show'] ) 			? $validate['auto-vin_show'] : '';
			$validation['auto-price_show']			= isset( $validate['auto-price_show'] ) 		? $validate['auto-price_show'] : '';
			$validation['auto-price-type_show']		= isset( $validate['auto-price-type_show'] ) 	? $validate['auto-price-type_show'] : '';
			$validation['auto-warranty_show']		= isset( $validate['auto-warranty_show'] ) 		? $validate['auto-warranty_show'] : '';
			$validation['auto-currency_show']		= isset( $validate['auto-currency_show'] ) 		? $validate['auto-currency_show'] : '';
			$validation['first-name_show']			= isset( $validate['first-name_show'] ) 		? $validate['first-name_show'] : '';
			$validation['last-name_show']			= isset( $validate['last-name_show'] ) 			? $validate['last-name_show'] : '';
			$validation['seller-company_show']		= isset( $validate['seller-company_show'] ) 	? $validate['seller-company_show'] : '';
			$validation['seller-phone_show']		= isset( $validate['seller-phone_show'] ) 		? $validate['seller-phone_show'] : '';
			$validation['seller-country_show']		= isset( $validate['seller-country_show'] ) 	? $validate['seller-country_show'] : '';
			$validation['seller-state_show']		= isset( $validate['seller-state_show'] ) 		? $validate['seller-state_show'] : '';
			$validation['seller-town_show']			= isset( $validate['seller-town_show'] ) 		? $validate['seller-town_show'] : '';
			
			return $validation;
		}
		
	}
	
}