<?php
session_start();
include 'connect_mysql.php';


$from = $_POST['from'];
$to = $_POST['to'];
$seats = $_POST['seats_num'];//4
$room = $_POST['room_name'];
$b = 'false';

$select_path2 = "select seats
                    from room
                    where name='" . $room . "'";
$result2 = mysqli_query($conn, $select_path2);
$sum2 = '0';
while ($row2 = $result2->fetch_assoc()){
    $sum2 += $row2['seats'];
}
$select_path1 = "select r1.seats-(select sum(r2.seats)
                    from reservation r2
                    where r2.room_name='" . $room . "'
					AND ((('" . $from . "'<=r2.date_to) and ('" . $from . "'>=r2.date_from)) 
					OR (('" . $to . "'>=r2.date_from) AND ('" . $to . "'<=r2.date_to)))) as n
					from room r1
                    where r1.name='" . $room . "'";
$result1 = mysqli_query($conn, $select_path1);
$sum = '0';

while ($row1 = mysqli_fetch_row($result1)) {
		$sum = $row1[0];
    }
if($seats<=$sum or ($sum==NULL and $sum2>=$seats)){
	$sql = sprintf("INSERT INTO reservation VALUES (NULL,'" . $room . "',NULL, '" . $_SESSION['username'] . "','" . $from . "','" . $to . "', '" . $seats . "')");
		  if ($conn->query($sql) === TRUE) {
			header("Location:index.php");
			} else {
			echo "Error: " . $sql . "<br>" . $conn->error;
		}
		 
}else{
	echo "<script>
		alert('That room is not available in that time for that much seats.');
		window.location.href='index.php';
		</script>";
}

?>