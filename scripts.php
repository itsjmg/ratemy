<?php
// Enqueue scripts and styles
function ratemy_enqueue_scripts() {
  wp_enqueue_style( 'owl-carousel', plugin_dir_url( __FILE__ ) . 'owl.carousel.min.css' );
  wp_enqueue_script( 'owl-carousel', plugin_dir_url( __FILE__ ) . 'owl.carousel.min.js', array( 'jquery' ), '2.3.4', true );
  wp_enqueue_script( 'ratemy-script', plugin_dir_url( __FILE__ ) . 'script.js', array( 'jquery' ), '1.0', true );
  wp_localize_script( 'ratemy-script', 'ratemy_ajax', array(
    'ajax_url' => admin_url( 'admin-ajax.php' )
  ) );
}
add_action( 'wp_enqueue_scripts', 'ratemy_enqueue_scripts' );

// Add script for photo rating stars
function ratemy_photo_rating_stars_script() {
  wp_enqueue_script( 'ratemy-rating-stars', plugin_dir_url( __FILE__ ) . 'rating-stars.js', array( 'jquery' ), '1.0', true );
}
add_action( 'wp_enqueue_scripts', 'ratemy_photo_rating_stars_script' );
