<?php
require_once(ABSPATH . 'wp-admin/includes/image.php');
require_once(ABSPATH . 'wp-admin/includes/file.php');
require_once(ABSPATH . 'wp-admin/includes/media.php');

add_action('rest_api_init', function () {
    register_rest_route(
        'v1/reload/',
        'add-reload-provider',
        array(
            'methods' => 'POST',
            'callback' => 'add_reload_provider',
        )
    );
});

function add_reload_provider($data) {
    $title = sanitize_text_field($data['title']);
    // $content = wp_kses_post($data['content']);

    $new_post = array(
        'post_title'    => $title,
        // 'post_content'  => $content,
        'post_type'     => 'reload_providers',
        'post_status'   => 'publish',
    );

    $post_id = wp_insert_post($new_post);

    if (!is_wp_error($post_id)) {
        // Handle featured image
        if ($_FILES['thumbnail']['error'] == 0) {
            // Handle the file upload and get the attachment ID
            $attachment_id = media_handle_upload('thumbnail', $post_id);
    
            if (is_wp_error($attachment_id)) {
                // Handle the error if the upload fails
                echo "Error uploading image: " . $attachment_id->get_error_message();
            } else {
                // Set the attachment as the featured image for the product
                set_post_thumbnail($post_id, $attachment_id);
            }
        }

        // Handle custom post meta
        if (isset($data['reload_amount']) && !empty($data['reload_amount'])) {
            foreach ($data['reload_amount'] as $meta_key => $meta_value) {
                update_post_meta($post_id, $meta_key, sanitize_text_field($meta_value));
            }
        }

        if (isset($data['reload_commission']) && !empty($data['reload_commission'])) {
            foreach ($data['reload_commission'] as $meta_key => $meta_value) {
                update_post_meta($post_id, $meta_key, sanitize_text_field($meta_value));
            }
        }

        if (isset($data['commission_type']) && !empty($data['commission_type'])) {
            foreach ($data['commission_type'] as $meta_key => $meta_value) {
                update_post_meta($post_id, $meta_key, sanitize_text_field($meta_value));
            }
        }

        return 'Reload provider added successfully with ID: ' . $post_id;
    } else {
        return 'Error adding reload provider: ' . $post_id->get_error_message();
    }
}
