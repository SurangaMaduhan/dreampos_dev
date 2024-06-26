<?php

/**
 * Mini-cart
 *
 * Contains the markup for the mini-cart, used by the cart widget.
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/cart/mini-cart.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see     https://docs.woocommerce.com/document/template-structure/
 * @package WooCommerce\Templates
 * @version 7.9.0
 */

defined('ABSPATH') || exit;

do_action('woocommerce_before_mini_cart'); ?>

<?php if (!WC()->cart->is_empty()) : ?>
    <div class="totalitem">
        <h4>Total items :
            <?php echo WC()->cart->get_cart_contents_count(); ?></h4>
        <button type="button" id="clear_cart" class="button" title="<?php echo esc_attr('Empty Cart', 'woocommerce'); ?>"><img src="<?php echo get_bloginfo('template_directory'); ?>/src/img/delete-2.svg" alt="img"> <?php echo esc_html('Empty cart', 'woocommerce'); ?></button>
    </div>
    <div class="product-table">
        <div class="mini_loder" style="display:none">
            <div class="whirly-loader"> </div>
        </div>
        <?php
        do_action('woocommerce_before_mini_cart_contents');

        $product_cost = 0;

        foreach (WC()->cart->get_cart() as $cart_item_key => $cart_item) {
            $_product = apply_filters('woocommerce_cart_item_product', $cart_item['data'], $cart_item, $cart_item_key);
            $product_id = apply_filters('woocommerce_cart_item_product_id', $cart_item['product_id'], $cart_item, $cart_item_key);

            $pCost = floatval($_product->get_meta('_cost', true)); // Assuming _cost is a numeric value
            $quantity = $cart_item['quantity'];
            $totalCost = $pCost * $quantity;

            $product_cost = $product_cost + $totalCost;



            if ($_product && $_product->exists() && $cart_item['quantity'] > 0 && apply_filters('woocommerce_widget_cart_item_visible', true, $cart_item, $cart_item_key)) {
                /**
                 * This filter is documented in woocommerce/templates/cart/cart.php.
                 *
                 * @since 2.1.0
                 */
                $product_name = apply_filters('woocommerce_cart_item_name', $_product->get_name(), $cart_item, $cart_item_key);
                $thumbnail = apply_filters('woocommerce_cart_item_thumbnail', $_product->get_image(), $cart_item, $cart_item_key);
                $product_price = apply_filters('woocommerce_cart_item_price', WC()->cart->get_product_price($_product), $cart_item, $cart_item_key);
                $product_permalink = apply_filters('woocommerce_cart_item_permalink', $_product->is_visible() ? $_product->get_permalink($cart_item) : '', $cart_item, $cart_item_key);
                $product = $cart_item['data'];
                $stock_quantity = $product->get_stock_quantity();
                $min_quantity = 1;
                $max_quantity = ($stock_quantity > 0) ? $stock_quantity : '';
        ?>
                <ul class="product-lists row">
                    <li class="col-sm-6">
                        <div class="productimg">
                            <div class="productimgs">
                                <?php echo $thumbnail; ?>
                            </div>
                            <div class="productcontet">
                                <h4>
                                    <?php echo $product_name; ?>
                                </h4>
                                <div class="productlinkset">
                                    <h5><?php echo $_product->get_sku(); ?></h5>
                                </div>
                                <div class="increment-decrement">

                                </div>
                            </div>
                    </li>
                    <li class="col-sm-1">
                        <div class="quntity">
                            <input type="number" class="input-text qty text" step="1" min="1" max="<?php echo $max_quantity; ?>" name="<?php echo $cart_item_key; ?>" value="<?php echo $cart_item['quantity']; ?>" title="Qty" onkeyup="checkMaxValue(jQuery(this))" />
                        </div>
                    </li>
                    <li class="col-sm-4">
                        <strong><?php echo apply_filters('woocommerce_cart_item_subtotal', WC()->cart->get_product_subtotal($_product, $cart_item['quantity']), $cart_item, $cart_item_key); ?></strong></br>
                        <?php echo apply_filters('woocommerce_widget_cart_item_quantity', '<span class="quantity">' . sprintf('%s &times; %s', $cart_item['quantity'], $product_price) . '</span>', $cart_item, $cart_item_key); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped 
                        ?>
                    </li>
                    <li class="col-sm-1">
                        <?php
                        echo apply_filters(
                            'woocommerce_cart_item_remove_link',
                            sprintf(
                                '<a href="%s" class="remove remove_from_cart_button" aria-label="%s" data-product_id="%s" data-cart_item_key="%s" data-product_sku="%s">
												<img src="' . get_bloginfo('template_directory') . '/src/img/delete-2.svg" alt="img">
											</a>',
                                esc_url(wc_get_cart_remove_url($cart_item_key)),
                                /* translators: %s is the product name */
                                esc_attr(sprintf(__('Remove %s from cart', 'woocommerce'), wp_strip_all_tags($product_name))),
                                esc_attr($product_id),
                                esc_attr($cart_item_key),
                                esc_attr($_product->get_sku())
                            ),
                            $cart_item_key
                        );
                        ?>
                    </li>
                </ul>
        <?php }
        }
        do_action('woocommerce_mini_cart_contents'); ?>
    </div>
    <div class="split-card"></div>
    <div class="card-body pt-0 pb-2">
        <form method="post" id="order_submit_form">
            <div class="setvalue">
                <?php $order_profit = WC()->cart->get_subtotal() - $product_cost; ?>
                <ul>
                    <li>
                        <h5>Subtotal</h5>
                        <h6><?php echo wc_price(WC()->cart->get_subtotal()); ?></h6>
                    </li>
                    <li>
                        <h5>Cost Total</h5>
                        <h6><?php echo wc_price($product_cost); ?></h6>
                    </li>
                    <li>
                        <h5>Order Profit</h5>
                        <h6><?php echo wc_price($order_profit); ?></h6>
                    </li>
                    <li class="total-value">
                        <h5>Total</h5>
                        <h6><?php echo wc_price(WC()->cart->get_subtotal()); ?></h6>
                    </li>
                </ul>
            </div>

            <div class="setvaluecash">
                <div class="payment_type_item"><img src="<?php echo get_bloginfo('template_directory'); ?>/src/img/cash.svg" alt="img" class="me-2">
                    <input type='radio' name='payment_type' value='cash' required />
                    Cash
                </div>
                <div class="payment_type_item"><img src="<?php echo get_bloginfo('template_directory'); ?>/src/img/debitcard.svg" alt="img" class="me-2">
                    <input type='radio' name='payment_type' value='pay_later' />
                    Pay later
                </div>
            </div>

            <div class="walkin_custom">
                <label> <input type="checkbox" name="walk_in_customer" id="walk_in_customer"> Walk in Customer</label>
            </div>
            <div class="customer_input">
                <input type="text" name="customer_name" placeholder="Please enter customer Name" id="customer_name" required>
            </div>

            <div class="btn-totallabel">
                <div class="button_set">
                    <button type="submit" class="me-3" data-toggle="modal" data-target="#order_submit">
                        <h5>Checkout Order</h5>
                        <h6><?php echo wc_price(WC()->cart->get_subtotal()); ?></h6>
                    </button>
                </div>
            </div>
            <input type="hidden" name="cost-total" value="<?php echo $product_cost; ?>">
            <input type="hidden" name="order-profit" value="<?php echo $order_profit; ?>">
        </form>

    </div>
    <?php do_action('woocommerce_widget_shopping_cart_before_buttons'); ?>
    <?php do_action('woocommerce_widget_shopping_cart_after_buttons'); ?>
<?php else : ?>
    <div class="woocommerce-mini-cart__empty-message">
        <img src="<?php echo get_bloginfo('template_directory'); ?>/src/img/no-product.png" alt="<?php esc_html_e('No products in the cart.', 'woocommerce'); ?>">
        <div class="mini_loder" style="display:none">
            <div class="whirly-loader"> </div>
        </div>
    </div>
<?php endif; ?>
<?php do_action('woocommerce_after_mini_cart'); ?>

<script>
    var walkInCheckbox = document.getElementById('walk_in_customer');
    var customerInputDiv = document.querySelector('.customer_input');
    var customerNameInput = document.getElementById('customer_name');

    // Add an event listener to the checkbox
    walkInCheckbox.addEventListener('change', function() {
        customerInputDiv.style.display = walkInCheckbox.checked ? 'none' : 'block';

        if (walkInCheckbox.checked) {
            customerNameInput.removeAttribute('required');
        } else {
            customerNameInput.setAttribute('required', 'required');
        }
    });

    function checkMaxValue($this) {
        const num = parseFloat($this.val());
        const maxValue = parseFloat($this.attr('max'));

        if (maxValue < num) {
            $this.val(maxValue);
        }

    }
    jQuery(document).ready(function($) {
        $('input[name=payment_type]').change(function() {
            $('.payment_type_item').removeClass('active');
            $(this).closest('.payment_type_item').addClass('active');
        });

        $('input[name=parts_type]').change(function() {
            $('.parts_type_item').removeClass('active');
            $(this).closest('.parts_type_item').addClass('active');
        });

        $("#order_submit_form").submit(function(event) {
            event.preventDefault();
            $(".global-loader").show();
            var cartData = JSON.stringify(<?php echo json_encode(WC()->cart->get_cart()); ?>);

            // Create FormData object
            var formData = new FormData(this);

            // Append cart data to FormData
            formData.append('cart_data', cartData);
            $.ajax({
                type: "POST",
                url: "/wp-json/v1/products/add-order", // Corrected the URL
                data: formData,
                contentType: false,
                processData: false,
                success: function(response) {
                    const order_id = response['order_id'];
                    $.ajax({
                        type: 'POST',
                        url: wc_cart_fragments_params.ajax_url,
                        data: {
                            action: 'empty_cart_action'
                        },
                        success: function(response) {
                            $(document.body).trigger('wc_fragment_refresh');
                            $(".global-loader").hide();
                            Swal.fire({
                                icon: "success",
                                title: "success...",
                                text: 'New Order Added ID ' + order_id,
                            });
                            FWP.refresh();
                        }
                    });
                },
                error: function(xhr, status, error) {
                    $(".global-loader").hide();
                    Swal.fire({
                        icon: "error",
                        title: "Oops...",
                        text: "Error:",
                        xhr,
                        status,
                        error,
                    });
                }
            });

        });
        $('button#clear_cart').click(function() {
            $.ajax({
                type: 'POST',
                url: wc_cart_fragments_params.ajax_url,
                data: {
                    action: 'empty_cart_action'
                },
                success: function(response) {
                    $(document.body).trigger('wc_fragment_refresh');
                    $(".global-loader").hide();
                    Swal.fire({
                        icon: "success",
                        title: "Cart Cleared...",
                        text: 'Your cart has been successfully cleared',
                    });
                    FWP.refresh();
                }
            });
        })

        jQuery(document.body).on('added_to_cart', function() {
            FWP.refresh();
        });
        jQuery(document.body).on('removed_from_cart updated_cart_totals', function() {
            FWP.refresh();
        });
        $(document.body).on('adding_to_cart', function() {
            $('.mini_loder').show();
        });

        $(document.body).on('added_to_cart', function() {
            $('.mini_loder').hide();
        });

        $('.remove_from_cart_button').on('click', function(event) {
            // Prevent the default link behavior
            event.preventDefault();

            // Show loader when the link is clicked
            showLoader();

            // Get the remove link URL
            var removeLink = $(this).attr('href');

            // Perform your removal logic, for example, an AJAX request to remove the product
            $.ajax({
                url: removeLink,
                type: 'GET',
                success: function(response) {
                    // Simulating the removal process with a successful AJAX request
                    // Replace this with your actual removal logic

                    // After the removal is completed, hide the loader
                    hideLoader();
                },
                error: function(error) {
                    // Handle errors if needed
                    console.error('Error:', error);
                    hideLoader();
                }
            });
        });

        $(document).on('facetwp-refresh', function() {
            // Show loader when the refresh is triggered
            $('.mini_loder_product').show();
        });

        // After FacetWP refreshes, hide the loader
        $(document).on('facetwp-loaded', function() {
            $('.mini_loder_product').hide();
        });

        // Function to show the loader
        function showLoader() {
            $('.mini_loder').show();
        }

        // Function to hide the loader
        function hideLoader() {
            $('.mini_loder').hide();
        }
    });
</script>