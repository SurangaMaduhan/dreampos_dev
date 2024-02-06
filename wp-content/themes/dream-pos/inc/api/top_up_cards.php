<?php
add_action('rest_api_init', function () {
    register_rest_route(
        'v1/cards/',
        'top-ups',
        array(
            'methods' => 'POST', // Use 'POST' instead of 'post'
            'callback' => 'top_up_cards',
        )
    );
});

function top_up_cards($data) {
    // Assuming you pass the post ID and new meta values in the request
    $post_id = isset($data['card']) ? intval($data['card']) : 0;
    $card_qut = isset($data['top_up_card']) ? sanitize_text_field($data['top_up_card']) : '';

    if ($post_id > 0 && get_post_status($post_id)) {
        // Check if the post is of the 'reload_provider' post type
        $post_type = get_post_type($post_id);
        if ($post_type === 'cards') {

            $current_meta_value = get_post_meta($post_id, 'card_qut', true); 
            // Replace 'your_meta_key' with your actual meta key
            $updated_meta_value = $current_meta_value + $card_qut;
            // Update the meta value
            update_post_meta($post_id, 'card_qut', $updated_meta_value); // Replace 'your_meta_key' with your actual meta key

            return 'Meta value updated successfully for Card provider with ID ' . $post_id;
        } else {
            return 'Post with ID ' . $post_id . ' is not a Card.';
        }
    } else {
        return 'Invalid or non-existent Card ID provided.';
    }
}
