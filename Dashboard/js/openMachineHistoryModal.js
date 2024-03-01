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
