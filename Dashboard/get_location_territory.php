<?php
// Include database connection file
require_once 'db_connect.php';

header('Content-Type: application/json');

// Get the territory from the URL query string
$territory = isset($_GET['territory']) ? $_GET['territory'] : '';

$locations = array();

if ($territory) {
    // Prepare the SQL statement to prevent SQL injection
    $stmt = $db->prepare("SELECT * FROM Locations WHERE Territory = ?");
    $stmt->bind_param("s", $territory); // "s" indicates the type is a string
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        while($row = $result->fetch_assoc()) {
            $locations[] = $row;
        }
        echo json_encode($locations);
    } else {
        echo json_encode(array('message' => 'No locations found for the specified territory'));
    }
    $stmt->close();
} else {
    echo json_encode(array('message' => 'Territory not specified'));
}

$db->close();
?>
