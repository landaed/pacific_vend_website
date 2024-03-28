<?php
// Include database connection file
require_once 'db_connect.php';

header('Content-Type: application/json');

$locationID = isset($_POST['formLocationId']) ? $_POST['formLocationId'] : '';
$collectionDate = isset($_POST['collection_date']) ? $_POST['collection_date'] : '';

if ($locationID && $collectionDate) {
    $sql = "SELECT 
                m.MachineID, m.LegacyID, m.CIDNumber, m.SerialNumber, m.Description,
                m.Supplier, m.PurchasePrice, m.PurchaseDate, m.SalePrice, m.SaleDate, m.SoldTo,
                mt.Name AS MachineTypeName, mt.Model AS MachineTypeModel,
                mt.Manufacture AS MachineTypeManufacture, mt.Genre AS MachineTypeGenre,
                mt.Dimensions AS MachineTypeDimensions,
                mh.StartDate,
                rs.SplitPercentage, l.Name AS LocationName
            FROM 
                Machines m
            LEFT JOIN
                MachineType mt ON m.MachineTypeID = mt.MachineTypeID
            JOIN 
                MachineHistory mh ON m.MachineID = mh.MachineID
            LEFT JOIN
                RevenueSplits rs ON m.MachineID = rs.MachineID
            LEFT JOIN
                Locations l ON rs.LocationID = l.LocationID
            WHERE 
                mh.LocationID = ? AND mh.StartDate <= ? AND (mh.EndDate IS NULL OR mh.EndDate > ?)
            ORDER BY 
                mh.StartDate DESC, l.Name ASC";

    $stmt = $db->prepare($sql);
    $stmt->bind_param("iss", $locationID, $collectionDate, $collectionDate);
    $stmt->execute();
    $result = $stmt->get_result();

    $machines = array();

    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $machineId = $row['MachineID'];
            if (!isset($machines[$machineId])) {
                $machines[$machineId] = $row;
                $machines[$machineId]['Splits'] = array();
            }

            if ($row['SplitPercentage'] != null) {
                array_push($machines[$machineId]['Splits'], array(
                    "SplitPercentage" => $row['SplitPercentage'],
                    "LocationName" => $row['LocationName']
                ));
            }
        }
        echo json_encode(array_values($machines));
    } else {
        echo json_encode(array('message' => 'No Machines Found at the specified location'));
    }

    $stmt->close();
} else {
    echo json_encode(array('message' => 'Location ID and/or Collection Date not specified'));
}

$db->close();
?>
