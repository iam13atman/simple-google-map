( function( $ ) {
	wp.customize('google_map_height', function(value){
		value.bind(function(to){
			$('#map-canvas').css('height', to + 'px');
		});
	});
	wp.customize('google_map_width', function(value){
		value.bind(function(to){
			$('#map-canvas').css('width', to + 'px');
		});
	});
} )( jQuery );