window.onload = function() {
fetch('machines-edit-modal.html')
  .then(response => response.text())
  .then(html => {
    document.getElementById('editModalContainer').innerHTML = html;
  });
}
