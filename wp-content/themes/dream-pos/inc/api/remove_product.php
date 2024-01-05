<?php
add_action('rest_api_init', function () {
    register_rest_route(
        'products/v1/',
        'remove_products',
        array(
            'methods' => 'POST',
            'callback' => 'remove_product',
        )
    );
});

function remove_product($data) {
    $product_id = isset($data['product_id']) ? absint($data['product_id']) : 0;

    if (!$product_id) {
        return new WP_Error('invalid_product_id', 'Invalid product ID provided.', array('status' => 400));
    }

    $result = wp_delete_post($product_id, true);

    if ($result === false) {
        return new WP_Error('delete_error', 'Error deleting product.', array('status' => 500));
    } else {
        return 'Product deleted successfully.';
    }
}
