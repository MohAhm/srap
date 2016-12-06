<?php
session_start();
include 'connect_mysql.php';

$from = $_POST['from'];
$to = $_POST['to'];
$seats = $_POST['seats_num'];
$room = $_POST['room_name'];
$b = 'false';

$select_path1 = "select r.seats-sum(re.seats) as n
					from room r, reservation re
					where r.name=re.room_name and
					r.name='" . $room . "' 
					AND ((('" . $from . "'<=re.date_to) and ('" . $from . "'>=re.date_from)) 
					OR (('" . $to . "'>=re.date_from) AND ('" . $to . "'<=re.date_to)))";
$result1 = mysqli_query($conn, $select_path1);
$sum = '0';
while ($row1 = $result1->fetch_assoc()){
    $sum += $row1['n'];
}
echo $sum;
if($sum>=$seats){
	$sql = sprintf("INSERT INTO reservation VALUES (NULL,'" . $room . "',NULL, '" . $_SESSION['username'] . "','" . $from . "','" . $to . "', '" . $seats . "')");
		  if ($conn->query($sql) === TRUE) {
			header("Location:index.php");
			} else {
			echo "Error: " . $sql . "<br>" . $conn->error;
		}
		  
		  if($row == true){ 
				echo "works";
		  //header("Location:index.php"); 
		  }
}else{
	echo "<script>
		alert('That room is not available in that time for that much seats.');
		window.location.href='index.php';
		</script>";
}

?>