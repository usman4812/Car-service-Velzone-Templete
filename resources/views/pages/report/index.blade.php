@extends('layouts.master')
@section('title', 'Product Usage Report')
@section('content')
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-header">
                    <div class="d-flex align-items-center">
                        <h5 class="card-title mb-0 flex-grow-1">Most Used Products Report</h5>
                    </div>
                </div>
                <div class="card-body">
                    <table id="report-table" class="table table-bordered dt-responsive nowrap table-striped align-middle"
                        style="width:100%">
                        <thead>
                            <tr>
                                <th>SR No.</th>
                                <th>Product Code</th>
                                <th>Product Name</th>
                                <th>Category</th>
                                <th>Sub Category</th>
                                <th>Total Quantity</th>
                                <th>Unit Price</th>
                                <th>Total Value</th>
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
                        data: 'product_code',
                        name: 'product_code',
                        searchable: true
                    },
                    {
                        data: 'product_name',
                        name: 'product_name',
                        searchable: true
                    },
                    {
                        data: 'category',
                        name: 'category',
                        searchable: true
                    },
                    {
                        data: 'sub_category',
                        name: 'sub_category',
                        searchable: true
                    },
                    {
                        data: 'total_quantity',
                        name: 'total_quantity',
                        searchable: false,
                        className: 'text-end'
                    },
                    {
                        data: 'price',
                        name: 'price',
                        searchable: false,
                        className: 'text-end'
                    },
                    {
                        data: 'total_value',
                        name: 'total_value',
                        searchable: false,
                        className: 'text-end'
                    }
                ],
                order: [[5, 'desc']], // Order by total quantity descending
                responsive: true,
                pageLength: 10,
                dom: 'Bfrtip',
                buttons: [
                    {
                        extend: 'excel',
                        text: '<i class="ri-file-excel-line"></i> Export Excel',
                        className: 'btn btn-success btn-sm',
                        exportOptions: {
                            columns: [0, 1, 2, 3, 4, 5, 6, 7]
                        }
                    },
                    {
                        extend: 'pdf',
                        text: '<i class="ri-file-pdf-line"></i> Export PDF',
                        className: 'btn btn-danger btn-sm',
                        exportOptions: {
                            columns: [0, 1, 2, 3, 4, 5, 6, 7]
                        }
                    },
                    {
                        extend: 'print',
                        text: '<i class="ri-printer-line"></i> Print',
                        className: 'btn btn-info btn-sm',
                        exportOptions: {
                            columns: [0, 1, 2, 3, 4, 5, 6, 7]
                        }
                    }
                ]
            });
        });
    </script>
@endpush

