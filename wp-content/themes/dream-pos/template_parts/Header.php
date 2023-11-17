<header class="main__header">
    <div class="logo">
        <img src="<?php echo get_bloginfo('template_directory'); ?>/src/img/Freedom-logo.png" alt="Freedom-logo">
    </div>
    <div class="logOut">
        <div class="pos__admin">
            <span class="user__icon">
                <img src="<?php echo get_bloginfo('template_directory'); ?>/src/img/programmer.png" alt="<?php echo $current_user->user_login; ?>">
            </span>
            <span><?php echo $current_user->user_login; ?></span>
        </div>
        <div class="pos__admin_dropdown">
            <a href="<?php echo wp_logout_url();?>">Log Out</a>
        </div>
    </div>
</header>