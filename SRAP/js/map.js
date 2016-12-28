
mapboxgl.accessToken = 'pk.eyJ1IjoibW9oYWhtIiwiYSI6ImNpd25pM2o4dzAzc2oyem5uanpyem52bmQifQ.CVOmI-BXOv7qwc6QFHNStA';

var map = new mapboxgl.Map({
	container: 'map',
	style: 'mapbox://styles/mohahm/ciwxzsn5b00112pr2sq10c15g', 	
	zoom: 1 
});

// Add zoom and rotation controls to the map.
map.addControl(new mapboxgl.NavigationControl());


map.on('load', function () {
	updateMapAndText();
});

/*
map.on('click', function (e) {
	for (var i = 0; i < 31; i++) {
		
		var features = map.queryRenderedFeatures(e.point, { layers: ['room-' + i] });
		if (!features.length) {
			return;
		}
		
		var feature = features[0];
		var popup = new mapboxgl.Popup()
			.setLngLat(map.unproject(e.point))
			.setHTML(feature.properties.message)
			.addTo(map);
	}
});
*/
/*
map.on('mousemove', function (e) {
 	for (var i = 0; i < 31; i++) {
 		var features = map.queryRenderedFeatures(e.point, { layers: ['room-' + i] });
 		map.getCanvas().style.cursor = (features.length) ? 'pointer' : '';
 	}
});
*/




