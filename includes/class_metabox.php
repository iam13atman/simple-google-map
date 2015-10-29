<?php
/**
 * Simple Google Maps
 * This class provides must of the core plugin functionality.
 *
 * @package Simple Google Maps
 * @since 0.1.0
 */

namespace SIMPLE_GOOGLE_MAPS\Metaboxes;

class Custom_Metaboxes {

	/**
	 * @var string plugin text domain
	 */
	protected $textdomain;

	/**
	 * @var array Collection of custom metaboxes to register
	 */
	protected $custom_metaboxes;

	/**
	 * @var array List of post types using the custom metabox
	 */
	protected $post_types;

	function __construct( $textdomain ) {
		$this->textdomain = $textdomain;
		$this->custom_metaboxes = array();
		$this->post_types = array();

		add_action( 'add_meta_boxes', array( $this, 'register_custom_metabox' ) );
//		add_action( 'admin_enqueue_scripts', array( $this, 'enqueue_admin_scripts' ) );
	}

	/**
	 * Loops through array of metaboxes and registers them with WordPress
	 */
	public function register_custom_metabox() {
		foreach( $this->custom_metaboxes as $metabox => $setting ) {
			add_meta_box(
				$setting['id'],
				$setting['name'],
				array( $this, 'render_custom_metabox' ),
				$setting['post_type'],
				$setting['context'],
				$setting['priority']
			);
		}
	}

	/**
	 * Checks to see if a certain post type already exists in $post_types, and
	 * if not we add it to the array.
	 * @param $post_type string
	 */
	public function add_post_type_support( $post_type ) {
		if ( is_array( $post_type ) ) {
			foreach ( $post_type as $type ) {
				if( ! in_array( $type, $this->post_types ) ) {
					$this->post_types[] = $type;
				}
			}
		}
		else {
			$this->post_types[] = $post_type;
		}

	}

	/**
	 * Adds an entry to the custom metaboxes array for metabox creation.
	 * Also calls add_post_type_support, to log required post types.
	 * @param $id string - computer readable
	 * @param $name string - Name for your metabox
	 * @param array $post_type - List of post types this metabox should display on
	 * @param string $context
	 * @param string $priority
	 *
	 * @return array
	 */
	public function add_custom_metabox( $id, $name, $post_type, $context = 'advanced', $priority = 'default' ) {

		$this->add_post_type_support( $post_type );

		return $this->custom_metaboxes[ $id ] = array(
			'id' => $id,
			'name' => $name,
			'post_type' => $post_type,
			'context' => $context,
			'priority' => $priority
		);
	}

	/**
	 * Outputs custom metabox div container
	 * @param $post
	 */
	public function render_custom_metabox( $post ) {
		echo '<div id="react-search"></div>';
	}

	/**
	 * Checks if the current post type has a custom metabox.
	 * Returns true if it does.
	 * @return bool
	 */
	public function has_custom_metabox() {
		$post_type = get_post_type();

		if ( in_array( $post_type, $this->post_types ) ) {
			return true;
		}
		return false;
	}

	/**
	 * Load Search Metabox scripts
	 */
//	public function enqueue_admin_scripts() {
//		if ( $this->has_custom_metabox() ) {
//			wp_enqueue_script( 'react-search', WP_REACT_SEARCH_URL . 'dist/app.js', array(), true );
//		}
//	}
}

$wp_custom_metaboxes = new Custom_Metaboxes( 'simple-maps' );
$wp_custom_metaboxes->add_custom_metabox( 'add-google-map', 'Create Google Map', 'google_map' );