<?php
require_once(ABSPATH . 'wp-admin/includes/image.php');
require_once(ABSPATH . 'wp-admin/includes/file.php');
require_once(ABSPATH . 'wp-admin/includes/media.php');

add_action('rest_api_init', function () {
    register_rest_route(
        'products/v1/',
        'update-product',
        array(
            'methods' => 'post',
            'callback' => 'update_product',
        )
    );
});

function update_product($product)
{
    $product_data = array(
        'post_title' => sanitize_text_field($product['product_title']),
        'post_content' => $product['product_description'],
        'post_status' => 'publish',
        'post_type' => 'product',
    );

    $product_id = wp_insert_post($product_data);
    update_post_meta($product_id, '_regular_price', sanitize_text_field($_POST['product_price']));
    update_post_meta($product_id, '_sku', sanitize_text_field($_POST['product_sku']));

    update_post_meta($product_id, '_manage_stock', 'yes');
    update_post_meta($product_id, '_stock', 5);
    update_post_meta($product_id, '_stock_status', 'instock');


    // Check if the file was uploaded successfully
    if ($_FILES['product_image']['error'] == 0) {
        // Handle the file upload and get the attachment ID
        $attachment_id = media_handle_upload('product_image', $product_id);

        if (is_wp_error($attachment_id)) {
            // Handle the error if the upload fails
            echo "Error uploading image: " . $attachment_id->get_error_message();
        } else {
            // Set the attachment as the featured image for the product
            set_post_thumbnail($product_id, $attachment_id);
        }
    }

    exit;
}