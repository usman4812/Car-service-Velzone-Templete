@extends('layouts.master')
@section('title', 'Car Manufacture')
@section('content')
    <div class="row">
        <div class="col-xxl-12">
            <div class="card">
                <div class="card-header align-items-center d-flex">
                    <h4 class="card-title mb-0 flex-grow-1">Update Car Manufacture</h4>
                </div><!-- end card header -->
                <div class="card-body">
                    <div class="live-preview">
                        <form action="{{ route('car-manufactures.update', $carManufacture) }}" method="POST"
                            enctype="multipart/form-data">
                            @method('PUT')
                            @csrf
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="name" class="form-label">Car Manufacture Name<span
                                                class="text-danger"> *</span></label>
                                        <input type="text" name="name" class="form-control"
                                            placeholder="Enter Car Manufacture Name" value="{{ $carManufacture->name }}"
                                            id="name" required>
                                    </div>
                                </div>
                                <!--end col-->
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="date" class="form-label">Date</label>
                                        <input type="date" name="date" class="form-control" placeholder=""
                                            value="{{ $carManufacture->date }}" id="date">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="ForminputState" class="form-label">Status</label>
                                        <select id="ForminputState" class="form-select" data-choices
                                            data-choices-sorting="true" name="status">
                                            <option selected>Choose...</option>
                                            <option value="active"
                                                {{ $carManufacture->status == 'active' ? 'selected' : '' }}>
                                                Active</option>
                                            <option value="inactive"
                                                {{ $carManufacture->status == 'inactive' ? 'selected' : '' }}>Inactive
                                            </option>

                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="date" class="form-label">Image</label>
                                        <input type="file" name="image" class="form-control" id="date">
                                    </div>
                                    <div>
                                        @if(empty($carManufacture->image) || $carManufacture->image == 'car-image.jpg')
                                            <img src="{{ asset('storage/carManufacture/car-image.jpg') }}" width="120" class="img-thumbnail">
                                        @else
                                            <img src="{{ asset('storage/carManufacture/' . $carManufacture->image) }}" width="120" class="img-thumbnail">
                                        @endif
                                    </div>
                                </div>
                                <!--end col-->
                                <div class="col-lg-12">
                                    <div class="d-flex justify-content-between align-items-center">
                                        <a href="{{ route('car-manufactures.index') }}" class="btn btn-danger waves-effect">
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
