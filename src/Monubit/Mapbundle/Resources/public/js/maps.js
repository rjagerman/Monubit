var map;
var clusterer;
var markers = [];

function initialize() {
	var nederland = new google.maps.LatLng(52.0833, 5.1333);
	var mapOptions = {
			zoom: 7,
			center: nederland,
			streetViewControl: true
	};
	map = new google.maps.Map(document.getElementById('map-canvas'),
			mapOptions);

	
	$.ajax({
		url: "/maps/monument",
		type: "POST"
	}).done(
			function(json) {
				if(json[0] == "success"){
					loadAllMarkers(json.data);
					clusterer = new MarkerClusterer(map, markers);
				} else{
					//display error message
					alert(json.error.message);
				}
			}
	);

}






function addMarker(location) { //@TODO zoek uit hoe die location in elkaar zit
	var marker = new google.maps.Marker({
		position: location,
		map: map
	});
	markers.push(marker);
}

//Sets the map on all markers in the array.
function setAllMap(map) {
	for (var i = 0; i < markers.length; i++) {
		markers[i].setMap(map);
	}
}

function addEventListener(marker, interaction, functionToCall) {
	return function() {
		google.maps.event.addListener(marker, interaction, functionToCall);
	};
}

function loadAllMarkers(monuments) {
	var infowindow = new google.maps.InfoWindow();
	for(var i=0;i<monuments.length;i++) {
		var position = new google.maps.LatLng(monuments[i].longitude, monuments[i].latitude);
		var marker = new google.maps.Marker({
			position: position,
			map: map,
			title: monuments[i].town
		})
		google.maps.event.addListener(marker, 'click', (function(marker, i) {
            return function() {
                infowindow.setContent("<a href=\"/monument/" + monuments[i].id + "\">"+monuments[i].name + "<br/>" + monuments[i].street + ", " + monuments[i].streetNumber + "</a>");
                infowindow.open(map, marker);
            }
        })(marker, i));
		markers.push(marker);
	}
}

$(document).ready(function(){
	initialize();
});