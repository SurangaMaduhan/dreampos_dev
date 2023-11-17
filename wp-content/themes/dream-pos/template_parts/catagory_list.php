<div class="page-wrapper">
    <div class="content">
        <div class="page-header">
            <div class="page-title">
                <h4>Product Category list</h4>
                <h6>View/Search product Category</h6>
            </div>
            <div class="page-btn">
                <a href="addcategory.html" class="btn btn-added">
                    <img src="<?php echo get_bloginfo('template_directory'); ?>/src/img/plus.svg" class="me-1" alt="img">Add Category
                </a>
            </div>
        </div>


        <!-- /product list -->
        <div class="card">
            <div class="card-body">
                <div class="table-top">
                    <div class="search-set">
                        <div class="search-input">
                            <a class="btn btn-searchset"><img src="<?php echo get_bloginfo('template_directory'); ?>/src/img/search-white.svg" alt="img"></a>
                            <div id="DataTables_Table_0_filter" class="dataTables_filter"><label> <input type="search"
                                        class="form-control form-control-sm" placeholder="Search..."
                                        aria-controls="DataTables_Table_0"></label></div>
                        </div>
                    </div>
                    <div class="wordset">
                        <ul>
                            <li>
                                <a data-bs-toggle="tooltip" data-bs-placement="top" title=""
                                    data-bs-original-title="pdf" aria-label="pdf"><img src="<?php echo get_bloginfo('template_directory'); ?>/src/img/pdf.svg"
                                        alt="img"></a>
                            </li>
                            <li>
                                <a data-bs-toggle="tooltip" data-bs-placement="top" title=""
                                    data-bs-original-title="excel" aria-label="excel"><img
                                        src="<?php echo get_bloginfo('template_directory'); ?>/src/img/excel.svg" alt="img"></a>
                            </li>
                            <li>
                                <a data-bs-toggle="tooltip" data-bs-placement="top" title=""
                                    data-bs-original-title="print" aria-label="print"><img
                                        src="<?php echo get_bloginfo('template_directory'); ?>/src/img/printer.svg" alt="img"></a>
                            </li>
                        </ul>
                    </div>
                </div>

                <div class="table-responsive">
                    <div id="DataTables_Table_0_wrapper" class="dataTables_wrapper dt-bootstrap4 no-footer">
                        <table class="table datanew dataTable no-footer" id="DataTables_Table_0" role="grid"
                            aria-describedby="DataTables_Table_0_info">
                            <thead>
                                <tr role="row">
                                    <th class="sorting_asc" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1"
                                        colspan="1" aria-sort="ascending"
                                        aria-label=": activate to sort column descending" style="width: 120.328px;">
                                        <label class="checkboxs">
                                            <input type="checkbox" id="select-all">
                                            <span class="checkmarks"></span>
                                        </label>
                                    </th>
                                    <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1"
                                        colspan="1" aria-label="Category name: activate to sort column ascending"
                                        style="width: 268.812px;">Category name</th>
                                    <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1"
                                        colspan="1" aria-label="Category Code: activate to sort column ascending"
                                        style="width: 248.234px;">Category Code</th>
                                    <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1"
                                        colspan="1" aria-label="Description: activate to sort column ascending"
                                        style="width: 323.797px;">Description</th>
                                    <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1"
                                        colspan="1" aria-label="Created By: activate to sort column ascending"
                                        style="width: 197.266px;">Created By</th>
                                    <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1"
                                        colspan="1" aria-label="Action: activate to sort column ascending"
                                        style="width: 164.562px;">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <!-- <tr class="odd">
                                    <td class="sorting_1">
                                        <label class="checkboxs">
                                            <input type="checkbox">
                                            <span class="checkmarks"></span>
                                        </label>
                                    </td>
                                    <td class="productimgname">
                                        <a href="javascript:void(0);" class="product-img">
                                            <img src="assets/img/product/noimage.png" alt="product">
                                        </a>
                                        <a href="javascript:void(0);">Computers</a>
                                    </td>
                                    <td>CT001</td>
                                    <td>Computers Description</td>
                                    <td>Admin</td>
                                    <td>
                                        <a class="me-3" href="editcategory.html">
                                            <img src="<?php echo get_bloginfo('template_directory'); ?>/src/img/edit.svg" alt="img">
                                        </a>
                                        <a class="me-3 confirm-text" href="javascript:void(0);">
                                            <img src="<?php echo get_bloginfo('template_directory'); ?>/src/img/delete.svg" alt="img">
                                        </a>
                                    </td>
                                </tr> -->
                            </tbody>
                        </table>
                        
                    </div>
                </div>
            </div>
        </div>
        <!-- /product list -->
    </div>
</div>