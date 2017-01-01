<?php
	session_start();
	include 'connect_mysql.php';
	
	$room_name = $_POST['room_name'];
	$available = $_POST['available'];
	$json = string;
	
	// Ugly coding, change later
	if($available == "available for booking") {
		$select_path = "UPDATE room SET available=0 WHERE name='" . $room_name . "'";
		$result = mysqli_query($conn, $select_path);
	} else {
		$select_path = "UPDATE room SET available=1 WHERE name='" . $room_name . "'";
		$result = mysqli_query($conn, $select_path);
	}
	echo json_encode($result);
?>