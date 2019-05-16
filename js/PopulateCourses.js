/*global $*/
$(document).ready(function() {
    var j = 1;
    $('#addCourse').click(function() {
        $.ajax({
            method: "POST",
            url: "Query.php",
            data: {
                rowNum: j
            },
            success: function(data) {
                if (data != "") {
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

function PopulateCourseNum(courseSubject, courseTitle, courseNum) {
    var courseID = document.getElementById(courseSubject).value;
    $.ajax({
        url: "PopulateCourses.php",
        method: "POST",
        data: {
            ID: courseID
        },
        success: function(data) {
            if (data != "") {
                $(courseTitle).empty().append('<option selected disabled>----------------</option>');
                $(courseNum).empty().append('<option selected disabled>Select Course Number</option>');
                $(courseNum + ' option:last').after(data);
            }
        },
        error: function() {
            $("#errorTest").html("Error retrieving data from PopulateCourses.php");
        }
    });
}

function PopulateCourseName(courseSubject, courseNum, courseTitle) {
    var courseSubject = document.getElementById(courseSubject).value;
    var courseNum = document.getElementById(courseNum).value;
    $.ajax({
        url: "PopulateCourseName.php",
        method: "POST",
        data: {
            courseSubject: courseSubject,
            courseNum: courseNum
        },
        success: function(data) {
            if (data != "") {
                $(courseTitle).empty().append(data);
            }
        },
        error: function() {
            $("#errorTest").html("Error retrieving data from PopulateCourseName.php");
        }
    });
}