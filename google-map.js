var map;
function initialize() {
	getCoordinates(google_settings.googleAddress, function(coords) {
		var mapOptions = {
		zoom: 14,
		scrollwheel: false,
		center: new google.maps.LatLng(coords[0], coords[1]),
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
// function initialize() {

// 	var mapObject;
// 	var myLocation;

// 	getCoordinates(google_settings.googleAddress, function(coords) {

// 		var myLocation = new google.maps.LatLng(coordinates[0], coordinates[1]);
// 		var mapOptions = {
// 			center: myLocation,
// 			zoom: 16,
// 			scrollwheel: false,
// 			mapTypeId: google.maps.MapTypeId.ROADMAP
// 		};
// 		var mapObject = new google.maps.Map(document.getElementById('map'), mapOptions);
// 	});
	
// 	// var mapObject = new google.maps.Map(document.getElementById('map'), mapOptions);
	

// 	if(google_settings.googleMarker == 1) {
// 		var marker = new google.maps.Marker({
// 			position: myLocation,
// 			map: mapObject

// 		});
// 	}
// }

// google.maps.event.addDomListener(window, 'load', initialize);






