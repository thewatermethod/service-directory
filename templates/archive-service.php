<?php
	//template for displays all services

	get_header();

	require( plugin_dir_path( __FILE__ ) . '../inc/servicedirectory_json.php');

	require( plugin_dir_path( __FILE__ ) . '../inc/servicedirectory_mapsapikey.php');

	$submitted = $_GET['submitted'];

	if ($submitted === 'true'){
		require( plugin_dir_path( __FILE__ ) . '../templates/form-submit.php');
	}

?>
	<div class="archive-service">

		<div id="map" style="min-height: 400px; min-width: 100%;"></div>

		<div class="row">
			<div class="col-md-12">
				<h1>Find a roof cleaner near you: </h1>
			</div>
		</div>
		<div class="row">
			<div class="col-md-7">
				<fieldset>
					<input type="text" id="search-term" placeholder="Enter your zip code or address here." />
					<select id="distanceFrom">
						<option value="10">within 10 miles</option>
						<option value="25">within 25 miles</option>
						<option value="50">within 50 miles</option>
						<option value="100">within 100 miles</option>
					</select>
					<button id="searchCleaners">Search</button>

				</fieldset>
			</div>
			<div class="col-md-5">
				<ul id="premiumRoofCleaners"></ul>
				<ul id="roofCleanerList"></ul>
			</div>
		</div>

	</div>

	<script>

		var json = <?php echo $json; ?>;
		var map;
		var mapMarkers = [];
		var distances = [];

		var searchButton = document.getElementById("searchCleaners");
		searchButton.addEventListener("click", function(){
			findClosestRoofCleaners();
		});

		var locations = json.locations;

		
		function addMarkers() {
						
			for( var i = 0; i < locations.length; i++) {
				
				var lng = locations[i].longitude;
				var lat = locations[i].latitude;
				var position = new google.maps.LatLng( parseFloat(lat), parseFloat(lng) );
			
				mapMarkers[i] = { 
					"name" : locations[i].name,
					"position" : position,
					"url" : locations[i].url
				};

				
				var marker = new google.maps.Marker({
					position: mapMarkers[i].position,
					map: map,
					title: mapMarkers[i].name,
					url: locations[i].url
				});
				
				marker.addListener( "click", function() {
					window.location.href = this.url;
				});
			}


			
		}		

		function initMap(){
		
			map = new google.maps.Map(document.getElementById('map'), {
    			center:  { lat: 41.697198, lng: -70.10251800000003},
				zoom: 3
			});

			addMarkers();
		}	 

		function findClosestRoofCleaners(){	

			var currentLocation;
			var searchTerm = document.getElementById("search-term").value;
			var gc = new google.maps.Geocoder();

			var distance = parseInt(document.getElementById("distanceFrom").value);

			for( var i = 0; i < distances.length; i++) {
				distances[i] = null;
			}
			
			gc.geocode(
				
				{ "address" : searchTerm },
				function( results, status ){

					if( status === google.maps.GeocoderStatus.OK){

						currentLocation = results[0].geometry.location;
						map.panTo( currentLocation );
						
						if (distance === 10){
							map.setZoom(11);
						} else if( distance === 25 ){
							map.setZoom(10);
						} else if (distance === 50 ){
							map.setZoom(9);
						} else {
							map.setZoom(8);
						}


						for( var i = 0; i < mapMarkers.length; i++) {

							distances[i] = {

								"index" : i,
								"distance" : calcDistance( currentLocation, mapMarkers[i].position )

							};

						}

						
						var roofCleanerList = document.getElementById('roofCleanerList');
						roofCleanerList.innerHTML = '';

						for( var i = 0; i < mapMarkers.length; i++ ){

								if (distances[i].distance <= distance){

									var listItem = document.createElement('li');
									var listItemLink = document.createElement('a');

					   				listItemLink.appendChild( document.createTextNode( mapMarkers[i].name ) );
					   				listItemLink.setAttribute( "href", mapMarkers[i].url );


					   				listItem.appendChild(listItemLink);

					   				roofCleanerList.appendChild(listItem);
					   			}
					   	 
						}
					
						
					} else {

						alert("Not a valid location. Please try again.");

					}

				});
		}
		
		var calcDistance = function(p1,p2){
 			var unitInMiles = ((google.maps.geometry.spherical.computeDistanceBetween(p1, p2) / 1000) * 0.62137 ).toFixed(2);
 			return unitInMiles;
		};


	</script>

	<script src="https://maps.googleapis.com/maps/api/js?key=<?php echo $apiKey; ?>&libraries=geometry&callback=initMap" async defer></script>

<?php 

	get_footer(); 

?>