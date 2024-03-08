var locationInput = document.getElementById('locationInput');
var suggestionsBox = document.getElementById('locationSuggestions');
if(suggestionsBox){
  console.log("successfully got location suggestion box, "+ suggestionsBox.id);
}
var locationID = document.getElementById('location_id');
console.log("loaded location suggestions");
if (locationInput) {
    locationInput.addEventListener('input', function() {
        console.log("recieved input!");
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
else{
  console.log("ERROR: cant find location input!");
}
