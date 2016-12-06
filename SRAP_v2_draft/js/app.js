
var $dateInputFrom = $("#from");
var $dateInputTo   = $("#to");
var $seatsSelect   = $("#seats");
var $roomSelect    = $("#room");
var $addButton     = $("#book");
var $booking       = $("#myBooking");

$dateInputFrom.datepicker({
	dateFormat: "yy-mm-dd",
	minDate: 0
});

$dateInputTo.datepicker({
	dateFormat: "yy-mm-dd", 
	minDate: 2
});


var createNewBookElement = function(dateFrom, dateTo, seats, room)
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

