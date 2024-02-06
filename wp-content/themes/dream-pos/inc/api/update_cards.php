<?php add_action('rest_api_init', function () {
    register_rest_route(
        'v1/cards/', // Remove the trailing slash
        'update-cards',
        array(
            'methods' => 'POST',
            'callback' => 'update_cards',
        )
    );
});

function update_cards($data)
{
    $post_id = absint($data['card_id']);
    $existing_post = get_post($post_id);

    if ($existing_post) {
        update_post_meta($post_id, 'card_provider', sanitize_text_field($data['card_provider']));
        update_post_meta($post_id, 'card_commission', sanitize_text_field($data['card_commission']));
        update_post_meta($post_id, 'card_commission_type', sanitize_text_field($data['card_commission_type']));
        update_post_meta($post_id, 'amount', sanitize_text_field($data['card_amount']));

        $response = array(
            'status' => 'success',
            'message' => 'Card updated successfully',
            'post_id' => $post_id,
        );
    } else {
        $response = array(
            'status' => 'error',
            'message' => 'Card not found',
        );
    }

    return new WP_REST_Response($response, 200);
}
