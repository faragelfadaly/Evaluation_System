<?php

$intake_id = $_POST['intake_id'];
$track_id = $_POST['track_id'];
$course_id = $_POST['course_id'];

include 'config.php';
$link= connectToDB();

$query=  mysqli_query($link,"select id from evaluation 
        where
        intake_id='$intake_id'
        and track_id='$track_id'
        and course_id='$course_id'                
        ");
if($row=  mysqli_fetch_assoc($query))
{
    echo "{$row['id']}";
}


?>
