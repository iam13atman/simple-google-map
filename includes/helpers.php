<?php
/**
 * Simple Google Maps
 * This file consists of useful functions.
 *
 * @package Simple Google Maps
 * @since 0.1.0
 */

namespace SIMPLE_GOOGLE_MAPS\Helpers;

function postmeta_value_exists( $meta_value, $key ) {

	if ( isset( $meta_value[$key] ) ) {
		return $meta_value[$key];
	}

	return $meta_value[$key] = false;
}