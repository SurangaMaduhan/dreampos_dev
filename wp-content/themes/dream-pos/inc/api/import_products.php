<?php

add_action('rest_api_init', function () {
    register_rest_route(
        'v1/products/',
        'import_products',
        array(
            'methods' => 'post',
            'callback' => 'import_product',
        )
    );
});
function import_product($request)
{
    $parameters = $request->get_params();
    // Check if a CSV file is provided
    if (!empty($_FILES['csv_file']['name'])) {
        $file = $_FILES['csv_file']['tmp_name'];
        // Perform CSV import
        return rest_ensure_response(import_products_from_csv($file));
    }

    // If no CSV file, proceed with updating individual product logic
    $product = wc_get_product($parameters['product_id']);

    if (is_a($product, 'WC_Product')) {
        // Your existing update logic here

        $response = $product->save();
        return rest_ensure_response(array('message' => 'Product update successful'));
    } else {
        return new WP_Error('update_failed', 'Failed to update the product.', array('status' => 500));
    }
}

// CSV import function
function import_products_from_csv($csv_file) {
    $success_count = 0;

    if (($handle = fopen($csv_file, 'r')) !== FALSE) {
        while (($data = fgetcsv($handle, 1000, ',')) !== FALSE) {
            // Your CSV import logic here
            // Example: Create or update products, set featured image, etc.
            print_r($data);
            // exit();
            $success_count++;
        }
        fclose($handle);
    }

    return array('message' => "$success_count products imported successfully");
}