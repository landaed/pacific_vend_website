<?php
session_start();

// Function to check access
function checkAccess($requiredRole, $requiredTerritory = null) {
    if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
        header("Location: login.html");
        exit;
    }
    if ($_SESSION['role'] !== $requiredRole || ($requiredTerritory !== null && $_SESSION['territory'] !== $requiredTerritory)) {
        header("Location: no_access.html");
        exit;
    }
}

// Example usage
// For a page that requires admin access
checkAccess('admin');

// For a page that requires employee access in the Vancouver territory
//checkAccess('employee', 'Vancouver');
?>
