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
       <h2 class="text-success"><?php echo e($title??''); ?></h2>
 <table class="table">
    <thead class="tbl-tr">
        <tr class="tbl-tr">
            <?php $__currentLoopData = $tFields; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $head): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <th><?php echo e(ucwords(str_replace('_', ' ', $head))); ?></th>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            <th class="text-center">Options</th>
        </tr>
    </thead>
    <tbody>
        <?php $__empty_1 = true; $__currentLoopData = $documents; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $doc): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
            <tr class="tbl-tr">
        
                <?php $__currentLoopData = $tFields; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $field): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <?php if($field == 'type'): ?>
                     <?php if($doc->document_type->value=='word'): ?>
                        <td><i class="mdi mdi-file-word" style="color:blue; font-size:18px"></i></td>
                     <?php elseif($doc->document_type->value=='pdf'): ?>
                        <td><i class="mdi mdi-file-pdf text-danger" style="font-size:18px"></i></td>
                     <?php endif; ?>   
                    <?php else: ?>
                        <td><?php echo e($doc->$field); ?></td>
                    <?php endif; ?>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                <td class="text-center">
                    <a href="#" onclick="downloadFile(<?php echo e($doc->id); ?>); return false;">
                        <i class="mdi mdi-download"></i>
                    </a>
                </td>
            </tr>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
            <tr class="tbl-tr">
                <td colspan="<?php echo e(count($tFields) + 1); ?>" class="text-center">No documents found.</td>
            </tr>
        <?php endif; ?>
    </tbody>
</table>


    </div>
</div>
<script>


</script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.base', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /home/customer/www/qms.lamtans.com/public_html/resources/views/user/documents.blade.php ENDPATH**/ ?>