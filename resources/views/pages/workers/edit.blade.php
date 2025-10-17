@extends('layouts.master')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title mb-0">Edit Worker</h5>
                </div>
                <div class="card-body">
                    <form action="{{ route('workers.update', $worker->id) }}" method="POST" enctype="multipart/form-data" id="workerForm">
                        @csrf
                        @method('PUT')
                        <div class="row g-3">
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label for="name" class="form-label">Worker Name <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" id="name" name="name" value="{{ old('name', $worker->name) }}" required>
                                    @error('name')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label for="designation" class="form-label">Designation <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" id="designation" name="designation" value="{{ old('designation', $worker->designation) }}" required>
                                    @error('designation')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label for="date" class="form-label">Date <span class="text-danger">*</span></label>
                                    <input type="date" class="form-control" id="date" name="date" value="{{ old('date', $worker->date) }}" required>
                                    @error('date')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="ForminputState" class="form-label">Status</label>
                                    <select id="ForminputState" class="form-select" data-choices data-choices-sorting="true" name="status">
                                        <option selected>Choose...</option>
                                        <option value="active" {{ $worker->status == 'active' ? 'selected' : '' }}>Active</option>
                                        <option value="inactive" {{ $worker->status == 'inactive' ? 'selected' : '' }}>Inactive</option>
                                    </select>
                                </div>
                            </div>

                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label for="image" class="form-label">Image</label>
                                    @if($worker->image && $worker->image != 'avatar.png')
                                        <div class="mb-3">
                                            <img src="{{ asset('storage/worker/' . $worker->image) }}" alt="{{ $worker->name }}" class="img-thumbnail" style="max-width: 120px;">
                                        </div>
                                    @endif
                                    <input type="file" class="form-control" id="image" name="image" accept="image/*">
                                    <small class="text-muted">Leave empty to keep the current image</small>
                                    @error('image')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-lg-12">
                                <div class="d-flex justify-content-between align-items-center">
                                    <a href="{{ route('workers.index') }}" class="btn btn-danger waves-effect">
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
        $('#workerForm').on('submit', function(e) {
            e.preventDefault();
            var form = $(this);
            var submitBtn = form.find('button[type="submit"]');
            submitBtn.prop('disabled', true);

            $.ajax({
                url: form.attr('action'),
                method: 'POST',
                data: new FormData(this),
                processData: false,
                contentType: false,
                success: function(response) {
                    Swal.fire({
                        title: 'Success!',
                        text: 'Worker updated successfully',
                        icon: 'success',
                        customClass: {
                            confirmButton: 'btn btn-primary w-xs mt-2'
                        },
                        buttonsStyling: false,
                        showCloseButton: true
                    }).then(function(result) {
                        window.location.href = "{{ route('workers.index') }}";
                    });
                },
                error: function(xhr) {
                    var errors = xhr.responseJSON.errors;
                    var errorMessage = '';
                    $.each(errors, function(key, value) {
                        errorMessage += value[0] + '<br>';
                    });

                    Swal.fire({
                        title: 'Error!',
                        html: errorMessage,
                        icon: 'error',
                        customClass: {
                            confirmButton: 'btn btn-primary w-xs mt-2'
                        },
                        buttonsStyling: false,
                        showCloseButton: true
                    });
                    submitBtn.prop('disabled', false);
                }
            });
        });
    });
</script>
@endpush
