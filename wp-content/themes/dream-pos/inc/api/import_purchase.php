<?php
// Add custom REST API endpoint for importing products
add_action('rest_api_init', function () {
    register_rest_route(
        'v1',
        'products/import',
        array(
            'methods' => 'POST',
            'callback' => 'import_products',
            'permission_callback' => '__return_true', // Set the permission callback as needed
        )
    );
});

// Callback function for importing products from CSV
function import_products($data)
{
    // Check if the request contains a CSV file
    if (isset($_FILES['csv_file']) && $_FILES['csv_file']['error'] == 0) {
        $csv_file = $_FILES['csv_file']['tmp_name'];

        // Read the CSV file
        $csv_data = array_map('str_getcsv', file($csv_file));

        // Remove header row
        $header = array_shift($csv_data);

        // Prepare an array to store imported products
        $imported_products = array();

        // Loop through CSV data and create/update products
        foreach ($csv_data as $row) {
            $product_data = array_combine($header, $row);

            // Product already exists, update product data
            update_post_meta($product_data['ID'], '_price', $product_data['Price']);
            update_post_meta($product_data['ID'], '_cost', $product_data['Cost']);
            update_post_meta($product_data['ID'], '_stock', $product_data['Stock']);
            update_post_meta($product_data['ID'], '_manage_stock', 'yes');

            if ($product_data['Stock'] > 0) {
                update_post_meta($product_data['ID'], '_stock_status', 'instock');
            } else {
                update_post_meta($product_data['ID'], '_stock_status', 'outofstock');
            }
            // return $product_data['Stock'];
        }
        return rest_ensure_response(array('imported_products' => $imported_products));
    } else {
        // Return an error response if no CSV file is provided
        return rest_ensure_response(array('error' => 'No CSV file provided'));
    }
}
