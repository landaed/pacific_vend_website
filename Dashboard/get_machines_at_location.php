<?php
// Include database connection file
require_once 'db_connect.php';

header('Content-Type: application/json');

// Get the LocationID from the request
$locationID = isset($_GET['locationID']) ? $_GET['locationID'] : '';

if ($locationID) {
    // SQL query to select machines that are currently located at the specified location
    $sql = "SELECT m.*, mh.StartDate, mh.EndDate, l.LocationID
            FROM Machines m
            JOIN MachineHistory mh ON m.MachineID = mh.MachineID
            JOIN Locations l ON mh.LocationID = l.LocationID
            WHERE l.LocationID = ? AND mh.EndDate IS NULL
            ORDER BY mh.StartDate DESC";

    $stmt = $db->prepare($sql);
    $stmt->bind_param("i", $locationID); // "i" indicates the type is an integer
    $stmt->execute();
    $result = $stmt->get_result();

    $machines = array();

    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $machines[] = $row;
        }
        echo json_encode($machines);
    } else {
        echo json_encode(array('message' => 'No Machines Found at the specified location'));
    }

    $stmt->close();
} else {
    echo json_encode(array('message' => 'Location ID not specified'));
}

$db->close();
?>
