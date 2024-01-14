<?php
add_action('rest_api_init', function () {
    register_rest_route(
        'products/v1/',
        'update-product',
        array(
            'methods' => 'post',
            'callback' => 'update_product',
        )
    );
});

function update_product($request)
{
    $parameters = $request->get_params();
    $product = wc_get_product($parameters['product_id']);

    if (is_a($product, 'WC_Product')) {
        $product->set_name(sanitize_text_field($parameters['product_name']));
        $product->set_regular_price(sanitize_text_field($parameters['product_price']));
        update_post_meta($parameters['product_id'], '_cost', sanitize_text_field($parameters['product_cost']));
        $product->set_stock_quantity(sanitize_text_field($parameters['product_qty']));

        update_post_meta($parameters['product_id'], '_stock_status', 'instock');
        update_post_meta($parameters['product_id'], '_manage_stock', 'yes');
        update_post_meta($parameters['product_id'], '_sku', $parameters['product_sku']);

        $product->set_category_ids(array());
        wp_set_post_terms( $parameters['product_id'], array(), 'brands');

        // Set the new category
        $term = get_term_by('slug', sanitize_text_field($parameters['product_category']), 'product_cat');
        $term_brand = get_term_by('slug', sanitize_text_field($parameters['product_brand']), 'brands');
        
        if ($term && !is_wp_error($term)) {
            $product->set_category_ids(array($term->term_id));
        }
        if ($term_brand && !is_wp_error($term_brand)) {
            wp_set_post_terms( $parameters['product_id'], array($term_brand->term_id,), 'brands');
        }

        if ($_FILES['thumbnail']['error'] == 0) {
            // Handle the file upload and get the attachment ID
            $attachment_id = media_handle_upload('thumbnail', $parameters['product_id']);
    
            if (is_wp_error($attachment_id)) {
                // Handle the error if the upload fails
                echo "Error uploading image: " . $attachment_id->get_error_message();
            } else {
                // Set the attachment as the featured image for the product
                set_post_thumbnail($parameters['product_id'], $attachment_id);
            }
        }
        $response = $product->save();
        return $response;
    } else {
        return new WP_Error('update_failed', 'Failed to update the product.', array('status' => 500));
    }
}