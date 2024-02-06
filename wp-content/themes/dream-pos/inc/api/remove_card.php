<?php
add_action('rest_api_init', function () {
    register_rest_route(
        'v1/cards/',
        'remove-cards',
        array(
            'methods' => 'POST',
            'callback' => 'remove_cards',
        )
    );
});

function remove_cards($data){
    $post_id = isset($data['post_id']) ? absint($data['post_id']) : 0;

    if (!$post_id) {
        return new WP_Error('invalid_cards_id', 'Invalid cards ID provided.', array('status' => 400));
    }

    $result = wp_delete_post($post_id, true);

    if ($result === false) {
        return new WP_Error('delete_error', 'Error deleting cards.', array('status' => 500));
    } else {
        return 'Cards deleted successfully.';
    }
}
