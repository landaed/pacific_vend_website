<?php
// Include database connection file
require_once 'db_connect.php';

header('Content-Type: application/json'); // Set appropriate response header

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['machine_id'])) {
    // Prepare a SQL query to fetch the current location
    $sql = "SELECT mh.*, loc.Name AS LocationName
            FROM MachineHistory mh
            JOIN Locations loc ON mh.LocationID = loc.LocationID
            WHERE mh.MachineID=? AND mh.EndDate IS NULL
            ORDER BY mh.StartDate DESC
            LIMIT 1";

    if ($stmt = $db->prepare($sql)) {
        // Bind machine ID to the prepared statement as a parameter
        $stmt->bind_param("i", $param_machine_id);
        $param_machine_id = $_POST['machine_id'];

        // Execute the prepared statement and get the result
        if ($stmt->execute()) {
            $result = $stmt->get_result();
            $locations = [];
            while ($row = $result->fetch_assoc()) {
                array_push($locations, $row);
            }

            echo json_encode($locations); // Return an array of locations (even if it's just one)
        } else {
            echo json_encode(array("error" => "Could not execute query: " . $db->error));
        }
    } else {
        echo json_encode(array("error" => "Could not prepare query: " . $db->error));
    }

    // Close statement
    $stmt->close();
} else {
    echo json_encode(array("error" => "Invalid request"));
}

// Close connection
$db->close();
?>
