<?php
// Include database connection file
require_once 'db_connect.php';

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    // Start a transaction
    $db->begin_transaction();

    try {
        // Prepare an insert statement for Users table
        $sql = "INSERT INTO Users (username, password, role, territory) VALUES (?, ?, ?, ?)";
        $stmt = $db->prepare($sql);

        // Bind variables to the prepared statement as parameters
        $stmt->bind_param("ssss", $param_username, $param_password, $param_role, $param_territory);

        // Set parameters and hash password
        $param_username = $_POST['username'];
        $param_password = password_hash($_POST['password'], PASSWORD_DEFAULT);
        $param_role = $_POST['role'];
        $param_territory = $_POST['territory'];

        // Execute the prepared statement
        $stmt->execute();
        $stmt->close();

        // Commit the transaction
        $db->commit();
        header("Location: index.php?status=success");
    }
    catch (Exception $e) {
        // An exception has occurred, which means something went wrong
        $db->rollback();
        header("Location: index.php?status=failure");
    }
}

// Close connection
$db->close();
?>
