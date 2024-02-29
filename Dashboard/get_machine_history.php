<?php
// Include database connection file
require_once 'db_connect.php';

header('Content-Type: application/json'); // Set appropriate response header

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['machine_id'])) {
    // Prepare a select statement with JOIN to fetch location details
    $sql = "SELECT loc.Name AS LocationName, loc.Address AS LocationAddress
            FROM MachineHistory mh
            JOIN Locations loc ON mh.LocationID = loc.LocationID
            WHERE mh.MachineID=?
            ORDER BY mh.StartDate DESC";

    if ($stmt = $db->prepare($sql)) {
        // Bind variables to the prepared statement as parameters
        $stmt->bind_param("i", $param_machine_id);
        $param_machine_id = $_POST['machine_id'];

        // Execute the prepared statement and get the result
        if ($stmt->execute()) {
            $result = $stmt->get_result();
            $history = array();
            while ($row = $result->fetch_assoc()) {
                array_push($history, $row);
            }
            echo json_encode($history); // Return the data as JSON
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
