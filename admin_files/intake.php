<?php

include '../config.php';

$link = connectToDB();
if (!$link) {
    die("Error while connecting to Database" . mysqli_error($link));
}

if (isset($_POST['set_as_current'])) {

    $intake_id = $_POST['intake_no'];

    $query = mysqli_query($link, "
        UPDATE intake SET current='0' WHERE 1;        
    ");
    $query1 = mysqli_query($link, "
        UPDATE intake SET current='1' WHERE id='$intake_id';
    ");
} else if (isset($_POST['-1'])) {
    if (isset($_POST['add'])) {

        $intake_no = $_POST['-1'];
        $year = $_POST['year'];

        $intake_query = executeQuery("INSERT INTO intake (intake_no,year) VALUES ($intake_no,$year);");
    } else {
        ?>
        <script>
            alert("notfound");
        </script>
        <?php

    }
} else {
    $intake_no = $_POST['intake_no'];
    if (isset($_POST['delete'])) {
        $intake_query = executeQuery("DELETE FROM `intake` where `id`=$intake_no;");
    } else if (isset($_POST['set_as_current'])) {
        
    }
}

@header("Location: adminpage.php");
?>
