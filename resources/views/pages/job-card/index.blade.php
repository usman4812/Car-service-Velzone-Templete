@extends('layouts.master')
@section('title', 'Job Cards')
@section('content')
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-header d-flex align-items-center">
                    <h5 class="card-title mb-0 flex-grow-1">Job Card List</h5>
                    <div>
                        <a href="{{ route('job-card.create') }}" class="btn btn-primary">Add Job Card</a>
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
                                <th>Sales Rep</th>
                                <th>Sub Total</th>
                                <th>Total</th>
                                <th>Date</th>
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
            $('#jobCard-table').DataTable({
                processing: true,
                serverSide: true,
                ajax: "{{ route('job-card.index') }}",
                columns: [
                    {
                        data: 'DT_RowIndex',
                        name: 'DT_RowIndex',
                        orderable: false,
                        searchable: false
                    },
                    {
                        data: 'job_card_no',
                        name: 'job_card_no'
                    },
                    {
                        data: 'name',
                        name: 'name'
                    },
                    {
                        data: 'sale_person_id',
                        name: 'sale_person_id'
                    },
                    {
                        data: 'sub_total',
                        name: 'sub_total'
                    },
                    {
                        data: 'total',
                        name: 'total'
                    },
                    {
                        data: 'date',
                        name: 'date'
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
