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
                <form method="post" id="add_brands">
                    <div class="row">
                        <div class="col-lg-12 col-sm-12 col-12">
                            <div class="form-group">
                                <label>Brand Name</label>
                                <input type="text" name="brand_name">
                            </div>
                        </div>
                        <div class="col-lg-12">
                            <div class="form-group">
                                <label>
                                    Product Image</label>
                                <div id="drop-area" class="mb-3">
                                    <img src="<?php echo get_bloginfo('template_directory'); ?>/src/img/upload.svg" alt="upload">
                                    <h4>Drag and drop a file to upload</h4>
                                    <input type="file" id="file-input" accept="image/*" name="thumbnail">
                                </div>
                                <div id="preview_wrap" style="display:none">
                                    <img id="file-preview" alt="File Preview">
                                    <button type="button" id="remove-btn">
                                        <i class="fa fa-times" aria-hidden="true"></i>
                                    </button>
                                </div>
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
        $("#add_brands").submit(function (event) {
            event.preventDefault();
            $(".global-loader").show()
            var formData = new FormData(this);
            $.ajax({
                type: "POST",
                url: "/wp-json/v1/products/add-brand",
                data: formData,
                contentType: false,
                processData: false,
                success: function (response) {
                    $(".global-loader").hide();
                    $("form").trigger('reset');
                    hide_wrap.style.display = 'none'; 
                    console.log(response.responseText);
                    // Swal.fire({
                    //     icon: "success",
                    //     title: "success...",
                    //     text: response,
                    // });
                },
                error: function (error) {
                    $(".global-loader").hide();
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