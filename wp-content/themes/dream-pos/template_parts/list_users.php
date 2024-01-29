<div class="page-wrapper">
    <div class="content">
        <div class="page-header">
            <div class="page-title">
                <h4>User List</h4>
                <h6>Manage your User</h6>
            </div>
            <div class="page-btn">
                <a href="/add-user/" class="btn btn-added"><img src="<?php echo get_bloginfo('template_directory'); ?>/src/img/plus.svg" alt="img" class="me-1">Add New User</a>
            </div>
        </div>

        <!-- /product list -->
        <div class="card">
            <div class="card-body">
                <div class="table-top">
                    <div class="search-set">
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
                <!-- /Filter -->
                <div class="table-responsive">
                    <table class="table  datanew">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>First Name</th>
                                <th>Last Name</th>
                                <th>Username </th>
                                <th>Role</th>
                                <th>Created On</th>
                                <th>Status</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $users = get_users();
                            foreach ($users as $user) {
                                $user_id = $user->ID;
                                $user_login = $user->user_login;
                                // $user_email = $user->user_email;
                                $user_first_name = $user->first_name;
                                $user_last_name = $user->last_name;
                                $roles = $user->roles;
                                $user_registered = $user->user_registered;
                                $formatted_registration_date = date('F j, Y H:i:s', strtotime($user_registered));
                                $first_name = get_user_meta($user_login, 'first_name', true);
                                $last_name = get_user_meta($user_login, 'last_name', true);
                            ?>
                                <tr>
                                    <td><?php echo $user_id; ?></td>
                                    <td>
                                        <?php if ($user_login == 'admin') {
                                            echo 'Super';
                                        } else {
                                            echo $user_first_name;
                                        } ?></td>
                                    <td>
                                        <?php if ($user_login == 'admin') {
                                            echo 'Admin';
                                        } else {
                                            echo $user_last_name;
                                        } ?>
                                    </td>
                                    <td><?php echo $user_login; ?></td>
                                    <td><?php echo $roles[0]; ?></td>
                                    <td><?php echo $formatted_registration_date; ?></td>
                                    <td><span class="bg-lightgreen badges">Active</span></td>
                                    <td>
                                        <?php if ($user_login != 'admin') { ?>
                                            <button type="button" class="me-3" data-toggle="modal" data-target="#view_user_<?php echo $user_id; ?>">
                                                <img src="<?php echo get_bloginfo('template_directory'); ?>/src/img/edit.svg" alt="img">
                                            </button>

                                            <button type="button" class="user_delete me-3" pr_id="<?php echo $user_id; ?>">
                                                <img src="<?php echo get_bloginfo('template_directory'); ?>/src/img/delete.svg" alt="img">
                                            </button>

                                            <div id="view_user_<?php echo $user_id; ?>" class="modal fade view_user" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel" aria-hidden="true">
                                                <div class="modal-dialog">
                                                    <div class="modal-content">
                                                        <h3>Update User #<?php echo $user_id; ?></h3>
                                                        <form method="post" class="edit_user">
                                                            <div class="row">
                                                                <div class="col-md-12">
                                                                    <div class="form-group">
                                                                        <label for="firstName">First Name:</label>
                                                                        <input type="text" id="firstName" name="firstName" value="<?php echo esc_attr($user_first_name); ?>">
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-12">
                                                                    <div class="form-group">
                                                                        <label for="lastName">Last Name:</label>
                                                                        <input type="text" id="lastName" name="lastName" value="<?php echo esc_attr($user_last_name); ?>">
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="row">
                                                                <div class="col-md-12">
                                                                    <div class="form-group">
                                                                        <label for="mpk">User Role:</label>
                                                                        <select name="role">
                                                                            <option value="">— No role for this site —</option>
                                                                            <option value="administrator" <?php echo ($roles[0] === 'administrator') ? 'selected' : ''; ?>>
                                                                                Administrator
                                                                            </option>
                                                                            <option value="shop_manager" <?php echo ($roles[0] === 'shop_manager') ? 'selected' : ''; ?>>
                                                                                Shop manager
                                                                            </option>
                                                                            <option value="editor" <?php echo ($roles[0] === 'editor') ? 'selected' : ''; ?>>
                                                                                Editor
                                                                            </option>
                                                                        </select>

                                                                    </div>
                                                                </div>
                                                                <div class="col-md-12">
                                                                    <div class="form-group">
                                                                        <label for="password">Password:</label>
                                                                        <div class="pass-group">
                                                                            <input type="password" class="pass-inputs" name="password">
                                                                            <span class="fas toggle-passworda fa-eye-slash"></span>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="button_set">
                                                                <input type="hidden" name="user_id" value="<?php echo esc_attr($user_id); ?>">
                                                                <button type="submit" class="btn btn-submit me-2">
                                                                    Update
                                                                </button>
                                                                <button type="button" class="btn btn-cancel me-2" data-dismiss="modal" aria-label="Close">
                                                                    Close
                                                                </button>
                                                            </div>
                                                        </form>
                                                        <div class="global-loader" style="display:none">
                                                            <div class="whirly-loader"> </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        <?php } ?>
                                    </td>
                                </tr>
                            <?php }; ?>

                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <div class="global-loader" style="display:none">
            <div class="whirly-loader"> </div>
        </div>
        <!-- /product list -->
    </div>
</div>
<script>
    jQuery(document).ready(function($) {
        $('.user_delete').on('click', function() {
            var user_id = $(this).attr('pr_id');

            Swal.fire({
                title: "Do you want to delete Product?",
                showDenyButton: true,
                confirmButtonText: "Yes",
                denyButtonText: "No"
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url: '/wp-json/v1/remove-user',
                        type: 'POST',
                        data: {
                            'user_id': user_id
                        },
                        success: function(response) {
                            Swal.fire({
                                icon: "success",
                                title: "success...",
                                text: '#' + user_id + ' User Deleted',
                            });
                            document.location.reload(true);
                        },
                        error: function(xhr, status, error) {
                            Swal.fire({
                                icon: "error",
                                title: "Oops...",
                                text: error.message,
                            });
                        }
                    });
                } else if (result.isDenied) {
                    Swal.fire({
                        icon: "error",
                        title: "Oops...",
                        text: 'User denied the deletion.',
                    });
                }
            });
        });

        $(".edit_user").submit(function(event) {
            event.preventDefault();
            // const modalId = $(this).closest('.modal').attr('id');
            $(".global-loader").show();
            var formData = new FormData(this);

            $.ajax({
                type: "POST",
                url: "/wp-json/v1/update-user", // Corrected the URL
                data: formData,
                contentType: false,
                processData: false,
                success: function(response) {
                    $(".global-loader").hide();
                    $('[data-dismiss="modal"]').trigger('click');
                    Swal.fire({
                        icon: "success",
                        title: "success...",
                        text: response.message,
                    });
                    document.location.reload(true);
                },
                error: function(error) {
                    $('[data-dismiss="modal"]').trigger('click');
                    Swal.fire({
                        icon: "error",
                        title: "Oops...",
                        text: 'User denied the deletion.',
                    });
                }
            });
        });
    });
</script>