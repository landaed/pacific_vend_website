<?php
// Include database connection file
require_once 'db_connect.php';

// Start the session
session_start();

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve the submitted credentials
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Prepare a select statement to check the username and retrieve account details
    $sql = "SELECT id, username, password FROM Users WHERE username = ?";
    
    if ($stmt = $db->prepare($sql)) {
        // Bind variables to the prepared statement as parameters
        $stmt->bind_param("s", $param_username);

        // Set parameters
        $param_username = $username;

        // Attempt to execute the prepared statement
        if ($stmt->execute()) {
            // Store result
            $stmt->store_result();

            // Check if username exists
            if ($stmt->num_rows == 1) {
                // Bind result variables
                $stmt->bind_result($id, $username, $hashed_password);
                if ($stmt->fetch()) {
                    if (password_verify($password, $hashed_password)) {
                        // Password is correct, so start a new session and save the username and id
                        $_SESSION['loggedin'] = true;
                        $_SESSION['id'] = $id;
                        $_SESSION['username'] = $username;
                        // Now fetch the role and territory for the user
                        $sql = "SELECT role, territory FROM Users WHERE id = ?";
                        $stmt = $db->prepare($sql);
                        $stmt->bind_param("i", $id);
                        if ($stmt->execute()) {
                            $stmt->bind_result($role, $territory);
                            if ($stmt->fetch()) {
                                $_SESSION['role'] = $role;
                                $_SESSION['territory'] = $territory;
                            }
                        }
                        $stmt->close();
                        
                        // Redirect user to welcome page
                        header("Location: index.html?status=loginsuccess");
                    } else {
                        // Display an error message if password is not valid
                        header("Location: login.html?status=loginfailure");
                    }
                }
            } else {
                // Display an error message if username doesn't exist
                header("Location: index.html?status=loginfailure");
            }
        } else {
            echo "Oops! Something went wrong. Please try again later.";
        }

        // Close statement
        $stmt->close();
    }
    // Close connection
    $db->close();
}
?>
