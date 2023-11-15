<?php
add_action('rest_api_init', function () {
    register_rest_route(
        'products/v1/',
        'remove-product',
        array(
            'methods' => 'post',
            'callback' => 'remove_product',
        )
    );
});

function remove_product($product)
{
    if (get_post_type($product) === 'product') {
        // Delete the product
        wp_delete_post($product, true);
        echo "Product deleted successfully.";
    } else {
        echo "Product not found.";
    }
}