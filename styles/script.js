$(document).ready(function() {

    var instructors;

    // Horizontal Tabs of admin page
    //var tabs = $("#tabs").tabs();
    // Vertical Tabs of admin page
    $("#tabs").tabs().addClass("ui-tabs-vertical ui-helper-clearfix");
    $("#tabs li").removeClass("ui-corner-top").addClass("ui-corner-left");

    // Assign jQuery ui button style to all buttons
    $("input[type='submit']").each(function() {
        $(this).button();
    });
    $("input[type='button']").each(function() {
        $(this).button();
    });
    $('input').addClass("ui-corner-all");
    $('select').addClass("ui-corner-all");

    // Date selection in section of evaluations
    $("#datepicker").datepicker({
        dateFormat: "dd-mm-yy",
        showButtonPanel: true
    });
    $("#instructor_name").combobox();
    $("#course_name").combobox();
    $("#track_name").combobox();
    $("#intake_no").combobox();

    $("#hidinstructor_name").on("change", function() {
        $("#trackinstid").val($("#hidinstructor_name").val());
        $("#trackinst").val($("#hidinstructor_name option:selected").html());

    });

    course_name();
    instructor_name();
    track_name();


    getTracks();
    getCourses();
    getStudents();

    getStudentsTransferTrack();

    $("#students_track").on("change", getStudents);
    // To display the student username
    $("#students_student").on("change", getUsername);

    //////////////////////////////////////////////////////////////
    $("#intake_main").on("change", getTracks);
    $("#track_main").on("change", getCourses);
    $("#course_main").on("change", getInstructors);
    $("#instructor_main").on("change", getInstructorScope);
///////////////////////////////////////////////////////////////////////////////////
////////////////////////////// Students page /////////////////////////////////////
    $("#students_transfer_track").on("change", function() {
        $("#track_new").html("");
        $("#students_transfer_student").html("");

        getStudentsTransferTrack();
    })
});
// to get the username of the selected student in the students page
function getUsername()
{
    $.ajax({
        url: "username.php",
        type: "POST",
        data: {
            student_id: $("#students_student").val()
        },
        success: function(resp) {
            $("#username").val(resp);

        }
    });
}
// to get all tracks except selected track in transfer student part
function getNewTracks()
{
    $.ajax({
        url: "newtracks.php",
        type: "POST",
        data: {
            old_track_id: $("#students_transfer_track").val()
        },
        success: function(resp) {
            var tracks = JSON.parse(resp);
            $("#track_new").html("");
            $.each(tracks, function(key, value) {
                var t = $("<option value='" + value[0] + "' >" + value[1] + "</option>");
                $("#track_new").append(t);
            })
        }
    });
}

////////////////////////////////////////////////////////////////////////////////////////////
//////////////////////////////// Functions Declaration /////////////////////////////////////
////////////////////////////////////////////////////////////////////////////////////////////


////////////////////////////////  Main page script functions  //////////////////////////////
function getTracks() {
    $("#track_main").html("");
    $("#course_main").html("");
    $("#instructor_main").html("");
    $("#due_date_main").val("");
    $("#scope").val("");


    // function to get the tracks in adminpage
    $("#course_main").html("");
    $.ajax({
        url: "tracks_main.php",
        type: "POST",
        data: {
            intake_id: $("#intake_main").val()
        },
        success: function(resp) {
            var tracks = JSON.parse(resp);
            $("#track_main").html("");
            $.each(tracks, function(key, value) {
                var t = $("<option value='" + value[0] + "' >" + value[1] + "</option>");
                $("#track_main").append(t);
            })
            getCourses();
        }
    });
}

// function to get the courses in adminpage    
function getCourses() {
    $("#course_main").html("");
    $("#instructor_main").html("");
    $("#scope").val("");
    $("#due_date_main").val("");

    $.ajax({
        url: "courses_main.php",
        type: "POST",
        data: {
            intake_id: $("#intake_main").val(),
            track_id: $("#track_main").val()
        },
        success: function(resp) {
            var tracks = JSON.parse(resp);
            $("#course_main").html("");
            $.each(tracks, function(key, value) {
                var t = $("<option value='" + value[0] + "' >" + value[1] + "</option>");
                $("#course_main").append(t);
            })
            getInstructors();
        }
    });
}

// function to get the courses in adminpage
function getInstructors() {
    $("#instructor_main").html("");
    $("#scope").val("");
    $("#due_date_main").val("");
    $.ajax({
        url: "instructors_main.php",
        type: "POST",
        data: {
            intake_id: $("#intake_main").val(),
            track_id: $("#track_main").val(),
            course_id: $("#course_main").val()
        },
        success: function(resp) {
            instructors = JSON.parse(resp);
            $("#instructor_main").html("");
            $.each(instructors, function(key, value) {
                var t = $("<option value='" + value[0] + "' >" + value[1] + "</option>");
                $("#instructor_main").append(t);
            })
            getInstructorScope();
            getDueDate();
        }
    });
}
function getInstructorScope()
{
    $("#scope").val("");
    $("#due_date_main").val("");
    instId = $("#instructor_main").val();

    for (var i = 0; i < instructors.length; i++)
    {
        if (instructors[i][0] == instId)
        {
            $("#scope").val(instructors[i][2]);
        }
    }
}

function getDueDate()
{
    $("#due_date_main").val("");
    $.ajax({
        url: "duedate.php",
        type: "POST",
        data: {
            intake_id: $("#intake_main").val(),
            track_id: $("#track_main").val(),
            course_id: $("#course_main").val(),
        },
        success: function(resp) {
            $("#due_date_main").val(resp);
        }
    });
}


//////////////////////////////////////////////////////////////////////////////////////////////////////
////////////////////  Instructor page AJAX function//////////////////////////////////////////////
function instructor_name()
{
    $.ajax({
        url: "instructor.php",
        type: "POST",
        data: {
            operation: 'find_instructor',
            inst_id: $("#instructor_name1").attr("name")
        },
        success: function(resp) {
            $("#instructor_title").val(resp);
        }
    });
}
////////////////////  Course page AJAX function//////////////////////////////////////////////
function course_name()
{
    $.ajax({
        url: "course.php",
        type: "POST",
        data: {
            operation: 'find_course',
            course_id: $("#course_name1").attr("name")
        },
        success: function(resp) {
            $("#course_code").val(resp);
        }
    });
}
////////////////////  Track page AJAX function//////////////////////////////////////////////
function track_name()
{
    $.ajax({
        url: "track.php",
        type: "POST",
        data: {
            operation: 'find_course',
            track_id: $("#track_name1").attr("name")
        },
        success: function(resp) {
            $("#inst").html(resp);
        }
    });
}
/////////////////////////////////////////////////////////////////////////////////////////

function getStudents()
{
    $("#students_student").val("");
    $("#username").val("");
    $.ajax({
        url: "students.php",
        type: "POST",
        data: {
            operation: 'find_students',
            track_id: $("#students_track").val()
        },
        success: function(resp) {
            $("#students_student").html(resp);
            getUsername();
        }
    });

}
function getStudentsTransferTrack()
{
    $.ajax({
        url: "students.php",
        type: "POST",
        data: {
            operation: 'find_students',
            track_id: $("#students_transfer_track").val()
        },
        success: function(resp) {
            $("#students_transfer_student").html(resp);
            if ($("#students_transfer_student option").length)
            {
                getNewTracks();
            }


        }
    });

}
function intake_no()
{

}

////////////////////////////////////////////////////////////////////////////////
//////////////  Script for Edit dialog in admin main page /////////////////////
$(function() {

    var eval_id;
    $("#edit_date").datepicker({
        dateFormat: "dd-mm-yy",
        showButtonPanel: true
    });

    var form = $("#dialog-form").dialog({
        autoOpen: false,
        height: 600,
        width: 500,
        modal: true,
        buttons: {
            "Save": function() {
                $.ajax({
                    url: "edit_evaluation.php",
                    type: "POST",
                    data: {
                        eval_id: eval_id,
                        scope: $("#scope").val(),
                        new_intake: $("#edit_intake").val(),
                        new_track: $("#edit_track").val(),
                        new_course: $("#edit_course").val(),
                        new_instructor: $("#edit_instructor").val(),
                        new_date: $("#edit_date").val(),
                        new_scope: $("#edit_scope").val()
                    },
                    success: function(resp) {
                        $("#edit_eval_message").html(resp);
                        $("#edit_eval_message").dialog({
                            buttons: [
                                {
                                    text: "Ok",
                                    click: function() {
                                        $(this).dialog("close");
                                    }
                                }
                            ]
                        });
                        form.dialog("close");
                    }
                });
            },
            Cancel: function() {
                form.dialog("close");
            }
        },
        close: function() {
            form.dialog("close");
        }
    });

    $("#edit_button_main")
            .button()
            .click(function() {
        $.ajax({
            url: "evaluation_id.php",
            type: "POST",
            data: {
                intake_id: $("#intake_main").val(),
                track_id: $("#track_main").val(),
                course_id: $("#course_main").val()
            },
            success: function(resp) {
                eval_id = resp;
                form.dialog("open");
            }
        });


    });
});

// ----------------------------- Delete Intake Dialog ------------------------------------------------
$(document).ready(function() {
    var deleteTracks = 0;
    var deleteStudents = 0;

    $('#delete').click(function() {
        var answer = $("#dialog").dialog({buttons: [
                {
                    text: "Ok",
                    click: function() {
                        deleteIntake();
                        $(this).dialog("close");
                    }
                },
                {
                    text: "Cancel",
                    click: function() {
                        $(this).dialog("close");

                    }
                }
            ]});
    });
    $("#checkbox1").on("change", function() {
        deleteTracks = 1;
    });
    $("#checkbox2").on("change", function() {
        deleteStudents = 1;
    });
    function deleteIntake()
    {

        $.ajax({
            url: "delete_intake.php",
            type: "POST",
            data: {
                intake_id: $("#intake_no").val(),
                deleteTracks: deleteTracks,
                deleteStudents: deleteStudents
            },
            success: function(resp) {
                $("#delete_message").html(resp);
                $("#delete_message").dialog({
                    modal: true,
                    buttons: {
                        Ok: function() {
                            $(this).dialog("close");
                        }
                    },
                    show: {
                        effect: "blind",
                        duration: 1000
                    },
                    hide: {
                        effect: "explode",
                        duration: 1000
                    }

                });

            }
        });
    }
    $("#year").datepicker({
        changeYear: true,
        changeMonth: false,
        dateFormat: 'yy',
        showButtonPanel: true
    });
});

function addEval()
{
    $.ajax({
        url: "add_evaluation.php",
        type: "POST",
        data: {
            track_id: $("#track_id_6").val(),
            course_id: $("#course_id_6").val(),
            instructor_lec_id: $("#instructor_lec_id_6").val(),
            date: $("#datepicker").val(),
            instructor_lab_id: $("#instructor_lab_id_6").val(),
        },
        success: function(resp) {
            $("#add_eval_message").html(resp);
            $("#add_eval_message").dialog({
                modal: true,
                buttons: {
                    Ok: function() {
                        $(this).dialog("close");
                    }
                },
                show: {
                    effect: "blind",
                    duration: 1000
                },
                hide: {
                    effect: "explode",
                    duration: 1000
                }
            });
            getTracks();
        }
    });
}

