<?php
// Include database connection file
require_once 'db_connect.php';

header('Content-Type: application/json');

$sql = "SELECT * FROM Locations";
$result = $db->query($sql);

$locations = array();

if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
        $locations[] = $row;
    }
    echo json_encode($locations);
} else {
    echo json_encode(array('message' => 'No locations found'));
}

$db->close();
?>
