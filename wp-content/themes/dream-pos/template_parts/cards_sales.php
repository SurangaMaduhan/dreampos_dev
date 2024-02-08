<?php
$args_cards = array(
    'post_type' => 'cards',
    'posts_per_page' => -1,
    'post_status' => 'publish',
    'meta_query'     => array(
        array(
            'key'     => 'card_qut', // Replace with your actual meta key
            'value'   => 0,
            'compare' => '!=',
        ),
    ),
    // 'facetwp' => true
);
$query = new WP_Query($args_cards);
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
                                        <th>Sold Card provider</th>
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
                                                <td><?php echo get_the_date('Y-m-d H:i:s'); ?></td>
                                                <td><?php echo get_post_meta($post->ID, 'sale_item_provider', true); ?></td>
                                                <td><?php echo get_post_meta($post->ID, 'sale_item_count', true); ?></td>
                                                <td><?php echo get_woocommerce_currency_symbol() . ': ' . number_format((float)  get_post_meta($post->ID, 'sale_amount', true), 2, '.', ''); ?></td>
                                                <td><?php echo get_woocommerce_currency_symbol() . ': ' . number_format((float)get_post_meta($post->ID, 'sale_commission_amount', true), 2, '.', ''); ?></td>
                                            </tr>
                                        <?php }
                                    } else { ?>
                                        <tr>
                                            <td colspan="5">No Cards sale in the list</td>
                                        </tr>
                                    <?php }
                                    wp_reset_query(); ?>
                                </tbody>
                            </table>
                        </div>
                        <div class="col-sm-5">
                            <div class="cards_sale">
                                <div class="row">
                                    <div class="col-12">
                                        <h5>Cards Counter</h5>
                                    </div>
                                    <div class="card_filters">
                                        <div class="search-input">
                                            <div class="form-group"><input id="myInput2" type="text" placeholder="Search.."></div>
                                        </div>
                                    </div>

                                    <div class="cards_list">
                                        <div class="row">
                                            <?php
                                            if ($query->have_posts()) {
                                            // $loop = new WP_Query($args);
                                            while ($query->have_posts()) :
                                                $query->the_post();
                                                global $post;
                                            ?>
                                                <div class="col-sm-3">
                                                    <button type="button" class="me-3 card_sale" data-toggle="modal" data-target="#card_sale_<?php echo $post->ID; ?>">
                                                        <h3><?php echo get_post_meta($post->ID, 'amount', true); ?>/=</h3>
                                                        <span><?php echo get_post_meta($post->ID, 'card_provider', true); ?></span>
                                                    </button>
                                                    <div id="card_sale_<?php echo $post->ID; ?>" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel" aria-hidden="true">
                                                        <div class="modal-dialog">
                                                            <div class="modal-content">
                                                                <form method="post" class="card_sale">
                                                                    <div class="row">
                                                                        <div class="col-sm-12">
                                                                            <h6><?php echo  get_post_meta($post->ID, 'amount', true); ?>/=</h6>
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
                                            <?php endwhile; } else {
                                                echo 'No cards Avilable';
                                            }
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
        $("#myInput2").on("keyup", function() {
            var value = $(this).val().toLowerCase();
            $(".cards_list .row .col-sm-3").filter(function() {
                $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
            });
        });

        $(document).on('facetwp-refresh', function() {
            if (FWP.loaded) {
                $('.facetwp-template').prepend('<div class="global-loader"><div class="whirly-loader"> </div></div>');
            }
        });

        $(".card_sale").submit(function(event) {
            event.preventDefault();
            // const modalId = $(this).closest('.modal').attr('id');
            var error_mas = 'User denied the submit reload.';
            $(".global-loader").show();
            var formData = new FormData(this);
            $.ajax({
                type: "POST",
                url: "/wp-json/v1/cards/add-card-sale", // Corrected the URL
                data: formData,
                contentType: false,
                processData: false,
                success: function(response) {
                    console.log(response);
                    // console.log(response);
                    $('[data-dismiss="modal"]').trigger('click');
                    $(".global-loader").hide();
                    $("form").trigger('reset');
                    // $('.provider_item').removeClass('active');
                    Swal.fire({
                        icon: "success",
                        title: "success...",
                        text: response.message,
                    });
                    FWP.refresh();
                    document.location.reload(true);
                },
                error: function(error) {
                    if (error.responseJSON.status == 'out_stock') {
                        console.log(error.responseJSON.stock);
                        error_mas = 'Only Left ' + error.responseJSON.stock + 'Card(s) Only';
                    }
                    $('[data-dismiss="modal"]').trigger('click');
                    $(".global-loader").hide();
                    Swal.fire({
                        icon: "error",
                        title: "Oops...",
                        text: error_mas,
                    });
                    // FWP.refresh();
                    // FWP.facets['reload_status'].refresh();
                }
            });
        });

    });
</script>