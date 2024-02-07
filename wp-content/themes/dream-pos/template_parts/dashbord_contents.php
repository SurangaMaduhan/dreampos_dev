<?php
// $current_date = date('Y-m-d') . 'T00:00:00';
date_default_timezone_set("Asia/Kolkata");
$timestamp_start = date('Y-m-d'); // example
$timestamp_end   = date('Y-m-d'); // example


// Set up the query arguments
$query_args = array(
    'limit' => -1,
    'orderby'  => 'ID',
    'order'    => 'DESC',
    'date_created' => date("Y-m-d", strtotime($timestamp_start)) . '...' . date("Y-m-d ", strtotime($timestamp_end . ' 23:59:59'))
);
// Get WooCommerce orders
$today_orders = wc_get_orders($query_args);
$today_order_total = 0;
$today_order_count = 0;
$today_orders_profit = 0;
foreach ($today_orders as $order) {
    if ($order->get_status() != 'cancelled' && $order->get_status() != 'pending') {
        $today_order_total += $order->get_subtotal();
        $today_orders_profit += intval($order->get_meta('_order_profit', true));
        $today_order_count++;
    }
}

$query_args = array(
    'status'       => array('pending'),
    'limit' => -1,
    'orderby'  => 'ID',
    'order'    => 'DESC',
    'date_created' => strtotime($timestamp_start) . '...' . strtotime($timestamp_end . ' 23:59:59'),
);

$today_pending_orders = wc_get_orders($query_args);
$today_order_pending_total = 0;
$today_order_pending_count = 0;
foreach ($today_pending_orders as $pending_order) {
    $today_order_pending_total += $pending_order->get_subtotal();
    $today_order_pending_count++;
}

$query_args = array(
    'limit' => -1,
    'orderby'  => 'ID',
    'order'    => 'DESC',
);

$total_sales = wc_get_orders($query_args);
$total_sales_amount = 0;
$total_sales_profit = 0;
$total_sales_count = 0;
$completed_sales = 0;
$pending_sales_count = 0;
$canceled_sales_count = 0;


foreach ($total_sales as $total_sale) {
    $total_sales_count++;
    if ($total_sale->get_status() != 'cancelled' && $total_sale->get_status() != 'pending') {
        $total_sales_amount += $total_sale->get_subtotal();
        $total_sales_profit += intval($total_sale->get_meta('_order_profit', true));
        $completed_sales++;
    }
    if ($total_sale->get_status() == 'pending') {
        $pending_sales_count++;
    }

    if ($total_sale->get_status() == 'cancelled') {
        $canceled_sales_count++;
    }
};

$args = array(
    'post_type'      => 'product',
    'posts_per_page' => -1,
);

$loop = new WP_Query($args);
$product_count = 0;

while ($loop->have_posts()) : $loop->the_post();
    $product_count++;
endwhile;

$args = array(
    'post_type' => 'product',
    'meta_key' => 'total_sales',
    'orderby' => 'meta_value_num',
    'posts_per_page' => 5,
);
$loop = new WP_Query($args);

$start_date = date('Y-m-d H:i:s', strtotime('-10 days'));

// Get orders
$orders = wc_get_orders(array(
    'limit' => -1,
    'orderby'  => 'ID',
    'order'    => 'DESC',
    'date_created' => '>' . $start_date,
));

// Initialize arrays for dates, sales totals, and cost totals
$dates_array = $sales_totals_array = $cost_totals_array = $profit_totals_array = array();

// Loop through the orders
foreach ($orders as $order) {
    // Get order information
    $order_id = $order->get_id();
    $order_total = $order->get_total();
    $order_date = $order->get_date_created()->format('Y-m-d'); // Format date as 'YYYY-MM-DD'
    $order_profit = $order->get_meta('_order_profit', true);
    $cost_total = $order->get_meta('_cost_total', true);

    // Aggregate order totals by date
    if (isset($dates_array[$order_date])) {
        $sales_totals_array[$order_date] += $order_total;
        $cost_totals_array[$order_date] += $cost_total;
        $profit_totals_array[$order_date] += $order_profit;
    } else {
        $dates_array[$order_date] = $order_date;
        $sales_totals_array[$order_date] = $order_total;
        $cost_totals_array[$order_date] = $cost_total;
        $profit_totals_array[$order_date] = $order_profit;
    }
}
$dates_json = json_encode(array_values($dates_array)); // array_values to get the indexed array
$sales_totals_json = json_encode(array_values($sales_totals_array));
$profit_totals_json = json_encode(array_values($profit_totals_array));
$cost_totals_json = json_encode(array_values($cost_totals_array));
?>
<div class="page-wrapper">
    <div class="content">
        <div class="row">
            <div class="col">
                <div class="dash-widget dash2">
                    <div class="dash-widgetimg">
                        <span><img src="<?php echo get_bloginfo('template_directory'); ?>/src/img/graph.png" alt="img"></span>
                    </div>
                    <div class="dash-widgetcontent">
                        <h5>
                            <?php echo get_woocommerce_currency_symbol(); ?>
                            <span class="counters" data-count="<?php echo $total_sales_amount; ?>">
                                <?php echo number_format((float) $total_sales_amount, 2, '.', ','); ?>
                            </span>.00
                        </h5>
                        <h6>Total Sale Amount</h6>
                    </div>
                </div>
            </div>
            <div class="col">
                <div class="dash-widget dash2">
                    <div class="dash-widgetimg">
                        <span><img src="<?php echo get_bloginfo('template_directory'); ?>/src/img/dash3.svg" alt="img"></span>
                    </div>
                    <div class="dash-widgetcontent">
                        <h5>
                            <?php echo get_woocommerce_currency_symbol(); ?>
                            <span class="counters" data-count="<?php echo $total_sales_profit; ?>">
                                <?php echo number_format((float) $total_sales_profit, 2, '.', ','); ?>
                            </span>.00
                        </h5>
                        <h6>Total Sale Profit</h6>
                    </div>
                </div>
            </div>
            <div class="col">
                <div class="dash-widget dash1">
                    <div class="dash-widgetimg">
                        <span>
                            <img src="<?php echo get_bloginfo('template_directory'); ?>/src/img/dash2.svg" alt="img">
                        </span>
                    </div>
                    <div class="dash-widgetcontent">
                        <h5> <?php echo get_woocommerce_currency_symbol(); ?>
                            <span class="counters" data-count="<?php echo $today_order_total; ?>">
                                <?php echo number_format((float) $today_order_total, 2, '.', ','); ?>
                            </span>.00
                        </h5>
                        <h6>Today Subtotal</h6>
                    </div>
                </div>
            </div>
            <div class="col">
                <div class="dash-widget ">
                    <div class="dash-widgetimg">
                        <span>
                            <img src="<?php echo get_bloginfo('template_directory'); ?>/src/img/dash1.svg" alt="img">
                        </span>
                    </div>
                    <div class="dash-widgetcontent">
                        <h5><?php echo get_woocommerce_currency_symbol(); ?>
                            <span class="counters" data-count="<?php echo $today_order_pending_total; ?>">
                                <?php echo number_format((float) $today_order_pending_total, 2, '.', ','); ?>
                            </span>.00
                        </h5>
                        <h6>Today Pending Sales</h6>
                    </div>
                </div>
            </div>
            <div class="col">
                <div class="dash-widget dash2">
                    <div class="dash-widgetimg">
                        <span><img src="<?php echo get_bloginfo('template_directory'); ?>/src/img/dash3.svg" alt="img"></span>
                    </div>
                    <div class="dash-widgetcontent">
                        <h5><?php echo get_woocommerce_currency_symbol(); ?>
                            <span class="counters" data-count="<?php echo $today_orders_profit . ''; ?>">
                                <?php echo number_format((float) $today_orders_profit, 2, '.', ','); ?>
                            </span>.00
                        </h5>
                        <h6>Today Profit Amount</h6>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col d-flex">
                <div class="dash-count das2">
                    <div class="dash-counts">
                        <h4><?php echo $product_count; ?></h4>
                        <h5>All inventory items</h5>
                    </div>
                    <div class="dash-imgs">
                        <i data-feather="package"></i>
                    </div>
                </div>
            </div>
            <div class="col d-flex">
                <div class="dash-count das1">
                    <div class="dash-counts">
                        <h4><?php echo $total_sales_count; ?></h4>
                        <h5>Total Sales</h5>
                    </div>
                    <div class="dash-imgs">
                        <i data-feather="file-plus"></i>
                    </div>
                </div>
            </div>
            <div class="col d-flex">
                <div class="dash-count das3">
                    <div class="dash-counts">
                        <h4><?php echo $completed_sales; ?></h4>
                        <h5>Total Completed Sales</h5>
                    </div>
                    <div class="dash-imgs">
                        <i data-feather="check-square"></i>
                    </div>
                </div>
            </div>
            <div class="col d-flex">
                <div class="dash-count ">
                    <div class="dash-counts">
                        <h4><?php echo $pending_sales_count; ?></h4>
                        <h5>Total Pending Sales</h5>
                    </div>
                    <div class="dash-imgs">
                        <i data-feather="file-minus"></i>
                    </div>
                </div>
            </div>
            <div class="col d-flex">
                <div class="dash-count das4">
                    <div class="dash-counts">
                        <h4><?php echo $canceled_sales_count; ?></h4>
                        <h5>Total Canceled Sales</h5>
                    </div>
                    <div class="dash-imgs">
                        <i data-feather="alert-triangle"></i>
                    </div>
                </div>
            </div>

        </div>
        <!-- Button trigger modal -->

        <div class="row">
            <div class="col-lg-7 col-sm-12 col-12 d-flex">
                <div class="card flex-fill w-100">

                    <div class="card-header pb-0 d-flex justify-content-between align-items-center">
                        <h5 class="card-title mb-0">Sales, Profit & Cost</h5>
                    </div>
                    <div class="card-body">
                        <div id="sales_charts"></div>
                    </div>
                </div>
            </div>
            <div class="col-lg-5 col-sm-12 col-12 d-flex">
                <div class="card flex-fill w-100">
                    <div class="card-header pb-0 d-flex justify-content-between align-items-center">
                        <h4 class="card-title mb-0">Best selling products</h4>
                        <div class="dropdown">
                            <a href="javascript:void(0);" data-bs-toggle="dropdown" aria-expanded="false" class="dropset">
                                <i class="fa fa-ellipsis-v"></i>
                            </a>
                            <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                <li>
                                    <a href="productlist.html" class="dropdown-item">Product List</a>
                                </li>
                                <li>
                                    <a href="addproduct.html" class="dropdown-item">Product Add</a>
                                </li>
                            </ul>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive dataview">
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Product Name</th>
                                        <th>SKU</th>
                                        <th>Total Sales</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    while ($loop->have_posts()) : $loop->the_post();
                                        global $product; ?>
                                        <tr>
                                            <td>#<?php echo $product->get_id(); ?></td>
                                            <td class="productimgname">
                                                <a href="javascript:void(0);" class="product-img">
                                                    <?php echo woocommerce_get_product_thumbnail(); ?>
                                                </a>
                                                <a href="javascript:void(0);"><?php echo $product->get_name(); ?></a>
                                            </td>
                                            <td><?php echo $product->get_sku(); ?></td>
                                            <td><?php echo $product->get_total_sales(); ?></td>
                                        </tr>
                                    <?php endwhile; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="card mb-0">
            <div class="card-body">
                <h4 class="card-title">Expired Products</h4>
                <div class="table-responsive dataview">
                    <table class="table datatable ">
                        <thead>
                            <tr>
                                <th>SNo</th>
                                <th>Product Name</th>
                                <th>Product Category</th>
                                <th>Brand Name</th>
                                <th>Product Cost</th>
                                <th>Product Price</th>
                                <th>Product Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $out_of_stock_products = wc_get_products(array(
                                'status'      => 'publish',
                                'limit'       => -1,
                                'stock_status' => 'outofstock',
                            ));

                            if ($out_of_stock_products) {
                                foreach ($out_of_stock_products as $product) {
                                    $product_id = get_the_ID();
                                    $product_categories = get_the_terms( $product_id, 'product_cat'); 
                                    ?>
                                    <tr>
                                        <td>
                                            <?php echo $product->get_sku(); ?>
                                        </td>
                                        <td class="productimgname">
                                            <a href="javascript:void(0);" class="product-img">
                                                <?php echo woocommerce_get_product_thumbnail(); ?>
                                            </a>
                                            <a href="javascript:void(0);"><?php echo $product->get_name(); ?></a>
                                        </td>
                                        <td><?php if ($product_categories[0]->name) {
                                                echo $product_categories[0]->name;
                                            }; ?></td>
                                        <td>
                                            <img class="brand_image" src="
                                            <?php if ($thumbnail_url) {
                                                echo $thumbnail_url;
                                            } else {
                                                echo get_template_directory_uri() . '/src/img/noimage.png';
                                            } ?>" alt="<?php echo $product_terms[0]->name; ?>">
                                        </td>
                                        <td><?php echo get_woocommerce_currency_symbol() . ': ' . number_format((float) $product->get_meta('_cost'), 2, '.', ''); ?></td>
                                        <td><?php echo get_woocommerce_currency_symbol() . ': ' . number_format((float) $product->get_price(), 2, '.', ''); ?></td>
                                        <td>
                                            <?php if ($product->managing_stock() && $product->is_in_stock()) {
                                                echo '<span class="instock">In stock</span>';
                                            } else {
                                                echo '<span class="outofstock">Out of stock</span>';
                                            } ?>
                                        </td>
                                    </tr>
                                <?php }
                            } else { ?>
                                <tr>
                                    <?php echo 'No out-of-stock products found.'; ?>
                                <tr>
                                <?php } ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
    jQuery(document).ready(function($) {
        var options = {
            series: [{
                    name: 'Net Profit',
                    data: <?php echo $profit_totals_json; ?>
                },
                {
                    name: 'Sales',
                    data: <?php echo $sales_totals_json; ?>
                },
                {
                    name: 'Cost',
                    data: <?php echo $cost_totals_json; ?>
                }
                // Add other series as needed
            ],
            chart: {
                type: 'bar',
                height: 350
            },
            plotOptions: {
                bar: {
                    horizontal: false,
                    columnWidth: '55%',
                    endingShape: 'rounded'
                },
            },
            dataLabels: {
                enabled: false
            },
            stroke: {
                show: true,
                width: 2,
                colors: ['transparent']
            },
            xaxis: {
                categories: <?php echo $dates_json; ?>,
            },
            yaxis: {
                title: {
                    text: 'Total Amounts'
                }
            },
            fill: {
                opacity: 1
            },
            tooltip: {
                y: {
                    formatter: function(val) {
                        return "රු," + val + ".00"
                    }
                }
            }
        };

        var chart = new ApexCharts(document.querySelector("#sales_charts"), options);
        chart.render();
    })
</script>