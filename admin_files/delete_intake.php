<?php

include '../config.php';
$intake_id = $_POST['intake_id'];
$deleteTracks = $_POST['deleteTracks'];
$deleteStudents = $_POST['deleteStudents'];

$link = connectToDB();

if (!$link) {
    die("Error while connecting to Database" . mysqli_error($link));
}

$query = mysqli_query($link, "update intake set isdeleted='1' where id='$intake_id';");


if ($query) {
    echo "Intake deleted successfully ";    
} else {
    echo "System Fails to delete intake ";
}

?>
