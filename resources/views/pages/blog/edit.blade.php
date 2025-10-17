@extends('layouts.master')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title mb-0">Edit Blog</h5>
                </div>
                <div class="card-body">
                    <form action="{{ route('blog.update', $blog->id) }}" method="POST" enctype="multipart/form-data" id="blogForm">
                        @csrf
                        @method('PUT')
                        <div class="row g-3">
                            <div class="col-lg-12">
                                <div class="form-group">
                                    <label for="title" class="form-label">Blog Title <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" id="title" name="title" value="{{ old('title', $blog->title) }}" required>
                                    @error('title')
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
                                        <textarea id="ckeditor-classic" name="description">{{ old('description', $blog->description) }}</textarea>
                                        @error('description')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label for="meta_keyword" class="form-label">Meta Keyword <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" id="meta_keyword" name="meta_keyword" value="{{ old('meta_keyword', $blog->meta_keyword) }}">
                                    @error('meta_keyword')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label for="meta_description" class="form-label">Meta Description <span class="text-danger">*</span></label>
                                    <textarea type="text" class="form-control" id="meta_description" name="meta_description">{{ old('meta_description', $blog->meta_description) }}</textarea>
                                    @error('meta_description')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label for="date" class="form-label">Date <span class="text-danger">*</span></label>
                                    <input type="date" class="form-control" id="date" name="date" value="{{ old('date', $blog->date) }}" required>
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
                                        <option value="active" {{ $blog->status == 'active' ? 'selected' : '' }}>Active</option>
                                        <option value="inactive" {{ $blog->status == 'inactive' ? 'selected' : '' }}>Inactive</option>
                                    </select>
                                </div>
                            </div>

                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label for="image" class="form-label">Image</label>
                                    <input type="file" class="form-control" id="image" name="image" accept="image/*">
                                    <small class="text-muted">Leave empty to keep the current image</small>
                                    @error('image')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label class="form-label">Current Image</label>
                                    <div class="mb-2">
                                        @if($blog->image && $blog->image != 'avatar.png')
                                            <img src="{{ asset('storage/blog/' . $blog->image) }}" alt="{{ $blog->title }}" class="rounded img-thumbnail" style="max-width: 150px;">
                                        @else
                                            <span class="badge bg-warning">No Image</span>
                                        @endif
                                    </div>
                                </div>
                            </div>

                            <div class="col-lg-12">
                                <div class="d-flex justify-content-between align-items-center">
                                    <a href="{{ route('blog.index') }}" class="btn btn-danger waves-effect">
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
    document.addEventListener("DOMContentLoaded", function() {
        // CKEditor
        ClassicEditor.create(document.querySelector('#ckeditor-classic'))
            .then(editor => {
                editor.ui.view.editable.element.style.height = '200px';
            })
            .catch(error => {
                console.error(error);
            });

        // Form submission
        document.getElementById('blogForm').addEventListener('submit', function(e) {
            e.preventDefault();
            var form = this;
            var submitBtn = form.querySelector('button[type="submit"]');
            submitBtn.disabled = true;

            fetch(form.action, {
                method: 'POST',
                body: new FormData(form),
                headers: {
                    'X-Requested-With': 'XMLHttpRequest'
                }
            })
            .then(response => response.json())
            .then(data => {
                Swal.fire({
                    title: 'Success!',
                    text: 'Blog updated successfully',
                    icon: 'success',
                    customClass: {
                        confirmButton: 'btn btn-primary w-xs mt-2'
                    },
                    buttonsStyling: false,
                    showCloseButton: true
                }).then(function(result) {
                    window.location.href = "{{ route('blog.index') }}";
                });
            })
            .catch(error => {
                Swal.fire({
                    title: 'Error!',
                    text: 'Something went wrong',
                    icon: 'error',
                    customClass: {
                        confirmButton: 'btn btn-primary w-xs mt-2'
                    },
                    buttonsStyling: false,
                    showCloseButton: true
                });
                submitBtn.disabled = false;
            });
        });
    });
</script>
@endpush
