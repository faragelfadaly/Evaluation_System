<?php

include 'config.php';
$link= connectToDB();

if(!$link)
{
    die("Fail to edit this evaluation, Try again later". mysqli_connect_error());        
}

$eval_id = $_POST['eval_id'];
$scope=$_POST['scope'];
$new_intake = $_POST['new_intake'];
$new_track = $_POST['new_track'];
$new_course=$_POST['new_course'];
$new_instructor=$_POST['new_instructor'];
$new_date=$_POST['new_date'];
$new_scope=$_POST['new_scope'];

$query=  mysqli_query($link,"
    UPDATE evaluation 
    set intake_id='$new_intake',
    track_id='$new_track',    
    course_id='$new_course',
    due_date='$new_date'
    WHERE id='$eval_id';        
        ");

$query=  mysqli_query($link,"
    UPDATE eval_inst_evtable 
    set inst_id='$new_instructor'
    WHERE eval_id='$eval_id' and scope='$scope';        
        ");


if($query)
{
    echo "Evaluation edited successfuly";
}
 else {
        die("Fail to edit this evaluation, Try again later".  mysqli_error($link));        
}

?>
    