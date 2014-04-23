<?php

include './config.php';

$intake_id = $_POST["intake_id"];
$track_id=$_POST["track_id"];
$course_id=$_POST["course_id"];

//$intakes_query = executeQuery("
//SELECT i.id as iid, i.name as iname
//FROM evaluation e
//JOIN instructor i ON i.id = e.inst_id
//WHERE e.intake_id = '{$intake_id}'
//AND e.track_id ='{$track_id}'
//AND e.course_id ='{$course_id}'     
//ORDER BY i.name
//");

$intakes_query = executeQuery("
SELECT i.id as iid, i.name as iname ,ei.scope as iscope
FROM evaluation e
JOIN 
(eval_inst_evtable ei join instructor i on ei.inst_id = i.id)
on e.id=ei.eval_id
WHERE e.intake_id = '{$intake_id}'
AND e.track_id ='{$track_id}'
AND e.course_id ='{$course_id}'     
ORDER BY i.name        
");


$instructors = array();

while ($row = mysqli_fetch_array($intakes_query)) {
    $instructors[] = array($row['iid'], $row['iname'],$row['iscope']);
}
echo json_encode($instructors);
?>
