<?php
	//template for displaying single service page
	
		
	get_header();

	require( plugin_dir_path( __FILE__ ) . '../inc/servicedirectory_mapsapikey.php');


?>



	<?php while ( have_posts() ) : the_post(); ?>
		<?php 
				$theID = get_the_ID(); 
			    $the_logo = get_post_meta( $theID, 'serviceLogoId', true );
			    $the_results_picture =  get_post_meta( $theID, 'beforeAndAfterId', true );
		?>

		<style type="text/css">
			#map { min-height: 400px; min-width: 320px; }
		</style>

		<header class="entry-header">
			<?php the_title( '<h1 class="entry-title">', '</h1>' ); ?>
		</header>


		<div class="entry-content single-service">
			<div id="map"></div>
			
			<div class="row">
				<div class="col-md-4 col-xs-12">
					<?php echo wp_get_attachment_image( $the_logo, 'full' ); ?>
				</div>

				<div class="col-md-6 col-md-offset-1 col-xs-12">
					<h3 class="business-info-title">Contact Information:</h3>
					<ul>
						<li> Address: <?php echo get_post_meta( $theID, 'serviceAddress', true ); ?>, <?php echo get_post_meta( $theID, 'serviceCity', true ); ?> <?php echo get_post_meta( $theID, 'serviceState', true ); ?> <?php echo get_post_meta( $theID, 'serviceZip', true ); ?></li>
						
						<?php 
							if ( get_post_meta( $theID, 'serviceWebsite', true ) ){ 
								echo '<li>Website: <a href="' . get_post_meta( $theID, 'serviceWebsite', true ) . '">' . get_post_meta( $theID, 'serviceWebsite', true ) . '</a></li>';
							}

							if ( get_post_meta( $theID, 'servicePhone', true ) ) {
								echo '<li>Phone: <a href="tel:"' .  get_post_meta( $theID, 'servicePhone', true ) .  '"">' .  get_post_meta( $theID, 'servicePhone', true ) . '</a></li>';
							}
							
							if ( get_post_meta( $theID, 'serviceEmail', true ) ){
								echo '<li> E-Mail: <a href="mailto:'. get_post_meta( $theID, 'serviceEmail', true ) . '"> '. get_post_meta( $theID, 'serviceEmail', true ) .'</a></li>';
							}
							
						?>
						
					</ul>

					<h3>Description of Services:</h3>

						<div class="serviceDescription"><?php echo get_the_content(); ?></div>

				</div>

			</div>

			<div class="row" style="margin: 15px;">

				<div class="col-md-10 col-md-offset-1">
					<?php echo wp_get_attachment_image( $the_results_picture, 'full' ); ?>
				</div>

			</div>

		</div>

	<?php endwhile; ?>

	<script>
		
		<?php 

			$theLocation = get_post_meta( $theID, 'place_location', true);
			$search = array("(", ",", ")");
			$replace = array("{lat:",", lng:","}");
			$theLocation = str_replace($search, $replace, $theLocation);
			$serviceTitle = get_the_title();
			echo 'var placeLocation = ' . $theLocation . ';'; 
			echo "\nvar serviceTitle = String('" . $serviceTitle . "');";

		?>


		var map;
		function initMap(){
			map = new google.maps.Map(document.getElementById('map'), {
    			center:  placeLocation,
				zoom: 12
			});

			var marker = new google.maps.Marker({
    			position: placeLocation,
    			map: map,
    			title: serviceTitle
  			});

		} 

	</script>
	<script src="https://maps.googleapis.com/maps/api/js?key=<?php echo $apiKey; ?>&callback=initMap" async defer></script>


<?php 

	get_footer(); 

?>