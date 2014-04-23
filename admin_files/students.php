<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">    
    <script  type="text/javascript" src="../styles/jquery-1.8.0.js"></script>
    <script type="text/javascript" src="../styles/jquery-ui-1.10.0.custom.js"></script>
    <link type="text/css" rel="stylesheet" href="../styles/jquery-ui-1.10.0.custom.css"/>
    <link type="text/css" rel="stylesheet" href="../styles/admin_style.css"/>
    
    <script type="text/javascript" src="../styles/styles_students.js"></script>

</head>          

<?php
include './config.php';

if (isset($_POST['operation'])) {
    $track_id = $_POST['track_id'];

    $students_query = executeQuery("select id,name from student where track_id='$track_id' and intake_id=(select id from intake where current='1')");


    while ($row = mysqli_fetch_array($students_query)) {
        echo "<option value='{$row["id"]}'>" . "{$row['name']}" . "</option>";
    }
}

//////////////////////////// Track ////////////////////////////////////////////////////////////

if (isset($_POST['add'])) {
    $tracks_query = executeQuery("select id,name from track");
    $tracks = array();
    while ($row = mysqli_fetch_assoc($tracks_query)) {
        $tracks[] = array(
            'id' => $row['id'],
            'name' => $row['name']
        );
    }

    $intakes_query = executeQuery("select id,intake_no from intake");
    $intakes = array();
    while ($row = mysqli_fetch_assoc($intakes_query)) {
        $intakes[] = array(
            'id' => $row['id'],
            'intake_no' => $row['intake_no']
        );
    }
//////////////////////////////////////  Add Student Form //////////////////////////////////////////////       
    ?>    
    <div style="background-color: #76b4ff">
        <div class="ui-tabs-panel ui-widget-content ui-corner-bottom" style="font-size: 20px">
            <form method="post" action="studentAdd.php">
                Name:
                <input type="text" name="name"/>
                <br><br>
                Username:
                <input type="text" name="username"/>
                <br><br>    
                Track:
                <select name="track_id">
                    <?php
                    foreach ($tracks as $track) {
                        ?>
                        <option value="<?php echo "{$track['id']}"; ?>"><?php echo "{$track['name']}"; ?></option>
                        <?php
                    }
                    ?>
                </select>
                <br><br>    
                <input type="submit" name="save" id="save_student" value="Save"/>

            </form>
        </div>
    </div>
    <!-- --------------------- Edit student -------------------------------------------  --->
    <?php
}

if (isset($_POST['edit'])) {
    $student_query = executeQuery("SELECT s.name, s.username, i.intake_no,t.name as tn
        FROM intake as i 
        INNER JOIN
        ( student as s INNER JOIN track as t
        ON s.track_id = t.id)
        ON  s.intake_id = i.id and s.id='{$_POST['student_name']}'"
    );

    if ($student_query) {
        if ($row = mysqli_fetch_assoc($student_query)) {
            $student_name = $row['name'];
            $student_username = $row['username'];
            $student_track_name = $row['tn'];
            $student_intake_name = $row['intake_no'];
        }
    }
    $tracks_query = executeQuery("select id,name from track ");
    $tracks = array();
    while ($row = mysqli_fetch_assoc($tracks_query)) {
        $tracks[] = array(
            'id' => $row['id'],
            'name' => $row['name']
        );
    }

    $intakes_query = executeQuery("select id,intake_no from intake");
    $intakes = array();
    while ($row = mysqli_fetch_assoc($intakes_query)) {
        $intakes[] = array(
            'id' => $row['id'],
            'intake_no' => $row['intake_no']
        );
    }
    ?>
    <div id="old_data" style="border: brown solid thick;width: 400px">
        <label>Old data</label>    
        <br><br>
        Name:
        <input type="text" name="name" value="<?php echo $student_name; ?>"/>
        <br><br>
        Username:
        <input type="text" name="username" value="<?php echo $student_username; ?>"/>
        <br><br>    
        Track:
        <input type="text" value="<?php echo "$student_track_name"; ?>"/>
        <br><br>    
        Intake:    
        <input type="text" value="<?php echo "$student_intake_name"; ?>"/>
        <br><br>    
    </div>
    <br><br>
    <form method="post" action="studentAdd.php">   

        <div id="new_data" style="border: brown solid thick;width: 400px">
            <label>New data</label>    
            Name:
            <input type="text" name="name" value="<?php echo $student_name; ?>"/>
            <br><br>
            Username:
            <input type="text" name="username" value="<?php echo $student_username; ?>"/>
            <br><br>    
            Track:
            <select name="track_id">
                <?php
                foreach ($tracks as $track) {
                    ?>
                    <option value="<?php echo "{$track['id']}"; ?>"><?php echo "{$track['name']}"; ?></option>
                    <?php
                }
                ?>
            </select>
            <br><br>    
            Intake:
            <select name="intake_id">
                <?php
                foreach ($intakes as $intake) {
                    ?>
                    <option value="<?php echo "{$intake['id']}"; ?>"><?php echo "Intake" . "{$intake['intake_no']}"; ?></option>
                    <?php
                }
                ?>
            </select>
            <input type="hidden" name="student_id" value="<?php echo "{$_POST['student_name']}"; ?>"/>
        </div>
        <input type="submit" name="edit" value="Save"/>            
    </form>
    <!-- ------------------------------------ Delete Student ------------------------------------------------ -->
    <?php
}
if (isset($_POST['delete'])) {
    $id = $_POST['student_name'];
    echo "$id";
    ?>
    <script>

        if (confirm("Delete Student,Are you sure?") == true)
        {
    <?php
    $delete_student_query = executeQuery("delete from student where id='$id'");
    if ($delete_student_query) {
        ?>
                alert("Student deleted successfully");
                //window.location.assign("adminpage.php#fragment-5");
        <?php
    }
    ?>
        }
        else
        {
            window.location.assign("adminpage.php");
        }
    </script>

    <!-- ------------------------------------ Transfer Student ------------------------------------------------ -->
    <?php
}

if (isset($_POST['transfer'])) {
    $old_track = $_POST['track_old'];
    $new_track = $_POST['track_new'];
    $student_id = $_POST['student_transfer_name'];
    ?>
    <script>
        if (confirm("Are you sure,transfer student?"))
        {
    <?php
    $transfer_query = executeQuery("update student set track_id='$new_track' where id='$student_id'");
    if ($transfer_query) {
        ?>
                alert("Student transferred successfully");
                window.location.assign("adminpage.php");
        <?php
    }
    ?>
        }
        else
        {
            window.location.assign("adminpage.php");
        }
    </script>
    <?php
}
?>