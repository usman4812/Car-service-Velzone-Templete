@extends('layouts.master')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title mb-0">Edit Service</h5>
                </div>
                <div class="card-body">
                    <form action="{{ route('services.update', $service->id) }}" method="POST" enctype="multipart/form-data" id="serviceForm">
                        @csrf
                        @method('PUT')
                        <div class="row g-3">
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label for="name" class="form-label">Service Name <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" id="name" name="name" value="{{ old('name', $service->name) }}" required>
                                    @error('name')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label for="link" class="form-label">Link</label>
                                    <input type="text" class="form-control" id="link" name="link" value="{{ old('link', $service->link) }}">
                                    @error('link')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label for="date" class="form-label">Date <span class="text-danger">*</span></label>
                                    <input type="date" class="form-control" id="date" name="date" value="{{ old('date', $service->date) }}" required>
                                    @error('date')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="ForminputState" class="form-label">Status</label>
                                    <select id="ForminputState" class="form-select" data-choices
                                        data-choices-sorting="true" name="status">
                                        <option selected>Choose...</option>
                                        <option value="active"
                                            {{ $service->status == 'active' ? 'selected' : '' }}>
                                            Active</option>
                                        <option value="inactive"
                                            {{ $service->status == 'inactive' ? 'selected' : '' }}>Inactive
                                        </option>

                                    </select>
                                </div>
                            </div>

                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label for="image" class="form-label">Image</label>
                                    @if($service->image && $service->image != 'avatar.png')
                                        <div class="mb-2">
                                            <img src="{{ asset('storage/service/' . $service->image) }}" alt="{{ $service->name }}" class="rounded avatar-lg">
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
                                    <a href="{{ route('services.index') }}" class="btn btn-danger waves-effect">
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
        $('#serviceForm').on('submit', function(e) {
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
                        text: 'Service updated successfully',
                        icon: 'success',
                        customClass: {
                            confirmButton: 'btn btn-primary w-xs mt-2'
                        },
                        buttonsStyling: false,
                        showCloseButton: true
                    }).then(function(result) {
                        window.location.href = "{{ route('services.index') }}";
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
