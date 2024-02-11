<div class="page-wrapper ms-0">
    <div class="content">
        <div class="row">
            <div class="col-lg-8 col-sm-12 tabs_wrapper">
                <div class="page-header ">
                    <div class="page-title">
                        <h4>Categories</h4>
                        <h6>Manage your purchases</h6>
                    </div>
                </div>
                <div class="pos-products-list">

                    <?php include_once 'pos_product_list.php'; ?>

                    <div class="mini_loder_product" style="display:none">
                        <div class="whirly-loader"> </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-4 col-sm-12 overs">
                <?php include_once 'pos_order_list.php'; ?>

                <div class="global-loader new_opener" style="display:none">
                    <div class="whirly-loader"> </div>
                </div>
            </div>
        </div>
    </div>
    <div class="global-loader" style="display:none">
        <div class="whirly-loader"> </div>
    </div>
</div>

<script>
    jQuery(document).ready(function($) {
        // Function to update cart quantity
        function updateCartQuantity(key, quantity) {
            // alert(wc_cart_params);
            $.ajax({
                type: 'POST',
                url: '/wp-admin/admin-ajax.php',
                data: {
                    action: 'update_mini_cart',
                    cart_key: key,
                    quantity: quantity,
                },
                success: function(response) {
                    if (response && !response.error) {
                        // Update mini cart content
                        $('.widget_shopping_cart_content').html(response);
                        $(document.body).trigger('wc_fragment_refresh');
                    }
                },
            });
        }
        // Attach change event to the quantity input field
        $(document).on('change', '.qty', function() {
            var key = $(this).attr('name');
            var quantity = $(this).val();
            updateCartQuantity(key, quantity);
        });
    });
</script>