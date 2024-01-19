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
function import_products_from_csv($csv_file)
{
    $success_count = 0;

    if (($handle = fopen($csv_file, 'r')) !== FALSE) {
        // Skip the first row (headers)
        fgetcsv($handle, 1000, ',');

        while (($data = fgetcsv($handle, 1000, ',')) !== FALSE) {
            $sku = sanitize_text_field($data[1]);

            // Check if a product with the same SKU already exists
            $existing_product = get_posts(array(
                'post_type' => 'product',
                'meta_query' => array(
                    array(
                        'key' => '_sku',
                        'value' => $sku,
                    ),
                ),
            ));

            if (!empty($existing_product)) {
                $success_count;
            } else {
                // Product with the SKU doesn't exist, insert a new one
                $product_data = array(
                    'post_title' => sanitize_text_field($data[0]),
                    'post_content' => '',
                    'post_status' => 'publish',
                    'post_type' => 'product',
                );

                $product_id = wp_insert_post($product_data);
                $product = wc_get_product($product_id);

                $success_count++;
            }
            $term = get_term_by('id', $data[5], 'product_cat');
            $term_brands = get_term_by('id', $data[6], 'brands');
            wp_set_object_terms($product_id, $term->term_id, 'product_cat');
            wp_set_object_terms($product_id, $term_brands->term_id, 'brands');
            $product->set_regular_price(sanitize_text_field($data[3]));
            update_post_meta($product_id, '_sku', $sku);
            update_post_meta($product_id, '_cost', $data[4]);
            update_post_meta($product_id, '_stock', sanitize_text_field($data[2]));
            update_post_meta($product_id, '_stock_status', 'instock');
            update_post_meta($product_id, '_manage_stock', 'yes');

            $product->save();
        }
        fclose($handle);
    }

    return array('message' => "$success_count products imported successfully");
}
