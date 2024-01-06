<?php
require_once(ABSPATH . 'wp-admin/includes/image.php');
require_once(ABSPATH . 'wp-admin/includes/file.php');
require_once(ABSPATH . 'wp-admin/includes/media.php');

add_action('rest_api_init', function () {
    register_rest_route(
        'v1/products/',
        'update-category',
        array(
            'methods' => 'post',
            'callback' => 'update_category',
        )
    );
});

function update_category($category)
{
    $category_name = sanitize_text_field($_POST['category_name']);
    $category_id = sanitize_text_field($_POST['category_id']);
    $thumbnail = $_FILES['thumbnail'];

    // Check if the category already exists
    $existing_category = get_term_by('term_id', $category_id, 'product_cat');

    if ($existing_category) {
        // Category exists, update its details
        $category_id = $existing_category->term_id;
        $result = wp_update_term($category_id, 'product_cat', array('name' => $category_name));

        if (is_wp_error($result)) {
            return 'Error updating category: ' . $result->get_error_message();
        }
    } else {
        // Category doesn't exist, create a new one
        $result = wp_insert_term($category_name, 'product_cat');

        if (is_wp_error($result)) {
            return 'Error adding category: ' . $result->get_error_message();
        }

        $category_id = $result['term_id'];
    }

    // Handle thumbnail upload
    if ($thumbnail['error'] == 0) {
        $thumbnail_id = media_handle_upload('thumbnail', $category_id);
        if (!is_wp_error($thumbnail_id)) {
            update_woocommerce_term_meta($category_id, 'thumbnail_id', absint($thumbnail_id));
            return 'Category updated successfully with thumbnail.';
        } else {
            return 'Error uploading thumbnail: ' . $thumbnail_id->get_error_message();
        }
    } else {
        return 'Category updated successfully without thumbnail.';
    }
}
