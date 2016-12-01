<?php  
session_start(); 
include 'connect_mysql.php';
$_SESSION["username"]= $_POST["username"]; 
$pass= $_POST["password"]; 
$name = $_SESSION["username"];    
/*$query=("SELECT username FROM user "
          . "WHERE username='" . $name . "' and "
          . "password='" . $pass . "'");   
		  $rs= mysql_query($query,$conn);   
		  $nr = mysql_num_rows($rs);*/
		  
		  $sql = sprintf("SELECT username FROM user WHERE username= '" . $name . "'
		  and password = '" . $pass . "'", mysqli_real_escape_string($conn, $_POST['username']));
          $result = mysqli_query($conn, $sql) or die("1");
          $row = mysqli_fetch_assoc($result) or header("Location:login.php"); 
		  
		  
		  if($row == true){    		  
		  header("Location:index.php");  }
		  
		  
		  ?>