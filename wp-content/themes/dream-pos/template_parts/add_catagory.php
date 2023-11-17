<div class="page-wrapper">
    <div class="content">
        <div class="page-header">
            <div class="page-title">
                <h4>Product Add Category</h4>
                <h6>Create new product Category</h6>
            </div>
        </div>
        <!-- /add -->
        <div class="card">
            <div class="card-body">
                <form  action="/wp-json/v1/products/add-category" method="post" enctype="multipart/form-data">
                    <div class="row">
                        <div class="col-lg-12 col-sm-12 col-12">
                            <div class="form-group">
                                <label>Category Name</label>
                                <input type="text" name="category_name">
                            </div>
                        </div>
                        <div class="col-lg-12">
                            <div class="form-group">
                                <label> Category Image</label>
                                <div id="drop-area" class="mb-3">
                                    <img src="<?php echo get_bloginfo('template_directory'); ?>/src/img/upload.svg"
                                        alt="upload">
                                    <p></p>
                                    <input type="file" id="file-input" accept="image/*" name="thumbnail" >
                                </div>
                                <div id="preview_wrap" style="display:none">
                                    <img id="file-preview" alt="File Preview">
                                    <button id="remove-btn"><i class="fa fa-times" aria-hidden="true"></i></button>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-12">
                            <button type="submit" class="btn btn-submit me-2">Submit</button>
                            <a href="categorylist.html" class="btn btn-cancel">Cancel</a>
                        </div>
                    </div>
                </form>
            </div>
        </div>
        <!-- /add -->
    </div>
</div>