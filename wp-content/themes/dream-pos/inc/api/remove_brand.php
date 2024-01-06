<?php
add_action('rest_api_init', function () {
    register_rest_route(
        'v1/products/',
        'remove_brand',
        array(
            'methods' => 'post',
            'callback' => 'remove_brand',
        )
    );
});
function remove_brand($data){
    if (isset($data['cat_id'])) {
        $cat_id = intval($data['cat_id']);
        $result = wp_delete_term($cat_id, 'brands');

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