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

<?php if (!WC()->cart->is_empty()): ?>
	<div class="totalitem">
		<h4>Total items :
			<?php echo WC()->cart->get_cart_contents_count(); ?></h4>
		<?php echo '<a href="?&empty_cart=yes" class="button" title="' . esc_attr( 'Empty Cart', 'woocommerce' ) . '">' . esc_html( 'Empty cart', 'woocommerce' ) . '</a>';?>
	</div>
	<div class="product-table">
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
						<input type="number" class="input-text qty text" step="1" min="1" max="" name="<?php echo $cart_item_key; ?>" value="<?php echo $cart_item['quantity']; ?>" title="Qty" size="4" pattern="[0-9]*" inputmode="numeric" aria-labelledby="label_here"/>

					</li>
					<li class="col-sm-4">
						<strong><?php echo apply_filters('woocommerce_cart_item_subtotal', WC()->cart->get_product_subtotal($_product, $cart_item['quantity']), $cart_item, $cart_item_key); ?></strong></br>
						<?php echo apply_filters('woocommerce_widget_cart_item_quantity', '<span class="quantity">' . sprintf('%s &times; %s', $cart_item['quantity'], $product_price) . '</span>', $cart_item, $cart_item_key); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
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
			<?php
			}
		}

		do_action('woocommerce_mini_cart_contents');
		?></div>
		<div class="split-card"></div>
		<div class="card-body pt-0 pb-2" >
        <div class="setvalue" >
			<?php $order_profit = WC()->cart->get_subtotal() - $product_cost; ?>
            <ul>
                <li>
                    <h5>Subtotal</h5>
                    <h6><?php echo wc_price(WC()->cart->get_subtotal());?></h6>
                </li>
                <li>
                    <h5>Cost Total</h5>
                    <h6><?php echo wc_price($product_cost);?></h6>
                </li>
                <li>
                    <h5>Order Profit</h5>
                    <h6><?php echo wc_price($order_profit);?></h6>
                </li>
                <li class="total-value">
                    <h5>Total</h5>
                    <h6><?php echo wc_price(WC()->cart->get_subtotal());?></h6>
                </li>
            </ul>
        </div>
        <div class="setvaluecash" >
            <ul>
                <li><a href="javascript:void(0);" class="paymentmethod"><img src="<?php echo get_bloginfo('template_directory'); ?>/src/img/cash.svg" alt="img" class="me-2">Cash</a></li>
                <li><a href="javascript:void(0);" class="paymentmethod"><img src="<?php echo get_bloginfo('template_directory'); ?>/src/img/debitcard.svg" alt="img" class="me-2">Debit</a></li>
                <li><a href="javascript:void(0);" class="paymentmethod"><img src="<?php echo get_bloginfo('template_directory'); ?>/src/img/scan.svg" alt="img" class="me-2">Scan</a></li>
            </ul>
        </div>
        <div class="btn-totallabel" >
            <h5>Checkout</h5>
            <h6><?php echo wc_price(WC()->cart->get_subtotal());?></h6>
        </div>
    </div>
		<?php do_action('woocommerce_widget_shopping_cart_before_buttons'); ?>
			<?php do_action('woocommerce_widget_shopping_cart_after_buttons'); ?>
<?php else: ?>
	<div class="woocommerce-mini-cart__empty-message">
		<img src="<?php echo get_bloginfo('template_directory'); ?>/src/img/no-product.png" alt="<?php esc_html_e('No products in the cart.', 'woocommerce'); ?>">
		
	</div>
<?php endif; ?>
<?php do_action('woocommerce_after_mini_cart'); ?>
