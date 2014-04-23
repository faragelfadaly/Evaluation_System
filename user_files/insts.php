<?php
session_start();
$student_id = $_SESSION['userid'];  // student id get from session       

include('../config.php');

$link = connectToDB();

// ajax response that send instructors of selected course in user-home page
if ($_POST['operation'] == 'find_insts') {
    $c_id = $_POST['course_id'];
    $ins_type=$_POST['ins_type'];
   
    if (!$result = mysqli_query($link, "SELECT instructor.name as iname, instructor.id as inst_id
                FROM instructor,evaluation
                where instructor.id=evaluation.inst_id and evaluation.course_id='$c_id' and
                    evaluation.scope='$ins_type' and 
                        evaluation.track_id =(select student.track_id from student where student.id='$student_id');")) {

        die("invalid");
    } else {
        while ($row = mysqli_fetch_assoc($result)) {

            echo "<option value='{$row['inst_id']}'>{$row['iname']}</option>";
            // echo "<option>'$ins_type'</option>";
        }
    }
}
//****************************
// ajax response that send due date of selected course in user-home page
else if ($_POST['operation'] == 'find_duedate') {
    $course_id = $_POST['course_id'];
    $instructor_id = $_POST['inst_id'];

    if (!$result = mysqli_query($link, "SELECT due_date
                                                FROM evaluation
                                                WHERE evaluation.course_id = '$course_id'
                                                AND evaluation.inst_id = '$instructor_id'
                                                AND evaluation.track_id = (
                                                SELECT student.track_id
                                                FROM student
                                                WHERE student.id = '$student_id' )
                                        ")) {

        die("invalid");
    } else {
        $row = mysqli_fetch_assoc($result);
        echo "{$row['due_date']}";
    }
}

// redirect to instructor_eval page if Instructor Evaluation submit button clicked in user-home page        
else if (isset($_POST['instructor'])) {
    header("Location: instructor_eval.php?course_id={$_POST['course_id']}&instructor_id={$_POST['instructor_id']}");
}
// redirect to course_eval page if Course Evaluation submit button clicked in user-home page    
else if (isset($_POST['course'])) {
    header("Location: course_eval.php?course_id={$_POST['course_id']}");
}
?>
