<?php 
    session_start();
    include 'connect_mysql.php';
    if ($_SESSION['username']=="" ) {
        header("Location: login.php");
        exit;
    }
?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <title>Room Allocation Planner</title>

        <!-- Required meta tags always come first -->
        <meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <meta http-equiv="x-ua-compatible" content="ie=edge">
        
        <!-- Google Font -->
        <link href="https://fonts.googleapis.com/css?family=Open+Sans:400,600" rel="stylesheet">

        <!-- Bootstrap CSS -->
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-alpha.5/css/bootstrap.min.css" integrity="sha384-AysaV+vQoT3kOAXZkl02PThvDr8HYKPZhNT5h/CXfBThSRXQ6jW5DO2ekP5ViFdi" crossorigin="anonymous">
        <!-- Mapbox CSS -->
        <link href='https://api.tiles.mapbox.com/mapbox-gl-js/v0.29.0/mapbox-gl.css' rel='stylesheet'/>
        <!-- Custom CSS -->
        <link rel="stylesheet" href="css/style.css">
    </head>
    <body>        
        <!-- topbar -->
        <nav id="topbar" class="navbar navbar-fixed-top py-1">
            <div class="container-fluid">
                <a class="navbar-brand" href="http://www.mdh.se/" target="_blank"><img class="img-fluid" src="img/mdh-logo.png" alt="logo"></a>

                <div id="navbar">
                    <div class="float-xs-right">
                        <p class="d-inline mr-3 hidden-sm-down"><span class="name"><?php echo $_SESSION["username"]; ?></span></p> 
                        <a href="logout.php" class="btn btn-outline-warning">Logout</a> 
                    </div> 
                </div>
            </div>
        </nav>
        <!-- end topbar -->
        
        <!-- content--> 
        <div class="container-fluid">
            <div class="row">
                <!-- sidebar-->   
                <ul id="sidebar" class="nav nav-pills nav-stacked col-sm-3 col-md-2">
                    <li class="nav-item">
                        <a class="nav-link" href="index.php">
                            <img class="icon" src="img/add.svg" alt="icon">
                            <span class="hidden-sm-down">Bookings</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="rooms.php">
                            <img class="icon" src="img/view.svg" alt="icon">
                            <span class="hidden-sm-down">Rooms</span>
                        </a>
                    </li>
                    <?php
                    if($_SESSION["role"] == 'admin') {
                    echo '<li class="nav-item">
                        <a class="nav-link" href="admin.php">
                            <img class="icon" style="weight:"24px" height="24px" " src="img/admin.png" alt="icon">
                            <span class="hidden-sm-down">Settings</span>
                        </a>
                    </li>';
                    }
                    ?>
                </ul>
                <!-- end sidebar--> 
                
                <!-- main -->
                <div id="main" class="col-sm-9 offset-sm-3 col-md-10 offset-md-2">
                    <h2 class="mb-2 pl-1">Add Booking</h2>
                    
                    <div class="container-fluid">
                        <div class="row">
                            <div class="col-md-3">
                                <!-- form-->
                                <form action="booking.php" method="post">
                                    <fieldset class="form-group mb-2">
                                        <label for="from">Date From:</label>
                                        <input type="text" class="form-control form-control-warning" id="start_date" placeholder="yyyy-mm-dd" autocomplete="off" maxlength="10">
                                        <div class="form-control-feedback">Date must be in the format of YYYY-MM-DD</div>
                                    </fieldset>
                                    <fieldset class="form-group mb-2">
                                        <label for="to">Date To:</label>
                                        <input type="text" class="form-control form-control-warning" id="end_date" placeholder="yyyy-mm-dd" autocomplete="off" maxlength="10">
                                        <div class="form-control-feedback">Date must be in the format of YYYY-MM-DD</div>
                                    </fieldset>
                                    <fieldset class="form-group mb-2">
                                        <label for="seats">Seats:</label>
                                        <select class="custom-select form-control" id="seats" name="seats_num">
                                            <option value="1">1</option>
                                            <option value="2">2</option>
                                            <option value="3">3</option>
                                            <option value="4">4</option>
                                            <option value="5">5</option>
                                            <option value="6">6</option>
                                        </select> 
                                    </fieldset>
                                    <fieldset class="form-group mb-2">
                                        <label for="room">Room Name:</label>
                                        <select class="custom-select form-control" id="room" name="room_name"></select> 
                                    </fieldset>
                                    <fieldset class="form-group mb-2">
                                        <label for="name">Name:</label>
                                        <?php  if($_SESSION["role"] == 'admin') { ?>
                                            <input type="text" class="form-control" id="name">
                                        <?php } else { ?>
                                            <input type="text" class="form-control" id="name" placeholder="<?php echo $_SESSION["username"]; ?>" disabled>
                                        <?php } ?>
                                    </fieldset>                                   
                                    <input id="add_book" class="btn btn-primary btn-lg" type="button" value="Book">
                                </form><!-- end form-->
                            </div>
                            <!-- Map -->
                            <div id="map" class="col-md-8 offset-md-1"></div>

                            <div class="col-md-12 bg-success mt-3 pb-3">
                                <h3 class="my-2">My Bookings:</h3>
								<ul id="booking" class="list-group">
								<?php
								    $select_path = "SELECT * from reservation WHERE name = '" . $_SESSION["username"] . "'";
									$result = mysqli_query($conn, $select_path);

									while($row = $result->fetch_assoc()){
										echo    '<li class="list-group-item">
											         <h4 class="list-group-item-heading">
													  <span id="li_date_from">' . $row['date_from'] . '</span> - <span id="li_date_to">' . $row['date_to'] . '</span>
													   <span class="tag tag-pill float-xs-right">
												            <a href="#">
                                                                <img class="icon" src="img/cancel.svg" alt="icon">
													        </a> 
													   </span>
												    </h4>
												    <span id="li_room_name">' . $row['room_name'] . '</span>, <span id ="li_seats">' . $row['seats'] . '</span> Seat
											    </li>';
											}
								?>
                                </ul>
                            </div>
                        </div> <!-- end row-->
                    </div> <!-- end container-->
                </div><!-- end main -->
            </div>
        </div>
        <!-- end content--> 
		 
        <!-- jQuery first, then Tether, then Bootstrap JS. -->
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js" integrity="sha384-3ceskX3iaEnIogmQchP8opvBy3Mi7Ce34nWjpBIwVTHfGYWQS9jwHDVRnpKKHJg7" crossorigin="anonymous"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/tether/1.3.7/js/tether.min.js" integrity="sha384-XTs3FgkjiBgo8qjEjBk0tGmf3wPrWtA6coPfQDfFEY8AnYJwjalXCiosYRBIBZX8" crossorigin="anonymous"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-alpha.5/js/bootstrap.min.js" integrity="sha384-BLiI7JTZm+JWlgKa0M0kGRpJbF2J8q+qreVrKBC47e3K6BW78kGLrCkeRX6I9RoK" crossorigin="anonymous"></script>
        <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
        <!-- Mapbox JS -->
        <script src='https://api.tiles.mapbox.com/mapbox-gl-js/v0.29.0/mapbox-gl.js'></script>
        <!-- Custom JS -->
        <script type="text/javascript" src="js/app.js"></script>
		<script type="text/javascript" src="js/map.js"></script>
		<script type="text/javascript" src="js/sqlHandler.js"></script>
    </body>
</html>
