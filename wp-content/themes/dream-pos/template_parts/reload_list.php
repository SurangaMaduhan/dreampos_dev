<?php
$args = array(
    'post_type' => 'reload_providers',
    'posts_per_page' => -1,
    'post_status' => 'publish',
);
$query = new WP_Query($args);
$reload_args = array(
    'post_type' => 'reloads',
    'posts_per_page' => -1,
    'post_status' => 'publish',
    'facetwp' => true
);
$reload = new WP_Query($reload_args);
?>
<div class="page-wrapper">
    <div class="content">
        <div class="page-header">
            <div class="page-title">
                <h4>Reload Providers List</h4>
                <h6>Manage Reload Providers</h6>
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
                            <div class="form-group"><input id="myInput" type="text" placeholder="Search.."></div>
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
                                    <div class="col-lg col-sm-3 col-12">
                                        <div class="form-group">
                                            <?php echo do_shortcode('[facetwp facet="filter_reload_by_provide"]'); ?>
                                        </div>
                                    </div>
                                    <div class="col-lg col-sm-3 col-12">
                                        <div class="form-group">
                                            <?php echo do_shortcode('[facetwp facet="reload_status"]'); ?>
                                        </div>
                                    </div>

                                    <div class="col-lg col-sm-4 col-12">
                                        <div class="form-group style-rd">
                                            <div class="form-group"><?php echo do_shortcode('[facetwp facet="reload_date"]'); ?></div>
                                        </div>
                                    </div>
                                    <div class="col-lg col-sm-2 col-12">
                                        <div class="form-group style-rd">
                                            <div class="form-group"><?php echo do_shortcode('[facetwp facet="reset"]'); ?></div>
                                        </div>
                                    </div>

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- /Filter -->
                <div class="table-responsive2">
                    <div class="row">
                        <div class="col-12">

                        </div>
                        <div class="col-sm-8">
                            <table>
                                <thead>
                                    <tr>
                                        <th>Mobile Number</th>
                                        <th>Reload Date and time</th>
                                        <th>Reload Amount</th>
                                        <th>Provider Name</th>
                                        <th>Reload Balance</th>
                                        <th>Reload status</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody class="facetwp-template ps-res">
                                    <?php
                                    if ($reload->have_posts()) {
                                        while ($reload->have_posts()) {
                                            $reload->the_post();
                                            $post_id = get_the_ID();
                                            $title = get_the_title();
                                            $post_date = get_the_date('Y-m-d H:i:s');
                                            $reload_amount = get_post_meta($post_id, 'amount', true);
                                            $reload_provider = get_post_meta($post_id, 'provider', true);
                                            $reload_status = get_post_meta($post_id, 'status', true);
                                            $provider_after = get_post_meta($post_id, 'provider_after_balance', true);
                                            $provider_before_balance = get_post_meta($post_id, 'provider_before_balance', true);
                                            $reload_item_commission = get_post_meta($post_id, 'reload_item_commission', true);
                                            $provider_after_balance = $provider_after ? get_woocommerce_currency_symbol() . ': ' . number_format((float) $provider_after, 2, '.', '') : 'Not Complete';
                                    ?>
                                            <tr>
                                                <td><?php echo $title; ?></td>
                                                <td><?php echo $post_date; ?></td>
                                                <td><?php echo get_woocommerce_currency_symbol() . ': ' . number_format((float) $reload_amount, 2, '.', ''); ?></td>
                                                <td><?php echo $reload_provider ?></td>
                                                <td><?php echo $provider_after_balance; ?></td>
                                                <td>
                                                    <?php
                                                    $class_btn = ($reload_status == 'pending') ? ' update_btn' : ' view_btn';
                                                    ?>
                                                    <button class="<?php echo $reload_status;
                                                                    echo $class_btn; ?> " p_id="<?php echo $post_id; ?>">
                                                        <?php echo $reload_status ?>
                                                    </button>
                                                </td>
                                                <td style="text-align: center; display: flex; align-items: center; justify-content: center;">
                                                    <?php if ($reload_status == "pending") { ?>
                                                        <button type="button" class="me-3" data-toggle="modal" data-target="#edit_reload_<?php echo $post_id; ?>">
                                                            <img src="<?php echo get_bloginfo('template_directory'); ?>/src/img/edit.svg" alt="img">
                                                        </button>
                                                        <button type="button" class="remove_product" pr_id="<?php echo $post_id; ?>">
                                                            <img src="<?php echo get_bloginfo('template_directory'); ?>/src/img/delete.svg" alt="img">
                                                        </button>
                                                        <div id="edit_reload_<?php echo $post_id; ?>" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel" aria-hidden="true">
                                                            <div class="modal-dialog">
                                                                <div class="modal-content">
                                                                    <form method="post" class="edit_reload">
                                                                        <div class="row">
                                                                            <div class="col-12">
                                                                                <h5>#<?php echo $post_id; ?> Update</h5>
                                                                            </div>
                                                                            <div class="col-12">
                                                                                <div class="col-12">
                                                                                    <div class="form-group">
                                                                                        <input type="text" id="mobile_number" name="mobile_number" placeholder="Mobile Number" maxlength="10" required autocomplete="off" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*?)\..*/g, '$1');" value="<?php echo $title; ?>">
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                            <div class="col-12">
                                                                                <div class="form-group">
                                                                                    <input type="number" id="amount" name="amount" placeholder="Reload Amount" required autocomplete="off" value="<?php echo $reload_amount; ?>">
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                        <div class="button_set">
                                                                            <input type="hidden" name="reload_id" value="<?php echo $post_id; ?>">
                                                                            <button type="submit" class="btn btn-submit me-2">
                                                                                Update
                                                                            </button>
                                                                            <button type="button" class="btn btn-cancel me-2" data-dismiss="modal" aria-label="Close">
                                                                                close
                                                                            </button>
                                                                        </div>
                                                                    </form>
                                                                    <div class="global-loader" style="display:none">
                                                                        <div class="whirly-loader"> </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    <?php } else { ?>
                                                        <button type="button" class="me-3" data-toggle="modal" data-target="#view_reload_<?php echo $post_id; ?>">
                                                            <img src="<?php echo get_bloginfo('template_directory'); ?>/src/img/eye.svg" alt="img">
                                                        </button>
                                                        <div id="view_reload_<?php echo $post_id; ?>" class="modal fade view_reload" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel" aria-hidden="true">
                                                            <div class="modal-dialog">
                                                                <div class="modal-content">
                                                                    <h3>
                                                                        <?php echo $title; ?> details.
                                                                    </h3>
                                                                    <div class="wrap_content_rel">
                                                                        <h6><strong>Before balance (<?php echo $reload_provider ?>)</strong> : <?php echo get_woocommerce_currency_symbol() . ': ' . number_format((float) $provider_before_balance, 2, '.', ''); ?></h6>
                                                                        <h6><strong>After balance (<?php echo $reload_provider ?>)</strong> : <?php echo get_woocommerce_currency_symbol() . ': ' . number_format((float) $provider_after, 2, '.', ''); ?></h6>
                                                                        <h6><strong>Commission </strong> : <?php echo get_woocommerce_currency_symbol() . ': ' . number_format((float) $reload_item_commission, 2, '.', ''); ?></h6>
                                                                    </div>
                                                                    <div class="button_set">

                                                                        <button type="button" class="btn btn-cancel me-2" data-dismiss="modal" aria-label="Close">
                                                                            close
                                                                        </button>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    <?php }; ?>
                                                </td>
                                            </tr>
                                        <?php }
                                    } else { ?>
                                        <tr>
                                            <td colspan="7">No Reloads in the list</td>
                                        </tr>
                                    <?php } ?>
                                </tbody>
                            </table>
                        </div>
                        <div class="col-sm-4">
                            <div class="realod_adding">
                                <form method="post" id="submit_reload">
                                    <div class="row">
                                        <div class="col-12">
                                            <h5>Add New Reload</h5>
                                        </div>
                                        <div class="col-12">
                                            <div class="form-group">
                                                <input type="text" id="mobile_number" name="mobile_number" placeholder="Mobile Number" maxlength="10" required autocomplete="off" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*?)\..*/g, '$1');">
                                            </div>
                                        </div>
                                        <div class="col-12">
                                            <div class="form-group">
                                                <input type="number" id="amount" name="amount" placeholder="Reload Amount" required autocomplete="off">
                                            </div>
                                        </div>
                                        <div class="col-12 provider_wraper">
                                            <div class="providers_items_wrap row">
                                                <?php
                                                if ($query->have_posts()) {
                                                    while ($query->have_posts()) {
                                                        $query->the_post();
                                                        $post_id = get_the_ID();
                                                        $title = get_the_title();
                                                        $featured_image = get_the_post_thumbnail_url($post_id); ?>
                                                        <div class="col-4">
                                                            <div class="provider_item">
                                                                <img src="<?php echo $featured_image; ?>" alt="img" class="me-2">
                                                                <input type='radio' name='provider' value='<?php echo $title; ?>' required />
                                                                <?php echo $title; ?>
                                                            </div>
                                                        </div>
                                                <?php }
                                                }; ?>
                                            </div>
                                        </div>
                                        <div class="col-12">
                                            <input type="submit" value="Add reload" class="btn btn-submit me-2">
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
        <!-- /product list -->
    </div>
</div>

<script>
    jQuery(document).ready(function($) {
        $("#myInput").on("keyup", function() {
            var value = $(this).val().toLowerCase();
            $(".table-responsive2 tbody tr").filter(function() {
                $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
            });
        });

        $('input[name=provider]').change(function() {
            $('.provider_item').removeClass('active');
            $(this).closest('.provider_item').addClass('active');
        });

        $(document).on('facetwp-refresh', function() {
            if (FWP.loaded) {
                $('.facetwp-template').prepend('<div class="global-loader"><div class="whirly-loader"> </div></div>');
            }
        });
        $("#submit_reload").submit(function(event) {
            event.preventDefault();
            const modalId = $(this).closest('.modal').attr('id');
            // $(".global-loader").show();
            var formData = new FormData(this);
            $.ajax({
                type: "POST",
                url: "/wp-json/v1/reload/add-reload", // Corrected the URL
                data: formData,
                contentType: false,
                processData: false,
                success: function(response) {
                    // console.log(response);
                    FWP.refresh();
                    $("form").trigger('reset');
                    $('.provider_item').removeClass('active');
                    Swal.fire({
                        icon: "success",
                        title: "success...",
                        text: response.message,
                    });
                    // document.location.reload(true);
                },
                error: function(error) {
                    console.log(error);
                    // $('[data-dismiss="modal"]').trigger('click');
                    Swal.fire({
                        icon: "error",
                        title: "Oops...",
                        text: 'User denied the submit reload.',
                    });
                }
            });
        });

        $(".edit_reload").submit(function(event) {
            event.preventDefault();
            const modalId = $(this).closest('.modal').attr('id');
            // $(".global-loader").show();
            var formData = new FormData(this);
            $.ajax({
                type: "POST",
                url: "/wp-json/v1/reload/update-reload", // Corrected the URL
                data: formData,
                contentType: false,
                processData: false,
                success: function(response) {
                    $('[data-dismiss="modal"]').trigger('click');
                    FWP.refresh();
                    Swal.fire({
                        icon: "success",
                        title: "success...",
                        text: response.message,
                    });
                },
                error: function(error) {
                    console.log(error);
                    $('[data-dismiss="modal"]').trigger('click');
                    Swal.fire({
                        icon: "error",
                        title: "Oops...",
                        text: 'User denied the submit reload.',
                    });
                }
            });
        });

        // Use event delegation to handle the click event for any element with the class 'remove_product'
        $(document).on('click', '.remove_product', function() {
            var productID = $(this).attr('pr_id');
            Swal.fire({
                title: "Do you want to remove reload?",
                icon: "info",
                showDenyButton: true,
                confirmButtonText: "Yes",
                denyButtonText: "No"
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url: '/wp-json/v1/reload/remove-reload',
                        type: 'POST',
                        data: {
                            'post_id': productID
                        },
                        success: function(response) {
                            // Rebind SweetAlert2 events or perform actions after successful reload
                            FWP.refresh();
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
        $(document).on('click', '.update_btn', function() {
            var productID = $(this).attr('p_id');
            Swal.fire({
                title: "Do you want to Update status?",
                icon: "info",
                showDenyButton: true,
                confirmButtonText: "Complete Reload",
                denyButtonText: "No"
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url: '/wp-json/v1/reload/update-status',
                        type: 'POST',
                        data: {
                            'p_id': productID
                        },
                        success: function(response) {
                            console.log(response);
                            // // Rebind SweetAlert2 events or perform actions after successful reload
                            FWP.refresh();
                        },
                        error: function(xhr, status, error) {
                            // Swal.fire({
                            //     icon: "error",
                            //     title: "Oops...",
                            //     text: xhr.responseText,
                            // });
                            console.log(xhr.responseText);
                        }
                    });
                } else if (result.isDenied) {
                    // Swal.fire({
                    //     icon: "error",
                    //     title: "Oops...",
                    //     text: 'User denied the deletion.',
                    // });
                }
            });
        });


    });
</script>