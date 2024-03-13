<?php
// Include database connection file
require_once 'db_connect.php';

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
  $db->begin_transaction();
  try{
      // Prepare an insert statement
      $sql = "INSERT INTO MachineHistory (MachineID, LocationID, StartDate, EndDate) VALUES (?, ?, ?, ?)";

      $stmt = $db->prepare($sql);
      // Bind variables to the prepared statement as parameters
      $stmt->bind_param("iiss", $param_machine_id, $param_location_id, $param_start_date, $param_end_date);

      // Set parameters
      $param_machine_id = $_POST['machineIDInput'];
      $param_location_id = $_POST['locationInput'];
      $param_start_date = $_POST['start_date'];
      $param_end_date = isset($_POST['end_date']) ? $_POST['end_date'] : NULL;

      // Execute the prepared statement
      $stmt->execute();
      $stmt->close();


      // Commit the transaction
      $db->commit();
      header("Location: add_machine_history_success.html");
    }
    catch (Exception $e) {
        // An exception has occurred, which means something went wrong
        $db->rollback();
        echo "ERROR: Could not execute query (add machine history failed): " . $e->getMessage();
    }
}

// Close connection
$db->close();
?>
