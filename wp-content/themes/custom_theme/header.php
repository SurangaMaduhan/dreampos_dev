<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0">
  <meta name="robots" content="noindex, nofollow">
  <title>Dreams Pos admin template</title>
  <link rel="shortcut icon" type="image/x-icon"
    href="<?php echo get_bloginfo('template_directory'); ?>/src/img/favicon.png">
  <link rel="stylesheet" href="<?php echo get_bloginfo('template_directory'); ?>/src/css/bootstrap.min.css">
  <link rel="stylesheet" href="<?php echo get_bloginfo('template_directory'); ?>/src/css/animate.css">
  <link rel="stylesheet" href="<?php echo get_bloginfo('template_directory'); ?>/src/css/dataTables.bootstrap4.min.css">
  <link rel="stylesheet" href="<?php echo get_bloginfo('template_directory'); ?>/src/css//fontawesome.min.css">
  <link rel="stylesheet" href="<?php echo get_bloginfo('template_directory'); ?>/src/css//all.min.css">

  <link rel="stylesheet" href="<?php echo get_bloginfo('template_directory'); ?>/src/css/bootstrap.min.css">
  <link rel="stylesheet" href="<?php echo get_bloginfo('template_directory'); ?>/src/css/bootstrap-theme.min.css">
  <link rel="stylesheet" href="<?php echo get_bloginfo('template_directory'); ?>/src/css/select2.min.css">
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
          <a href="#" class="logo logo-normal">
            <img src="<?php echo get_bloginfo('template_directory'); ?>/src/img/logo.png" alt="">
          </a>
          <a href="#" class="logo logo-white">
            <img src="<?php echo get_bloginfo('template_directory'); ?>/src/img/logo-white.png" alt="">
          </a>
          <a href="#" class="logo-small">
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
              <form action="#">
                <div class="searchinputs">
                  <input type="text" placeholder="Search">
                  <div class="search-addon">
                    <span><i data-feather="search" class="feather-14"></i></span>
                  </div>
                </div>
                <!-- <a class="btn"  id="searchdiv"><img src="<?php echo get_bloginfo('template_directory'); ?>/src/icons/search.svg" alt="img"></a> -->
              </form>
            </div>
          </li>
          <!-- /Search -->

          <!-- Flag -->
          <!-- <li class="nav-item dropdown has-arrow flag-nav nav-item-box">
            <a class="nav-link dropdown-toggle" data-bs-toggle="dropdown" href="javascript:void(0);" role="button">
              <i data-feather="globe"></i>
            </a>
            <div class="dropdown-menu dropdown-menu-right">
              <a href="javascript:void(0);" class="dropdown-item active">
                <img src="<?php echo get_bloginfo('template_directory'); ?>/src/flags/us.png" alt="" height="16"> English
              </a>
              <a href="javascript:void(0);" class="dropdown-item">
                <img src="<?php echo get_bloginfo('template_directory'); ?>/src/flags/fr.png" alt="" height="16"> French
              </a>
              <a href="javascript:void(0);" class="dropdown-item">
                <img src="<?php echo get_bloginfo('template_directory'); ?>/src/flags/es.png" alt="" height="16"> Spanish
              </a>
              <a href="javascript:void(0);" class="dropdown-item">
                <img src="<?php echo get_bloginfo('template_directory'); ?>/src/flags/de.png" alt="" height="16"> German
              </a>
            </div>
          </li> -->
          <!-- /Flag -->

          <li class="nav-item nav-item-box">
            <a href="javascript:void(0);" id="btnFullscreen">
              <i data-feather="maximize"></i>
            </a>
          </li>
          <li class="nav-item nav-item-box">
            <a href="email.html">
              <i data-feather="mail"></i>
              <span class="badge rounded-pill">1</span>
            </a>
          </li>
          <!-- Notifications -->
          <li class="nav-item dropdown nav-item-box">
            <a href="javascript:void(0);" class="dropdown-toggle nav-link" data-bs-toggle="dropdown">
              <i data-feather="bell"></i><span class="badge rounded-pill">2</span>
            </a>
            <div class="dropdown-menu notifications">
              <div class="topnav-dropdown-header">
                <span class="notification-title">Notifications</span>
                <a href="javascript:void(0)" class="clear-noti"> Clear All </a>
              </div>
              <div class="noti-content">
                <ul class="notification-list">
                  <li class="notification-message">
                    <a href="activities.html">
                      <div class="media d-flex">
                        <span class="avatar flex-shrink-0">
                          <!-- <img alt="" src="<?php echo get_bloginfo('template_directory'); ?>/src/img/avatar-02.jpg"> -->
                        </span>
                        <div class="media-body flex-grow-1">
                          <p class="noti-details"><span class="noti-title">John Doe</span> added new task <span
                              class="noti-title">Patient appointment booking</span></p>
                          <p class="noti-time"><span class="notification-time">4 mins ago</span></p>
                        </div>
                      </div>
                    </a>
                  </li>
                  <li class="notification-message">
                    <a href="activities.html">
                      <div class="media d-flex">
                        <span class="avatar flex-shrink-0">
                          <!-- <img alt="" src="<?php echo get_bloginfo('template_directory'); ?>/src/img/avatar-03.jpg"> -->
                        </span>
                        <div class="media-body flex-grow-1">
                          <p class="noti-details"><span class="noti-title">Tarah Shropshire</span> changed the task name
                            <span class="noti-title">Appointment booking with payment gateway</span>
                          </p>
                          <p class="noti-time"><span class="notification-time">6 mins ago</span></p>
                        </div>
                      </div>
                    </a>
                  </li>
                  <li class="notification-message">
                    <a href="activities.html">
                      <div class="media d-flex">
                        <span class="avatar flex-shrink-0">
                          <!-- <img alt="" src="<?php echo get_bloginfo('template_directory'); ?>/src/img/avatar-06.jpg"> -->
                        </span>
                        <div class="media-body flex-grow-1">
                          <p class="noti-details"><span class="noti-title">Misty Tison</span> added <span
                              class="noti-title">Domenic Houston</span> and <span class="noti-title">Claire Mapes</span>
                            to project <span class="noti-title">Doctor available module</span></p>
                          <p class="noti-time"><span class="notification-time">8 mins ago</span></p>
                        </div>
                      </div>
                    </a>
                  </li>
                  <li class="notification-message">
                    <a href="activities.html">
                      <div class="media d-flex">
                        <span class="avatar flex-shrink-0">
                          <!-- <img alt="" src="<?php echo get_bloginfo('template_directory'); ?>/src/img/avatar-17.jpg"> -->
                        </span>
                        <div class="media-body flex-grow-1">
                          <p class="noti-details"><span class="noti-title">Rolland Webber</span> completed task <span
                              class="noti-title">Patient and Doctor video conferencing</span></p>
                          <p class="noti-time"><span class="notification-time">12 mins ago</span></p>
                        </div>
                      </div>
                    </a>
                  </li>
                  <li class="notification-message">
                    <a href="activities.html">
                      <div class="media d-flex">
                        <span class="avatar flex-shrink-0">
                          <!-- <img alt="" src="<?php echo get_bloginfo('template_directory'); ?>/src/img/avatar-13.jpg"> -->
                        </span>
                        <div class="media-body flex-grow-1">
                          <p class="noti-details"><span class="noti-title">Bernardo Galaviz</span> added new task <span
                              class="noti-title">Private chat module</span></p>
                          <p class="noti-time"><span class="notification-time">2 days ago</span></p>
                        </div>
                      </div>
                    </a>
                  </li>
                </ul>
              </div>
              <div class="topnav-dropdown-footer">
                <a href="activities.html">View all Notifications</a>
              </div>
            </div>
          </li>
          <!-- /Notifications -->

          <li class="nav-item nav-item-box">
            <a href="generalsettings.html"><i data-feather="settings"></i></a>
          </li>
          <li class="nav-item dropdown has-arrow main-drop">
            <a href="javascript:void(0);" class="dropdown-toggle nav-link userset" data-bs-toggle="dropdown">
              <span class="user-info">
                <span class="user-letter">
                  <!-- <img src="<?php echo get_bloginfo('template_directory'); ?>/src/img/avator1.jpg" alt="" class="img-fluid"> -->
                </span>
                <span class="user-detail">
                  <span class="user-name">John Smilga</span>
                  <span class="user-role">Super Admin</span>
                </span>
              </span>
            </a>
            <div class="dropdown-menu menu-drop-user">
              <div class="profilename">
                <div class="profileset">
                  <!-- <span class="user-img"><img src="<?php echo get_bloginfo('template_directory'); ?>/src/img/avator1.jpg" alt=""> -->
                  <span class="status online"></span></span>
                  <div class="profilesets">
                    <h6>John Smilga</h6>
                    <h5>Super Admin</h5>
                  </div>
                </div>
                <hr class="m-0">
                <a class="dropdown-item" href="profile.html"> <i class="me-2" data-feather="user"></i> My Profile</a>
                <a class="dropdown-item" href="generalsettings.html"><i class="me-2"
                    data-feather="settings"></i>Settings</a>
                <hr class="m-0">
                <a class="dropdown-item logout pb-0" href="signin.html">
                  <!-- <img src="<?php echo get_bloginfo('template_directory'); ?>/src/img/log-out.svg" class="me-2" alt="img"> -->
                  Logout</a>
              </div>
            </div>
          </li>
        </ul>
        <!-- /Header Menu -->

        <!-- Mobile Menu -->
        <div class="dropdown mobile-user-menu">
          <a href="javascript:void(0);" class="nav-link dropdown-toggle" data-bs-toggle="dropdown"
            aria-expanded="false"><i class="fa fa-ellipsis-v"></i></a>
          <div class="dropdown-menu dropdown-menu-right">
            <a class="dropdown-item" href="profile.html">My Profile</a>
            <!-- <a class="dropdown-item" href="generalsettings.html">Settings</a> -->
            <a class="dropdown-item" href="signin.html">Logout</a>
          </div>
        </div>
        <!-- /Mobile Menu -->
      </div>
      <!-- Header -->
    <?php } ?>