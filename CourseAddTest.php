<?php
require_once('DBConfig.php'); 
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
    <div class="container">
      <form action="Dashboard.php" method="post" id="POS_AddCourse">
        <div class="table-responsive">
          <table class="dynamicTable" id="POS_Table">
            <tr id="row0">
              <td>
                <select class="form-control" name="courseSubjects" id="courseSubjects" onchange="PopulateCourseNum()">
                  <option selected disabled>Select Course Code</option>
                  <?php  //POS course selection functionality

                  $user_check_query = "SELECT DISTINCT subject FROM Courses ORDER BY subject;";
                  $result = mysqli_query($conn, $user_check_query);
                  while($row = $result->fetch_assoc() ){
                    $subject = $row['subject'];
                    echo "<option id='$subject' value='$subject'>$subject</option>";
                  }
                  ?>
                </select>
              </td>
              <td>
                <select class="form-control" name="courseNum" id="courseNum" onchange="PopulateCourseName(this.value)">
                  <option selected disabled>----------------</option>
                </select>
              </td>
              <td>
                <select class="form-control" name="courseTitle" id="courseTitle">
                  <option selected disabled>----------------</option>
                </select>
              </td>
              <td><button class="btn btn-block btn-success" type="button" id="addCourse">Add Course</button></td>
            </tr>
          </table>
          <div class="col-md-6 text-center"> 
            <button type="submit" name="calculate" class="btn btn-info" />Submit</button>
          </div>
        </div> <!-- table-responsive -->
      </form>
    </div> <!-- container -->
    <script>
    /*global $*/
      $(document).ready(function() {
        var j = 1;
        $('#addCourse').click(function() {
          $.ajax({
            method:"POST",
            url:"Query.php",
            data: {rowNum:j},
            success:function(data) {
              if(data !="") {
                $("#POS_Table tr:last").after(data);
              }
            },
            error: function() {
              $("#errorTest").html("Error retrieving data from Query.php");
            }
          });
          
          j++;
        });

        $(document).on('click', '.btn_remove', function() {
          var button_id = $(this).attr("id");
          $('#row' + button_id + '').remove();
        });
      });
      
      function PopulateCourseNum(){
        var courseID = document.getElementById("courseSubjects");
         $.ajax({
            url:"PopulateCourses.php",
            method: "POST",
            data: {ID:courseID},
            success:function(data) {
              if(data !="") {
                $("#courseTitle").empty().append('<option selected disabled>----------------</option>');
                $("#courseNum").empty().append('<option selected disabled>Select Course Number</option>');
                $("#courseNum option:last").after(data);
              }
            },
            error: function() {
              $("#errorTest").html("Error retrieving data from PopulateCourses.php");
            }
          });
      }
      
      function PopulateCourseName(courseID){
        $.ajax({
          url:"PopulateCourseName.php",
          method: "POST",
          data: {ID:courseID},
          success:function(data) {
            if(data !="") {
              $("#courseTitle").empty().append(data);
            }
          },
          error: function() {
            $("#errorTest").html("Error retrieving data from PopulateCourseName.php");
          }
        });
      }
    </script>
  </body>
</html>