<div class="page-wrapper" bis_skin_checked="1">
    <div class="content" bis_skin_checked="1">
        <div class="page-header" bis_skin_checked="1">
            <div class="page-title" bis_skin_checked="1">
                <h4>Import Products</h4>
                <h6>Bulk upload your products</h6>
            </div>
        </div>

        <!-- /product list -->
        <div class="card" bis_skin_checked="1">
            <div class="card-body" bis_skin_checked="1">
                <div class="requiredfield" bis_skin_checked="1">
                    <h4>Field must be in csv format</h4>
                </div>
                <form id="import_product" method="post">
                    <div class="row" bis_skin_checked="1">
                        <div class="col-lg-3 col-sm-6 col-12" bis_skin_checked="1">
                            <div class="form-group" bis_skin_checked="1">
                                <a class="btn btn-submit w-100" href="<?php echo get_bloginfo('template_directory'); ?>/src/img/Sample_CSV.csv" download>Download Sample File</a>
                            </div>
                        </div>
                        <div class="col-lg-12" bis_skin_checked="1">
                            <div class="form-group">
                                <div class="mb-3">
                                    <label for="formFile" class="form-label">Upload CSV File</label>
                                    <input class="form-control"type="file" name="csv_file" accept=".csv" required>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-12 col-sm-12" bis_skin_checked="1">
                            <div class="productdetails productdetailnew" bis_skin_checked="1">
                                <ul class="product-bar">
                                    <li>
                                        <h4>Product Name</h4>
                                        <h6 class="manitorygreen">This Field is required</h6>
                                    </li>
                                    <li>
                                        <h4>SKU code</h4>
                                        <h6 class="manitorygreen">This Field is required</h6>
                                    </li>
                                    <li>
                                        <h4>QTY </h4>
                                        <h6 class="manitorygreen">This Field is required</h6>
                                    </li>
                                    <li>
                                        <h4>Product Cost</h4>
                                        <h6 class="manitorygreen">This Field is required</h6>
                                    </li>
                                    <li>
                                        <h4>Product Price</h4>
                                        <h6 class="manitorygreen">This Field is required</h6>
                                    </li>
                                    <li>
                                        <h4>Category ID</h4>
                                        <h6 class="manitorygreen">This Field is required</h6>
                                    </li>
                                    <li>
                                        <h4>Brand ID</h4>
                                        <h6 class="manitorygreen">This Field is required</h6>
                                    </li>
                                </ul>
                            </div>
                        </div>
                        <div class="col-lg-12" bis_skin_checked="1">
                            <div class="form-group mb-0" bis_skin_checked="1">
                                <button class="btn btn-submit me-2" type="submit">Submit</button>
                                <a href="javascript:void(0);" class="btn btn-cancel">Cancel</a>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
        <div class="global-loader" style="display:none">
            <div class="whirly-loader"> </div>
        </div>
        <!-- /product list -->
    </div>
</div>

<script>
jQuery(document).ready(function ($) {
        const hide_wrap = document.getElementById('preview_wrap');
        $("#import_product").submit(function (event) {
            event.preventDefault();
            $(".global-loader").show()
            var formData = new FormData(this);
            $.ajax({
                type: "POST",
                url: "/wp-json/v1/products/import_products",
                data: formData,
                contentType: false,
                processData: false,
                success: function (response) {
                    $(".global-loader").hide();
                    // $("form").trigger('reset');
                    // hide_wrap.style.display = 'none'; 
                    // console.log(response);
                    Swal.fire({
                        icon: "success",
                        title: "success...",
                        text: response,
                    });
                },
                error: function (error) {
                    $(".global-loader").hide();
                    // console.log(error);
                    Swal.fire({
                        icon: "error",
                        title: "Product Import Failed..",
                        text: 'Please check your CSV and try again',
                    });
                }
            });
        });
    });
</script>