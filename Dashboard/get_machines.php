<?php
// Include database connection file
require_once 'db_connect.php';

header('Content-Type: application/json');

$locationID = isset($_GET['locationID']) ? $_GET['locationID'] : '';

if ($locationID) {
    $sql = "SELECT m.MachineID, m.LegacyID, m.CIDNumber, m.SerialNumber, m.Description,
            m.Supplier, m.PurchasePrice, m.PurchaseDate, m.SalePrice, m.SaleDate, m.SoldTo,
            mt.Name AS MachineTypeName, mt.Model AS MachineTypeModel,
            mt.Manufacture AS MachineTypeManufacture, mt.Genre AS MachineTypeGenre,
            mt.Dimensions AS MachineTypeDimensions
            FROM Machines m
            JOIN MachineType mt ON m.MachineTypeID = mt.MachineTypeID
            JOIN MachineHistory mh ON m.MachineID = mh.MachineID
            WHERE mh.LocationID = ? AND mh.EndDate IS NULL
            ORDER BY mh.StartDate DESC";

    $stmt = $db->prepare($sql);
    $stmt->bind_param("i", $locationID);
    $stmt->execute();
    $result = $stmt->get_result();

    $machines = array();

    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $machines[] = $row;
        }
        echo json_encode($machines);
    } else {
        echo json_encode(array('message' => 'No Machines Found at the specified location'));
    }

    $stmt->close();
} else {
    echo json_encode(array('message' => 'Location ID not specified'));
}

$db->close();
?>
