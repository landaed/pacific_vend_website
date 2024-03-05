
function fetchmachines(locationID) {
    // Append the locationID as a query parameter
    const url = `get_machines_at_location.php?locationID=${locationID}`;
        fetch(url)
            .then(response => response.json())
            .then(data => {
                const machinesContainer = document.getElementById('machinesContainer');
                data.forEach(machine => {
                    // ... existing code to create machineDiv ...
                    // Check if 'type' is defined, if not, use a default value like 'unknown'
                    const machineGenre = machine.Genre ? machine.Genre.toLowerCase() : 'unknown';

                    const machineDiv = document.createElement('div');
                    machineDiv.className = `card border-left-${machineGenre} shadow py-2`;

                    machineDiv.innerHTML = `
                    <div class="card-body">
                        <div class="row no-gutters align-items-center">
                            <div class="col-auto1 mr-2">
                                <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                                    Door #</div>
                                <div class="h5 mb-0 font-weight-bold text-gray-800">${machine.MachineID}</div>
                            </div>
                            <div class="col-auto1">
                                <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                                    LegacyID</div>
                                <div class="h5 mb-0 font-weight-bold text-gray-800">${machine.LegacyID}</div>
                            </div>
                            <div class="col-auto1">
                                <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                                    CID #</div>
                                <div class="h5 mb-0 font-weight-bold text-gray-800">${machine.CIDNumber}</div>
                            </div>
                            <div class="col-auto1">
                                <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                                    Serial #</div>
                                <div class="h5 mb-0 font-weight-bold text-gray-800">${machine.SerialNumber}</div>
                            </div>
                            <div class="col-auto1">
                                <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                                    Name</div>
                                <div class="h5 mb-0 font-weight-bold text-gray-800">${machine.Name}</div>
                            </div>
                            <div class="col-auto1">
                                <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                                    Genre</div>
                                <div class="h5 mb-0 font-weight-bold text-gray-800">${machine.Genre}</div>
                            </div>
                            <div class="col-auto1">
                                <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                                    Description</div>
                                <div class="h5 mb-0 font-weight-bold text-gray-800">${machine.Description}</div>
                            </div>
                            <div class="col-auto1">
                                <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                                    Dimensions</div>
                                <div class="h5 mb-0 font-weight-bold text-gray-800">${machine.Dimensions}</div>
                            </div>
                            <div class="col-auto1">
                                <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                                    Supplier</div>
                                <div class="h5 mb-0 font-weight-bold text-gray-800">${machine.Supplier}</div>
                            </div>
                            <div class="col-auto1">
                                <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                                    PurchaseDate</div>
                                <div class="h5 mb-0 font-weight-bold text-gray-800">${machine.PurchaseDate}</div>
                            </div>

                            <div class="col-auto1">
                                <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                                    PurchasePrice</div>
                                <div class="h5 mb-0 font-weight-bold text-gray-800">${machine.PurchasePrice}</div>
                            </div>

                            <div class="col-auto1">
                                <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                                    SaleDate</div>
                                <div class="h5 mb-0 font-weight-bold text-gray-800">${machine.SaleDate}</div>
                            </div>
                            <div class="col-auto1">
                                <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                                    SalePrice</div>
                                <div class="h5 mb-0 font-weight-bold text-gray-800">${machine.SalePrice}</div>
                            </div>
                            <div class="col-auto1">
                                <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                                    Sold To</div>
                                <div class="h5 mb-0 font-weight-bold text-gray-800">${machine.SoldTo}</div>
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
                            <div class="dropdown-header">Edit or Remove:</div>
                            <a class="dropdown-item" href="#" data-machine-id="${machine.MachineID}">Edit</a>
                            <a class="dropdown-item" href="#" location-machine-id="${machine.MachineID}">Set/Change Location</a>
                            <div class="dropdown-divider"></div>
                            <a class="dropdown-item" href="#">Create Maintenance Report</a>
                        </div>
                    </div>
                    `;
                    machinesContainer.appendChild(machineDiv);
                    const editButton = document.querySelector(`[data-machine-id="${machine.MachineID}"]`);
                    editButton.onclick= function() { openEditModal(machine); };

                });

                // Bind click event to edit buttons after they are added to the DOM
                data.forEach(machine => {


                    const machineHistoryButton = document.querySelector(`[location-machine-id="${machine.MachineID}"]`);
                    if (machineHistoryButton) {
                        machineHistoryButton.addEventListener('click', function(event) {
                            event.preventDefault();
                            const machineId = this.getAttribute('location-machine-id');
                            const selectedMachine = data.find(m => m.MachineID === machineId);
                            if (selectedMachine) {
                                openMachineHistoryModal(selectedMachine);
                                fetchCurrLocation(selectedMachine);
                            }
                        });
                    }


                });
            })
            .catch(error => {
                console.error('Error fetching machines:', error);
            });
    }

    function openEditModal(machine) {
      console.log("openingEdit Modal");
      // Populate the modal fields with the machine data
      document.getElementById('machine_id').value = machine.MachineID;
      document.getElementById('legacy_id').value = machine.LegacyID;
      document.getElementById('cid_number').value = machine.CIDNumber;
      document.getElementById('serial_number').value = machine.SerialNumber;

      document.getElementById('name').value = machine.Name;
      document.getElementById('genre').value = machine.Genre;
      document.getElementById('description').value = machine.Description;
      document.getElementById('dimensions').value = machine.Dimensions;
      document.getElementById('supplier').value = machine.Supplier;
      document.getElementById('purchase_price').value = machine.PurchasePrice;
      document.getElementById('purchase_date').value = machine.PurchaseDate;
      document.getElementById('sale_price').value = machine.SalePrice;
      document.getElementById('sale_date').value = machine.SaleDate;
      document.getElementById('sold_to').value = machine.SoldTo;
      // Show the modal
      $('#editMachineModal').modal('show');
    }

    function openMachineHistoryModal(machine) {
      // Populate the modal fields with the machine data
      document.getElementById('machine_id').value = machine.MachineID;
      document.getElementById('machine_name').textContent = machine.Name;
      // Show the modal
      $('#machineHistoryModal').modal('show');
      const addMachineHistoryButton = document.querySelector(`[id="add-machine-history-btn"]`);
      if (addMachineHistoryButton) {
          console.log("adding click listener for update location btn")
          addMachineHistoryButton.addEventListener('click', function(event) {
              event.preventDefault();
              const machineId = this.getAttribute('add-machine-history-id');
              openAddMachineHistoryModal(machine);
          });
      }
      else{
        console.log("ERROR: could not find the button");
      }

    }


    function fetchCurrLocation(machine) {
    document.getElementById('machine_id').value = machine.MachineID;
    console.log("fetching current location");
    fetch(`get_curr_location.php`, {
      method: 'POST',
      headers: {
          'Content-Type': 'application/x-www-form-urlencoded',
      },
      body: 'machine_id=' + machine.MachineID
    }) // Adjust this to your PHP endpoint
        .then(response => response.json())
        .then(data => {
            console.log("Response data:", data); // Debugging: log the response

            // Ensure data is in array format
            if (!Array.isArray(data)) {
                data = [data]; // Convert to an array if it's not
            }

            const locationContainer = document.getElementById('location_container');
            locationContainer.innerHTML = '';
            data.forEach(location => {
                console.log("got a location!");
                // Existing code to create locationDiv
                const locationDiv = document.createElement('div');
                locationDiv.innerHTML = `
                <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                    Current Location</div>
                <div class="h5 mb-0 font-weight-bold text-gray-800">${location.LocationName}, ${location.LocationAddress}</div>
                `;
                locationContainer.appendChild(locationDiv);
            });
        })
        .catch(error => {
            console.error('Error:', error);
        });
    }


    function fetchMachineHistory(machineId) {
      fetch('get_machine_history.php', {
          method: 'POST',
          headers: {
              'Content-Type': 'application/x-www-form-urlencoded',
          },
          body: 'machine_id=' + machineId
      })
      .then(response => response.json())
      .then(data => {
          // Handle the machine history data
          // For example, update the DOM to show the machine's history
          const historyContainer = document.getElementById('history_container');
          historyContainer.innerHTML = ''; // Clear previous content
          data.forEach(historyEntry => {
              const entryDiv = document.createElement('div');
              entryDiv.innerHTML = `
              <div>Location: ${historyEntry.locationName}</div>
              <div>Start Date: ${historyEntry.startDate}</div>
              <div>End Date: ${historyEntry.endDate || 'Present'}</div>
              `;
              historyContainer.appendChild(entryDiv);
          });
      })
      .catch(error => {
          console.error('Error:', error);
      });
    }

// open modals
    window.onload = function() {
    fetch('machines-edit-modal.html')
      .then(response => response.text())
      .then(html => {
        document.getElementById('editModalContainer').innerHTML = html;
      });

    fetch('machine_history_modal.html')
      .then(response => response.text())
      .then(html => {
        document.getElementById('machineHistoryModalContainer').innerHTML = html;
      });

    fetch('add_machine_history_modal.html')
      .then(response => response.text())
      .then(html => {
        document.getElementById('addMachineHistoryModalContainer').innerHTML = html;
      });

      fetchmachines('5');
    }
