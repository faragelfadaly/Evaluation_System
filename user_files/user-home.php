<?php
session_start();

include('../config.php');

$link = connectToDB();
$id = $_SESSION['userid'];

// Get all courses that don't exist in course evaluation table 
$courses_c_eval = array();
if (!$result = mysqli_query($link, "SELECT DISTINCT c.name as cname ,c.id as cid 
                                    FROM course c,evaluation ev,course_eval cev 
                                    where ev.course_id=c.id 
                                    and ev.id not in(select ceval.eval_id from course_eval ceval where ceval.student_id='$id') 
                                    and ev.track_id=(select s.track_id from student s where s.id='$id' )")) {

    die("invalid");
} else {
    while ($row = mysqli_fetch_assoc($result)) {

        $courses_c_eval[] = array('cname' => $row['cname'], 'cid' => $row['cid']);
    }
}
/*
  echo "<pre>";
  print_r($courses_c_eval);
  echo "</pre>";
 * 
 */
// Get all courses that don't exist in instructor evaluation table in lec
$courses_i_eval_lec = array();
if (!$result = mysqli_query($link, "SELECT c.name cname,e.course_id cid,inst.name instname,evt.id instid
                                    FROM eval_inst_evtable evt, evaluation e ,course c,instructor inst
                                    WHERE evt.eval_id = e.id
                                    AND e.course_id=c.id
                                    AND evt.inst_id=inst.id
                                    AND e.track_id = (SELECT track_id
                                                      FROM student
                                                      WHERE id = '$id' ) 
                                    and evt.id not in(select ieval.eval_id from instructor_eval ieval where ieval.student_id='$id')
                                    and evt.scope='lec'")) {

    die("invalid");
} else {
    while ($row = mysqli_fetch_assoc($result)) {

        $courses_i_eval_lec[] = array('cname' => $row['cname'], 'cid' => $row['cid'], 'instid' => $row['instid'], 'instname' => $row['instname']);
    }
}
/*
  echo "<pre>";
  print_r($courses_i_eval_lec);
  echo "</pre>";
 * 
 */
// Get all courses that don't exist in instructor evaluation table in lab
$courses_i_eval_lab = array();
if (!$result = mysqli_query($link, "SELECT c.name cname,e.course_id cid,inst.name instname,evt.id instid
                                    FROM eval_inst_evtable evt, evaluation e ,course c,instructor inst
                                    WHERE evt.eval_id = e.id
                                    AND e.course_id=c.id
                                    AND evt.inst_id=inst.id
                                    AND e.track_id = (SELECT track_id
                                                      FROM student
                                                      WHERE id = '$id' ) 
                                    and evt.id not in(select ieval.eval_id from instructor_eval ieval where ieval.student_id='$id')
                                    and evt.scope='lab'")) {

    die("invalid");
} else {
    while ($row = mysqli_fetch_assoc($result)) {

        $courses_i_eval_lab[] = array('cname' => $row['cname'], 'cid' => $row['cid'], 'instid' => $row['instid'], 'instname' => $row['instname']);
    }
}
/*
  echo "<pre>";
  print_r($courses_i_eval_lab);
  echo "</pre>";
 * 
 */
//    Make a new array carries courses for evaluation indicating if it need:
//    instructor evaluation
//    or course evaluation
//    or both

$allCourses = array();
foreach ($courses_i_eval_lec as $i_item) {
    foreach ($courses_i_eval_lab as $i_lab) {
        foreach ($courses_c_eval as $c_item) {
            if ($i_item['cname'] != $c_item['cname'] && $i_item['cname'] != $i_lab['cname']) {
                $allCourses[] = array($i_item['cid'] => $i_item['cname'], 'flag' => 0, $i_item['instid'] => $i_item['instname'], "");
            } else if ($i_item['cname'] == $c_item['cname'] && $i_item['cname'] == $i_lab['cname']) {
                $allCourses[] = array($i_item['cid'] => $i_item['cname'], 'flag' => 1, $i_item['instid'] => $i_item['instname'], $i_lab['instid'] => $i_lab['instname']);
            } else if ($i_item['cname'] == $c_item['cname'] && $i_item['cname'] != $i_lab['cname']) {
                $allCourses[] = array($i_item['cid'] => $i_item['cname'], 'flag' => 1, $i_item['instid'] => $i_item['instname'], "");
            } else if ($i_item['cname'] != $c_item['cname'] && $i_item['cname'] == $i_lab['cname']) {
                $allCourses[] = array($i_item['cid'] => $i_item['cname'], 'flag' => 0, $i_item['instid'] => $i_item['instname'], $i_lab['instid'] => $i_lab['instname']);
            }
        }
    }
}
foreach ($courses_i_eval_lab as $labitem) {
    foreach ($courses_c_eval as $c_item) {
        foreach ($courses_i_eval_lec as $lecitem) {

            if ($labitem['cname'] != $lecitem['cname'] && $labitem['cname'] != $c_item['cname']) {
                $allCourses[] = array($labitem['cid'] => $labitem['cname'], 'flag' => 0, "", $labitem['instid'] => $labitem['instname']);
            }
        }
    }
}



foreach ($courses_c_eval as $c_item) {
    foreach ($courses_i_eval_lec as $lecitem) {
        foreach ($courses_i_eval_lab as $labitem) {
            if ($c_item['cname'] != $lecitem['cname'] && $c_item['cname'] != $labitem['cname']) {
                $allCourses[] = array($c_item['cid'] => $c_item['cname'], 'flag' => 1, "", "");
            }
        }
    }
    
}
echo "<pre>";
print_r($allCourses);
echo "</pre>";
/* foreach ($courses_c_eval as $c_item) {
  foreach ($courses_i_eval_lec as $lecitem) {
  foreach ($courses_i_eval_lab as $labitem) {
  if ($c_item['cname'] != $lecitem['cname'] && $c_item['cname'] != $labitem['cname']) {
  $allCourses[] = array($c_item['cid'] => $c_item['cname'], 'flag' => 1, "", "");
  }
  }
  }
  }
  foreach ($courses_i_eval_lab as $i_item) {
  foreach ($courses_i_eval_lec as $i_lec) {
  if (!in_array($i_item['cname'], $courses_i_eval_lec) && $i_item['cname'] != $i_lec['cname']) {
  $allCourses[] = array($i_item['cid'] => $i_item['cname'], 'flag' => 0, "", $i_item['instid'] => $i_item['instname']);
  } else if (in_array($i_item['cname'], $courses_c_eval) && $i_item['cname'] != $i_lec['cname']) {
  $allCourses[] = array($i_item['cid'] => $i_item['cname'], 'flag' => 1, "", $i_item['instid'] => $i_item['instname']);
  }
  }
  }
  foreach ($courses_i_eval_lec as $i_item) {
  foreach ($courses_i_eval_lab as $i_lab) {
  if (!in_array($i_item['cname'], $courses_c_eval) && $i_item['cname'] != $i_lab) {
  $allCourses[] = array($i_item['cid'] => $i_item['cname'], 'flag' => 0, $i_item['instid'] => $i_item['instname'], "");
  } else if (!in_array($i_item['cname'], $courses_c_eval) && $i_item['cname'] == $i_lab) {
  $allCourses[] = array($i_item['cid'] => $i_item['cname'], 'flag' => 0, $i_item['instid'] => $i_item['instname'], $i_lab['instid'] => $i_lab['instname']);
  } else if (in_array($i_item['cname'], $courses_c_eval) && $i_item['cname'] != $i_lab) {
  $allCourses[] = array($i_item['cid'], $i_item['cname'], 'flag' => 1, $i_item['instid'] => $i_item['instname'], "");
  } else if (in_array($i_item['cname'], $courses_c_eval) && $i_item['cname'] == $i_lab) {
  $allCourses[] = array($i_item['cid'] => $i_item['cname'], 'flag' => 1, $i_item['instid'] => $i_item['instname'], $i_lab['instid'] => $i_lab['instname']);
  }
  }
  }
 * 
 */

//****************************************
    ?>
    <html>

        <script src="../styles/jquery-1.8.0.js">
        </script>
        <style>
            body
            {
                background-image: url(../images/bg1.jpg);
            }
        </style>
        <script>
            $(document).ready(function() {
                getInstructorname();
                disableSubmit();

                $("#course_name").on("change", getInstructorname);
                //$('.ins[name="ins"]').on("change", getInstructorname);
                $('input[name=ins]').on("change", getInstructorname);

                $("#course_name").on("change", disableSubmit);


            });
            function getInstructorname()
            {        
               
                var course_id=$("#course_name").val();
                var scope=$('input[name=ins]:checked').val();
                $("#inst_names").html("");
                for(var i in $allCourses)
                {
                    //if()
                    //{
                    $("#inst_names").append("<option value='{$row['inst_id']}'>{$row['iname']}</option>");
                    //}
                }               
                $("#inst_names").html(resp);
                getDueDate();
                  
            }

            function getDueDate()
            {
                $.ajax({
                    url: "insts.php",
                    type: "POST",
                    data: {
                        operation: 'find_duedate',
                        course_id: $("#course_name").val(),
                        inst_id: $("#inst_names").val()

                
                
                    },
                    success: function(resp) {
                        $("#duedate").val(resp);

                    }
                });
            }

            function disableSubmit()
            {

                $.ajax({
                    url: "disable_submit_ajax.php",
                    type: "POST",
                    data: {
                        course_id: $("#course_name").val(),
                        id: <?php echo "$id"; ?>
                    },
                    success: function(resp) {
                        var disableOptions = JSON.parse(resp);

                        if (disableOptions[0] === 0)
                        {
                            $("#course_eval_submit").attr("disabled", "true");
                        }
                        else
                        {
                            $("#course_eval_submit").removeAttr("disabled");
                        }

                        if (disableOptions[1] === 0)
                        {
                            $("#instructor_eval_submit").attr("disabled", "true");
                        }
                        else
                        {
                            $("#instructor_eval_submit").removeAttr("disabled");
                        }

                    }
                });

            }
        </script> 
        <body>
            <div id='3' align='center' style="margin-top: 150px">
                <form action='insts.php' id='login' method='post' accept-charset='UTF-8'>
                    <fieldset style=" height: 300px;font-size: 30px ">
                        <a href="../login.php?value=Signout">Signout</a>
                        <br>
                        Subject:
                        <select name="course_id" id="course_name">
                            <br>
                            <?php
                            foreach ($allCourses as $course) {


                                echo "<option value='{$course[0]}' >{$course[1]}</option>";
                            }
                            ?>
                    </select> 
                    <br>
                    Lecture:<input type="radio" class="ins" name="ins" value="lec" checked>

                    Lab: <input type="radio" class="ins" name="ins" value="lab">
                    <br>

                    Instructor:
                    <select name="instructor_id" id="inst_names" >    </select>
                    <br>
                    <span>Evaluation deadline is:  <input type="text" disabled id='duedate'/></span>
                    <br>
                    <input type='submit' id="instructor_eval_submit" name='instructor' value='Instructor Evaluation' />
                    <input type='submit' id="course_eval_submit" name='course' value='Course Evaluation'  />
                </fieldset>
            </form>
        </div>
    </body>
</html>