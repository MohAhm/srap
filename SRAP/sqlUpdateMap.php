<?php
session_start();
include 'connect_mysql.php';

$from = $_POST['from'];
$to = $_POST['to'];
$seats = $_POST['seats'];


/*$select_path = "
SELECT *
FROM room r 
INNER JOIN mapcord m 
ON r.name = m.name
";*/
if($to != "" && $from != ""){
	$select_path = "
	SELECT *
	FROM
		(SELECT t3.room_name, t3.seats as seatsLeft
		FROM
			(SELECT t2.room_name, t2.seats FROM
					(SELECT DISTINCT t1.room_name,  
							if(r.seats - t1.seats - 1 >= 0, r.seats - t1.seats, 0) as seats
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
			if(r.seats - 1 >= 0, r.seats, 0) as seats
			FROM room r) as t3
		GROUP BY t3.room_name) as t4
	INNER JOIN mapcord m
	ON m.name = t4.room_name
    INNER JOIN room rr
    ON rr.name = m.name
	
		";

	$json = array();
	$json = 
		array(
			'type'	=> 'geojson',
			'data'	=>	array(
							'type'		 => 'FeatureCollection',
							'features'	 =>	array(	
												// Add rooms
		),),);
		
	$result = mysqli_query($conn, $select_path);
	while($row = $result->fetch_assoc()) {
		$available = "";
		if((int)$row['available'] == 0 || $row['seatsLeft'] < $seats)
			$available = "NotAvailable";
		else $available = "Available";
		

		$tempJson = 
		array(
			'type' 		=> 'Feature',
			'geometry'	=>	array(
								'type'	=> 'Polygon',
								'coordinates' => 
								array(
									array(
										array(
											(float)$row['east'],(float)$row['south']
										),
										array(
											(float)$row['east'],(float)$row['north']
										),
										array(
											(float)$row['west'],(float)$row['north']
										),
										array(
											(float)$row['west'],(float)$row['south']
										),
										array(
											(float)$row['east'],(float)$row['south']
										)
									),
								),
							),
				'properties'=> array( 
									'id' 		=> $row['name'],
									'message' 	=> 'Seats available (' . (int)$row['seatsLeft'] . ')',
									'seatsLeft' => (int)$row['seatsLeft'],
									'status'	=> $available
								),
		);
		array_push($json[data][features], $tempJson);

	}
	echo json_encode($json);
}


?>