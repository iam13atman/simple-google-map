<?php
/**
 * Simple Google Maps
 * This class provides must of the core plugin functionality.
 *
 * @package Simple Google Maps
 * @since 0.1.0
 */

namespace SIMPLE_GOOGLE_MAPS\Metaboxes;
use SIMPLE_GOOGLE_MAPS\Country_Select as Select;

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

	protected $meta_names;

	function __construct( $textdomain ) {
		$this->textdomain = $textdomain;
		$this->custom_metaboxes = array();
		$this->post_types = array();
		$this->meta_names = array(
			'address_1' => 'Address Line 1',
			'address_2' => 'Address Line 2',
			'city' => 'City',
			'state' => 'State/Province/Region',
			'zipcode' => 'Zip/ Postal Code'
		);

		add_action( 'add_meta_boxes', array( $this, 'register_custom_metabox' ) );
		add_action( 'save_post', array( $this, 'save_custom_metabox_data' ) );
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

	protected function meta_value( $var, $default ) {
		return empty( $var ) ? $default : $var;
	}

	/**
	 * Outputs custom metabox div container
	 * @param $post
	 */
	public function render_custom_metabox( $post ) {
		wp_nonce_field( SIMPLE_GOOGLE_MAPS_PATH, 'simple_google_map_nonce' );
		$meta_data = array_map( function( $a ){ return $a[0]; }, get_post_meta( $post->ID ) );
		?>
		<div id="google-map-input">
			<?php
			foreach( $this->meta_names as $key => $value ) {
				printf( '<label for="%s">%s</label>', str_replace( '_', '-', $key ), $value );
				printf( '<input type="text" class="metabox-row-content" size="60" name="%s" id="%s" value="%s"/>',
					$key,
					str_replace( '_', '-', $key ),
					$this->meta_value( $meta_data[$key], '' )
					);

			}
			?>

<!--			<label for="address-2">Address Line 2</label>-->
<!--			<input type="text" name="address_2" id="address-2"/>-->
<!--			<label for="city">City</label>-->
<!--			<input type="text" name="city" id="city"/>-->
<!--			<label for="state">State/Province/Region</label>-->
<!--			<input type="text" name="state" id="state"/>-->
<!--			<label for="zipcode">Zip/ Postal Code</label>-->
<!--			<input type="text" name="zipcode" id="zipcode"/>-->
			<?php echo new Select\Country_Select( $meta_data['countries'] ); ?>
		</div>
		<div id="google-map-output">

		</div>

		<?php
	}

	public function save_custom_metabox_data( $post_id ) {

		if ( $is_autosave = wp_is_post_autosave( $post_id ) ) {
			return;
		}

		if ( $is_revision = wp_is_post_revision( $post_id ) ) {
			return;
		}

		$is_valid_nonce = ( isset( $_POST[ 'simple_google_map_nonce' ] ) && wp_verify_nonce( $_POST[ 'simple_google_map_nonce' ], basename( __FILE__ ) ) ) ? 'true' : 'false';
		if ( ! $is_valid_nonce ) {
			return;
		}

		if ( isset( $_POST[ 'address_1' ] ) ) {
			update_post_meta( $post_id, 'address_1', sanitize_text_field( $_POST[ 'address_1' ] ) );
		}

		if ( isset( $_POST[ 'address_2' ] ) ) {
			update_post_meta( $post_id, 'address_2', sanitize_text_field( $_POST[ 'address_2' ] ) );
		}

		if ( isset( $_POST[ 'city' ] ) ) {
			update_post_meta( $post_id, 'city', sanitize_text_field( $_POST[ 'city' ] ) );
		}

		if ( isset( $_POST[ 'zipcode' ] ) ) {
			update_post_meta( $post_id, 'zipcode', sanitize_text_field( $_POST[ 'zipcode' ] ) );
		}

		if ( isset( $_POST[ 'state' ] ) ) {
			update_post_meta( $post_id, 'state', sanitize_text_field( $_POST[ 'state' ] ) );
		}

		if ( isset( $_POST[ 'countries' ] ) ) {
			update_post_meta( $post_id, 'countries', sanitize_text_field( $_POST[ 'countries' ] ) );
		}

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