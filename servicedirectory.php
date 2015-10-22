<?php

   /***************************************************************************************************

     Plugin Name: Service Provider Directory Plugin
     Plugin URI: http://www.capecodwebfoundry.com/service-directory
     Description: A plugin that allows users to add themselves to a directory of service providers. For best results, please use the Service Directory theme as well!
     Version: 1.0
     Author: Matt Bevilacqua
     Author URI: http://www.mattbev.com
     License: GPL2

   ***************************************************************************************************/


//  Add custom "service" post type /ck
require( 'inc/servicedirectory_addposttype.php' );
 
// Add metaboxes /ck
require( 'inc/servicedirectory_addmetaboxes.php' );

// Runs when plugin is activated /ck
register_activation_hook(__FILE__,'servicedirectory_install'); 

// Runs on plugin deactivation /ck
register_deactivation_hook( __FILE__, 'servicedirectory_remove' );

// add scripts and styles /ck
require('inc/servicedirectory_enqueue.php');

// add custom templates
require( 'inc/servicedirectory_pagetemplater.php' );
require( 'inc/servicedirectory_changetemplates.php' );

//  install needed pages with plugin
require( 'inc/servicedirectory_install.php' );

//  process front end service submission
require( 'inc/servicedirectory_addservice.php');

// allows posts to do file uploads
require( 'inc/servicedirectory_enctypeposthack.php');


function servicedirectory_menu(){
	
	//  add_options_page( $page_title, $menu_title, $capability, $menu_slug, $function);
   
}

add_action( 'admin_menu', 'servicedirectory_menu' );


function servicedirectory_options_page(){

  global $servicedirectory_url;
  global $options;

  if( !current_user_can('manage_options') ){
     wp_die( 'You do not have sufficient permissions to access this page.' );
  }


  require( plugins_url('inc/servicedirectory_pagewrapper.php', __FILE__) );

}

