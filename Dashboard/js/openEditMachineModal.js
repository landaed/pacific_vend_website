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
