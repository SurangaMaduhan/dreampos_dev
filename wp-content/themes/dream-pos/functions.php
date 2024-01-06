<?php
add_filter('show_admin_bar', '__return_false');

require_once(ABSPATH . 'wp-admin/includes/image.php');
require_once(ABSPATH . 'wp-admin/includes/file.php');
require_once(ABSPATH . 'wp-admin/includes/media.php');

require_once 'inc/api/add_product.php';
require_once 'inc/api/add_category.php';
require_once 'inc/api/remove_category.php';
require_once 'inc/api/add_brand.php';
require_once 'inc/api/remove_product.php';
require_once 'inc/api/update_product.php';
require_once 'inc/api/update_category.php';
require_once 'inc/api/update_brand.php';
require_once 'inc/api/remove_brand.php';


function enqueue_custom_styles() {
  wp_enqueue_style('style', get_stylesheet_uri());
  
}

add_action('wp_enqueue_scripts', 'enqueue_custom_styles');


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

// Display custom field in general tab
add_action('woocommerce_product_options_general_product_data', 'custom_product_field');

function custom_product_field()
{
  global $post;

  echo '<div class="options_group">';

  // Custom field
  woocommerce_wp_text_input(
    array(
      'id' => '_cost',
      'label' => __('Cost Product', 'dreampos'),
      'placeholder' => '',
      'type' => 'number',
      'desc_tip' => 'true',
      'description' => __('Enter the custom field value here.', 'dreampos'),
    )
  );

  echo '</div>';
}

// Save custom field data
add_action('woocommerce_process_product_meta', 'save_custom_product_field');

function save_custom_product_field($post_id)
{
  // Save custom field
  $custom_field = $_POST['_cost'];
  if (!empty($custom_field)) {
    update_post_meta($post_id, '_cost', sanitize_text_field($custom_field));
  }
}

function wporg_register_taxonomy_course() {
  $labels = array(
      'name'              => _x( 'Brands', 'taxonomy general name' ),
      'singular_name'     => _x( 'Brand', 'taxonomy singular name' ),
      'search_items'      => __( 'Search Brands' ),
      'all_items'         => __( 'All Brands' ),
      'parent_item'       => __( 'Parent Brands' ),
      'parent_item_colon' => __( 'Parent Brands:' ),
      'edit_item'         => __( 'Edit Brand' ),
      'update_item'       => __( 'Update Brand' ),
      'add_new_item'      => __( 'Add New Brand' ),
      'new_item_name'     => __( 'New Brand Name' ),
      'menu_name'         => __( 'Brands' ),
  );
  $args   = array(
      'hierarchical'      => true, // make it hierarchical (like categories)
      'labels'            => $labels,
      'show_ui'           => true,
      'show_admin_column' => true,
      'query_var'         => true,
      'rewrite'           => [ 'slug' => 'brands' ],
  );
  register_taxonomy( 'brands', [ 'product' ], $args );
}
add_action( 'init', 'wporg_register_taxonomy_course' );

