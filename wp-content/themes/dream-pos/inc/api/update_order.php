<?php
add_action('rest_api_init', function () {
    register_rest_route(
        'products/v1/',
        'update-order',
        array(
            'methods' => 'post',
            'callback' => 'update_order',
        )
    );
});

function update_order($request)
{
    $parameters = $request->get_params();

    // Check if required parameters are present
    if (empty($parameters['order_id']) || empty($parameters['order_status'])) {
        return new WP_Error('missing_parameters', 'Order ID and new_status are required parameters.', array('status' => 400));
    }

    $order_id = $parameters['order_id'];
    $new_status = $parameters['order_status'];

    // Update order status
    $order = wc_get_order($order_id);

    if (is_a($order, 'WC_Order')) {
        $order->update_status($new_status);
        return array('message' => 'Order status updated successfully.');
    } else {
        return new WP_Error('update_failed', 'Failed to update the order.', array('status' => 500));
    }
}
