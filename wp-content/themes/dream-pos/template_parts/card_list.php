<?php
global $paged;
if (!isset($paged) || !$paged) {
    $paged = 1;
}

$args = array(
    'post_type' => 'cards',
    'posts_per_page' => -1,
    'facetwp' => true,
); ?>

<div class="page-wrapper">
    <div class="content">
        <div class="page-header">
            <div class="page-title">
                <h4>Cards List</h4>
                <h6>Manage your Cards</h6>
            </div>
            <div class="page-btn">
                <button type="button" class="btn btn-added" data-toggle="modal" data-target="#top_up">
                    <img src="<?php echo get_bloginfo('template_directory'); ?>/src/img/plus.svg" class="me-2" alt="img"> Topup cards
                </button>
                <a href="/add-top-up-cards/" class="btn btn-added"><img src="<?php echo get_bloginfo('template_directory'); ?>/src/img/plus.svg" alt="img" class="me-1">Add New Card</a>
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
                                            <?php echo do_shortcode('[facetwp facet="card_provider"]'); ?>
                                        </div>
                                    </div>
                                    <div class="col-lg col-sm-1 col-12">
                                        <div class="form-group">
                                            <?php echo do_shortcode('[facetwp facet="reset"]'); ?>
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
                                <th>Card Name</th>
                                <th>Card Amount</th>
                                <th>Card provider</th>
                                <th>Card Commission</th>
                                <th>Commission type</th>
                                <th>Card Quantity</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody class="facetwp-template">
                            <?php
                            $loop = new WP_Query($args);
                            while ($loop->have_posts()) :
                                $loop->the_post();
                                global $post;
                            ?>
                                <tr>
                                    <td><?php the_title(); ?></td>
                                    <td><?php echo get_woocommerce_currency_symbol() . ': ' . number_format((float)  get_post_meta($post->ID, 'amount', true), 2, '.', ''); ?></td>
                                    <td><?php echo get_post_meta($post->ID, 'card_provider', true); ?></td>
                                    <td><?php echo get_post_meta($post->ID, 'card_commission', true); ?></td>
                                    <td><?php echo get_post_meta($post->ID, 'card_commission_type', true); ?></td>
                                    <td><?php echo get_post_meta($post->ID, 'card_qut', true); ?></td>
                                    <td>
                                        <button type="button" class="me-3" data-toggle="modal" data-target="#card_edit_<?php echo $post->ID; ?>">
                                            <img src="<?php echo get_bloginfo('template_directory'); ?>/src/img/edit.svg" alt="img">
                                        </button>
                                        <button type="button" class="remove_product" pr_id="<?php echo $post->ID; ?>">
                                            <img src="<?php echo get_bloginfo('template_directory'); ?>/src/img/delete.svg" alt="img">
                                        </button>
                                        <div id="card_edit_<?php echo $post->ID; ?>" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel" aria-hidden="true">
                                            <div class="modal-dialog">
                                                <div class="modal-content">
                                                    <form method="post" class="edit_cards">
                                                        <div class="row">
                                                            <div class="col-sm-12">
                                                                <h5>Update "<?php echo the_title(); ?>" Card</h5>
                                                            </div>
                                                            <div class="col-sm-12">
                                                                <div class="form-group">
                                                                    <label for="card_amount">Card Amount</label>
                                                                    <input type="text" name="card_amount" value="<?php echo get_post_meta($post->ID, 'amount', true); ?>">
                                                                </div>
                                                            </div>
                                                            <div class="col-sm-12">
                                                                <div class="form-group">
                                                                    <label for="card_commission">Card Commission</label>
                                                                    <input type="text" name="card_commission" value="<?php echo get_post_meta($post->ID, 'card_commission', true); ?>">
                                                                </div>
                                                            </div>
                                                            <div class="col-sm-12">
                                                                <div class="form-group">
                                                                    <label for="card_commission_type">Card Commission Type</label>
                                                                    <select name="card_commission_type" required>
                                                                        <option value="">Choose Commission type</option>
                                                                        <option value="fixed" <?php
                                                                                                if (get_post_meta($post->ID, 'card_commission_type', true) == 'fixed') {
                                                                                                    echo 'selected';
                                                                                                }; ?>>Fixed</option>
                                                                        <option value="percentage" <?php
                                                                                                    if (get_post_meta($post->ID, 'card_commission_type', true) == 'percentage') {
                                                                                                        echo 'selected';
                                                                                                    }; ?>>Percentage</option>
                                                                    </select>
                                                                </div>
                                                            </div>
                                                            <div class="col-sm-12">
                                                                <div class="form-group">
                                                                    <label for="card_provider">Card Providers</label>
                                                                    <select name="card_provider" id="card_provider" required>
                                                                        <option value="">Choose Category</option>
                                                                        <option value="dialog" <?php if (get_post_meta($post->ID, 'card_provider', true) == 'dialog') {
                                                                                                    echo 'selected';
                                                                                                } ?>>Dialog</option>
                                                                        <option value="mobitel" <?php if (get_post_meta($post->ID, 'card_provider', true) == 'mobitel') {
                                                                                                    echo 'selected';
                                                                                                } ?>>Mobitel</option>
                                                                        <option value="hutch" <?php if (get_post_meta($post->ID, 'card_provider', true) == 'hutch') {
                                                                                                    echo 'selected';
                                                                                                } ?>>Hutch</option>
                                                                        <option value="airtel" <?php if (get_post_meta($post->ID, 'card_provider', true) == 'airtel') {
                                                                                                    echo 'selected';
                                                                                                } ?>>Airtel</option>
                                                                        <option value="lanka bell" <?php if (get_post_meta($post->ID, 'card_provider', true) == 'lanka bell') {
                                                                                                        echo 'selected';
                                                                                                    } ?>>Lanka Bell</option>
                                                                    </select>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="button_set">
                                                            <input type="hidden" name="card_id" value="<?php echo $post->ID; ?>">
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
        <div id="top_up" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <form method="post" id="top_up_card">
                        <div class="row">
                            <div class="col-sm-12">
                                <h5>TopUp Reloads</h5>
                            </div>
                            <div class="col-sm-12">
                                <div class="form-group">
                                    <input type="number" name="top_up_card" id="top_up_card" placeholder="Please enter Card topup Count ..">
                                </div>
                            </div>
                            <div class="col-sm-12">
                                <div class="form-group">
                                    <select name="card" id="card">
                                        <option value="">-- Select Card --</option>
                                        <?php
                                        $loop = new WP_Query($args);
                                        while ($loop->have_posts()) :
                                            $loop->the_post();
                                            global $post;
                                        ?>
                                            <option value="<?php echo $post->ID; ?>"><?php echo get_post_meta($post->ID, 'card_provider', true); ?> <?php the_title(); ?></option>
                                        <?php endwhile;
                                        wp_reset_query();
                                        // echo facetwp_display('per_page');
                                        ?>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="button_set">
                            <button type="submit" class="btn btn-submit me-2">
                                Crads Topup
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
        $(document).on('click', '.remove_product', function() {
            var productID = $(this).attr('pr_id');
            Swal.fire({
                title: "Do you want to delete Card?",
                showDenyButton: true,
                confirmButtonText: "Yes",
                denyButtonText: "No"
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url: '/wp-json/v1/cards/remove-cards',
                        type: 'POST',
                        data: {
                            'post_id': productID
                        },
                        success: function(response) {
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
        $(document).on('submit', '.edit_cards', function(event) {
            event.preventDefault();
            const modalId = $(this).closest('.modal').attr('id');
            $(".global-loader").show();
            var formData = new FormData(this);
            $.ajax({
                type: "POST",
                url: "/wp-json/v1/cards/update-cards", // Corrected the URL
                data: formData,
                contentType: false,
                processData: false,
                success: function(response) {
                    FWP.refresh();
                    $(".global-loader").hide();
                    $('[data-dismiss="modal"]').trigger('click');
                    Swal.fire({
                        icon: "success",
                        title: "success...",
                        text: response.message,
                    });
                },
                error: function(error) {
                    Swal.fire({
                        icon: "error",
                        title: "Oops...",
                        text: 'User denied the deletion.',
                    });
                }
            });
        });

        $("#top_up_card").submit(function(event) {
            event.preventDefault();
            const modalId = $(this).closest('.modal').attr('id');
            $(".global-loader").show();
            var formData = new FormData(this);

            $.ajax({
                type: "POST",
                url: "/wp-json/v1/cards/top-ups", // Corrected the URL
                data: formData,
                contentType: false,
                processData: false,
                success: function(response) {
                    $(".global-loader").hide();
                    $('[data-dismiss="modal"]').trigger('click');
                    FWP.refresh();
                    Swal.fire({
                        icon: "success",
                        title: "success...",
                        text: 'ID ' + response + ' Updated',
                    });
                    // document.location.reload(true);
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
    });
</script>