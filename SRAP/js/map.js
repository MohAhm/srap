
mapboxgl.accessToken = 'pk.eyJ1IjoibW9oYWhtIiwiYSI6ImNpd25pM2o4dzAzc2oyem5uanpyem52bmQifQ.CVOmI-BXOv7qwc6QFHNStA';

var map = new mapboxgl.Map({
	container: 'map',
	style: 'mapbox://styles/mohahm/cixet3y5600l12pnwzrv3s2xi', 	
	minZoom: 1,
	center: [-16.87, -1.43] 
});

// Add zoom and rotation controls to the map.
map.addControl(new mapboxgl.NavigationControl());

map.on('click', function (e) {
	
	// If the green layer exist, get it, and then add a popup-marker to the clicked point
	if(map.getLayer('room-0')){
		var features = map.queryRenderedFeatures(e.point, { layers: ['room-0'] });
		if (!features.length) {
			return;
		}

		var feature = features[0];
		var popup = new mapboxgl.Popup()
			.setLngLat(map.unproject(e.point))
			.setHTML(feature.properties.message)
			.addTo(map);

		// Change the choosed room to the new
		$('#room').val(feature['properties'].id);
	}
	
});

map.on('mousemove', function (e) {
 	
 	if(map.getLayer('room-0')) {
 		var features = map.queryRenderedFeatures(e.point, { layers: ['room-0'] });
 		map.getCanvas().style.cursor = (features.length) ? 'pointer' : '';
 	}
 	
});

function resetMap(){
	
	// room-0 is the green layer
	if(map.getLayer('room-0')){
		map.removeLayer('room-0');
	}
	// room-1 is the red layer
	if(map.getLayer('room-1')){
		map.removeLayer('room-1');
	}
	// rooms is the source all the layers is stacked on
	if(map.getSource('rooms')){
		map.removeSource('rooms');
	}
}







