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
                <a class="navbar-brand" href="index.php"><img class="img-fluid" src="img/mdh_logo.png" alt="logo"></a>

                <div id="navbar">
                    <div class="float-xs-right">
                        <p class="d-inline mr-3 hidden-sm-down">Welcome: <span class="name"><?php echo $_SESSION["username"]; ?></span></p> 
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
                    <h1 class="mb-3">Available Rooms</h1>
                    <form method="post" class="mb-3">
                        <fieldset class="form-group">
                            <label for="from">Date From:</label>
                            <input type="text" class="form-control" id="from" placeholder="yyyy/mm/dd" name="f">
                        </fieldset>
                        <fieldset class="form-group">
                            <label for="to">Date To:</label>
                            <input type="text" class="form-control" id="to" placeholder="yyyy/mm/dd" name="t">
                        </fieldset>
						<fieldset class="form-group">
                            <label for="seats">Seats:</label>
                            <select class="form-control custom-select" id="seats" name="s">
                                <option value="1">1</option>
                                <option value="2">2</option>
                                <option value="3">3</option>
                                <option value="4">4</option>
                                <option value="5">5</option>
                            </select>
						</fieldset>
                        <button type="submit" class="btn btn-primary" name="searchform">Search</button>
					</form>
                    <div class="container-fluid">
                        <div class="row">
                            <ul class="nav nav-tabs mb-2">
                                <li class="nav-item">
                                    <a class="nav-link active" href="#textual" data-toggle="tab" role="tab">Textual</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" href="#graphic" data-toggle="tab" role="tab">Graphic</a>
                                </li>
                            </ul>

                            <!-- tab content -->
                            <div class="tab-content">
                                <div class="tab-pane active" id="textual" role="tabpanel"> 
                                    <table class="table table-striped">
                                        <thead>
                                            <tr>
                                                <th>Room Number</th>
                                                <th>Seats Available</th>
                                            </tr>
                                        </thead>
                                        <tbody>
										<?php
									  											
											$select_path = "select DISTINCT r.name, r.seats 
											from room r, reservation re
											where r.name != re.room_name";
											$result = mysqli_query($conn, $select_path);
											while($row = $result->fetch_assoc()){
												echo '<tr>
													<th scope="row">' . $row['name'] . '</th>
													<td>' . $row['seats'] . '</td>
													
													</tr>';
											}
											
                                            /*
											if(isset($_POST['searchform'])){
												$s = $_POST['s'];
												$f = $_POST['f'];
												$t = $_POST['t'];
												if($t != '' and $f != ''){
												$select_path = "SELECT r.name as name, r.seats as seats
																from room r
																WHERE r.name not IN (
																select DISTINCT re1.room_name
																from reservation re1
																where (('" . $f . "'<date_to) and ('" . $f . "'>=date_from)) 
																OR (('" . $t . "'>=date_from) AND ('" . $t . "'<=date_to)))";
												$result = mysqli_query($conn, $select_path);
											while($row = $result->fetch_assoc()){
												echo '<tr>
													<th scope="row">' . $row['name'] . '</th>
													<td>' . $row['seats'] . '</td>
													
													</tr>';
											}
											}
											}	
                                            */
                                        										
										?>
                                            <!--<tr>
                                                <th scope="row">U1-048</th>
                                                <td>3</td>
                                                <td>Free</td>
                                            </tr>
                                            <tr>
                                                <th scope="row">U1-052</th>
                                                <td>1</td>
                                                <td>Free</td>
                                            </tr>
                                            <tr>
                                                <th scope="row">U1-057</th>
                                                <td>5</td>
                                                <td>2 left</td>
                                            </tr>-->
                                        </tbody>
                                    </table>
                                </div><!-- end tab textual-->
                                <div class="tab-pane" id="graphic" role="tabpanel">
                                    Map...
                                </div>
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
    </body>
</html>