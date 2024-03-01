window.onload = function() {
fetch('add_machine_history_modal.html')
  .then(response => response.text())
  .then(html => {
    document.getElementById('addMachineHistoryModalContainer').innerHTML = html;
  });
}
