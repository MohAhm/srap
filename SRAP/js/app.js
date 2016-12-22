
var $startDate 		= $("#start_date");
var $endDate   		= $("#end_date");
var $seats   		= $("#seats");
var $room    		= $("#room");
var $addBookBtn		= $("#add_book");
var $booking		= $("#booking");

var $username 		= $("#username");
var $password 		= $("#password");
var $loginBtn		= $("#login");

$(".form-control-feedback").hide();

// NYI: form handler response to dynamically update available rooms

function getClosestDate(current, offset)
{
	var newDate = new Date();
	newDate.setDate(current.getDate() + offset);
	return newDate;
};

$startDate.datepicker({
	dateFormat: "yy-mm-dd",
	minDate: 0,
	onSelect: function(dateText, inst) {

		var fromDate = new Date(dateText);
		var toDate = $endDate.datepicker('getDate');
		
		// Assert start date is prior to end date
		if ( !(toDate) || (fromDate <= toDate) ) {
			// Call to form handler.
		} else {
			$(this).datepicker('setDate', getClosestDate(toDate, -1));
		}
	}
});

$endDate.datepicker({
	dateFormat: "yy-mm-dd", 
	minDate: 2,
	onSelect: function(dateText, inst) {

		var toDate = new Date(dateText);
		var fromDate = $startDate.datepicker('getDate');

		// Assert start date is prior to end date
		if ( !(fromDate) || (fromDate <= toDate) ) {
			// Call to form handler.
		} else {
			$(this).datepicker('setDate', getClosestDate(fromDate, 1));
		}
	}
});


function createNewBookElement(dateFrom, dateTo, seats, room)
{
	var $listItem = $("<li></li>");
	var $date = $("<h4></h4>");
	var $info = $("<p></p>");

	$listItem.addClass("list-group-item");

	$date.text(dateFrom + " -- " + dateTo);
	$date.addClass("list-group-item-heading");
	$date.append(
		$("<span class='tag tag-pill float-xs-right'/>").append(
			$("<a href='#'/>").append(
				$("<img class='icon' src='img/cancel.svg' alt='icon'/>")
			)
		)	
	);

	$info.text(room + ", " + seats + " Seat");
	$info.addClass("mb-0");

	$listItem.append($date);
	$listItem.append($info);

	return $listItem;
};

var isInputEmpty = function(text) {
	return text.val().length > 0;
};

var isDateInputValid = function(date)
{
	var pattern = /(\d{4})-(\d{2})-(\d{2})/;
	return pattern.test(date);
};

var dateInputEvent = function()
{
	if (isDateInputValid($(this).val())) {
		$(this).next().hide();
		$(this).parent().removeClass("has-warning");
	}
	else {
		$(this).next().show();
		$(this).parent().addClass("has-warning");
	}

};

var textInputEvent = function()
{
	if (isInputEmpty($(this))) {
		$(this).next().hide();
		$(this).parent().removeClass("has-warning");
	}
	else {
		$(this).next().show();
		$(this).parent().addClass("has-warning");
	}
};

// events in input
$startDate.focus(dateInputEvent).keydown(dateInputEvent).keyup(dateInputEvent).change(dateInputEvent);
$endDate.focus(dateInputEvent).keydown(dateInputEvent).keyup(dateInputEvent).change(dateInputEvent);
$username.focus(textInputEvent).keydown(textInputEvent).keyup(textInputEvent);
$password.focus(textInputEvent).keydown(textInputEvent).keyup(textInputEvent);

// add booking
$addBookBtn.click(function()
{
	console.log("Add booking ...");

	var startDateValid = isDateInputValid($startDate.val());
	var endDateValid = isDateInputValid($endDate.val());

	if (startDateValid && endDateValid) {
		var $listItem = createNewBookElement($startDate.val(), $endDate.val(), 
										     $seats.val(), $room.val());

		$booking.append($listItem);

		// ## add values to the db ##
		$.ajax({
			url: 'booking.php',
			type: 'post',
			data: { "from": $startDate.val(), "to": $endDate.val(), "seats_num": $seats.val(), "room_name": $room.val()},
			success: function(response) { }
		});

		// reset values
		$startDate.val("");
		$endDate.val("");
	}
	else if (startDateValid && !(endDateValid)) {
		$endDate.next().show();
		$endDate.parent().addClass("has-warning");
	}
	else if (!(startDateValid) && endDateValid) {
		$startDate.next().show();
		$startDate.parent().addClass("has-warning");
	}
	else {
		$startDate.next().show();
		$startDate.parent().addClass("has-warning");
		$endDate.next().show();
		$endDate.parent().addClass("has-warning");
	}
});


// Update the list of available rooms when booking
function updateAvailableRooms(dateFrom, dateTo, seats)
{
	console.log("Updated available rooms");
	$.ajax({
			url: 'updateAvailableRooms.php',
			type: 'post',
			data: { "from": dateFrom, "to": dateTo, "seats": seats},
			success: function(data){
				// Replace selector list with a new one
				$("#room").html(data);
		}
			
		});
};

// cancel booking
$booking.on("click", "a", function() 
{
	console.log("Cancel");

	// ## delete item from db ##
	var papa = $(this).parentsUntil(".list-group");
	var liRoomname = papa.find("#li_room_name").text();
	var liDateFrom = papa.find("#li_date_from").text();
	var liDateTo = papa.find("#li_date_to").text();

	// ## delete item from db ## 
	$.ajax({
			url: 'removeBooking.php',
			type: 'post',
			data: { "room_name": liRoomname, "from": liDateFrom, "to": liDateTo},
			success: function(response) { console.log("booking removed")}
		});
	
	
	// Remove tablerow
	papa.remove();
	
});


// admin cancel
$( "#AdminList a" ).click(function() {
	
	console.log("Admin cancel");
	
	var papa = $(this).parents('tr');
	var $rows = papa.find("td");
	var rowArray = [];
	
	// Push all values from row to array
	$.each($rows, function() {
		rowArray.push($(this).text());
	});
	
	// Split date string
	var date = rowArray[3].split(' - ');
	
	// ## delete item from db ## 
	$.ajax({
			url: 'removeBooking.php',
			type: 'post',
			data: { "user": rowArray[0],"room_name": rowArray[1], "from": date[0], "to": date[1]},
			success: function(response) { console.log("booking removed")}
		});
	
	
	// Remove tablerow
	papa.remove();
});


