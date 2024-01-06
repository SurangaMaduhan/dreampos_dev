<?php
$product_categories = get_terms(
    array(
        'taxonomy' => 'brands',
        'hide_empty' => false,
    )
);
?>
<div class="page-wrapper">
    <div class="content">
        <div class="page-header">
            <div class="page-title">
                <h4>Brand List</h4>
                <h6>Manage your Brand</h6>
            </div>
            <div class="page-btn">
                <a href="/add-brand/" class="btn btn-added"><img src="<?php echo get_bloginfo('template_directory'); ?>/src/img/plus.svg" class="me-2" alt="img">Add Brand</a>
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
                            <a class="btn btn-searchset"><img src="<?php echo get_bloginfo('template_directory'); ?>/src/img/search-white.svg" alt="img"></a>
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
                <div class="card" id="filter_inputs">
                    <div class="card-body pb-0">
                        <div class="row">
                            <div class="col-lg-3 col-sm-6 col-12">
                                <div class="form-group">
                                    <input type="text" placeholder="Enter Brand Name">
                                </div>
                            </div>
                            <div class="col-lg-3 col-sm-6 col-12">
                                <div class="form-group">
                                    <input type="text" placeholder="Enter Brand Description">
                                </div>
                            </div>
                            <div class="col-lg-1 col-sm-6 col-12 ms-auto">
                                <div class="form-group">
                                    <a class="btn btn-filters ms-auto"><img src="<?php echo get_bloginfo('template_directory'); ?>/src/img/search-whites.svg" alt="img"></a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- /Filter -->
                <div class="table-responsive">
                    <table class="table datanew">
                        <thead>
                            <tr>
                                <th>
                                    <label class="checkboxs">
                                        <input type="checkbox" id="select-all">
                                        <span class="checkmarks"></span>
                                    </label>
                                </th>
                                <th>Image</th>
                                <th>Brand Name</th>
                                <th>Brand Description</th>
                                <th>Brand Description</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($product_categories as $category) {
                                $category_id = $category->term_id;
                                $thumbnail_id = get_option('z_taxonomy_image_id' . $category_id);
                                $thumbnail_url = wp_get_attachment_thumb_url($thumbnail_id);
                                ?>
                                <tr>
                                    <td>
                                        <label class="checkboxs">
                                            <input type="checkbox">
                                            <span class="checkmarks"></span>
                                        </label>
                                    </td>
                                    <td class="productimgname">
                                        <a href="javascript:void(0);" class="product-img">
                                            <img src="<?php if ($thumbnail_url) {
                                                echo $thumbnail_url;
                                            } else {
                                                echo get_template_directory_uri() . '/src/img/noimage.png';
                                            } ?>" alt="<?php echo $category->name; ?>">
                                        </a>
                                        <a href="javascript:void(0);">
                                            <?php echo $category->name; ?>
                                        </a>
                                    </td>
                                    <td>
                                        <?php echo $category->term_taxonomy_id; ?>
                                    </td>
                                    <td>
                                        <?php echo $category->slug; ?>
                                    </td>
                                    <td>
                                        <?php echo $category->count; ?>
                                    </td>
                                    <td>
                                        <a href="/update-brand/?brand_id=<?php echo $category_id; ?>" class="me-3 btn_style">
                                            <img src="<?php echo get_bloginfo('template_directory'); ?>/src/img/edit.svg" alt="img">
                                        </a>
                                        <button type="button" class="me-3 delete_btn btn_style" pr_id="<?php echo $category->term_taxonomy_id; ?>">
                                            <img src="<?php echo get_bloginfo('template_directory'); ?>/src/img/delete.svg" alt="img">
                                        </button>
                                    </td>
                                </tr>
                        <?php } ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <!-- /product list -->
</div></div>

<script>
    jQuery(document).ready(function($){
        $('.delete_btn').on('click', function () {
		var categoryId = $(this).attr('pr_id');
		Swal.fire({
			title: "Do you want to delete Category?",
			showDenyButton: true,
			// showCancelButton: true,
			confirmButtonText: "Yes",
			denyButtonText: `no`
		}).then((result) => {
			if (result.isConfirmed) {
				$.ajax({
					url: '/wp-json/v1/products/remove_brand',
					type: 'POST',
					data: {'cat_id': categoryId},
					success: function (response) {
                        Swal.fire({
                            icon: "success",
                            title: "success...",
                            text: response.message,
                        });
						document.location.reload(true);
					},
					error: function (error) {
						Swal.fire({
							icon: "error",
							title: "Oops...",
							text: error,
						});
					}
				});
			} else if (result.isDenied) {
				Swal.fire({
					icon: "error",
					title: "Oops...",
					text: error,
				});
			}
		});
	});
    })
</script>

