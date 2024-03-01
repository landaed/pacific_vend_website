window.onload = function() {
fetch('machine_history_modal.html')
  .then(response => response.text())
  .then(html => {
    document.getElementById('machineHistoryModalContainer').innerHTML = html;
  });
}
