<?php

add_action('post_edit_form_tag', 'servicedirectory_edit_form_tag');
/**
 * Callback for WordPress 'post_edit_form_tag' action.
 * 
 * Append enctype - multipart/form-data and encoding - multipart/form-data
 * to allow image uploads for post type 'post'
 * see http://www.rfmeier.net/allow-file-uploads-to-a-post-with-wordpress-post_edit_form_tag-action/
 * 
 * @global type $post
 * @return type
 */
function servicedirectory_edit_form_tag(){
    
    global $post;
    
    //  if invalid $post object, return
    if(!$post)
        return;
    
    //  get the current post type
    $post_type = get_post_type($post->ID);
    
    //  if post type is not 'post', return
    if('service' != $post_type)
        return;
    
    //  append our form attributes
    printf(' enctype="multipart/form-data" encoding="multipart/form-data" ');
    
}