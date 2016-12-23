
mapboxgl.accessToken = 'pk.eyJ1IjoibW9oYWhtIiwiYSI6ImNpd25pM2o4dzAzc2oyem5uanpyem52bmQifQ.CVOmI-BXOv7qwc6QFHNStA';

var map = new mapboxgl.Map({
	container: 'map',
	style: 'mapbox://styles/mohahm/ciwxzsn5b00112pr2sq10c15g', 	
	zoom: 1,
	interactive: true	 
});

map.on('load', function () {
	// interactive room will be here ... 
	map.addSource('rooms', {
		'type': 'geojson',
		'data': {
			"type": "FeatureCollection",
			"features": [{
		        'type': 'Feature',
			    'geometry': {
			        'type': 'Polygon',
			        'coordinates': [[[-124.49707031249999, 28.536274512989916],
			        	[-124.49707031249999, 44.308126684886126],
						[-115.53222656249999, 44.308126684886126],
			            [-115.53222656249999, 28.536274512989916],
			            [-124.49707031249999, 28.536274512989916]]]
			    },
			    "properties": {
			        "id": "U1-073",
			        "name": "This room is fully Occupied",
			        "status": "NotAvailable"
			    }
		    }, {
		    	'type': 'Feature',
			    'geometry': {
			        "type": "Polygon",
					"coordinates": [[[-77.2119140625, -47.39834920035925],
					   [-77.2119140625, -30.372875188118016],
					   [-64.4677734375, -30.372875188118016],
					   [-64.4677734375, -47.39834920035925],
					   [-77.2119140625, -47.39834920035925]]]
				},
				"properties": {
				    "id": "U1-049",
				    "name": "Is free",
				    "status": "Available"
				}
		    }, {
		        'type': 'Feature',
			    'geometry': {
			    	"type": "Polygon",
					"coordinates": [[[-56.953125, 28.459033019728043],
            			[-56.953125, 44.37098696297173],
            			[-44.12109374999999, 44.37098696297173],
            			[-44.12109374999999, 28.459033019728043],
            			[-56.953125, 28.459033019728043]]]
			    },
			    "properties": {
			        "id": "U1-084b",
			        "name": "There still room for you",
			        "status": "PartAvailable"
			    }
		    }]
		}
	});

	var statusColor = [
		['NotAvailable', '#ED4A4C'],
		['PartAvailable', '#F5AD44'],
		['Available', '#8AC854']
    ];

	statusColor.forEach(function (layer, i) {
		map.addLayer({
		    "id": "room-" + i,
		    "type": "fill",
		    "source": "rooms",
		    "paint": {
		        'fill-color': layer[1], 
		         "fill-opacity": 0.75
		    },
			"filter":["==", "status", layer[0]]
		});
	});


});

map.on('click', function (e) {
	var features = map.queryRenderedFeatures(e.point, { layers: ['room-0', 'room-1', 'room-2'] });
	if (!features.length) {
		return;
	}

	var feature = features[0];

	var popup = new mapboxgl.Popup()
		.setLngLat(map.unproject(e.point))
		.setHTML(feature.properties.name)
		.addTo(map);
});

map.on('mousemove', function (e) {
	var features = map.queryRenderedFeatures(e.point, { layers: ['room-0', 'room-1', 'room-2'] });
	map.getCanvas().style.cursor = (features.length) ? 'pointer' : '';
});

// Add zoom and rotation controls to the map.
map.addControl(new mapboxgl.NavigationControl());


