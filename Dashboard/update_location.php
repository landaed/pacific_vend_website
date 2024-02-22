<?php
// Include database connection file
require_once 'db_connect.php';

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['original_name']) && isset($_POST['original_address'])) {
    // SQL query to update the location
    $sql = "UPDATE Locations SET name=?, address=?, city=?, ZipCode=?, province=?, Territory=?, type=?, email=?, PhoneNumber=? WHERE name=? AND address=?";

    if($stmt = $db->prepare($sql)){
        // Bind variables to the prepared statement as parameters
        $stmt->bind_param("sssssssssss", $_POST['name'], $_POST['address'], $_POST['city'], $_POST['ZipCode'], $_POST['Province'], $_POST['Territory'], $_POST['type'], $_POST['email'], $_POST['phone_number'], $_POST['original_name'], $_POST['original_address']);

        // Attempt to execute the prepared statement
        if($stmt->execute()){
            header("Location: ".$_SERVER['PHP_SELF']);
        } else{
            echo json_encode(array('message' => 'Error updating location: ' . $db->error));
        }
    } else {
        echo json_encode(array('message' => 'Error preparing query: ' . $db->error));
    }

    // Close statement
    $stmt->close();
}

// Close connection
$db->close();
?>
