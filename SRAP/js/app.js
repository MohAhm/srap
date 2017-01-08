 
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
}

function createNewBookElement(dateFrom, dateTo, seats, room)
{
	var $listItem = $("<li></li>");
	var $dateHolder = $("<h4></h4>");
	var $dateTo = $("<span id='li_date_to'></span>");
	var $dateFrom = $("<span id='li_date_from'></span>");
	var $rName = $("<span id='li_room_name'></span>");
	var $seats = $("<span id='li_seats'></span>");

	$listItem.addClass("list-group-item");
	
	$dateTo.text(dateTo);
	$dateFrom.text(dateFrom);
	$rName.text(room);
	$seats.text(seats);
	
	$dateHolder.addClass("list-group-item-heading");
	$dateHolder.append($dateFrom);
	$dateHolder.append(" - ");
	$dateHolder.append($dateTo);
	$dateHolder.append(
		$("<span class='tag tag-pill float-xs-right'/>").append(
			$("<a href='#'/>").append(
				$("<img class='icon' src='img/ic_delete.svg' alt='icon'/>")
			)
		)	
	);

	$listItem.append($dateHolder);
	$listItem.append($rName);
	$listItem.append(", ");
	$listItem.append($seats);
	if(seats > 1)
		$listItem.append(" Seats");
	else
		$listItem.append(" Seat");
	
	return $listItem;
}

var isInputEmpty = function(text) {
	return text.val().length > 0;
};

var isDateInputValid = function(date)
{
	var pattern = /(\d{4})-(\d{2})-(\d{2})/;
	return pattern.test(date);
};

var isRoomEmpty = function() {
	return $room.children().length > 0;
};

function dateInputEvent(date)
{
	if (isDateInputValid(date.val())) {
		date.next().hide();
		date.parent().removeClass("has-warning");
	}
	else {
		date.next().show();
		date.parent().addClass("has-warning");
	}

}

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

		$(this).change();
	}
}).on("input change", function() 
{
	console.log("Start date change ...");

    dateInputEvent($(this));
    
	var path = window.location.pathname;
	if(path.includes('index.php')){
		enableBookingEvent();
		updateMapAndText($startDate.val(), $endDate.val(), $seats.val());
	}
	else if(path.includes('rooms.php')){
		updateMapAndText($startDate.val(), $endDate.val(), $seats.val());
	}
	else if(path.includes('admin.php')){
		updateAdminList($startDate.val(), $endDate.val());
	}
    
});

$endDate.datepicker({
	dateFormat: "yy-mm-dd", 
	minDate: 0,
	onSelect: function(dateText, inst) {

		var toDate = new Date(dateText);
		var fromDate = $startDate.datepicker('getDate');

		// Assert start date is prior to end date
		if ( !(fromDate) || (fromDate <= toDate) ) {
			// Call to form handler.
		} else {
			$(this).datepicker('setDate', getClosestDate(fromDate, 1));
		}

		$(this).change();
	}
}).on("input change", function() 
{
	console.log("End date change ...");

    dateInputEvent($(this)); 

    var path = window.location.pathname;
	if(path.includes('index.php')){
		enableBookingEvent();
		updateMapAndText($startDate.val(), $endDate.val(), $seats.val());
	}
	else if(path.includes('rooms.php')){
		updateMapAndText($startDate.val(), $endDate.val(), $seats.val());
	}
	else if(path.includes('admin.php')){
		updateAdminList($startDate.val(), $endDate.val());
	}
});

$seats.change(function() 
{
	var path = window.location.pathname;
	if(path.includes('index.php')){
		updateMapAndText($startDate.val(), $endDate.val(), $seats.val());
	}
	else if(path.includes('rooms.php')){
		updateMapAndText($startDate.val(), $endDate.val(), $seats.val());
	}

});

// add booking
$addBookBtn.click(function()
{
	console.log("Add booking ...");

	var $listItem = createNewBookElement($startDate.val(), $endDate.val(), $seats.val(), $room.val());

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
	$("#room").children().remove();
	$("#name").val("");
	resetMap();

}).prop("disabled", !canBook());

// cancel booking
$booking.on("click", "a", function() 
{
	console.log("Cancel");

	var papa = $(this).parentsUntil(".list-group");
	var liRoomname = papa.find("#li_room_name").text();
	var liDateFrom = papa.find("#li_date_from").text();
	var liDateTo = papa.find("#li_date_to").text();
	
	console.log(liRoomname);

	// ## delete item from db ## 
	$.ajax({
			url: 'removeBooking.php',
			type: 'post',
			data: { "room_name": liRoomname, "from": liDateFrom, "to": liDateTo},
			success: function(response) { console.log("booking removed");}
		});
	
	// Remove tablerow
	papa.remove();
	
});

// admin cancel
$( "#AdminList" ).on("click", "a", function() {
	
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
			success: function(response) { console.log("booking removed");}
		});
	
	// Remove tablerow
	papa.remove();
});

// Admin change room availability
$("#change_room_availability").click(function() {
	
	var papa = $(this).parents('form');
	var selector = $("#room_n").val().split(' - ');
	
	console.log("Switch availability in room");
	
	papa.find("option").remove();
	
	$.ajax({
		url: 'roomavailable.php' ,
		type: 'post' ,
		data: { "room_name": selector[0], "available": selector[1]},
		success: function(response) { console.log(response); }
	});
	
	window.location = "admin.php";
});


// disable button for empty inputs
function canBook() {
	return isDateInputValid($startDate.val()) && isDateInputValid($endDate.val());
}

var enableBookingEvent = function() {
	$addBookBtn.prop("disabled", !canBook());
};


function canLogin() {
	return isInputEmpty($username) && isInputEmpty($password);
}

function enableLoginEvent() {
	$loginBtn.prop("disabled", !canLogin());
}

$username.focus(enableLoginEvent).keyup(enableLoginEvent);
$password.focus(enableLoginEvent).keyup(enableLoginEvent);

enableLoginEvent();


