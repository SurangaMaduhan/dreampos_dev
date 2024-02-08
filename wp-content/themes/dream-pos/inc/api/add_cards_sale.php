<?php

add_action('rest_api_init', function () {
    register_rest_route(
        'v1/cards/',
        'add-card-sale',
        array(
            'methods' => 'POST',
            'callback' => 'add_card_sale',
        )
    );
});

function add_card_sale(WP_REST_Request $request)
{
    $parameters = $request->get_params();

    // // Perform your logic here, retrieve data from the request
    $card_id = sanitize_text_field($parameters['card_id']);
    $card_qut_item = intval($parameters['card_qut']);
    $card_amount = intval(get_post_meta($card_id, 'amount', true));
    $card_commission = get_post_meta($card_id, 'card_commission', true);
    $card_qut = intval(get_post_meta($card_id, 'card_qut', true));
    $card_commission_type = get_post_meta($card_id, 'card_commission_type', true);
    $card_provider = get_post_meta($card_id, 'card_provider', true);
    $sale_amount = $card_amount * $card_qut_item;

    if ($card_commission_type == 'percentage') {
        $card_commission = ($card_amount / 100) * $card_commission;
    }
    $sale_commission = $card_commission * $card_qut_item;

    // Build initial post title with post ID and some post meta

    $updateQut = $card_qut - $card_qut_item;

    if ($updateQut < 0) {
        $res = array(
            'status' => 'out_stock',
            'message' => 'Error creating new post',
            'stock'    => $card_qut
        );
        return new WP_REST_Response($res, 500);
    } else {
        update_post_meta($card_id, 'card_qut', $updateQut);
    }

    $post_args = array(
        'post_status'   => 'publish',
        'post_type'     => 'cards_sales',
    );
    $new_post_id = wp_insert_post($post_args);

    // Check if the post was successfully created
    if ($new_post_id) {
        // Build updated post title and update the post
        $updated_post_title = "#" . $new_post_id;
        wp_update_post(array('ID' => $new_post_id, 'post_title' => $updated_post_title));

        // Add post meta to the newly created post
        update_post_meta($new_post_id, 'sale_amount', $sale_amount);
        update_post_meta($new_post_id, 'sale_commission_amount', $sale_commission);
        update_post_meta($new_post_id, 'sale_item_count', $card_qut_item);
        update_post_meta($new_post_id, 'sale_item_provider', $card_provider);

        // Add more post meta as needed
        return new WP_REST_Response('Card sale added successfully', 200);
    } else {
        // Handle the error if post creation fails
        return new WP_REST_Response('Error adding card sale', 500);
    }
}
