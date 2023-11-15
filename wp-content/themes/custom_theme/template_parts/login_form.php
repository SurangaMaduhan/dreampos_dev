<div id="login__wrapper">
    <div class="login-form">
        <img src="<?php echo get_template_directory_uri() ?>/src/img/Freedom-logo.png" alt="Freedom-logo">
        <?php

        $args = array(
            'echo' => true,
            'redirect' => '/',
            'form_id' => 'loginform',
            'label_username' => 'Username',
            'label_password' => 'Password',
            'label_remember' => 'Remember Me',
            'label_log_in' => 'Log In',
            'id_username' => 'user_login',
            'id_password' => 'user_pass',
            'id_remember' => 'rememberme',
            'id_submit' => 'wp-submit',
            'remember' => true,
            'value_username' => '',
            'value_remember' => false,
        );
        wp_login_form($args);
        ?>
        <div class="powerd__by">
            <p>Powered by <a href="#">test</a></p>
        </div>
    </div>
</div>