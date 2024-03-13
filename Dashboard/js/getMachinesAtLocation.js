
function fetchmachines(locationID) {
    const url = `get_machines_at_location.php?locationID=${locationID}`;
    fetch(url)
        .then(response => response.json())
        .then(data => {
            const machinesContainer = document.getElementById('machinesContainer');
            machinesContainer.innerHTML = ''; // Clear existing content

            data.forEach(machine => {
                const machineGenre = machine.Genre ? machine.Genre.toLowerCase() : 'unknown';
                const machineDiv = document.createElement('div');
                machineDiv.className = `card border-left-${machineGenre} shadow mb-4`;
                machineDiv.id = `machine_${machine.MachineID}`;

                const visibleContent = `
                    <div class="card-body py-3 d-flex flex-row align-items-center justify-content-between" id="visible_${machine.MachineID}">
                        <h6 class="m-0 font-weight-bold text-primary">Door #${machine.MachineID} - ${machine.MachineTypeName}</h6>

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
                    </div>
                `;



                let hiddenContent = `
                    <div class="card-body d-none" id="hidden_${machine.MachineID}">
                        <p><strong>Model:</strong> ${machine.MachineTypeModel}</p>
                        <p><strong>Genre:</strong> ${machine.MachineTypeGenre}</p>
                        <p><strong>Dimensions:</strong> ${machine.MachineTypeDimensions}</p>
                        <p><strong>Manufacture:</strong> ${machine.MachineTypeManufacture}</p>

                        <p><strong>Legacy ID:</strong> ${machine.LegacyID}</p>
                        <p><strong>CID Number:</strong> ${machine.CIDNumber}</p>
                        <p><strong>Serial Number:</strong> ${machine.SerialNumber}</p>
                        <p><strong>Description:</strong> ${machine.Description}</p>
                        <p><strong>Supplier:</strong> ${machine.Supplier}</p>
                        <p><strong>Purchase Date:</strong> ${machine.PurchaseDate}</p>
                        <p><strong>Purchase Price:</strong> ${machine.PurchasePrice}</p>
                        <p><strong>Sale Date:</strong> ${machine.SaleDate}</p>
                        <p><strong>Sale Price:</strong> ${machine.SalePrice}</p>
                        <p><strong>Sold To:</strong> ${machine.SoldTo}</p>
                        <div><strong>Prizes:</strong></div>
                        <ul>
                `;
                if (machine.Prizes && machine.Prizes.length > 0) {
                    machine.Prizes.forEach(prize => {
                        hiddenContent += `<li>${prize.Name} (Tier: ${prize.Tier}, Capacity: ${prize.Capacity}, Current: ${prize.CurrentAmount})</li>`;
                    });
                } else {
                    hiddenContent += '<li>No prizes associated</li>';
                }

                hiddenContent += `</ul></div>`;

                machineDiv.innerHTML = visibleContent + hiddenContent;
                machinesContainer.appendChild(machineDiv);
                const editButton = document.querySelector(`[data-machine-id="${machine.MachineID}"]`);
                editButton.onclick= function() { openEditModal(machine); };

                const machineHistoryButton = document.querySelector(`[location-machine-id="${machine.MachineID}"]`);
                machineHistoryButton.onclick= function() { openMachineHistoryModal(machine); };

                document.getElementById(`visible_${machine.MachineID}`).addEventListener('click', function() {
                    if (!event.target.matches('#dropdownMenuLink, #dropdownMenuLink *')) {
                      const hiddenDiv = document.getElementById(`hidden_${machine.MachineID}`);
                      hiddenDiv.classList.toggle('d-none');
                    }
                });
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
      if(machine.MachineID){
        console.log("machin id is " + machine.MachineID);
      }
      else{
        console.log("ERROR: no machine id found!!!1");
      }
      document.getElementById('legacy_id').value = machine.LegacyID;
      document.getElementById('cid_number').value = machine.CIDNumber;
      document.getElementById('serial_number').value = machine.SerialNumber;

      document.getElementById('machineTypeInput').value = machine.MachineTypeName;

      document.getElementById('description').value = machine.Description;

      document.getElementById('supplier').value = machine.Supplier;
      document.getElementById('purchase_price').value = machine.PurchasePrice;
      document.getElementById('purchase_date').value = machine.PurchaseDate;
      document.getElementById('sale_price').value = machine.SalePrice;
      document.getElementById('sale_date').value = machine.SaleDate;
      document.getElementById('sold_to').value = machine.SoldTo;
      // Show the modal
      $('#editMachineModal').modal('show');

      $('#editMachineModal').on('shown.bs.modal', function() {
        initializeMachineTypeSuggestions();
      });
    }

    function openMachineHistoryModal(machine) {
      // Populate the modal fields with the machine data
      document.getElementById('machine_id').value = machine.MachineID;
      document.getElementById('machine_name').textContent = machine.Name;
      // Show the modal
      $('#machineHistoryModal').modal('show');
      fetchCurrLocation(machine);
      const addMachineHistoryButton = document.querySelector(`[id="add-machine-history-btn"]`);
      if (addMachineHistoryButton) {
          console.log("adding click listener for update location btn")
          addMachineHistoryButton.addEventListener('click', function(event) {
              event.preventDefault();
              const machineId = this.getAttribute('add-machine-history-id');
              // open add history modal
              $('#machineHistoryModal').modal('hide');

              var locationInput = document.getElementById('locationInput');
              var suggestionsBox = document.getElementById('locationSuggestions');
              locationInput.id = "notInput";
              suggestionsBox.id = "notSuggestions";
              $('#addMachineHistoryModal').modal('show');

              $('#addMachineHistoryModal').on('shown.bs.modal', function() {
                console.log("add machine history modal has loaded");
                initializeLocationSuggestions();
                document.getElementById('machineIDInput').value = machine.MachineID;
                
              });


              $('#addMachineHistoryModal').on('hidden.bs.modal', function() {
                  console.log("Add machine history modal has closed");
                  locationInput.id = "locationInput";
                  suggestionsBox.id = "locationSuggestions";

              });
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
      const params = new URLSearchParams(window.location.search);
      const paramValue = params.get('locationID');
      const locName = params.get('Name');
      const locationNameDiv = document.getElementById('location_name');
      if(locationNameDiv){
        locationNameDiv.innerHTML=`<h1>${locName}</h1>`;
        console.log("loc name: " + locName);
      }
      else{
        console.log("ERROR: no location nam div found");
      }


      fetchmachines(paramValue);

    }
