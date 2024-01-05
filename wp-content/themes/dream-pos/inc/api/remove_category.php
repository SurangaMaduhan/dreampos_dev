<?php
add_action('rest_api_init', function () {
    register_rest_route(
        'v1/products/',
        'remove_category',
        array(
            'methods' => 'post',
            'callback' => 'remove_category',
        )
    );
});
function remove_category($data){
    if (isset($data['cat_id'])) {
        $cat_id = intval($data['cat_id']);
        $result = wp_delete_term($cat_id, 'product_cat');

        if (is_wp_error($result)) {
            return array(
                'success' => false,
                'message' => $result->get_error_message(),
            );
        } else {
            return array(
                'success' => true,
                'message' => 'Category deleted successfully.',
            );
        }
    } else {
        return array(
            'success' => false,
            'message' => 'Category ID is required.',
        );
    }
}