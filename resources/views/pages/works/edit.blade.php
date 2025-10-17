@extends('layouts.master')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title mb-0">Edit Work</h5>
                </div>
                <div class="card-body">
                    <form action="{{ route('works.update', $work->id) }}" method="POST" enctype="multipart/form-data" id="workForm">
                        @csrf
                        @method('PUT')
                        <div class="row g-3">
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label for="title" class="form-label">Title <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" id="title" name="title" value="{{ old('title', $work->title) }}" required>
                                    @error('title')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="type" class="form-label">Type <span class="text-danger">*</span></label>
                                    <select id="type" class="form-select" data-choices data-choices-sorting="true" name="type">
                                        <option selected>Choose...</option>
                                        <option value="PPF (PAINT PROTECTION FILM)" {{ $work->type == 'PPF (PAINT PROTECTION FILM)' ? 'selected' : '' }}>PPF (PAINT PROTECTION FILM)</option>
                                        <option value="WINDOW TINTING" {{ $work->type == 'WINDOW TINTING' ? 'selected' : '' }}>WINDOW TINTING</option>
                                        <option value="CAR WRAPPING" {{ $work->type == 'CAR WRAPPING' ? 'selected' : '' }}>CAR WRAPPING</option>
                                        <option value="CERAMIC COATING" {{ $work->type == 'CERAMIC COATING' ? 'selected' : '' }}>CERAMIC COATING</option>
                                        <option value="LEATHER COATING" {{ $work->type == 'LEATHER COATING' ? 'selected' : '' }}>LEATHER COATING</option>
                                        <option value="RESIDENTIAL TINTING" {{ $work->type == 'RESIDENTIAL TINTING' ? 'selected' : '' }}>RESIDENTIAL TINTING</option>
                                        <option value="COMMERCIAL TINTING" {{ $work->type == 'COMMERCIAL TINTING' ? 'selected' : '' }}>COMMERCIAL TINTING</option>
                                    </select>
                                    @error('type')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label for="date" class="form-label">Date <span class="text-danger">*</span></label>
                                    <input type="date" class="form-control" id="date" name="date" value="{{ old('date', $work->date) }}" required>
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
                                        <option value="active" {{ $work->status == 'active' ? 'selected' : '' }}>Active</option>
                                        <option value="inactive" {{ $work->status == 'inactive' ? 'selected' : '' }}>Inactive</option>
                                    </select>
                                </div>
                            </div>

                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label for="image" class="form-label">Image</label>
                                    @if($work->image && $work->image != 'avatar.png')
                                        <div class="mb-3">
                                            <img src="{{ asset('storage/work/' . $work->image) }}" alt="{{ $work->title }}" class="img-thumbnail" style="max-width: 120px;">
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
                                <div class="card">
                                    <div class="card-header">
                                        <h4 class="card-title mb-0">Description</h4>
                                    </div>
                                    <div class="card-body">
                                        <textarea class="form-control" id="description" name="description">{{ old('description', $work->description) }}</textarea>
                                    </div>
                                </div>
                            </div>

                            <div class="col-lg-12">
                                <div class="d-flex justify-content-between align-items-center">
                                    <a href="{{ route('works.index') }}" class="btn btn-danger waves-effect">
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
<!-- TinyMCE -->
<script src="{{ asset('assets/libs/tinymce/tinymce.min.js') }}"></script>

<script>
    $(document).ready(function() {
        // TinyMCE
        tinymce.init({
            selector: 'textarea#description',
            height: 300,
            plugins: [
                'advlist', 'autolink', 'lists', 'link', 'image', 'charmap', 'preview',
                'anchor', 'searchreplace', 'visualblocks', 'code', 'fullscreen',
                'insertdatetime', 'media', 'table', 'help', 'wordcount'
            ],
            toolbar: 'undo redo | blocks | ' +
                'bold italic backcolor | alignleft aligncenter ' +
                'alignright alignjustify | bullist numlist outdent indent | ' +
                'removeformat | help',
            content_style: 'body { font-family:Helvetica,Arial,sans-serif; font-size:16px }'
        });

        $('#workForm').on('submit', function(e) {
            e.preventDefault();
            var form = $(this);
            var submitBtn = form.find('button[type="submit"]');
            submitBtn.prop('disabled', true);

            // Get TinyMCE content
            var description = tinymce.get('description').getContent();

            var formData = new FormData(this);
            formData.append('description', description);

            $.ajax({
                url: form.attr('action'),
                method: 'POST',
                data: formData,
                processData: false,
                contentType: false,
                success: function(response) {
                    Swal.fire({
                        title: 'Success!',
                        text: 'Work updated successfully',
                        icon: 'success',
                        customClass: {
                            confirmButton: 'btn btn-primary w-xs mt-2'
                        },
                        buttonsStyling: false,
                        showCloseButton: true
                    }).then(function(result) {
                        window.location.href = "{{ route('works.index') }}";
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
