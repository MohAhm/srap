function updateMapAndText(dateFrom, dateTo, seats)
{
	// Callback function to get a list of object(rooms)
	getAvailableRooms(dateFrom, dateTo, seats, function(returnValue) {
		
		// ## UPDATE MAP ##
		// If source layer dosn't exist on map, create it
		if(map.getSource('rooms') === undefined)
		{
			console.log("created map");
			// Add source to the map with JSONdata from DB
			map.addSource('rooms', returnValue);

			var statusColor = [
			['Available', '#8AC854'],
			['NotAvailable', '#ED4A4C'],
			];

			// Creates two layers, red and green depending if the room are available for booking
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
		}
		
		// else if source layer exist, just update map
		else{
			console.log("updated map");
			map.getSource('rooms').setData(returnValue['data']);
		}
		
		
		
		
		// ## UPDATE TEXT ##
		// Depending on webpage, server updates different
		var path = window.location.pathname;
		
		if(path.includes('index.php')){
			// Build a string to echo it for the selector list
			var selectString = "";
			$.each( returnValue['data']['features'], function( key, value ) {
				if(value['properties'].status == 'Available' && value['properties'].seatsLeft > 0)
					selectString += '<option>' + value['properties'].id + '</option>';
			});

			// Replace selector list with a new one
			$("#room").html(selectString);
		}
		
		
		else if(path.includes('rooms.php')){
			// Clear the table body
			$('#textTableBodyRooms > tr').remove();
			// Add the rooms to the table
			$.each( returnValue['data']['features'], function( key, value ) {
				if(value['properties'].status == 'Available' && value['properties'].seatsLeft > 0)
					$("#textTableBodyRooms").append('<tr><th scope="row">' + value['properties'].id + '</th><td>' + value['properties'].seatsLeft + '</td></tr>');
			});
		}		
		
	});
}


function updateAdminList(dateFrom, dateTo)
{
	console.log("updateAdminList");
	$.ajax({
			url: 'sqlAdminFetch.php',
			type: 'post',
			dataType: 'json',
			data: { "from": dateFrom, "to": dateTo},
			success: function(data){
				// Remove current table
				$('#AdminList > tr').remove();
				
				// Loop through result and add it to the table
				$.each( data, function( key, value ) {
					$("#AdminList").append(
					'<tr>' +
							'<td>' + value.name + '</td>' +
							'<td>' + value.room_name + '</td>' + 
							'<td>' + value.seats + '</td>' + 
							'<td>' + value.date_from + ' - ' + value.date_to + '</td>' +
							'<td> <a href="#">' +
									'<img class="icon" src="img/ic_delete.svg" alt="icon">' + 
								 '</a>' + 
							'</td>' + 
					'</tr>');
				});
			$("#AdminList").append('</tbody> </table>');
		}
			
	});
}


// Get an array of the available rooms
function getAvailableRooms(dateFrom, dateTo, seats, callback)
{
	// Callback function that delivers a JSON with the rooms from DB
	console.log("getAvailableRooms");
	$.ajax({
			url: 'sqlUpdateMap.php',
			type: 'post',
			dataType: 'json',
			data: { "from": dateFrom, "to": dateTo, "seats": seats},
			success: function(data){
				callback(data);
		}
			
	});
}

