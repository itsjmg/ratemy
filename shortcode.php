<?php
// Add shortcode for photo carousel
function ratemy_carousel_shortcode() {
  $carousel = ratemy_photo_carousel();
  return $carousel;
}
add_shortcode( 'ratemy_carousel', 'ratemy_carousel_shortcode' );
