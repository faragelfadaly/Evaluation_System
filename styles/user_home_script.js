$(document).ready(function() {


});
// function to get array of all courses that this student did not evaluate (course , lecture , lab)            
function getCoursesArray()
{
    var courses = array();
    $.ajax({
        url: "allCoursesArray.php",
        type: "POST",
        data: {
        },
        success: function(resp) {
            var courses = JSON.parse(resp);
        }
    });

    for (var item in courses)
    {
        $("#course_name").append("<option value='"+ item[0] +"'>"+ item[0] +"</option>");        
    }

}

function getDueDate()
{
    $.ajax({
        url: "insts.php",
        type: "POST",
        data: {
            operation: 'find_duedate',
            course_id: $("#course_name").val(),
            inst_id: $("#inst_names").val()
        },
        success: function(resp) {
            $("#duedate").val(resp);

        }
    });
}

function disableSubmit()
{

}