<?php $__env->startSection('title', 'Login'); ?>

<?php $__env->startSection('content'); ?>

<div class="row justify-content-center">
    <div class="text-center mb-3 mt-5"><img src="<?php echo e(asset('images/logo.png')); ?>" alt=""></div>
    <div class="col-md-6 col-lg-4 card pt-5 pb-5 ms-5 me-4">
        <h3 class="text-center mb-4">Login</h3>
        <form method="POST" action="<?php echo e(route('login')); ?>">
            <?php echo csrf_field(); ?>

            <?php if(session('status')): ?>
                <div class="alert alert-success"><?php echo e(session('status')); ?></div>
            <?php endif; ?>

            <div class="mb-3">
                <label>Email Address</label>
                <input type="email" name="email" value="<?php echo e(old('email')); ?>" class="form-control" required autofocus>
                <?php $__errorArgs = ['email'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <small class="text-danger"><?php echo e($message); ?></small> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
            </div>

            <div class="mb-3">
                <label>Password</label>
                <input type="password" name="password" class="form-control" required>
                <?php $__errorArgs = ['password'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <small class="text-danger"><?php echo e($message); ?></small> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
            </div>
            <div class="d-flex justify-content-between">
                <div class="mb-3 form-check">
                <input type="checkbox" name="remember" class="form-check-input" id="remember">
                <label class="form-check-label" for="remember">Remember Me</label>
            </div>
                <div class="text-center mt-3">
                <a href="<?php echo e(route('password.request')); ?>">Forgot Password?</a>
            </div>
            </div>
            <div class="d-grid">
                <button type="submit" class="btn btn-primary">Login</button>
            </div>
        </form>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.auth', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /home/customer/www/qms.lamtans.com/public_html/resources/views/auth/admin-login.blade.php ENDPATH**/ ?>