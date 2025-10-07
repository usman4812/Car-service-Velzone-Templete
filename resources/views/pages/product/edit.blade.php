@extends('layouts.master')
@section('title', 'Products')
@section('content')
    <div class="row">
        <div class="col-xxl-12">
            <div class="card">
                <div class="card-header align-items-center d-flex">
                    <h4 class="card-title mb-0 flex-grow-1">Add New Product</h4>
                </div><!-- end card header -->
                <div class="card-body">
                    <div class="live-preview">
                        <form action="{{ route('products.update', $product->id) }}" method="POST"
                            enctype="multipart/form-data">
                            @method('PUT')
                            @csrf
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="name" class="form-label">Product Name<span class="text-danger">
                                                *</span></label>
                                        <input type="text" name="name" class="form-control"
                                            placeholder="Enter Product Name" id="name" value="{{ $product->name }}"
                                            required>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="name" class="form-label">Price<span class="text-danger">
                                                *</span></label>
                                        <input type="integer" name="price" class="form-control"
                                            placeholder="Enter Product Price" value="{{ $product->price }}" required>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="category_id" class="form-label">Category<span
                                                class="text-danger">*</span></label>
                                        <select id="category_id" class="form-select" data-choices
                                            data-choices-sorting="true" name="category_id">
                                            <option value="">Select Category</option>
                                            @foreach ($categories as $id => $name)
                                                <option value="{{ $id }}"
                                                    {{ $product->category_id == $id ? 'selected' : '' }}>
                                                    {{ $name }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>

                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="sub_category_id" class="form-label">Sub Category<span
                                                class="text-danger">*</span></label>
                                        <select id="sub_category_id" class="form-select" name="sub_category_id" required>
                                            <option value="">Select Sub Category</option>
                                            @foreach ($subCategories as $id => $name)
                                                <option value="{{ $id }}"
                                                    {{ $product->sub_category_id == $id ? 'selected' : '' }}>
                                                    {{ $name }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="warranty" class="form-label">Warranty</label>
                                        <input type="text" name="warranty" class="form-control"
                                            placeholder="Enter Warranty" value="{{ $product->warranty }}">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="code" class="form-label">Code</label>
                                        <input type="text" name="code" class="form-control" placeholder="Enter Code"
                                            value="{{ $product->code }}">
                                    </div>
                                </div>
                                <!--end col-->
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="date" class="form-label">Date</label>
                                        <input type="date" name="date" class="form-control" placeholder=""
                                            value="{{ $product->date }}">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="ForminputState" class="form-label">Status</label>
                                        <select id="ForminputState" class="form-select" data-choices
                                            data-choices-sorting="true" name="status">
                                            <option selected>Choose...</option>
                                            <option value="active" {{ $product->status == 'active' ? 'selected' : '' }}>
                                                Active</option>
                                            <option value="inactive"
                                                {{ $product->status == 'inactive' ? 'selected' : '' }}>Inactive
                                            </option>

                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="date" class="form-label">Image</label>
                                        <input type="file" name="image" class="form-control" id="date">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <img src="{{ asset('storage/product/' . ($product->image ?? 'avatar.png')) }}"
                                            width="120" class="img-thumbnail">
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="mb-3">
                                        <label for="description" class="form-label">Description</label>
                                        <textarea type="text" name="description" class="form-control">{{ $product->description }}</textarea>
                                    </div>
                                </div>
                                <!--end col-->
                                <div class="col-lg-12">
                                    <div class="d-flex justify-content-between align-items-center">
                                        <a href="{{ route('products.index') }}" class="btn btn-danger waves-effect">
                                            <i class="ri-arrow-left-line align-middle me-1"></i> Back
                                        </a>
                                        <div class="text-end">
                                            <button type="submit" class="btn btn-primary">Update</button>
                                        </div>
                                    </div>
                                </div>
                                <!--end col-->
                            </div>
                            <!--end row-->
                        </form>
                    </div>

                </div>
            </div>
        </div> <!-- end col -->
    </div>
@endsection
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    $(document).ready(function() {
        $('#category_id').on('change', function() {
            var category_id = $(this).val();
            $('#sub_category_id').html('<option value="">Loading...</option>');

            if (category_id) {
                $.ajax({
                    url: "{{ url('/get-subcategories') }}/" + category_id,
                    type: "GET",
                    success: function(data) {
                        $('#sub_category_id').empty().append(
                            '<option value="">Select Sub Category</option>');
                        $.each(data, function(key, value) {
                            $('#sub_category_id').append('<option value="' + key +
                                '">' + value + '</option>');
                        });
                    }
                });
            } else {
                $('#sub_category_id').html('<option value="">Select Sub Category</option>');
            }
        });
    });
</script>
