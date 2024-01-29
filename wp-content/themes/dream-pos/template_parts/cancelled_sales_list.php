<?php
global $paged;
if (!isset($paged) || !$paged) {
    $paged = 1;
}
$ordersn = wc_get_orders(array(
    'limit' => -1,
    'status'       => array('cancelled'),
    'orderby'  => 'ID',
    'order'    => 'DESC',
));

foreach ($ordersn as $order) {
    $order_date = strtotime($order->get_date_created());

    if (empty($earliest_date) || $order_date < strtotime($earliest_date)) {
        $earliest_date = date('Y-m-d', $order_date);
    }

    if (empty($latest_date) || $order_date > strtotime($latest_date)) {
        $latest_date = date('Y-m-d', $order_date);
    }
}

$quary = array(
    'limit' => -1,
    'status'       => array('cancelled'),
    'orderby'  => 'ID',
    'order'    => 'DESC',
);

$start_date = isset($_GET['start_date']) ? sanitize_text_field($_GET['start_date']) : '';
$end_date = isset($_GET['end_date']) ? sanitize_text_field($_GET['end_date']) : '';
$sales_type = isset($_GET['sales_type']) ? sanitize_text_field($_GET['sales_type']) : '';

if (!empty($_GET['start_date']) || !empty($_GET['end_date']) || !empty($_GET['sales_type']) || !empty($_GET['sales_type'])) {
    $quary = array(
        'limit' => -1,
        'status'       => array('cancelled'),
        'orderby'  => 'ID',
        'order'    => 'DESC',
        'date_created' => date("Y-m-d", strtotime($start_date)) . '...' .  date("Y-m-d", strtotime($end_date . ' 23:59:59')),
        'meta_query' => array(
            array(
                'key' => '_parts_type',
                'value' => $sales_type,
                'compare' => '='
            )
        )
    );
}
$orders = wc_get_orders($quary);
$orders_sub_total = 0;
$orders_cost_total = 0;
$orders_profit_total = 0;

$all_orders = 0;
$completed_orders = 0;
$pending_orders = 0;
$cancelled_orders = 0;

foreach ($orders as $order2) {
    $orders_sub_total += (float) $order2->get_subtotal();
    $orders_cost_total += (float) $order2->get_meta('_cost_total', true);
    $orders_profit_total += (float) $order2->get_meta('_order_profit', true);

    $all_orders++;

    if ($order2->get_status() == 'completed') {
        $completed_orders++;
    }

    if ($order2->get_status() == 'pending') {
        $pending_orders++;
    }

    if ($order2->get_status() == 'cancelled') {
        $cancelled_orders++;
    }
}
?>

<div class="page-wrapper">
    <div class="content">
        <div class="page-header">
            <div class="page-title">
                <h4>Cancelled Sales List</h4>
                <h6>Manage your Cancelled Sales</h6>
            </div>
        </div>

        <div class="icon_details_wrap">
            <div class="row">
                <div class="col-lg-4 col-sm-6 col-12">
                    <div class="dash-widget">
                        <div class="dash-widgetimg">
                            <span>
                                <img src="http://dreamspos.loc/wp-content/themes/dream-pos/src/img/dash1.svg" alt="img">
                            </span>
                        </div>
                        <div class="dash-widgetcontent">
                            <h5><?php echo get_woocommerce_currency_symbol(); ?>,<span class="counters" data-count="<?php echo (float) $orders_sub_total; ?>"><?php echo $orders_sub_total; ?></span>.00</h5>
                            <h6>Total Cancelled Amount</h6>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 col-sm-6 col-12">
                    <div class="dash-widget dash1">
                        <div class="dash-widgetimg">
                            <span>
                                <img src="http://dreamspos.loc/wp-content/themes/dream-pos/src/img/dash2.svg" alt="img">
                            </span>
                        </div>
                        <div class="dash-widgetcontent">
                            <h5><?php echo get_woocommerce_currency_symbol(); ?>,<span class="counters" data-count="<?php echo (float) $orders_cost_total; ?>"><?php echo $orders_cost_total; ?></span>.00</h5>
                            <h6>Total Cancelled Cost Amount</h6>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 col-sm-6 col-12">
                    <div class="dash-widget dash2">
                        <div class="dash-widgetimg">
                            <span><img src="http://dreamspos.loc/wp-content/themes/dream-pos/src/img/dash3.svg" alt="img"></span>
                        </div>
                        <div class="dash-widgetcontent">
                            <h5><?php echo get_woocommerce_currency_symbol(); ?>,<span class="counters" data-count="<?php echo (float) $orders_profit_total; ?>"><?php echo $orders_profit_total; ?></span>.00</h5>
                            <h6>Total Cancelled Profit Amount</h6>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- /product list -->
        <div class="card">
            <div class="card-body">
                <div class="table-top">
                    <div class="search-set">
                        <a class="btn btn-filter" id="filter_search">
                            <img src="<?php echo get_bloginfo('template_directory'); ?>/src/img/filter.svg" alt="img">
                            <span><img src="<?php echo get_bloginfo('template_directory'); ?>/src/img/closes.svg" alt="img"></span>
                        </a>
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
                        <form method="get" class="Form_Serch_orders">
                            <div class="row">
                                <div class="col-sm-2">
                                    <label for="start_date">Start Date:</label>
                                    <input type="date" id="start_date" name="start_date" placeholder="YYYY-MM-DD" min="<?= $earliest_date ?>" max="<?= $latest_date ?>" required>
                                </div>
                                <div class="col-sm-2">
                                    <label for="end_date">End Date:</label>
                                    <input type="date" id="end_date" name="end_date" placeholder="YYYY-MM-DD" min="<?= $earliest_date ?>" max="<?= $latest_date ?>" required>
                                </div>

                                <div class="col-sm-2">
                                    <label for="sales_type">Sales Type:</label>
                                    <select name="sales_type" id="sales_type" class="select" required>
                                        <option value="">--- Select Sales Type ---</option>
                                        <option value="motorbike">High capacity</option>
                                        <option value="motorcycle">Low Capacity</option>
                                        <option value="modification">Modifications</option>
                                    </select>
                                </div>
                                <div class="col-sm-2 d-flex align-items-end">
                                    <button type="submit" class="filter_submit">Search</button>
                                    <button type="button" class="filter_clear" onclick="jQuery('.Form_Serch_orders *').removeAttr('required');jQuery('.Form_Serch_orders').trigger('reset'); jQuery('.filter_submit').trigger('click')"><img src="<?php echo get_bloginfo('template_directory'); ?>/src/img/closes.svg" alt="img"></button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>

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
                                <th>Order Date & Time</th>
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
                                $bike_type = "";
                                if ($order->get_meta('_parts_type', true) == 'motorbike') {
                                    $bike_type = 'High capacity';
                                } elseif ($order->get_meta('_parts_type', true) == 'motorcycle') {
                                    $bike_type = 'Low Capacity';
                                } else {
                                    $bike_type = 'Modifications';
                                }
                            ?>
                                <tr>
                                    <td>
                                        #<?php echo $order_id; ?>
                                    </td>
                                    <td><?php echo $order->get_meta('_customer_name', true); ?></td>
                                    <td style="text-transform: capitalize;"><?php echo $bike_type; ?></td>
                                    <td><?php echo get_woocommerce_currency_symbol() . ': ' . number_format((float) $order->get_subtotal(), 2, '.', ''); ?></td>
                                    <td><?php echo get_woocommerce_currency_symbol() . ': ' . number_format((float) $order->get_meta('_cost_total', true), 2, '.', ''); ?></td>
                                    <td><?php echo get_woocommerce_currency_symbol() . ': ' . number_format((float) $order->get_meta('_order_profit', true), 2, '.', ''); ?></td>
                                    <td><?php echo date('F j, Y, g:i a', strtotime($order->get_date_created())); ?></td>
                                    <td><?php echo $order->get_item_count(); ?></td>
                                    <td><span class="<?php echo $order->get_status(); ?> order_status"><?php echo $order->get_status(); ?></span></td>
                                    <td>
                                        <button type="button" class="me-3" data-toggle="modal" data-target="#view_order_<?php echo $order_id; ?>">
                                            <img src="<?php echo get_bloginfo('template_directory'); ?>/src/img/eye.svg" alt="img">
                                        </button>
                                        <button type="button" class="me-3" data-toggle="modal" data-target="#change_status_<?php echo $order_id; ?>">
                                            <img src="<?php echo get_bloginfo('template_directory'); ?>/src/img/edit.svg" alt="img">
                                        </button>
                                        <?php if ($order->get_status() == 'cancelled') { ?>
                                            <button type="button" class="remove_order" order_id="<?php echo $order_id; ?>">
                                                <img src="<?php echo get_bloginfo('template_directory'); ?>/src/img/delete.svg" alt="img">
                                            </button>
                                        <?php } ?>
                                        <div id="view_order_<?php echo $order_id; ?>" class="modal fade bd-example-modal-lg Order_view" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel" aria-hidden="true">
                                            <div class="modal-dialog modal-lg">
                                                <div class="modal-content">
                                                    <div class="row ">
                                                        <div class="col-sm-12">
                                                            <h2>Sale ID #<?php echo $order_id; ?></h2>
                                                        </div>
                                                        <div class="col-sm-12 cl_Table">
                                                            <div class="row tbHeader">
                                                                <div class="col-sm-2" style="text-align: center;">#</div>
                                                                <div class="col-sm-4">Product name</div>
                                                                <div class="col-sm-2" style="text-align: center;">Quantity</div>
                                                                <div class="col-sm-4" style="text-align: center;">Subtotal</div>
                                                            </div>
                                                            <?php
                                                            foreach ($order->get_items() as $item_id => $item) {
                                                                $product = wc_get_product($item->get_product_id());
                                                            ?>
                                                                <div class="row align-items-center">
                                                                    <div class="col-sm-2">
                                                                        <?php echo $product->get_image(); ?>
                                                                    </div>
                                                                    <div class="col-sm-4">
                                                                        <strong><?php echo $item->get_name(); ?></strong><br>
                                                                        <i>Cost : <?php echo get_woocommerce_currency_symbol() . ': ' . number_format((float) $item->get_meta('_pr_cost', true), 2, '.', ''); ?></i>
                                                                    </div>
                                                                    <div class="col-sm-2" style="text-align: center;"><?php echo $item->get_quantity(); ?></div>
                                                                    <div class="col-sm-4" style="text-align: center;"><?php echo get_woocommerce_currency_symbol() . ': ' . number_format((float)$item->get_subtotal(), 2, '.', ''); ?></div>
                                                                </div>
                                                            <?php }; ?>
                                                        </div>
                                                        <div class="col-cm-12 customerNme">
                                                            <h5>Customer Name : <span><?php echo $order->get_meta('_customer_name', true); ?></span></h5>
                                                        </div>
                                                        <div class="col-sm-12 order_mainDetails">
                                                            <div class="row justify-content-end">
                                                                <div class="col-sm-8">
                                                                    <div class="row">
                                                                        <div class="col-sm-6">
                                                                            <span class="title_order">Subtotal</span>
                                                                        </div>
                                                                        <div class="col-sm-6">
                                                                            <span class="price_order"><?php echo get_woocommerce_currency_symbol() . ': ' . number_format((float) $order->get_subtotal(), 2, '.', ''); ?></span>
                                                                        </div>
                                                                    </div>
                                                                    <div class="row">
                                                                        <div class="col-sm-6">
                                                                            <span class="title_order">Cost Total</span>
                                                                        </div>
                                                                        <div class="col-sm-6">
                                                                            <span class="price_order"><?php echo get_woocommerce_currency_symbol() . ': ' . number_format((float) $order->get_meta('_cost_total', true), 2, '.', ''); ?></span>
                                                                        </div>
                                                                    </div>
                                                                    <div class="row">
                                                                        <div class="col-sm-6">
                                                                            <span class="title_order">Order Profit</span>
                                                                        </div>
                                                                        <div class="col-sm-6">
                                                                            <span class="price_order"><?php echo get_woocommerce_currency_symbol() . ': ' . number_format((float) $order->get_meta('_order_profit', true), 2, '.', ''); ?></span>
                                                                        </div>
                                                                    </div>
                                                                    <div class="row">
                                                                        <div class="col-sm-6">
                                                                            <strong class="title_order">Total</strong>
                                                                        </div>
                                                                        <div class="col-sm-6">
                                                                            <strong class="price_order"><?php echo get_woocommerce_currency_symbol() . ': ' . number_format((float) $order->get_subtotal(), 2, '.', ''); ?></strong>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="button_set">
                                                        <button type="button" class="btn btn-cancel me-2" data-dismiss="modal" aria-label="Close">
                                                            close
                                                        </button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div id="change_status_<?php echo $order_id; ?>" class="modal fade bd-example-modal-lg Order_view" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel" aria-hidden="true">
                                            <div class="modal-dialog modal-lg">
                                                <div class="modal-content">
                                                    <div class="row">
                                                        <div class="col-sm-12">
                                                            <h2>Order Status Update ID #<?php echo $order_id; ?></h2>
                                                        </div>
                                                    </div>
                                                    <div class="col-cm-12 customerNme_order">
                                                        <h6>Customer Name : <span><?php echo $order->get_meta('_customer_name', true); ?></span></h6>
                                                    </div>
                                                    <div class="wrapper_edit_stutus">
                                                        <div class="row tbHeader">
                                                            <div class="col-sm-2" style="text-align: center;">#</div>
                                                            <div class="col-sm-4">Product name</div>
                                                            <div class="col-sm-2" style="text-align: center;">Quantity</div>
                                                            <div class="col-sm-4" style="text-align: center;">Subtotal</div>
                                                        </div>

                                                        <?php
                                                        foreach ($order->get_items() as $item_id => $item) {
                                                            $product = wc_get_product($item->get_product_id());
                                                        ?>
                                                            <div class="row">
                                                                <div class="col-sm-2">
                                                                    <?php echo $product->get_image(); ?>
                                                                </div>
                                                                <div class="col-sm-4">
                                                                    <strong><?php echo $item->get_name(); ?></strong><br>
                                                                    <i>Cost : <?php echo get_woocommerce_currency_symbol() . ': ' . number_format((float) $item->get_meta('_pr_cost', true), 2, '.', ''); ?></i>
                                                                </div>
                                                                <div class="col-sm-2" style="text-align: center;">
                                                                    <?php echo $item->get_quantity(); ?>
                                                                </div>
                                                                <div class="col-sm-4" style="text-align: center;">
                                                                    <?php echo get_woocommerce_currency_symbol() . ': ' . number_format((float)$item->get_subtotal(), 2, '.', ''); ?>
                                                                </div>
                                                            </div>
                                                        <?php }; ?>
                                                    </div>
                                                    <div class="col-sm-12 order_mainDetails">
                                                        <div class="col-sm-12">
                                                            <div class="row">
                                                                <div class="col-sm-6">
                                                                    <span class="title_order">Subtotal</span>
                                                                </div>
                                                                <div class="col-sm-6">
                                                                    <span class="price_order"><?php echo get_woocommerce_currency_symbol() . ': ' . number_format((float) $order->get_subtotal(), 2, '.', ''); ?></span>
                                                                </div>
                                                            </div>
                                                            <div class="row">
                                                                <div class="col-sm-6">
                                                                    <span class="title_order">Cost Total</span>
                                                                </div>
                                                                <div class="col-sm-6">
                                                                    <span class="price_order"><?php echo get_woocommerce_currency_symbol() . ': ' . number_format((float) $order->get_meta('_cost_total', true), 2, '.', ''); ?></span>
                                                                </div>
                                                            </div>
                                                            <div class="row">
                                                                <div class="col-sm-6">
                                                                    <span class="title_order">Order Profit</span>
                                                                </div>
                                                                <div class="col-sm-6">
                                                                    <span class="price_order"><?php echo get_woocommerce_currency_symbol() . ': ' . number_format((float) $order->get_meta('_order_profit', true), 2, '.', ''); ?></span>
                                                                </div>
                                                            </div>
                                                            <div class="row">
                                                                <div class="col-sm-6">
                                                                    <strong class="title_order">Total</strong>
                                                                </div>
                                                                <div class="col-sm-6">
                                                                    <strong class="price_order"><?php echo get_woocommerce_currency_symbol() . ': ' . number_format((float) $order->get_subtotal(), 2, '.', ''); ?></strong>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <form method="post" class="update_status">
                                                        <div class="status_btn">
                                                            <?php if ($order->get_status() != 'completed') { ?>
                                                                <div class="status_btn_item">
                                                                    <input type="radio" name="order_status" value="completed">
                                                                    <h4>Complete</h4>
                                                                </div>
                                                            <?php } ?>
                                                            <?php if ($order->get_status() != 'pending') { ?>
                                                                <div class="status_btn_item">
                                                                    <input type="radio" name="order_status" value="pending">
                                                                    <h4>Pending</h4>
                                                                </div>
                                                            <?php } ?>
                                                            <?php if ($order->get_status() != 'cancelled') { ?>
                                                                <div class="status_btn_item">
                                                                    <input type="radio" name="order_status" value="cancelled">
                                                                    <h4>Cancel</h4>
                                                                </div>
                                                            <?php } ?>
                                                        </div>
                                                        <div class="button_set">
                                                            <input type="hidden" name="order_id" value="<?php echo $order_id; ?>">
                                                            <button type="submit" class="btn btn-submit me-2">
                                                                Update Status
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
    function addThousandsSeparator(number) {
        return number.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
    }
    var counters = document.querySelectorAll('.counters');

    // Update each counter element
    counters.forEach(function(counter) {
        var targetValue = parseFloat(counter.getAttribute('data-count'));
        var currentValue = 0;

        // Set an interval to update the counter gradually
        var interval = setInterval(function() {
            currentValue += 1000.01; // You can adjust the increment as needed

            // Update the counter text
            counter.textContent = addThousandsSeparator(currentValue.toFixed(2));

            // Check if we've reached the target value
            if (currentValue >= targetValue) {
                clearInterval(interval);
                counter.textContent = addThousandsSeparator(targetValue.toFixed(2)); // Set the final value
            }
        }, 10); // You can adjust the interval as needed
    });
    jQuery(document).ready(function($) {
        $('input[name=order_status]').change(function() {
            $('.status_btn_item').removeClass('active');
            $(this).closest('.status_btn_item').addClass('active');
        });
        $(".update_status").submit(function(event) {
            event.preventDefault();
            const modalId = $(this).closest('.modal').attr('id');
            // $(".global-loader").show();
            var formData = new FormData(this);

            $.ajax({
                type: "POST",
                url: "/wp-json/products/v1/update-order", // Corrected the URL
                data: formData,
                contentType: false,
                processData: false,
                success: function(response) {
                    $('[data-dismiss="modal"]').trigger('click');
                    Swal.fire({
                        icon: "success",
                        title: "success...",
                        text: response.message,
                    });
                    document.location.reload(true);
                },
                error: function(error) {
                    console.log(error);
                    $('[data-dismiss="modal"]').trigger('click');
                    Swal.fire({
                        icon: "error",
                        title: "Oops...",
                        text: 'User denied the deletion.',
                    });
                }
            });
        });

        $('.remove_order').on('click', function() {
            var productID = $(this).attr('order_id');

            Swal.fire({
                title: "Do you want to delete Sale?",
                showDenyButton: true,
                confirmButtonText: "Yes",
                denyButtonText: "No"
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url: '/wp-json/v1/remove-order',
                        type: 'POST',
                        data: {
                            'order_id': productID
                        },
                        success: function(response) {
                            document.location.reload(true);
                            // console.log(response);
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

    });
</script>