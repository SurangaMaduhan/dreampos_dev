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

require_once 'inc/api/update_category.php';
require_once 'inc/api/import_products.php';
require_once 'inc/api/update_brand.php';
require_once 'inc/api/remove_brand.php';
require_once 'inc/api/new_orders.php';
require_once 'inc/api/update_order.php';
require_once 'inc/api/update_product.php';
require_once 'inc/api/add_user.php';
require_once 'inc/api/remove_user.php';
require_once 'inc/api/update_user.php';
require_once 'inc/api/export_products.php';
require_once 'inc/api/import_purchase.php';



function enqueue_custom_styles()
{
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

function enqueue_custom_scripts() {
  // Enqueue your custom script
  wp_enqueue_script('woocommerce');
  wp_enqueue_script('wc-cart-fragments', null, array('jquery'), '', true);
}

add_action('wp_enqueue_scripts', 'enqueue_custom_scripts');


function custom_mini_cart()
{
  echo '<div class="widget_shopping_cart_content">';
  woocommerce_mini_cart();
  echo '</div>';
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

function wporg_register_taxonomy_course()
{
  $labels = array(
    'name' => _x('Brands', 'taxonomy general name'),
    'singular_name' => _x('Brand', 'taxonomy singular name'),
    'search_items' => __('Search Brands'),
    'all_items' => __('All Brands'),
    'parent_item' => __('Parent Brands'),
    'parent_item_colon' => __('Parent Brands:'),
    'edit_item' => __('Edit Brand'),
    'update_item' => __('Update Brand'),
    'add_new_item' => __('Add New Brand'),
    'new_item_name' => __('New Brand Name'),
    'menu_name' => __('Brands'),
  );
  $args = array(
    'hierarchical' => true, // make it hierarchical (like categories)
    'labels' => $labels,
    'show_ui' => true,
    'show_admin_column' => true,
    'query_var' => true,
    'rewrite' => ['slug' => 'brands'],
  );
  register_taxonomy('brands', ['product'], $args);
}
add_action('init', 'wporg_register_taxonomy_course');


add_action('wp_loaded', 'woocommerce_empty_cart_action', 20);
function woocommerce_empty_cart_action()
{
  if (isset($_GET['empty_cart']) && 'yes' === esc_html($_GET['empty_cart'])) {
    WC()->cart->empty_cart();

    $referer = wc_get_cart_url();
    wp_safe_redirect($referer);
  }
}

function update_mini_cart_callback()
{
  if (isset($_POST['cart_key']) && isset($_POST['quantity'])) {
    $cart_key = sanitize_text_field($_POST['cart_key']);
    $quantity = wc_stock_amount(wc_clean($_POST['quantity']));

    WC()->cart->set_quantity($cart_key, $quantity);
    WC()->cart->calculate_totals();

    // Output the updated mini cart content
    woocommerce_mini_cart();
    die();
  }
}
add_action('wp_ajax_update_mini_cart', 'update_mini_cart_callback');
add_action('wp_ajax_nopriv_update_mini_cart', 'update_mini_cart_callback');

add_filter('facetwp_render_output', function ($output, $params) {
  // Check if 'categories_list' facet exists in the output
  if (isset($output['facets']['categories_list'])) {
    $categoriesHTML = $output['facets']['categories_list'];

    // Modify the 'categories_list' HTML for styled radio buttons
    $categoriesHTML = preg_replace_callback(
      '/<div class="facetwp-radio(?: checked)?(?: disabled)?" data-value="(.*?)".*?><span class="facetwp-display-value">(.*?)<\/span><span class="facetwp-counter">\((\d+)\)<\/span><\/div>/',
      function ($matches) use ($params) {
        $category_slug = $matches[1];
        $category_name = $matches[2];
        $category_count = $matches[3];


        $term = get_term_by('slug', $category_slug, 'product_cat');
        $thumbnail_url = '';
        if ($term && !is_wp_error($term)) {
          $thumbnail_id = get_woocommerce_term_meta($term->term_id, 'thumbnail_id', true);
          $thumbnail_url = wp_get_attachment_thumb_url($thumbnail_id);
          $is_selected = in_array($category_slug, $params['facets'][1]['selected_values']);
        } else {
          $term = get_term_by('slug', $params['facets'][1]['selected_values'][0], 'product_cat');

          $thumbnail_id = get_woocommerce_term_meta($term->term_id, 'thumbnail_id', true);

          $thumbnail_url = wp_get_attachment_thumb_url($thumbnail_id);
          $is_selected = in_array($category_slug, $params['facets'][1]['selected_values']);
          var_dump($thumbnail_url);
        }

        $checked_attr = $is_selected ? 'checked' : '';
        return '<div class="facetwp-radio ' . $checked_attr . '" data-value="' . $category_slug . '"><div class="bc_items" style="background:url(' . $thumbnail_url . ');"><span class="facetwp-display-value">' . $category_name . '</span> <i>' . $category_count . '</i></div></div>';
      },
      $categoriesHTML
    );

    // Update the 'categories_list' HTML in the output
    $output['facets']['categories_list'] = $categoriesHTML;
  }

  return $output;
}, 10, 2);


add_action('wp_ajax_empty_cart_action', 'ts_empty_cart_action_callback');
add_action('wp_ajax_nopriv_empty_cart_action', 'ts_empty_cart_action_callback');
function ts_empty_cart_action_callback() {
    // Set quantities to zero for all items in the cart
    foreach ( WC()->cart->get_cart() as $cart_item_key => $cart_item ) {
        WC()->cart->set_quantity( $cart_item_key, 0 );
    }
    die();
}

function clear_cart() {
  if (function_exists('WC')) {
      WC()->cart->empty_cart();
      error_log('Cart emptied successfully', 0);
  } else {
      error_log('WooCommerce not active', 0);
  }
}

add_action('rest_api_init', function () {
  register_rest_route(
      'v1',
      '/products/empty-cart',
      array(
          'methods' => 'POST',
          'callback' => 'empty_cart_callback',
      )
  );
});

function empty_cart_callback() {
  clear_cart();
  return 'Cart cleared successfully';
}

function redirect_to_last_page() {
  // Check if the current request is a single product page
  if (is_product()) {
      // Get the referrer (last visited page)
      $referrer = wp_get_referer();

      // If a referrer is found, redirect to the last visited page
      if ($referrer) {
          wp_safe_redirect($referrer);
          exit;
      } else {
          // If no referrer is found, redirect to the home page or any other desired page
          wp_safe_redirect(home_url('/'));
          exit;
      }
  }
}

// Hook the function to the template_redirect action
add_action('template_redirect', 'redirect_to_last_page');