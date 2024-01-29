<?php
add_action('rest_api_init', function () {
    register_rest_route(
        'v1/',
        'add-user',
        array(
            'methods' => 'post',
            'callback' => 'add_new_user',
        )
    );
});

function add_new_user($data)
{
    $first_name = $data->get_param('firstName');
    $last_name = $data->get_param('lastName');
    $username = $data->get_param('username');
    $email = strtolower(str_replace(' ', '', $first_name)) . '' . strtolower(str_replace(' ', '', $last_name)) . '@dm.loc';
    $password = $data->get_param('password');
    $user_role = $data->get_param('role'); // Assuming you pass the role from the form

    // Additional validation and sanitation here

    // Create user without specifying the role initially
    $user_id = wp_create_user($username, $password, $email);

    if (is_wp_error($user_id)) {
        return new WP_Error('registration_error', $user_id->get_error_message(), array('status' => 400));
    }


    $user = new WP_User($user_id);
    $user->set_role($user_role);
    update_user_meta($user_id, 'first_name', $first_name);
    update_user_meta($user_id, 'last_name', $last_name);


    return array('status' => 'success', 'message' => 'User registered successfully.');
}
