<?php

add_action('rest_api_init', function () {
    register_rest_route(
        'v1/cards/',
        'add-card',
        array(
            'methods' => 'POST',
            'callback' => 'add_card',
        )
    );
});

function add_card(WP_REST_Request $request) {
    $parameters = $request->get_params();

    // Perform your logic here, retrieve data from the request
    $card_name = sanitize_text_field($parameters['card_name']);
    $card_provider = sanitize_text_field($parameters['card_provider']);
    $card_qut = sanitize_text_field($parameters['card_qut']);
    $card_commission_type = sanitize_text_field($parameters['card_commission_type']);
    $card_commission = floatval($parameters['card_commission']);
    $amount = floatval($parameters['card_amount']);

    // Add the post with meta values
    $post_args = array(
        'post_title'    => $card_name,
        'post_status'   => 'publish',
        'post_type'     => 'cards', // Change 'your_custom_post_type' to the actual custom post type
        // You can add more parameters based on your custom post type requirements
    );

    $new_post_id = wp_insert_post($post_args);

    if (!is_wp_error($new_post_id)) {
        update_post_meta($new_post_id, 'card_provider', $card_provider);
        update_post_meta($new_post_id, 'card_qut', $card_qut);
        update_post_meta($new_post_id, 'card_commission_type', $card_commission_type);
        update_post_meta($new_post_id, 'card_commission', $card_commission);
        update_post_meta($new_post_id, 'amount', $amount);

        // You can send a response back if needed
        return new WP_REST_Response('Card added successfully', 200);
    } else {
        // Handle the error if post creation fails
        return new WP_REST_Response('Error adding card', 500);
    }
}
