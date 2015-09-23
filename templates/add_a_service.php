<?php
	//template for add a service page
	get_header();

?>

	<div id="primary" class="content-area">
		<main id="main" class="site-main" role="main">

			<article>
			<header class="entry-header">
				<h1>Add Your Service to Our Directory</h1>
				</header><!-- .entry-header -->

			<div class="entry-content">
				<p>To become a premium member of our directory, where you will appear first and highlighted in search results, please <a href="http://www.roofcleaners.org/membership-application/" alt="Premium Membership Sign Up for <?php echo get_bloginfo('title');?>">sign up for a premium membership</a>.</p>

				<div class="service-form-wrapper">

					<form enctype="multipart/form-data" encoding="multipart/form-data" action="" id="addServiceForm" name="addServiceForm" method="POST">
					 
					    <fieldset id="locationField">
					    	<label for="locationField">Find your address with our quick search:  </label>
      						<input id="autocomplete" autocomplete="false" placeholder="Enter your address" onFocus="geolocate()" type="text"></input>
    					</fieldset>

    					<hr>

    					<div id="addressInformation">
						    <fieldset>
						        <label for="postTitle"><?php _e('Business Name:', 'framework') ?></label>
						        <input type="text" name="postTitle" id="postTitle" class="required" value="<?php if ( isset( $_POST['postTitle'] ) ) echo $_POST['postTitle']; ?>" />
						    </fieldset>

						     <fieldset>
						        <label for="serviceAddress"><?php _e('Address:', 'framework') ?></label>
						        <input type="text" name="serviceAddress" id="serviceAddress" class="required" value="<?php if ( isset( $_POST['serviceAddress'] ) ) echo $_POST['serviceAddress']; ?>" />
						    </fieldset>


						    <fieldset>
						        <label for="serviceCity"><?php _e('City:', 'framework') ?></label>
						        <input type="text" name="serviceCity" id="locality" class="required" value="<?php if ( isset( $_POST['serviceCity'] ) ) echo $_POST['serviceCity']; ?>" />
						    </fieldset>	 
						 
						     <fieldset>
						        <label for="serviceState"><?php _e('State:', 'framework') ?></label>
								<input type="text" name="serviceState" id="administrative_area_level_1" class="required" value="<?php if ( isset( $_POST['serviceState'] ) ) echo $_POST['serviceState']; ?>" />
						    </fieldset>	  
	 

						     <fieldset>
						        <label for="serviceZip"><?php _e('Zip Code:', 'framework') ?></label>
						 
						          <input type="text" name="serviceZip" id="postal_code" class="required" value="<?php if ( isset( $_POST['serviceZip'] ) ) echo $_POST['serviceZip']; ?>" />
						    </fieldset>	 
						</div>

						<fieldset>
							<label for="serviceWebsite"><?php _e('Business Website:', 'framework') ?></label>

							<input type="url" name="serviceWebsite" id="serviceWebsite" class="required" placeholder="Including the http:// or https://" value="<?php if ( isset( $_POST['serviceWebsite'] ) ) echo $_POST['serviceWebsite']; ?>" />
						</fieldset>	   

						<fieldset>
							<label for="servicePhone"><?php _e('Business Phone:', 'framework') ?></label>

							<input type="text" name="servicePhone" id="servicePhone" class="required" value="<?php if ( isset( $_POST['servicePhone'] ) ) echo $_POST['serviceEmail']; ?>" />
						</fieldset>	  

						<fieldset>
							<label for="serviceEmail"><?php _e('Business E-mail:', 'framework') ?></label>

							<input type="email" name="serviceEmail" id="serviceEmail" class="required" value="<?php if ( isset( $_POST['serviceEmail'] ) ) echo $_POST['serviceEmail']; ?>" />
						</fieldset>	 

						<fieldset>
							<label for="servicePhoto"><?php _e('Add a Logo:', 'framework') ?></label>

							<input type="file" name="servicePhoto" id="servicePhoto" class="required" />
						</fieldset>	  

						<fieldset>
							<label for="beforeAndAfterPhoto"><?php _e('Add a Before and After Photo:', 'framework') ?></label>

							<input type="file" name="beforeAndAfterPhoto" id="beforeAndAfterPhoto" class="required" />
						</fieldset>	  

					    <fieldset>
					        <label for="postContent"><?php _e('Description of Your Services:', 'framework') ?></label>
					 
					        <textarea name="postContent" id="postContent" rows="8" cols="30" class="required"></textarea>
					    </fieldset>
					 
					 	 <input type="hidden" name="place_location" id="place_location" value="" />

					     <?php wp_nonce_field( 'post_nonce', 'post_nonce_field' ); ?>

					    <fieldset>
					        <input type="hidden" name="submitted" id="submitted" value="true" />
					 
					        <button type="submit"><?php _e('Add Your Service', 'framework') ?></button>
					    </fieldset>


						</form>
					</div><!-- service-form-wrapper -->
				</div><!--.entry-content -->
			</article>

		</main><!-- .site-main -->
	</div><!-- .content-area -->

	<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
	<script type="text/javascript" src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDe710MLkkbulyOcOKU6G8vb1d8bA0X9YE&libraries=places"></script>

	

	<script>
		// This example displays an address form, using the autocomplete feature
		// of the Google Places API to help users fill in the information.

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
		  		  
		  document.getElementById("place_location").value = place.geometry.location;

		  for (var component in componentForm) {
		    document.getElementById(component).value = '';
		    document.getElementById(component).disabled = false;
		  }

		  // Get each component of the address from the place details
		  // and fill the corresponding field on the form.
		  for (var i = 0; i < place.address_components.length; i++) {
		    var addressType = place.address_components[i].types[0];
		    if (componentForm[addressType]) {
		      var val = place.address_components[i][componentForm[addressType]];
		      document.getElementById(addressType).value = val;
		    }

		  }

		  document.getElementById('serviceAddress').value =  place.address_components[0]['short_name'] + ' ' + place.address_components[1]['short_name'];
		  document.getElementById("addressInformation").style.display = 'block';
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

	</script>
<?php 

	get_footer(); 

?>