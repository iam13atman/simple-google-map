<?php
/**
 * Simple Google Maps
 * This file is responsible for registering all styles and scripts with WordPress.
 *
 * @package Simple Google Maps
 * @since 0.1.0
 */

namespace SIMPLE_GOOGLE_MAPS\Scripts;

function setup() {
	add_action( 'admin_enqueue_scripts', 'enqueue_admin_scripts' );
	add_action( 'wp_enqueue_scripts', 'enqueue_google_api_scripts' );
}

/**
 * Enqueue Scripts and styles.
 */
function enqueue_google_api_scripts() {
	//TODO: Need to add conditional checks for shortcode and customizer page.
	wp_enqueue_script(
		'google_api',
		'https://maps.googleapis.com/maps/api/js?v=3.exp$sensor=false' ,
		array() ,
		SIMPLE_GOOGLE_MAPS_VERSION,
		true
	);
	wp_enqueue_script(
		'google_js',
		SIMPLE_GOOGLE_MAPS_URL . '/google-map.js',
		array() ,
		SIMPLE_GOOGLE_MAPS_VERSION,
		true
	);
	wp_enqueue_script(
		'geocoder_js',
		SIMPLE_GOOGLE_MAPS_URL . '/geocoder.js',
		array() ,
		SIMPLE_GOOGLE_MAPS_VERSION,
		true
	);

	wp_enqueue_style(
		'google_css',
		SIMPLE_GOOGLE_MAPS_URL . '/google-map.css',
		array() ,
		SIMPLE_GOOGLE_MAPS_VERSION
	);
	wp_localize_script( 'google_js',
		'google_settings',
		array(
			'ajaxurl' => admin_url( 'admin-ajax.php' ),
			'googleMarker' => get_option( 'display_map_marker' ),
			'googleAddress' => get_option( 'google_map_address' ),
			'googleZoom' => get_option( 'google_map_zoom' ),
			'googleScroll' => get_option('google_map_scroll')
		)
	);

}

function enqueue_admin_scripts() {
	wp_enqueue_script(
		'customizer_js',
		SIMPLE_GOOGLE_MAPS_URL . '/map-customizer.js',
		array() ,
		SIMPLE_GOOGLE_MAPS_VERSION,
		true
	);
}

