jQuery(document).ready(function($) {
    // Process photo upload form submission
    $('#ratemy-photo-form').on('submit', function(e) {
      e.preventDefault();
      var form_data = new FormData(this);
      $.ajax({
        url: ratemy_ajax.ajax_url,
        type: 'POST',
        data: form_data,
        processData: false,
        contentType: false,
        success: function(response) {
          response = JSON.parse(response);
          if (response.success) {
            $('#ratemy-photo-form').trigger('reset');
            alert(response.message);
          } else {
            alert(response.message);
          }
        },
        error: function() {
          alert('Error uploading photo.');
        }
      });
    });
    
    // Handle photo rating
    $('.ratemy-rating-stars').on('click', 'span', function() {
      var post_id = $(this).data('post-id');
      var rating = $(this).data('rating');
      $.ajax({
        url: ratemy_ajax.ajax_url,
        type: 'POST',
        data: {
          action: 'ratemy_photo_rating',
          post_id: post_id,
          rating: rating
        },
        success: function(response) {
          response = JSON.parse(response);
          if (response.success) {
            $('.ratemy-rating-stars[data-post-id="' + post_id + '"]').replaceWith(response.message);
          } else {
            alert(response.message);
          }
        },
        error: function() {
          alert('Error saving rating.');
        }
      });
    });
    
    // Initialize photo rating stars
    $('.ratemy-rating-stars').each(function() {
      var post_id = $(this).data('post-id');
      var rating = $(this).data('rating');
      var stars = '';
      for (var i = 1; i <= 5; i++) {
        if (i <= Math.round(rating)) {
          stars += '<span class="dashicons dashicons-star-filled" data-post-id="' + post_id + '" data-rating="' + i + '"></span>';
        } else {
          stars += '<span class="dashicons dashicons-star-empty" data-post-id="' + post_id + '" data-rating="' + i + '"></span>';
        }
      }
      $(this).html(stars);
    });
    
    // Initialize photo carousel
    $('.owl-carousel').owlCarousel({
      items: 1,
      loop: true,
      nav: true,
      dots: true,
      margin: 10,
      autoplay: true,
      autoplayTimeout: 5000,
      autoplayHoverPause: true,
      responsive: {
        0: {
          nav: false
        },
        768: {
          nav: true
        }
      }
    });
  });
  