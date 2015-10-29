<?php
add_action( 'admin_menu', 'sgmaps_add_admin_menu' );
add_action( 'admin_init', 'sgmaps_settings_init' );


function sgmaps_add_admin_menu(  ) { 

	add_submenu_page( 'tools.php', 'Simple Google Maps', 'Simple Google Maps', 'manage_options', 'simple_google_maps', 'simple_google_maps_options_page' );

}


function sgmaps_settings_init(  ) { 

	register_setting( 'pluginPage', 'sgmaps_settings' );

	add_settings_section(
		'sgmaps_pluginPage_section', 
		__( 'Your section description', 'sqmaps' ), 
		'sgmaps_settings_section_callback', 
		'pluginPage'
	);
	// Setting to select the page your shortcode is on. 
	add_settings_field( 
		'sgmaps_customizer_page_select', 
		__( 'Settings field description', 'sqmaps' ), 
		'sgmaps_customizer_page_select_render', 
		'pluginPage', 
		'sgmaps_pluginPage_section' 
	);
	//Button Takes Users to Customizer. Main settings are in the customizer.
	add_settings_field( 
		'sgmaps_customizer_button', 
		__( 'Settings field description', 'sqmaps' ), 
		'sgmaps_customizer_button_render', 
		'pluginPage', 
		'sgmaps_pluginPage_section' 
	);


}


function sgmaps_customizer_button_render() {
	//Link used to send people to customizer 
	$url = admin_url( 'customize.php' );

	$option = get_option('sgmaps_settings');

	//TODO: Trying to add page selected to customizer url, that way user are directed to the correct page.
	if( $option[ 'sgmaps_settings' ] ) {
		$google_map_url = get_permalink( 'option[sgmaps_customizer_page_select][0]'  );

		$url = add_query_arg( 'url', urlencode( $google_map_url ), $url);
	}
	
	?>

	<a href="<?php echo $url; ?>">
    	<input type="button" value="Customize" class="button-primary">
	</a>

	<?php
}

function sgmaps_customizer_page_select_render() {
	// $args = array( 
	// 	'post_type' => 'page', 
	// 	'post_status' => 'publish', 
	// 	'sort_column' => 'post_title',
	// 	'sort_order' => 'ASC'
	//  );

	// $pages = get_pages( $args );
	
	//TODO: Need to save selection.
	wp_dropdown_pages(); 
	
	// echo '<select>';
	// foreach ($pages as $key => $page) {
	// 	$option = '<option value="' . get_page_link( $page->ID ) . '">';
	// 	$option .= $page->post_title;
	// 	$option .= '</option>';
	// 	echo $option;
	// }
	// echo '</select>';
	
	
}


function sgmaps_settings_section_callback(  ) { 

	echo __( 'This section description', 'sqmaps' );

}


function simple_google_maps_options_page(  ) { 

	?>
	<form action='options.php' method='post'>
		
		<h2>Simple Google Maps</h2>
		
		<?php
		settings_fields( 'pluginPage' );
		do_settings_sections( 'pluginPage' );
		submit_button();
		?>
		
	</form>
	<?php

}

?>