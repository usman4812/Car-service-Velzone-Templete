@extends('layouts.master')
@section('title', 'Contact')
@section('content')
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-header">
                    <div class="d-flex align-items-center">
                        <h5 class="card-title mb-0 flex-grow-1">Contact</h5>
                    </div>
                </div>
                <div class="card-body">
                    <table id="jobCard-table" class="table table-bordered dt-responsive nowrap table-striped align-middle"
                        style="width:100%">
                        <thead>
                            <tr>
                                <th>SR No.</th>
                                <th>InVoice No.</th>
                                <th>Customer Name</th>
                                <th>Email</th>
                                <th>Phone</th>
                                <th>Car Model</th>
                                <th>Car Plate No</th>
                                <th>Date</th>
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
            var table = $('#jobCard-table').DataTable({
                processing: true,
                serverSide: true,
                ajax: "{{ route('contacts.index') }}",
                columns: [
                    {
                        data: 'DT_RowIndex',
                        name: 'DT_RowIndex',
                        orderable: false,
                        searchable: false
                    },
                    {
                        data: 'job_card_no',
                        name: 'job_card_no',
                        searchable: true
                    },
                    {
                        data: 'name',
                        name: 'customer.name',
                        searchable: true
                    },
                    {
                        data: 'email',
                        name: 'customer.email',
                        searchable: true
                    },
                    {
                        data: 'phone',
                        name: 'customer.phone',
                        searchable: true
                    },
                    {
                        data: 'car_model',
                        name: 'customer.car_model',
                        searchable: true
                    },
                    {
                        data: 'car_plat_no',
                        name: 'customer.car_plat_no',
                        searchable: true
                    },
                    {
                        data: 'date',
                        name: 'date',
                        searchable: false
                    }
                ],
                order: [],
                responsive: true,
                pageLength: 10
            });

            // Sales Person Filter Change
            $('#sale_person_filter').on('change', function() {
                table.draw();
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
