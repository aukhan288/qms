<?php $__env->startSection('page'); ?>
<div class="row py-5 ms-5 me-5">
    <?php if (isset($component)) { $__componentOriginal95e65e5e8cdd528c6fe4473895fa9309 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal95e65e5e8cdd528c6fe4473895fa9309 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.user-side_menu','data' => []] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('user-side_menu'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal95e65e5e8cdd528c6fe4473895fa9309)): ?>
<?php $attributes = $__attributesOriginal95e65e5e8cdd528c6fe4473895fa9309; ?>
<?php unset($__attributesOriginal95e65e5e8cdd528c6fe4473895fa9309); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal95e65e5e8cdd528c6fe4473895fa9309)): ?>
<?php $component = $__componentOriginal95e65e5e8cdd528c6fe4473895fa9309; ?>
<?php unset($__componentOriginal95e65e5e8cdd528c6fe4473895fa9309); ?>
<?php endif; ?>
    <div class="col-md-9">
        <a href=""><img src="https://qms.easy-pasplus.com/templates/easypasplus_qms/images/competent-person-dashboard.png" alt=""></a>
        <div class="mt-5">
            <h3 class="text-success">My Account</h3>
            <hr>
            <div class="row">
                <div class="col-sm-4 border-end border-1">
                    <h4 class="text-success">Business Details</h4>
                    <span>
                    <img src="<?php echo e(Storage::url(Auth::user()->profile_pic)); ?>" class="img-fluid" alt="Profile Picture" />
                    </span>
                    <p class="mt-3"><?php echo e(Auth::user()->org); ?> <br>
                    <?php echo e(Auth::user()->street); ?> <br>
                    <?php echo e(Auth::user()->district); ?> <br>
                    <?php echo e(Auth::user()->city); ?> <br>
                    <?php echo e(Auth::user()->postal_code); ?></p>
                </div>
                <div class="col-sm-4 border-end border-1">
                  <h4 class="text-success">Nominee</h4>
                  <p class="mt-3"><?php echo e(Auth::user()->name); ?></p>
                </div>
                <div class="col-sm-4">
                <h4 class="text-success">Quarterly Newsletters</h4>
                <?php $__currentLoopData = $newsletters; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $nl): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
               
                 <a style="
                 text-decoration: none;
    color: #55A850;
    word-break: break-word;
    -webkit-hyphens: auto;
    -moz-hyphens: auto;
    hyphens: auto;
    font-size:12px;
    font-weight:700
                 " 
                 onclick="downloadFile('<?php echo e($nl->id); ?>');  return false;"
                 href="<?php echo e(Storage::url($nl->file_path)); ?>"><?php echo e($nl->name); ?></a><br>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?> 
                </div>
            </div>
            <hr>
            <h3 class="text-success">Notification Center</h3>
            <hr>
            <h5 class="text-success">Upcoming Renewals</h5>
            <table class="table table-sm table-striped">
                <thead>
                    <th>Type</th>
                    <th>Description</th>
                    <th>Renewal Date</th>
                    <th>Options</th>
                </thead>
                <tbody>
                    <tr>
                        <td>R11</td>
                        <td>Caunce O'Hara</td>
                        <td>2025-06-04</td>
                        <td>View</td>		
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</div>
<script>
   

</script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.base', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /home/customer/www/qms.lamtans.com/public_html/resources/views/user/home.blade.php ENDPATH**/ ?>