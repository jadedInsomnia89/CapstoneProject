/*global $*/
$(document).ready(function() {
  var i = 1;
  $('#add').click(function() {
    i++;
    $('#dynamic_field').append('<tr id="row' + i + '"> <td><input type="text" name="title[]" placeholder="Course Title" class="form-control name_list" required /></td> <td ALIGN="center"> <select class="form-control name_list" name="credit[]" required> <option value="" disabled selected>Select your Credits</option> <option value="4">4</option> <option value="3">3</option> <option value="2">2</option> <option value="1">1</option> <option value="0">0</option> </select> </td> <td ALIGN="center"> <select class="form-control name_list" name="grade[]" required> <option value="" disabled selected>Select your Grade</option> <option value="4">A</option> <option value="3">B</option> <option value="2">C</option> <option value="1">D</option> <option value="0">F</option> </select> </td> <td><button type="button" name="remove" id="' + i + '" class="btn btn-danger btn_remove">X</button></td></tr>');
  });

  $(document).on('click', '.btn_remove', function() {
    var button_id = $(this).attr("id");
    $('#row' + button_id + '').remove();
  });
  
  /*
  $('#submit').click(function() {
    $.ajax({
      url: "GPACalculator.php",
      method: "POST",
      data: $('#add_course').serialize(),
      success: function(data) {
        // alert(data);
        // $('#add_course')[0].reset();
      }
    });
  });
  */
});