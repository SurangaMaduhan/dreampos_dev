<?php
add_filter('show_admin_bar', '__return_false');

require_once(ABSPATH . 'wp-admin/includes/image.php');
require_once(ABSPATH . 'wp-admin/includes/file.php');
require_once(ABSPATH . 'wp-admin/includes/media.php');

require_once 'inc/api/add_product.php';

function redirect_login_page()
{

  $login_page = home_url('/');
  $page_viewed = basename($_SERVER['REQUEST_URI']);

  if ($page_viewed == "wp-login.php" && $_SERVER['REQUEST_METHOD'] == 'GET') {
    wp_redirect($login_page);
    exit;
  }
}
add_action('init', 'redirect_login_page');

function login_failed()
{

  $login_page = home_url('/');
  wp_redirect($login_page . '?user-login=failed');
  exit;
}
add_action('wp_login_failed', 'login_failed');

function verify_username_password($user, $username, $password)
{

  $login_page = home_url('/');
  if ($username == "" || $password == "") {
    wp_redirect($login_page . "?user-login=empty");
    exit;
  }
}
add_filter('authenticate', 'verify_username_password', 1, 3);

function logout_page()
{

  $login_page = home_url('/');
  wp_redirect($login_page . "?user-login=false");
  exit;
}
add_action('wp_logout', 'logout_page');


function wpb_custom_new_menu()
{
  register_nav_menu('main-menu', __('Main Menu'));
}
add_action('init', 'wpb_custom_new_menu');

function mytheme_add_woocommerce_support()
{
  add_theme_support('woocommerce');
}
add_action('after_setup_theme', 'mytheme_add_woocommerce_support');

function custom_mini_cart()
{
  echo '<ul class="dropdown-menu-mini-cart">';
  echo '<li> <div class="widget_shopping_cart_content">';
  woocommerce_mini_cart();
  echo '</div></li></ul>';

}
add_shortcode('custom-techno-mini-cart', 'custom_mini_cart');

