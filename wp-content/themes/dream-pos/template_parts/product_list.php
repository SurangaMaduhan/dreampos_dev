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
                <a href="/add-products/" class="btn btn-added"><img src="<?php echo get_bloginfo('template_directory'); ?>/src/img/plus.svg" alt="img" class="me-1">Add New Product</a>
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
                            <li><a data-bs-toggle="tooltip" data-bs-placement="top" title="pdf"><img src="<?php echo get_bloginfo('template_directory'); ?>/src/img/pdf.svg" alt="img"></a></li>
                            <li><a data-bs-toggle="tooltip" data-bs-placement="top" title="excel"><img src="<?php echo get_bloginfo('template_directory'); ?>/src/img/excel.svg" alt="img"></a></li>
                            <li><a data-bs-toggle="tooltip" data-bs-placement="top" title="print"><img src="<?php echo get_bloginfo('template_directory'); ?>/src/img/printer.svg" alt="img"></a></li>
                        </ul>
                    </div>
                </div>
                <!-- /Filter -->
                <div class="card mb-0" id="filter_inputs">
                    <div class="card-body pb-0">
                        <div class="row">
                            <div class="col-lg-12 col-sm-12">
                                <div class="row">
                                    <div class="col-lg col-sm-4 col-12">
                                        <div class="form-group">
                                            <?php echo do_shortcode('[facetwp facet="categories"]'); ?>
                                        </div>
                                    </div>
                                    <div class="col-lg col-sm-4 col-12">
                                        <div class="form-group">
                                            <?php echo do_shortcode('[facetwp facet="brands"]'); ?>
                                        </div>
                                    </div>
                                    
                                    <div class="col-lg col-sm-4 col-12">
                                        <div class="form-group">
                                            <?php echo do_shortcode('[facetwp facet="price"]'); ?>
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
                                <th>#</th>
                                <th>Product Name</th>
                                <th>SKU</th>
                                <th>Category</th>
                                <th>Brand</th>
                                <th>Cost</th>
                                <th>Sale Price</th>
                                <th>Qty</th>
                                <th>Product Status</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody class="facetwp-template">
                            <?php
                            $loop = new WP_Query($args);
                            while ($loop->have_posts()):
                                $loop->the_post();
                                global $product;

                                $categories = get_categories(
                                    array(
                                        'taxonomy' => 'product_cat',
                                        'orderby' => 'name',
                                        'show_count' => 0,
                                        'pad_counts' => 0,
                                        'hierarchical' => 1,
                                        'title_li' => '',
                                        'hide_empty' => 0,
                                    )
                                );

                                $product_brand = get_categories(
                                    array(
                                        'taxonomy' => 'brands',
                                        'orderby' => 'name',
                                        'show_count' => 0,
                                        'pad_counts' => 0,
                                        'hierarchical' => 1,
                                        'title_li' => '',
                                        'hide_empty' => 0,
                                    )
                                );

                                $currentCategories = get_the_terms($product->get_id(), 'product_cat');
                                $currentCategory = $currentCategories[0];
                                $product_terms = get_the_terms($product->get_id(), 'brands');
                                $thumbnail_id = get_option('z_taxonomy_image_id' . $product_terms[0]->term_id);
                                $thumbnail_url = wp_get_attachment_thumb_url($thumbnail_id, 'thumbnail');

                                $image =  wp_get_attachment_url( $product->get_image_id() , 'single-post-thumbnail' );
                                ?>
                                    <tr>
                                        <td>
                                          #<?php echo $product->get_id();?> 
                                        </td>
                                        <td class="productimgname">
                                            <a href="javascript:void(0);" class="product-img">
                                                <?php echo woocommerce_get_product_thumbnail(); ?>
                                            </a>
                                            <a href="javascript:void(0);"><?php echo $product->get_name(); ?></a>
                                        </td>
                                        <td><?php echo $product->get_sku(); ?></td>
                                        <td><?php if($currentCategories[0]->name){
                                            echo $currentCategories[0]->name;
                                        }; ?></td>
                                        <td>
                                            <img class="brand_image" src="<?php if ($thumbnail_url) {
                                                echo $thumbnail_url;
                                            } else {
                                                echo get_template_directory_uri() . '/src/img/noimage.png';
                                            } ?>" alt="<?php echo $product_terms[0]->name; ?>">
                                        </td>
                                        <td><?php echo get_woocommerce_currency_symbol() . ': ' . number_format((float) $product->get_meta('_cost'), 2, '.', ''); ?></td>
                                        <td><?php echo get_woocommerce_currency_symbol() . ': ' . number_format((float) $product->get_price(), 2, '.', ''); ?></td>
                                        <td><?php echo get_post_meta($product->get_id(), '_stock', true); ?></td>
                                        <td>
                                    <?php if ($product->managing_stock() && $product->is_in_stock()) {
                                        echo '<span class="instock">In stock</span>';
                                    } else {
                                        echo '<span class="outofstock">Out of stock</span>';
                                    } ?>
                                        </td>
                                        <td>
                                            <a class="me-3" href="/view-product/?product-id=<?php echo $product->get_id(); ?>">
                                                <img src="<?php echo get_bloginfo('template_directory'); ?>/src/img/eye.svg" alt="img">
                                            </a>
                                            <button type="button" class="me-3" data-toggle="modal" data-target="#edit_product_<?php echo $product->get_id(); ?>"><img src="<?php echo get_bloginfo('template_directory'); ?>/src/img/edit.svg" alt="img"></button>
                                            
                                            <button type="button" class="remove_product" pr_id="<?php echo $product->get_id(); ?>">
                                                <img src="<?php echo get_bloginfo('template_directory'); ?>/src/img/delete.svg" alt="img">
                                            </button>

                                            <div id="edit_product_<?php echo $product->get_id(); ?>" class="modal fade bd-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel" aria-hidden="true">
                                                <div class="modal-dialog modal-lg">
                                                    <div class="modal-content">
                                                    <form method="post" class="edit_product">
                                                    <div class="row">
                                                        <div class="col-sm-12">
                                                            <h5>Update "<?php echo $product->get_sku(); ?>" Product</h5>
                                                        </div>
                                                        <div class="col-sm-7">
                                                            <div class="current_image">
                                                                <label>Current product image</label>
                                                                <?php echo woocommerce_get_product_thumbnail(); ?>
                                                            </div>
                                                            <div class="form-group">
                                                                <label>
                                                                    Change Product Image</label>
                                                                <div class="drop-area" class="mb-3">
                                                                    <img src="<?php echo get_bloginfo('template_directory'); ?>/src/img/upload.svg" alt="upload">
                                                                    <h4>Drag and drop a file to upload</h4>
                                                                    <input type="file" class="file-input" accept="image/*" name="thumbnail">
                                                                </div>
                                                                <div class="preview_wrap" style="display: none;">
                                                                    <img class="file-preview" alt="File Preview" 
                                                                    src="<?php if ($image) {
                                                                            echo $image;
                                                                        } else {
                                                                            echo get_template_directory_uri() . '/src/img/noimage.png';
                                                                        };?>
                                                                    ">
                                                                    <button type="button" class="remove-btn">
                                                                        <i class="fa fa-times" aria-hidden="true"></i>
                                                                    </button>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-sm-5">
                                                            <div class="row">
                                                                <div class="col-sm-12">
                                                                    <label for="product_name">Product Name</label>
                                                                    <input type="text" name="product_name" value="<?php echo $product->get_name(); ?>">
                                                                </div>
                                                                <div class="col-sm-12">
                                                                    <label for="product_name">Product Cost</label>
                                                                    <input type="text" name="product_cost" value="<?php echo $product->get_meta('_cost'); ?>">
                                                                </div>
                                                                <div class="col-sm-12">
                                                                    <label for="product_name">Sale Price</label>
                                                                    <input type="text" name="product_price" value="<?php echo $product->get_price(); ?>">
                                                                </div>
                                                                <div class="col-sm-12">
                                                                    <label for="product_name">Sale Price</label>
                                                                    <input type="text" name="product_price" value="<?php echo $product->get_price(); ?>">
                                                                </div>
                                                                <div class="col-sm-12">
                                                                    <label for="product_name">Product SKU</label>
                                                                    <input type="text" name="product_sku" value="<?php echo get_post_meta($product->get_id(), '_sku', true); ?>">
                                                                </div>
                                                                <div class="col-sm-12">
                                                                    <label for="product_name">Product Qty</label>
                                                                    <input type="text" name="product_qty" value="<?php echo get_post_meta($product->get_id(), '_stock', true); ?>">
                                                                </div>
                                                                <div class="col-sm-12">
                                                                    <label for="product_name">Product Category</label>
                                                                    <select class="style_select select2" name="product_category"  required>
                                                                        <?php foreach ($categories as $category) {
                                                                            if ($currentCategory->name == $category->name) {
                                                                                echo '<option value="' . $category->slug . '" selected>' . $category->name . '</option>';
                                                                            } else {
                                                                                echo '<option value="' . $category->slug . '">' . $category->name . '</option>';
                                                                            }

                                                                        }
                                                                        ; ?>
                                                                    </select>
                                                                </div>
                                                                <div class="col-sm-12">
                                                                    <label for="product_name">Product Brand</label>
                                                                    <select class="style_select select2" name="product_brand"  required>
                                                                        <?php foreach ($product_brand as $brand) {
                                                                            if ($product_terms[0]->name == $brand->name) {
                                                                                echo '<option value="' . $brand->slug . '" selected>' . $brand->name . '</option>';
                                                                            } else {
                                                                                echo '<option value="' . $brand->slug . '">' . $brand->name . '</option>';
                                                                            }
                                                                        };?>
                                                                    </select>
                                                                </div>

                                                            </div>
                                                        </div>    
                                                    </div>
                                                    <div class="button_set">
                                                        <input type="hidden" name="product_id" value="<?php echo $product->get_id(); ?>">
                                                        <button type="submit" class="btn btn-submit me-2">
                                                            Update
                                                        </button>
                                                        <button type="button" class="btn btn-cancel me-2" data-dismiss="modal" aria-label="Close">
                                                            close
                                                        </button>
                                                    </div>
                                                </form>
                                                    </div>
                                                </div>
                                            </div>
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
<script>
jQuery(document).ready(function($) {
    $('.modal').each(function () {
        const dropArea = $(this).find('.drop-area')[0];
        const fileInput = $(this).find('.file-input')[0];
        const filePreview = $(this).find('.file-preview')[0];
        const removeBtn = $(this).find('.remove-btn')[0];
        const hide_wrap = $(this).find('.preview_wrap')[0];

        fileInput.addEventListener('change', () => {
            const files = fileInput.files;
            handleFiles(files);
        });

        removeBtn.addEventListener('click', () => {
            fileInput.value = ''; // Clear file input
            hideImagePreview();
        });

        function handleFiles(files) {
            if (files.length > 0) {
                const file = files[0];
                if (file.type.startsWith('image/')) {
                    showImagePreview(file);
                } else {
                    hideImagePreview();
                }
            } else {
                hideImagePreview();
            }
        }

        function showImagePreview(file) {
            const reader = new FileReader();

            reader.onload = function (e) {
                filePreview.src = e.target.result;
                hide_wrap.style.display = 'block';
            };

            reader.readAsDataURL(file);
        }

        function hideImagePreview() {
            filePreview.src = '';
            hide_wrap.style.display = 'none';
        }
    });

    $('.remove_product').on('click', function() {
        var productID = $(this).attr('pr_id');

        Swal.fire({
            title: "Do you want to delete Product?",
            showDenyButton: true,
            confirmButtonText: "Yes",
            denyButtonText: "No"
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: '/wp-json/products/v1/remove_products',
                    type: 'POST',
                    data: {'product_id': productID},
                    success: function(response) {
                        document.location.reload(true);
                    },
                    error: function(xhr, status, error) {
                        Swal.fire({
                            icon: "error",
                            title: "Oops...",
                            text: xhr.responseText,
                        }); 
                    }
                });
            } else if (result.isDenied) {
                Swal.fire({
                    icon: "error",
                    title: "Oops...",
                    text: 'User denied the deletion.',
                });
            }
        });
    });

    $(".edit_product").submit(function (event) {
    event.preventDefault();
    const modalId = $(this).closest('.modal').attr('id');
    // $(".global-loader").show();
    var formData = new FormData(this);

    $.ajax({
        type: "POST",
        url: "/wp-json/products/v1/update-product", // Corrected the URL
        data: formData,
        contentType: false,
        processData: false,
        success: function (response) {
            $('[data-dismiss="modal"]').trigger('click');
            Swal.fire({
                icon: "success",
                title: "success...",
                text: 'ID '+response+' Updated',
            }); 
            document.location.reload(true);
        },
        error: function (error) {
            $('[data-dismiss="modal"]').trigger('click');
            Swal.fire({
                icon: "error",
                title: "Oops...",
                text: 'User denied the deletion.',
            });
        }
    });
});
});


</script>

