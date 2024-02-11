<div class="page-wrapper">
    <div class="content">
        <div class="page-header">
            <div class="page-title">
                <h4>Brand ADD</h4>
                <h6>Create new Brand</h6>
            </div>
        </div>
        <!-- /add -->
        <div class="card">
            <div class="card-body">
                <form method="post" id="add_card">
                    <div class="row">
                        <div class="col-lg-4 col-sm-12 col-12">
                            <div class="form-group">
                                <label>Card Name</label>
                                <input type="text" name="card_name">
                            </div>
                        </div>
                        <div class="col-lg-4 col-sm-12 col-12">
                            <div class="form-group">
                                <label>Card Providers</label>
                                <select class="select" name="card_provider" id="card_provider" required>
                                    <option value="">Choose Category</option>
                                    <option value="dialog">Dialog</option>
                                    <option value="mobitel">Mobitel</option>
                                    <option value="hutch">Hutch</option>
                                    <option value="airtel">Airtel</option>
                                    <option value="lanka bell">Lanka Bell</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-lg-4 col-sm-12 col-12">
                            <div class="form-group">
                                <label>Card amount</label>
                                <input type="text" name="card_amount">
                            </div>
                        </div>
                        <div class="col-lg-4 col-sm-12 col-12">
                            <div class="form-group">
                                <label>Card Quntity</label>
                                <input type="text" name="card_qut">
                            </div>
                        </div>
                        <div class="col-lg-4 col-sm-12 col-12">
                            <div class="form-group">
                                <label>Card commission</label>
                                <input type="text" name="card_commission">
                            </div>
                        </div>
                        <div class="col-lg-4 col-sm-12 col-12">
                            <div class="form-group">
                                <label>Card commission type</label>
                                <select class="select" name="card_commission_type" id="card_commission_type" required>
                                    <option value="">Choose Commission type</option>
                                    <option value="fixed">Fixed</option>
                                    <option value="percentage">Percentage</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-lg-12">
                            <button type="submit" class="btn btn-submit me-2">
                                Submit
                            </button>
                            <a href="brandlist.html" class="btn btn-cancel">Cancel</a>
                        </div>
                    </div>
                </form>
            </div>
        </div>
        <!-- /add -->
        <div class="global-loader" style="display:none">
            <div class="whirly-loader"> </div>
        </div>
    </div>
</div>

<script>
    jQuery(document).ready(function($) {
        const hide_wrap = document.getElementById('preview_wrap');
        $("#add_card").submit(function(event) {
            event.preventDefault();
            $(".global-loader").show()
            var formData = new FormData(this);
            $.ajax({
                type: "POST",
                url: "/wp-json/v1/cards/add-card",
                data: formData,
                contentType: false,
                processData: false,
                success: function(response) {
                    $(".global-loader").hide();
                    $("form").trigger('reset');
                    $('select').prop('selectedIndex', 0);
                    Swal.fire({
                        icon: "success",
                        title: "success...",
                        text: response,
                    });
                },
                error: function(error) {
                    $(".global-loader").hide();
                    Swal.fire({
                        icon: "error",
                        title: "Oops...",
                        text: error,
                    });
                }
            });
        });
    });
</script>