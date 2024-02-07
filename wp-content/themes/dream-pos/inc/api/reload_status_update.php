<?php
add_action('rest_api_init', function () {
    register_rest_route(
        'v1/reload/',
        'update-status',
        array(
            'methods' => 'POST',
            'callback' => 'update_status',
        )
    );
});

function update_status($data)
{
    // Perform your logic here, retrieve data from the request
    $post_id = absint($data['p_id']);
    // $mobile_number = sanitize_text_field($data['mobile_number']);
    // $amount = absint($data['amount']);
    // $provider = sanitize_text_field($data['provider']);

    // Check if the post with the given ID exists
    $existing_reload = get_post($post_id);


    if ($existing_reload) {
        $reaload_id = $existing_reload->ID;
        $reload_amount = get_post_meta($post_id, 'amount', true);
        $reload_provider = get_post_meta($post_id, 'provider', true);
        $provider = get_page_by_title($reload_provider, OBJECT, 'reload_providers');
        $provider_balance = get_post_meta($provider->ID, 'reload_amount', true);
        $provider_commission = get_post_meta($provider->ID, 'reload_commission', true);
        $provider_commission_type = get_post_meta($provider->ID, 'commission_type', true);

        $balance_reduce = $reload_amount;

        $calculate_commission = ($reload_amount / 100) * $provider_commission;

        if ($provider_commission_type == 'after') {
            $balance_reduce = $reload_amount - $calculate_commission;
        }

        $after_balance = $provider_balance - $balance_reduce;

        update_post_meta($reaload_id, 'reload_item_commission', $calculate_commission);

        update_post_meta($reaload_id, 'provider_before_balance', $provider_balance);

        update_post_meta($reaload_id, 'provider_after_balance', $after_balance);

        update_post_meta($reaload_id, 'status', 'completed');

        update_post_meta($provider->ID, 'reload_amount', $after_balance);


        $response = array(
            'status' => 'success',
            'message' => 'Reload status updated',
            'post_id' => $post_id,
        );
    } else {
        $response = array(
            'status' => 'error',
            'message' => 'Reload not found',
        );
    }

    return new WP_REST_Response($response, 200);
}
