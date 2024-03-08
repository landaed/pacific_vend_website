<?php
// Include database connection file
require_once 'db_connect.php';

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    // Start a transaction
    $db->begin_transaction();

    try {
        // Prepare an insert statement for Machines table
        $sql = "INSERT INTO MachineType (Manufacture, Model, Name, Genre, Dimensions) VALUES (?, ?, ?, ?, ?)";
        $stmt = $db->prepare($sql);

        // Bind variables to the prepared statement as parameters
        $stmt->bind_param("sssss", $param_manufacture, $param_model, $param_name, $param_genre, $param_dimensions, );

        // Set parameters
        $param_manufacture = $_POST['manufacture'];
        $param_model = $_POST['model'];
        $param_name = $_POST['name'];
        $param_genre = $_POST['genre'];
        $param_dimensions = $_POST['dimensions'];
        // Execute the prepared statement
        $stmt->execute();
        $stmt->close();


        // Commit the transaction
        $db->commit();
        header("Location: add_machine_type_success.html");
    }
    catch (Exception $e) {
        // An exception has occurred, which means something went wrong
        $db->rollback();
        echo "ERROR: Could not execute query (add machine type failed): " . $e->getMessage();
    }
}
// Close connection
$db->close();
?>
