<?php

include './config.php';
$link = connectToDB();

if (!$link) {
    die("Connection to Database Error,<i style='color:red'><b>Try again later<b></i>");
}


    $intake_id = $_POST['intake_id'];
    $track_id = $_POST['track_id'];
    $course_id = $_POST['course_id'];    
    
    $inst_eval_query = mysqli_query($link, "select due_date from evaluation where intake_id='$intake_id' and track_id='$track_id' and course_id='$course_id' ");
    if ($row = mysqli_fetch_assoc($inst_eval_query)) {
        echo "{$row['due_date']}";
    }    
?>
