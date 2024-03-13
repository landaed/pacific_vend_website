<?php
// Include database connection file
require_once 'db_connect.php';

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    // Prepare an insert statement
    $sql = "INSERT INTO MachineHistory (MachineID, LocationID, StartDate, EndDate) VALUES (?, ?, ?, ?)";

    if ($stmt = $db->prepare($sql)) {
        // Bind variables to the prepared statement as parameters
        $stmt->bind_param("iiss", $param_machine_id, $param_location_id, $param_start_date, $param_end_date);

        // Set parameters
        $param_machine_id = $_POST['machineIDInput'];
        $param_location_id = $_POST['locationInput'];
        $param_start_date = $_POST['start_date'];
        $param_end_date = isset($_POST['end_date']) ? $_POST['end_date'] : NULL;

        // Attempt to execute the prepared statement
        if ($stmt->execute()) {
            // Redirect to a confirmation page if the query was successful
            header("Location: add_machine_history_success.html");
            exit(); // Ensure no further execution of the script after redirect
        } else {
            echo "ERROR: Could not execute query: $sql. " . $db->error;
        }
    } else {
        echo "ERROR: Could not prepare query: $sql. " . $db->error;
    }

    // Close statement
    $stmt->close();
}

// Close connection
$db->close();
?>
