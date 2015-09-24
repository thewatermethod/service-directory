<?php

function add_servicedirectory_metaboxes(){

		add_meta_box( 'servicedirectory_add_service', 'Service Info', 'add_servicedirectory_metaboxes_callback', 'service','side');
}

function add_servicedirectory_metaboxes_callback( $post ){

	/**
	 *
	 * Prints the box content.
	 * 
	 * @param WP_Post $post The object for the current post/page.
	 *
	 */

  	wp_nonce_field( 'save_servicedirectory_metaboxes', 'servicedirectory_meta_box_nonce' );
  	echo '<label for="locationField">Find your address with our quick search: </label>';
    echo '<input id="autocomplete" autocomplete="false" placeholder="Enter your address" onFocus="geolocate()" type="text" class="widefat"></input><hr>';

  	$serviceAddress = get_post_meta( $post->ID, 'serviceAddress', true);
  	echo '<label for="serviceAddress">Service Address</label>';
  	echo '<input type="text" name="serviceAddress" value="'.$serviceAddress.'" class="widefat" id="serviceAddress" />';

  	$serviceCity =  get_post_meta( $post->ID, 'serviceCity', true);
  	echo '<label for="serviceCity">City</label>';
  	echo '<input type="text" name="serviceCity" id="locality" class="widefat" value="'.$serviceCity.'" />';

    $serviceState = get_post_meta( $post->ID, 'serviceState', true);
    echo '<label for="serviceState">Service State</label>';
   	echo '<input type="text" name="serviceState" value="'.$serviceState.'" class="widefat"  id="serviceState" />';

   	$serviceZip = get_post_meta( $post->ID, 'serviceZip', true);
   	echo '<label for="serviceZip">Zip Code</label>';
    echo '<input type="text" name="serviceZip" id="postal_code" class="widefat" value="'.$serviceZip.'" />';	
    
    $serviceWebsite = get_post_meta( $post->ID, 'serviceWebsite', true);
    echo '<label for="serviceWebsite">Service Website</label>';
    echo '<input type="text" name="serviceWebsite" value="'.$serviceWebsite.'" class="widefat" />';
    
    $servicePhone = get_post_meta( $post->ID, 'servicePhone', true);
    echo '<label for="servicePhone">Service Phone</label>';
    echo '<input type="text" name="servicePhone" value="'.$servicePhone.'" class="widefat" /><hr>';
    
    $serviceEmail = get_post_meta( $post->ID, 'serviceEmail', true);
  	echo '<label for="serviceEmail">E-mail:</label>';
  	echo '<input type="text" name="serviceEmail" id="serviceEmail" class="widefat" value="'.$serviceEmail.'"" />';

    $serviceLogoId = get_post_meta( $post->ID, 'serviceLogoId', true); 
    echo '<label for="servicePhoto">Logo</label>';
    echo'<div style="clear:both;">' . wp_get_attachment_image( $serviceLogoId ) . '</div>';
    echo '<input type="file" name="servicePhoto" class="widefat"><hr>';

    $beforeAndAfterId = get_post_meta( $post->ID, 'beforeAndAfterId', true); 
    echo '<label for="beforeAndAfterPhoto">Before and After Picture</label>';
    echo '<div style="clear:both;">'. wp_get_attachment_image( $beforeAndAfterId ). '</div>';
    echo '<input type="file" name="beforeAndAfterPhoto" class="widefat">';

    $place_location = get_post_meta( $post->ID, 'place_location', true); 
    echo '<input type="hidden" name="place_location" id="place_location" value="'.$place_location.'" />';
   	
}

function save_servicedirectory_metaboxes( $post_id ){

	/**
	 *
	 * When the post is saved, saves our custom data.
	 *
	 * @param int $post_id The ID of the post being saved.
	 *
	 */

	/** SECURITY/VERIFICATION STUFF **/

	if ( !isset( $_POST['servicedirectory_meta_box_nonce'] ) ) { return; }

	if ( !wp_verify_nonce( $_POST['servicedirectory_meta_box_nonce'], 'save_servicedirectory_metaboxes' ) ) { return; }

	if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {	return; }

	if('page' == $_POST['post_type']) {
      if(!current_user_can('edit_page', $post_id)) {
        return $post_id;
      } 
    } else {
        if(!current_user_can('edit_page', $post_id)) {
            return $post_id;
        } 
    } 

    /** END SECURITY STUFF **/

    update_post_meta( $post_id, 'serviceAddress', sanitize_text_field($_POST['serviceAddress']) );
    update_post_meta( $post_id, 'serviceCity', sanitize_text_field($_POST['serviceCity']) );
    update_post_meta( $post_id, 'serviceState', sanitize_text_field($_POST['serviceState']) );
    update_post_meta( $post_id, 'serviceWebsite', sanitize_text_field($_POST['serviceWebsite']) );
    update_post_meta( $post_id, 'servicePhone', sanitize_text_field($_POST['servicePhone']) );
    update_post_meta( $post_id, 'serviceEmail', sanitize_text_field($_POST['serviceEmail']) );
    update_post_meta( $post_id, 'serviceZip', sanitize_text_field($_POST['serviceZip']) );
    update_post_meta( $post_id, 'place_location', $_POST['place_location']);

    $serviceLogoAttachment = media_handle_upload( 'servicePhoto' , $post_id );
    
    if ( !is_wp_error( $serviceLogoAttachment ) ){ 
     
      update_post_meta( $post_id, 'serviceLogoId', $serviceLogoAttachment );
    }

    $beforeAndAfterAttachment = media_handle_upload( 'beforeAndAfterPhoto' , $post_id );

    if ( !is_wp_error( $beforeAndAfterAttachment ) ){ 
 
      update_post_meta( $post_id, 'beforeAndAfterId', $beforeAndAfterAttachment );
    }

}

add_action('save_post', 'save_servicedirectory_metaboxes');
