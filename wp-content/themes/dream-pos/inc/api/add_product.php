<?php

require_once(ABSPATH . 'wp-admin/includes/image.php');
require_once(ABSPATH . 'wp-admin/includes/file.php');
require_once(ABSPATH . 'wp-admin/includes/media.php');

add_action('rest_api_init', function () {
    register_rest_route(
        'v1/products/',
        'add-new-product',
        array(
            'methods' => 'post',
            'callback' => 'add_new_product',
        )
    );
});

function add_new_product($product)
{
    $titleFor = $product['product_title'].' ('.$_POST['product_sku'].')';
    $product_data = array(
        'post_title' => sanitize_text_field($titleFor),
        'post_content' => $product['product_description'],
        'post_status' => 'publish',
        'post_type' => 'product',
    );

    $product_id = wp_insert_post($product_data);
    $product = wc_get_product($product_id);

    $term = get_term_by('slug', $_POST['product_category'], 'product_cat');
    // $term_brands = get_term_by('slug', $_POST['product_brand'], 'brands');

    wp_set_object_terms($product_id, $term->term_id, 'product_cat');

    // wp_set_object_terms($product_id, $term_brands->term_id, 'brands');

    $product->set_regular_price(sanitize_text_field($_POST['product_price']));

    update_post_meta($product_id, '_sku', $_POST['product_sku']);
    update_post_meta($product_id, '_cost', $_POST['product_cost']);
    update_post_meta($product_id, '_stock', sanitize_text_field($_POST['quantity']));
    update_post_meta($product_id, '_manage_stock', 'yes');

    if(sanitize_text_field($_POST['quantity']) > 0 ){
        update_post_meta($product_id, '_stock_status', 'instock');
    } else{
        update_post_meta($product_id, '_stock_status', 'outofstock');
    }
    

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
    $response = $product->save();

    return $response;
}