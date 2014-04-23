<?php

include './config.php';

if (isset($_POST['operation'])) {
    $inst_id = $_POST['inst_id'];

    $instructor_query = executeQuery("select title from instructor where id='$inst_id';");

    if ($row = mysqli_fetch_assoc($instructor_query)) {
        echo $row['title'];
    }
} else {
    if (isset($_POST['-1'])) {
        if (isset($_POST['add'])) {

            $inst_name = $_POST['-1'];
            $title = $_POST['instructor_title'];
            $instructor_query = executeQuery("INSERT INTO `instructor`( `name`, `title`, `work`) VALUES ('$inst_name','$title','1');");
        } else {
            ?>
            <script>
                alert("notfound");
            </script>
            <?php

        }
    } else {
        $inst_id = $_POST['instructor_id'];
        if (isset($_POST['delete'])) {            
            $instructor_query = executeQuery("update `instructor` set `work`='0' where `id`=$inst_id;");
        } else if (isset($_POST['add'])) {
            $title = $_POST['instructor_title'];
            $instructor_query = executeQuery("update `instructor` set `title`='$title' where `id`=$inst_id;");
        }        
    }
    @header("Location: adminpage.php");
}
?>
