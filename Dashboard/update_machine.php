<?php
// Include database connection file
require_once 'db_connect.php';

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['machine_id'])) {
    // Prepare an update statement
    $sql = "UPDATE Machines SET MachineTypeID=?, LegacyID=?, CIDNumber=?, SerialNumber=?, Description=?, Supplier=?, PurchasePrice=?, PurchaseDate=?, SalePrice=?, SaleDate=?, SoldTo=? WHERE MachineID=?";
    if($stmt = $db->prepare($sql)){
        // Bind variables to the prepared statement as parameters
        $stmt->bind_param("issssssssssi", $param_machine_type, $param_legacy_id, $param_cid_number, $param_serial_number, $param_description, $param_supplier, $param_purchase_price, $param_purchase_date, $param_sale_price, $param_sale_date, $param_sold_to, $param_machine_id);
        // Set parameters
        $param_machine_id = $_POST['machine_id'];
        $param_machine_type = $_POST['machine_type_id'];
        $param_legacy_id = $_POST['legacy_id'];
        $param_cid_number = $_POST['cid_number'];
        $param_serial_number = $_POST['serial_number'];
        $param_description = $_POST['description'];
        $param_supplier = $_POST['supplier'];
        $param_purchase_price = $_POST['purchase_price'];
        $param_purchase_date = $_POST['purchase_date'];
        $param_sale_price = $_POST['sale_price'];
        $param_sale_date = $_POST['sale_date'];
        $param_sold_to = $_POST['sold_to'];
        // Attempt to execute the prepared statement
        if($stmt->execute()){
            // Redirect to a confirmation page if the query was successful
            header("Location: update_machine_success.html");
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
