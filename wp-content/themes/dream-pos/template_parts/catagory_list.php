<?php
$product_categories = get_terms(array(
    'taxonomy' => 'product_cat',
    'hide_empty' => false,
));
?>

<div class="page-wrapper">
    <div class="content">
        <div class="page-header">
            <div class="page-title">
                <h4>Product Category list</h4>
                <h6>View/Search product Category</h6>
            </div>
            <div class="page-btn">
                <a href="/add-category/" class="btn btn-added">
                    <img src="<?php echo get_bloginfo('template_directory'); ?>/src/img/plus.svg" class="me-1"
                        alt="img">Add Category
                </a>
            </div>
        </div>


        <!-- /product list -->
        <div class="card">
            <div class="card-body">
                <div class="table-top">
                    <div class="search-set">
                        <div class="search-input">
                            <a class="btn btn-searchset"><img
                                    src="<?php echo get_bloginfo('template_directory'); ?>/src/img/search-white.svg"
                                    alt="img"></a>
                        </div>
                    </div>
                    <div class="wordset">
                        <ul>
                            <li>
                                <a data-bs-toggle="tooltip" data-bs-placement="top" title="pdf"><img
                                        src="<?php echo get_bloginfo('template_directory'); ?>/src/img/pdf.svg"
                                        alt="img"></a>
                            </li>
                            <li>
                                <a data-bs-toggle="tooltip" data-bs-placement="top" title="excel"><img
                                        src="<?php echo get_bloginfo('template_directory'); ?>/src/img/excel.svg"
                                        alt="img"></a>
                            </li>
                            <li>
                                <a data-bs-toggle="tooltip" data-bs-placement="top" title="print"><img
                                        src="<?php echo get_bloginfo('template_directory'); ?>/src/img/printer.svg"
                                        alt="img"></a>
                            </li>
                        </ul>
                    </div>
                </div>
                <div class="table-responsive">
                    <table class="table  datanew">
                        <thead>
                            <tr>
                               
                                <th>Category name</th>
                                <th>Category ID</th>
                                <th>Slug</th>
                                <th>Related Product Count</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($product_categories as $category) {
                                $category_id = $category->term_id;
                                $thumbnail_id = get_woocommerce_term_meta($category_id, 'thumbnail_id', true);
                                $thumbnail_url = wp_get_attachment_thumb_url($thumbnail_id);
                                ?>
                                <tr>
                                    <td class="productimgname">
                                        <a href="javascript:void(0);" class="product-img">
                                            <img src="
                                                <?php if ($thumbnail_url) {
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
                                        <button type="button" class="me-3 btn_style"  data-toggle="modal" data-target="#editModal">
                                            <img src="<?php echo get_bloginfo('template_directory'); ?>/src/img/edit.svg"
                                                alt="img">
                                        </button>
                                        <button type="button" class="me-3 delete_btn btn_style"
                                            pr_id="<?php echo $category->term_taxonomy_id; ?>">
                                            <img src="<?php echo get_bloginfo('template_directory'); ?>/src/img/delete.svg"
                                                alt="img">
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
    </div>
</div>

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
					url: '/wp-json/v1/products/remove_category',
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