<?php
add_action('rest_api_init', function () {
    register_rest_route(
        'v1/reload/',
        'remove-reload',
        array(
            'methods' => 'POST',
            'callback' => 'remove_reload',
        )
    );
});

function remove_reload($data){
    $post_id = isset($data['post_id']) ? absint($data['post_id']) : 0;

    if (!$post_id) {
        return new WP_Error('invalid_product_id', 'Invalid product ID provided.', array('status' => 400));
    }

    $result = wp_delete_post($post_id, true);

    if ($result === false) {
        return new WP_Error('delete_error', 'Error deleting product.', array('status' => 500));
    } else {
        return 'Product deleted successfully.';
    }
}
