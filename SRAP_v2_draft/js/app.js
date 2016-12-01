
var new_tbody = document.createElement('tbody');

populate_with_new_rows(new_tbody);
old_tbody.parentNode.replaceChild(new_tbody, old_tbody);



$(document).ready(function(){
	$("#listItem01img").click(function(){
		$("#listItem01").remove();
	});
			
	$("#listItem02img").click(function(){
		$("#listItem02").remove();
	});
});



$("#from").datepicker({
	dateFormat: "yy-mm-dd"
});

$("#to").datepicker({
	dateFormat: "yy-mm-dd"
});