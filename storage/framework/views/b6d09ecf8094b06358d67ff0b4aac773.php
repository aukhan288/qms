<?php $__env->startSection('content'); ?>
<?php
    use App\Enums\TemplateCategory;
    use App\Enums\DocumentType;
?>


<div class="mb-3">
    <span class="pageHeading"><?php echo e($title??''); ?></span>
</div>
<div class="card p-3">
    <form id="orgForm"
          method="POST"
          action="<?php echo e($template ? route('template.create', $template->id) : route('template.create')); ?>"
          enctype="multipart/form-data"
          novalidate>
        <?php echo csrf_field(); ?>

        <div class="row">
            <div class="col-sm-7 mb-3">
                <label for="name" class="form-label">Template Name <span class="text-danger">*</span></label>
                <input type="text" class="form-control" id="name" name="name" required
                       value="<?php echo e(old('name', $template->name ?? '')); ?>">
            </div>
            <div class="col-sm-2 mb-3">
                <label for="document_type" class="form-label">Document Type <span class="text-danger">*</span></label>
                <select class="form-select" id="document_type" name="document_type" required>
                    <option value="">Select type</option>
                  <?php $__currentLoopData = \App\Enums\DocumentType::cases(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $type): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
    <?php
        $selectedValue = old('document_type') ?? ($template->document_type->value ?? $template->document_type ?? null);
    ?>

    <option value="<?php echo e($type->value); ?>"
        <?php echo e($selectedValue == $type->value ? 'selected' : ''); ?>>
        <?php echo e(strtoupper($type->value)); ?>

    </option>
<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

                </select>
            </div>
           
            <div class="col-sm-3 mb-3">
                <label for="category" class="form-label">Category <span class="text-danger">*</span></label>
                <select class="form-select" id="category" name="category" required>
                    <option value="">Select category</option>
                 <?php $__currentLoopData = \App\Enums\TemplateCategory::cases(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $category): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
    <?php
        $selectedValue = old('category') ?? ($template->category->value ?? $template->category ?? null);
    ?>

    <option value="<?php echo e($category->value); ?>"
        <?php echo e($selectedValue == $category->value ? 'selected' : ''); ?>>
        <?php echo e(ucfirst($category->value)); ?>

    </option>
<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

                </select>
            </div>
            
              <div class="col-sm-1 mb-3">
                <label for="ref" class="form-label">Ref # <span class="text-danger">*</span></label>
                <input type="text" class="form-control" id="ref" name="ref" required
                       value="<?php echo e(old('ref', $template->ref ?? '')); ?>">
            </div>
              <div class="col-sm-1 mb-3">
                <label for="revision" class="form-label">Revision <span class="text-danger">*</span></label>
                <input type="number" class="form-control" id="revision" name="revision" required
                       value="<?php echo e(old('revision', $template->revision ?? '')); ?>">
            </div>
              <div class="col-sm-1 mb-3">
                <label for="pages" class="form-label">No. Pages <span class="text-danger">*</span></label>
                <input type="number" class="form-control" id="pages" name="pages" required
                       value="<?php echo e(old('pages', $template->pages ?? '')); ?>">
            </div>
            <div class="col-sm-3 mb-3">
              <label for="revision_date" class="form-label">Revision Date <span class="text-danger">*</span></label>
              <input type="date" class="form-control" id="revision_date" name="revision_date" required
                     value="<?php echo e(old('revision_date', $template->revision_date ?? '')); ?>">
          </div>
            <div class="col-sm-6 mb-3" id="wordDiv" style="display:none">
              <label for="file" class="form-label">Word File <span class="text-danger">*</span></label>
              <input type="file" class="form-control" id="file" name="file" 
                     value="" disabled>
          </div>
       

        <!-- HTML Content -->
        <div class="mb-3" id="htmlDiv" style="display:none">
            <label for="editor" class="form-label">Content <span class="text-danger">*</span>   <small class="text-muted d-block">Please use HTML for PDF</small></label>
           <textarea name="content" id="editor" class="form-control" style="height: 300px; overflow-y: auto; resize: vertical;" disabled>
    <?php echo e(old('content', $template->content ?? '')); ?>

</textarea>


        </div>

        <div class="modal-footer">
            <button type="submit" class="btn btn-primary text-white"><?php echo e($template ? 'Update' : 'Save'); ?></button>
        </div>
    </form>
</div>


<script>
    $(document).ready(function(){
        let template = <?php echo json_encode($template, 15, 512) ?>;
     if (template) {
    if (template?.document_type == 'word') {
        $('#htmlDiv').hide();
        $('#htmlDiv textarea').prop('disabled', true);
        $('#wordDiv').show();
        $('#wordDiv input').prop('disabled', false);
    } else {
        $('#htmlDiv').show();
        $('#htmlDiv textarea').prop('disabled', false);
        $('#wordDiv').hide();
        $('#wordDiv input').prop('disabled', true);
    }
}

    });
$('#document_type').on('change', function () {
    const value = $(this).val();

    if (value === 'pdf') {
        $('#htmlDiv').show().find('textarea').prop('disabled', false);
        $('#wordDiv').hide().find('input').prop('disabled', true);
    } else if (value === 'word') {
        $('#htmlDiv').hide().find('textarea').prop('disabled', true);
        $('#wordDiv').show().find('input').prop('disabled', false);
    } else {
        $('#htmlDiv, #wordDiv').hide();
        $('#htmlDiv textarea, #wordDiv input').prop('disabled', true);
    }
});


    document.addEventListener('DOMContentLoaded', function () {
        // CKEDITOR.replace('editor', {
        //     toolbar: [
        //         { name: 'document', items: ['Source'] },
        //         { name: 'basicstyles', items: ['Bold', 'Italic', 'Underline'] },
        //         { name: 'paragraph', items: ['NumberedList', 'BulletedList'] },
        //         { name: 'links', items: ['Link', 'Unlink'] },
        //         { name: 'insert', items: ['Image', 'Table'] },
        //         { name: 'tools', items: ['Maximize'] },
        //         { name: 'editing', items: ['Scayt'] }
        //     ]
        // });
    });
</script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /home/customer/www/qms.lamtans.com/public_html/resources/views/admin/create-template.blade.php ENDPATH**/ ?>