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
                        <p class="d-inline mr-3 hidden-sm-down">
                            <img class="icon" src="img/ic_person.svg" alt="icon">
                            <span class="name"><?php echo $_SESSION["username"]; ?></span>
                        </p> 
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
                            <img class="icon" src="img/ic_add.svg" alt="icon">
                            <span class="hidden-sm-down">Booking</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link active" href="rooms.php">
                            <img class="icon" src="img/ic_room.svg" alt="icon">
                            <span class="hidden-sm-down">Rooms</span>
                        </a>
                    </li>
                    <?php
                    if($_SESSION["role"] == 'admin') {
                    echo '<li class="nav-item">
                        <a class="nav-link" href="admin.php">
                            <img class="icon" src="img/ic_settings.svg" alt="icon">
                            <span class="hidden-sm-down">Settings</span>
                        </a>
                    </li>';
                    }
                    ?>
                </ul>
                <!-- end sidebar--> 
                
                <!-- main -->
                <div id="main" class="col-sm-9 offset-sm-3 col-md-10 offset-md-2">
                    <h2 class="mb-3 pl-1">Available Rooms</h2>
                    <div class="container-fluid">
                        <div class="row">
                            <div class="col-md-3">
                                <form method="post" class="mb-3">            
                                    <fieldset class="form-group mb-2">
                                        <label for="from">Date From:</label>
                                        <input type="text" class="form-control form-control-warning" id="start_date" placeholder="yyyy-mm-dd" autocomplete="off" maxlength="10" name="from">
                                        <div class="form-control-feedback">Date must be in the format of YYYY-MM-DD</div>
                                    </fieldset>
                                    <fieldset class="form-group mb-2">
                                        <label for="to">Date To:</label>
                                        <input type="text" class="form-control form-control-warning" id="end_date" placeholder="yyyy-mm-dd" autocomplete="off" maxlength="10" name="to">
                                        <div class="form-control-feedback">Date must be in the format of YYYY-MM-DD</div>
                                    </fieldset>
                                    <fieldset class="form-group">
                                        <label for="seats">Seats:</label>
                                        <select class="form-control custom-select" id="seats" name="s">
                                            <option value="1">1</option>
                                            <option value="2">2</option>
                                            <option value="3">3</option>
                                            <option value="4">4</option>
                                            <option value="5">5</option>
                                            <option value="6">6</option>
                                        </select>
                                    </fieldset>                  
                                </form>
                            </div>
                            <div class="col-md-8 offset-md-1">
                                <ul class="nav nav-tabs mb-2">
                                    <li class="nav-item">
                                        <a class="nav-link" href="#textual" data-toggle="tab" role="tab">Textual</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link active" href="#graphic" data-toggle="tab" role="tab">Map</a>
                                    </li>
                                </ul>

                                <!-- tab content -->
                                <div class="tab-content mb-3">
                                    <div class="tab-pane" id="textual" role="tabpanel"> 
                                        <table class="table table-striped">
                                            <thead>
                                                <tr>
                                                    <th>Room Number</th>
                                                    <th>Seats Available</th>
                                                </tr>
                                            </thead>
                                            <tbody id="textTableBodyRooms">
        											<!-- app.js, function( updateTableInRoom ) will fill the table -->
                                            </tbody>
                                        </table>
                                    </div><!-- end tab textual-->
                                    <div class="tab-pane active" id="graphic" role="tabpanel">
                                        <div id="map"></div>
                                    </div>
                                </div>
                            </div> 
                        </div><!-- end row2-->
                    </div><!-- end container2-->
                </div><!-- end main -->
            </div><!-- end row1-->
        </div><!-- end container1-->

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
