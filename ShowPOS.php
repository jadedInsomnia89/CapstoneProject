<?php
session_start();
require_once('DBConfig.php');
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Plan Of Study</title>
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
        <h1>Your Plan Of Study</h1>
    </div>


    <?php
    $user_check_query = "SELECT * FROM Enroll WHERE student_ID = '{$_SESSION['UserID']}' AND year = '2018' AND term = '1';";
    $result = mysqli_query($conn, $user_check_query);

    // Displays the table with the course availability data
    if ($result->num_rows > 0) {
        echo '    <h3>2018 Spring</h3>
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
                    <tbody>';
        // output data of each row
        while ($course = $result->fetch_assoc()) {
            $course_check_query = "SELECT * FROM Courses WHERE ID = '{$course['course_ID']}';";
            $course_result = mysqli_query($conn, $course_check_query);
            while ($row = $course_result->fetch_assoc()) {
                echo '<tr>
                              <td scope="row">' . $row["subject"] . '</td>
                              <td>' . $row["course_number"] . '</td>
                              <td> ' . $row["title"] . '</td>
                              <td> ' . $row["credit_hours"] . '</td>
                              </tr>';
            }
        }
        echo'       </tbody>
                </div>
            </table>
        <br /><br />';
    }
    ?>



    <?php
    $user_check_query = "SELECT * FROM Enroll WHERE student_ID = '{$_SESSION['UserID']}' AND year = '2018' AND term = '2';";
    $result = mysqli_query($conn, $user_check_query);

    // Displays the table with the course availability data
    if ($result->num_rows > 0) {
        echo '    <h3>2018 Summer</h3>
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
                            <tbody>';
        // output data of each row
        while ($course = $result->fetch_assoc()) {
            $course_check_query = "SELECT * FROM Courses WHERE ID = '{$course['course_ID']}';";
            $course_result = mysqli_query($conn, $course_check_query);
            while ($row = $course_result->fetch_assoc()) {
                echo '<tr>
                              <td scope="row">' . $row["subject"] . '</td>
                              <td>' . $row["course_number"] . '</td>
                              <td> ' . $row["title"] . '</td>
                              <td> ' . $row["credit_hours"] . '</td>
                              </tr>';
            }
        }
    echo'       </tbody>
                </div>
            </table>
        <br /><br />';
    }
    ?>


    <?php
    $user_check_query = "SELECT * FROM Enroll WHERE student_ID = '{$_SESSION['UserID']}' AND year = '2018' AND term = '3';";
    $result = mysqli_query($conn, $user_check_query);

    // Displays the table with the course availability data
    if ($result->num_rows > 0) {
        echo '    <h3>2018 Fall</h3>
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
                            <tbody>';
        // output data of each row
        while ($course = $result->fetch_assoc()) {
            $course_check_query = "SELECT * FROM Courses WHERE ID = '{$course['course_ID']}';";
            $course_result = mysqli_query($conn, $course_check_query);
            while ($row = $course_result->fetch_assoc()) {
                echo '<tr>
                              <td scope="row">' . $row["subject"] . '</td>
                              <td>' . $row["course_number"] . '</td>
                              <td> ' . $row["title"] . '</td>
                              <td> ' . $row["credit_hours"] . '</td>
                              </tr>';
            }
        }
        echo'       </tbody>
                </div>
            </table>
        <br /><br />';
    }
    ?>


    <?php
    $user_check_query = "SELECT * FROM Enroll WHERE student_ID = '{$_SESSION['UserID']}' AND year = '2019' AND term = '1';";
    $result = mysqli_query($conn, $user_check_query);

    // Displays the table with the course availability data
    if ($result->num_rows > 0) {
        echo '    <h3>2019 Spring</h3>
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
                            <tbody>';
        // output data of each row
        while ($course = $result->fetch_assoc()) {
            $course_check_query = "SELECT * FROM Courses WHERE ID = '{$course['course_ID']}';";
            $course_result = mysqli_query($conn, $course_check_query);
            while ($row = $course_result->fetch_assoc()) {
                echo '<tr>
                              <td scope="row">' . $row["subject"] . '</td>
                              <td>' . $row["course_number"] . '</td>
                              <td> ' . $row["title"] . '</td>
                              <td> ' . $row["credit_hours"] . '</td>
                              </tr>';
            }
        }
        echo'       </tbody>
                </div>
            </table>
        <br /><br />';
    }
    ?>



    <?php
    $user_check_query = "SELECT * FROM Enroll WHERE student_ID = '{$_SESSION['UserID']}' AND year = '2019' AND term = '2';";
    $result = mysqli_query($conn, $user_check_query);

    // Displays the table with the course availability data
    if ($result->num_rows > 0) {
        echo '    <h3>2019 Summer</h3>
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
                            <tbody>';
        // output data of each row
        while ($course = $result->fetch_assoc()) {
            $course_check_query = "SELECT * FROM Courses WHERE ID = '{$course['course_ID']}';";
            $course_result = mysqli_query($conn, $course_check_query);
            while ($row = $course_result->fetch_assoc()) {
                echo '<tr>
                              <td scope="row">' . $row["subject"] . '</td>
                              <td>' . $row["course_number"] . '</td>
                              <td> ' . $row["title"] . '</td>
                              <td> ' . $row["credit_hours"] . '</td>
                              </tr>';
            }
        }
        echo'       </tbody>
                </div>
            </table>
        <br /><br />';
    }
    ?>


    <?php
    $user_check_query = "SELECT * FROM Enroll WHERE student_ID = '{$_SESSION['UserID']}' AND year = '2019' AND term = '3';";
    $result = mysqli_query($conn, $user_check_query);

    // Displays the table with the course availability data
    if ($result->num_rows > 0) {
        echo '    <h3>2019 Fall</h3>
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
                            <tbody>';
        // output data of each row
        while ($course = $result->fetch_assoc()) {
            $course_check_query = "SELECT * FROM Courses WHERE ID = '{$course['course_ID']}';";
            $course_result = mysqli_query($conn, $course_check_query);
            while ($row = $course_result->fetch_assoc()) {
                echo '<tr>
                              <td scope="row">' . $row["subject"] . '</td>
                              <td>' . $row["course_number"] . '</td>
                              <td> ' . $row["title"] . '</td>
                              <td> ' . $row["credit_hours"] . '</td>
                              </tr>';
            }
        }
        echo'       </tbody>
                </div>
            </table>
        <br /><br />';
    }
    ?>



    <?php
    $user_check_query = "SELECT * FROM Enroll WHERE student_ID = '{$_SESSION['UserID']}' AND year = '2020' AND term = '1';";
    $result = mysqli_query($conn, $user_check_query);

    // Displays the table with the course availability data
    if ($result->num_rows > 0) {
        echo '    <h3>2020 Spring</h3>
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
                            <tbody>';
        // output data of each row
        while ($course = $result->fetch_assoc()) {
            $course_check_query = "SELECT * FROM Courses WHERE ID = '{$course['course_ID']}';";
            $course_result = mysqli_query($conn, $course_check_query);
            while ($row = $course_result->fetch_assoc()) {
                echo '<tr>
                              <td scope="row">' . $row["subject"] . '</td>
                              <td>' . $row["course_number"] . '</td>
                              <td> ' . $row["title"] . '</td>
                              <td> ' . $row["credit_hours"] . '</td>
                              </tr>';
            }
        }
        echo'       </tbody>
                </div>
            </table>
        <br /><br />';
    }
    ?>


    <?php
    $user_check_query = "SELECT * FROM Enroll WHERE student_ID = '{$_SESSION['UserID']}' AND year = '2020' AND term = '2';";
    $result = mysqli_query($conn, $user_check_query);

    // Displays the table with the course availability data
    if ($result->num_rows > 0) {
        echo '    <h3>2020 Summer</h3>
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
                            <tbody>';
        // output data of each row
        while ($course = $result->fetch_assoc()) {
            $course_check_query = "SELECT * FROM Courses WHERE ID = '{$course['course_ID']}';";
            $course_result = mysqli_query($conn, $course_check_query);
            while ($row = $course_result->fetch_assoc()) {
                echo '<tr>
                              <td scope="row">' . $row["subject"] . '</td>
                              <td>' . $row["course_number"] . '</td>
                              <td> ' . $row["title"] . '</td>
                              <td> ' . $row["credit_hours"] . '</td>
                              </tr>';
            }
        }
        echo'       </tbody>
                </div>
            </table>
        <br /><br />';
    }
    ?>


    <?php
    $user_check_query = "SELECT * FROM Enroll WHERE student_ID = '{$_SESSION['UserID']}' AND year = '2020' AND term = '3';";
    $result = mysqli_query($conn, $user_check_query);

    // Displays the table with the course availability data
    if ($result->num_rows > 0) {
        echo '    <h3>2020 Fall</h3>
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
                            <tbody>';
        // output data of each row
        while ($course = $result->fetch_assoc()) {
            $course_check_query = "SELECT * FROM Courses WHERE ID = '{$course['course_ID']}';";
            $course_result = mysqli_query($conn, $course_check_query);
            while ($row = $course_result->fetch_assoc()) {
                echo '<tr>
                              <td scope="row">' . $row["subject"] . '</td>
                              <td>' . $row["course_number"] . '</td>
                              <td> ' . $row["title"] . '</td>
                              <td> ' . $row["credit_hours"] . '</td>
                              </tr>';
            }
        }
        echo'       </tbody>
                </div>
            </table>
        <br /><br />';
    }
    ?>


    
        <?php
    $user_check_query = "SELECT * FROM Enroll WHERE student_ID = '{$_SESSION['UserID']}' AND year = '2021' AND term = '1';";
    $result = mysqli_query($conn, $user_check_query);

    // Displays the table with the course availability data
    if ($result->num_rows > 0) {
        echo '    <h3>2021 Spring</h3>
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
                            <tbody>';
        // output data of each row
        while ($course = $result->fetch_assoc()) {
            $course_check_query = "SELECT * FROM Courses WHERE ID = '{$course['course_ID']}';";
            $course_result = mysqli_query($conn, $course_check_query);
            while ($row = $course_result->fetch_assoc()) {
                echo '<tr>
                              <td scope="row">' . $row["subject"] . '</td>
                              <td>' . $row["course_number"] . '</td>
                              <td> ' . $row["title"] . '</td>
                              <td> ' . $row["credit_hours"] . '</td>
                              </tr>';
            }
        }
        echo'       </tbody>
                </div>
            </table>
        <br /><br />';
    }
    ?>


    <?php
    $user_check_query = "SELECT * FROM Enroll WHERE student_ID = '{$_SESSION['UserID']}' AND year = '2021' AND term = '2';";
    $result = mysqli_query($conn, $user_check_query);

    // Displays the table with the course availability data
    if ($result->num_rows > 0) {
        echo '    <h3>2021 Summer</h3>
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
                            <tbody>';
        // output data of each row
        while ($course = $result->fetch_assoc()) {
            $course_check_query = "SELECT * FROM Courses WHERE ID = '{$course['course_ID']}';";
            $course_result = mysqli_query($conn, $course_check_query);
            while ($row = $course_result->fetch_assoc()) {
                echo '<tr>
                              <td scope="row">' . $row["subject"] . '</td>
                              <td>' . $row["course_number"] . '</td>
                              <td> ' . $row["title"] . '</td>
                              <td> ' . $row["credit_hours"] . '</td>
                              </tr>';
            }
        }
        echo'       </tbody>
                </div>
            </table>
        <br /><br />';
    }
    ?>


    <?php
    $user_check_query = "SELECT * FROM Enroll WHERE student_ID = '{$_SESSION['UserID']}' AND year = '2021' AND term = '3';";
    $result = mysqli_query($conn, $user_check_query);

    // Displays the table with the course availability data
    if ($result->num_rows > 0) {
        echo '    <h3>2021 Fall</h3>
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
                            <tbody>';
        // output data of each row
        while ($course = $result->fetch_assoc()) {
            $course_check_query = "SELECT * FROM Courses WHERE ID = '{$course['course_ID']}';";
            $course_result = mysqli_query($conn, $course_check_query);
            while ($row = $course_result->fetch_assoc()) {
                echo '<tr>
                              <td scope="row">' . $row["subject"] . '</td>
                              <td>' . $row["course_number"] . '</td>
                              <td> ' . $row["title"] . '</td>
                              <td> ' . $row["credit_hours"] . '</td>
                              </tr>';
            }
        }
        echo'       </tbody>
                </div>
            </table>
        <br /><br />';
    }
    ?>
</html>