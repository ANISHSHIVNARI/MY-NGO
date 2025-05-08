<?php
/**
 * REST API endpoints for shriramnavyugtrust.org
 */

// Register custom REST API endpoints
add_action('rest_api_init', function () {
  // Register route for custom posts
  register_rest_route('shriramnavyugtrust.org/v1', '/custom-posts', [
    'methods' => 'GET',
    'callback' => 'get_custom_posts',
    'permission_callback' => '__return_true',
  ]);
  
  // Register route for contact form
  register_rest_route('shriramnavyugtrust.org/v1', '/contact', [
    'methods' => 'POST',
    'callback' => 'process_contact_form',
    'permission_callback' => '__return_true',
  ]);
});

// Callback for custom posts endpoint
function get_custom_posts($request) {
  $args = [
    'post_type' => 'custom_post',
    'posts_per_page' => 10,
    'orderby' => 'date',
    'order' => 'DESC',
  ];
  
  $posts = get_posts($args);
  $data = [];
  
  foreach ($posts as $post) {
    $data[] = [
      'id' => $post->ID,
      'title' => $post->post_title,
      'content' => $post->post_content,
      'date' => $post->post_date,
    ];
  }
  
  return $data;
}

// Callback for contact form endpoint
function process_contact_form($request) {
  $params = $request->get_params();
  
  $name = sanitize_text_field($params['name']);
  $email = sanitize_email($params['email']);
  $message = sanitize_textarea_field($params['message']);
  
  // Process form data (e.g., send email)
  $to = get_option('admin_email');
  $subject = 'New Contact Form Submission';
  $body = "Name: $name\nEmail: $email\nMessage: $message";
  
  $sent = wp_mail($to, $subject, $body);
  
  if ($sent) {
    return ['status' => 'success', 'message' => 'Your message has been sent.'];
  } else {
    return ['status' => 'error', 'message' => 'Failed to send message.'];
  }
}

