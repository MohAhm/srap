<?php

	$conn = mysqli_connect("localhost", "root", "root", "reserve");
	// Check Connection
	if (!$conn)
	{
	    die ("Connection failed" . mysql_errno());
	}

?>
