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
                                                    <h1 class="h4 text-gray-900 mb-4">Add a Placed Machine</h1>
                                                </div>
                                                <form class="user" action="add_machine.php" method="post">
                                                    <input type="hidden" id="location_id" name="location_id">
                                                    <div class="form-group">
                                                        <input type="text" class="form-control form-control-user" id="locationInput_1" placeholder="Current Location (Required)" autocomplete="off" required>
                                                        <div id="locationSuggestions" class="suggestions-box"></div>
                                                    </div>
                                                    <div class="form-group">
                                                        <b>Start Date</b>
                                                        <input type="date" class="form-control form-control-user" id="start_date" name="start_date" placeholder="Start Date">
                                                    </div>
                                                    <input type="submit" class="btn btn-primary btn-user btn-block" value="Submit">
                                                </form>
                                                <script>

                                                document.getElementById('addPrizeButton').addEventListener('click', function() {
                                                    const prizeContainer = document.getElementById('prizesContainer');
                                                    const prizeNumber = prizeContainer.children.length + 1;

                                                    const prizeDiv = document.createElement('div');
                                                    prizeDiv.innerHTML = `
                                                        <div class="form-group">
                                                            <input type="text" class="form-control" name="prize_name_${prizeNumber}" placeholder="Prize Name">
                                                        </div>
                                                        <div class="form-group">
                                                            <select class="form-control" name="prize_tier_${prizeNumber}">
                                                                <option value="">Tier (0-8)</option>
                                                                <option value="0">0</option>
                                                                <option value="1">1</option>
                                                                <option value="2">2</option>
                                                                <option value="3">3</option>
                                                                <option value="4">4</option>
                                                                <option value="5">5</option>
                                                                <option value="6">6</option>
                                                                <option value="7">7</option>
                                                                <option value="8">8</option>
                                                            </select>
                                                        </div>
                                                        <div class="form-group">
                                                            <input type="number" class="form-control" name="prize_capacity_${prizeNumber}" placeholder="Capacity">
                                                        </div>
                                                        <div class="form-group">
                                                            <input type="number" class="form-control" name="prize_current_amount_${prizeNumber}" placeholder="Current Amount">
                                                        </div>
                                                    `;
                                                    prizeContainer.appendChild(prizeDiv);
                                                });
                                            </script>
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

    <script src="./js/location_suggestions.js"></script>
    <script>initializeLocationSuggestions("locationInput_1");</script>
    <!-- Bootstrap core JavaScript-->
    <script src="vendor/jquery/jquery.min.js"></script>
    <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

    <!-- Core plugin JavaScript-->
    <script src="vendor/jquery-easing/jquery.easing.min.js"></script>

    <!-- Custom scripts for all pages-->
    <script src="js/sb-admin-2.min.js"></script>




</body>

</html>
