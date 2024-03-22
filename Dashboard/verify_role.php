<?php

// Function to check access
function checkAccess($requiredRole, $requiredTerritory = null) {
    if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
        header("Location: login.php");
        exit;
    }
    if ($_SESSION['role'] !== $requiredRole || ($requiredTerritory !== null && $_SESSION['territory'] !== $requiredTerritory)) {
        header("Location: no_access.php");
        exit;
    }
}

// Example usage
// For a page that requires admin access
checkAccess('admin');
//checkAccess('employee');
//checkAccess('manager');
?>
