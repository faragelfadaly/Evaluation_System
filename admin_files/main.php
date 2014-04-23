<?php
include './config.php';

$link = connectToDB();

if (!$link) {
    die("Connection to Database Error,<i style='color:red'><b>Try again later<b></i>");
}
$intake_id = $_POST['intake'];
$track_id = $_POST['track'];
$course_id = $_POST['course'];
$instructor_id = $_POST['instructor'];

///////////////// Instructor Evaluation /////////////////
if (isset($_POST['instructor_eval'])) {
    $intake = $_POST['intake'];
    $track = $_POST['track'];
    $course_id = $_POST['course'];
    $instructor_id = $_POST['instructor'];
    $scope = $_POST['scope'];


    $evalquery = mysqli_query($link, "select id from eval_inst_evtable where inst_id='$instructor_id' and scope='$scope' and eval_id=(
        select distinct id from evaluation 
        where intake_id='$intake' and track_id='$track' and course_id='$course_id' );
    ");
    if ($evalquery) {
        $affected = mysqli_affected_rows($link);
        if ($affected == 1) {
            if ($row = mysqli_fetch_assoc($evalquery)) {
                header("Location: instructor_eval.php?eval={$row['id']}");
            }
        }
    }
}
///////////////// Course Evaluation /////////////////
if (isset($_POST['course_eval'])) {
    $intake = $_POST['intake'];
    $track = $_POST['track'];
    $course_id = $_POST['course'];

    $evalquery = mysqli_query($link, "
        select distinct id from evaluation 
        where intake_id='$intake' and track_id='$track' and course_id='$course_id';
    ");
    if ($evalquery) {
        if ($row = mysqli_fetch_assoc($evalquery)) {
            header("Location: course_eval.php?eval={$row['id']}");
        }
    }
}
///////////////// Deactivate Evaluation /////////////////
if (isset($_POST['deactivate'])) {
    echo "<title>Deactivate</title>";

    $delete_query = mysqli_query($link, "
        update evaluation set active='deactivated'
        where intake_id='$intake_id' and track_id='$track_id' and course_id='$course_id';
    ");
    if ($delete_query) {
        header("Location: adminpage.php");
    }
}

///////////////// Delete Evaluation /////////////////
if (isset($_POST['delete'])) {
    echo "<title>Delete Evaluation</title>";

    $track_id = $_POST['track'];
    $course_id = $_POST['course'];
    $instructor_id = $_POST['instructor'];

    $delete_query = mysqli_query($link, "
            delete from evaluation 
            where intake_id='$intake_id' and track_id='$track_id' and course_id='$course_id';        
    ");
    if ($delete_query) {
        header("Location: adminpage.php");
    }
}

///////////////// Edit/////////////////
if (isset($_POST['edit'])) {
    echo "<title>Edit</title>";
}

///////////////// Late Students /////////////////
if (isset($_POST['late_students'])) {
    echo "<title>Late Students</title>";
    $track_id = $_POST['track'];
    $course_id = $_POST['course'];
    $instructor_id = $_POST['instructor'];
    ?>
    <!----------------------------------------------------------------------------------------------------------------------------------------->
    <!-- -------------------------------------------------------------- Lecture Instructor Evaluation late Students ------------------------------------ -->

    <!-- Late Students in instructor Evaluation who evaluate the lecture after due date -->
    <h2 style="color: #1c94c4;background-color: gold">Late Students in Instructor Evaluation who evaluate the  <i><b style='color: red'>Lecture Instructor</b></i> after due date </h2>
    <table border="5px" style="border-color: gold">
        <?php
        $late_students_inst_query = mysqli_query($link, "
                select s.name as sname from student s where s.track_id='$track_id' and s.intake_id='$intake_id' and s.id =(
                select ie.student_id from instructor_eval ie , eval_inst_evtable evt where ie.late='1' and evt.scope='lec' 
                and evt.id=ie.eval_id and evt.eval_id=(
                select id from evaluation where track_id='$track_id' and intake_id='$intake_id' and course_id='$course_id'
            )
        )           
        ");
        if (!$late_students_inst_query) {
            die("Query Error");
        }
        $i = 1;
        while ($row = mysqli_fetch_assoc($late_students_inst_query)) {
            echo "<tr><td>{$i}</td><td>{$row['sname']}</td></tr>";
            $i++;
        }
        ?>
    </table>


    <!-- Late Students in instructor Evaluation who did not evaluate the lectur instructor -->
    <h2 style="color: #1c94c4;background-color: gold">Late Students in Course Evaluation who did not evaluate the  <i><b style='color: red'>Lecture Instructor</b></i> till now </h2>
    <table border="5px" style="border-color: gold">
        <?php
        $late_students_inst_query = mysqli_query($link, "
            select s.name as sname from student s where s.intake_id='$intake_id' and s.track_id='$track_id' 
            and s.id not in (
            select ie.student_id from instructor_eval ie where ie.eval_id in(
            select evt.id from eval_inst_evtable evt , evaluation e where evt.scope='lec' 
            and e.track_id='$track_id' and e.intake_id='$intake_id' and evt.scope='lec' and e.id=evt.eval_id and e.course_id='$course_id'
        ) 
        )  
        ");
        if (!$late_students_inst_query) {
            die("Query Error");
        }
        $i = 1;
        while ($row = mysqli_fetch_assoc($late_students_inst_query)) {
            echo "<tr><td>{$i}</td><td>{$row['sname']}</td></tr>";
            $i++;
        }
        ?>
    </table>
    <!----------------------------------------------------------------------------------------------------------------------------------------->
    <!-- -------------------------------------------------------------- Lab Instructor Evaluation late Students ------------------------------------ -->
    <!-- Late Students in instructor Evaluation who evaluate the lecture after due date -->
    <h2 style="color: #1c94c4;background-color: gold">Late Students in Instructor Evaluation who evaluate the  <i><b style='color: red'>Lab Instructor</b></i> after due date </h2>
    <table border="5px" style="border-color: gold">
        <?php
        $late_students_inst_query = mysqli_query($link, "
                select s.name as sname from student s where s.track_id='$track_id' and s.intake_id='$intake_id' and s.id =(
                select ie.student_id from instructor_eval ie , eval_inst_evtable evt where ie.late='1' and evt.scope='lab' 
                and evt.id=ie.eval_id and evt.eval_id=(
                select id from evaluation where track_id='$track_id' and intake_id='$intake_id' and course_id='$course_id'
            )
        )           
        ");
        if (!$late_students_inst_query) {
            die("Query Error");
        }
        $i = 1;
        while ($row = mysqli_fetch_assoc($late_students_inst_query)) {
            echo "<tr><td>{$i}</td><td>{$row['sname']}</td></tr>";
            $i++;
        }
        ?>
    </table>


    <!-- Late Students in instructor Evaluation who did not evaluate the lectur instructor -->
    <h2 style="color: #1c94c4;background-color: gold">Late Students in Instructor Evaluation who did not evaluate the  <i><b style='color: red'>Lab Instructor</b></i> till now </h2>
    <table border="5px" style="border-color: gold">
        <?php
        $late_students_inst_query = mysqli_query($link, "
            select s.name as sname , s.id as sid , s.track_id as sti from student s where s.intake_id='$intake_id' and s.track_id='$track_id' 
            and s.id not in (
            select ie.student_id from instructor_eval ie where ie.eval_id in(
            select evt.id from eval_inst_evtable evt , evaluation e where e.id=evt.eval_id and evt.scope='lab' 
            and e.track_id='$track_id' and e.intake_id='$intake_id' and e.course_id='$course_id'
        ) 
        )  
        ");
        ////////////////////////////////////////////////////////////////////////////////////
        /*$i=0;
        while (list($sname, $sid, $sti) = mysqli_fetch_array($late_students_inst_query)) {
            echo "$sname"."<br>";
            echo "$sid"."<br>";
            $i++;
        }
         * 
         */
        ///////////////////////////////////////////////////////////////////////////////////

        if (!$late_students_inst_query) {
            die("Query Error");
        }
        $i = 1;
        while ($row = mysqli_fetch_assoc($late_students_inst_query)) {
            echo "<tr><td>{$i}</td><td>{$row['sname']}</td></tr>";
            $i++;
        }
        ?>
    </table>
    <!----------------------------------------------------------------------------------------------------------------------------------------->
    <!-- -------------------------------------------------------------- Course Evaluation late Students ------------------------------------ -->
    <h2 style="color: #1c94c4;background-color: gold">Late Students in Course Evaluation who evaluate the  <i><b style='color: red'>course</b></i> after due date </h2>
    <?php
    /////// Late Students who evaluate course after due date 
    $late_students_course_query = mysqli_query($link, "select s.name as sname from evaluation e , course_eval ce , student s
                                                        where e.track_id='$track_id' 
                                                        and e.course_id='$course_id'
                                                        and e.id=ce.eval_id 
                                                        and ce.late=1 
                                                        and ce.student_id=s.id");
    if (!$late_students_course_query) {
        die("Query Error  <i style='color:red'><b>" . mysqli_error($link) . "</b></i>");
    }
    ?>          
    <table border="5px" style="border-color: gold">
    <?php
    $i = 1;
    while ($row = mysqli_fetch_assoc($late_students_course_query)) {

        echo "<tr><td>{$i}</td><td>{$row['sname']}</td></tr>";
        $i++;
    }
    ?>
    </table>

    <h2 style="color: #1c94c4;background-color: gold">Late Students in Course Evaluation who did not evaluate the  <i><b style='color: red'>course</b></i> till now </h2>
    <?php
    $late_students_course_query = mysqli_query($link, "
            select s.name as sname 
            from student s where s.intake_id='$intake_id'
            and s.track_id='$track_id' and s.id not in (
            select ce.student_id from course_eval ce where ce.eval_id=(select id from evaluation e where e.course_id='$course_id'))
                                                        ");
    if (!$late_students_course_query) {
        die("Query Error  <i style='color:red'><b>" . mysqli_error($link) . "</b></i>");
    }
    ?>          
    <table border="5px" style="border-color: gold">
    <?php
    $i = 1;
    while ($row = mysqli_fetch_assoc($late_students_course_query)) {

        echo "<tr><td>{$i}</td><td>{$row['sname']}</td></tr>";
        $i++;
    }
    ?>
    </table>
        <?php
    }
    ?>