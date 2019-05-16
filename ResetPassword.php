<?php
session_start();

// Initializing SESSION variables
$_SESSION['message'] = '';
if (!isset($_SESSION['email'])) {
    $_SESSION['email'] = $_GET['Email'];
}
// Create connection
$conn = new mysqli('localhost', 'user', 'a123456') or die("Connection failed: " . $conn->connect_error);

// Select Database
mysqli_select_db($conn, 'data') or die("Could not open the db:");;

//Save new password
if (isset($_POST['reset'])) {
    $password = md5($_POST['password']);


    $query = "UPDATE Students SET PasswordHash = '" . $password . "' WHERE Email = '" . $_SESSION['email'] . "'";
    $result = mysqli_query($conn, $query);
    if ($result) {
        $_SESSION['message'] = "Your password has been changed successfully";
        header("location: Login.php");
    } else {
        $_SESSION['message'] = "An error occurred. Please try the again or contact us";
    }
}

// Close connection
mysqli_close($conn);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Reset Password</title>
    <!-- Bootstrap and Jquery CDN -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js" async></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" async></script>
    <!-- Font Awesome Icons (used in navbar)-->
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.8.1/css/all.css" integrity="sha384-50oBUHEmvpQ+1lW4y57PTFmhCaXp0ML5d60M1M7uH2+nqUivzIebhndOJK28anvf" crossorigin="anonymous">
    <!-- Custom Stylesheet -->
    <link rel="stylesheet" type="text/css" href="css/Style.css">
    <link rel="stylesheet" type="text/css" href="css/ResetPassword.css">
</head>

<body>
    <header>
        <nav class="navbar fixed-top navbar-expand-sm navbar-custom">
            <a class="navbar-brand" href="https://ualr.edu"><img src="img/ualrLogo.png"></a>
            <button class="navbar-toggler ml custom-toggler" type="button" data-toggle="collapse" data-target="#collapsibleNavbar">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="collapsibleNavbar">
                <ul class="navbar-nav">
                    <li class="nav-item"><a class="nav-link" href="Index.php"><span class="fas fa-home"></span> Home</a></li>
                    <li class="nav-item"><a class="nav-link" href="GPACalculator.php"><span class="fas fa-calculator"></span></span> GPA Calculator</a></li>
                    <li class="nav-item"><a class="nav-link" href="Registration.php"><span class="fas fa-user-plus"></span> Register</a></li>
                    <li class="nav-item"><a class="nav-link" href="Login.php"><span class="fas fa-sign-in-alt"></span> Login</a></li>
                </ul>
            </div>
        </nav>
    </header>

    <div class="container">
        <form class="form" action="ResetPassword.php" method="post">
            <h4 class="h3 mb-3 font-weight-normal" align="center" style="margin-top:150px;">Reset your password</h4>
            <?= $_SESSION['message'] ?>
            <label for="inputPassword" class="sr-only">Password</label>
            <input type="password" name="password" id="inputPassword" class="form-control" placeholder="Enter Your New Password" required>
            <button class="btn btn-lg btn-primary btn-block" type="submit" name="reset">Reset Password</button>
        </form>
    </div> <!-- container -->
</body>

</html> 