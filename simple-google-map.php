<?php
/*
Plugin Name: Simple Google Map
Plugin URI: https://github.com/mrbobbybryant/simple-google-map
Description: A simple wordpress plugin that allows you to configure Google Maps for your site.
Version: 1.0
Author: Bobby Bryant
Author URI: http://www.developwithwp.com
License: GPL2
Text Domain: simple-maps
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

namespace SIMPLE_GOOGLE_MAPS;

// Useful global constants
define( 'SIMPLE_GOOGLE_MAPS_VERSION', '0.1.0' );
define( 'SIMPLE_GOOGLE_MAPS_URL',     plugin_dir_url( __FILE__ ) );
define( 'SIMPLE_GOOGLE_MAPS_PATH',    dirname( __FILE__ ) . '/' );

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Activate the plugin
 */
function simple_google_maps_activate() {

	flush_rewrite_rules();
}
register_activation_hook( __FILE__, __NAMESPACE__ . '\simple_google_maps_activate' );

/**
 * Deactivate the plugin
 * Uninstall routines should be in uninstall.php
 */
function simple_google_maps_deactivate() {

}
register_deactivation_hook( __FILE__, __NAMESPACE__ . '\simple_google_maps_deactivate' );

/**
 * Require Includes Directory Items
 */
require_once( SIMPLE_GOOGLE_MAPS_PATH . 'includes/settings.php' );
require_once( SIMPLE_GOOGLE_MAPS_PATH . 'includes/map-customizer.php' );
require_once( SIMPLE_GOOGLE_MAPS_PATH . 'includes/enqueue_scripts.php' );
require_once( SIMPLE_GOOGLE_MAPS_PATH . 'includes/helpers.php' );
require_once( SIMPLE_GOOGLE_MAPS_PATH . 'includes/class_google_map.php' );
require_once( SIMPLE_GOOGLE_MAPS_PATH . 'includes/class_metabox.php' );
require_once( SIMPLE_GOOGLE_MAPS_PATH . 'includes/class_country_select.php' );

\SIMPLE_GOOGLE_MAPS\Scripts\setup();

/**
 * Register Map Shortcode.
 */
function google_register_shortcode( $atts ) {
	?>

	<div id="map-canvas">
	</div>

	<?php
}
add_shortcode( 'simple_google_map', __NAMESPACE__ . '\google_register_shortcode' );

/**
 * Add Settings Page link.
 */
function google_map_settings_links ( $links ) {
	 
	$mylinks = array(
	'<a href="' . admin_url( 'tools.php?page=simple_google_maps' ) . '">Settings</a>',
	);

	return array_merge( $links, $mylinks );
}
add_filter( 'plugin_action_links_' . plugin_basename(__FILE__), __NAMESPACE__ . '\google_map_settings_links' );
