<?php

$product = wc_get_product(intval($_GET['product-id']));
$terms = get_the_terms(intval($_GET['product-id']), 'product_cat');
$brands = get_the_terms(intval($_GET['product-id']), 'brands');
$thumbnail_id = get_option('z_taxonomy_image_id' . $brands[0]->term_id);
$thumbnail_url = wp_get_attachment_thumb_url($thumbnail_id, 'thumbnail');



?>
<div class="page-wrapper" style="min-height: 452px;">
    <div class="content">
        <div class="page-header">
            <div class="page-title">
                <h4>Product Details</h4>
                <h6>Full details of a product</h6>
            </div>
        </div>
        <!-- /add -->
        <div class="row">
            <div class="col-lg-8 col-sm-12">
                <div class="card">
                    <div class="card-body">
                        <div class="productdetails">
                            <ul class="product-bar">
                                <li>
                                    <h4>Product</h4>
                                    <h6><?php echo $product->get_name(); ?></h6>
                                </li>
                                <li>
                                    <h4>Category</h4>
                                    <h6><?php echo $product->get_categories(); ?></h6>
                                </li>
                                <li>
                                    <h4>Brand</h4>
                                    <h6>
                                        <img class="brand_image" src="<?php if ($thumbnail_url) {
                                            echo $thumbnail_url;
                                        } else {
                                            echo get_template_directory_uri() . '/src/img/noimage.png';
                                        } ?>" alt="">
                                    </h6>
                                </li>
                                <li>
                                    <h4>SKU</h4>
                                    <h6><?php echo $product->get_sku(); ?></h6>
                                </li>
                                <li>
                                    <h4>Quantity</h4>
                                    <h6><?php echo get_post_meta($product->get_id(), '_stock', true); ?></h6>
                                </li>
                                <li>
                                    <h4>Product Cost</h4>
                                    <h6><?php echo get_woocommerce_currency_symbol() . ': ' . number_format((float) $product->get_meta('_cost'), 2, '.', ''); ?></h6>
                                </li>
                                <li>
                                    <h4>Product Sale Price</h4>
                                    <h6><?php echo get_woocommerce_currency_symbol() . ': ' . number_format((float) $product->get_price(), 2, '.', ''); ?></h6>
                                </li>
                                <li>
                                    <h4>Status</h4>
                                    <h6>
                                <?php if ($product->managing_stock() && $product->is_in_stock()) {
                                    echo '<span class="instock">In stock</span>';
                                } else {
                                    echo '<span class="outofstock">Out of stock</span>';
                                } ?>
                                    </h6>
                                </li>
                                <li>
                                    <h4>Description</h4>
                                    <h6><?php echo $product->get_description(); ?></h6>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-4 col-sm-12">
                <div class="card">
                    <div class="card-body">
                        <a href="javascript:void(0);" class="product-img-in_view">
                            <?php echo woocommerce_get_product_thumbnail(); ?>
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <!-- /add -->
    </div>
</div>

