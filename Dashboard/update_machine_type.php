<?php
// Include database connection file
require_once 'db_connect.php';

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['machine_id'])) {
    // Prepare an update statement
    $sql = "UPDATE MachineType SET Manufacture=?, Model=?, Name=?, Genre=?, Dimensions=? WHERE MachineTypeID=?";

    if($stmt = $db->prepare($sql)){
        // Bind variables to the prepared statement as parameters
        $stmt->bind_param("sssssi", $param_manufacture, $param_model, $param_name, $param_genre, $param_dimensions, $param_machine_id);

        // Set parameters
        $param_machine_id = $_POST['machine_id'];
        $param_manufacture = $_POST['manufacture'];
        $param_model = $_POST['model'];

        $param_name = $_POST['name'];
        $param_genre = $_POST['genre'];

        $param_dimensions = $_POST['dimensions'];

        // Attempt to execute the prepared statement
        if($stmt->execute()){
            // Redirect to a confirmation page if the query was successful
            header("Location: update_machine_type_success.html");
            //exit(); // Ensure no further execution of the script after redirect
        } else{
            echo json_encode(array('message' => 'Error updating location: ' . $db->error));
            echo "ERROR: Could not execute query: $sql. " . $db->error;
        }
    } else{
        echo json_encode(array('message' => 'Error preparing query: ' . $db->error));
        echo "ERROR: Could not prepare query: $sql. " . $db->error;
    }

    // Close statement
    $stmt->close();
}

// Close connection
$db->close();
?>
