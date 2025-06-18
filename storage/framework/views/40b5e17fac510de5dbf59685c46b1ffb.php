<?php
    use App\Enums\TemplateCategory;
?>
<aside class="col-md-3">
        <nav class="bg-dark pt-3">
            <h2 class="text-success ms-3">Menu</h2>
            <ul class="nav flex-column">
            <li class="nav-item py-2 bg-dark">
                <a class="nav-link text-white d-flex align-items-center" href="#"><i class="mdi mdi-dashboard mdi-24px"></i> Dashboard</a>
            </li>

                <li class="nav-item py-2 bg-dark">
<li class="nav-item">
    <form method="POST" action="<?php echo e(route('logout')); ?>">
        <?php echo csrf_field(); ?>
        <button type="submit" class="btn nav-link text-white d-flex align-items-center border-0 bg-transparent">
            <i class="mdi mdi-logout mdi-24px me-2"></i> Logout
        </button>
    </form>
</li>

                </li>
                <li class="nav-item py-2 bg-dark">
                    <a class="nav-link text-white d-flex align-items-center" href="#"><i class="mdi mdi-currency-gbp mdi-24px"></i> Billing Info</a>
                </li>
               <li class="nav-item py-2 bg-success">
                <a class="nav-link text-white d-flex align-items-center" data-bs-toggle="collapse" href="#authSubmenu" role="button" aria-expanded="false" aria-controls="authSubmenu">
                    </i> Installer QMS (v10) <i class="mdi mdi-chevron-down ms-auto"></i>
                </a>
                <ul class="collapse list-unstyled ps-4 bg-dark" id="authSubmenu">
                    <?php $__currentLoopData = TemplateCategory::cases(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $category): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <li class="nav-item py-1">
                            <a class="nav-link text-white" href="<?php echo e(url('/documents/' . $category->value)); ?>">
                                <?php echo e(ucwords($category->value)); ?>

                            </a>
                        </li>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </ul>
            </li>
            </ul>
        </nav>
    </aside><?php /**PATH /home/customer/www/qms.lamtans.com/public_html/resources/views/components/user-side_menu.blade.php ENDPATH**/ ?>