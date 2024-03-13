function initializeLocationSuggestions() {
    var locationInput = document.getElementById('locationInput');
    if (locationInput) {
        console.log("Got location input");
        locationInput.addEventListener('input', locationInputHandler);
    } else {
        console.log("ERROR: cant find machine type input!");
    }
}
function locationInputHandler() {
    console.log("inside input handler for location suggestions");
    var locationInput = document.getElementById('locationInput');
    var suggestionsBox = document.getElementById('locationSuggestions');
    var locationID = document.getElementById('location_id');

    if(!suggestionsBox){
      console.log("Error: no suggestionsBox found");
    }
    if(!locationID){
      console.log("Error: no location id found");
    }

    var searchTerm = locationInput.value;
    if (searchTerm.length > 1) {
        console.log("search term > 1")
        fetch(`location_suggestions.php?search=${searchTerm}`)
            .then(response => response.json())
            .then(data => {
                suggestionsBox.innerHTML = '';
                data.forEach(location => {
                    console.log("listing location");
                    var suggestion = document.createElement('div');
                    suggestion.textContent = location.Name;
                    if(location.Model){
                        suggestion.textContent += ", " + location.Address;
                    }
                    if(location.Manufacture){
                        suggestion.textContent += ", " + location.Province;
                    }
                    suggestion.name = location.LocationID;
                    suggestion.classList.add('suggestion');
                    suggestion.addEventListener('click', function() {
                        locationInput.value = this.textContent;
                        suggestionsBox.innerHTML = '';
                        locationID.value = this.name;
                        if(document.getElementById('locationIDInput')){
                          console.log("setting location INPUT id");
                          document.getElementById('locationIDInput').value = locationID.value;
                        }
                        console.log("locationID selected is " + locationID.value);
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
}
