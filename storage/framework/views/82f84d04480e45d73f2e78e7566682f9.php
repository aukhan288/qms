<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title><?php echo $__env->yieldContent('title', 'Auth'); ?></title>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <link rel="stylesheet" href="<?php echo e(asset('mdi/css/materialdesignicons.min.css')); ?>">

    <!-- End plugin css for this page -->
    <!-- inject:css -->
    <link rel="stylesheet" href="<?php echo e(asset('css/bootstrap.min.css')); ?>">
    <link rel="stylesheet" href="<?php echo e(asset('css/style.css')); ?>">

    <!-- endinject -->
    <link rel="shortcut icon" href="<?php echo e(asset('images/logo.png')); ?>" />
</head>
<body class="bg-light">
    <div class="container mt-5">
        <?php echo $__env->yieldContent('content'); ?>
    </div>

    <script src="<?php echo e(asset('js/bootstrap.min.js')); ?>"></script>
    <script src="<?php echo e(asset('js/jquery.min.js')); ?>"></script>
    <script src="<?php echo e(asset('js/popper.min.js')); ?>"></script>
    <script src="<?php echo e(asset('js/template.js')); ?>"></script>
    <!-- endinject -->
    <!-- Custom js for this page-->
    
    <!-- End custom js for this page-->

    <script src="js/jquery.cookie.js" type="text/javascript"></script>
</body>
</html><?php /**PATH /home/customer/www/qms.lamtans.com/public_html/resources/views/layouts/auth.blade.php ENDPATH**/ ?>