@extends('layouts.master')
@section('title', 'Users')
@section('content')
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-header d-flex align-items-center">
                    <h5 class="card-title mb-0 flex-grow-1">User List</h5>
                    <div>
                        @if(auth()->user()->hasRole('admin') || auth()->user()->can('create-user'))
                        <a id="addRow" href="{{ route('users.create') }}" class="btn btn-primary">
                            Add User
                        </a>
                        @endif
                    </div>
                </div>
                <div class="card-body">
                    <table id="users-table" class="table table-bordered dt-responsive nowrap table-striped align-middle">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Image</th>
                                <th>Name</th>
                                <th>Email</th>
                                <th>Phone</th>
                                <th>Roles</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
<script>
    $(document).ready(function() {
        var table = $('#users-table').DataTable({
            processing: true,
            serverSide: true,
            ajax: "{{ route('users.index') }}",
            columns: [
                {data: 'id', name: 'id'},
                {data: 'image', name: 'image', orderable: false, searchable: false},
                {data: 'name', name: 'name'},
                {data: 'email', name: 'email'},
                {data: 'phone', name: 'phone'},
                {data: 'roles', name: 'roles'},
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
                    $.ajax({
                        url: form.attr('action'),
                        type: 'POST',
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        data: {
                            _method: 'DELETE'
                        },
                        success: function(response) {
                            Swal.fire({
                                title: 'Deleted!',
                                text: 'User has been deleted successfully.',
                                icon: 'success',
                                confirmButtonText: 'OK'
                            }).then(() => {
                                table.ajax.reload();
                            });
                        },
                        error: function() {
                            Swal.fire({
                                title: 'Error!',
                                text: 'Something went wrong.',
                                icon: 'error',
                                confirmButtonText: 'OK'
                            });
                        }
                    });
                }
            });
        });
    });
</script>
@endpush

