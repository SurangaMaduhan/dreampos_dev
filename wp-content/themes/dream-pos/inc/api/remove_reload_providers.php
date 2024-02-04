<?php
add_action('rest_api_init', function () {
    register_rest_route(
        'v1/reload/',
        'delete-reload-provider',
        array(
            'methods' => 'POST',
            'callback' => 'delete_reload_provider',
        )
    );
});

function delete_reload_provider($data) {
    $post_id = isset($data['post_id']) ? intval($data['post_id']) : 0;

    if ($post_id > 0 && get_post_status($post_id)) {
        if (wp_trash_post($post_id)) {
            return 'Reload provider with ID ' . $post_id . ' moved to trash successfully.';
        } else {
            return 'Error moving reload provider with ID ' . $post_id . ' to trash.';
        }
    } else {
        return 'Invalid or non-existent post ID provided.';
    }
}
