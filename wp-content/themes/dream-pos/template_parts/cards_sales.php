<?php
$args = array(
    'post_type' => 'cards',
    'posts_per_page' => -1,
    'post_status' => 'publish',
);
$query = new WP_Query($args);
$cards_args = array(
    'post_type' => 'cards_sales',
    'posts_per_page' => -1,
    'post_status' => 'publish',
    'facetwp' => true
);
$cards = new WP_Query($cards_args);
?>
<div class="page-wrapper">
    <div class="content">
        <div class="page-header">
            <div class="page-title">
                <h4>Cards Sales List</h4>
                <h6>Manage Cards Sales List</h6>
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
                        <div class="col-sm-7">
                            <table>
                                <thead>
                                    <tr>
                                        <th>Sale ID</th>
                                        <th>Sold Date & time</th>
                                        <th>Sold Card(s) Count</th>
                                        <th>Sale total</th>
                                        <th>Sale Commission</th>
                                    </tr>
                                </thead>
                                <tbody class="facetwp-template ps-res">
                                    <?php
                                    if ($cards->have_posts()) {
                                        while ($cards->have_posts()) {
                                            $cards->the_post();
                                            global $post;
                                    ?>
                                            <tr>
                                                <td><?php the_title(); ?></td>
                                                <td><?php echo get_the_date('Y-m-d H:i:s') ?></td>
                                                <td><?php echo get_post_meta($post->ID, 'sale_item_count', true); ?></td>
                                                <td><?php echo get_woocommerce_currency_symbol() . ': ' . number_format((float)  get_post_meta($post->ID, 'sale_amount', true), 2, '.', ''); ?></td>
                                                <td><?php echo get_woocommerce_currency_symbol() . ': ' . number_format((float)get_post_meta($post->ID, 'sale_commission_amount', true), 2, '.', ''); ?></td>
                                            </tr>
                                        <?php }
                                    } else { ?>
                                        <tr>
                                            <td colspan="5">No Cards sale in the list</td>
                                        </tr>
                                    <?php } ?>
                                </tbody>
                            </table>
                        </div>
                        <div class="col-sm-5">
                            <div class="cards_sale">
                                <div class="row">
                                    <div class="col-12">
                                        <h5>Add New Cards Sale</h5>
                                    </div>
                                    <div class="card_filters">
                                        <div class="row">
                                            <?php
                                            $loop = new WP_Query($args);
                                            while ($loop->have_posts()) :
                                                $loop->the_post();
                                                global $post;
                                            ?>
                                                <div class="col-sm-3">
                                                    <button type="button" class="me-3 card_sale" data-toggle="modal" data-target="#card_sale_<?php echo $post->ID; ?>">
                                                        <h3><?php echo get_post_meta($post->ID, 'amount', true); ?></h3>
                                                        <span><?php echo get_post_meta($post->ID, 'card_provider', true); ?></span>
                                                    </button>
                                                    <div id="card_sale_<?php echo $post->ID; ?>" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel" aria-hidden="true">
                                                        <div class="modal-dialog">
                                                            <div class="modal-content">
                                                                <form method="post" class="card_sale">
                                                                    <div class="row">
                                                                        <div class="col-sm-12">
                                                                            <h5><?php echo  get_post_meta($post->ID, 'amount', true); ?>/=</h5>
                                                                        </div>
                                                                        <div class="col-sm-12">
                                                                            <div class="form-group">
                                                                                <label for="card_qut">Card(s) Count</label>
                                                                                <input type="number" name="card_qut">
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                    <div class="button_set">
                                                                        <input type="hidden" name="card_id" value="<?php echo $post->ID; ?>">
                                                                        <button type="submit" class="btn btn-submit me-2">
                                                                            Crads sale
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

                                                </div>
                                            <?php endwhile;
                                            wp_reset_query();
                                            // echo facetwp_display('per_page');
                                            ?>
                                        </div>
                                    </div>
                                </div>
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

        $(".card_sale").submit(function(event) {
            event.preventDefault();
            // const modalId = $(this).closest('.modal').attr('id');
            $(".global-loader").show();
            var formData = new FormData(this);
            $.ajax({
                type: "POST",
                url: "/wp-json/v1/cards/add-card-sale", // Corrected the URL
                data: formData,
                contentType: false,
                processData: false,
                success: function(response) {
                    // console.log(response);
                    $('[data-dismiss="modal"]').trigger('click');
                    $(".global-loader").hide();
                    $("form").trigger('reset');                    
                    $('.provider_item').removeClass('active');
                    Swal.fire({
                        icon: "success",
                        title: "success...",
                        text: response.message,
                    });
                    FWP.refresh();
                    // document.location.reload(true);
                },
                error: function(error) {
                    // console.log(error);
                    $('[data-dismiss="modal"]').trigger('click');
                    Swal.fire({
                        icon: "error",
                        title: "Oops...",
                        text: 'User denied the submit reload.',
                    });
                }
            });
        });

    });
</script>