<?php
add_action('rest_api_init', function () {
    register_rest_route(
        'v1/reload/',
        'add-reload',
        array(
            'methods' => 'POST',
            'callback' => 'add_reload',
        )
    );
});

function add_reload($data)
{
    // Perform your logic here, retrieve data from the request
    $mobile_number = $data['mobile_number']; // Change 'param_name' to the actual parameter name you want to retrieve
    $amount = $data['amount']; // Change 'param_name' to the actual parameter name you want to retrieve
    $provider = $data['provider']; // Change 'param_name' to the actual parameter name you want to retrieve

    // Create a new post for a custom post type
    $post_args = array(
        'post_title'    => $mobile_number, // Set the title of the new post
        'post_status'   => 'publish', // Set the status of the new post (publish, draft, etc.)
        'post_type'     => 'reloads', // Change 'your_custom_post_type' to the actual custom post type
        // You can add more parameters based on your custom post type requirements
    );

    $new_post_id = wp_insert_post($post_args);

    update_post_meta($new_post_id, 'amount', $amount);
    update_post_meta($new_post_id, 'provider', $provider);
    update_post_meta($new_post_id, 'status', 'pending');

    if ($new_post_id) {
        // Post created successfully
        $response = array(
            'status' => 'success',
            'message' => 'New post created successfully',
            'post_id' => $new_post_id,
        );
    } else {
        // Error creating post
        $response = array(
            'status' => 'error',
            'message' => 'Error creating new post',
        );
    }

    return new WP_REST_Response($response, 200);
}
