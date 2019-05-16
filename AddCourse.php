<?php
session_start();
require_once('DBConfig.php');
$_SESSION['UserID'];
$_SESSION['message'] = '';

// Set session variable selectTerm if unset
if (!isset($_SESSION['termSelect'])) {
    $_SESSION['termSelect'] = "1,2,3";
    $termSelect = $_SESSION['termSelect'];
}

// Save the selected term from termSelect form to variable - will be used to query DB futher down page
if (isset($_POST['termSubmit'])) {
    $termSelect = $conn->real_escape_string($_POST['termSelect']);
}

if (isset($_POST['courseSubjects'])) {
  $courseSubjects = $_POST['courseSubjects'];
}
if (isset($_POST['courseNum'])) {
  $courseNum = $_POST['courseNum'];
}

if (isset($_POST['year'])) {
  $year = $_POST['year'];
}

if (isset($_POST['term'])) {
  $term = $_POST['term'];
}

// Adding Courses to database
if (isset($_POST['submit_courses'])) {

  // Checking courses row by row
  for ($i = 0; $i < count($courseSubjects); $i++) {

    // First, check if the student has enrolled this course before
    $check_courseID_query = "SELECT `ID` FROM `Courses` WHERE subject = '$courseSubjects[$i]' AND course_number = '$courseNum[$i]'";
    $result = mysqli_query($conn, $check_courseID_query);
    $courseID = mysqli_fetch_assoc($result);
    $check_enroll_query = "SELECT * FROM `Enroll` WHERE student_ID = '{$_SESSION['UserID']}' AND course_ID = '{$courseID['ID']}'";
    $result = mysqli_query($conn, $check_enroll_query);
    $enroll = mysqli_fetch_assoc($result);
    // If so, 
    if ($enroll['course_ID'] !== NULL) {
      // Display error message
      $_SESSION['message'] = "<b> You already enrolled in " . $courseSubjects[$i] . " " . $courseNum[$i] .  ".</b> So we won't add this course to your Plan Of Study.";
    } else { // If they don't enrolled this course before,
      // Finally, check if the course has prerequisite
      $check_prerequisite_query = "SELECT `prerequisite` FROM `Prerequisite` WHERE course_ID = '{$courseID['ID']}';";
      $prereqResult = mysqli_query($conn, $check_prerequisite_query);
      // If so,
      if ($prereqResult !== NULL) {
        $filled_prerequisite = true;
        // Check to see if the student meets the course prerequisite
        while ($row = $prereqResult->fetch_assoc()) {
          $test = $row['prerequisite'];
          $check_prerequisite_query = "SELECT `course_ID` FROM `Enroll` WHERE course_ID = $test AND student_ID = '{$_SESSION['UserID']}';";
          $result = mysqli_query($conn, $check_prerequisite_query);
          $prereq = mysqli_fetch_assoc($result);
          
          //check to see if student has prerequisite met
          if(!$prereq){
              $_SESSION['message'] = "<br><b> You don't meet the prerequisite of " . $courseSubjects[$i] . " " . $courseNum[$i] .  ".</b> So we won't add this course to your Plan Of Study.";
              $filled_prerequisite = false;
          }
        }
          
        if ($filled_prerequisite === true) {
          $insert_query = "INSERT INTO Enroll(student_ID,course_ID,year,term) VALUES('{$_SESSION['UserID']}','{$courseID['ID']}','$year','$term')";
          mysqli_query($conn, $insert_query);
        }
          
      } else { // If the course doesn't has prerequisite
        // Insert to database directly
        $insert_query = "INSERT INTO Enroll(student_ID,course_ID,year,term) VALUES('{$_SESSION['UserID']}','{$courseID['ID']}','$year','$term')";
        mysqli_query($conn, $insert_query);
      }
    }
  }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Add Courses</title>
    <!-- Bootstrap and Jquery CDN -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" async></script>
    <!-- Font Awesome Icons (used in navbar)-->
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.8.1/css/all.css" integrity="sha384-50oBUHEmvpQ+1lW4y57PTFmhCaXp0ML5d60M1M7uH2+nqUivzIebhndOJK28anvf" crossorigin="anonymous">
    <!-- Custom Stylesheet -->
    <link rel="stylesheet" type="text/css" href="css/Style.css">
    <link rel="stylesheet" type="text/css" href="css/Dashboard.css">
    <!-- Custom JS -->
    <script src="js/PopulateCourses.js"></script>
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
      <div class="col-md-12 text-center">
        <h2>Add Courses</h2>
        <br />
        
        <form action="AddCourse.php" method="post" id="POS_AddCourse">
          <table class="table">
            <tr>
              <td ALIGN="center">
                <select class="form-control name_list" name="year" required>
                  <option value="" disabled selected>Select Year</option>
                  <option value="2018">2018</option>
                  <option value="2019">2019</option>
                  <option value="2020">2020</option>
                  <option value="2021">2021</option>
                </select>
              </td>
              <td ALIGN="center">
                <select class="form-control name_list" name="term" required>
                  <option value="" disabled selected>Select Term</option>
                  <option value="1">Spring</option>
                  <option value="2">Summer</option>
                  <option value="3">Fall</option>
                </select>
              </td>
            </tr>
          </table>
          <br />
        
          <div class="table-responsive">
            <table class="table" id="POS_Table">
              <tr id="row0">
                <td>
                  <select class="form-control" name="courseSubjects[]" id='courseSubjects0' onchange="PopulateCourseNum('courseSubjects0','#courseTitle0','#courseNum0')">
                    <option selected disabled>Select Course Code</option>
                    <?php  //POS course selection functionality

                    $user_check_query = "SELECT DISTINCT subject FROM Courses ORDER BY subject;";
                    $result = mysqli_query($conn, $user_check_query);
                    while ($row = $result->fetch_assoc()) {
                      $subject = $row['subject'];
                      echo "<option id='$subject' value='$subject'>$subject</option>";
                    }
                    ?>
                  </select>
                </td>
                <td>
                  <select class="form-control" name="courseNum[]" id="courseNum0" onchange="PopulateCourseName('courseSubjects0','courseNum0','#courseTitle0')">
                    <option selected disabled>----------------</option>
                  </select>
                </td>
                <td>
                  <select class="form-control" name="courseTitle[]" id="courseTitle0">
                    <option selected disabled>----------------</option>
                  </select>
                </td>
                <td><button class="btn btn-block btn-success" type="button" id="addCourse">Add Course</button></td>
              </tr>
            </table>
            <br />
          </div> <!-- table-responsive -->
          
          <div class="row">
            <div class="col-md-4 offset-md-4">
              <button type="submit" name="submit_courses" class="btn btn-success btn-block" />Submit</button>
            </div>
          </div>
        </form>
        <?= $_SESSION['message'] ?>
      </div> <!-- bootstrap grid container -->
    </div> <!-- container -->
    
    <br/>
        <div class="container">
        <h2>Available Courses</h2>

        <!-- Dropdown menu to select which term to view available courses in -->
        <form class="form" action="AddCourse.php" method="post" id="term">
            <label for="termSelect" class="sr-only">Select Term to View Available Courses</label>
            <select class="form-control" name="termSelect" id="termSelect">
                <option value="" selected disabled>Select Term to View Available Courses</option>
                <option value="1,2,3">All</option>
                <option value="1">Spring</option>
                <option value="2">Summer</option>
                <option value="3">Fall</option>
            </select>

            <button class="btn btn-success btn-block" type="submit" name="termSubmit" id="termSubmit">Submit</button>
        </form>

        <!-- Available Courses Table Header -->
        <table class="table table-striped">
            <div class="table responsive">
                <thead>
                    <tr>
                        <th>Subject</th>
                        <th>Course number</th>
                        <th>Title</th>
                        <th>Credit hours</th>
                    </tr>
                </thead>
                <tbody>
                    <?php  // Code that populates the table
                    // Search Available Courses - if checks to see if All is selected
                    if ($termSelect == "1,2,3") {

                        // Shows all courses
                        $user_check_query = "SELECT * FROM Courses WHERE FIND_IN_SET('1', terms_offered) OR FIND_IN_SET('2', terms_offered) OR FIND_IN_SET('3', terms_offered);";
                        $result = mysqli_query($conn, $user_check_query);
                    } else {
                        // Shows the available courses for the selected term
                        $user_check_query = "SELECT * FROM Courses WHERE FIND_IN_SET('$termSelect', terms_offered);";
                        $result = mysqli_query($conn, $user_check_query);
                    }

                    // Displays the table with the course availability data
                    if ($result->num_rows > 0) {
                        // output data of each row
                        while ($row = $result->fetch_assoc()) {
                            echo '<tr>
                        <td scope="row">' . $row["subject"] . '</td>
                        <td>' . $row["course_number"] . '</td>
                        <td> ' . $row["title"] . '</td>
                        <td> ' . $row["credit_hours"] . '</td>
                      </tr>';
                        }
                    } else {
                        echo "0 results";
                    }
                    ?>
                </tbody>
            </div>  <!--table-resonsive -->
        </table>
    </div>  <!-- container -->
</body>

</html>