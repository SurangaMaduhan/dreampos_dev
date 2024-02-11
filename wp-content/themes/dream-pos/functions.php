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
require_once 'inc/api/remove_order.php';
require_once 'inc/api/add_reload_provider.php';
require_once 'inc/api/remove_reload_providers.php';
require_once 'inc/api/top_up_reload.php';
require_once 'inc/api/add_reload.php';
require_once 'inc/api/remove_reload.php';
require_once 'inc/api/update_reload.php';
require_once 'inc/api/reload_status_update.php';
require_once 'inc/api/add_card.php';
require_once 'inc/api/remove_card.php';
require_once 'inc/api/update_cards.php';
require_once 'inc/api/top_up_cards.php';
require_once 'inc/api/add_cards_sale.php';
require_once 'inc/api/index_all.php';



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

function enqueue_custom_scripts()
{
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
          // var_dump($thumbnail_url);
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
function ts_empty_cart_action_callback()
{
  // Set quantities to zero for all items in the cart
  foreach (WC()->cart->get_cart() as $cart_item_key => $cart_item) {
    WC()->cart->set_quantity($cart_item_key, 0);
  }
  die();
}

function clear_cart()
{
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

function empty_cart_callback()
{
  clear_cart();
  return 'Cart cleared successfully';
}

function redirect_to_last_page()
{
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

// Add multiple custom meta boxes
function add_custom_meta_boxes()
{
  add_meta_box(
    'reload_amount',         // Unique ID
    'Reload Amount',         // Box title
    'display_reload_amount_box', // Callback function to display the meta box
    'reload_providers',                      // Post type
    'normal',                    // Context (normal, advanced, side)
    'default'                    // Priority (high, core, default, low)
  );

  add_meta_box(
    'reload_commission',         // Unique ID
    'Reload Commission',         // Box title
    'display_reload_commission_box', // Callback function to display the meta box
    'reload_providers',                      // Post type
    'normal',                    // Context (normal, advanced, side)
    'default'                    // Priority (high, core, default, low)
  );

  add_meta_box(
    'commission_type',         // Unique ID
    'Commission type',         // Box title
    'display_commission_type_box', // Callback function to display the meta box
    'reload_providers',                      // Post type
    'normal',                    // Context (normal, advanced, side)
    'default'                    // Priority (high, core, default, low)
  );

  add_meta_box(
    'use_another_provider',         // Unique ID
    'Use Another provider',         // Box title
    'display_use_another_provider_box', // Callback function to display the meta box
    'reload_providers',                      // Post type
    'normal',                    // Context (normal, advanced, side)
    'default'                    // Priority (high, core, default, low)
  );
  
  add_meta_box(
    'existing_provider',         // Unique ID
    'existing provider',         // Box title
    'display_existing_provider_box', // Callback function to display the meta box
    'reload_providers',                      // Post type
    'normal',                    // Context (normal, advanced, side)
    'default'                    // Priority (high, core, default, low)
  );

  add_meta_box(
    'amount',         // Unique ID
    'Reload Amount',         // Box title
    'display_reloads_amount_box', // Callback function to display the meta box
    'reloads',                      // Post type
    'normal',                    // Context (normal, advanced, side)
    'default'                    // Priority (high, core, default, low)
  );

  add_meta_box(
    'provider',         // Unique ID
    'Reload provider',         // Box title
    'display_provider_box', // Callback function to display the meta box
    'reloads',                      // Post type
    'normal',                    // Context (normal, advanced, side)
    'default'                    // Priority (high, core, default, low)
  );

  add_meta_box(
    'status',         // Unique ID
    'Reload status',         // Box title
    'display_status_box', // Callback function to display the meta box
    'reloads',                      // Post type
    'normal',                    // Context (normal, advanced, side)
    'default'                    // Priority (high, core, default, low)
  );

  add_meta_box(
    'reload_item_commission',         // Unique ID
    'Reload item commission',         // Box title
    'display_reload_item_commission_box', // Callback function to display the meta box
    'reloads',                      // Post type
    'normal',                    // Context (normal, advanced, side)
    'default'                    // Priority (high, core, default, low)
  );

  add_meta_box(
    'provider_before_balance',         // Unique ID
    'provider before balance',         // Box title
    'display_provider_before_balance_box', // Callback function to display the meta box
    'reloads',                      // Post type
    'normal',                    // Context (normal, advanced, side)
    'default'                    // Priority (high, core, default, low)
  );

  add_meta_box(
    'provider_after_balance',         // Unique ID
    'provider after balance',         // Box title
    'display_provider_after_balance_box', // Callback function to display the meta box
    'reloads',                      // Post type
    'normal',                    // Context (normal, advanced, side)
    'default'                    // Priority (high, core, default, low)
  );
  

  add_meta_box(
    'amount',         // Unique ID
    'Card amount',         // Box title
    'display_card_amount_box', // Callback function to display the meta box
    'cards',                      // Post type
    'normal',                    // Context (normal, advanced, side)
    'default'                    // Priority (high, core, default, low)
  );

  add_meta_box(
    'card_commission',         // Unique ID
    'Card commission',         // Box title
    'display_card_commission_box', // Callback function to display the meta box
    'cards',                      // Post type
    'normal',                    // Context (normal, advanced, side)
    'default'                    // Priority (high, core, default, low)
  );

  add_meta_box(
    'card_commission_type',         // Unique ID
    'Card commission type',         // Box title
    'display_card_commission_type_box', // Callback function to display the meta box
    'cards',                      // Post type
    'normal',                    // Context (normal, advanced, side)
    'default'                    // Priority (high, core, default, low)
  );

  add_meta_box(
    'card_qut',         // Unique ID
    'Card Quntity',         // Box title
    'display_card_qut_box', // Callback function to display the meta box
    'cards',                      // Post type
    'normal',                    // Context (normal, advanced, side)
    'default'                    // Priority (high, core, default, low)
  );

  add_meta_box(
    'card_provider',         // Unique ID
    'Card provider',         // Box title
    'display_card_provider_box', // Callback function to display the meta box
    'cards',                      // Post type
    'normal',                    // Context (normal, advanced, side)
    'default'                    // Priority (high, core, default, low)
  );

  add_meta_box(
    'sale_amount',         // Unique ID
    'Sale Amount',         // Box title
    'display_sale_amount_box', // Callback function to display the meta box
    'cards_sales',                      // Post type
    'normal',                    // Context (normal, advanced, side)
    'default'                    // Priority (high, core, default, low)
  );

  add_meta_box(
    'sale_commission_amount',         // Unique ID
    'Sale Commission Amount',         // Box title
    'display_sale_commission_amount_box', // Callback function to display the meta box
    'cards_sales',                      // Post type
    'normal',                    // Context (normal, advanced, side)
    'default'                    // Priority (high, core, default, low)
  );

  add_meta_box(
    'sale_item_count',         // Unique ID
    'Sale item Count',         // Box title
    'display_sale_item_count_box', // Callback function to display the meta box
    'cards_sales',                      // Post type
    'normal',                    // Context (normal, advanced, side)
    'default'                    // Priority (high, core, default, low)
  );
  add_meta_box(
    'sale_item_provider',         // Unique ID
    'Sale item provider',         // Box title
    'display_sale_item_provider_box', // Callback function to display the meta box
    'cards_sales',                      // Post type
    'normal',                    // Context (normal, advanced, side)
    'default'                    // Priority (high, core, default, low)
  );
}
add_action('add_meta_boxes', 'add_custom_meta_boxes');

// Display content for custom meta box 1
function display_reload_amount_box($post)
{
  $reload_amount = get_post_meta($post->ID, 'reload_amount', true);
?>
  <input type="text" id="reload_amount" name="reload_amount" value="<?php echo esc_attr($reload_amount); ?>">
<?php
}

// Display content for custom meta box 2
function display_reload_commission_box($post)
{
  $reload_commission = get_post_meta($post->ID, 'reload_commission', true);
?>
  <input type="text" id="reload_commission" name="reload_commission" value="<?php echo esc_attr($reload_commission); ?>" readonly>
<?php
}

function display_commission_type_box($post)
{
  $commission_type = get_post_meta($post->ID, 'commission_type', true);
?>
  <input type="text" id="commission_type" name="commission_type" value="<?php echo esc_attr($commission_type); ?>" readonly>
<?php
}


function display_reloads_amount_box($post)
{
  $amount = get_post_meta($post->ID, 'amount', true);
?>
  <input type="text" id="commission_type" name="amount" value="<?php echo esc_attr($amount); ?>" readonly>
<?php
}

function display_provider_box($post)
{
  $provider = get_post_meta($post->ID, 'provider', true);
?>
  <input type="text" id="commission_type" name="provider" value="<?php echo esc_attr($provider); ?>" readonly>
<?php
}

function display_status_box($post)
{
  $status = get_post_meta($post->ID, 'status', true);
?>
  <input type="text" id="commission_type" name="status" value="<?php echo esc_attr($status); ?>" readonly>
<?php
}

function display_card_amount_box($post)
{
  $amount = get_post_meta($post->ID, 'amount', true);
?>
  <input type="text" id="amount" name="status" value="<?php echo esc_attr($amount); ?>" readonly>
<?php
}

function display_reload_item_commission_box($post)
{
  $reload_item_commission = get_post_meta($post->ID, 'reload_item_commission', true);
?>
  <input type="text" id="reload_item_commission" name="reload_item_commission" value="<?php echo esc_attr($reload_item_commission); ?>" readonly>
<?php
}

function display_provider_before_balance_box($post)
{
  $provider_before_balance = get_post_meta($post->ID, 'provider_before_balance', true);
?>
  <input type="text" id="provider_before_balance" name="provider_before_balance" value="<?php echo esc_attr($provider_before_balance); ?>" readonly>
<?php
}

function display_provider_after_balance_box($post)
{
  $amount = get_post_meta($post->ID, 'amount', true);
?>
  <input type="text" id="amount" name="amount" value="<?php echo esc_attr($amount); ?>" readonly>
<?php
}

function display_card_commission_box($post)
{
  $card_commission = get_post_meta($post->ID, 'card_commission', true);
?>
  <input type="text" id="card_commission" name="card_commission" value="<?php echo esc_attr($card_commission); ?>" readonly>
<?php
}

function display_card_commission_type_box($post)
{
  $card_commission_type = get_post_meta($post->ID, 'card_commission_type', true);
?>
  <input type="text" id="card_commission_type" name="card_commission_type" value="<?php echo esc_attr($card_commission_type); ?>" readonly>
<?php
}
function display_card_qut_box($post)
{
  $card_qut = get_post_meta($post->ID, 'card_qut', true);
?>
  <input type="text" id="card_qut" name="card_qut" value="<?php echo esc_attr($card_qut); ?>" readonly>
<?php
}
function display_card_provider_box($post)
{
  $card_provider = get_post_meta($post->ID, 'card_provider', true);
?>
  <input type="text" id="card_provider" name="card_provider" value="<?php echo esc_attr($card_provider); ?>" readonly>
<?php
}
function display_sale_amount_box($post)
{
  $sale_amount = get_post_meta($post->ID, 'sale_amount', true);
?>
  <input type="text" id="sale_amount" name="sale_amount" value="<?php echo esc_attr($sale_amount); ?>" readonly>
<?php
}
function display_sale_commission_amount_box($post)
{
  $sale_commission_amount = get_post_meta($post->ID, 'sale_commission_amount', true);
?>
  <input type="text" id="sale_commission_amount" name="sale_commission_amount" value="<?php echo esc_attr($sale_commission_amount); ?>" readonly>
<?php
}
function display_sale_item_count_box($post)
{
  $sale_item_count = get_post_meta($post->ID, 'sale_item_count', true);
?>
  <input type="text" id="sale_item_count" name="sale_item_count" value="<?php echo esc_attr($sale_item_count); ?>" readonly>
<?php
}
function display_sale_item_provider_box($post)
{
  $sale_item_provider = get_post_meta($post->ID, 'sale_item_provider', true);
?>
  <input type="text" id="sale_item_provider" name="sale_item_provider" value="<?php echo esc_attr($sale_item_provider); ?>" readonly>
<?php
}

function display_use_another_provider_box($post)
{
  $use_another_provider = get_post_meta($post->ID, 'use_another_provider', true);
?>
  <input type="text" id="use_another_provider" name="use_another_provider" value="<?php echo esc_attr($use_another_provider); ?>" readonly>
<?php
}

function display_existing_provider_box($post)
{
  $existing_provider = get_post_meta($post->ID, 'existing_provider', true);
?>
  <input type="text" id="existing_provider" name="existing_provider" value="<?php echo esc_attr($existing_provider); ?>" readonly>
<?php
}
// Save custom meta box values
function save_custom_meta_boxes($post_id)
{
  if (array_key_exists('reload_commission', $_POST)) {
    update_post_meta(
      $post_id,
      'reload_commission',
      sanitize_text_field($_POST['reload_commission'])
    );
  }

  if (array_key_exists('reload_amount', $_POST)) {
    update_post_meta(
      $post_id,
      'reload_amount',
      sanitize_text_field($_POST['reload_amount'])
    );
  }

  if (array_key_exists('commission_type', $_POST)) {
    update_post_meta(
      $post_id,
      'commission_type',
      sanitize_text_field($_POST['commission_type'])
    );
  }

  if (array_key_exists('amount', $_POST)) {
    update_post_meta(
      $post_id,
      'amount',
      sanitize_text_field($_POST['amount'])
    );
  }

  if (array_key_exists('provider', $_POST)) {
    update_post_meta(
      $post_id,
      'provider',
      sanitize_text_field($_POST['provider'])
    );
  }

  if (array_key_exists('status', $_POST)) {
    update_post_meta(
      $post_id,
      'status',
      sanitize_text_field($_POST['status'])
    );
  }

  if (array_key_exists('reload_item_commission', $_POST)) {
    update_post_meta(
      $post_id,
      'reload_item_commission',
      sanitize_text_field($_POST['reload_item_commission'])
    );
  }

  if (array_key_exists('provider_before_balance', $_POST)) {
    update_post_meta(
      $post_id,
      'provider_before_balance',
      sanitize_text_field($_POST['provider_before_balance'])
    );
  }

  if (array_key_exists('provider_after_balance', $_POST)) {
    update_post_meta(
      $post_id,
      'provider_after_balance',
      sanitize_text_field($_POST['provider_after_balance'])
    );
  }

  if (array_key_exists('amount', $_POST)) {
    update_post_meta(
      $post_id,
      'amount',
      sanitize_text_field($_POST['amount'])
    );
  }

  if (array_key_exists('card_commission', $_POST)) {
    update_post_meta(
      $post_id,
      'card_commission',
      sanitize_text_field($_POST['card_commission'])
    );
  }

  if (array_key_exists('card_commission_type', $_POST)) {
    update_post_meta(
      $post_id,
      'card_commission_type',
      sanitize_text_field($_POST['card_commission_type'])
    );
  }

  if (array_key_exists('card_qut', $_POST)) {
    update_post_meta(
      $post_id,
      'card_qut',
      sanitize_text_field($_POST['card_qut'])
    );
  }

  if (array_key_exists('card_provider', $_POST)) {
    update_post_meta(
      $post_id,
      'card_provider',
      sanitize_text_field($_POST['card_qut'])
    );
  }

  if (array_key_exists('sale_amount', $_POST)) {
    update_post_meta(
      $post_id,
      'sale_amount',
      sanitize_text_field($_POST['sale_amount'])
    );
  }

  if (array_key_exists('sale_commission_amount', $_POST)) {
    update_post_meta(
      $post_id,
      'sale_commission_amount',
      sanitize_text_field($_POST['sale_commission_amount'])
    );
  }
  if (array_key_exists('sale_item_count', $_POST)) {
    update_post_meta(
      $post_id,
      'sale_item_count',
      sanitize_text_field($_POST['sale_item_count'])
    );
  }
  if (array_key_exists('sale_item_provider', $_POST)) {
    update_post_meta(
      $post_id,
      'sale_item_provider',
      sanitize_text_field($_POST['sale_item_provider'])
    );
  }

  if (array_key_exists('use_another_provider', $_POST)) {
    update_post_meta(
      $post_id,
      'use_another_provider',
      sanitize_text_field($_POST['use_another_provider'])
    );
  }

  if (array_key_exists('existing_provider', $_POST)) {
    update_post_meta(
      $post_id,
      'existing_provider',
      sanitize_text_field($_POST['existing_provider'])
    );
  }
}
add_action('save_post', 'save_custom_meta_boxes');


// Hook for handling custom AJAX action
add_action('wp_ajax_custom_index_posts', 'custom_index_posts');

// Function to trigger Relevanssi indexing
function custom_index_posts() {
    // Check nonce for security
    check_ajax_referer('custom_index_nonce', 'security');

    // Trigger Relevanssi indexing
    do_action('relevanssi_count_missing_posts');

    // Return a response (optional)
    echo 'Indexing started...';

    // Always exit to avoid extra output
    wp_die();
}