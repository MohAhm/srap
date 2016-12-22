<?php
session_start();
include 'connect_mysql.php';

$from = $_POST['from'];
$to = $_POST['to'];
$seats = $_POST['seats'];

if($to != "" && $from != ""){
	$select_path = "
	SELECT t3.room_name, t3.seats
	FROM
		(SELECT t2.room_name, t2.seats FROM
				(SELECT DISTINCT t1.room_name,  
						if(r.seats - t1.seats - '" . $seats . "' >= 0, r.seats - t1.seats, 0) as seats
				FROM	
						(SELECT DISTINCT re.room_name, (SELECT SUM(seats)
											  FROM reservation
											  WHERE (re.room_name = room_name)
												  AND ((date_from <= '" . $from . "' AND date_to >= '" . $from . "') 
												  OR (date_from <= '" . $to . "' AND date_to >= '" . $to . "') 
												  OR ('" . $from . "' <= date_from AND '" . $to . "' >= date_from))) as seats
						FROM reservation re 
						WHERE 
							((date_from <= '" . $from . "' AND date_to >= '" . $from . "') 
							OR (date_from <= '" . $to . "' AND date_to >= '" . $to . "') 
							OR ('" . $from . "' <= date_from AND '" . $to . "' >= date_from))) as t1
				INNER JOIN room r 
				ON r.name = t1.room_name) as t2	
		UNION
		SELECT name, 
		if(r.seats - '" . $seats . "' >= 0, r.seats, 0) as seats
		FROM room r) as t3
	GROUP BY t3.room_name
	HAVING t3.seats <> 0";


		
	$result = mysqli_query($conn, $select_path);

	while($row = $result->fetch_assoc()) {
		echo '<option>' . $row['room_name'] . '</option>';
	}
}


?>