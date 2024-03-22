fetch('session_info.php')
    .then(response => response.json())
    .then(data => {
        if (data.status === 'loggedin') {
            // Assigning to global variables
            window.userLoggedIn = true;
            window.userId = data.id;
            window.username = data.username;
            window.userRole = data.role;
            window.userTerritory = data.territory;

            // Now these variables can be accessed globally in any other script
        } else {
            window.userLoggedIn = false;
            // Handle not-logged-in scenario
        }
    })
    .catch(error => console.error('Error:', error));
