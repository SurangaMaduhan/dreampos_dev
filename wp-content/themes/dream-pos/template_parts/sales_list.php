<?php
global $paged;
if (!isset($paged) || !$paged) {
    $paged = 1;
}

$orders = wc_get_orders(array(
    'limit' => -1,
    // 'status'       => array( 'your-custom-status' ),
    // 'orderby'      => 'date',
    // 'order'        => 'ASC',
    // 'date_created' => '<' . ( $today - ( $days_delay * $one_day ) ),
)); ?>

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
                                <th>Customer Name</th>
                                <th>Order Type</th>
                                <th>Order Subtotal</th>
                                <th>Order Cost</th>
                                <th>Order Profit</th>
                                <th>Order Date</th>
                                <th>Product Count</th>
                                <th>Order Status</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody class="facetwp-template">
                            <?php
                            // $loop = new WP_Query($args);
                            // var_dump($loop);
                            foreach ($orders as $order) {
                                $order_id = $order->get_id();
                                // $order->get_meta('_cost_total', true) 
                            ?>
                                <tr>
                                    <td>
                                        #<?php echo $order_id ?>
                                    </td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                </tr>
                            <?php }; ?>
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
        $('.newEdit').each(function() {
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

                reader.onload = function(e) {
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
                        data: {
                            'product_id': productID
                        },
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

        $(".edit_product").submit(function(event) {
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
                success: function(response) {
                    $('[data-dismiss="modal"]').trigger('click');
                    Swal.fire({
                        icon: "success",
                        title: "success...",
                        text: 'ID ' + response + ' Updated',
                    });
                    document.location.reload(true);
                },
                error: function(error) {
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