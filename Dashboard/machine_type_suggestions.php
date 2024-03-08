<?php
// Include database connection file
require_once 'db_connect.php';

header('Content-Type: application/json');

$searchTerm = isset($_GET['search']) ? $_GET['search'] : '';

$locations = array();

if ($searchTerm) {
    // Prepare the SQL statement to prevent SQL injection
    $stmt = $db->prepare("SELECT MachineTypeID, Name, Model, Manufacture FROM MachineType WHERE Name LIKE CONCAT('%', ?, '%')");
    $stmt->bind_param("s", $searchTerm);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        while($row = $result->fetch_assoc()) {
            $locations[] = $row;
        }
        echo json_encode($locations);
    } else {
        echo json_encode(array('message' => 'No locations found'));
    }
    $stmt->close();
} else {
    echo json_encode(array('message' => 'Search term not specified'));
}

$db->close();
?>
