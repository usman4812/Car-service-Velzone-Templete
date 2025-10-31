@extends('layouts.master')
@section('title', 'Permissions')
@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-header d-flex align-items-center">
                    <h5 class="card-title mb-0 flex-grow-1">Permissions List</h5>
                </div>
                <div class="card-body">
                    <table id="permissions-table" class="table table-bordered dt-responsive nowrap table-striped align-middle">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Permission Name</th>
                                <th>Module</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    $(document).ready(function() {
        var table = $('#permissions-table').DataTable({
            processing: true,
            serverSide: true,
            ajax: "{{ route('permissions.index') }}",
            columns: [
                {data: 'id', name: 'id'},
                {data: 'name', name: 'name'},
                {data: 'module', name: 'module'},
                {data: 'action_name', name: 'action_name'}
            ],
            order: [[0, 'desc']]
        });
    });
</script>
@endpush


