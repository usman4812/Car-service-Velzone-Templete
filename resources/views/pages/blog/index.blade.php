@extends('layouts.master')

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-header d-flex align-items-center">
                        <h5 class="card-title mb-0 flex-grow-1">Blog List</h5>
                        <div>
                            <a id="addRow" href="{{ route('blog.create') }}" class="btn btn-primary">
                                Add Blog
                            </a>
                        </div>
                    </div>
                    <div class="card-body">
                        <table id="blog-table" class="table table-bordered dt-responsive nowrap table-striped align-middle">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Image</th>
                                    <th>Title</th>
                                    <th>Description</th>
                                    <th>Meta Keyword</th>
                                    <th>Date</th>
                                    <th>Status</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        $(document).ready(function() {
            var table = $('#blog-table').DataTable({
                processing: true,
                serverSide: true,
                ajax: "{{ route('blog.index') }}",
                columns: [{
                        data: 'id',
                        name: 'id'
                    },
                    {
                        data: 'image',
                        name: 'image',
                        orderable: false,
                        searchable: false
                    },
                    {
                        data: 'title',
                        name: 'title'
                    },
                    {
                        data: 'description',
                        name: 'description',
                        render: function(data, type, row) {
                            if (type === 'display') {
                                var text = $("<div>").html(data).text(); // Remove HTML tags
                                if (text.length > 40) {
                                    return '<span title="' + text.replace(/"/g, '&quot;') + '">' +
                                        text.substr(0, 40) + '...</span>';
                                }
                                return text;
                            }
                            return data;
                        }
                    },
                    {
                        data: 'meta_keyword',
                        name: 'meta_keyword'
                    },
                    {
                        data: 'date',
                        name: 'date'
                    },
                    {
                        data: 'status',
                        name: 'status'
                    },
                    {
                        data: 'action',
                        name: 'action',
                        orderable: false,
                        searchable: false
                    }
                ],
                order: [
                    [0, 'desc']
                ]
            });

            // Delete confirmation
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
