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
                        suggestion.textContent = location.Name;
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
