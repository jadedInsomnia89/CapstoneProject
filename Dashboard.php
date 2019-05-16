<?php
session_start();

// Create connection
$conn = new mysqli('localhost', 'user', 'a123456') or die("Connection failed: " . $conn->connect_error);
// Select Database
mysqli_select_db($conn, 'data') or die("Could not open the db:");;

// Calculating current GPA
$user_check_query = "SELECT Enroll.grade, Courses.credit_hours FROM Enroll LEFT JOIN Courses ON Enroll.course_ID = Courses.ID WHERE Enroll.student_ID =" . $_SESSION['UserID'];
$result = mysqli_query($conn, $user_check_query);

while ($user = mysqli_fetch_assoc($result)) { // if user records exists
    if ($user[grade] !== NULL)  { // and their grade isn't null
      $credit_attempted = $credit_attempted + $user[credit_hours];
      $points_earned = $points_earned + ($user[credit_hours] * $user[grade]);
    }
}

$gpa_raw = $points_earned / $credit_attempted;

if ($gpa_raw === false) { // if user doesn't have any records
    $gpa = " <b>Currently, we don't have any records to calcuate your GPA</b>";
} else {
    $gpa = round($gpa_raw, 2);
}
// Calculating current GPA -- END

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Dashboard</title>
    <!-- Bootstrap and Jquery CDN -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" async></script>
    <!-- Font Awesome Icons (used in navbar)-->
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.8.1/css/all.css" integrity="sha384-50oBUHEmvpQ+1lW4y57PTFmhCaXp0ML5d60M1M7uH2+nqUivzIebhndOJK28anvf" crossorigin="anonymous">
    <!-- Custom Stylesheet -->
    <link rel="stylesheet" type="text/css" href="css/Style.css">
    <link rel="stylesheet" type="text/css" href="css/Dashboard.css">
    <!-- <script src="js/AddRemoveRows.js"></script> -->
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

                    <!-- check to see if user is logged in or not - if logged in, display logout button, otherwise show login button -->
                    <?php if (isset($_SESSION['UserID'])) : ?>
                        <li class="nav-item"><a class="nav-link" href="Dashboard.php"><span class="fas fa-tachometer-alt"></span> Dashboard</a></li>
                        <li class="nav-item"><a class="nav-link" href="Logout.php"><span class="fas fa-sign-in-alt"></span> Log Out</a></li>
                    <?php else : ?>
                        <li class="nav-item"><a class="nav-link" href="Registration.php"><span class="fas fa-user-plus"></span> Register</a></li>
                        <li class="nav-item"><a class="nav-link" href="Login.php"><span class="fas fa-sign-in-alt"></span> Log In</a></li>
                    <?php endif; ?>
                </ul>
            </div>
        </nav>
    </header>

    <div class="container">
        <h1>Dashboard</h1> <br />
        <h6>
            <center>Hi <?php echo $_SESSION['first_name']; ?>&#x21; Your current overall GPA is: <?php echo $gpa; ?> </center>
        </h6>
    </div> <!-- container -->


    <div class="container-fluid">
        <div class="row no-gutter popup-gallery">
            <div class="col-lg-4 col-sm-6">
                <a href="AddCourse.php" class="portfolio-box">
                    <img src="img/p1.png" class="img-responsive">
                    <div class="portfolio-box-caption">
                        <div class="portfolio-box-caption-content">
                            <div class="project-name">
                                <h3>Add courses to Plan Of Study</h3>
                            </div>
                        </div>
                    </div>
                </a>
            </div>
            <div class="col-lg-4 col-sm-6">
                <a href="ShowPOS.php" class="portfolio-box">
                    <img src="img/p3.png" class="img-responsive">
                    <div class="portfolio-box-caption">
                        <div class="portfolio-box-caption-content">
                            <div class="project-name">
                                <h3>Check Your Plan Of Study</h3>
                            </div>
                        </div>
                    </div>
                </a>
            </div>
            <div class="col-lg-4 col-sm-6">
                <a href="ReportGrade.php" class="portfolio-box">
                    <img src="img/p2.png" class="img-responsive">
                    <div class="portfolio-box-caption">
                        <div class="portfolio-box-caption-content">
                            <div class="project-name">
                                <h3>Report your grade</h3>
                            </div>
                        </div>
                    </div>
                </a>
            </div>
        </div>
    </div>
</body>

</html>