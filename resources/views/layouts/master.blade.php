<!doctype html>
<html lang="en" data-layout="vertical" data-topbar="light" data-sidebar="dark" data-sidebar-size="lg"
    data-sidebar-image="none" data-preloader="disable" data-theme="default" data-theme-colors="default">

<head>
    <meta charset="utf-8" />
    <title>Dashboard | Car Service Management</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta content="Car Service Management System" name="description" />
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <!-- App favicon -->
    <link rel="shortcut icon" href="{{ asset('assets/images/favicon.ico') }}">

    <!-- Bootstrap CSS -->
    <link href="{{ asset('assets/css/bootstrap.min.css') }}" rel="stylesheet" type="text/css" />

    <!-- Layout config CSS -->
    <link href="{{ asset('assets/css/layout.min.css') }}" rel="stylesheet" type="text/css" />

    <!-- App CSS -->
    <link href="{{ asset('assets/css/app.min.css') }}" rel="stylesheet" type="text/css" />

    <!-- Icons CSS -->
    <link href="{{ asset('assets/css/icons.min.css') }}" rel="stylesheet" type="text/css" />

    <!-- Sweet Alert CSS -->
    <link href="{{ asset('assets/libs/sweetalert2/sweetalert2.min.css') }}" rel="stylesheet" type="text/css" />

    <!-- Custom CSS -->
    <style>
        .app-menu {
            position: fixed;
            top: 0;
            bottom: 0;
            left: 0;
            width: 250px;
            min-height: 100vh;
            padding-bottom: 75px;
            z-index: 1002;
            background: var(--vz-vertical-menu-bg);
            border-right: 1px solid var(--vz-vertical-menu-border);
            transition: all .1s ease-out;
        }

        .navbar-menu {
            width: 250px;
            height: 100vh;
            overflow-y: auto;
        }

        .main-content {
            margin-left: 250px;
            overflow: hidden;
        }

        .page-content {
            padding: calc(70px + 1.5rem) calc(1.5rem * .5) 60px calc(1.5rem * .5);
        }
    </style>

    <!-- DataTables CSS -->
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.4/css/dataTables.bootstrap5.min.css">
</head>

<body>
    <!-- Begin page -->
    <div id="layout-wrapper">
        {{-- Topbar --}}
        @include('partials.topbar')

        <!-- Left Sidebar -->
        <div class="app-menu navbar-menu">
            @include('partials.sidebar')
        </div>
        <!-- Left Sidebar End -->

        <!-- Vertical Overlay-->
        <div class="vertical-overlay"></div>

        <!-- Start main content -->
        <div class="main-content">
            <div class="page-content">
                {{-- Flash Messages --}}
                @if (session('success'))
                    <div class="alert alert-success material-shadow" role="alert">
                        <strong>Yey! Everything worked! </strong> {{ session('success') }}
                    </div>
                @endif

                @if (session('error'))
                    <div class="alert alert-danger material-shadow" role="alert">
                        <strong>Oops! Something went wrong. </strong> {{ session('error') }}
                    </div>
                @endif

                @yield('content')
            </div>
            <!-- End Page-content -->

            {{-- Footer --}}
            @include('partials.footer')
        </div>
        <!-- end main content-->
    </div>
    <!-- END layout-wrapper -->

    <!--start back-to-top-->
    <button onclick="topFunction()" class="btn btn-danger btn-icon" id="back-to-top">
        <i class="ri-arrow-up-line"></i>
    </button>
    <!--end back-to-top-->

    <!--preloader-->
    <div id="preloader">
        <div id="status">
            <div class="spinner-border text-primary avatar-sm" role="status">
                <span class="visually-hidden">Loading...</span>
            </div>
        </div>
    </div>

    <!-- JAVASCRIPT -->
    <!-- jQuery first -->
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>

    <!-- Bootstrap Bundle with Popper -->
    <script src="{{ asset('assets/libs/bootstrap/js/bootstrap.bundle.min.js') }}"></script>

    <!-- DataTables -->
    <script src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.4/js/dataTables.bootstrap5.min.js"></script>

    <!-- Sweet Alert -->
    <script src="{{ asset('assets/libs/sweetalert2/sweetalert2.min.js') }}"></script>
<!-- ckeditor -->
<script src="{{ asset('assets/libs/%40ckeditor/ckeditor5-build-classic/build/ckeditor.js') }}"></script>

<!-- quill js -->
<script src="{{ asset('assets/libs/quill/quill.min.js') }}"></script>
    <!-- App js -->
    <script src="{{ asset('assets/js/app.js') }}"></script>

    @stack('scripts')

    <script>
        // Auto close after 3 sec
        setTimeout(function() {
            let alert = document.querySelector('.alert');
            if (alert) {
                alert.style.display = 'none';
            }
        }, 3000);
    </script>

    <!-- Add New Customer Modal -->
    <div class="modal fade" id="addCustomerModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Add New Customer</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form id="newCustomerForm" method="POST">
                    @csrf
                    <div class="modal-body">
                        <div class="mb-3">
                            <label class="form-label">Customer Name<span class="text-danger">*</span></label>
                            <input type="text" class="form-control" id="newCustomerName" name="name" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Email</label>
                            <input type="email" class="form-control" id="newCustomerEmail" name="email">
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Phone<span class="text-danger">*</span></label>
                            <input type="text" class="form-control" id="newCustomerPhone" name="phone" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Car Model</label>
                            <input type="text" class="form-control" id="newCustomerCarModel" name="car_model">
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Car Plate No</label>
                            <input type="text" class="form-control" id="newCustomerCarPlate" name="car_plat_no">
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Address</label>
                            <textarea class="form-control" id="newCustomerAddress" name="address" rows="2"></textarea>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Date<span class="text-danger">*</span></label>
                            <input type="date" class="form-control" id="newCustomerDate" name="date" value="{{ date('Y-m-d') }}" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Status</label>
                            <select class="form-select" id="newCustomerStatus" name="status">
                                <option value="active" selected>Active</option>
                                <option value="inactive">Inactive</option>
                            </select>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-light" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Save Customer</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</body>
</html>
