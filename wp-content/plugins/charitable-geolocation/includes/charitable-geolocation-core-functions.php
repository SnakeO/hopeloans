<?php

/**
 * Charitable Geolocation Core Functions.
 *
 * General core functions.
 *
 * @author      Studio164a
 * @category    Core
 * @package     Charitable Geolocation
 * @subpackage  Functions
 * @version     1.0.0
 */

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) { exit; }

/**
 * This returns the original Charitable_Geolocation object.
 *
 * Use this whenever you want to get an instance of the class. There is no
 * reason to instantiate a new object, though you can do so if you're stubborn :)
 *
 * @return  Charitable_Geolocation
 * @since   1.0.0
 */
function charitable_geolocation() {
	return Charitable_Geolocation::get_instance();
}

/**
 * Displays a template.
 *
 * @param   string|array $template_name A single template name or an ordered array of template
 * @param   array        $args Optional array of arguments to pass to the view.
 * @return  Charitable_Geolocation_Template
 * @since   1.0.0
 */
function charitable_geolocation_template( $template_name, array $args = array() ) {
	if ( empty( $args ) ) {
		$template = new Charitable_Geolocation_Template( $template_name );
	} else {
		$template = new Charitable_Geolocation_Template( $template_name, false );
		$template->set_view_args( $args );
		$template->render();
	}

	return $template;
}

/**
 * Get coordinates from an address.
 *
 * @param   string $address
 * @return  array|WP_Error|false
 * @since   1.1.0
 */
function charitable_geolocation_get_coordinates_from_address( $address ) {
	$url      = 'https://maps.googleapis.com/maps/api/geocode/json?address=' . urlencode( $address );
	$response = wp_remote_get( $url );

	if ( is_wp_error( $response ) ) {
		return $response;
	}

	$body = json_decode( $response['body'] );

	if ( ! array_key_exists( 0, $body->results ) ) {
		return false;
	}

	$coordinates = $body->results[0]->geometry->location;

	return array(
		'lat'      => $coordinates->lat,
		'long'     => $coordinates->lng,
		'place_id' => $body->results[0]->place_id,
	);
}
