var machineTypeInput = document.getElementById('machineTypeInput');
var suggestionsBox = document.getElementById('machineTypeSuggestions');
var machineTypeID = document.getElementById('machine_type_id');
console.log("loaded machine suggestions");
if (machineTypeInput) {
    machineTypeInput.addEventListener('input', function() {
        console.log("recieved input!");
        var searchTerm = this.value;
        if (searchTerm.length > 1) {
            fetch(`machine_type_suggestions.php?search=${searchTerm}`)
                .then(response => response.json())
                .then(data => {
                    suggestionsBox.innerHTML = '';
                    data.forEach(machineType => {
                        var suggestion = document.createElement('div');
                        suggestion.textContent = machineType.Name + ",  " + machineType.Model + ",  " + machineType.Manufacture;
                        suggestion.name = machineType.MachineTypeID;
                        suggestion.classList.add('suggestion');
                        suggestion.addEventListener('click', function() {
                            machineTypeInput.value = this.textContent;
                            suggestionsBox.innerHTML = '';
                            machineTypeID.value = this.name;
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
else{
  console.log("ERROR: cant find machine type input!");
}
