<?php echo do_shortcode('[facetwp facet="products"]'); ?>
<?php echo do_shortcode('[facetwp facet="categories_list"]'); ?>

<div class="row facetwp-template">
    <?php
    $args = array(
        'post_type' => 'product',
        'posts_per_page' => -1,
        'meta_query'     => array(
            'relation' => 'AND', // Add this line for an AND relationship between conditions
            array(
                'key'     => '_stock_status',
                'value'   => 'instock',
                'compare' => '=',
            ),
            array(
                'key'     => '_stock',
                'value'   => 0,
                'compare' => '>',
                'type'    => 'NUMERIC',
            ),
        ),
        'facetwp' => true
    );
    $loop = new WP_Query($args);
    while ($loop->have_posts()) :
        $loop->the_post();
        global $product;
        $currentCategories = get_the_terms($product->get_id(), 'product_cat');
        $product_in_cart = false;
        foreach (WC()->cart->get_cart() as $cart_item) {
            if ($cart_item['product_id'] == $product->get_id()) {
                $product_in_cart = true;
                break;
            }
        } ?>
        <div class="col-lg-2 col-sm-3 d-flex">
            <div class="productset flex-fill 
            <?php if ($product_in_cart) {
                echo 'active2';
            } ?>">
                <div class="productsetimg">
                    <?php echo woocommerce_get_product_thumbnail(); ?>
                    <h6><?php echo get_woocommerce_currency_symbol() . ': ' . number_format((float) $product->get_meta('_cost'), 2, '.', ''); ?></h6>
                    <?php if ($product_in_cart) { ?>
                        <div class="check-product">
                            <i class="fa fa-check"></i>
                        </div>
                    <?php } ?>
                </div>
                <div class="productsetcontent">
                    <div class="title">
                        <h5><?php if ($currentCategories[0]->name) {
                                echo $currentCategories[0]->name;
                            }; ?></h5>
                        <h4><?php echo $product->get_name(); ?></h4>
                    </div>
                    <div class="stock">
                        <span class="cost">Qty: <?php echo $product->get_stock_quantity(); ?></span>
                        <h6><?php echo get_woocommerce_currency_symbol() . ': ' . number_format((float) $product->get_price(), 2, '.', ''); ?></h6>
                    </div>
                </div>
                <?php
                // Display Add to Cart button only if the product is not in the cart
                if (!$product_in_cart) {
                    echo do_shortcode('[add_to_cart id="' . $product->get_id() . '"]');
                } ?>
            </div>
        </div>
    <?php endwhile;
    wp_reset_query(); ?>
</div>
<script>
    jQuery(document).ready(function() {
        $('.add_to_cart_button').on('click', function(event) {
            // Prevent the default behavior (i.e., following the link)
            event.preventDefault();

            // Get product information from the link attributes
            var product_id = $(this).data('product_id');
            var quantity = $(this).data('quantity');

            // Perform the add-to-cart operation using AJAX
            $.ajax({
                type: 'POST',
                url: wc_add_to_cart_params.ajax_url,
                data: {
                    action: 'woocommerce_add_to_cart',
                    product_id: product_id,
                    quantity: quantity,
                },
                success: function(response) {
                    // Optionally, you can handle the response if needed
                    console.log(response);

                    // Optionally, you can redirect to the cart page after successful addition
                    // window.location.href = wc_add_to_cart_params.cart_url;
                },
            });
        });
    })
</script>