function fetchmachines() {
        fetch(`get_machine_types.php`) // Replace with the actual path to your PHP script
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
                                    Model</div>
                                <div class="h5 mb-0 font-weight-bold text-gray-800">${machine.Model}</div>
                            </div>

                            <div class="col-auto1">
                                <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                                    Dimensions</div>
                                <div class="h5 mb-0 font-weight-bold text-gray-800">${machine.Dimensions}</div>
                            </div>

                            <div class="col-auto1">
                                <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                                    Manufacturer</div>
                                <div class="h5 mb-0 font-weight-bold text-gray-800">${machine.Manufacture}</div>
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
                            <a class="dropdown-item" href="#" data-machine-id="${machine.MachineTypeID}">Edit</a>
                            <a class="dropdown-item" href="#" location-machine-id="${machine.MachineTypeID}">Placement List</a>
                        </div>
                    </div>
                    `;

                    machinesContainer.appendChild(machineDiv);
                });

                // Bind click event to edit buttons after they are added to the DOM
                data.forEach(machine => {
                    const editButton = document.querySelector(`[data-machine-id="${machine.MachineTypeID}"]`);
                    if (editButton) {
                        editButton.addEventListener('click', function(event) {
                            event.preventDefault();
                            const machineId = this.getAttribute('data-machine-id');
                            const selectedMachine = data.find(m => m.MachineTypeID === machineId);
                            console.log("machineid: " + selectedMachine)
                            if (selectedMachine) {
                                openEditModal(selectedMachine);
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
      // Populate the modal fields with the machine data
      document.getElementById('machine_id').value = machine.MachineTypeID;
      document.getElementById('name').value = machine.Name;
      document.getElementById('genre').value = machine.Genre;
      document.getElementById('dimensions').value = machine.Dimensions;
      document.getElementById('manufacture').value = machine.Manufacture;

      // Show the modal
      $('#editMachineModal').modal('show');
    }

// open modals
    window.onload = function() {
    fetch('edit_machine_type_modal.html')
      .then(response => response.text())
      .then(html => {
        document.getElementById('editModalContainer').innerHTML = html;
      });


      fetchmachines();
    }
