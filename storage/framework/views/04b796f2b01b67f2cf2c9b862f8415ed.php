<?php $__env->startSection('content'); ?>
<div class="d-flex">
    <button type="button" class="btn btn-primary btn-sm text-white mb-3 ms-auto" data-bs-toggle="modal" data-bs-target="#newsletterModal">
      Add Newsletter
    </button>
</div>
<div class="bg-white p-4 border rounded">
    <table class="table-sm table table-bordered" id="newslettersTable"></table>
</div>

<!-- Modal -->
<div class="modal fade" id="newsletterModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="newsletterModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-md">
    <div class="modal-content">
      <form id="newsletterForm" enctype="multipart/form-data" novalidate>
        <?php echo csrf_field(); ?>
        <div class="modal-header">
          <h1 class="modal-title fs-5" id="newsletterModalLabel">Add Newsletter</h1>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>

        <div class="modal-body">
          <div class="mb-3">
            <label for="name" class="form-label">Newsletter Name <span class="text-danger">*</span></label>
            <input type="text" class="form-control" id="name" name="name" required>
          </div>

          
          <div class="row">
            <div class="col-sm-8">
              <div class="mb-3">
            <label for="type" class="form-label">Type <span class="text-danger">*</span></label>
            <select class="form-select" id="type" name="type" required>
              <option value="">Select Type</option>
              <option value="quarterly">Quarterly</option>
              <option value="half_yearly">Half Yearly</option>
              <option value="yearly">Yearly</option>
            </select>
          </div>
            </div>
            <div class="col-sm-4 d-flex">
                <div class="form-check m-auto me-0">
            <input class="form-check-input" type="checkbox" id="is_active" name="is_active">
            <label class="form-check-label" for="is_active">Active</label>
          </div>
            </div>
          </div>
          <div class="mb-3">
            <label for="file" class="form-label">Upload File (PDF or HTML)</label>
            <input type="file" class="form-control" id="file" name="file" accept=".pdf,.html">
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
   $('#newslettersTable').DataTable({
    processing: true,
    serverSide: true,
    ajax: "<?php echo e(route('admin.newsletters.list')); ?>",
    columns: [
        { title: '#', data: 'id' },
        { title: 'Name', data: 'name' },
        { title: 'Type', data: 'type' },
        {
            title: 'PDF',
            data: 'file_path',
         render: function (data) {
    if (!data) return '-';
    return `<a href="/storage/${data}" target="_blank" class="" title="Download PDF">
                <i class="mdi mdi-file-pdf text-danger fs-5" title="PDF Available"></i>

            </a>`;
}

        },
    {
    title: 'Status',
    data: 'is_active',
    render: function (data) {
        return data
            ? '<i class="mdi mdi-check-circle text-success fs-5" title="Active"></i>'
            : '<i class="mdi mdi-close-circle text-danger fs-5" title="Inactive"></i>';
    }
},

      {
    title: 'Created At',
    data: 'created_at',
    render: function (data) {
        if (!data) return '';
        const date = new Date(data);
        const day = date.getDate();
        const monthNames = ["Jan", "Feb", "Mar", "Apr", "May", "Jun", "Jul", "Aug", "Sep", "Oct", "Nov", "Dec"];
        const month = monthNames[date.getMonth()];
        const year = date.getFullYear();

        // Time formatting
        let hours = date.getHours();
        const minutes = date.getMinutes().toString().padStart(2, '0');
        const ampm = hours >= 12 ? 'PM' : 'AM';
        hours = hours % 12 || 12;

        const formattedTime = `${hours}:${minutes} ${ampm}`;

        // Suffix logic
        const getOrdinal = (n) => {
            const s = ["th", "st", "nd", "rd"];
            const v = n % 100;
            return n + (s[(v - 20) % 10] || s[v] || s[0]);
        };

        const formattedDate = `${getOrdinal(day)} ${month} ${year}`;
        return `${formattedDate} <small class="text-muted">${formattedTime}</small>`;
    }
},
{
    title: 'Action',
    data: null,
    orderable: false,
    searchable: false,
    render: function (data, type, row) {
        return `
            <a class="me-1" onclick="editNewsletter(${row.id})" title="Edit">
                <i class="mdi mdi-pencil fs-5"></i>
            </a>
            <a class="text-danger" onclick="deleteNewsletter(${row.id})" title="Delete">
                <i class="mdi mdi-delete fs-5"></i>
            </a>
        `;
    }
}


    ]
});

    $('#newsletterForm').on('submit', function (e) {
        e.preventDefault();

        let form = $(this)[0];
        let formData = new FormData(form);

        $.ajax({
            url: "<?php echo e(route('admin.newsletter.create')); ?>",
            type: "POST",
            data: formData,
            contentType: false,
            processData: false,
            headers: {
                'X-CSRF-TOKEN': $('input[name="_token"]').val()
            },
            success: function () {
                $('#newsletterModal').modal('hide');
                alert("Newsletter added successfully!");
                $('#newsletterForm')[0].reset();
                $('#newslettersTable').DataTable().ajax.reload();
            },
            error: function (xhr) {
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

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /home/customer/www/qms.lamtans.com/public_html/resources/views/admin/newsletters.blade.php ENDPATH**/ ?>