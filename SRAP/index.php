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
                </ul>
                <!-- end sidebar--> 
                
                <!-- main -->
                <div id="main" class="col-md-9 offset-md-3 col-sm-10 offset-sm-2 offset-xs-1">
                    <h1 class="mb-2 pl-1">Add Booking</h1>
                    
                    <div class="container-fluid">
                        <div class="row">
                            <div class="col-md-4">
                                <!-- form-->
                                <form action="booking.php" method="post">
                                    <fieldset class="form-group mb-2 has-warning">
                                        <label for="from">Date From:</label>
                                        <input type="text" class="form-control form-control-warning" id="from" placeholder="yy-mm-dd" autocomplete="off"  name="from">
                                    </fieldset>
                                    <fieldset class="form-group mb-2 has-warning">
                                        <label for="to">Date To:</label>
                                        <input type="text" class="form-control form-control-warning" id="to" placeholder="yy-mm-dd" autocomplete="off"  name="to">
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
                                        <select class="custom-select form-control" id="room" name="room_name">
										    <?php
											    $select_path = "select name from room";
												$result = mysqli_query($conn, $select_path);
											    while($row = $result->fetch_assoc()){
												    echo '<option>' . $row['name'] . '</option>';
											    }
											?>
                                        </select> 
                                    </fieldset>
                                    <fieldset class="form-group mb-2">
                                        <label for="name">Name:</label>
                                        <input type="text" class="form-control" id="name" placeholder="<?php echo $_SESSION["username"]; ?>" disabled>
                                    </fieldset>                                   
                                    <input id="book" class="btn btn-primary btn-lg" type="button" value="Book">
                                </form><!-- end form-->
                            </div>
                            <div class="col-md-6 offset-md-2 bg-success pb-3">
                                <h3 class="my-2">My Bookings:</h3>
								<ul id="myBooking" class="list-group">
								<?php
								    $select_path = "SELECT * from reservation";
									$result = mysqli_query($conn, $select_path);

									while($row = $result->fetch_assoc()){
										echo    '<li class="list-group-item">
											         <h4 class="list-group-item-heading">
													  ' . $row['date_from'] . ' - ' . $row['date_to'] . '
													   <span class="tag tag-pill float-xs-right">
												            <a href="#">
                                                                <img class="icon" src="img/cancel.svg" alt="icon">
													        </a> 
													   </span>
												    </h4>
												    ' . $row['room_name'] . ', ' . $row['seats'] . ' Seat
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

        <!-- Custom JS -->
        <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
        <script type="text/javascript" src="js/app.js"></script>
    </body>
</html>