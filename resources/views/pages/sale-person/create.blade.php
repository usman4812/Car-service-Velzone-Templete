@extends('layouts.master')
@section('title', 'Sale Person')
@section('content')
    <div class="row">
        <div class="col-xxl-12">
            <div class="card">
                <div class="card-header align-items-center d-flex">
                    <h4 class="card-title mb-0 flex-grow-1">Add New Sales Person</h4>
                </div><!-- end card header -->
                <div class="card-body">
                    <div class="live-preview">
                        <form action="{{route('sales-persons.store')}}" method="POST">
                            @csrf
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="name" class="form-label">Full Name<span class="text-danger"> *</span></label>
                                        <input type="text" name="name" class="form-control" placeholder="Enter your Full Name"
                                            id="name" required>
                                    </div>
                                </div>
                                <!--end col-->
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="email" class="form-label">Email Address<span class="text-danger"> *</span></label>
                                        <input type="email" name="email" class="form-control" placeholder="example@gamil.com"
                                            id="email" required>
                                    </div>
                                </div>
                                <!--end col-->
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="phonenumberInput" class="form-label">Phone Number<span class="text-danger"> *</span></label>
                                        <input type="tel" name="phone" class="form-control" placeholder="+(880) 451 45123"
                                            id="phonenumberInput" required>
                                    </div>
                                </div>
                                <!--end col-->

                                <!--end col-->
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="salary" class="form-label">Salary<span class="text-danger"> *</span></label>
                                        <input type="number" name="salary" class="form-control" placeholder="Enter Salary"
                                            id="salary" required>
                                    </div>
                                </div>
                                <!--end col-->
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="citynameInput" class="form-label">Joining Date<span class="text-danger"> *</span></label>
                                        <input type="date"  name="joining_date" class="form-control" placeholder="Enter Joining Date"
                                            id="citynameInput" required>
                                    </div>
                                </div>
                                <!--end col-->
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="ForminputState" class="form-label">Status</label>
                                        <select id="ForminputState" name="status" class="form-select" data-choices
                                            data-choices-sorting="true">
                                            <option selected>Choose...</option>
                                            <option value="active" selected>Active</option>
                                            <option value="inactive">In Active</option>
                                        </select>
                                    </div>
                                </div>
                                 <div class="col-md-12">
                                    <div class="mb-3">
                                        <label for="address" class="form-label">Address</label>
                                        <textarea type="text" name="address" class="form-control" placeholder="Address"
                                            id="address"></textarea>
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
