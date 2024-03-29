function initializeMachineTypeSuggestions() {
    var machineTypeInput = document.getElementById('machineTypeInput');
    if (machineTypeInput) {
        machineTypeInput.addEventListener('input', machineTypeInputHandler);
    } else {
        console.log("ERROR: cant find machine type input!");
    }
}

function machineTypeInputHandler() {
    var machineTypeInput = document.getElementById('machineTypeInput');
    var MachineTypeSuggestionBox = document.getElementById('machineTypeSuggestions');
    var machineTypeID = document.getElementById('machine_type_id');

    var searchTerm = machineTypeInput.value;
    if (searchTerm.length > 1) {
        fetch(`machine_type_suggestions.php?search=${searchTerm}`)
            .then(response => response.json())
            .then(data => {
                MachineTypeSuggestionBox.innerHTML = '';
                data.forEach(machineType => {
                    var suggestion = document.createElement('div');
                    suggestion.textContent = machineType.Name;
                    if(machineType.Model){
                        suggestion.textContent += ", " + machineType.Model;
                    }
                    if(machineType.Manufacture){
                        suggestion.textContent += ", " + machineType.Manufacture;
                    }
                    suggestion.name = machineType.MachineTypeID;
                    suggestion.classList.add('suggestion');
                    suggestion.addEventListener('click', function() {
                        machineTypeInput.value = this.textContent;
                        MachineTypeSuggestionBox.innerHTML = '';
                        machineTypeID.value = this.name;
                        console.log("machineTypeID selected is " + machineTypeID.value);
                    });
                    MachineTypeSuggestionBox.appendChild(suggestion);
                });
            })
            .catch(error => {
                console.error('Error:', error);
            });
    } else {
        MachineTypeSuggestionBox.innerHTML = '';
    }
}
