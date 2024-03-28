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

        var machineFormData = {};
        var machineDetails = {};
        function addNewSplit(machineId) {
            var form = document.getElementById(`machineForm_${machineId}`);
            var newIndex = form.querySelectorAll('.split-group').length;
            var newSplitHtml = `
                <div class="form-group split-group" data-index="${newIndex}">
                    <label>Payee (Location Name):</label>
                    <input type="text" class="form-control" name="splitName_${newIndex}">
                    <label>Split Percentage:</label>
                    <input type="number" class="form-control" name="splitPercentage_${newIndex}">
                </div>
            `;
            // Append new split HTML before the Add New Split button
            var addButton = form.querySelector('button[type="button"]');
            addButton.insertAdjacentHTML('beforebegin', newSplitHtml);
        }


        function calculateRevenue(formData) {
            // Positive values
            const positives = ['meter1', 'meter2', 'quarters', 'loons', 'toons', 'fives', 'ten', 'twenty', 'creditCard', 'misc'];
            let positiveSum = positives.reduce((sum, key) => sum + (parseFloat(formData[key]) || 0), 0);

            // Negative values
            const negatives = ['refunds', 'deductions'];
            let negativeSum = negatives.reduce((sum, key) => sum - (parseFloat(formData[key]) || 0), 0); // Subtracting negative values

            console.log("positiveSum: " + positiveSum);
            console.log("negativeSum: " + negativeSum); // This will be a negative number or zero
            return positiveSum + negativeSum; // Adding the negative sum (which is a negative number or zero)
        }


        function showMachineForm(machineId) {
            // Hide the main collection report form
            //document.getElementById('collectionReportForm').style.display = 'none';

            // Show the specific form for the clicked machine
            var formContainer = document.getElementById(`formContainer_${machineId}`);
            formContainer.style.display = 'block';

            var formData = machineFormData[machineId] || {};
            let machineRevenue = calculateRevenue(formData);

            // Retrieve split information for the machine
            var splits = machineDetails[machineId].Splits || [];
            
            // Create HTML for each split
            var splitsHtml = splits.map((split, index) => `
                <div class="form-group split-group" data-index="${index}">
                    <label>Payee (Location Name):</label>
                    <input type="text" class="form-control" name="splitName_${index}" value="${split.LocationName || ''}">
                    <label>Split Percentage:</label>
                    <input type="number" class="form-control" name="splitPercentage_${index}" value="${split.SplitPercentage || ''}">
                </div>
            `).join('');

            // Add button for adding a new split
            splitsHtml += `
                <div class="form-group">
                    <button class="btn btn-secondary" type="button" onclick="addNewSplit(${machineId})">Add New Split</button>
                </div>
            `;

            // Populate formContainer with the machine-specific form and pre-fill with saved data
            formContainer.innerHTML = `
            <h3>Collection Form for Machine ${machineId}</h3>
            <form id="machineForm_${machineId}">
                ${splitsHtml}
                <div class="form-group">
                    <label>Meter #1:</label>
                    <input type="number" class="form-control" name="meter1" value="${formData.meter1 || ''}">
                </div>
                <div class="form-group">
                    <label>Meter #2:</label>
                    <input type="number" class="form-control" name="meter2" value="${formData.meter2 || ''}">
                </div>
                <div class="form-group">
                    <label>Prize Meter 1:</label>
                    <input type="number" class="form-control" name="prizeMeter1" value="${formData.prizeMeter1 || ''}">
                </div>
                <div class="form-group">
                    <label>Prize Meter 2:</label>
                    <input type="number" class="form-control" name="prizeMeter2" value="${formData.prizeMeter2 || ''}">
                </div>
                <div class="form-group">
                    <label>Prize Meter 3:</label>
                    <input type="number" class="form-control" name="prizeMeter3" value="${formData.prizeMeter3 || ''}" >
                </div>
                <!-- Add more input fields for currency types here -->
                <div class="form-group">
                    <label>Quarters:</label>
                    <input type="number" class="form-control" name="quarters" value="${formData.quarters || ''}">
                </div>
                <div class="form-group">
                    <label>Loons:</label>
                    <input type="number" class="form-control" name="loons" value="${formData.loons || ''}">
                </div>
                <div class="form-group">
                    <label>Toons:</label>
                    <input type="number" class="form-control" name="toons" value="${formData.toons || ''}">
                </div>
                <div class="form-group">
                    <label>5:</label>
                    <input type="number" class="form-control" name="fives" value="${formData.fives || ''}">
                </div>
                <div class="form-group">
                    <label>10:</label>
                    <input type="number" class="form-control" name="ten" value="${formData.ten || ''}">
                </div>
                <div class="form-group">
                    <label>20:</label>
                    <input type="number" class="form-control" name="twenty" value="${formData.twenty || ''}">
                </div>
                <!-- Add inputs for Loons, Toons, 5, 10, 20, Tokens, etc. -->
                <!-- ... -->
                <div class="form-group">
                    <label>Credit Card:</label>
                    <input type="number" class="form-control" name="creditCard" value="${formData.creditCard || ''}">
                </div>
                <div class="form-group">
                    <label>MISC:</label>
                    <input type="number" class="form-control" name="misc" value="${formData.misc || ''}">
                </div>
                <div class="form-group">
                    <label>Refunds:</label>
                    <input type="number" class="form-control" name="refunds" value="${formData.refunds || ''}">
                </div>
                <div class="form-group">
                    <label>Deductions (e.g., music fees, online fees):</label>
                    <input type="number" class="form-control" name="deductions" value="${formData.deductions || ''}">
                </div>
                <button class="btn btn-success" onclick="saveMachineForm(${machineId}, event)">Save</button>
                <button class="btn btn-secondary" onclick="toggleVisibility(${machineId}, event)">Cancel</button>

            </form>
        `;
        }

        function toggleVisibility(machineId, event) {
            event.preventDefault();
            document.getElementById(`formContainer_${machineId}`).style.display = 'none';
           // document.getElementById('collectionReportForm').style.display = 'block';
        }

        function saveMachineForm(machineId, event) {
            event.preventDefault();

            
            var form = document.getElementById(`machineForm_${machineId}`);
            var formData = new FormData(form);

            machineFormData[machineId] = {};
            formData.forEach((value, key) => {
                machineFormData[machineId][key] = value;
            });

            let updatedFormData = machineFormData[machineId];

            var totalPercentage = 0;
            form.querySelectorAll('.split-group').forEach(group => {
                totalPercentage += parseFloat(group.querySelector('[name^="splitPercentage_"]').value || 0);
            });

            if (totalPercentage > 100) {
                alert('Total split percentage exceeds 100%. Please adjust the percentages.');
                return;
            }
            let machineRevenue = calculateRevenue(updatedFormData);

            let machineTypeName = machineDetails[machineId].MachineTypeName;

            document.querySelector(`#visible_${machineId} .text-primary`).textContent =
                `Door #${machineId} - ${machineTypeName} - Revenue: $${machineRevenue.toFixed(2)}`;

            // Implement the save logic for the machine-specific form
            // On successful save, update the icon to show completion
           // On successful save, update the icon to show completion
            var statusIcon = document.getElementById(`statusIcon_${machineId}`);
            statusIcon.classList.remove('fa-exclamation-circle');
            statusIcon.classList.add('fa-check-circle');
            statusIcon.style.color = 'green'; // Set the color to green

            // Hide the form and show the main list again
            toggleVisibility(machineId, event);
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
                    machineDetails[machine.MachineID] = {
                        MachineTypeName: machine.MachineTypeName,
                        Splits: machine.Splits || [] // Store splits array for each machine
                    };
                    let machineRevenue = calculateRevenue(machineFormData[machine.MachineID] || {});
                    var machineDiv = `
                        <div class="card-body py-3 d-flex flex-row align-items-center justify-content-between" id="visible_${machine.MachineID}">
                        <h6 class="m-0 font-weight-bold text-primary">Door #${machine.MachineID} - ${machine.MachineTypeName} - Revenue: $${machineRevenue.toFixed(2)}</h6>
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
