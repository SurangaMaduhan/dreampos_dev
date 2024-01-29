<?php 
add_action('rest_api_init', function () {
    register_rest_route(
        'v1/',
        'remove-order',
        array(
            'methods' => 'POST',
            'callback' => 'remove_order',
        )
    );
});

function remove_order($request)
{
    $order_id = $request->get_param('order_id');
    // return $order_id;

    if (empty($order_id)) {
        return new WP_Error('missing_order_id', 'Order ID is required.', array('status' => 400));
    }

    // Check if the order exists
    $order = wc_get_order($order_id);

    if (!$order || is_wp_error($order)) {
        return new WP_Error('invalid_order_id', 'Invalid Order ID.', array('status' => 404));
    }


    if ('cancelled' == $order->get_status()) {

        // Delete the order
        $order->delete();

        return array('success' => true, 'message' => 'Order status changed to cancelled and order deleted successfully.');
    } 
}
