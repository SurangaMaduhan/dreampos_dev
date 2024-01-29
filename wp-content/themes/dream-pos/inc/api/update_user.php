<?php
add_action('rest_api_init', function () {
    register_rest_route(
        'v1/',
        'update-user',
        array(
            'methods' => 'POST',
            'callback' => 'update_user',
        )
    );
});

function update_user($request)
{
    $user_id = $request->get_param('user_id');
    $first_name = $request->get_param('firstName');
    $last_name = $request->get_param('lastName');
    $password = $request->get_param('password');
    $user_role = $request->get_param('role');

    // Additional validation and sanitation here

    // Update user information
    $user_data = array(
        'ID' => $user_id,
    );

    if ($first_name) {
        $user_data['first_name'] = $first_name;
    }

    if ($last_name) {
        $user_data['last_name'] = $last_name;
    }

    if ($password) {
        $user_data['user_pass'] = $password;
    }

    // Update user data
    $result = wp_update_user($user_data);

    if (is_wp_error($result)) {
        return new WP_Error('update_error', $result->get_error_message(), array('status' => 400));
    }

    // Update user role
    if ($user_role) {
        $user = new WP_User($user_id);
        $user->set_role($user_role);
    }

    return array('status' => 'success', 'message' => 'User updated successfully.');
}
