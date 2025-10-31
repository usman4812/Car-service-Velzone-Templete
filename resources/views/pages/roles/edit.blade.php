@extends('layouts.master')
@section('title', 'Edit Role')
@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title mb-0">Edit Role</h5>
                </div>
                <div class="card-body">
                    <form action="{{ route('roles.update', $role) }}" method="POST" id="roleForm">
                        @csrf
                        @method('PUT')
                        <div class="row g-3">
                            <div class="col-lg-12">
                                <div class="form-group">
                                    <label for="name" class="form-label">Role Name <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" id="name" name="name" value="{{ old('name', $role->name) }}" required>
                                    @error('name')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-lg-12">
                                <div class="form-group">
                                    <label class="form-label">Permissions <span class="text-danger">*</span></label>
                                    <div class="row">
                                        @foreach($permissions as $module => $modulePermissions)
                                            <div class="col-md-4 mb-3">
                                                <div class="card">
                                                    <div class="card-header bg-light">
                                                        <h6 class="mb-0">{{ ucfirst(str_replace('-', ' ', $module)) }}</h6>
                                                    </div>
                                                    <div class="card-body">
                                                        @foreach($modulePermissions as $permission)
                                                            <div class="form-check mb-2">
                                                                <input class="form-check-input" type="checkbox"
                                                                    name="permissions[]" value="{{ $permission->id }}"
                                                                    id="permission_{{ $permission->id }}"
                                                                    {{ $role->permissions->contains($permission->id) ? 'checked' : '' }}>
                                                                <label class="form-check-label" for="permission_{{ $permission->id }}">
                                                                    {{ ucfirst(str_replace('-', ' ', explode('-', $permission->name, 2)[1] ?? $permission->name)) }}
                                                                </label>
                                                            </div>
                                                        @endforeach
                                                    </div>
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                    @error('permissions')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-lg-12">
                                <div class="d-flex justify-content-between align-items-center">
                                    <a href="{{ route('roles.index') }}" class="btn btn-danger waves-effect">
                                        <i class="ri-arrow-left-line align-middle me-1"></i> Back
                                    </a>
                                    <div class="text-end">
                                        <button type="submit" class="btn btn-primary">Update</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    $(document).ready(function() {
        // Select All functionality for each module
        $('.card-header').each(function() {
            var header = $(this);
            var checkboxes = header.next('.card-body').find('input[type="checkbox"]');

            header.css('cursor', 'pointer').on('click', function(e) {
                if ($(e.target).is('input')) return;

                var allChecked = checkboxes.length === checkboxes.filter(':checked').length;
                checkboxes.prop('checked', !allChecked);
            });
        });

        // Form validation
        $('#roleForm').on('submit', function(e) {
            var checkedPermissions = $('input[name="permissions[]"]:checked').length;
            if (checkedPermissions === 0) {
                e.preventDefault();
                Swal.fire({
                    title: 'Error!',
                    text: 'Please select at least one permission.',
                    icon: 'error',
                    confirmButtonText: 'OK'
                });
                return false;
            }
        });
    });
</script>
@endpush


