<!DOCTYPE html>
<html lang="en"> 
    <head>
        <title>Login</title> 

        <!-- Required meta tags always come first -->
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <meta http-equiv="x-ua-compatible" content="ie=edge">

        <!-- Bootstrap CSS -->
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-alpha.5/css/bootstrap.min.css" integrity="sha384-AysaV+vQoT3kOAXZkl02PThvDr8HYKPZhNT5h/CXfBThSRXQ6jW5DO2ekP5ViFdi" crossorigin="anonymous">

        <!-- Custom CSS -->
        <link rel="stylesheet" href="css/style.css">
    </head>
    <body>
        <div class="container">
            <form action="verify.php" method="post" class="form-signin mt-3">
                <img class="img-fluid mb-1" src="img/mdh-logo.png" alt="logo">
                <p class="lead mb-3">Login to room allocation planner</p>

                <p>Enter your username and password to login.</p>
                <fieldset class="form-group mb-2">
                    <label for="username">Username:</label>
                    <input type="text" class="form-control" id="username" name="username" maxlength="30">
                </fieldset>
                <fieldset class="form-group mb-2">
                    <label for="password">Password:</label>
                    <input type="password" class="form-control" id="password" name="password" maxlength="30">
                </fieldset>
                <input id="login" class="btn btn-primary btn-lg btn-block mb-2" type="submit" value="Log in">
                
                <?php 
                     if (isset($_GET['error'])) {
                        $error = $_GET['error'];
                    
                ?>
                    <p class="error">
                        <img class="icon" src="img/ic_error.svg" alt="icon">
                        <span><?php echo $error; ?></span>
                    </p> 
                <?php } ?>
            </form>
        </div>

        <!-- jQuery first, then Tether, then Bootstrap JS. -->
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js" integrity="sha384-3ceskX3iaEnIogmQchP8opvBy3Mi7Ce34nWjpBIwVTHfGYWQS9jwHDVRnpKKHJg7" crossorigin="anonymous"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/tether/1.3.7/js/tether.min.js" integrity="sha384-XTs3FgkjiBgo8qjEjBk0tGmf3wPrWtA6coPfQDfFEY8AnYJwjalXCiosYRBIBZX8" crossorigin="anonymous"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-alpha.5/js/bootstrap.min.js" integrity="sha384-BLiI7JTZm+JWlgKa0M0kGRpJbF2J8q+qreVrKBC47e3K6BW78kGLrCkeRX6I9RoK" crossorigin="anonymous"></script>

        <!-- Custom JS -->
        <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
        <script type="text/javascript" src="js/app.js"></script>
    </body>
</html>