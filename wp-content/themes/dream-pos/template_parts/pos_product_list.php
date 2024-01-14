<?php echo do_shortcode('[facetwp facet="products"]'); ?>
<?php echo do_shortcode( '[facetwp facet="categories_list"]' ); ?>

<div class="row facetwp-template">
<?php
$args = array(
    'post_type' => 'product',
    'posts_per_page' => -1,
    'facetwp' => true
);
$loop = new WP_Query($args);
while ($loop->have_posts()):
    $loop->the_post();
    global $product;
    $currentCategories = get_the_terms($product->get_id(), 'product_cat'); ?>
    <div class="col-lg-2 col-sm-3 d-flex">
        <div class="productset flex-fill">
            <div class="productsetimg">
                <?php echo woocommerce_get_product_thumbnail(); ?>
                <h6><?php echo get_woocommerce_currency_symbol() . ': ' . number_format((float) $product->get_meta('_cost'), 2, '.', ''); ?></h6>
                
            </div>
            <div class="productsetcontent">
                <h5><?php if ($currentCategories[0]->name) {
                    echo $currentCategories[0]->name;
                }
                ; ?></h5>
                <h4><?php echo $product->get_name(); ?></h4>
                <span class="cost">Qty: <?php echo $product->get_stock_quantity(); ?></span>
                <h6><?php echo get_woocommerce_currency_symbol() . ': ' . number_format((float) $product->get_price(), 2, '.', ''); ?></h6>
                <?php echo do_shortcode('[add_to_cart id="' . $product->get_id() . '"]'); ?>
            </div>
        </div>
    </div>
<?php endwhile;
wp_reset_query(); ?></div>

