<?php
/**
 * Template Name: Product sub catagory list
 */
get_header();
if (!is_user_logged_in()) {
    include_once 'template_parts/login_form.php';
} else {
    include_once 'template_parts/sidebar.php';
    include_once 'template_parts/sub_catagory_list.php';
}
get_footer(); ?>