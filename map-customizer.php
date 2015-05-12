<?php
// $option = get_option('sgmaps_settings');
// $google_map_url = get_permalink( 'sgmaps_settings[sgmaps_customizer_page_select]'  );

// $options = get_option( 'sgmaps_settings' );
// 	if( !empty( $options[ 'sgmaps_customizer_page_select' ] ) ) {
// 		echo '<select><option value="' . esc_attr( $options[ 'sgmaps_customizer_page_select' ] ) . '"></select>';
// 	}

/**
 * This function adds a custom panel for the Homepage Hero Section.
 */
function sgmaps_customizer_panels( $wp_customize ) {
	$wp_customize->add_panel(
    	'google_map_panel',
    	array(
    		'priority' =>10,
    		'capability' => 'edit_theme_options',
    		'theme_supports' => '',
    		'title' => __( 'Google Map', 'sqmaps' ),
    		'description' => __( 'This panel allows you to customize how Google Maps are displayed on your website.', 'sqmaps' )
    	)
    );
	_sgmaps_general_section( $wp_customize );

}
add_action( 'customize_register', 'sgmaps_customizer_panels' );

function _sgmaps_general_section( $wp_customize ) {
	$wp_customize->add_section( 'map_general_settings' , 
		array(
	        'title' => __( 'General Map Settings', 'sqmaps' ),
	        'priority' => 30,
	        'description' => __( 'section description', 'sqmaps' ),
	        'panel' => 'google_map_panel'
		) 
	);
	_sgmaps_page_select( $wp_customize );
	_sgmaps_marker_setting( $wp_customize );
	_sgmaps_maps_address( $wp_customize );
	_sqmaps_map_size( $wp_customize );
}
function _sgmaps_style_section( $wp_customize ) {
	$wp_customize->add_section( 'map_general_settings' , 
		array(
	        'title' => __( 'General Map Settings', 'sqmaps' ),
	        'priority' => 30,
	        'description' => __( 'section description', 'sqmaps' ),
	        'panel' => 'google_map_panel'
		) 
	);
	
}
function _sgmaps_maps_address( $wp_customize ) {
	$wp_customize->add_setting( 'google_map_address', 
		array(
		'default' => 'New York, NY',
		'type' => 'option',
		'capability' => 'edit_theme_options',
		'transport' => '',
		'sanitize_callback' => 'esc_textarea',
		) 
	);

	$wp_customize->add_control( 'google_map_address', 
		array(
		    'type' => 'textarea',
		    'priority' => 10,
		    'section' => 'map_general_settings',
		    'label' => __( 'Map Address', 'textdomain', 'sqmaps' ),
		    'description' => __('Insert your adress here.', 'sqmaps' ),
		    'settings' => 'google_map_address',
		) 
	);
}
function _sgmaps_page_select( $wp_customize ) {
	$wp_customize->add_setting( 'control-slug' , array('type' => 'option'));
	$wp_customize->add_control( new WP_Customize_Control( $wp_customize, 'control-slug', array(
	        'label'   => __( 'Page Link', 'sqmaps' ),
	        'section' => 'map_general_settings',
	        'type'    => 'dropdown-pages',
	        'settings' => 'control-slug',
	) ) );
}

function _sgmaps_marker_setting( $wp_customize ) {
	$wp_customize->add_setting(
    'display_map_marker', array(
	   		'default' => 1,
	        'type' => 'option',
	        'capability' => 'manage_options',
	        'sanitize_callback' => 'sgmaps_sanitize_checkbox'
	    )
	);
	$wp_customize->add_control(
    'display_map_marker', array(
	        'type' => 'checkbox',
	        'label' => __( 'Display Map Marker', 'sqmaps' ),
	        'section' => 'map_general_settings',
	        'setting' => 'display_map_marker'
	    )
	);
}
function _sqmaps_map_size( $wp_customize ) {
	$wp_customize->add_setting( 
		'google_map_width', 
		array(
			'default' => 400,
			'type' => 'option',
			'capability' => 'edit_theme_options',
			'sanitize_callback' => 'intval',
			'transport' => 'postMessage'
		) 
	);

	$wp_customize->add_control( 
		'google_map_width', 
		array(
		    'type' => 'range',
		    'setting' => 'google_map_width',
		    'section' => 'map_general_settings',
		    'label' => __( 'Map Width', 'sqmaps' ),
		    'input_attrs' => array(
		        'min' => 100,
		        'max' => 1000,
		        'step' => 10,
	    	),
		) 
	);
	$wp_customize->add_setting( 
		'google_map_height', 
		array(
			'default' => 400,
			'type' => 'option',
			'capability' => 'edit_theme_options',
			'sanitize_callback' => 'intval',
			'transport' => 'postMessage'
		) 
	);

	$wp_customize->add_control( 
		'google_map_height', 
		array(
		    'type' => 'range',
		    'setting' => 'google_map_height',
		    'section' => 'map_general_settings',
		    'label' => __( 'Map Height', 'sqmaps' ),
		    'input_attrs' => array(
		        'min' => 100,
		        'max' => 1000,
		        'step' => 10,
	    	),
		) 
	);
}


/**
 * The next set of functions are responsible for custom sanitization callbacks.
 */
function sgmaps_sanitize_text( $input ) {
	return wp_kses_post( force_balance_tags( $input ) );
}

function sgmaps_sanitize_checkbox( $input ) {
    if ( $input == 1 ) {
        return 1;
    } else {
        return '';
    }
}

function sgmaps_customizer_styles() {
	?>
	<style type="text/css">

		#map-canvas {
			height: <?php echo get_option('google_map_height'); ?>;
			width: <?php echo get_option('google_map_width'); ?>;
		}

	</style>
	<?php
}
add_action( 'wp_head', "sgmaps_customizer_styles" );