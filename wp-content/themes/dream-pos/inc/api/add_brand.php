<?php
require_once(ABSPATH . 'wp-admin/includes/image.php');
require_once(ABSPATH . 'wp-admin/includes/file.php');
require_once(ABSPATH . 'wp-admin/includes/media.php');

add_action('rest_api_init', function () {
    register_rest_route(
        'v1/products/',
        'add-brand',
        array(
            'methods' => 'post',
            'callback' => 'add_brand',
        )
    );
});
function add_brand($brand)
{
    $category_name = sanitize_text_field($_POST['brand_name']);
    $thumbnail = $_FILES['thumbnail'];
    $result = wp_insert_term(
        $category_name,
        'brands'
    );

    if (is_wp_error($result)) {
        return 'Error adding/updating category: ' . $result->get_error_message();
    } else {
        $category_id = $result['term_id'];

        if ($thumbnail['error'] == 0) {
            $thumbnail_id = media_handle_upload('thumbnail', $category_id);
            if (!is_wp_error($thumbnail_id)) {
                // Update category image using Categories Images plugin functions
                update_option('z_taxonomy_image_id'.$category_id, absint($thumbnail_id));
                update_option('z_taxonomy_image'.$category_id, wp_get_attachment_url($thumbnail_id));

                return 'Category updated successfully with thumbnail.';
            } else {
                return 'Error uploading thumbnail: ' . $thumbnail_id->get_error_message();
            }
        } else {
            return 'Category updated successfully without thumbnail.';
        }
    }
}