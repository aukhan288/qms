@extends('layouts.app')

@section('content')
<div class="d-flex">
<button 
  type="button" 
  class="btn btn-primary btn-sm text-white mb-3 ms-auto" 
  onclick="window.location.href='{{ url('admin/template') }}'">
  Add Template
</button>

</div>
<div class="" style="background-color: #fff;
    padding: 1.5em;
    border: 1px solid rgba(0, 0, 0, .3);
    border-radius: 7px;">
    <table class="table-sm table table-bordered" id="templatesTable" >
    </table>
</div>

<script>
$(document).ready(function () {
    $('#templatesTable').DataTable({
    processing: true,
    serverSide: false,
    ajax: {
        url: "{{ route('templates.list') }}",
        type: 'GET',
        dataSrc: function (json) {
            console.log(json.data);
            return json.data ?? json;
        }
    },
    columns: [
        { title: '#', data: 'id' },
        { title: 'Ref', data: 'ref' },
        { title: 'Name', data: 'name' },
        { title: 'Published', data: '', render: function (data, type, row) {
            return `<button class="btn btn-sm btn-success" >${row.published ?'Publish':'Un Publish'}</button>`;
        }},
        {
          title: 'Type',
    data: '',
    render: function(data, type, row) {
        let icon = '';
        if (row.document_type === 'pdf') {
            icon = 'file-pdf-box text-danger';
        } else if (row.document_type === 'word') {
            icon = 'file-word-box text-primary';
        } else {
            icon = 'file-document-box'; // default
        }
        return `<i class="mdi mdi-${icon}" style="font-size: 24px;"></i>`;
    }
},

        { title: 'Category', data: '', render: function (data, type, row) {
            return row.category.charAt(0).toUpperCase() + row.category.slice(1);
        }},
        { title: 'Created Date', data: '', render: function (data, type, row) {
            return moment(row.created_at).format("MMM Do YYYY");;
        }},
        { title: 'Actions', data: '', render: function (data, type, row) {
            return `
                <button class="btn btn-sm btn-success download-btn" onclick="downloadFile(${row?.id})"><i class="mdi mdi-download"></i></button>
                <button class="btn btn-sm btn-primary edit-btn" onclick="window.location.href='https://qms.lamtans.com/admin/template/${row?.id}'"><i class="mdi mdi-pencil"></i></button>
                <button class="btn btn-sm btn-danger delete-btn" data-id="${row.id}"><i class="mdi mdi-delete"></i></button>
            `;
        }, orderable: false, searchable: false }
    ]
});

$('#orgForm').on('submit', function (e) {
        e.preventDefault();

        let form = $(this)[0];
        let formData = new FormData(form);

        $.ajax({
            url: "{{ route('organizations.store') }}",
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

@endsection