<?php

include './config.php';

// Insert Student Data from page (students.php)
if (isset($_POST['save'])) {
    $name = $_POST['name'];
    $username = $_POST['username'];
    $track_id = $_POST['track_id'];
        
    $student_query = executeQuery("insert into student (name,username,track_id,intake_id) values ('$name','$username','$track_id',(select id from intake where current='1'))");
    
    if ($student_query) {

        echo "                   
                    <script type='text/javascript'>    
                        alert('Saving performed successfully');    
                        window.location.assign('adminpage.php#fragment-5');
                    </script>    
                        ";
    }
}

// Edit Student Data from page (students.php)

if (isset($_POST['edit'])) {
    $name = $_POST['name'];
    $username = $_POST['username'];
    $id = $_POST['student_id'];
    $track_id = $_POST['track_id'];
    $intake_id = $_POST['intake_id'];

    $student_update_query = executeQuery("update student set name='$name',username='$username',track_id='$track_id',intake_id='$intake_id' where id='$id'");

    if ($student_update_query) {
        echo "                   
                    <script type='text/javascript'>    
                        alert('Editing Student data performed successfully');
                        window.location.assign('adminpage.php#fragment-5');
                    </script>    
                        ";
    }
}
?>