<!DOCTYPE html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="csrf-token" content="<?php echo e(csrf_token()); ?>">

    <title>QMS</title>
    <!-- plugins:css -->
    <link rel="stylesheet" href="<?php echo e(asset('mdi/css/materialdesignicons.min.css')); ?>">

    <!-- End plugin css for this page -->
    <!-- inject:css -->
    <link rel="stylesheet" href="<?php echo e(asset('css/bootstrap.min.css')); ?>">
    <link rel="stylesheet" href="<?php echo e(asset('css/datatable.min.css')); ?>">
    <link rel="stylesheet" href="<?php echo e(asset('css/quill.css')); ?>">
    <link rel="stylesheet" href="<?php echo e(asset('css/style.css')); ?>">

    <!-- endinject -->
    <link rel="shortcut icon" href="<?php echo e(asset('images/logo.png')); ?>" />
    <script src="<?php echo e(asset('js/popper.min.js')); ?>"></script>
    <script src="<?php echo e(asset('js/jquery.min.js')); ?>"></script>
    <script src="<?php echo e(asset('js/bootstrap.min.js')); ?>"></script>
        <script src="<?php echo e(asset('js/moment.js')); ?>"></script>
        <script src="<?php echo e(asset('js/jquery.cookie.js')); ?>"></script>
        <script src="<?php echo e(asset('js/jquery.dataTables.js')); ?>"></script>
        <script src="<?php echo e(asset('js/datatable.min.js')); ?>"></script>
        <script src="<?php echo e(asset('ckeditor/ckeditor.js')); ?>"></script>
        <script src="<?php echo e(asset('js/template.js')); ?>"></script>
        <script src="<?php echo e(asset('js/common.js')); ?>"></script>
</head>

<body>
    <div class="container-scroller">

        <!-- partial:partials/_navbar.html -->
        <nav class="navbar col-lg-12 col-12 p-0 fixed-top d-flex flex-row">
            <div class="navbar-brand-wrapper d-flex justify-content-center">
                <div class="navbar-brand-inner-wrapper d-flex justify-content-between align-items-center w-100">
                    <a class="navbar-brand brand-logo" href="<?php echo e(url('/admin')); ?>"><img src="<?php echo e(asset('images/logo.png')); ?>" alt="logo" /></a>
                    <a class="navbar-brand brand-logo-mini" href="<?php echo e(url('/admin')); ?>"><img src="images/logo.png" alt="logo" /></a>
                    <button class="navbar-toggler navbar-toggler align-self-center" type="button" data-toggle="minimize">
                        <span class="mdi mdi-sort-variant"></span>
                    </button>
                </div>
            </div>
            <div class="navbar-menu-wrapper d-flex align-items-center justify-content-end">
                <ul class="navbar-nav mr-lg-4 w-100">
                    <li class="nav-item nav-search d-none d-lg-block w-100">
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text" id="search">
                                    <i class="mdi mdi-magnify"></i>
                                </span>
                            </div>
                            <input type="text" class="form-control" placeholder="Search now" aria-label="search" aria-describedby="search">
                        </div>
                    </li>
                </ul>
                <ul class="navbar-nav navbar-nav-right">

                    <li class="nav-item dropdown">
                        <a class="nav-link count-indicator dropdown-toggle d-flex align-items-center justify-content-center notification-dropdown" id="notificationDropdown" href="#" data-bs-toggle="dropdown">
                            <i class="mdi mdi-bell mx-0"></i>
                            <span class="count"></span>
                        </a>
                        <div class="dropdown-menu dropdown-menu-right navbar-dropdown" aria-labelledby="notificationDropdown">
                            <p class="mb-0 font-weight-normal float-left dropdown-header">Notifications</p>
                            <a class="dropdown-item">
                                <div class="item-thumbnail">
                                    <div class="item-icon bg-success">
                                        <i class="mdi mdi-information mx-0"></i>
                                    </div>
                                </div>
                                <div class="item-content">
                                    <h6 class="font-weight-normal">Application Error</h6>
                                    <p class="font-weight-light small-text mb-0 text-muted">
                                        Just now
                                    </p>
                                </div>
                            </a>
                            <a class="dropdown-item">
                                <div class="item-thumbnail">
                                    <div class="item-icon bg-warning">
                                        <i class="mdi mdi-settings mx-0"></i>
                                    </div>
                                </div>
                                <div class="item-content">
                                    <h6 class="font-weight-normal">Settings</h6>
                                    <p class="font-weight-light small-text mb-0 text-muted">
                                        Private message
                                    </p>
                                </div>
                            </a>
                            <a class="dropdown-item">
                                <div class="item-thumbnail">
                                    <div class="item-icon bg-info">
                                        <i class="mdi mdi-account-box mx-0"></i>
                                    </div>
                                </div>
                                <div class="item-content">
                                    <h6 class="font-weight-normal">New user registration</h6>
                                    <p class="font-weight-light small-text mb-0 text-muted">
                                        2 days ago
                                    </p>
                                </div>
                            </a>
                        </div>
                    </li>
                    <li class="nav-item nav-profile dropdown">
    <a class="nav-link dropdown-toggle" href="#" data-bs-toggle="dropdown" id="profileDropdown">
        <img 
            src="<?php echo e(Auth::user()->profile_pic ? Storage::url(Auth::user()->profile_pic) : asset('images/profile.png')); ?>" 
            alt="profile"
        />
        <span class="nav-profile-name"><?php echo e(Auth::user()->name); ?></span>
    </a>
    <div class="dropdown-menu dropdown-menu-right navbar-dropdown" aria-labelledby="profileDropdown">
        <a class="dropdown-item" href="#">
            <i class="mdi mdi-settings text-primary"></i>
            Settings
        </a>
        <a class="dropdown-item" href="<?php echo e(route('logout')); ?>"
           onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
            <i class="mdi mdi-logout text-primary"></i>
            Logout
        </a>
    </div>
</li>

<!-- Hidden logout form (outside dropdown, ideally near bottom of the page) -->
<form id="logout-form" action="<?php echo e(route('logout')); ?>" method="POST" style="display: none;">
    <?php echo csrf_field(); ?>
</form>

                </ul>
                <button class="navbar-toggler navbar-toggler-right d-lg-none align-self-center" type="button" data-toggle="offcanvas">
                    <span class="mdi mdi-menu"></span>
                </button>
            </div>
        </nav>
        <!-- partial -->
        <div class="container-fluid page-body-wrapper">
            <!-- partial:partials/_sidebar.html -->
            <nav class="sidebar sidebar-offcanvas" id="sidebar">
                <ul class="nav">
                    <li class="nav-item">
                        <a class="nav-link" href="<?php echo e(url('/admin')); ?>">
                            <i class="mdi mdi-home menu-icon"></i>
                            <span class="menu-title">Dashboard</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="<?php echo e(url('/admin/newsletters')); ?>">
                            <i class="mdi mdi-office-building menu-icon"></i>
                            <span class="menu-title">Newsletters</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="<?php echo e(url('/admin/organizations')); ?>">
                            <i class="mdi mdi-office-building menu-icon"></i>
                            <span class="menu-title">Organizations</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="<?php echo e(url('/admin/templates')); ?>">
                            <i class="mdi mdi-office-building menu-icon"></i>
                            <span class="menu-title">Templates</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" data-bs-toggle="collapse" href="#ui-basic" aria-expanded="false" aria-controls="ui-basic">
                            <i class="mdi mdi-circle-outline menu-icon"></i>
                            <span class="menu-title">UI Elements</span>
                            <i class="menu-arrow"></i>
                        </a>
                        <div class="collapse" id="ui-basic">
                            <ul class="nav flex-column sub-menu">
                                <li class="nav-item"> <a class="nav-link" href="pages/ui-features/buttons.html">Buttons</a></li>
                                <li class="nav-item"> <a class="nav-link" href="pages/ui-features/typography.html">Typography</a></li>
                            </ul>
                        </div>
                    </li>
                </ul>
            </nav>
            <!-- partial -->
            <div class="main-panel">
                <div class="content-wrapper">
                
                    <?php if(session('success')): ?>
  <div class="alert alert-success">
    <?php echo e(session('success')); ?>

  </div>
<?php endif; ?>

<?php if(session('error')): ?>
  <div class="alert alert-danger">
    <?php echo e(session('error')); ?>

  </div>
<?php endif; ?>

                    <?php echo $__env->yieldContent('content'); ?>


                </div>
                <!-- content-wrapper ends -->
                <!-- partial:partials/_footer.html -->
                <footer class="footer">
                    <div class="d-sm-flex justify-content-center justify-content-sm-between">
                        <span class="text-muted text-center text-sm-left d-block d-sm-inline-block">Copyright © <a href="https://www.bootstrapdash.com/" target="_blank">bootstrapdash.com </a>2021</span>
                        <span class="float-none float-sm-right d-block mt-1 mt-sm-0 text-center">Only the best <a href="https://www.bootstrapdash.com/" target="_blank"> Bootstrap dashboard </a> templates</span>
                    </div>
                </footer>
                <!-- partial -->
            </div>
            <!-- main-panel ends -->
            <!-- page-body-wrapper ends -->
        </div>
        <!-- container-scroller -->

        <!-- End plugin js for this page-->
        <!-- inject:js -->

        <!-- endinject -->
        <!-- Custom js for this page-->

        <!-- End custom js for this page-->

        <!-- <script src="js/jquery.cookie.js" type="text/javascript"></script> -->
</body>

</html><?php /**PATH /home/customer/www/qms.lamtans.com/public_html/resources/views/layouts/app.blade.php ENDPATH**/ ?>