<?php
// Process photo upload form
if ( isset( $_POST['ratemy_photo_submit'] ) ) {
  $post_title = sanitize_text_field( $_POST['ratemy_photo_title'] );
  $post_content = sanitize_text_field( $_POST['ratemy_photo_description'] );
  $post_author = get_current_user_id();
  $post_status = 'publish';
  
  $file = $_FILES['ratemy_photo_file'];
  $upload = wp_upload_bits( $file['name'], null, file_get_contents( $file['tmp_name'] ) );
  
  if ( ! $upload['error'] ) {
    $post_thumbnail_id = wp_insert_attachment( array(
      'post_mime_type' => $file['type'],
      'post_title' => preg_replace( '/\.[^.]+$/', '', basename( $file['name'] ) ),
      'post_content' => '',
      'post_status' => 'inherit',
      'guid' => $upload['url']
    ), $upload['file'] );
    
    require_once ABSPATH . 'wp-admin/includes/image.php';
    $attachment_data = wp_generate_attachment_metadata( $post_thumbnail_id, $upload['file'] );
    wp_update_attachment_metadata( $post_thumbnail_id, $attachment_data );
    
    $post_thumbnail = array( $post_thumbnail_id );
  } else {
    $post_thumbnail = '';
  }
  
  $new_post = array(
    'post_title' => $post_title,
    'post_content' => $post_content,
    'post_author' => $post_author,
    'post_status' => $post_status,
    'post_type' => 'photo',
    'post_thumbnail' => $post_thumbnail
  );
  
  $post_id = wp_insert_post( $new_post );
  
  if ( ! is_wp_error( $post_id ) ) {
    $response = array(
      'success' => true,
      'message' => 'Photo uploaded successfully.'
    );
  } else {
    $response = array(
      'success' => false,
      'message' => 'Error uploading photo.'
    );
  }
  
  echo wp_json_encode( $response );
  wp_die();
}
?>

<form id="ratemy-photo-form" method="post" enctype="multipart/form-data">
  <div class="form-group">
    <label for="ratemy_photo_title">Title</label>
    <input type="text" class="form-control" id="ratemy_photo_title" name="ratemy_photo_title" required>
  </div>
  <div class="form-group">
    <label for="ratemy_photo_description">Description</label>
    <textarea class="form-control" id="ratemy_photo_description" name="ratemy_photo_description" rows="3"></textarea>
  </div>
  <div class="form-group">
    <label for="ratemy_photo_file">File</label>
    <input type="file" class="form-control-file" id="ratemy_photo_file" name="ratemy_photo_file" required>
  </div>
  <button type="submit" class="btn btn-primary" name="ratemy_photo_submit">Upload</button>
</form>
