<?php
/**
 * Template Name: View Products
 */
get_header();
if (!is_user_logged_in()) {
    include_once 'template_parts/login_form.php';
} else {
    include_once 'template_parts/sidebar.php';
    include_once 'template_parts/view_product_content.php';
}
get_footer(); ?>