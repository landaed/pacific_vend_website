<?php
session_start();
header('Content-Type: application/json');

// Check if the user is logged in
if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] === true) {
    // Return relevant session data
    echo json_encode([
        'status' => 'loggedin',
        'id' => $_SESSION['id'],
        'username' => $_SESSION['username'],
        'role' => $_SESSION['role'],
        'territory' => $_SESSION['territory']
    ]);
} else {
    header("Location: login.php");
    exit;
}
?>
