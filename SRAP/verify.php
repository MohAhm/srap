<?php  

	if ($_POST)	{

		$name 	  = htmlspecialchars(trim($_POST['username']));
		$password = htmlspecialchars(($_POST['password']));

		include 'connect_mysql.php';

		$query = mysqli_query($conn, "SELECT username, role FROM user WHERE username LIKE '$name' AND password LIKE '$password'");
		$row = mysqli_fetch_assoc($query);

		if ($row == true) {

			session_start();

			$_SESSION['username'] = $name;	
			$_SESSION['role'] = $row['role']; 

			header("Location:index.php"); 
		}
		else {
			$error = urlencode("Username or password is incorrect.");
			header("Location:login.php?error=$error");
		}	
	}
	  
?>