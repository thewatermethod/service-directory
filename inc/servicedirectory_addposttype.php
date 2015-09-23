<?php

//  Add custom "service" post type

add_action('init', 'servicedirectory_addposttype');
add_action( 'add_meta_boxes', 'add_servicedirectory_metaboxes' );


function servicedirectory_addposttype(){

	$labels = array(
		'name'               => _x( 'Services', 'post type general name', 'servicedirectory' ),
		'singular_name'      => _x( 'Service', 'post type singular name', 'servicedirectory' ),
		'menu_name'          => _x( 'Services', 'admin menu', 'servicedirectory' ),
		'name_admin_bar'     => _x( 'Service', 'add new on admin bar', 'servicedirectory' ),
		'add_new'            => _x( 'Add New', 'service', 'servicedirectory' ),
		'add_new_item'       => __( 'Add New Service', 'servicedirectory' ),
		'new_item'           => __( 'New Service', 'servicedirectory' ),
		'edit_item'          => __( 'Edit Service', 'servicedirectory' ),
		'view_item'          => __( 'View Service', 'servicedirectory' ),
		'all_items'          => __( 'All Services', 'servicedirectory' ),
		'search_items'       => __( 'Search Services', 'servicedirectory' ),
		'parent_item_colon'  => __( 'Parent Services:', 'servicedirectory' ),
		'not_found'          => __( 'No services found.', 'servicedirectory' ),
		'not_found_in_trash' => __( 'No services found in Trash.', 'servicedirectory' )
	);

	$args = array(
		'labels'             => $labels,
        'description'        => __( 'Description.', 'servicedirectory' ),
		'public'             => true,
		'publicly_queryable' => true,
		'show_ui'            => true,
		'show_in_menu'       => true,
		'query_var'          => true,
		'rewrite'            => array( 'slug' => 'service' ),
		'capability_type'    => 'post',
		'has_archive'        => true,
		'hierarchical'       => false,
		'menu_position'      => null,
		'supports'           => array( 'title', 'editor', 'author', 'thumbnail')
	);

	register_post_type('service', $args);

}



