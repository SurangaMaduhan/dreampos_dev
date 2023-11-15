<?php
global $paged;
if (!isset($paged) || !$paged) {
    $paged = 1;
}

$args = array(
    'post_type' => 'product',
    'paged' => $paged,
    'facetwp' => true
); ?>

<div class="page-wrapper">
    <div class="content">
        <div class="page-header">
            <div class="page-title">
                <h4>Product List</h4>
                <h6>Manage your products</h6>
            </div>
            <div class="page-btn">
                <a href="addproduct.html" class="btn btn-added"><img src="<?php echo get_bloginfo('template_directory'); ?>/src/img/plus.svg" alt="img"
                        class="me-1">Add New Product</a>
            </div>
        </div>


        <!-- /product list -->
        <div class="card">
            <div class="card-body">
                <div class="table-top">
                    <div class="search-set">
                        <div class="search-path">
                            <a class="btn btn-filter" id="filter_search">
                                <img src="<?php echo get_bloginfo('template_directory'); ?>/src/img/filter.svg" alt="img">
                                <span><img src="<?php echo get_bloginfo('template_directory'); ?>/src/img/closes.svg" alt="img"></span>
                            </a>
                        </div>
                        <div class="search-input">
                            <a class="btn btn-searchset"><img src="<?php echo get_bloginfo('template_directory'); ?>/src/img/search-white.svg" alt="img"></a>
                        </div>
                    </div>
                    <div class="wordset">
                        <ul>
                            <li>
                                <a data-bs-toggle="tooltip" data-bs-placement="top" title="pdf"><img
                                        src="<?php echo get_bloginfo('template_directory'); ?>/src/img/pdf.svg" alt="img"></a>
                            </li>
                            <li>
                                <a data-bs-toggle="tooltip" data-bs-placement="top" title="excel"><img
                                        src="<?php echo get_bloginfo('template_directory'); ?>/src/img/excel.svg" alt="img"></a>
                            </li>
                            <li>
                                <a data-bs-toggle="tooltip" data-bs-placement="top" title="print"><img
                                        src="<?php echo get_bloginfo('template_directory'); ?>/src/img/printer.svg" alt="img"></a>
                            </li>
                        </ul>
                    </div>
                </div>
                <!-- /Filter -->
                <div class="card mb-0" id="filter_inputs">
                    <div class="card-body pb-0">
                        <div class="row">
                            <div class="col-lg-12 col-sm-12">
                                <div class="row">
                                    <div class="col-lg col-sm-6 col-12">
                                        <div class="form-group">
                                            <?php echo do_shortcode('[facetwp facet="categories"]');?>
                                        </div>
                                    </div>
                                    <div class="col-lg col-sm-6 col-12">
                                        <div class="form-group">
                                            <select class="select">
                                                <option>Choose Category</option>
                                                <option>Computers</option>
                                                <option>Fruits</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-lg col-sm-6 col-12">
                                        <div class="form-group">
                                            <select class="select">
                                                <option>Choose Sub Category</option>
                                                <option>Computer</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-lg col-sm-6 col-12">
                                        <div class="form-group">
                                            <select class="select">
                                                <option>Brand</option>
                                                <option>N/D</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-lg col-sm-6 col-12 ">
                                        <div class="form-group">
                                            <select class="select">
                                                <option>Price</option>
                                                <option>150.00</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-lg-1 col-sm-6 col-12">
                                        <div class="form-group">
                                            <a class="btn btn-filters ms-auto"><img
                                                    src="<?php echo get_bloginfo('template_directory'); ?>/src/img/search-whites.svg" alt="img"></a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- /Filter -->
                <div class="table-responsive">
                    <table class="table  datanew">
                        <thead>
                            <tr>
                                <th>
                                    <label class="checkboxs">
                                        <input type="checkbox" id="select-all">
                                        <span class="checkmarks"></span>
                                    </label>
                                </th>
                                <th>Product Name</th>
                                <th>SKU</th>
                                <th>Category </th>
                                <th>Brand</th>
                                <th>price</th>
                                <th>Unit</th>
                                <th>Qty</th>
                                <th>Created By</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $loop = new WP_Query($args);
                            while ($loop->have_posts()):
                                $loop->the_post();
                                global $product; ?>
                                <tr>
                                    <td>
                                        <label class="checkboxs">
                                            <input type="checkbox">
                                            <span class="checkmarks"></span>
                                        </label>
                                    </td>
                                    <td class="productimgname">
                                        <a href="javascript:void(0);" class="product-img">
                                            <?php echo woocommerce_get_product_thumbnail(); ?>
                                        </a>
                                        <a href="javascript:void(0);"><?php echo $product->get_name(); ?></a>
                                    </td>
                                    <td><?php echo get_post_meta($product->get_id(), '_sku', true); ?></td>
                                    <td><?php //echo $product->get_name(); ?></td>
                                    <td><?php echo get_post_meta($product->get_id(), '_stock', true);?></td>
                                    <td><?php echo $product->get_price(); ?></td>
                                    <td>pc</td>
                                    <td>100.00</td>
                                    <td>Admin</td>
                                    <td>
                                        <a class="me-3" href="product-details.html">
                                            <img src="<?php echo get_bloginfo('template_directory'); ?>/src/img/eye.svg" alt="img">
                                        </a>
                                        <a class="me-3" href="editproduct.html">
                                            <img src="<?php echo get_bloginfo('template_directory'); ?>/src/img/edit.svg" alt="img">
                                        </a>
                                        <a class="confirm-text" href="javascript:void(0);">
                                            <img src="<?php echo get_bloginfo('template_directory'); ?>/src/img/delete.svg" alt="img">
                                        </a>
                                    </td>
                                </tr>
                            <?php endwhile;
                            wp_reset_query();
                            // echo facetwp_display('per_page');
                            ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <!-- /product list -->
    </div>
</div>