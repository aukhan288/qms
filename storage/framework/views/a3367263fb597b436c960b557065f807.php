<?php $__env->startSection('content'); ?>
<div class="d-flex">
    <button type="button" class="btn btn-primary btn-sm text-white mb-3 ms-auto" data-bs-toggle="modal" data-bs-target="#staticBackdrop">
      Add Organization
    </button>
</div>
<div class="" style="background-color: #fff;
    padding: 1.5em;
    border: 1px solid rgba(0, 0, 0, .3);
    border-radius: 7px;">
    <table class="table-sm table table-bordered" id="organizationsTable" >
    </table>
</div>



<!-- Modal -->
<div class="modal fade" id="staticBackdrop" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <form id="orgForm" enctype="multipart/form-data" novalidate>
        <?php echo csrf_field(); ?>
        <div class="modal-header">
          <h1 class="modal-title fs-5" id="staticBackdropLabel">Add Organization</h1>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>

        <div class="modal-body">
          <!-- Full Name -->
          <div class="mb-3">
            <label for="name" class="form-label">Full Name<span class="text-danger">*</span></label>
            <input type="text" class="form-control" id="name" name="name" required>
          </div>

          <!-- Email Address -->
          <div class="mb-3">
            <label for="email" class="form-label">Email address<span class="text-danger">*</span></label>
            <input type="email" class="form-control" id="email" name="email" required>
          </div>

          <!-- Company Name -->
          <div class="mb-3">
            <label for="org" class="form-label">Company Name<span class="text-danger">*</span></label>
            <input type="text" class="form-control" id="org" name="org" required>
          </div>

          <!-- Profile Picture -->
          <div class="mb-3">
            <label for="profile_pic" class="form-label">Company Logo<span class="text-danger">*</span></label>
            <input type="file" class="form-control" id="profile_pic" name="profile_pic" accept="image/*">
          </div>

          <!-- Street Address -->
          <div class="mb-3">
            <label for="street" class="form-label">Street Address<span class="text-danger">*</span></label>
            <input type="text" class="form-control" id="street" name="street" required>
          </div>

          <div class="row">
            <!-- District -->
            <div class="mb-3 col-sm-4">
              <label for="district" class="form-label">District<span class="text-danger">*</span></label>
              <input type="text" class="form-control" id="district" name="district" required>
            </div>

            <!-- City -->
            <div class="mb-3 col-sm-4">
              <label for="city" class="form-label">City<span class="text-danger">*</span></label>
              <input type="text" class="form-control" id="city" name="city" required>
            </div>

            <!-- Postal Code -->
            <div class="mb-3 col-sm-4">
              <label for="postal_code" class="form-label">Postal Code<span class="text-danger">*</span></label>
              <input type="text" class="form-control" id="postal_code" name="postal_code" required>
            </div>
          </div>  
          </div>

        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
          <button type="submit" class="btn btn-primary text-white">Save</button>
        </div>
      </form>
    </div>
  </div>
</div>


<script>
$(document).ready(function () {
    $('#organizationsTable').DataTable({
    processing: true,
    serverSide: false,
    ajax: {
        url: "<?php echo e(route('organizations.list')); ?>",
        type: 'GET',
        dataSrc: function (json) {
            console.log(json.data);
            return json.data ?? json;
        }
    },
    columns: [
        { title: '#', data: 'id' },
        { 
            title: 'Logo',
            data: 'profile_pic',
            render: function (data, type, row) {
                let imgSrc = data ? `${data}` : "<?php echo e(asset('images/profile.png')); ?>";
                return `<img src="${imgSrc}" alt="profile" width="40" height="40" style="object-fit: cover; border-radius: 50%;">`;
            },
            orderable: false,
            searchable: false
        },
        { title: 'Name', data: 'name' },
        { title: 'Email', data: 'email' },
        { 
            title: 'Organization', 
            data: 'org',
            defaultContent: '-' // in case org is null
        }
    ]
});

$('#orgForm').on('submit', function (e) {
        e.preventDefault();

        let form = $(this)[0];
        let formData = new FormData(form);

        $.ajax({
            url: "<?php echo e(route('organizations.store')); ?>",
            type: "POST",
            data: formData,
            contentType: false,
            processData: false,
            headers: {
                'X-CSRF-TOKEN': $('input[name="_token"]').val()
            },
            success: function (response) {
                // Optionally close modal and show success message
                $('#staticBackdrop').modal('hide');
                alert("Organization added successfully!");

                // Optionally clear form
                $('#orgForm')[0].reset();
                $('.is-invalid').removeClass('is-invalid');
                $('.invalid-feedback').remove();
            },
            error: function (xhr) {
                // Remove existing errors
                $('.is-invalid').removeClass('is-invalid');
                $('.invalid-feedback').remove();

                if (xhr.status === 422) {
                    let errors = xhr.responseJSON.errors;
                    for (let field in errors) {
                        let input = $('[name="' + field + '"]');
                        input.addClass('is-invalid');
                        input.after('<div class="invalid-feedback">' + errors[field][0] + '</div>');
                    }
                } else {
                    alert("Something went wrong. Please try again.");
                }
            }
        });
    });
});
</script>

<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /home/customer/www/qms.lamtans.com/public_html/resources/views/admin/organizations.blade.php ENDPATH**/ ?>