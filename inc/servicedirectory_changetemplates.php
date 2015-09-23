<?php

function servicedirectory_change_post_type_template($single_template) {
     global $post;

     if ($post->post_type == 'service'){
        $single_template = plugin_dir_path( __FILE__ ) . '../templates/service.php';
     }

     return $single_template;
}

add_filter( 'single_template', 'servicedirectory_change_post_type_template' );


function servicedirectory_get_custom_archive_type_template( $archive_template ) {
     global $post;

     if ( is_post_type_archive ( 'service' ) ) {
          $archive_template = plugin_dir_path( __FILE__ ) . '../templates/archive-service.php';
     }
     return $archive_template;
}

add_filter( 'archive_template', 'servicedirectory_get_custom_archive_type_template' );
