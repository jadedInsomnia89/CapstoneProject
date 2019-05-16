<?php
session_start();

// Initializing SESSION variables
$_SESSION['message'] = '';
$subject = '';
$message = '';
$headers = '';

// Create connection
$conn = new mysqli('localhost', 'user', 'a123456') or die("Connection failed: " . $conn->connect_error);

// Select Database
mysqli_select_db($conn, 'data') or die("Could not open the db:");;

if (isset($_POST['forgot'])) {
    $email = $conn->real_escape_string($_POST['email']);

    $query = "SELECT * FROM Students WHERE Email = '$email' LIMIT 1";
    $result = mysqli_query($conn, $query);
    $user = mysqli_fetch_assoc($result);

    if ($user) {
        $to      = $email;
        $subject = 'Your UALR Plan Of Study Software Password Reset';
        $message = '<html>
                      <head>
                        <title>Your UALR Plan Of Study Software Password Reset</title>
                      </head>
                      <body>
                        <p>Thank you for using UALR Plan of Study Software.</p>
                        <p>Your password reset link is: https://38dbf52bfc6f4179802bfb7dec4844bd.vfs.cloud9.us-east-2.amazonaws.com/ResetPassword.php?Email=' . $email . '</p>
                        <p>This is an automated email. Please do not reply.</p>
                      </body>
                    </html>';
        // To send HTML mail, the Content-type header must be set
        $headers  = 'MIME-Version: 1.0' . "\r\n";
        $headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
        $headers .= 'From: PlanOfStudy@ualr.edu';

        mail($to, $subject, $message, $headers);

        // Display success message
        $_SESSION['message'] = "<b>Your link has been sent.</b>";
    } else {
        $_SESSION['message'] = "<b>The email address you entered has not been registered yet.</b>";
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
    <title>Forgot Password</title>
    <!-- Bootstrap and Jquery CDN -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js" async></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" async></script>
    <!-- Font Awesome Icons (used in navbar)-->
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.8.1/css/all.css" integrity="sha384-50oBUHEmvpQ+1lW4y57PTFmhCaXp0ML5d60M1M7uH2+nqUivzIebhndOJK28anvf" crossorigin="anonymous">
    <!-- Custom Stylesheet -->
    <link rel="stylesheet" type="text/css" href="css/Style.css">
    <link rel="stylesheet" type="text/css" href="css/ForgotPassword.css">
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
      <form class="form" action="ForgotPassword.php" method="post">
        <h3 class="h3 mb-3 font-weight-normal" style="margin-top:100px;">Forgot your password?</h3>
        <p>Enter your <b>email address</b>. <br /> We'll send you an email with your link to reset your password.</p>
        <?= $_SESSION['message'] ?>
    
        <label for="inputEmail" class="sr-only">Email address</label>
        <input type="email" name="email" id="inputEmail" class="form-control" placeholder="Enter email address" required>
    
        <button class="btn btn-lg btn-primary btn-block" type="submit" name="forgot">Reset Password</button>
      </form>
    </div> <!-- container -->
  </body>
</html> 