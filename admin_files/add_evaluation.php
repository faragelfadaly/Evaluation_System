<?php

include './config.php';
$link = connectToDB();
if (!$link) {
    die("Connection to Database Error,<i style='color:red'><b>Try again later<b></i>");
}

//$year = date("Y", time());

$track_id = $_POST['track_id'];
$course_id = $_POST['course_id'];
$instructor_lec_id = $_POST['instructor_lec_id'];
$instructor_lab_id = $_POST['instructor_lab_id'];
$due_date = $_POST['date'];

$evaluations = mysqli_query($link, "
        INSERT INTO `evaluation`(`intake_id`, `track_id`,`course_id`,`due_date`) 
        VALUES ((select id from intake where current='1'),'$track_id','$course_id','$due_date')
        ");

$eval_id = mysqli_insert_id($link);
if ($eval_id != 0) {
    $lec_eval = mysqli_query($link, "
        INSERT INTO `eval_inst_evtable`(`eval_id`, `inst_id`,`scope`) 
        VALUES ('$eval_id','$instructor_lec_id','lec');
        ");

    $lab_eval = mysqli_query($link, "
        INSERT INTO `eval_inst_evtable`(`eval_id`, `inst_id`,`scope`) 
        VALUES ('$eval_id','$instructor_lab_id','lab');
        ");
}

if ($lec_eval && $lab_eval) {    
    echo"Evaluation added successfuly";
}
?>
