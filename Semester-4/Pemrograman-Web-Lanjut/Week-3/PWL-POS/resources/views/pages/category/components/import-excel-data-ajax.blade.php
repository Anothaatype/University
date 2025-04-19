<div class="modal fade" id="importExcelCategoryAjaxModal" tabindex="-1" role="dialog"
    aria-labelledby="importExcelCategoryAjaxModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="importExcelCategoryAjaxModalLabel">Import Data (Excel)</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="{{ route('categories.import-excel-ajax') }}" method="POST" id="importExcelCategoryAjaxForm">
                @csrf
                <div class="modal-body">
                    <div class="form-group">
                        <label for="file" class="form-label">File</label>
                        <input class="form-control" type="file" id="file" name="file">
                        <small class="error-text text-danger" id="error-file"></small>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-success btn-sm">Upload</button>
                </div>
            </form>
        </div>
    </div>
</div>

@push('scripts')
    <script>
        $(document).ready(function() {
            $('#importExcelCategoryAjaxForm').validate({
                rules: {
                    file: {
                        required: true,
                        extension: "xlsx|xls|csv"
                    },
                },
                submitHandler: function(form) {
                    $.ajax({
                        url: form.action,
                        type: form.method,
                        data: new FormData(form),
                        contentType: false,
                        processData: false,
                        success: function(response) {
                            if (response.success) {
                                $('#importExcelCategoryAjaxModal').modal('hide');
                                Swal.fire({
                                    icon: 'success',
                                    title: 'Success',
                                    text: response.message
                                });

                                $('#categoriesTable').DataTable().ajax.reload();
                            } else {
                                $('.error-text').text('');
                                $.each(response.errors, function(key, value) {
                                    $('#error-' + key).text(value);
                                })

                                Swal.fire({
                                    icon: 'error',
                                    title: 'Error',
                                    text: response.message
                                });
                            }
                        },
                        error: function(xhr) {
                            console.log(xhr.responseText);
                        }
                    });

                    return false;
                },
                errorElement: 'small',
                errorPlacement: function(error, element) {
                    error.addClass('invalid-feedback');
                    element.closest('.form-group').append(error);
                },
                highlight: function(element, errorClass, validClass) {
                    $(element).addClass('is-invalid');
                },
                unhighlight: function(element, errorClass, validClass) {
                    $(element).removeClass('is-invalid');
                }
            });
        });
    </script>
@endpush
