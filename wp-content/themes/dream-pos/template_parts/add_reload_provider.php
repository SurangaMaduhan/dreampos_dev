<div class="page-wrapper">
    <div class="content">
        <div class="page-header">
            <div class="page-title">
                <h4>Reload Provider Add</h4>
                <h6>Create Reload Provider</h6>
            </div>
        </div>
        <!-- /add -->
        <div class="card">
            <div class="card-body">
                <form method="post" id="add_reload_provider">
                    <div class="row">
                        <div class="col-3">
                            <div class="form-group">
                                <label for="ProviderName">Provider Name:</label>
                                <input type="text" id="title" name="title" required>
                            </div>
                        </div>
                        <div class="col-3">
                            <div class="form-group">
                                <label for="reload_commission">Reload Commission:</label>
                                <input type="text" id="reload_commission" name="reload_commission" required>
                            </div>
                        </div>
                        <div class="col-3">
                            <div class="form-group">
                                <label for="reload_amount">Reload Amount:</label>
                                <input type="number" id="reload_amount" name="reload_amount" required>
                            </div>
                        </div>
                        <div class="col-3">
                            <div class="form-group">
                                <label for="commission_type">Reload Amount:</label>
                                <select name="commission_type" id="commission_type" class="style_select select" required>
                                    <option value=""> -- Select commission Type -- </option>
                                    <option value="before"> Before commission </option>
                                    <option value="after"> After commission </option>
                                </select>
                            </div>
                        </div>
                        <div class="col-3">
                            <div class="form-group">
                                <label for="use_another_provider">Use another Provider Amount</label>
                                <input type="checkbox" name="use_another_provider" id="use_another_provider">
                            </div>
                        </div>
                        <div class="col-3 open_only_another_rovider" style="display:none">
                            <div class="form-group">
                                <label for="existing_provider">Existing Provider list</label>
                                <select name="existing_provider" id="existing_provider" class="style_select select">
                                    <option value="">-- Select Provider --</option>
                                    <?php
                                    $provider_args = array(
                                        'post_type' => 'reload_providers',
                                        'posts_per_page' => -1,
                                        'post_status' => 'publish',
                                    );

                                    $provider_query = new WP_Query($provider_args);
                                    ?>
                                    <?php if ($provider_query->have_posts()) {
                                        while ($provider_query->have_posts()) {
                                            $provider_query->the_post();
                                            $post_id = get_the_ID();
                                            $title = get_the_title();
                                    ?>
                                            <option value="<?php echo $post_id; ?>"><?php echo $title; ?></option>
                                    <?php }
                                    } ?>
                                </select>
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="form-group">
                                <label> Category Image</label>
                                <div id="drop-area" class="mb-3">
                                    <img src="<?php echo get_bloginfo('template_directory'); ?>/src/img/upload.svg" alt="upload">
                                    <h4>Drag and drop a file to upload</h4>
                                    <input type="file" id="file-input" accept="image/*" name="thumbnail">
                                </div>
                                <div id="preview_wrap" style="display:none">
                                    <img id="file-preview" alt="File Preview">
                                    <button type="button" id="remove-btn"><i class="fa fa-times" aria-hidden="true"></i></button>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-12">
                            <input type="submit" value="Add User" class="btn btn-submit me-2">
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

    const checkbox = document.getElementById('use_another_provider');
    const open_only_another_rovider = document.querySelector('.open_only_another_rovider');

    checkbox.addEventListener('change', function() {
        if (checkbox.checked) {
            open_only_another_rovider.style.display = 'block';
            jQuery('#reload_amount').removeAttr('required');
        } else {
            open_only_another_rovider.style.display = 'none';
            jQuery('#reload_amount').attr('required' , true);
        }
    });

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

        reader.onload = function(e) {
            filePreview.src = e.target.result;
            hide_wrap.style.display = 'block';
        };

        reader.readAsDataURL(file);
    }

    function hideImagePreview() {
        filePreview.src = '';
        hide_wrap.style.display = 'none';
    }

    jQuery(document).ready(function($) {
        const hide_wrap = document.getElementById('preview_wrap');
        $("#add_reload_provider").submit(function(event) {
            event.preventDefault();
            $(".global-loader").show()
            var formData = new FormData(this);
            // console.log(formData);
            $.ajax({
                type: "POST",
                url: "/wp-json/v1/reload/add-reload-provider",
                data: formData,
                contentType: false,
                processData: false,
                success: function(response) {
                    // console.log(response);
                    $(".global-loader").hide();
                    $("form").trigger('reset');
                    hide_wrap.style.display = 'none';
                    Swal.fire({
                        icon: "success",
                        title: "Reload Provider added...",
                        text: response,
                    });
                    // window.location.href = "/brand-list/";
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