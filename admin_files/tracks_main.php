<?php

include './config.php';

$intake_id = $_POST["intake_id"];

$intakes_query = executeQuery("select t.name,t.id
    from track t join(track_intake ti join intake i on ti.intake_id=i.id)on t.id=ti.track_id
 where i.id='{$intake_id}' and t.isdeleted='0';");

$tracks = array();

while ($row = mysqli_fetch_array($intakes_query)) {
    $tracks[] = array($row['id'], $row['name']);
}
echo json_encode($tracks);
?>
