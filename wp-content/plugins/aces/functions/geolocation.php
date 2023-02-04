<?php

/**
 *
 * ipdata.co IP geolocation API
 *
 */

if ( get_option( 'aces_geolocation_enable') ) {

	// IP geolocation API Start

	global $geo_data;

	$user_ip = $_SERVER['REMOTE_ADDR'];

	$user_ip_string = str_replace(['.',':'], '', $user_ip);
	$aces_user_ip_key = 'aces_'.$user_ip_string;

	if ( get_option( 'aces_geolocation_api_key') ) {
		$api_key = esc_attr( get_option( 'aces_geolocation_api_key') );
	} else {
		$api_key = '';
	}

	$ch = curl_init('https://api.ipdata.co/'.$user_ip.'?api-key='.$api_key.'&fields=country_name,country_code');

	$aces_json_data_cache_key = 'json_'.$user_ip_string.'_cache';
	$aces_user_ip_cache_key = 'user_'.$user_ip_string.'_cache';
	
	$aces_user_ip_check = get_transient( $aces_user_ip_cache_key );

	// Checking the cache for the current user

	if ( $aces_user_ip_key == $aces_user_ip_check ) {

	    $geo_data = get_transient( $aces_json_data_cache_key );

	    if ( false === $geo_data ) {

			curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

			$json = curl_exec($ch);
			curl_close($ch);

			$geo_data = json_decode($json);
			set_transient( $aces_json_data_cache_key, $geo_data, 3600 ); // 60 min cache

		}	    
		
	} else {

		$geo_data = get_transient( $aces_json_data_cache_key );

	    if ( false === $geo_data ) {

			curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

			$json = curl_exec($ch);
			curl_close($ch);

			$geo_data = json_decode($json);
			set_transient( $aces_json_data_cache_key, $geo_data, 3600 ); // 60 min cache

		}

		// Save a new key for the current user to the cache

		$aces_user_ip_key_save = $aces_user_ip_key;
		set_transient( $aces_user_ip_cache_key, $aces_user_ip_key_save, 3600 ); // 60 min cache

	}

	// IP geolocation API End

	function aces_geolocation( $post_id ){

		$data = $GLOBALS['geo_data'];

	    // Creating an array of restricted countries

	    $post_restricted_countries = get_the_terms( $post_id, 'restricted-country' );

	    if ( !empty($data->country_code) ) {

	    	$country_code = $data->country_code;
	    	$country_name = $data->country_name;

	    	$allowed_message = esc_html( 'Users from %s are accepted', 'aces' );

	    	// Get a custom allowed message

	    	if ( get_option( 'aces_geolocation_allowed_message') ) {
				$allowed_message = get_option( 'aces_geolocation_allowed_message' );
			}

	    	$restricted_message = esc_html( 'Users from %s are not accepted', 'aces' );

	    	// Get a custom restricted message

	    	if ( get_option( 'aces_geolocation_restricted_message') ) {
				$restricted_message = get_option( 'aces_geolocation_restricted_message' );
			}

		    if ( !empty($post_restricted_countries) ) {

		    	$restricted_countries = [];

			    foreach ( $post_restricted_countries as $restricted_country ) {
			    	$restricted_countries[] = get_term_meta($restricted_country->term_id, 'aces_country_code', true);
			    }

			    $restricted_countries_array = array_unique($restricted_countries);

			    // Showing the message

				if ( in_array($country_code, $restricted_countries_array) ) {

					if (get_option( 'aces_geolocation_allowed_mode')) {  ?>

						<i class="fas fa-check-circle"></i> <?php echo esc_html( sprintf($allowed_message, $country_name) ); ?>

					<?php } else {  ?>

						<i class="fas fa-times-circle"></i> <?php echo esc_html( sprintf($restricted_message, $country_name) ); ?>

					<?php }

				} else {

					if (get_option( 'aces_geolocation_allowed_mode')) {  ?>

						<i class="fas fa-times-circle"></i> <?php echo esc_html( sprintf($restricted_message, $country_name) ); ?>

					<?php } else {  ?>

						<i class="fas fa-check-circle"></i> <?php echo esc_html( sprintf($allowed_message, $country_name) ); ?>

					<?php }

				}

		    } else {

		    	if (get_option( 'aces_geolocation_allowed_mode')) {  ?>

					<i class="fas fa-times-circle"></i> <?php echo esc_html( sprintf($restricted_message, $country_name) ); ?>

				<?php } else {  ?>

					<i class="fas fa-check-circle"></i> <?php echo esc_html( sprintf($allowed_message, $country_name) ); ?>

				<?php }

			}

		} else {

			echo esc_html( 'Service is unavailable or invalid API key.', 'aces' );

		}

	}

}