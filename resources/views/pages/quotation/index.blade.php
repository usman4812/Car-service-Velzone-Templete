@extends('layouts.master')
@section('title', 'Quotations')
@section('content')
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-header">
                    <div class="d-flex align-items-center">
                        <h5 class="card-title mb-0 flex-grow-1">Quotation List</h5>
                        <div>
                            <a href="{{ route('making-quotation.create') }}" class="btn btn-primary">Add Quotation</a>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <table id="quotation-table" class="table table-bordered dt-responsive nowrap table-striped align-middle"
                        style="width:100%">
                        <thead>
                            <tr>
                                <th>SR No.</th>
                                <th>Quotation No.</th>
                                <th>Customer Name</th>
                                <th>Phone</th>
                                <th>Car Model</th>
                                <th>Car Plate No</th>
                                <th>Chassis No</th>
                                <th>Sub Total</th>
                                <th>Total Payable</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection
@push('scripts')
    <script>
        $(document).ready(function() {
            var table = $('#quotation-table').DataTable({
                processing: true,
                serverSide: true,
                ajax: "{{ route('making-quotation.index') }}",
                columns: [
                    {
                        data: 'DT_RowIndex',
                        name: 'DT_RowIndex',
                        orderable: false,
                        searchable: false
                    },
                    {
                        data: 'quotation_no',
                        name: 'quotation_no',
                        searchable: true
                    },
                    {
                        data: 'customer_name',
                        name: 'customer_name',
                        searchable: true
                    },
                    {
                        data: 'customer_phone',
                        name: 'customer_phone',
                        searchable: true
                    },
                    {
                        data: 'car_model',
                        name: 'car_model',
                        searchable: true
                    },
                    {
                        data: 'car_plat_no',
                        name: 'car_plat_no',
                        searchable: true
                    },
                    {
                        data: 'chassis_no',
                        name: 'chassis_no',
                        searchable: false
                    },
                    {
                        data: 'sub_total',
                        name: 'sub_total',
                        searchable: false
                    },
                    {
                        data: 'total_payable',
                        name: 'total_payable',
                        searchable: false
                    },
                    {
                        data: 'action',
                        name: 'action',
                        orderable: false,
                        searchable: false
                    }
                ],
                order: [],
                responsive: true,
                pageLength: 10
            });
                        
            // SweetAlert Delete Confirmation
            $(document).on('click', '.show-confirm', function(e) {
                e.preventDefault();
                let form = $(this).closest('form');
                Swal.fire({
                    title: 'Are you sure?',
                    text: "This action cannot be undone!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Yes, delete it!'
                }).then((result) => {
                    if (result.isConfirmed) {
                        form.submit();
                    }
                });
            });
        });
    </script>
@endpush
