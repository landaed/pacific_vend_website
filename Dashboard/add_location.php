<?php
// Include database connection file
require_once 'db_connect.php';

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    // Prepare an insert statement
    $sql = "INSERT INTO Locations (name, address, city, ZipCode, province, Territory, type, email, PhoneNumber) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)";

    if($stmt = $db->prepare($sql)){
        // Bind variables to the prepared statement as parameters
        $stmt->bind_param("sssssssss", $param_name, $param_address, $param_city, $param_zip_code, $param_province, $param_territory, $param_type, $param_email, $param_phone_number);

        // Set parameters
        $param_name = $_POST['name'];
        $param_address = $_POST['address'];
        $param_city = $_POST['city'];
        $param_zip_code = $_POST['ZipCode'];
        $param_province = $_POST['Province'];
	$param_territory = $_POST['Territory'];
        $param_type = $_POST['type'];
        $param_email = $_POST['email'];
        $param_phone_number = $_POST['phone_number'];

        // Attempt to execute the prepared statement
        if($stmt->execute()){
            // Redirect to a confirmation page if the query was successful
            header("Location: add_location_success.html");
            exit(); // Ensure no further execution of the script after redirect
        } else{
            echo "ERROR: Could not execute query: $sql. " . $db->error;
        }
    } else{
        echo "ERROR: Could not prepare query: $sql. " . $db->error;
    }

    // Close statement
    $stmt->close();
}

// Close connection
$db->close();
?>
