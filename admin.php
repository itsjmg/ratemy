<?php
// Process photo upload form in admin panel
function ratemy_process_photo_upload() {
  if ( isset( $_FILES['photo'] ) && !empty( $_FILES['photo']['name'] ) ) {
    $file = $_FILES['photo'];
    $file_name = sanitize_file_name( $file['name'] );
    $upload_dir = wp_upload_dir();
    $upload_path = $upload_dir['path'];
    $file_path = $upload_path . '/' . $file_name;
    
    if ( move_uploaded_file( $file['tmp_name'], $file_path ) ) {
      $title = str_replace( '-', ' ', pathinfo( $file_name, PATHINFO_FILENAME ) );
      $title = ucwords( $title );
      
      // Insert photo as custom post type
      $post_args = array(
        'post_title' => $title,
        'post_type' => 'photo',
        'post_status' => 'publish'
      );
      $post_id = wp_insert_post( $post_args );
      
      // Attach uploaded image to custom post type
      $attachment = array(
        'guid'           => $upload_dir['url'] . '/' . $file_name,
        'post_mime_type' => $file['type'],
        'post_title'     => $title,
        'post_content'   => '',
        'post_status'    => 'inherit',
        'post_parent'    => $post_id
      );
      $attach_id = wp_insert_attachment( $attachment, $file_path, $post_id );
      
      // Generate image metadata and update custom post type
      $attach_data = wp_generate_attachment_metadata( $attach_id, $file_path );
      wp_update_attachment_metadata( $attach_id, $attach_data );
      
      // Redirect to uploaded photo
      wp_redirect( get_permalink( $post_id ) );
      exit;
    } else {
      wp_die( 'Failed to upload file.' );
    }
  }
}
add_action( 'init', 'ratemy_process_photo_upload' );
