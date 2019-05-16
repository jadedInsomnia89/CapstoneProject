<?php
session_start();

// Initializing SESSION variables
$_SESSION['message'] = '';
if (!isset($_SESSION['UserID'])) {
    $_SESSION['UserID'] = null;
}
if (!isset($_SESSION['first_name'])) {
    $_SESSION['first_name'] = null;
}

// Create connection
$conn = new mysqli('localhost', 'user', 'a123456') or die("Connection failed: " . $conn->connect_error);

// Select Database
mysqli_select_db($conn, 'data') or die("Could not open the db:");;

// Check to see if Submit Button was clicked
if (isset($_POST['login_user'])) {
    // Receive the username and password passed by the form
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $username = $conn->real_escape_string($_POST['username']);
        $password = md5($_POST['password']); // md5 hash password
    }

    // Check to see if the username exists in the database
    $user_check_query = "SELECT * FROM Students WHERE user_name='$username'; ";
    $result = mysqli_query($conn, $user_check_query);
    $user = mysqli_fetch_assoc($result);

    if ($user) { // if user exists
        if ($user['user_name'] === $username) {
            // Check to see if the password exists in the database
            if ($user['PasswordHash'] == $password) {
                $_SESSION['message'] = 'Login successful';
                $_SESSION['UserID'] = $user['ID'];
                $_SESSION['first_name'] = $user['first_name'];
                header("location: Dashboard.php");
            } else {
                $_SESSION['message'] = 'Password is Incorrect. Please Try Again';
            }
        } 
    }
    else {
            $_SESSION['message'] = 'User Name is Incorrect. Please Try Again';
        }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Login</title>
    <!-- Bootstrap and Jquery CDN -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js" async></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" async></script>
    <!-- Font Awesome Icons (used in navbar)-->
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.8.1/css/all.css" integrity="sha384-50oBUHEmvpQ+1lW4y57PTFmhCaXp0ML5d60M1M7uH2+nqUivzIebhndOJK28anvf" crossorigin="anonymous">
    <!-- Custom Stylesheet -->
    <link rel="stylesheet" type="text/css" href="css/Style.css">
    <link rel="stylesheet" type="text/css" href="css/Login.css">
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
                    <li class="nav-item"><a class="nav-link" href="Login.php"><span class="fas fa-sign-in-alt"></span> Log In</a></li>
                </ul>
            </div>
        </nav>
    </header>

    <div class="container">
        <form class="form" action="Login.php" method="post">
            <h1 align="center" class="h1 mb-3 font-weight-normal" style="margin-top:130px;">Login</h1>
            <?= $_SESSION['message'] ?>
            <label for="inputUsername" class="sr-only">Username</label>
            <input type="username" name="username" id="loginUsername" class="form-control" placeholder="User name" required autofocus>

            <label for="inputPassword" class="sr-only">Password</label>
            <input type="password" name="password" id="loginPassword" class="form-control" placeholder="Password" required>
            <button class="btn btn-lg btn-primary btn-block" type="submit" name="login_user">Submit</button>
            <a class="d-block small mt-3 text-center" href="ForgotPassword.php">Forgot Password?</a>
        </form>
    </div> <!-- container -->
</body>

</html>