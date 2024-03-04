var locationInput = document.getElementById('locationInput');
var suggestionsBox = document.getElementById('locationSuggestions');
var locationID = document.getElementById('location_id');
if (locationInput) {
    locationInput.addEventListener('input', function() {
        var searchTerm = this.value;
        if (searchTerm.length > 1) {
            fetch(`location_suggestions.php?search=${searchTerm}`)
                .then(response => response.json())
                .then(data => {
                    suggestionsBox.innerHTML = '';
                    data.forEach(location => {
                        var suggestion = document.createElement('div');
                        suggestion.textContent = location.Name + ",  " + location.Address;
                        suggestion.name = location.LocationID;
                        suggestion.classList.add('suggestion');
                        suggestion.addEventListener('click', function() {
                            locationInput.value = this.textContent;
                            suggestionsBox.innerHTML = '';
                            locationID.value = this.name;
                        });
                        suggestionsBox.appendChild(suggestion);
                    });
                })
                .catch(error => {
                    console.error('Error:', error);
                });
        } else {
            suggestionsBox.innerHTML = '';
        }
    });
}
/*
function openAddMachineHistoryModal(machine) {
  setTimeout(function() {
  // Populate the modal fields with the machine data
  document.getElementById('machine_id').value = machine.MachineID;
  document.getElementById('machine_name').textContent = machine.Name;
  // Show the modal
  console.log("opening add history modal");
  $('#machineHistoryModal').modal('hide');
  $('#addMachineHistoryModal').modal('show');
  $('#addMachineHistoryModal').on('shown.bs.modal', function () {
      // Now the modal is fully shown, and its elements should be accessible
      var locationInput = document.getElementById('locationInput');
      var suggestionsBox = document.getElementById('locationSuggestions');
      var locationIDInput = document.getElementById('locationIDInput');
      var machineIDInput = document.getElementById('machineIDInput');

      if (locationIDInput) {
          console.log("found locationIDInput");
      } else {
          console.log("ERROR: LOCATION ID INPUT NOT FOUND");
      }

      // Assuming machine is a global variable or passed somehow to this function
      machineIDInput.value = machine.MachineID;

      if (locationInput) {
          locationInput.addEventListener('input', function() {
              var searchTerm = this.value;
              if (searchTerm.length > 1) {
                  fetch(`location_suggestions.php?search=${searchTerm}`)
                      .then(response => response.json())
                      .then(data => {
                          suggestionsBox.innerHTML = '';
                          data.forEach(location => {
                              var suggestion = document.createElement('div');
                              suggestion.textContent = location.Name;
                              suggestion.classList.add('suggestion');
                              suggestion.addEventListener('click', function() {
                                  locationInput.value = this.textContent;
                                  suggestionsBox.innerHTML = '';
                                  locationIDInput.value = location.LocationID;
                              });
                              suggestionsBox.appendChild(suggestion);
                          });
                      })
                      .catch(error => {
                          console.error('Error:', error);
                      });
              } else {
                  suggestionsBox.innerHTML = '';
              }
          });
      }

  });
}, 500);
}*/
