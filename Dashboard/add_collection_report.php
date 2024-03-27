<?php
session_start();
require_once 'verify_session.php';
?>
<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>SB Admin 2 - Login</title>

    <!-- Custom fonts for this template-->
    <link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link
        href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i"
        rel="stylesheet">

    <!-- Custom styles for this template-->
    <link href="css/sb-admin-2.css" rel="stylesheet">

</head>

<body id="page-top">

    <!-- Page Wrapper -->
    <div id="wrapper">
        <script src="get_session_info.js"></script>
        <div id="sidebarContainer"></div>
        <script src="sidebar.js"></script>
        <!-- End of Sidebar -->

        <!-- Content Wrapper -->
        <div id="content-wrapper" class="d-flex flex-column">

            <!-- Main Content -->
            <div id="content">
                    
                    <!-- Topbar -->
                    <div id="topbarContainer"></div>
                    <script src="topbar.js"></script>
                    <!-- Outer Row -->
                    <div class="row justify-content-center">

                        <div class="col-xl-10 col-lg-12 col-md-9">

                            <div class="card o-hidden border-0 shadow-lg my-5">
                                <div class="card-body p-0">
                                    <!-- Nested Row within Card Body -->
                                    <div class="row">

                                        <div class="col-lg-6-center">
                                            <div class="p-5">
                                                <div class="text-center">
                                                    <h1 class="h4 text-gray-900 mb-4">Collections Report</h1>
                                                </div>
                                                <div id="machinesList" class="machines-list-container"></div>

                                                <form class="user" id="collectionReportForm">
                                                    <input type="hidden" id="formLocationId" name="formLocationId">
                                                    <div class="form-group">
                                                        <input type="text" class="form-control form-control-user" id="formLocationInput" placeholder="Current Location (Required)" autocomplete="off" required>
                                                        <div id="formLocationSuggestions" class="suggestions-box"></div>
                                                    </div>
                                                    <div class="form-group">
                                                        <b>Collection Date</b>
                                                        <input type="date" class="form-control form-control-user" id="collection_date" name="collection_date" placeholder="Collection Date">
                                                    </div>
                                                    <input type="submit" class="btn btn-primary btn-user btn-block" value="Submit">
                                                </form>
                                            
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                        </div>

                    </div>
                     <!-- Footer -->
                     <footer class="sticky-footer bg-white">
                        <div class="container my-auto">
                            <div class="copyright text-center my-auto">
                                <span>Copyright &copy; Landa Investments Ltd.</span>
                            </div>
                        </div>
                    </footer>
                    <!-- End of Footer -->
        
                </div>
                <!-- End of Content Wrapper -->
        
            </div>
            <!-- End of Page Wrapper -->

    </div>
    <script>
        function showMachineForm(machineId) {
            // Hide the main collection report form
            document.getElementById('collectionReportForm').style.display = 'none';

            // Show the specific form for the clicked machine
            var formContainer = document.getElementById(`formContainer_${machineId}`);
            formContainer.style.display = 'block';

            // Populate formContainer with the machine-specific form
            // and a save button which, when clicked, will toggle the form and main list visibility
            formContainer.innerHTML = `
            <h3>Collection Form for Machine ${machineId}</h3>
            <form id="machineForm_${machineId}">
                <div class="form-group">
                    <label>Meter #1:</label>
                    <input type="number" class="form-control" name="meter1" required>
                </div>
                <div class="form-group">
                    <label>Meter #2:</label>
                    <input type="number" class="form-control" name="meter2" required>
                </div>
                <div class="form-group">
                    <label>Prize Meter 1:</label>
                    <input type="number" class="form-control" name="prizeMeter1" required>
                </div>
                <div class="form-group">
                    <label>Prize Meter 2:</label>
                    <input type="number" class="form-control" name="prizeMeter2" required>
                </div>
                <div class="form-group">
                    <label>Prize Meter 3:</label>
                    <input type="number" class="form-control" name="prizeMeter3" required>
                </div>
                <!-- Add more input fields for currency types here -->
                <div class="form-group">
                    <label>Quarters:</label>
                    <input type="number" class="form-control" name="quarters">
                </div>
                <!-- Add inputs for Loons, Toons, 5, 10, 20, Tokens, etc. -->
                <!-- ... -->
                <div class="form-group">
                    <label>Credit Card:</label>
                    <input type="number" class="form-control" name="creditCard">
                </div>
                <div class="form-group">
                    <label>MISC:</label>
                    <input type="number" class="form-control" name="misc">
                </div>
                <div class="form-group">
                    <label>Refunds:</label>
                    <input type="number" class="form-control" name="refunds">
                </div>
                <div class="form-group">
                    <label>Deductions (e.g., music fees, online fees):</label>
                    <input type="number" class="form-control" name="deductions">
                </div>
                <button class="btn btn-success" onclick="saveMachineForm(${machineId})">Save</button>
                <button class="btn btn-secondary" onclick="toggleVisibility(${machineId})">Cancel</button>
            </form>
        `;
        }

        function toggleVisibility(machineId) {
            document.getElementById(`formContainer_${machineId}`).style.display = 'none';
            document.getElementById('collectionReportForm').style.display = 'block';
        }

        function saveMachineForm(machineId) {
            // Implement the save logic for the machine-specific form
            // On successful save, update the icon to show completion
           // On successful save, update the icon to show completion
            var statusIcon = document.getElementById(`statusIcon_${machineId}`);
            statusIcon.classList.remove('fa-exclamation-circle');
            statusIcon.classList.add('fa-check-circle');
            statusIcon.style.color = 'green'; // Set the color to green

            // Hide the form and show the main list again
            toggleVisibility(machineId);
        }

    document.getElementById('collectionReportForm').addEventListener('submit', function(event) {
        event.preventDefault();

        var locationId = document.getElementById('formLocationId').value;
        var collectionDate = document.getElementById('collection_date').value;

        fetch('get_machines_for_collections_report.php', {
            method: 'POST',
            body: new URLSearchParams({
                'formLocationId': locationId,
                'collection_date': collectionDate
            }),
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded'
            }
        })
        .then(response => response.json())
        .then(data => {
            var machinesList = document.getElementById('machinesList');
            machinesList.innerHTML = ''; // Clear previous results

            if (data.message) {
                machinesList.innerHTML = data.message; // Display message (no machines, etc.)
            } else {
                data.forEach(function(machine) {
                    var machineDiv = `
                        <div class="card-body py-3 d-flex flex-row align-items-center justify-content-between" id="visible_${machine.MachineID}">
                            <h6 class="m-0 font-weight-bold text-primary">Door #${machine.MachineID} - ${machine.MachineTypeName}</h6>
                            <div>
                                <i class="fas fa-exclamation-circle" id="statusIcon_${machine.MachineID}"></i>
                                <button class="btn btn-primary btn-sm" onclick="showMachineForm(${machine.MachineID})">View/Edit Collection Form</button>
                            </div>
                        </div>
                        <div id="formContainer_${machine.MachineID}" class="machine-form-container" style="display: none;">
                            <!-- Machine specific form goes here -->
                        </div>`;
                    machinesList.innerHTML += machineDiv;
                });
            }
        })
        .catch(error => console.error('Error:', error));
    });
    </script>

    <script src="./js/location_suggestions.js"></script>
    <script>initializeLocationSuggestions("formLocationInput", "formLocationSuggestions", "formLocationId");</script>
    <!-- Bootstrap core JavaScript-->
    <script src="vendor/jquery/jquery.min.js"></script>
    <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

    <!-- Core plugin JavaScript-->
    <script src="vendor/jquery-easing/jquery.easing.min.js"></script>

    <!-- Custom scripts for all pages-->
    <script src="js/sb-admin-2.min.js"></script>




</body>

</html>
