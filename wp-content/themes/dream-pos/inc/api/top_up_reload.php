<?php
add_action('rest_api_init', function () {
    register_rest_route(
        'v1/reload/',
        'top-up',
        array(
            'methods' => 'POST', // Use 'POST' instead of 'post'
            'callback' => 'top_up',
        )
    );
});

function top_up($data) {
    // Assuming you pass the post ID and new meta values in the request
    $post_id = isset($data['provider']) ? intval($data['provider']) : 0;
    $top_up_amount = isset($data['top_up_amount']) ? sanitize_text_field($data['top_up_amount']) : '';

    if ($post_id > 0 && get_post_status($post_id)) {
        // Check if the post is of the 'reload_provider' post type
        $post_type = get_post_type($post_id);
        if ($post_type === 'reload_providers') {

            $current_meta_value = get_post_meta($post_id, 'reload_amount', true); // Replace 'your_meta_key' with your actual meta key
            $updated_meta_value = $current_meta_value + $top_up_amount;
            // Update the meta value
            update_post_meta($post_id, 'reload_amount', $updated_meta_value); // Replace 'your_meta_key' with your actual meta key

            return 'Meta value updated successfully for reload provider with ID ' . $post_id;
        } else {
            return 'Post with ID ' . $post_id . ' is not a reload provider.';
        }
    } else {
        return 'Invalid or non-existent post ID provided.';
    }
}
