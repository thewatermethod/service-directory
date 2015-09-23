<?php

function servicedirectory_install() {

    global $wpdb;

    $the_page_title = 'Add Your Service';
    $the_page_name = 'add-a-service';

    // the menu entry...
    delete_option("servicedirectory_page_title");
    add_option("servicedirectory_page_title", $the_page_title, '', 'yes');
    // the slug...
    delete_option("servicedirectory_page_name");
    add_option("servicedirectory_page_name", $the_page_name, '', 'yes');
    // the id...
    delete_option("servicedirectory_page_id");
    add_option("servicedirectory_page_id", '0', '', 'yes');

    $the_page = get_page_by_title( $the_page_title );

    if ( ! $the_page ) {

        // Create post object
        $_p = array();
        $_p['post_title'] = $the_page_title;
        $_p['post_content'] = "This text may be overridden by the plugin. You shouldn't edit it.";
        $_p['post_status'] = 'publish';
        $_p['post_type'] = 'page';
        $_p['comment_status'] = 'closed';
        $_p['ping_status'] = 'closed';
        $_p['post_category'] = array(1); // the default 'Uncategorized'

        // Insert the post into the database
        $the_page_id = wp_insert_post( $_p );

        error_log( $the_page_id, 3, '../wp-content/debug.log' );
        update_post_meta( $the_page_id, '_wp_page_template', 'add_a_service.php'); 

    } else {
        // the plugin may have been previously active and the page may just be trashed...

        $the_page_id = $the_page->ID;

        //make sure the page is not trashed...
        $the_page->post_status = 'publish';
        $the_page_id = wp_update_post( $the_page );

    }

    delete_option( 'servicedirectory_page_id' );
    add_option( 'servicedirectory_page_id', $the_page_id );

}

function servicedirectory_remove() {

    global $wpdb;

    $the_page_title = get_option( "servicedirectory_page_title" );
    $the_page_name = get_option( "servicedirectory_page_name" );

    //  the id of our page...
    $the_page_id = get_option( 'servicedirectory_page_id' );
    if( $the_page_id ) {
        wp_delete_post( $the_page_id ); // this will trash, not delete
    }

    delete_option("servicedirectory_page_title");
    delete_option("servicedirectory_page_name");
    delete_option("servicedirectory_page_id");

}

function servicedirectory_query_parser( $q ) {

    $the_page_name = get_option( "servicedirectory_page_name" );
    $the_page_id = get_option( 'servicedirectory_page_id' );

    $qv = $q->query_vars;

    if( !$q->did_permalink AND ( isset( $q->query_vars['page_id'] ) ) AND ( intval($q->query_vars['page_id']) == $the_page_id ) ) {

        $q->set('servicedirectory_page_is_called', TRUE );
        return $q;

    } elseif( isset( $q->query_vars['pagename'] ) AND ( ($q->query_vars['pagename'] == $the_page_name) OR ($_pos_found = strpos($q->query_vars['pagename'],$the_page_name.'/') === 0) ) ) {

        $q->set('servicedirectory_page_is_called', TRUE );
        return $q;

    } else {

        $q->set('servicedirectory_page_is_called', FALSE );
        return $q;

    }

}

add_filter( 'parse_query', 'servicedirectory_query_parser' );