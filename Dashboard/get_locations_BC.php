<?php
// Include database connection file
require_once 'db_connect.php';

header('Content-Type: application/json');

// Adjusted SQL query to select only locations where Province is 'BC'
$sql = "SELECT * FROM Locations WHERE Province = 'BC'";
$result = $db->query($sql);

$locations = array();

if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
        $locations[] = $row;
    }
    echo json_encode($locations);
} else {
    echo json_encode(array('message' => 'No locations found in BC'));
}

$db->close();
?>
