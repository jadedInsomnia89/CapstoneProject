<?php
session_start();
$_SESSION['message'] = '';
$gpa = NULL;
$points_earned = 0;

if (isset($_POST['credit'])) {
    $credit = $_POST['credit'];
}
if (isset($_POST['grade'])) {
    $grade = $_POST['grade'];
}

// Calculate GPA
if (isset($_POST['calculate'])) {
    $credit_attempted = array_sum($credit);
    $length = count($grade);

    for ($i = 0; $i < $length; $i++) {
        $points_earned = $points_earned + ($credit[$i] * $grade[$i]);
    }

    $gpa = $points_earned / $credit_attempted;

    $_SESSION['message'] = '<div class="sidebar">
                                <div class="circle">
                                    <div class="circle-text">
                                        <h2>Your GPA is:   ' . round($gpa, 2) . '</h2>
                                     </div>
                                </div>
                            </div>';
}
?>

<!DOCTYPE html>
<html lang="en">

  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>GPA Calculator</title>
    <!-- Bootstrap and Jquery CDN -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" async></script>
    <!-- Font Awesome Icons (used in navbar)-->
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.8.1/css/all.css" integrity="sha384-50oBUHEmvpQ+1lW4y57PTFmhCaXp0ML5d60M1M7uH2+nqUivzIebhndOJK28anvf" crossorigin="anonymous">
    <!-- Custom Stylesheet -->
    <link rel="stylesheet" type="text/css" href="css/Style.css">
    <link rel="stylesheet" type="text/css" href="css/GPACalculator.css">
    <script src="js/AddRemoveRows.js"></script>
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
            <?php if(isset($_SESSION['UserID'])): ?>
              <li class="nav-item"><a class="nav-link" href="Dashboard.php"><span class="fas fa-tachometer-alt"></span> Dashboard</a></li>
              <li class="nav-item"><a class="nav-link" href="Logout.php"><span class="fas fa-sign-in-alt"></span> Log Out</a></li>
            <?php else: ?>
              <li class="nav-item"><a class="nav-link" href="Registration.php"><span class="fas fa-user-plus"></span> Register</a></li>
              <li class="nav-item"><a class="nav-link" href="Login.php"><span class="fas fa-sign-in-alt"></span> Log In</a></li>
            <?php endif; ?>
          </ul>
        </div>
      </nav>
    </header>

    <div class="container">
      <h1>GPA Calculator</h1>

      <div class="col-md-12 text-center">
        <div class="form-group">
          <form name="add_course" id="add_course" method="post">
            <div class="table-responsive">
              <table class="table" id="dynamic_field">
                <tr>
                  <td><input type="text" name="title" placeholder="Course Title" class="form-control name_list" required /></td>
                  <td ALIGN="center">
                    <select class="form-control name_list" name="credit[]" required>
                      <option value="" disabled selected>Select your Credits</option>
                      <option value="4">4</option>
                      <option value="3">3</option>
                      <option value="2">2</option>
                      <option value="1">1</option>
                      <option value="0">0</option>
                    </select>
                  </td>
                  <td ALIGN="center">
                    <select class="form-control name_list" name="grade[]" required>
                      <option value="" disabled selected>Select your Grade</option>
                      <option value="4">A</option>
                      <option value="3">B</option>
                      <option value="2">C</option>
                      <option value="1">D</option>
                      <option value="0">F</option>
                    </select>
                  </td>
                  <td><button type="button" name="add" id="add" class="btn btn-success">Add another class</button></td>
                </tr>
              </table>
              <button type="submit" name="calculate" class="btn btn-info" />Submit</button>
            </div>
          </form>
        </div>
        <?= $_SESSION['message'] ?>
      </div>
    </div>
  </body>

</html>