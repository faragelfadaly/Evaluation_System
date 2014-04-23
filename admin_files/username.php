<?php

include './config.php';

$student_id = $_POST['student_id'];

$query = executeQuery("select username from student where id='$student_id'");

if(!$query)
{
    die("Query Error");
}

if($row=  mysqli_fetch_assoc($query))
{
    echo "{$row['username']}";
}

?>
