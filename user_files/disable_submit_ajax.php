<?php

    
include '../config.php';

$course_id=$_POST['course_id'];
session_start();
$id = $_SESSION['userid'];
$link= connectToDB();
    
    ////////////////////////////////////////////////////////////////////////////////////////////////
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

        $courses_c_eval[] = array('cname' =>$row['cname'],'cid' => $row['cid']);
    }
}

// Get all courses that don't exist in instructor evaluation table
$courses_i_eval = array();
if (!$result = mysqli_query($link, "SELECT DISTINCT c.name as cname ,c.id as cid 
                                    FROM course c,evaluation ev
                                    where ev.course_id=c.id 
                                    and ev.id not in(select ieval.eval_id from instructor_eval ieval where ieval.student_id='$id') 
                                    and ev.track_id=(select s.track_id from student s where s.id='$id' )")) {

    die("invalid");
} else {
    while ($row = mysqli_fetch_assoc($result)) {

        $courses_i_eval[] = array('cname' => $row['cname'],'cid' => $row['cid']);
    }
}
 
  // Make a new array carries courses for evaluation indicating if it need:
 // instructor evaluation
 // or course evaluation
 // or both
  
$allCourses=array();
foreach ($courses_c_eval as $c_item)
{
    if(in_array($c_item, $courses_i_eval))
    {
        $allCourses[]=array($c_item['cid'],$c_item['cname'],1,1);                
    }
 else {
        $allCourses[]=array($c_item['cid'],$c_item['cname'],1,0);                
    }
}
foreach ($courses_i_eval as $i_item)
{
    if(!in_array($i_item, $courses_c_eval))
    {
        $allCourses[]=array($i_item['cid'],$i_item['cname'],0,1);                
    } 
}

    //////////////////////////////////////////////////////////////////////////////////////////////
    foreach ($allCourses as $course) 
    {
        if($course_id==$course[0])
        {
            $disable_array=array($course[2],$course[3]);                                    
            echo json_encode($disable_array);
            break;
        }
    }

?>
