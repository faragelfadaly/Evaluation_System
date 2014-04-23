<?php

include './config.php';
if (isset($_POST['operation'])) {
    $track_id = $_POST['track_id'];

    $track_query = executeQuery("SELECT  inst.id,inst.name FROM instructor inst,track t WHERE inst.id=t.supervisor_id and t.id='$track_id';");

    if ($row = mysqli_fetch_array($track_query)) {
        echo "<input type='hidden' name='trackinstid' id='trackinstid' value='{$row["id"]}'>";
        echo "<input type='text' name='trackinst' id='trackinst' value='{$row["name"]}'/>";
    }
} else {
    if (isset($_POST['add'])) {        
        if ($_POST['track_id'] == '-2') {
            $track_name = $_POST['-1'];
            $supervisor = $_POST['hidinstructor_id'];
            $track_query = executeQuery("
                INSERT INTO `track`(`name`,`supervisor_id`) VALUES ('$track_name','$supervisor');");
        } else {
            $track_id = $_POST['track_id'];
            $supervisor = $_POST['trackinstid'];
            if ($_POST['-1']) {
                $track_name = $_POST['-1'];                
                $track_query = executeQuery("update `track` set `name`='$track_name',`supervisor_id`='$supervisor' where `id`='$track_id';");
            } else {
                $track_query = executeQuery("update `track` set `supervisor_id`='$supervisor' where `id`='$track_id';");
            }
        }
        
    } else {
        $track_id = $_POST['track_id'];
        if (isset($_POST['delete'])) {
            $track_query = executeQuery("DELETE FROM `track` where `id`=$track_id;");
        }
    }
    @header("Location: adminpage.php");
}
?>
