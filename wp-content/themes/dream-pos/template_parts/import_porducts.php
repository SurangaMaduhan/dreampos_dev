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
                                <a class="btn btn-submit w-100">Download Sample File</a>
                            </div>
                        </div>
                        <div class="col-lg-12" bis_skin_checked="1">
                            <div class="form-group">
                                <label>
                                Upload CSV File</label>
                                <div id="drop-area" class="mb-3">
                                    <img src="<?php echo get_bloginfo('template_directory'); ?>/src/img/upload.svg" alt="upload">
                                    <h4>Drag and drop a file to upload</h4>
                                    <input type="file" id="file-input" name="csv_file" accept=".csv">
                                </div>
                                <div id="preview_wrap" style="display: none;">
                                    <img id="file-preview" alt="File Preview">
                                    <button type="button" id="remove-btn">
                                        <i class="fa fa-times" aria-hidden="true"></i>
                                    </button>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-6 col-sm-12" bis_skin_checked="1">
                            <div class="productdetails productdetailnew" bis_skin_checked="1">
                                <ul class="product-bar">
                                    <li>
                                        <h4>Product Name</h4>
                                        <h6 class="manitorygreen">This Field is required</h6>
                                    </li>
                                    <li>
                                        <h4>Category</h4>
                                        <h6 class="manitorygreen">This Field is required</h6>
                                    </li>
                                    <li>
                                        <h4>SKU code</h4>
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
                                        <h4>Product Unit</h4>
                                        <h6 class="manitorygreen">This Field is required</h6>
                                    </li>
                                    <li>
                                        <h4>Description</h4>
                                        <h6 class="manitoryblue">Field optional</h6>
                                    </li>
                                </ul>
                            </div>
                        </div>
                        <div class="col-lg-6 col-sm-12" bis_skin_checked="1">
                            <div class="productdetails productdetailnew" bis_skin_checked="1">
                                <ul class="product-bar">
                                    <li>
                                        <h4>Minimum Qty</h4>
                                        <h6 class="manitoryblue">Field optional</h6>
                                    </li>
                                    <li>
                                        <h4>Quantity</h4>
                                        <h6 class="manitoryblue">Field optional</h6>
                                    </li>
                                    <li>
                                        <h4>Tax</h4>
                                        <h6 class="manitoryblue">Field optional</h6>
                                    </li>
                                    <li>
                                        <h4>Discount Type</h4>
                                        <h6 class="manitoryblue">Field optional</h6>
                                    </li>
                                    <li>
                                        <h4>Brand</h4>
                                        <h6 class="manitoryblue">Field optional</h6>
                                    </li>
                                    <li>
                                        <h4>Minimum Qty</h4>
                                        <h6 class="manitoryblue">Field optional</h6>
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
        <!-- /product list -->
    </div>
</div>

<script>
const dropArea = document.getElementById('drop-area');
const fileInput = document.getElementById('file-input');
const filePreview = document.getElementById('file-preview');
const removeBtn = document.getElementById('remove-btn');
const hide_wrap = document.getElementById('preview_wrap');

fileInput.addEventListener('change', () => {
    const files = fileInput.files;
    handleFiles(files);
});

removeBtn.addEventListener('click', () => {
    fileInput.value = ''; // Clear file input
    hideImagePreview();
});

function handleFiles(files) {
    if (files.length > 0) {
        const file = files[0];
        if (file.type.startsWith('image/')) {
            showImagePreview(file);
        } else {
            hideImagePreview();
        }
    } else {
        hideImagePreview();
    }
}

function showImagePreview(file) {
    const reader = new FileReader();

    reader.onload = function (e) {
        filePreview.src = e.target.result;
        hide_wrap.style.display = 'block';
    };

    reader.readAsDataURL(file);
}

function hideImagePreview() {
    filePreview.src = '';
    hide_wrap.style.display = 'none';
}

jQuery(document).ready(function ($) {
        const hide_wrap = document.getElementById('preview_wrap');
        $("#import_product").submit(function (event) {
            event.preventDefault();
            // $(".global-loader").show()
            var formData = new FormData(this);
            $.ajax({
                type: "POST",
                url: "/wp-json/v1/products/import_products",
                data: formData,
                contentType: false,
                processData: false,
                success: function (response) {
                    // $(".global-loader").hide();
                    // $("form").trigger('reset');
                    // hide_wrap.style.display = 'none'; 
                    console.log(response);
                    // Swal.fire({
                    //     icon: "success",
                    //     title: "success...",
                    //     text: response,
                    // });
                },
                error: function (error) {
                    // $(".global-loader").hide();
                    console.log(error.responseText);
                    // Swal.fire({
                    //     icon: "error",
                    //     title: "Oops...",
                    //     text: error,
                    // });
                }
            });
        });
    });
</script>