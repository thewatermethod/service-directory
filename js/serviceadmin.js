
var placeSearch, autocomplete;
var componentForm = {
	locality: 'long_name',
	administrative_area_level_1: 'short_name',
	postal_code: 'short_name'
};

function initAutocomplete() {
    // Create the autocomplete object, restricting the search to geographical
    // location types.
    autocomplete = new google.maps.places.Autocomplete(
      /** @type {!HTMLInputElement} */(document.getElementById('autocomplete')),
      {types: ['geocode']});

    // When the user selects an address from the dropdown, populate the address
    // fields in the form.
	autocomplete.addListener('place_changed', fillInAddress);
}

function fillInAddress() {
	// Get the place details from the autocomplete object.
	var place = autocomplete.getPlace();

	var locality = document.getElementById("locality");
	var serviceState = document.getElementById("serviceState");
	var postal_code = document.getElementById("postal_code");
	var serviceAddress = document.getElementById('serviceAddress');
	var place_location = document.getElementById("place_location");

	locality.value = '';
	locality.disabled = false;
	locality.value = place.address_components[3]["long_name"];

	serviceState.value = '';
	serviceState.disabled = false;
	serviceState.value = place.address_components[5]["short_name"];
	
	postal_code.value = '';
	postal_code.disabled = false;
	postal_code.value = place.address_components[7]["long_name"];

	serviceAddress.value= '';
	serviceAddress.disabled = '';
	serviceAddress.value =  place.address_components[0]['short_name'] + ' ' + place.address_components[1]['short_name'];

	place_location.value = '';
	place_location.disabled = false;
	place_location.value = place.geometry.location;
	
}

// Bias the autocomplete object to the user's geographical location,
// as supplied by the browser's 'navigator.geolocation' object.
function geolocate() {
	if (!autocomplete){

		initAutocomplete();
				
	  if (navigator.geolocation) {
		    navigator.geolocation.getCurrentPosition(function(position) {
		      var geolocation = {
		        lat: position.coords.latitude,
		        lng: position.coords.longitude
		      };
		      var circle = new google.maps.Circle({
		        center: geolocation,
		        radius: position.coords.accuracy
		      });
		      autocomplete.setBounds(circle.getBounds());
		    });
	    }
	}
}
