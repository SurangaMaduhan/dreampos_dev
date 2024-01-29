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
                <form method="post" id="add_user">
                    <div class="row">
                        <div class="col-lg-4 col-sm-6 col-12">
                            <div class="form-group">
                                <label for="firstName">First Name:</label>
                                <input type="text" id="firstName" name="firstName" required>
                            </div>
                        </div>
                        <div class="col-lg-4 col-sm-6 col-12">
                            <div class="form-group">
                                <label for="lastName">Last Name:</label>
                                <input type="text" id="lastName" name="lastName" required>
                            </div>
                        </div>

                        <div class="col-lg-4 col-sm-6 col-12">
                            <div class="form-group">
                                <label for="username">Username:</label>
                                <input type="text" id="username" name="username" required>
                            </div>
                        </div>
                        <div class="col-lg-4 col-sm-6 col-12">
                            <div class="form-group">
                                <label>Role</label>
                                <select name="role" id="role" required class="select">
                                    <option value="">— No role for this site —</option>
                                    <option value="administrator">Administrator</option>
                                    <option value="shop_manager">Shop manager</option>
                                    <option value="editor">Editor</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-lg-4 col-sm-6 col-12">
                            <div class="form-group">
                                <label>Password</label>
                                <div class="pass-group">
                                    <input type="password" class="pass-inputs" name="password">
                                    <span class="fas toggle-passworda fa-eye-slash"></span>
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
    jQuery(document).ready(function($) {
        // $("#add_user").submit(function(event) {
        //     event.preventDefault();
        //     // $(".global-loader").show();

        //     var firstName = document.getElementById('firstName').value;
        //     var lastName = document.getElementById('lastName').value;
        //     var username = document.getElementById('username').value;
        //     // var email = document.getElementById('email').value;
        //     var password = document.getElementById('password').value;
        //     var userRole = document.getElementById('role').value;

        //     // Construct the request body
        //     var data = {
        //         firstName: firstName,
        //         lastName: lastName,
        //         username: username,
        //         // email: firstName + '' + lastName + '@dreamp.com',
        //         password: password,
        //         userRole: userRole
        //     };

        //     // Send the registration request to the API endpoint
        //     fetch('/wp-json/v1/products/add-user', {
        //             method: 'POST',
        //             headers: {
        //                 'Content-Type': 'application/json',
        //             },
        //             body: JSON.stringify(data),
        //         })
        //         .then(response => response.json())
        //         .then(data => {
        //             // Handle the response
        //             console.log(data);
        //             alert(data.message); // You can replace this with a more user-friendly notification
        //         })
        //         .catch(error => {
        //             console.error('Error:', error);
        //         });
        // });

        $("#add_user").submit(function(event) {
            event.preventDefault();
            $(".global-loader").show()
            var formData = new FormData(this);
            // console.log(formData);
            $.ajax({
                type: "POST",
                url: "/wp-json/v1/add-user",
                data: formData,
                contentType: false,
                processData: false,
                success: function(response) {
                    // console.log(response);
                    $(".global-loader").hide();
                    $("form").trigger('reset');
                    Swal.fire({
                        icon: "success",
                        title: "User added...",
                        text: response.message,
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