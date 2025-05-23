@extends('layouts.main')

@section('title', 'Items')

@section('contents')
    {{-- Alert Message --}}
    @if (session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <strong>Success!</strong> {{ session('success') }}
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
            </button>
        </div>
    @endif
    
    {{-- Contents --}}
    <div class="card">
        <div class="card-header">
            <div class="d-flex justify-content-between align-items-center">
                <p class="my-0 fs-4">Items Table</p>
                <div class="d-flex align-items-center">
                    <a href="{{ route('items.store-page') }}" class="btn btn-primary btn-sm ml-0 ml-md-2">Create New Item</a>
                    <button type="button" class="btn btn-primary btn-sm ml-0 ml-md-2" data-toggle="modal"
                        data-target="#newItemAjaxModal">Create New Item (AJAX)</button>
                    <button type="button" class="btn btn-primary btn-sm ml-0 ml-md-2" data-toggle="modal"
                    data-target="#importExcelItemAjaxModal">Import Data (AJAX)</button>
                    <a href="{{ route('items.export-excel') }}" class="btn btn-primary btn-sm ml-0 ml-md-2">Export Excel</a>
                    <a href="{{ route('items.export-pdf') }}" target="_blank" class="btn btn-primary btn-sm ml-0 ml-md-2">Export PDF</a>
                </div>
            </div>
        </div>
        <div class="card-body">
            <table class="table table-bordered" id="itemsTable">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Code</th>
                        <th>Name</th>
                        <th>Category</th>
                        <th>Actions</th>
                        <th>Actions AJAX</th>
                    </tr>
                </thead>
            </table>
        </div>
    </div>

    {{-- Load Modals --}}
    @include('pages.item.components.store-ajax')
    @include('pages.item.components.update-ajax')
    @include('pages.item.components.details-ajax')
    @include('pages.item.components.import-excel-data-ajax')
@endsection

@push('scripts')
    <script>
        const itemsTable = document.getElementById('itemsTable');

        let itemsDataTable = $(itemsTable).DataTable({
            serverSide: true,
            ajax: {
                url: "{{ route('items.list') }}",
                dataType: "JSON",
                type: "GET",
            },
            columns: [
                {
                    data: "DT_RowIndex",
                    className: "text-center",
                    orderable: false,
                    searchable: false
                },
                {
                    data: "item_code",
                    orderable: true,
                    searchable: true
                },
                {
                    data: "item_name",
                    orderable: true,
                    searchable: true
                },
                {
                    data: "category.category_name",
                    orderable: true,
                    searchable: true
                },
                {
                    data: "actions",
                    orderable: false,
                    searchable: false
                },
                {
                    data: "actions-ajax",
                    orderable: false,
                    searchable: false
                },
            ],
        });
    </script>

    {{-- Delete Item --}}
    <script>
        $(document).on('click', '.delete-item-ajax-btn', function() {
            let itemId = $(this).data('id');

            Swal.fire({
                title: 'Are you sure?',
                text: "You won't be able to revert this!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, delete it!'
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url: `/items/${itemId}/delete-ajax`,
                        type: 'DELETE',
                        success: function(response) {
                            Swal.fire(
                                'Deleted!',
                                response.message,
                                'success'
                            );

                            $('#itemsTable').DataTable().ajax.reload();
                        },
                        error: function(xhr) {
                            console.log(xhr.responseText);
                        }
                    });
                }
            });
        });
    </script>
@endpush