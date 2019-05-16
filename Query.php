<?php
require_once('DBConfig.php');
?>
<tr id='<?php echo "row" . $_POST['rowNum']; ?>'>
    <td>
        <select class="form-control" name="courseSubjects[]" id='<?php echo "courseSubjects" . $_POST['rowNum']; ?>' onchange="PopulateCourseNum('<?php echo "courseSubjects" . $_POST['rowNum']; ?>','<?php echo "#courseTitle" . $_POST['rowNum']; ?>','<?php echo "#courseNum" . $_POST['rowNum']; ?>')">
            <option selected disabled>Select Course Code</option>
            <?php  //POS course selection functionality

            $user_check_query = "SELECT DISTINCT subject FROM Courses ORDER BY subject;";
            $result = mysqli_query($conn, $user_check_query);
            while ($row = $result->fetch_assoc()) {
                $subject = $row['subject'];
                echo "<option value='$subject'>$subject</option>";
            }
            ?>
        </select>
    </td>
    <td>
        <select class="form-control" name="courseNum[]" id='<?php echo "courseNum" . $_POST['rowNum']; ?>' onchange="PopulateCourseName('<?php echo "courseSubjects" . $_POST['rowNum']; ?>','<?php echo "courseNum" . $_POST['rowNum']; ?>','<?php echo "#courseTitle" . $_POST['rowNum']; ?>')">
            <option selected disabled>----------------</option>
        </select>
    </td>
    <td>
        <select class="form-control" name="courseTitle[]" id='<?php echo "courseTitle" . $_POST['rowNum']; ?>'>
            <option selected disabled>----------------</option>
        </select>
    </td>
    <td><button class="btn btn-block btn-light btn_remove" type="button" id="<?php echo $_POST['rowNum']; ?>">Remove Course</button></td>
</tr>