@extends('layouts.master')
@section('title', 'Daily Earnings Report')
@section('content')
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-header">
                    <div class="d-flex align-items-center">
                        <h5 class="card-title mb-0 flex-grow-1">
                            <i class="ri-calendar-line me-2"></i>Daily Earnings Report
                        </h5>
                    </div>
                </div>
                <div class="card-body">
                    <table id="report-table" class="table table-bordered dt-responsive nowrap table-striped align-middle"
                        style="width:100%">
                        <thead>
                            <tr>
                                <th>SR No.</th>
                                <th>Date</th>
                                <th>Total Job Cards</th>
                                <th>Total Earnings</th>
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
            var table = $('#report-table').DataTable({
                processing: true,
                serverSide: true,
                ajax: "{{ route('reports.index') }}",
                columns: [
                    {
                        data: 'DT_RowIndex',
                        name: 'DT_RowIndex',
                        orderable: false,
                        searchable: false
                    },
                    {
                        data: 'date',
                        name: 'date',
                        searchable: true
                    },
                    {
                        data: 'total_job_cards',
                        name: 'total_job_cards',
                        searchable: false,
                        className: 'text-center'
                    },
                    {
                        data: 'total_earnings',
                        name: 'total_earnings',
                        searchable: false,
                        className: 'text-end'
                    },
                    {
                        data: 'action',
                        name: 'action',
                        orderable: false,
                        searchable: false,
                        className: 'text-center'
                    }
                ],
                order: [[1, 'desc']], // Order by date descending
                responsive: true,
                pageLength: 10,
                dom: 'Bfrtip',
                buttons: [
                    {
                        extend: 'excel',
                        text: '<i class="ri-file-excel-line"></i> Export Excel',
                        className: 'btn btn-success btn-sm',
                        exportOptions: {
                            columns: [0, 1, 2, 3]
                        }
                    },
                    {
                        extend: 'pdf',
                        text: '<i class="ri-file-pdf-line"></i> Export PDF',
                        className: 'btn btn-danger btn-sm',
                        exportOptions: {
                            columns: [0, 1, 2, 3]
                        }
                    },
                    {
                        extend: 'print',
                        text: '<i class="ri-printer-line"></i> Print',
                        className: 'btn btn-info btn-sm',
                        exportOptions: {
                            columns: [0, 1, 2, 3]
                        }
                    }
                ]
            });
        });
    </script>
@endpush

