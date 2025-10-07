@extends('layouts.master')
@section('title', 'Customers')
@section('content')
    <div class="row">
        <div class="col-xxl-12">
            <div class="card">
                <div class="card-header align-items-center d-flex">
                    <h4 class="card-title mb-0 flex-grow-1">Add New Customer</h4>
                </div><!-- end card header -->
                <div class="card-body">
                    <div class="live-preview">
                        <form action="{{ route('customers.store') }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="name" class="form-label">Full Name<span class="text-danger">
                                                *</span></label>
                                        <input type="text" name="name" class="form-control"
                                            placeholder="Enter Full Name" id="name" required>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="name" class="form-label">Email<span class="text-danger">
                                                *</span></label>
                                        <input type="email" name="email" class="form-control"
                                            placeholder="Enter Customer Email">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="phone" class="form-label">Phone</label>
                                        <input type="text" name="phone" class="form-control" placeholder="Enter Phone" required>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="car_model" class="form-label">Car Model</label>
                                        <input type="text" name="car_model" class="form-control"
                                            placeholder="Enter Car Model">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="car_plat_no" class="form-label">Car Plate No</label>
                                        <input type="text" name="car_plat_no" class="form-control"
                                            placeholder="Enter Car Plate  No ">
                                    </div>
                                </div>

                                <!--end col-->
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="date" class="form-label">Date</label>
                                        <input type="date" name="date" class="form-control" placeholder="Address"
                                            id="date">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="ForminputState" class="form-label">Status</label>
                                        <select id="ForminputState" class="form-select" data-choices
                                            data-choices-sorting="true" name="status">
                                            <option selected>Choose...</option>
                                            <option value="active" selected>Active</option>
                                            <option value="inactive">In Active</option>

                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="mb-3">
                                        <label for="address" class="form-label">Address</label>
                                        <textarea type="text" name="address" class="form-control"></textarea>
                                    </div>
                                </div>
                                <!--end col-->
                                <div class="col-lg-12">
                                    <div class="text-end">
                                        <button type="submit" class="btn btn-primary">Submit</button>
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
