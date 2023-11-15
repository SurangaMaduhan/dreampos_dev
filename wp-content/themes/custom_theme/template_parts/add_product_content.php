<!-- <label for="product_title">Product Title:</label>
<br>

<label for="product_description">Product Description:</label>
<textarea name="product_description" id="product_description" required></textarea><br>

<label for="product_price">Price:</label>
<input type="number" name="product_price" id="product_price" required><br>

<label for="product_sku">SKU:</label>
<input type="text" name="product_sku" id="product_sku"><br>

<label for="product_image">Product Image:</label>
<input type="file" name="product_image" id="product_image" accept="image/*"><br>

<input type="submit" value="Add Product">
</form> -->
<div class="page-wrapper">
    <div class="content">
        <div class="page-header">
            <div class="page-title">
                <h4>Product Add</h4>
                <h6>Create new product</h6>
            </div>
        </div>
        <!-- /add -->
        <div class="card">
            <div class="card-body">
                <form action="/wp-json/v1/products/add-new-product" method="post" enctype="multipart/form-data">
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
                                <select class="select">
                                    <option>Choose Category</option>
                                    <option>Computers</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-lg-3 col-sm-6 col-12">
                            <div class="form-group">
                                <label>Brand</label>
                                <input type="text">
                            </div>
                        </div>
                        <div class="col-lg-3 col-sm-6 col-12">
                            <div class="form-group">
                                <label>SKU</label>
                                <input type="text">
                            </div>
                        </div>
                        <div class="col-lg-3 col-sm-6 col-12">
                            <div class="form-group">
                                <label>Minimum Qty</label>
                                <input type="text">
                            </div>
                        </div>
                        <div class="col-lg-3 col-sm-6 col-12">
                            <div class="form-group">
                                <label>Quantity</label>
                                <input type="number" name="quantity">
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
                                <textarea name="product_description" id="product_description"
                                    class="form-control"></textarea>
                            </div>
                        </div>
                        
                        <div class="col-lg-12">
                            <div class="form-group">
                                <label> Product Image</label>
                                <div class="image-upload">
                                    <input type="file" name="product_image" id="product_image" accept="image/*">
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
    </div>
</div>
</div>