async function initializeSidebar() {
    let sessionData = await fetchSessionInfo();
    if (sessionData && sessionData.status === 'loggedin') {
        let territoryLinks = '';
        if (sessionData.territory === 'Vancouver') {
            territoryLinks = '<a class="collapse-item" href="get_locations_page.php?territory=Vancouver">Vancouver</a>';
        } else if (sessionData.territory === 'Edmonton') {
            territoryLinks = '<a class="collapse-item" href="get_locations_page.php?territory=Edmonton">Edmonton</a>';
        } else if (sessionData.territory === 'Calgary') {
            territoryLinks = '<a class="collapse-item" href="get_locations_page.php?territory=Calgary">Calgary</a>';
        }

        let createAccountLink = '';
        if (sessionData.role === 'admin') {
            createAccountLink = `
                <li class="nav-item">
                    <a class="nav-link" href="add_account.html">
                        <i class="fas fa-fw fa-user-plus"></i>
                        <span>Create Account</span>
                    </a>
                </li>`;
        }

        document.getElementById('sidebarContainer').innerHTML = `<!-- Sidebar -->
        <ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">

            <!-- Sidebar - Brand -->
            <a class="sidebar-brand d-flex align-items-center justify-content-center" href="index.php">
                <div class="sidebar-brand-icon">
                    <i><img src="./img/PVD.png" style="width: 50%;"></img></i>
                </div>
            </a>

            <!-- Divider -->
            <hr class="sidebar-divider my-0">

            <!-- Nav Item - Dashboard -->
            <li class="nav-item active">
                <a class="nav-link" href="index.php">
                    <i class="fas fa-fw fa-tachometer-alt"></i>
                    <span>Dashboard</span></a>
            </li>

            <!-- Divider -->
            <hr class="sidebar-divider">

            <!-- Heading -->
            <div class="sidebar-heading">
                Options
            </div>

            <!-- Nav Item - Pages Collapse Menu -->
            <li class="nav-item">
                <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseTwo"
                    aria-expanded="true" aria-controls="collapseTwo">
                    <i class="fas fa-fw fa-map"></i>
                    <span>Locations</span>
                </a>
                <div id="collapseTwo" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
                    <div class="bg-white py-2 collapse-inner rounded">
                        <h6 class="collapse-header">Territories</h6>
                        ${territoryLinks}
                        <a class="collapse-item" href="add_location.html">New</a>
                    </div>
                </div>
            </li>

            <!-- Nav Item - Utilities Collapse Menu -->
            <li class="nav-item">
                <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseUtilities"
                    aria-expanded="true" aria-controls="collapseUtilities">
                    <i class="fas fa-fw fa-wrench"></i>
                    <span>Machines</span>
                </a>
                <div id="collapseUtilities" class="collapse" aria-labelledby="headingUtilities"
                    data-parent="#accordionSidebar">
                    <div class="bg-white py-2 collapse-inner rounded">
                        <h6 class="collapse-header">Sorting</h6>
                        <a class="collapse-item" href="get_machines_all.html">Placed Machines</a>
                        <a class="collapse-item" href="get_machines_types.html">Machine Types</a>
                        <a class="collapse-item" href="add_machine_type.html">Create Machine Type</a>
                        <a class="collapse-item" href="add_machine.html">Create a Placed Machine</a>
                    </div>
                </div>
            </li>
            ${createAccountLink}

            <!-- Divider -->
            <hr class="sidebar-divider">

            <!-- Heading -->
            <div class="sidebar-heading">
                Analytics (Under Construction)
            </div>

            <!-- Divider -->
            <hr class="sidebar-divider d-none d-md-block">

            <!-- Sidebar Toggler (Sidebar) -->
            <div class="text-center d-none d-md-inline">
                <button class="rounded-circle border-0" id="sidebarToggle"></button>
            </div>


        </ul>
        <!-- End of Sidebar -->
        `;

    }
}

initializeSidebar();

