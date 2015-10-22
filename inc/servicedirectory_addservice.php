<?php

add_action( 'init', 'servicedirectory_addservice');

function servicedirectory_addservice(){

  if ( isset( $_POST['submitted'] ) && isset( $_POST['post_nonce_field'] ) ){

      if ( trim( $_POST['postTitle'] ) === '' ) {
          $postTitleError = 'Please enter a title.';
          $hasError = true;
      }

      $postInformation = array(
      	'post_title' => wp_strip_all_tags( $_POST['postTitle'] ),
      	'post_content' => $_POST['postContent'],
    	  'post_type' => 'service',
    	  'post_status' => 'pending'
      );

      $post_id = wp_insert_post( $postInformation );

      if ($post_id) {

        require_once( ABSPATH . 'wp-admin/includes/image.php' );
        require_once( ABSPATH . 'wp-admin/includes/file.php' );
        require_once( ABSPATH . 'wp-admin/includes/media.php' );

        $serviceLogoAttachment = media_handle_upload( 'servicePhoto' , $post_id );

        if ( !is_wp_error( $serviceLogoAttachment ) ){
          add_post_meta( $post_id, 'serviceLogoId', $serviceLogoAttachment );
        }

        $beforeAndAfterAttachment = media_handle_upload( 'beforeAndAfterPhoto' , $post_id );

        if ( !is_wp_error( $beforeAndAfterAttachment ) ){


          add_post_meta( $post_id, 'beforeAndAfterId', $beforeAndAfterAttachment );
        }

      	add_post_meta( $post_id, 'serviceAddress', $_POST['serviceAddress'] );
      	add_post_meta( $post_id, 'serviceCity', $_POST['serviceCity'] );
        add_post_meta( $post_id, 'serviceState', $_POST['serviceState'] );
      	add_post_meta( $post_id, 'serviceWebsite', $_POST['serviceWebsite']);
      	add_post_meta( $post_id, 'servicePhone', $_POST['servicePhone']);
        add_post_meta( $post_id, 'serviceEmail', $_POST['serviceEmail'] );
        add_post_meta( $post_id, 'place_location', $_POST['place_location'] );

      }

      wp_redirect( home_url() . '/service?submitted=true'  );
      exit;


	}

}
