<?php 
	session_start(); 
	include 'connect_mysql.php';
	// including swiftmailer library
	require __DIR__ . '/vendor/autoload.php';

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

	// check if admin cancel a booking
	if($_SESSION["role"] == 'admin'){
		$selectRole = "SELECT role, mail FROM user WHERE username= '" . $user . "'";
		$result2 = mysqli_query($conn, $selectRole);
	    $row1 = mysqli_fetch_assoc($result2);

	    // send email if admin canceling a user booking (not admin's)
	    if($row1['role'] != 'admin'){
	    	$userMail = $row1['mail']; 

	    	$selectAdminInfo = "SELECT mail, mail_pwd FROM user WHERE username= '" . $_SESSION['username'] . "'";
			$result3 = mysqli_query($conn, $selectAdminInfo);
	    	$row2 = mysqli_fetch_assoc($result3);
	    	$adminMail = $row2['mail'];
	    	$adminPwd = $row2['mail_pwd'];


			// Create transport
			$transport = Swift_SmtpTransport::newInstance();
            $transport->setUsername($adminMail);
            $transport->setPassword($adminPwd);
            $transport->setHost('smtp-mail.outlook.com');
            $transport->setPort(587)->setEncryption('tls');
			// Create mailer
			$mailer = Swift_Mailer::newInstance($transport);

			// Create a message
			$message = Swift_Message::newInstance();
			$message->setSubject('Cancel Booking!');
			$message->setFrom(array($adminMail => 'Admin'));
			$message->setTo(array($userMail));
			$message->setBody("Your booking seat/seats on the room <b>$room</b> has been canceled by administrator", 'text/html');

			// Send the message
			$mailer->send($message);
	    }
	}

?>