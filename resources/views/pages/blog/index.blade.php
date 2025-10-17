@extends('layouts.master')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-header d-flex align-items-center">
                    <h5 class="card-title mb-0 flex-grow-1">Blog List</h5>
                    <div>
                        <a href="{{ route('blog.create') }}" class="btn btn-primary">
                            Add Blog
                        </a>
                    </div>
                </div>

                <div class="card-body">
                    <table id="blog-table" class="table table-bordered table-striped align-middle">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Image</th>
                                <th>Title</th>
                                <th>Description</th>
                                <th>Meta Keyword</th>
                                <th>Date</th>
                                <th>Status</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
/* Table styles to prevent horizontal scroll */
.table {
    width: 100% !important;
}
.table th, .table td {
    white-space: normal;
}
</style>

@endsection

@push('scripts')
<script>
    $(document).ready(function() {
        var table = $('#blog-table').DataTable({
            processing: true,
            serverSide: true,
            scrollX: false,
            ajax: "{{ route('blog.index') }}",
            columns: [
                {data: 'id', name: 'id'},
                {data: 'image', name: 'image', orderable: false, searchable: false},
                {data: 'title', name: 'title'},
                {data: 'description', name: 'description', orderable: false},
                {data: 'meta_keyword', name: 'meta_keyword'},
                {data: 'date', name: 'date'},
                {data: 'status', name: 'status'},
                {data: 'action', name: 'action', orderable: false, searchable: false}
            ],
            order: [[0, 'desc']]
        });

        // Delete confirmation
        $(document).on('click', '.show-confirm', function(e) {
            e.preventDefault();
            let form = $(this).closest('form');
            Swal.fire({
                title: 'Are you sure?',
                text: "This action cannot be undone!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, delete it!'
            }).then((result) => {
                if (result.isConfirmed) {
                    form.submit();
                }
            });
        });
    });
</script>
@endpush
