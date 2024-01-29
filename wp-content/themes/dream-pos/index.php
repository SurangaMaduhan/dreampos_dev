<?php get_header(); ?>
<?php if (!is_user_logged_in()) { ?>
    <div id="login__wrapper">
        <div class="login-form">
            <span class="login100-form-title p-b-26">
                Welcome
            </span>
            <img src="<?php echo get_template_directory_uri() ?>/src/img/logo.png" alt="Freedom-logo">
            <?php
            $args = array(
                'echo' => true,
                'redirect' => '/test',
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
                <p>Powered by <a href="#">test</a></p>sdsdf
            </div>
        </div>
    </div>
<?php } else { ?>
    <?php the_content(); ?>
<?php } ?>
<?php get_footer(); ?>