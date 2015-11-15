( function( window, $, undefined ) {
	'use strict';
	var map;
	var address;
	var postSlug = $( document.getElementById( 'add-google-map' ) );
	var geoLat = $( document.getElementById( 'geolat' ) );
	var geoLng = $( document.getElementById( 'geolng' ) );
	var latlng = google_settings.googleLatLng;
	var geocoder = new google.maps.Geocoder();

	//Address Fields
	var addressOne = document.getElementById( 'address-1' );
	var addressTwo = document.getElementById( 'address-2' );
	var city = document.getElementById( 'city' );
	var state = document.getElementById( 'state' );
	var zipcode = document.getElementById( 'zipcode' );
	var country =document.getElementById( 'countries' );

	function initialize() {

		var location = new google.maps.LatLng( {lat: parseFloat(latlng[0]), lng: parseFloat(latlng[1])} );
		var mapOptions = {
			zoom: 8,
			center: location
		};

		map = new google.maps.Map(document.getElementById("map"), mapOptions);

		var marker = new google.maps.Marker({
			map: map,
			position: {lat: parseFloat(latlng[0]), lng: parseFloat(latlng[1])},
			title: 'Click for more detail'
		});
	}

	function codeAddress(address) {
		geocoder.geocode( { 'address': address}, function(results, status) {
			if (status == google.maps.GeocoderStatus.OK) {
				$( 'div#message' ).remove();
				map.setCenter(results[0].geometry.location);
				var marker = new google.maps.Marker({
					map: map,
					position: results[0].geometry.location
				});
				postSlug.before( '<div id="message" class="updated"><p>' + "Successfully Generated Map!" + '</p></div>' );
			} else {
				$( 'div#message' ).remove();
				postSlug.before( '<div id="message" class="error"><p>' + "Geocode was not successful for the following reason: " + status + '</p></div>' );
			}
			geoLat.val( results[0].geometry.location.lat() );
			geoLng.val( results[0].geometry.location.lng() );
		});
	}

	function checkForRequiresValues() {
		if ( addressOne !== null && addressOne.value === "" ) {
			return false;
		}
		if ( city !== null && city.value === "" ) {
			return false;
		}
		if ( country !== null && country.value === "" ) {
			return false;
		}

		return true;
	}

	function generateMap() {
		var ready = checkForRequiresValues();

		if ( ready ) {
			var address = [
				addressOne.value,
				addressTwo.value,
				city.value,
				state.value,
				zipcode.value,
				country.value
			];
			address = address.join(' ');
			codeAddress( address );
		}
	}
	window.onload = initialize;
	city.addEventListener( "blur", generateMap );
	state.addEventListener( "blur", generateMap );
	zipcode.addEventListener( "blur", generateMap );
	country.addEventListener( "change", generateMap );

} )( this, jQuery );
