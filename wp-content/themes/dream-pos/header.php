<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0">
  <meta name="robots" content="noindex, nofollow">
  <title>Dreams Pos admin template</title>
  <link rel="shortcut icon" type="image/x-icon" href="<?php echo get_bloginfo('template_directory'); ?>/src/img/favicon.png">
  <link rel="stylesheet" href="<?php echo get_bloginfo('template_directory'); ?>/src/css/bootstrap.min.css">
  <link rel="stylesheet" href="<?php echo get_bloginfo('template_directory'); ?>/src/css/animate.css">
  <link rel="stylesheet" href="<?php echo get_bloginfo('template_directory'); ?>/src/css/dataTables.bootstrap4.min.css">
  <link rel="stylesheet" href="<?php echo get_bloginfo('template_directory'); ?>/src/css//fontawesome.min.css">
  <link rel="stylesheet" href="<?php echo get_bloginfo('template_directory'); ?>/src/css//all.min.css">

  <link rel="stylesheet" href="<?php echo get_bloginfo('template_directory'); ?>/src/css/bootstrap.min.css">
  <link rel="stylesheet" href="<?php echo get_bloginfo('template_directory'); ?>/src/css/bootstrap-theme.min.css">
  <link rel="stylesheet" href="<?php echo get_bloginfo('template_directory'); ?>/src/css/select2.min.css">
  <link href="<?php echo get_bloginfo('template_directory'); ?>/src/css/featherlight.css" type="text/css" rel="stylesheet" />
  <link href="<?php echo get_bloginfo('template_directory'); ?>/src/css/slick.css" type="text/css" rel="stylesheet" />
  <link rel="stylesheet" href="<?php echo get_bloginfo('template_directory'); ?>/src/css/style.css">
  <?php wp_head(); ?>
</head>

<body>

  <?php if (is_user_logged_in()) { ?>
    <div id="global-loader">
      <div class="whirly-loader"> </div>
    </div>
    <div class="main-wrapper">

      <!-- Header -->
      <div class="header">

        <!-- Logo -->
        <div class="header-left active">
          <a href="/" class="logo logo-normal">
            <img src="<?php echo get_bloginfo('template_directory'); ?>/src/img/logo.png" alt="">
          </a>
          <a href="/" class="logo logo-white">
            <img src="<?php echo get_bloginfo('template_directory'); ?>/src/img/logo-white.png" alt="">
          </a>
          <a href="/" class="logo-small">
            <img src="<?php echo get_bloginfo('template_directory'); ?>/src/img/logo-small.png" alt="">
          </a>
          <a id="toggle_btn" href="javascript:void(0);">
            <i data-feather="chevrons-left" class="feather-16"></i>
          </a>
        </div>
        <!-- /Logo -->

        <a id="mobile_btn" class="mobile_btn" href="#sidebar">
          <span class="bar-icon">
            <span></span>
            <span></span>
            <span></span>
          </span>
        </a>

        <!-- Header Menu -->
        <ul class="nav user-menu">

          <!-- Search -->
          <li class="nav-item nav-searchinputs">
            <div class="top-nav-search">

              <a href="javascript:void(0);" class="responsive-search">
                <i class="fa fa-search"></i>
              </a>
            </div>
          </li>

          <li class="nav-item nav-item-box">
            <a href="javascript:void(0);" id="btnFullscreen">
              <i data-feather="maximize"></i>
            </a>
          </li>
          <!-- Notifications -->


          <?php
          $args = array(
            'post_type'      => 'product',
            'post_status'    => 'publish',
            'posts_per_page' => -1,
            'meta_query'     => array(
              array(
                'key'     => '_stock',
                'value'   => 3,
                'compare' => '<=',
                'type'    => 'NUMERIC',
              ),
            ),
          );

          $loop = new WP_Query($args);
          $product_count = $loop->found_posts;

          if ($product_count > 0) { ?>
            <li class="nav-item dropdown nav-item-box">
              <a href="javascript:void(0);" class="dropdown-toggle nav-link" data-bs-toggle="dropdown" aria-expanded="false">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-bell">
                  <path d="M18 8A6 6 0 0 0 6 8c0 7-3 9-3 9h18s-3-2-3-9"></path>
                  <path d="M13.73 21a2 2 0 0 1-3.46 0"></path>
                </svg><span class="badge rounded-pill"><?php echo $product_count; ?></span>
              </a>
              <div class="dropdown-menu notifications">
                <div class="topnav-dropdown-header">
                  <span class="notification-title">Notifications</span>
                </div>
                <div class="noti-content">
                  <ul class="notification-list">

                    <?php
                    while ($loop->have_posts()) : $loop->the_post();
                      global $product; ?>
                      <li class="notification-message">
                        <a href="/products-list/">
                          <div class="media d-flex">
                            <span class="avatar flex-shrink-0">
                              <?php echo woocommerce_get_product_thumbnail(); ?>
                            </span>
                            <div class="media-body flex-grow-1">
                              <p class="noti-details"><?php echo $product->get_name(); ?> <span class="noti-title"> Low stock.</span></p>
                              <p class="noti-time"><span class="notification-time">Stock Count : <?php echo get_post_meta($product->get_id(), '_stock', true); ?></span></p>
                            </div>
                          </div>
                        </a>
                      </li>

                    <?php endwhile;

                    wp_reset_query(); ?>



                  </ul>
                </div>
              </div>
            </li> <!-- /Notifications -->
          <?php }?>
          <li class="nav-item dropdown has-arrow main-drop">
            <a href="javascript:void(0);" class="dropdown-toggle nav-link userset" data-bs-toggle="dropdown">
              <span class="user-info">
                <span class="user-letter">
                  <img src="<?php echo get_bloginfo('template_directory'); ?>/src/img/logo-small.png" alt="" class="img-fluid">
                </span>
                <?php
                $user = wp_get_current_user();
                $user_meta = get_userdata($user->ID);
                $userFname = get_user_meta($user->ID, 'first_name', true);
                $userLname = get_user_meta($user->ID, 'last_name', true);
                $user_role = $user_meta->roles;
                $role = $user_role[0];
                $name = $userFname . ' ' . $userLname;
                if ($name == ' ') {
                  $name = 'Super Admin';
                  $role = 'Super_admin';
                }
                ?>
                <span class="user-detail">
                  <span class="user-name"><?php echo $name; ?></span>
                  <span class="user-role"><?php echo $role; ?></span>
                </span>
              </span>
            </a>
            <div class="dropdown-menu menu-drop-user">
              <div class="profilename">
                <div class="profileset">
                  <img src="<?php echo get_bloginfo('template_directory'); ?>/src/img/logo-small.png" alt="" class="img-fluid">
                  <span class="status online"></span></span>
                  <div class="profilesets">
                    <h6><?php echo $name; ?></h6>
                    <h5><?php echo $role; ?></h5>
                  </div>
                </div>
                <hr class="m-0">
                <a class="dropdown-item logout pb-0" href="<?php echo wp_logout_url(get_permalink()); ?>">
                  Logout
                </a>
              </div>
            </div>
          </li>
        </ul>
        <!-- /Header Menu -->

        <!-- Mobile Menu -->
        <div class="dropdown mobile-user-menu">
          <a href="javascript:void(0);" class="nav-link dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false"><i class="fa fa-ellipsis-v"></i></a>
          <div class="dropdown-menu dropdown-menu-right">
            <a class="dropdown-item" href="<?php echo wp_logout_url(get_permalink()); ?>">Logout</a>
          </div>
        </div>
        <!-- /Mobile Menu -->
      </div>
      <!-- Header -->
    <?php } ?>