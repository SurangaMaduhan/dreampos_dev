<?php
/**
 * Template Name: Add Reload Providers
 */
get_header();
if (!is_user_logged_in()) {
    include_once 'template_parts/login_form.php';
} else {
    include_once 'template_parts/sidebar.php';
    include_once 'template_parts/add_reload_provider.php';
}
get_footer(); ?>