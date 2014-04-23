<?php

include './config.php';

$old_track_id = $_POST['old_track_id'];

$query = executeQuery("
    select t.id,t.name 
from track t join track_intake ti
on t.id= ti.track_id
where ti.intake_id=(select id from intake where current='1')
AND t.id != '$old_track_id'
");

if(!$query)
{
    die("Query Error");
}

$tracks = array();

while ($row = mysqli_fetch_array($query)) {
    $tracks[] = array($row['id'], $row['name']);
}
echo json_encode($tracks);

?>
