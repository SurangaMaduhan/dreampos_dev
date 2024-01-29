<?php
require_once(ABSPATH . 'wp-admin/includes/user.php');
add_action('rest_api_init', function () {
    register_rest_route(
        'v1/',
        'remove-user',
        array(
            'methods' => 'POST',
            'callback' => 'remove_user',
        )
    );
});
function remove_user($data){
    $user_id = $data->get_param('user_id');
    if (!empty($user_id)) {
        $result = wp_delete_user($user_id);
        return $result;
        if ($result instanceof WP_Error) {
            return array('status' => 'error', 'message' => $result->get_error_message());
        } else {
            return array('status' => 'success', 'message' => 'User deleted successfully.');
        }
    } else {
        return array('status' => 'error', 'message' => 'Invalid user ID.');
    }
}