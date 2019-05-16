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

// REGISTER USER
if (isset($_POST['reg_user'])) {
    // Receive the username and password passed by the form
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $username = $conn->real_escape_string($_POST['username']);
        $email = $conn->real_escape_string($_POST['email']);
        $password = md5($_POST['password']); // md5 hash password
        $firstname = $conn->real_escape_string($_POST['firstname']);
        $lastname = $conn->real_escape_string($_POST['lastname']);
        $Tnumber = $conn->real_escape_string($_POST['Tnumber']);
        $startTerm = $conn->real_escape_string($_POST['startTerm']);
        $startYear = $conn->real_escape_string($_POST['startYear']);
        $startTerm = (int)$startTerm;
        $startYear = (int)$startYear;
    }

    // Check to see if year exceeds current year
    if ($startYear <= date("Y")) {
        // First check the database to make sure 
        // a user does not already exist with the same username and/or email
        $user_check_query = "SELECT * FROM Students WHERE user_name='$username' OR Email='$email' LIMIT 1";
        $result = mysqli_query($conn, $user_check_query);
        $user = mysqli_fetch_assoc($result);

        if ($user) { // if user exists
            if ($user['user_name'] === $username) {
                $_SESSION['message'] = "<b>Username already exists.</b> <br/> Please use a different username.";
            }
            if ($user['Email'] === $email) {
                $_SESSION['message'] = "<b>Email already exists.</b> <br/> Please login to your existing account.";
            }
        } else { // Finally,  
            // register if a user does not already exist with the same username and/or email
            // Record the SQL statement required for the insert operation through the $insert_query variable
            $insert_query = "INSERT INTO Students(user_name,PasswordHash,first_name,last_name,Email,t_number,StartTerm,StartYear) VALUES('{$username}','{$password}','{$firstname}','{$lastname}','{$email}','{$Tnumber}','{$startTerm}','{$startYear}')";

            // Insert user information to the database
            mysqli_query($conn, $insert_query);
            $_SESSION['message'] = 'Registration successful. <br/> Welcome to CS Plan of Study!';
            echo ("{$_SESSION['message']}" . "<br />");
            $_SESSION['UserID'] = $user['ID'];
            $_SESSION['first_name'] = $user['first_name'];
            header('location: Login.php');

            // Close connection
            mysqli_close($conn);
        }
    } else {
        // year exceeded current year, so display error message
        $_SESSION['message'] = "The year exceeds the current year.  Please enter a valid starting year.";
    }
}
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Registration</title>
    <!-- Bootstrap and Jquery CDN -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js" async></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" async></script>
    <!-- Font Awesome Icons (used in navbar)-->
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.8.1/css/all.css" integrity="sha384-50oBUHEmvpQ+1lW4y57PTFmhCaXp0ML5d60M1M7uH2+nqUivzIebhndOJK28anvf" crossorigin="anonymous">
    <!-- Custom Stylesheet -->
    <link rel="stylesheet" type="text/css" href="css/Style.css">
    <link rel="stylesheet" type="text/css" href="css/Registration.css">
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
        <form class="form" action="Registration.php" method="post">
            <h1 align="center" class="h1 mb-3 font-weight-normal" style="margin-top:130px;">Registration</h1>
            <?= $_SESSION['message'] ?>
            <label for="inputUsername" class="sr-only">Username</label>
            <input type="username" name="username" id="inputUsername" class="form-control" placeholder="User Name" required autofocus>

            <label for="inputEmail" class="sr-only">Email Address</label>
            <input type="email" name="email" id="inputEmail" class="form-control" placeholder="Email Address" required>

            <label for="inputPassword" class="sr-only">Password</label>
            <input type="password" name="password" id="inputPassword" class="form-control" placeholder="Password" required>

            <label for="inputFirstname" class="sr-only">First Name</label>
            <input type="firstname" name="firstname" id="inputFirstname" class="form-control" placeholder="First Name" required>

            <label for="inputLastname" class="sr-only">Last Name</label>
            <input type="lastname" name="lastname" id="inputFirstname" class="form-control" placeholder="Last Name" required>

            <label for="inputTnumber" class="sr-only">T-number</label>
            <input type="Tnumber" name="Tnumber" id="inputTnumber" class="form-control" placeholder="T-number" required>

            <label for="startTerm" class="sr-only">Select Starting Term for College</label>
            <select class="form-control form-control-lg" name="startTerm" id="startTerm" required>
                <option value="">Select Starting Term for College</option>
                <option value="1">Spring</option>
                <option value="2">Summer</option>
                <option value="3">Fall</option>
            </select>

            <label for="startYear" class="sr-only">Enter Starting Year for College</label>
            <input type="number" name="startYear" id="startYear" class="form-control" placeholder="Enter Starting Year for College" min="2014" required>
            <br/>
            <button class="btn btn-lg btn-primary btn-block" type="submit" name="reg_user">Sign up</button>
        </form>
    </div> <!-- container -->
</body>

</html>