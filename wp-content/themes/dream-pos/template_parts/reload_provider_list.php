<?php
$args = array(
    'post_type' => 'reload_providers',
    'posts_per_page' => -1,
    'post_status' => 'publish',
);

$query = new WP_Query($args);
?>
<div class="page-wrapper">
    <div class="content">
        <div class="page-header">
            <div class="page-title">
                <h4>Reload Providers List</h4>
                <h6>Manage Reload Providers</h6>
            </div>
            <div class="page-btn">
                <button type="button" class="btn btn-added" data-toggle="modal" data-target="#top_up">
                    <img src="<?php echo get_bloginfo('template_directory'); ?>/src/img/plus.svg" class="me-2" alt="img"> Topup Reload
                </button>
                <a href="/add-reload-providers/" class="btn btn-added"><img src="<?php echo get_bloginfo('template_directory'); ?>/src/img/plus.svg" class="me-2" alt="img">Reload Provider</a>
            </div>
        </div>


        <!-- /product list -->
        <div class="card">
            <div class="card-body">
                <div class="table-top">
                    <div class="search-set">
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
                <div class="table-responsive">
                    <table class="table datanew">
                        <thead>
                            <tr>
                                <th>
                                    Provider ID
                                </th>
                                <th>Image</th>
                                <th>Reload Amount</th>
                                <th>Reload Commission</th>
                                <th>Commission type</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            if ($query->have_posts()) {
                                while ($query->have_posts()) {
                                    $query->the_post();
                                    $post_id = get_the_ID();
                                    $title = get_the_title();
                                    $featured_image = get_the_post_thumbnail_url($post_id);
                                    $reload_amount = get_post_meta($post_id, 'reload_amount', true);
                                    $reload_commission = get_post_meta($post_id, 'reload_commission', true);
                                    $commission_type = get_post_meta($post_id, 'commission_type', true);
                            ?>
                                    <tr>
                                        <td>
                                            #<?php echo $post_id; ?>
                                        </td>
                                        <td class="productimgname">
                                            <a href="javascript:void(0);" class="product-img">
                                                <img src="<?php if ($featured_image) {
                                                                echo $featured_image;
                                                            } else {
                                                                echo get_template_directory_uri() . '/src/img/noimage.png';
                                                            } ?>" alt="<?php echo $title; ?>">
                                            </a>
                                            <a href="javascript:void(0);">
                                                <?php echo $title; ?>
                                            </a>
                                        </td>
                                        <td>
                                            <?php echo get_woocommerce_currency_symbol() . ': ' . number_format((float) $reload_amount, 2, '.', ''); ?>
                                        </td>
                                        <td>
                                            <?php echo $reload_commission; ?>%
                                        </td>
                                        <td>
                                            <?php echo $commission_type; ?>
                                        </td>
                                        <td>
                                            <button type="button" class="me-3 delete_btn btn_style" post_id="<?php echo $post_id; ?>">
                                                <img src="<?php echo get_bloginfo('template_directory'); ?>/src/img/delete.svg" alt="img">
                                            </button>
                                        </td>
                                    </tr>
                            <?php }
                            } ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <!-- /product list -->
        <div id="top_up" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <form method="post" id="top_up_form">
                        <div class="row">
                            <div class="col-sm-12">
                                <h5>TopUp Reloads</h5>
                            </div>
                            <div class="col-sm-12">
                                <div class="form-group">
                                    <input type="number" name="top_up_amount" id="top_up_amount" placeholder="Please enter Topup Amount ..">
                                </div>
                            </div>
                            <div class="col-sm-12">
                                <div class="providers_items_wrap row">
                                    <?php
                                    if ($query->have_posts()) {
                                        while ($query->have_posts()) {
                                            $query->the_post();
                                            $post_id = get_the_ID();
                                            $title = get_the_title();
                                            $featured_image = get_the_post_thumbnail_url($post_id); ?>
                                            <div class="col-3">
                                                <div class="provider_item">
                                                    <img src="<?php echo $featured_image; ?>" alt="img" class="me-2">
                                                    <input type='radio' name='provider' value='<?php echo $post_id; ?>' required/>
                                                    <?php echo $title; ?>
                                                </div>
                                            </div>
                                    <?php }}; ?>
                                </div>
                            </div>
                        </div>
                        <div class="button_set">
                            <button type="submit" class="btn btn-submit me-2">
                                Reload Topup
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
</div>

<script>
    jQuery(document).ready(function($) {
        $('input[name=provider]').change(function() {
            $('.provider_item').removeClass('active');
            $(this).closest('.provider_item').addClass('active');
        });

        $('.delete_btn').on('click', function() {
            var categoryId = $(this).attr('post_id');
            Swal.fire({
                title: "Do you want to delete Category?",
                showDenyButton: true,
                // showCancelButton: true,
                confirmButtonText: "Yes",
                denyButtonText: `no`
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url: '/wp-json/v1/reload/delete-reload-provider',
                        type: 'POST',
                        data: {
                            'post_id': categoryId
                        },
                        success: function(response) {
                            Swal.fire({
                                icon: "success",
                                title: "success...",
                                text: response,
                            });
                            document.location.reload(true);
                        },
                        error: function(error) {
                            Swal.fire({
                                icon: "error",
                                title: "Oops...",
                                text: error,
                            });
                        }
                    });
                } else if (result.isDenied) {
                    Swal.fire({
                        icon: "error",
                        title: "Oops...",
                        text: error,
                    });
                }
            });
        });

        $("#top_up_form").submit(function(event) {
            event.preventDefault();
            const modalId = $(this).closest('.modal').attr('id');
            $(".global-loader").show();
            var formData = new FormData(this);

            $.ajax({
                type: "POST",
                url: "/wp-json/v1/reload/top-up", // Corrected the URL
                data: formData,
                contentType: false,
                processData: false,
                success: function(response) {
                    $(".global-loader").hide();
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
                        text: 'User denied the Updated.',
                    });
                }
            });
        });

    })
</script>