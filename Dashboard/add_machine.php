<?php
// Include database connection file
require_once 'db_connect.php';

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    // Start a transaction
    $db->begin_transaction();

    try {
        // Prepare an insert statement for Machines table
        $sql = "INSERT INTO Machines (Manufacture, Model, LegacyID, CIDNumber, SerialNumber, Name, Genre, Description, Dimensions, Supplier, PurchasePrice, PurchaseDate, SalePrice, SaleDate, SoldTo) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
        $stmt = $db->prepare($sql);

        // Bind variables to the prepared statement as parameters
        $stmt->bind_param("sssssssssssssss", $param_manufacture, $param_model, $param_legacy_id, $param_cid_number, $param_serial_number, $param_name, $param_genre, $param_description, $param_dimensions, $param_supplier, $param_purchase_price, $param_purchase_date, $param_sale_price, $param_sale_date, $param_sold_to);

        // Set parameters
        $param_manufacture = $_POST['manufacture'];
        $param_model = $_POST['model'];
        $param_legacy_id = $_POST['legacy_id'];
        $param_cid_number = $_POST['cid_number'];
        $param_serial_number = $_POST['serial_number'];
        $param_name = $_POST['name'];
        $param_genre = $_POST['genre'];
        $param_description = $_POST['description'];
        $param_dimensions = $_POST['dimensions'];
        $param_supplier = $_POST['supplier'];
        $param_purchase_price = $_POST['purchase_price'];
        $param_purchase_date = $_POST['purchase_date'];
        $param_sale_price = $_POST['sale_price'];
        $param_sale_date = $_POST['sale_date'];
        $param_sold_to = $_POST['sold_to'];

        // Execute the prepared statement
        $stmt->execute();
        $stmt->close();

        // Get the last inserted id
        $last_inserted_machine_id = $db->insert_id;
        // Commit the transaction
        $db->commit();
    }
    catch (Exception $e) {
        // An exception has occurred, which means something went wrong
        $db->rollback();
        echo "ERROR: Could not execute query (add machine failed): " . $e->getMessage();
    }
    $db->begin_transaction();
    try{
        // Now insert into MachineHistory table
        $sql_history = "INSERT INTO MachineHistory (MachineID, LocationID, StartDate, EndDate) VALUES (?, ?, ?, ?)";
        $stmt_history = $db->prepare($sql_history);

        // Bind parameters
        $stmt_history->bind_param("iiss", $last_inserted_machine_id, $param_location_id, $param_start_date, $param_end_date);

        // Set parameters
        $param_location_id = $_POST['location_id'];
        $param_start_date = $_POST['start_date'];  // Assuming this is coming from your form
        $param_end_date = $_POST['end_date'];      // Assuming this is coming from your form, can be NULL

        // Execute the statement
        $stmt_history->execute();
        $stmt_history->close();

        // Commit the transaction
        $db->commit();

        // Redirect to a confirmation page if the query was successful
        header("Location: add_machine_success.html");
        exit(); // Ensure no further execution of the script after redirect
    } catch (Exception $e) {
        // An exception has occurred, which means something went wrong
        $db->rollback();
        echo "ERROR: Could not execute query (add location failed): " . $e->getMessage();
        echo "location id:" . $param_location_id;
    }
} else {
    echo "ERROR: Invalid request";
}

// Close connection
$db->close();
?>
