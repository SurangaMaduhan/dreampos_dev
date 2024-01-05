<div class="page-wrapper">
    <div class="content">
        <div class="page-header">
            <div class="page-title">
                <h4>Product Add</h4>
                <h6>Create new product</h6>
            </div>
        </div>
        <!-- /add -->

        <?php
        // Get WooCommerce product categories
        $categories = get_categories(
            array(
                'taxonomy' => 'product_cat',
                'orderby' => 'name',
                'show_count' => 0,
                'pad_counts' => 0,
                'hierarchical' => 1,
                'title_li' => '',
                'hide_empty' => 0,
            )
        );
        ?>


        <div class="card">
            <div class="card-body">
                <form method="post" enctype="multipart/form-data" id="create_product_form">
                    <div class="row">
                        <div class="col-lg-3 col-sm-6 col-12">
                            <div class="form-group">
                                <label>Product Name</label>
                                <input type="text" name="product_title" id="product_title" required>
                            </div>
                        </div>
                        <div class="col-lg-3 col-sm-6 col-12">
                            <div class="form-group">
                                <label>Category</label>
                                <select class="select" name="product_category" id="product_category" required>
                                    <option value="">Choose Category</option>
                                    <?php foreach ($categories as $category) {
                                        echo '<option value="' . $category->slug .'">' . $category->name . '</option>';
                                    };?>
                                </select>
                            </div>
                        </div>
                        <div class="col-lg-3 col-sm-6 col-12">
                            <div class="form-group">
                                <label>SKU</label>
                                <input type="text" name="product_sku" required>
                            </div>
                        </div>
                        <div class="col-lg-3 col-sm-6 col-12">
                            <div class="form-group">
                                <label>Quantity</label>
                                <input type="number" name="quantity" required>
                            </div>
                        </div>
                        <div class="col-lg-3 col-sm-6 col-12">
                            <div class="form-group">
                                <label>Cost</label>
                                <input type="number" name="product_cost" id="product_cost" required>
                            </div>
                        </div>
                        <div class="col-lg-3 col-sm-6 col-12">
                            <div class="form-group">
                                <label>Price</label>
                                <input type="number" name="product_price" id="product_price" required>
                            </div>
                        </div>
                        <div class="col-lg-12">
                            <div class="form-group">
                                <label>Description</label>
                                <textarea name="product_description" id="product_description" class="form-control"></textarea>
                            </div>
                        </div>
                        <div class="col-lg-12">
                            <div class="form-group">
                                <label>
                                    Category Image</label>
                                <div id="drop-area" class="mb-3">
                                    <img src="<?php echo get_bloginfo('template_directory'); ?>/src/img/upload.svg" alt="upload">
                                    <h4>Drag and drop a file to upload</h4>
                                    <input type="file" name="product_image" id="file-input" accept="image/*">
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
                            <input type="submit" value="Add Product" class="btn btn-submit me-2">
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
        $("#create_product_form").submit(function (event) {
            event.preventDefault();

            $(".global-loader").show()
            var formData = new FormData(this);

            // console.log(formData);
            $.ajax({
                type: "POST",
                url: "/wp-json/v1/products/add-new-product",
                data: formData,
                contentType: false,
                processData: false,
                success: function (response) {
                    $(".global-loader").hide();
                    $("form").trigger('reset');
                    hide_wrap.style.display = 'none'; 
                    Swal.fire({
                        icon: "success",
                        title: "success...",
                        text: response,
                    });
                },
                error: function (error) {
                    $(".global-loader").hide();
                    Swal.fire({
                        icon: "error",
                        title: "Oops...",
                        text:error,
                    });
                }
            });
        });
    });
</script>

