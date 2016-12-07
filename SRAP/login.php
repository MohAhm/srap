<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">

    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <link href="css/bootstrap.css" rel="stylesheet">
	<title>Log-in</title>
	<?php
	session_start();
	if(isset($_POST['username'])){
		$_SESSION['username'] = $_POST['username'];
	}
	?>
</head>
<body>
<div class="centered">
<div>
  <img src="img/mdh_logo.png" class="MDHlogo col-sm-offset-1">
  <h3 class="col-sm-offset-1">Login to room allocation planner</h3>
  <h5 class="col-sm-offset-1">Enter your username and password to login.</h5>
</div>

<form class="form-horizontal" action="verify.php" method="post">
  <div class="form-group">
    <label for="inputEmail3" class="col-sm-2 control-label">Username</label>
    <div class="col-sm-10">
      <input type="text" class="form-control" id="inputEmail3" placeholder="Username" name="username">
    </div>
  </div>
  <div class="form-group">
    <label for="inputPassword3" class="col-sm-2 control-label">Password</label>
    <div class="col-sm-10">
      <input type="password" class="form-control" id="inputPassword3" placeholder="Password" name="password">
    </div>
  </div>
  <div class="form-group">
    <div class="col-sm-offset-2 col-sm-10">
      <button type="submit" class="btn btn-warning login">Log in</button>
    </div>
  </div>
</form>

</div>

    <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
    <!-- Include all compiled plugins (below), or include individual files as needed -->
    <script src="js/jquery.js"></script>
    <script src="js/bootstrap.min.js"></script>
</body>
</html>