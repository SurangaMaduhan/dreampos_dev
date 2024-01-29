<div class="page-wrapper">
    <div class="content">
        <div class="page-header">
            <div class="page-title">
                <h4>Import Purchases</h4>
                <h6>Bulk upload your Purchases</h6>
            </div>
        </div>

        <!-- /product list -->
        <div class="card">
            <div class="card-body">
                <div class="requiredfield">
                    <h4>Download All products in CSV format</h4>
                </div>
                <div class="row">
                    <div class="col-lg-3 col-sm-6 col-12">
                        <div class="form-group">
                            <form id="exportForm" method="post">
                                <button type="submit" class="btn btn-submit w-100">Download CSV</button>
                            </form>
                        </div>
                    </div>
                </div>
                <form id="import_purchases" method="post">
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="form-group">
                                <div class="mb-3">
                                    <label for="formFile" class="form-label">Upload CSV File</label>
                                    <input class="form-control" type="file" name="csv_file" accept=".csv" required>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-12 col-sm-12">
                            <div class="productdetails productdetailnew">
                                <ul class="product-bar">
                                    <li>
                                        <h4>Product ID</h4>
                                        <h6 class="manitorygreen">This Field is required</h6>
                                    </li>
                                    <li>
                                        <h4>Product Title</h4>
                                        <h6 class="manitorygreen">This Field is required</h6>
                                    </li>
                                    <li>
                                        <h4>SKU </h4>
                                        <h6 class="manitorygreen">This Field is required</h6>
                                    </li>
                                    <li>
                                        <h4>Product Price</h4>
                                        <h6 class="manitorygreen">This Field is required</h6>
                                    </li>
                                    <li>
                                        <h4>Product Cost</h4>
                                        <h6 class="manitorygreen">This Field is required</h6>
                                    </li>
                                    <li>
                                        <h4>Product Stock</h4>
                                        <h6 class="manitorygreen">This Field is required</h6>
                                    </li>
                                </ul>
                            </div>
                        </div>
                        <div class="col-lg-12">
                            <div class="form-group mb-0">
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
    document.getElementById('exportForm').addEventListener('submit', function(event) {
        event.preventDefault();
        jQuery(".global-loader").show()
        // You can use JavaScript to make an AJAX request to your REST API endpoint
        // Example using fetch API
        fetch('/wp-json/v1/products/export', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                },
            })
            .then(response => response.blob())
            .then(blob => {
                // Create a temporary anchor element to trigger the download
                const link = document.createElement('a');
                link.href = window.URL.createObjectURL(new Blob([blob]));
                link.download = 'exported_products.csv';
                document.body.appendChild(link);
                link.click();
                document.body.removeChild(link);
                jQuery(".global-loader").hide();
                jQuery("form").trigger('reset');
                Swal.fire({
                    icon: "success",
                    title: "User added...",
                    text: 'successfully downloaded',
                });
            })
            .catch(error => {
                // console.error();
                jQuery(".global-loader").hide();
                Swal.fire({
                    icon: "error",
                    title: "Oops...",
                    text: 'Error: ' + error,
                });
            });
    });

    document.getElementById('import_purchases').addEventListener('submit', function(event) {
        event.preventDefault();
        jQuery(".global-loader").show()
        var formData = new FormData(this);

        fetch('/wp-json/v1/products/import', {
                method: 'POST',
                body: formData
            })
            .then(response => response.json())
            .then(data => {
                jQuery(".global-loader").hide();
                jQuery("form").trigger('reset');
                Swal.fire({
                    icon: "success",
                    title: "User added...",
                    text: 'Products imported successfully!',
                });
            })
            .catch(error => {
                // Handle errors, e.g., display an error message
                jQuery(".global-loader").hide();
                Swal.fire({
                    icon: "error",
                    title: "Oops...",
                    text: 'An error occurred during import.',
                });
            });
    });
</script>