<?php
/**
 * Template Name: Reload Providers list
 */
get_header();
if (!is_user_logged_in()) {
    include_once 'template_parts/login_form.php';
} else {
    include_once 'template_parts/sidebar.php';
    include_once 'template_parts/reload_provider_list.php';
}
get_footer(); ?>