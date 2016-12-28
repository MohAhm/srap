
mapboxgl.accessToken = 'pk.eyJ1IjoibW9oYWhtIiwiYSI6ImNpd25pM2o4dzAzc2oyem5uanpyem52bmQifQ.CVOmI-BXOv7qwc6QFHNStA';

var map = new mapboxgl.Map({
	container: 'map',
	style: 'mapbox://styles/mohahm/ciwxzsn5b00112pr2sq10c15g', 	
	zoom: 1  
});

// Add zoom and rotation controls to the map.
map.addControl(new mapboxgl.NavigationControl());


function updateMap(dateFrom, dateTo, seats)
{
	$.ajax({
			url: 'sqlGetRooms.php',
			type: 'post',
			dataType: 'json',
			data: { "from": dateFrom, "to": dateTo, "seats": seats},
			success: function(data){

				if(map.getSource('rooms') === undefined)
				{	
					console.log("created map");
					map.addSource('rooms', data);
			
					var statusColor = [
					['NotAvailable', '#ED4A4C'],
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
					})
				}
				
				else{
					console.log("updated map");
					map.getSource('rooms').setData(data['data']);
				}
				
		}		
	});
}

map.on('load', function () {
	updateMap();
});

// map.on('click', function (e) {
// 	for (var i = 0; i < 31; i++) {
	
// 		var features = map.queryRenderedFeatures(e.point, { layers: ['room-' + i] });
// 		if (!features.length) {
// 			return;
// 		}

// 		var feature = features[0];

// 		var popup = new mapboxgl.Popup()
// 			.setLngLat(map.unproject(e.point))
// 			.setHTML(feature.properties.message)
// 			.addTo(map);
// 	}
// });

// map.on('mousemove', function (e) {
// 	for (var i = 0; i < 31; i++) {
// 		var features = map.queryRenderedFeatures(e.point, { layers: ['room-' + i] });
// 		map.getCanvas().style.cursor = (features.length) ? 'pointer' : '';
// 	}
// });




