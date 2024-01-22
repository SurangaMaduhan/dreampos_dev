<?php
add_action('rest_api_init', function () {
    register_rest_route(
        'v1/products',
        'add-order',
        array(
            'methods' => 'POST',
            'callback' => 'add_order',
        )
    );
});

function add_order($request)
{
    // Check if the request is a POST request
    if ('POST' !== $request->get_method()) {
        return new WP_Error('invalid_method', 'Invalid request method', array('status' => 405));
    }

    // Get the request data
    $cart_data = json_decode($request->get_param('cart_data'), true);
    $cost_total = $request->get_param('cost-total');
    $order_profit = $request->get_param('order-profit');
    $payment_type = $request->get_param('payment_type');
    $parts_type = $request->get_param('parts_type');
    $customer_name = $request->get_param('customer_name');
    
    // Validate the cart data
    if (empty($cart_data) || !is_array($cart_data)) {
        return new WP_Error('invalid_cart_data', 'Invalid cart data', array('status' => 400));
    }

    // Create a new order
    $order = wc_create_order();

    // Add products to the order
    foreach ($cart_data as $cart_item) {
        $product_id = $cart_item['product_id'];
        $quantity   = $cart_item['quantity'];

        // Validate product existence
        $product = wc_get_product($product_id);
        if (!$product) {
            return new WP_Error('invalid_product', 'Invalid product ID', array('status' => 400));
        }

        // Add the product to the order
        $item_id = $order->add_product($product, $quantity);

        // Add product meta information
        if ($item_id) {
            wc_add_order_item_meta($item_id, '_pr_cost', $product->get_meta('_cost'), true);
        }
    }

    // Calculate totals and save the order
    $order->calculate_totals();
    $order->save();

    // Add custom order meta data
    $order_id = $order->get_id();

    $order->update_meta_data('_cost_total', $cost_total);
    $order->update_meta_data('_order_profit', $order_profit);
    // $order->update_meta_data('_payment_type', $payment_type);
    $order->update_meta_data('_parts_type', $parts_type);
    $order->update_meta_data('_customer_name', $customer_name);
    

    // Optionally mark the order as paid
    if($payment_type == 'cash'){
        $order->update_status('completed');
    } else{
        $order->update_status('pending');
    }
    

    // Clear the cart
    // WC()->cart->empty_cart();
    // update_post_meta($order_id, '_cost_total ', $cost_total);

    // Optionally, you can retrieve and output the saved meta data
    // $saved_meta_value = get_post_meta($order_id, '_custom_meta_key', true);

    // Return a response with the order ID
    return new WP_REST_Response(array('order_id' => $order_id), 200);
}
