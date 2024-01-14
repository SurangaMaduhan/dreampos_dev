<?php
/**
 * Template Name: POS Temp
 */
get_header();
if (!is_user_logged_in()) {
    include_once 'template_parts/login_form.php';
} else {
    include_once 'template_parts/pos-content.php';
} get_footer(); ?>