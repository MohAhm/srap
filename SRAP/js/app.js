
var $dateInputFrom = $("#from");
var $dateInputTo   = $("#to");
var $seatsSelect   = $("#seats");
var $roomSelect    = $("#room");
var $addButton     = $("#book");
var $booking       = $("#myBooking");

// NYI: form handler response to dynamically update available rooms

function getClosestDate(current, offset)
{
	var newDate = new Date();
	newDate.setDate(current.getDate() + offset);
	return newDate;
};

$dateInputFrom.datepicker({
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

$dateInputTo.datepicker({
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

// add booking
$addButton.click(function()
{
	console.log("Add booking ...");

	// here: should be some validation on inputs before calling createNewBookElement function
	var $listItem = createNewBookElement($dateInputFrom.val(), $dateInputTo.val(), 
									     $seatsSelect.val(), $roomSelect.val());

	$booking.append($listItem);

	// ## add values to the db ##

	// reset values
	$dateInputFrom.val("");
	$dateInputTo.val("");
	$seatsSelect.val(0);
});

// cancel booking
$booking.on("click", "a", function() 
{
	console.log("Cancel");

	$(this).parentsUntil(".list-group").remove();

	// ## delete item from db ##
});

