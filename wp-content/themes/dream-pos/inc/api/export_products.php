<?php
// Add custom REST API endpoint for exporting products
add_action('rest_api_init', function () {
    register_rest_route(
        'v1',
        'products/export',
        array(
            'methods' => 'POST',
            'callback' => 'export_products',
            'permission_callback' => '__return_true', // Set the permission callback as needed
        )
    );
});

// Callback function for exporting products as CSV
function export_products($data) {
    // Retrieve all products
    $args = array(
        'post_type' => 'product',
        'posts_per_page' => -1,
    );
    $products_query = new WP_Query($args);
    $products = $products_query->get_posts();

    // Prepare CSV content
    $csv_content = "ID,Title,SKU,Price,Cost,Stock\n";

    // Loop through products and add data to CSV content
    foreach ($products as $product) {
        $product_data = array(
            'id' => $product->ID,
            'title' => get_the_title($product->ID),
            'sku' => get_post_meta($product->ID, '_sku', true),
            'price' => get_post_meta($product->ID, '_price', true),            
            'cost' => get_post_meta($product->ID, '_cost', true),
            'stock' => get_post_meta($product->ID, '_stock', true),
        );

        // Add product data to CSV content
        $csv_content .= implode(',', $product_data) . "\n";
    }

    // Set CSV headers
    header('Content-Type: text/csv');
    header('Content-Disposition: attachment; filename="exported_products.csv"');

    // Output CSV content
    echo $csv_content;

    // Stop further execution
    die();
}
