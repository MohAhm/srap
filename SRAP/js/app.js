
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
		var toDate = $dateInputTo.datepicker('getDate');

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
		var fromDate = $dateInputFrom.datepicker('getDate');

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

// cancel booking
$booking.on("click", "a", function() 
{
	console.log("Cancel");
	
	$(this).parentsUntil(".list-group").remove();

	// ## delete item from db ##
});

$( "#AdminList a" ).click(function() {
	$(this).parents('tr').remove();
});


