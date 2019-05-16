<?php
session_start();
require_once('DBConfig.php');
$_SESSION['message'] = "";

//get the current month and year
date_default_timezone_set('America/Chicago');
$month = date("n");
$year = date("Y");

//set the proper term depending on which month it is
if($month >=1 && $month <6){
  $term = 1;
}else if($month >=6 && $month <8){
  $term = 2;
}else{
  $term = 3;
}

//query DB for all courses enrolled in prior to the current Term and Year - results will be displayed in table below
$userID = (int)$_SESSION['UserID'];
$gradeQuery = "SELECT C.title, C.ID FROM Enroll E, Courses C WHERE (year < $year or (year = '$year' and term <= '$term')) and E.course_ID = C.ID and E.student_ID = '$userID' ;";
$gradeResult = mysqli_query($conn, $gradeQuery);

//collect form data and save to the DB
if (isset($_POST['gradeReportSubmit'])) {
  $letterGrades = $_POST['letterGrades'];
  $i = 0;
  while ($row = $gradeResult->fetch_assoc()) {
    $ID = $row['ID'];
    $letter = $letterGrades[$i];
    $updateGradesQuery = "UPDATE Enroll SET grade = '$letter' WHERE student_ID = '{$_SESSION['UserID']}' AND course_ID = '$ID';";
    mysqli_query($conn, $updateGradesQuery);
    $i++;
    $_SESSION['message'] = "<br/>Success!  Grades were saved." . '<br/><br/><div class="row">
            <div class="col-md-4 offset-md-4">
              <a href="Dashboard.php"/>Back to Dashboard</a>
            </div>
          </div>';
  }
}
?>

<!DOCTYPE html>
<html lang="en">

  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Report Grade</title>
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
      <div class="col-md-12 text-center">
        <h1>Report Your Grade<br></h1>
        
        <form action="ReportGrade.php" method="post" id="POS_ReportGrade">
          <div class="table-responsive">
            <table class="table" id="ReportGradeTable">
              <?php
              $_SESSION['k'] = 0;
              while ($row = $gradeResult->fetch_assoc()) {
                $title = $row['title'];
              ?>
              <tr id="row0">
                <td class="gradeReportLabel">
                  <label for="letterGrade" id='<?php echo "grade" . $_SESSION['k']; ?>'><?php echo $title; ?></label>
                </td>
                <td>
                  <select class="form-control" name="letterGrades[]" id='<?php echo "grade" . $_SESSION['k']; ?>' required>
                    <option value="" disabled selected>Select your Grade</option>
                    <option value="4">A</option>
                    <option value="3">B</option>
                    <option value="2">C</option>
                    <option value="1">D</option>
                    <option value="0">F</option>
                  </select>
                </td>
              </tr>
              <?php
              $_SESSION['k']++;
              } 
              ?>
            </table>
          </div> <!-- table-responsive -->
          
          <div class="row">
            <div class="col-md-4 offset-md-4">
              <button type="submit" name="gradeReportSubmit" class="btn btn-success btn-block" />Submit</button>
            </div>
          </div>
        </form>
        <?= $_SESSION['message'] ?>
      </div> <!-- bootstrap grid container -->
    </div> <!--container -->
  </body>
</html>