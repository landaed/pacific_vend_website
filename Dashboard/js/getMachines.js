function fetchmachines(filter) {
        fetch(`get_machines.php`) // Replace with the actual path to your PHP script
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
                });

                // Bind click event to edit buttons after they are added to the DOM
                data.forEach(machine => {
                    const editButton = document.querySelector(`[data-machine-id="${machine.MachineID}"]`);
                    if (editButton) {
                        editButton.addEventListener('click', function(event) {
                            event.preventDefault();
                            const machineId = this.getAttribute('data-machine-id');
                            const selectedMachine = data.find(m => m.MachineID === machineId);
                            if (selectedMachine) {
                                openEditModal(selectedMachine);
                            }
                        });
                    }

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

    // Call the function when the page loads
    window.onload = () => fetchmachines('Edmonton');
    function openEditModal(machine) {
      console.log("machine info: " + machine)
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
