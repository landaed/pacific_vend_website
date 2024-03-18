<?php
// Include database connection file
require_once 'db_connect.php';

header('Content-Type: application/json');

$locationID = isset($_GET['locationID']) ? $_GET['locationID'] : '';

if ($locationID) {
    $sql = "SELECT 
    m.MachineID, m.LegacyID, m.CIDNumber, m.SerialNumber, m.Description,
    m.Supplier, m.PurchasePrice, m.PurchaseDate, m.SalePrice, m.SaleDate, m.SoldTo,
    mt.Name AS MachineTypeName, mt.Model AS MachineTypeModel,
    mt.Manufacture AS MachineTypeManufacture, mt.Genre AS MachineTypeGenre,
    mt.Dimensions AS MachineTypeDimensions,
    mh.StartDate
FROM 
    Machines m
JOIN 
    MachineType mt ON m.MachineTypeID = mt.MachineTypeID
JOIN 
    MachineHistory mh ON m.MachineID = mh.MachineID
JOIN
    (SELECT MachineID, MAX(StartDate) as MaxStartDate
     FROM MachineHistory
     GROUP BY MachineID) mh2 ON mh.MachineID = mh2.MachineID AND mh.StartDate = mh2.MaxStartDate
WHERE 
    mh.LocationID = ? 
ORDER BY 
    mh.StartDate DESC;
";

    $stmt = $db->prepare($sql);
    $stmt->bind_param("i", $locationID);
    $stmt->execute();
    $result = $stmt->get_result();

    $machines = array();

    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            // Fetch prizes for each machine
            $sql_prizes = "SELECT * FROM Prizes WHERE MachineID = ?";
            $stmt_prizes = $db->prepare($sql_prizes);
            $stmt_prizes->bind_param("i", $row['MachineID']);
            $stmt_prizes->execute();
            $result_prizes = $stmt_prizes->get_result();

            $prizes = array();
            while($prize_row = $result_prizes->fetch_assoc()) {
                array_push($prizes, $prize_row);
            }
            $row['Prizes'] = $prizes; // Add prizes to machine array

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
