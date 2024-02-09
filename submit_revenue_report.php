<?php
include 'db_connect.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $machine_id = $_POST['MachineID'];
    $location_id = $_POST['LocationID'];
    $collection_date = $_POST['CollectionDate'];
    $revenue_amount = $_POST['RevenueAmount'];

    $sql = "INSERT INTO RevenueReports (MachineID, LocationID, CollectionDate, RevenueAmount) VALUES (?, ?, ?, ?)";

    if($stmt = mysqli_prepare($db, $sql)){
        mysqli_stmt_bind_param($stmt, "iisd", $machine_id, $location_id, $collection_date, $revenue_amount);

        if(mysqli_stmt_execute($stmt)){
            echo "Record added successfully.";
        } else{
            echo "ERROR: Could not execute query: $sql. " . mysqli_error($db);
        }
    } else{
        echo "ERROR: Could not prepare query: $sql. " . mysqli_error($db);
    }

    mysqli_stmt_close($stmt);
}
mysqli_close($db);
?>
