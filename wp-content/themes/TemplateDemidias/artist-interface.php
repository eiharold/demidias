<?php
/*
Template Name: Interface do Artista
*/

if ( is_user_logged_in() || current_user_can('publish_posts') ) { // Execute code if user is logged in
    acf_form_head();
    wp_deregister_style( 'wp-admin' );
}
get_header();

/**
 * Deregister the admin styles outputted when using acf_form
 */
add_action( 'wp_print_styles', 'tsm_deregister_admin_styles', 999 );
function tsm_deregister_admin_styles() {
    // Bail if not logged in or not able to post
    if ( ! ( is_user_logged_in() || current_user_can('publish_posts') ) ) {
        return;
    }
    wp_deregister_style( 'wp-admin' );
}
 
// ======================================================================================
// Codes to put on your content body area
// ======================================================================================
 
 
// Bail if not logged in or able to post
    if ( ! ( is_user_logged_in()|| current_user_can('publish_posts') ) ) {
        echo '<p>You must be a registered author to post.</p>';
        return;
    }
 
    $new_post = array(
        'post_id'            => 'new', // Create a new post
        // PUT IN YOUR OWN FIELD GROUP ID(s)
        'field_groups'       => array(172), // Create post field group ID(s)
        'form'               => true,
        'return'             => '%post_url%', // Redirect to new post url
        'html_before_fields' => '',
        'html_after_fields'  => '',
        'submit_value'       => 'Submit Post',
        'updated_message'    => 'Saved!'
    );
    acf_form( $new_post );
 
