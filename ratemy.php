<?php
/*
Plugin Name: Rate My Photos
Plugin URI: https://example.com/plugins/ratemy
Description: Allows registered users to upload photos and rate them.
Version: 1.0
Author: John Doe
Author URI: https://example.com/
License: GPL2
*/

// Register custom post type for photos
function create_photo_post_type() {
  register_post_type( 'photo',
    array(
      'labels' => array(
        'name' => __( 'Photos' ),
        'singular_name' => __( 'Photo' )
      ),
      'public' => true,
      'has_archive' => true,
      'rewrite' => array('slug' => 'photos'),
      'supports' => array( 'title', 'editor', 'thumbnail', 'comments' )
    )
  );
}
add_action( 'init', 'create_photo_post_type' );
