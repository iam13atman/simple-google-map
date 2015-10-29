<?php
/**
 * Simple Google Maps
 * This class provides must of the core plugin functionality.
 *
 * @package Simple Google Maps
 * @since 0.1.0
 */

namespace SIMPLE_GOOGLE_MAPS\Maps;

class Google_Maps {

	public function __construct() {
	add_action( 'init', array( $this, 'register_map_post_type' ) );
	}

	/**
	 * Register Map Post Type
	 *
	 * @uses register_post_type
	 *
	 * @since 0.1.0
	 */
	public function register_map_post_type() {

		$singular = esc_html__( 'Google Map', 'simple-maps' );
		$plural = esc_html__( 'Google Maps', 'simple-maps' );
		//Used for the rewrite slug below.
		$slug = str_replace( ' ', '_', strtolower( $singular ) );

		//Setup all the labels to accurately reflect this post type.
		$labels = array(
			'name' 					=> $plural,
			'singular_name' 		=> $singular,
			'add_new' 				=> esc_html__( 'Add New', 'simple-maps' ),
			'add_new_item' 			=> sprintf( esc_html__( 'Add New %s', 'simple-maps' ), $singular ),
			'edit'		        	=> esc_html__( 'Edit', 'simple-maps' ),
			'edit_item'	        	=> sprintf( esc_html__( 'Edit %s', 'simple-maps' ), $singular ),
			'new_item'	        	=> sprintf( esc_html__( 'New %s', 'simple-maps' ), $singular ),
			'view' 					=> sprintf( esc_html__( 'View %s', 'simple-maps' ), $singular ),
			'view_item' 			=> sprintf( esc_html__( 'View %s', 'simple-maps' ), $singular ),
			'search_term'   		=> sprintf( esc_html__( 'Search %s', 'simple-maps' ), $plural ),
			'parent' 				=> sprintf( esc_html__( 'Parent %s', 'simple-maps' ), $singular ),
			'not_found' 			=> sprintf( esc_html__( 'No %s found', 'simple-maps' ), $plural ),
			'not_found_in_trash' 	=> sprintf( esc_html__( 'No %s in Trash', 'simple-maps' ), $plural )
		);
		//Define all the arguments for this post type.
		$args = array(
			'labels' 			  => $labels,
			'public'              => true,
			'show_in_admin_bar'  => false,
			'menu_position'       => 12,
			'menu_icon'           => 'dashicons-location-alt',
			'delete_with_user'    => false,
			'hierarchical'        => false,
			'has_archive'         => false,
			'capability_type'     => 'post',
			'rewrite'             => array(
				'slug' => $slug,
				'with_front' => false
			),
			'supports'            => array(
				'title',
			)
		);

		register_post_type( $slug, $args);
	}
}

$simple_google_map = new Google_Maps();