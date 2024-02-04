<?php add_action('rest_api_init', function () {
    register_rest_route(
        'v1/reload/', // Remove the trailing slash
        '/update-reload',
        array(
            'methods' => 'POST',
            'callback' => 'update_reload',
        )
    );
});

function update_reload($data)
{
    // Perform your logic here, retrieve data from the request
    $post_id = absint($data['reload_id']);
    $mobile_number = sanitize_text_field($data['mobile_number']);
    $amount = absint($data['amount']);
    // $provider = sanitize_text_field($data['provider']);

    // Check if the post with the given ID exists
    $existing_post = get_post($post_id);

    if ($existing_post) {
        // Update post data
        $post_args = array(
            'ID' => $post_id,
            'post_title' => $mobile_number,
            'post_status' => 'publish',
            'post_type' => 'reloads',
        );

        wp_update_post($post_args);

        // Update post meta
        update_post_meta($post_id, 'amount', $amount);
        // update_post_meta($post_id, 'provider', $provider);

        $response = array(
            'status' => 'success',
            'message' => 'Post updated successfully',
            'post_id' => $post_id,
        );
    } else {
        $response = array(
            'status' => 'error',
            'message' => 'Post not found',
        );
    }

    return new WP_REST_Response($response, 200);
}
