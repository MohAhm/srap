<?php
session_start();
include 'connect_mysql.php';

$from = $_POST['from'];
$to = $_POST['to'];

if($to != "" && $from != ""){
	$select_path = "SELECT room_name, seats, name, date_to, date_from 
					FROM reservation 
					WHERE 
						(date_from <= '" . $from . "' AND date_to >= '" . $from . "')
						OR (date_from <= '" . $to . "' AND date_to >= '" . $to . "')
						OR ('" . $from . "' <= date_from AND '" . $to . "' >= date_from)";
						
	$json = array();
	$result = mysqli_query($conn, $select_path);
	while($row = $result->fetch_assoc()) {
		
		$row_array['name'] = $row['name'];
		$row_array['room_name'] = $row['room_name'];
		$row_array['seats'] = $row['seats'];
		$row_array['date_from'] = $row['date_from'];
		$row_array['date_to'] = $row['date_to'];
		array_push($json, $row_array);
		
	}
	echo json_encode($json);	
}

?>
                                    