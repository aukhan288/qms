var csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

function downloadFile(id) {
    console.log("Clicked Newsletter:", id);

    $.ajax({
        url: '/download-file', // Your actual endpoint
        type: 'POST',
        data: {
            id: id,
            _token: csrfToken // Laravel CSRF token
        },
        xhrFields: {
            responseType: 'blob' // Important to receive binary data
        },
        success: function(blob, status, xhr) {
            // Get filename from Content-Disposition header if available
            var filename = "download.pdf"; // fallback filename
            var disposition = xhr.getResponseHeader('Content-Disposition');
            if (disposition && disposition.indexOf('attachment') !== -1) {
                var filenameRegex = /filename[^;=\n]*=((['"]).*?\2|[^;\n]*)/;
                var matches = filenameRegex.exec(disposition);
                if (matches != null && matches[1]) { 
                    filename = matches[1].replace(/['"]/g, '');
                }
            }

            // Create blob URL and trigger download
            var url = window.URL.createObjectURL(blob);
            var a = document.createElement('a');
            a.href = url;
            a.download = filename;
            document.body.appendChild(a);
            a.click();
            a.remove();
            window.URL.revokeObjectURL(url);

            console.log('Download triggered:', filename);
        },
        error: function(xhr, status, error) {
            console.error('Download failed:', error);
        }
    });
}