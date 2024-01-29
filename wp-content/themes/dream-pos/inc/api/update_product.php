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
    // return 'succsess';
    $parameters = $request->get_params();
    $product = wc_get_product($parameters['product_id']);
    $product->set_name(sanitize_text_field($parameters['product_name']));

    // Updated product description handling
    $new_description = sanitize_text_field($parameters['product_description']);
    $product->set_description($new_description);

    $product->set_regular_price(sanitize_text_field($parameters['product_price']));
    update_post_meta($parameters['product_id'], '_cost', sanitize_text_field($parameters['product_cost']));
    $product->set_stock_quantity(sanitize_text_field($parameters['product_qty']));

    if (sanitize_text_field($parameters['quantity']) < 0) {
        update_post_meta($parameters['product_id'], '_stock_status', 'instock');
    } else {
        update_post_meta($parameters['product_id'], '_stock_status', 'outofstock');
    }
    update_post_meta($parameters['product_id'], '_manage_stock', 'yes');
    update_post_meta($parameters['product_id'], '_sku', $parameters['product_sku']);

    $product->set_category_ids(array());
    wp_set_post_terms($parameters['product_id'], array(), 'brands');

    // Set the new category
    $term = get_term_by('slug', sanitize_text_field($parameters['product_category']), 'product_cat');
    $term_brand = get_term_by('slug', sanitize_text_field($parameters['product_brand']), 'brands');

    if ($term && !is_wp_error($term)) {
        $product->set_category_ids(array($term->term_id));
    }
    if ($term_brand && !is_wp_error($term_brand)) {
        wp_set_post_terms($parameters['product_id'], array($term_brand->term_id), 'brands');
    }

    if ($_FILES['thumbnail']['error'] == 0) {
        // Handle the file upload and get the attachment ID
        $attachment_id = media_handle_upload('thumbnail', $parameters['product_id']);

        if (!is_wp_error($attachment_id)) {        
            // Set the attachment as the featured image for the product
            set_post_thumbnail($parameters['product_id'], $attachment_id);
        }
    }
    $response = $product->save();
    return $response;
}
