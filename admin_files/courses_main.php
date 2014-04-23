<?php

include './config.php';

$intake_id = $_POST["intake_id"];
$track_id = $_POST["track_id"];

// get all courses from database if it is activated 
$intakes_query = executeQuery("
SELECT distinct c.id as cid, c.name as cname
FROM evaluation e
JOIN course c ON c.id = e.course_id
WHERE e.intake_id = '{$intake_id}'
AND e.track_id ='{$track_id}'
AND active='activated'
ORDER BY c.name
");

$tracks = array();

while ($row = mysqli_fetch_array($intakes_query)) {
    $tracks[] = array($row['cid'], $row['cname']);
}
echo json_encode($tracks);
?>
