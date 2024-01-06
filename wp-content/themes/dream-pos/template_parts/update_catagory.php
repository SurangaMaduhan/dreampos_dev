<?php 
    $category_id = $_GET['category-id'];
    $term = get_term($category_id);
    $thumbnail_id = get_woocommerce_term_meta($category_id, 'thumbnail_id', true);
    $thumbnail_url = wp_get_attachment_thumb_url($thumbnail_id);
?>
<div class="page-wrapper with_loader">
    <div class="content">
        <div class="page-header">
            <div class="page-title">
                <h4>Update Product ID #<?php echo $category_id;?> Category</h4>
                <h6>Update product Category Details</h6>
            </div>
        </div>
        <!-- /add -->
        <div class="card">
            <div class="card-body">
                <form id="add_catagory_form" method="post" enctype="multipart/form-data">
                    <div class="row">
                        <div class="col-lg-12 col-sm-12 col-12">
                            <div class="form-group">
                                <label>Category Name</label>
                                <input type="text" name="category_name" value="<?php echo $term->name;?>" required>
                            </div>
                        </div>
                        <div class="col-lg-12">
                            <div class="form-group">
                                <label> Category Image</label>
                                <div id="drop-area" class="mb-3">
                                    <img src="<?php echo get_bloginfo('template_directory'); ?>/src/img/upload.svg"
                                        alt="upload">
                                    <h4>Drag and drop a file to upload</h4>
                                    <input type="file" id="file-input" accept="image/*" name="thumbnail">
                                </div>
                                <div id="preview_wrap">
                                    <img id="file-preview" alt="File Preview" 
                                        src="<?php if ($thumbnail_url) {
                                            echo $thumbnail_url;
                                        } else {
                                            echo get_template_directory_uri() . '/src/img/noimage.png';
                                        };
                                    ?>">
                                    <button type="button" id="remove-btn"><i class="fa fa-times" aria-hidden="true"></i></button>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-12">
                            <input type="hidden" name="category_id" value="<?php echo $category_id ?>">
                            <button type="submit" class="btn btn-submit me-2">Submit</button>
                            <a href="/category-list/" class="btn btn-cancel">Cancel</a>
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
        $("#add_catagory_form").submit(function (event) {
            event.preventDefault();
            $(".global-loader").show()
            var formData = new FormData(this);
            $.ajax({
                type: "POST",
                url: "/wp-json/v1/products/update-category",
                data: formData,
                contentType: false,
                processData: false,
                success: function (response) {
                    $(".global-loader").hide();
                    Swal.fire({
                        icon: "success",
                        title: "success...",
                        text: response,
                    });
                    window.location.href = "/category-list/";
                },
                error: function (error) {
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