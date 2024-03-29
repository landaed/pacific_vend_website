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

    <title>SB Admin 2 - Dashboard</title>

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

        <!-- Content Wrapper -->
        <div id="content-wrapper" class="d-flex flex-column">

            <!-- Main Content -->
            <div id="content">
              <div id="topbarContainer"></div>
              <script src="topbar.js"></script>

                <!-- End of Topbar -->

                <!-- Begin Page Content -->
                <div class="container-fluid">

                    <!-- Page Heading -->
                    <div class="d-sm-flex align-items-center justify-content-between mb-4">
                        <h1 class="h3 mb-0 text-gray-800">Dashboard</h1>
                        <a href="#" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm"><i
                                class="fas fa-download fa-sm text-white-50"></i> Generate Report</a>
                    </div>

                    <!-- Content Row -->
                    <div class="row">
                      <div id="editModalContainer"></div>
                      <div id="locationsContainer"></div>

                      <script>
                      function openEditModal(location) {
                        // Populate the modal fields with the location data
                        document.getElementById('originalName').value = location.Name;
                        document.getElementById('originalAddress').value = location.Address;
                        document.getElementById('editInputName').value = location.Name;
                        document.getElementById('editInputAddress').value = location.Address;

                        document.getElementById('editInputCity').value = location.City;
                        document.getElementById('editInputZip').value = location.ZipCode;
                        document.getElementById('editExampleProvince').value = location.Province;
                        document.getElementById('editExampleTerritory').value = location.Territory;
                        document.getElementById('editExampleType').value = location.Type;
                        document.getElementById('editInputEmail').value = location.Email;
                        document.getElementById('editInputPhoneNumber').value = location.PhoneNumber;
                        // ... set values for all fields ...

                        // Show the modal
                        $('#editLocationModal').modal('show');
                      }
                      function fetchLocations(territory) {
                        fetch(`get_location_territory.php?territory=${territory}`) // Replace with the actual path to your PHP script
                              .then(response => response.json())
                              .then(data => {
                                  const locationsContainer = document.getElementById('locationsContainer');
                                  locationsContainer.innerHTML = ''; // Clear existing content

                                  data.forEach(location => {
                                      // Check if 'type' is defined, if not, use a default value like 'unknown'
                                      const locationType = location.Type ? location.Type.toLowerCase() : 'unknown';
                                      const locationDiv = document.createElement('div');
                                      locationDiv.className = `card border-left-${locationType} shadow py-2`;
                                      locationDiv.id = `location_${location.LocationID}`;

                                      const visibleContent = `
                                          <div class="card-body py-3 d-flex flex-row align-items-center justify-content-between" id="visible_${location.LocationID}">
                                              <h6 class="m-0 font-weight-bold text-primary">${location.Name} - ${location.Address} - ${location.City}</h6>
                                              <div class="dropdown no-arrow">
                                                  <a class="dropdown-toggle" href="#" role="button" id="dropdownMenuLink"
                                                     data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                      <i class="fas fa-ellipsis-v fa-sm fa-fw text-gray-400"></i>
                                                  </a>
                                                  <div class="dropdown-menu dropdown-menu-right shadow animated--fade-in"
                                                       aria-labelledby="dropdownMenuLink">
                                                      <div class="dropdown-header">Edit</div>
                                                      <a class="dropdown-item" href="#" data-location-id="${location.LocationID}">Edit</a>
                                                      <a class="dropdown-item" href="#">Delete (not working yet)</a>
                                                      <div class="dropdown-divider"></div>
                                                      <a class="dropdown-item" href="#" g-list-location-id="${location.LocationID}">Games List</a>
                                                  </div>
                                              </div>
                                          </div>
                                      `;



                                      const hiddenContent = `
                                          <div class="card-body d-none" id="hidden_${location.LocationID}">
                                              <p><strong>Postal Code:</strong> ${location.ZipCode}</p>
                                              <p><strong>Province:</strong> ${location.Province}</p>
                                              <p><strong>Email:</strong> ${location.Email}</p>
                                              <p><strong>Phone:</strong> ${location.PhoneNumber}</p>
                                              <p><strong>Territory:</strong> ${location.Territory}</p>

                                          </div>
                                      `;

                                      locationDiv.innerHTML = visibleContent + hiddenContent;
                                      locationsContainer.appendChild(locationDiv);
                                      const editButton = document.querySelector(`[data-location-id="${location.LocationID}"]`);
                                      editButton.onclick= function() { openEditModal(location); };

                                      const gameListButton = document.querySelector(`[g-list-location-id="${location.LocationID}"]`);
                                      var fullName = location.Name +  ", " + location.Address;
                                      console.log("fullName: " + fullName);
                                      console.log("ID: " + location.LocationID);

                                      var url = `get_machines_at_location_page.php?locationID=${encodeURIComponent(location.LocationID)}&Name=${encodeURIComponent(fullName)}`;
                                      gameListButton.addEventListener('click', function() {
                                          // Assuming you have an input for location name

                                          if (location.LocationID) {
                                              // Construct the URL with LocationID and Name as query parameters
                                              var url = `get_machines_at_location_page.php?locationID=${encodeURIComponent(location.LocationID)}&Name=${encodeURIComponent(fullName)}`;
                                              window.location.href = url; // Redirect to the URL
                                          } else {
                                              alert('Please enter a location ID'); // Handle the empty input
                                          }
                                      });
                                      document.getElementById(`visible_${location.LocationID}`).addEventListener('click', function() {
                                        if (!event.target.matches('#dropdownMenuLink, #dropdownMenuLink *')) {
                                            const hiddenDiv = document.getElementById(`hidden_${location.LocationID}`);
                                            hiddenDiv.classList.toggle('d-none');
                                        }
                                          
                                      });
                                  });
                              })
                              .catch(error => {
                                  console.error('Error fetching locations:', error);
                              });
                      }
                    /*  function fetchLocations(territory) {
                          // Encode the territory for use in a URL

                          fetch(`get_location_territory.php?territory=${territory}`) // Replace with the actual path to your PHP script
                                .then(response => response.json())
                                .then(data => {
                                    const locationsContainer = document.getElementById('locationsContainer');
                                    data.forEach(location => {
                                        // Check if 'type' is defined, if not, use a default value like 'unknown'
                                        const locationType = location.Type ? location.Type.toLowerCase() : 'unknown';

                                        const locationDiv = document.createElement('div');
                                        locationDiv.className = `card border-left-${locationType} shadow py-2`;

                                        locationDiv.innerHTML = `
                                            <div class="card-body">
                                                <div class="row no-gutters align-items-center">
                                                    <div class="col-auto1 mr-2">
                                                        <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                                                            Name</div>
                                                        <div class="h5 mb-0 font-weight-bold text-gray-800">${location.Name}</div>
                                                    </div>
                                                    <div class="col-auto1">
                                                        <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                                                            Address</div>
                                                        <div class="h5 mb-0 font-weight-bold text-gray-800">${location.Address}</div>
                                                    </div>
                                                    <div class="col-auto1">
                                                        <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                                                            City</div>
                                                        <div class="h5 mb-0 font-weight-bold text-gray-800">${location.City}</div>
                                                    </div>
                                                    <div class="col-auto1">
                                                        <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                                                            Zip Code</div>
                                                        <div class="h5 mb-0 font-weight-bold text-gray-800">${location.ZipCode}</div>
                                                    </div>
                                                    <div class="col-auto1">
                                                        <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                                                            Province</div>
                                                        <div class="h5 mb-0 font-weight-bold text-gray-800">${location.Province}</div>
                                                    </div>
                                                    <div class="col-auto1">
                                                        <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                                                            Email</div>
                                                        <div class="h5 mb-0 font-weight-bold text-gray-800">${location.Email}</div>
                                                    </div>
                                                    <div class="col-auto1">
                                                        <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                                                            Phone Number</div>
                                                        <div class="h5 mb-0 font-weight-bold text-gray-800">${location.PhoneNumber}</div>
                                                    </div>
                                                    <div class="col-auto1">
                                                        <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                                                            Territory</div>
                                                        <div class="h5 mb-0 font-weight-bold text-gray-800">${location.Territory}</div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="dropdown no-arrow">
                                                <a class="dropdown-toggle" href="#" role="button" id="dropdownMenuLink"
                                                   data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                    <i class="fas fa-ellipsis-v fa-sm fa-fw text-gray-400"></i>
                                                </a>
                                                <div class="dropdown-menu dropdown-menu-right shadow animated--fade-in"
                                                     aria-labelledby="dropdownMenuLink">
                                                    <div class="dropdown-header">Edit</div>
                                                    <a class="dropdown-item" href="#" data-location-id="${location.LocationID}">Edit</a>
                                                    <a class="dropdown-item" href="#">Delete (not working yet)</a>
                                                    <div class="dropdown-divider"></div>
                                                    <a class="dropdown-item" href="#" g-list-location-id="${location.LocationID}">Games List</a>
                                                </div>
                                            </div>
                                        `;
                                        locationsContainer.appendChild(locationDiv);
                                        const editButton = document.querySelector(`[data-location-id="${location.LocationID}"]`);
                                        editButton.onclick= function() { openEditModal(location); };

                                        const gameListButton = document.querySelector(`[g-list-location-id="${location.LocationID}"]`);
                                        gameListButton.onclick= function() { openEditModal(location); };
                                        var fullName = location.Name +  ", " + location.Address;
                                        console.log("fullName: " + fullName);
                                        console.log("ID: " + location.LocationID);

                                        var url = `get_machines_at_location_page.php?locationID=${encodeURIComponent(location.LocationID)}&Name=${encodeURIComponent(fullName)}`;
                                        gameListButton.addEventListener('click', function() {
                                            // Assuming you have an input for location name

                                            if (location.LocationID) {
                                                // Construct the URL with LocationID and Name as query parameters
                                                var url = `get_machines_at_location_page.php?locationID=${encodeURIComponent(location.LocationID)}&Name=${encodeURIComponent(fullName)}`;
                                                window.location.href = url; // Redirect to the URL
                                            } else {
                                                alert('Please enter a location ID'); // Handle the empty input
                                            }
                                        });

                                    });
                                })
                                .catch(error => {
                                    console.error('Error fetching locations:', error);
                                });
                        }*/



                      </script>

                    </div>
                </div>
                <!-- /.container-fluid -->

            </div>
            <!-- End of Main Content -->

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

    <!-- Scroll to Top Button-->
    <a class="scroll-to-top rounded" href="#page-top">
        <i class="fas fa-angle-up"></i>
    </a>

    

    <!-- Bootstrap core JavaScript-->
    <script src="vendor/jquery/jquery.min.js"></script>
    <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

    <!-- Core plugin JavaScript-->
    <script src="vendor/jquery-easing/jquery.easing.min.js"></script>

    <!-- Custom scripts for all pages-->
    <script src="js/sb-admin-2.min.js"></script>

    <!-- Page level plugins -->

    <script>
        async function VerifyRole(paramValue) {
            let sessionData = await fetchSessionInfo();
            if (sessionData && sessionData.status === 'loggedin') {
                if(sessionData.role === 'admin' || sessionData.territory === paramValue) {
                    fetchLocations(paramValue);
                    fetch('edit-modal.html')
                    .then(response => response.text())
                    .then(html => {
                    document.getElementById('editModalContainer').innerHTML = html;
                    });
                } else {
                    alert('You do not have access to this territory, territory: ' + sessionData.territory + ", paramValue: " + paramValue);
                    window.location.href = 'index.php';
                }
            }
        }
        window.onload = function() {
        const params = new URLSearchParams(window.location.search);
        const paramValue = params.get('territory');
        VerifyRole(paramValue);
        };
    </script>

</body>

</html>
