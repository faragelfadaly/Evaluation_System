<?php

include './config.php';

if (isset($_POST['operation'])) {
    $course_id = $_POST['course_id'];

    $course_query = executeQuery("select code from course where id='$course_id';");


    if ($row = mysqli_fetch_assoc($course_query)) {
        echo $row['code'];
    }
} else {
    if (isset($_POST['-1'])) {
        if (isset($_POST['add'])) {

            $course_name = $_POST['-1'];
            $code = $_POST['course_code'];
            $course_query = executeQuery("INSERT INTO `course`( `name`, `code`) VALUES ('$course_name','$code');");
        } else {
            ?>
            <script>
                alert("notfound");
            </script>
            <?php

        }
    } else {
        $course_id = $_POST['course_id'];
        if (isset($_POST['delete'])) {
            $course_query = executeQuery("DELETE FROM `course` where `id`=$course_id;");
        } else if (isset($_POST['add'])) {
            $code = $_POST['course_code'];
            $course_query = executeQuery("update `course` set `code`='$code' where `id`=$course_id;");
        }        
    }
    @header("Location: adminpage.php");
}
?>
