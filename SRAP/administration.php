<?php
    session_start();
    include 'connect_mysql.php';
?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <title>Room Allocation Planner</title>

        <!-- Required meta tags always come first -->
        <meta charset="utf-8">
        <meta http-equiv="x-ua-compatible" content="ie=edge">
        
        <!-- Google Font -->
        <link href="https://fonts.googleapis.com/css?family=Open+Sans:400,600" rel="stylesheet">

        <!-- Bootstrap CSS -->
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-alpha.5/css/bootstrap.min.css" integrity="sha384-AysaV+vQoT3kOAXZkl02PThvDr8HYKPZhNT5h/CXfBThSRXQ6jW5DO2ekP5ViFdi" crossorigin="anonymous">

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
				<ul id="sidebar" class="nav nav-pills nav-stacked col-md-3 col-sm-2 col-xs-2">
                    <li class="nav-item">
                        <a class="nav-link" href="index.php">
                            <img class="icon" src="img/add.svg" alt="icon">
                            <span class="hidden-sm-down">Add Booking</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="rooms.php">
                            <img class="icon" src="img/view.svg" alt="icon">
                            <span class="hidden-sm-down">Rooms</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="administration.php">
                            <img class="icon" style="weight:"24px" height="24px" " src="img/admin.png" alt="icon">
                            <span class="hidden-sm-down">Administration</span>
                        </a>
                    </li>
                </ul>
                <!-- end sidebar--> 
                
                <!-- main -->
                <div id="main" class="col-md-9 offset-md-3 col-sm-10 offset-sm-2 offset-xs-1">
                    <h1 class="mb-3">Rooms Administration</h1>
                    <div class="container-fluid">
                        <div class="row">

                            <!-- tab content -->
                            <div class="tab-content">
                                <div class="tab-pane active" id="textual" role="tabpanel"> 
                                    <table class="table table-striped">
									<?php
										// If admin search, make a second table with all the reservation during that time period and list them with a cancel button
										if($_SESSION["role"] == 'admin') {
												echo '<table class="table table-striped">
														<thead>
															<tr>
																<th>User</th>
																<th>Room</th>
																<th>Seats</th>
																<th>Date</th>
																<th></th>
															</tr>
														</thead>
												<tbody id="AdminList">';
												
													// Print all bookings between those dates
													$select_path = "SELECT room_name, seats, name, date_to, date_from 
																	FROM reservation";
													$result = mysqli_query($conn, $select_path);
													while($row = $result->fetch_assoc()) {
														echo '
														<tr>
																<td>' . $row['name'] . '</td>
																<td>' . $row['room_name'] . '</td> 
																<td>' . $row['seats'] . '</td> 
																<td>' . $row['date_from'] . ' - ' . $row['date_to'] . '</td>
																<td> <a href="#"> 
																		<img class="icon" src="img/cancel.svg" alt="icon"> 
																	 </a> 
																</td> 
														</tr>';
													}
												
												
												echo '</tbody> </table>';
										}
									?>
                                    </table>
                                </div><!-- end tab textual-->
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

        <!-- Custom JS -->
        <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
        <script type="text/javascript" src="js/app.js"></script>
    </body>
</html>