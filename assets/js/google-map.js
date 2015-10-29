var map;
function initialize() {
	getCoordinates(google_settings.googleAddress, function(coords) {
		
		var scroll = false;
		if(1 == google_settings.googleScroll) {
			scroll = true;
		} 

		var mapOptions = {
		zoom: parseInt(google_settings.googleZoom),
		center: new google.maps.LatLng(coords[0], coords[1]),
		scrollwheel: scroll,
		mapTypeId: google.maps.MapTypeId.ROADMAP
		};

		map = new google.maps.Map(document.getElementById('map-canvas'), mapOptions);

		if(google_settings.googleMarker == 1) {
			var marker = new google.maps.Marker({
				position: new google.maps.LatLng(coords[0], coords[1]),
				map: map
			});
		}
	})	
}

google.maps.event.addDomListener(window, 'load', initialize);








