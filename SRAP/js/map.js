
mapboxgl.accessToken = 'pk.eyJ1IjoibW9oYWhtIiwiYSI6ImNpd25pM2o4dzAzc2oyem5uanpyem52bmQifQ.CVOmI-BXOv7qwc6QFHNStA';

var map = new mapboxgl.Map({
	container: 'map',
	style: 'mapbox://styles/mohahm/ciwxzsn5b00112pr2sq10c15g', 	
	zoom: 1 
});

// Add zoom and rotation controls to the map.
map.addControl(new mapboxgl.NavigationControl());

map.on('click', function (e) {
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

		$('#room').val(feature['properties'].id);
	}
	
});

function resetMap(){
	if(map.getLayer('room-0')){
		map.removeLayer('room-0');
	}
	if(map.getLayer('room-1')){
		map.removeLayer('room-1');
	}
	if(map.getSource('rooms')){
		map.removeSource('rooms');
	}
}

/*
map.on('mousemove', function (e) {
 	for (var i = 0; i < 31; i++) {
 		var features = map.queryRenderedFeatures(e.point, { layers: ['room-' + i] });
	
 		map.getCanvas().style.cursor = (features.length) ? 'pointer' : '';
 	}
});

*/



