<?php
/*
Plugin Name: Simple Google Map
Plugin URI: https://github.com/mrbobbybryant/simple-google-map
Description: A simple wordpress plugin that allows you to configure Google Maps for your site.
Version: 1.0
Author: Bobby Bryant
Author URI: http://www.developwithwp.com
License: GPL2
*/
/*
Copyright 2015  Bobby Bryant  (email : bobby@hatrackmedia.com)
This program is free software; you can redistribute it and/or modify
it under the terms of the GNU General Public License, version 2, as
published by the Free Software Foundation.
This program is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
GNU General Public License for more details.
You should have received a copy of the GNU General Public License
along with this program; if not, write to the Free Software
Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA
*/

/**
 * Enqueue Scripts and styles.
 */
function sgmaps_google_enqueue_scripts() {
	//TODO: Need to add conditional checks for shortcode and customizer page.
	wp_enqueue_script( 
		'google_api', 
		'https://maps.googleapis.com/maps/api/js?v=3.exp$sensor=false' ,
		array() ,
		'20150508', 
		true 
	);
	wp_enqueue_script( 
		'google_js', 
		plugins_url('google-map.js', __FILE__) ,
		array() ,
		'20150508', 
		true 
	);
	wp_enqueue_script( 
		'geocoder_js', 
		plugins_url('geocoder.js', __FILE__) ,
		array() ,
		'20150508', 
		true 
	);
	wp_enqueue_script( 
		'customizer_js', 
		plugins_url('map-customizer.js', __FILE__) ,
		array() ,
		'20150508', 
		true 
	);
	wp_enqueue_style( 
		'google_css', 
		plugins_url('google-map.css', __FILE__) ,
		array() ,
		'20150508'
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
add_action( 'admin_enqueue_scripts', 'sgmaps_google_enqueue_scripts' );
add_action( 'wp_enqueue_scripts', 'sgmaps_google_enqueue_scripts' );

/**
 * Register Map Shortcode.
 */
function sgmaps_google_register_shortcode( $atts ) {
	?>

	<div id="map-canvas">
	</div>

	<?php
}
add_shortcode( 'simple_google_map', 'sgmaps_google_register_shortcode' );

/**
 * Load Settings page.
 */
require 'settings.php';

/**
 * Load Map Cusotmizer Page.
 */
require 'map-customizer.php';