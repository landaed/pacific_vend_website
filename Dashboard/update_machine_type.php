<?php
// Include database connection file
require_once 'db_connect.php';

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['machine_id'])) {
    $db->begin_transaction();
    try{
        $sql = "UPDATE MachineType SET Manufacture=?, Model=?, Name=?, Genre=?, Dimensions=? WHERE MachineTypeID=?";
        $stmt = $db->prepare($sql);
        // Bind variables to the prepared statement as parameters
        $stmt->bind_param("sssssi", $param_manufacture, $param_model, $param_name, $param_genre, $param_dimensions, $param_machine_id);

        // Set parameters
        $param_machine_id = $_POST['machine_id'];
        $param_manufacture = $_POST['manufacture'];
        $param_model = $_POST['model'];

        $param_name = $_POST['name'];
        $param_genre = $_POST['genre'];

        $param_dimensions = $_POST['dimensions'];
        $stmt->execute();
        $stmt->close();
        $db->commit();
        header("Location: update_machine_type_success.html");
    }
    catch (Exception $e) {
        // An exception has occurred, which means something went wrong
        $db->rollback();
        echo "ERROR: Could not execute query (update  machine type failed): " . $e->getMessage();
        header("Location: index.html");
    }
}

// Close connection
$db->close();
?>
