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

        $product->set_category_ids(array());

        // Set the new category
        $term = get_term_by('slug', sanitize_text_field($parameters['product_category']), 'product_cat');
        if ($term && !is_wp_error($term)) {
            $product->set_category_ids(array($term->term_id));
        }
        $response = $product->save();
        return $response;
    } else {
        return new WP_Error('update_failed', 'Failed to update the product.', array('status' => 500));
    }
}