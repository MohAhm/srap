<?php
session_start();
include 'connect_mysql.php';


$from = $_POST['from'];
$to = $_POST['to'];
$user = $_SESSION['username'];
$room = $_POST['room_name'];

if(!empty($_POST['user'])){
	$user = $_POST['user'];
}

$select_path = "DELETE FROM reservation
                WHERE 
				date_from = '" . $from . "' AND 
				date_to = '" . $to . "' AND 
				name = '" . $user . "' AND 
				room_name = '" . $room . "'";
$result = mysqli_query($conn, $select_path);

?>