<?php $__env->startSection('title', 'Login'); ?>

<?php $__env->startSection('page'); ?>
<div class="row justify-content-center py-5">
    <div class="col-md-8 col-lg-8 card p-5 bg-dark">
        <h3 class="text-white mb-4">Login</h3>
        <form method="POST" action="<?php echo e(route('login')); ?>">
            <?php echo csrf_field(); ?>

            <?php if(session('status')): ?>
                <div class="alert alert-success"><?php echo e(session('status')); ?></div>
            <?php endif; ?>

            <div class="mb-3">
                <label class="text-white">Email Address</label>
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
                <label class="text-white">Password</label>
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
                <div>
                    <div class="form-check text-white">
                      <input type="checkbox" name="remember" class="form-check-input" id="remember">
                      <label class="form-check-label" for="remember">Remember Me</label>
                    </div>
                    <div class="text-center">
                      <a href="<?php echo e(route('password.request')); ?>">Forgot Password?</a>
                    </div>
                </div> 
                <button type="submit" class="btn bg-success text-white" style="height: 38px;">Login</button>
            </div>
            
        </form>
    </div>
    <div class="col-sm-4">
        <img class="img-fluid" src="https://qms.easy-pasplus.com/templates/easypasplus_qms/images/competent-person.png" alt="">
    </div>
</div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.base', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /home/customer/www/qms.lamtans.com/public_html/resources/views/auth/login.blade.php ENDPATH**/ ?>