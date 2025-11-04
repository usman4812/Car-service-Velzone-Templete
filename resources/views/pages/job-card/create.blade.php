@extends('layouts.master')
@section('title', 'Job Card')
@section('head')
    <meta name="csrf-token" content="{{ csrf_token() }}">
@endsection
@section('content')
    <div class="row">
        <div class="col-xxl-12">
            <div class="card">
                <div class="card-header align-items-center d-flex">
                    <h4 class="card-title mb-0 flex-grow-1">Add Job Card</h4>
                </div><!-- end card header -->
                <div class="card-body">
                    <div class="live-preview">
                        <form action="{{ route('job-card.store') }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <input type="hidden" name="_token" value="{{ csrf_token() }}" />
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="mb-3">
                                        <label for="job_card_no" class="form-label">Job Card No<span class="text-danger">
                                                *</span></label>
                                        <input type="text" name="job_card_no" class="form-control"
                                            value="{{ $jobCardNo ?? '' }}" readonly>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="mb-3">
                                        <label for="date" class="form-label">Date<span class="text-danger">
                                                *</span></label>
                                        <input type="date" name="date" class="form-control" value="{{ date('Y-m-d') }}" required>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="mb-3">
                                        <label for="customer_id" class="form-label">Customer Name<span class="text-danger">
                                                *</span></label>
                                        <div class="d-flex gap-2">
                                            <select id="customer_id" class="form-select" data-choices
                                                data-choices-sorting="true" name="customer_id" required>
                                                <option value="">Select Customer</option>
                                                @foreach ($customers as $id => $customer)
                                                    <option value="{{ $id }}" data-name="{{ $customer }}">{{ $customer }}</option>
                                                @endforeach
                                            </select>
                                            <button type="button" class="btn btn-soft-primary" id="addNewCustomerBtn">
                                                <i class="ri-add-line align-middle"></i>
                                            </button>
                                        </div>

                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="mb-3">
                                        <label for="email" class="form-label">Email</label>
                                        <input type="email" name="email" class="form-control" id="email"
                                            placeholder="Enter Email Address">
                                    </div>
                                </div>
                                <!--end col-->
                                <div class="col-md-4">
                                    <div class="mb-3">
                                        <label for="phone" class="form-label">Mobile Phone</label>
                                        <input type="text" name="phone" class="form-control"
                                            placeholder="Enter Mobile Phone" id="phone">
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="mb-3">
                                        <label for="car_model" class="form-label">Car Model</label>
                                        <input type="text" name="car_model" class="form-control"
                                            placeholder="Enter Car Model" id="car_model">
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="mb-3">
                                        <label for="car_plat_no" class="form-label">Car Plate No</label>
                                        <input type="text" name="car_plat_no" class="form-control"
                                            placeholder="Enter Car Plate No" id="car_plat_no">
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="mb-3">
                                        <label for="chassis_no" class="form-label">Chassis No</label>
                                        <input type="text" name="chassis_no" class="form-control"
                                            placeholder="Enter Chassis No" id="chassis_no">
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="mb-3">
                                        <label for="category_id" class="form-label">Car Manufacture</label>
                                        <select id="car_manufacture_id" class="form-select" data-choices
                                            data-choices-sorting="true" name="car_manufacture_id">
                                            <option value="">Select Car Manufacture</option>
                                            @foreach ($carMenus as $id => $carMenu)
                                                <option value="{{ $id }}">{{ $carMenu }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="mb-3">
                                        <label for="manu_year" class="form-label">Manufacturing Year</label>
                                        <select id="manu_year" class="form-select" data-choices data-choices-sorting="true"
                                            name="manu_year">
                                            <option value="">Select Manufacturing Year</option>
                                            @for ($year = date('Y'); $year >= 2010; $year--)
                                                <option value="{{ $year }}">{{ $year }}</option>
                                            @endfor
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="mb-3">
                                        <label for="sale_person_id" class="form-label">Sales Person</label>
                                        <select id="sale_person_id" class="form-select" data-choices
                                            data-choices-sorting="true" name="sale_person_id">
                                            <option value="">Select Sales Person</option>
                                            @foreach ($salePersons as $id => $salePerson)
                                                <option value="{{ $id }}">{{ $salePerson }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="mb-3">
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="checkbox" id="inlineCheckbox1"
                                                name="full_car" value="1">
                                            <label class="form-check-label" for="inlineCheckbox1">Full Car</label>
                                        </div>
                                        <div class="form-check form-check-inline">
                                            <label for="category_id" class="form-label">Full Car Price</label>
                                            <input type="number" name="full_car_price" class="form-control"
                                                placeholder="Enter Full Car Price" id="full_car_price">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-8">
                                    <div class="mb-3">
                                        <label for="remarks" class="form-label">Remarks</label>
                                        <textarea type="text" name="remarks" class="form-control"></textarea>
                                    </div>
                                </div>
                                <div class="col-md-4 mt-5">
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="checkbox" id="inlineCheckbox2"
                                            name="promo" value="1">
                                        <label class="form-check-label" for="inlineCheckbox2">Promo</label>
                                    </div>
                                </div>


                                <div class="card">
                                    <div class="card-header align-items-center d-flex">
                                        <h4 class="card-title mb-0 flex-grow-1">Items</h4>
                                    </div>

                                    <div class="card-body">
                                        <!-- Header Row -->
                                        <div class="row fw-semibold text-muted mb-2 border-bottom pb-2">
                                            <div class="col-md-6">Item Details</div>
                                            <div class="col-md-1 text-center">QTY</div>
                                            <div class="col-md-1 text-center">Price</div>
                                            <div class="col-md-1 text-center">Total</div>
                                            <div class="col-md-3 text-center">Action</div>
                                        </div>

                                        <div id="itemRows">
                                            <div class="row align-items-center mb-3 item-row border-bottom pb-3">
                                                <!-- Item Section (Category, Subcategory, Product) -->
                                                <div class="col-md-6">
                                                    <div class="row g-2">
                                                        <div class="col-md-4">
                                                            <select class="form-select category_id" data-choices
                                                                data-choices-sorting="true" name="category_id[]">
                                                                <option value="">Select Category</option>
                                                                @foreach ($categories as $id => $name)
                                                                    <option value="{{ $id }}">{{ $name }}
                                                                    </option>
                                                                @endforeach
                                                            </select>
                                                        </div>
                                                        <div class="col-md-4">
                                                            <select class="form-select sub_category_id"
                                                                name="sub_category_id[]">
                                                                <option value="">Select Sub Category</option>
                                                            </select>
                                                        </div>
                                                        <div class="col-md-4">
                                                            <select class="form-select product_id" data-choices
                                                                name="product_id[]">
                                                                <option value="">Select Product</option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                </div>

                                                <!-- Qty -->
                                                <div class="col-md-1">
                                                    <input type="number" name="qty[]"
                                                        class="form-control text-center qty" placeholder="0">
                                                </div>

                                                <!-- Price -->
                                                <div class="col-md-1">
                                                    <input type="text" name="price[]"
                                                        class="form-control text-center price" placeholder="0.00"
                                                        id="price" readonly>
                                                </div>

                                                <!-- Total -->
                                                <div class="col-md-1">
                                                    <input type="text" name="total[]"
                                                        class="form-control text-center total" placeholder="0.00"
                                                        id="total" readonly>
                                                </div>

                                                <!-- Action Buttons -->
                                                <div class="col-md-3 text-center">
                                                    <button type="button"
                                                        class="btn btn-success btn-sm addRow me-1 mt-1">
                                                        <i class="ri-add-line align-middle"></i> Add
                                                    </button>
                                                    <button type="button" class="btn btn-danger btn-sm removeRow mt-1">
                                                        <i class="ri-delete-bin-line align-middle"></i> Delete
                                                    </button>
                                                </div>

                                                <!-- Description Row -->
                                                <div class="col-md-8 mt-2">
                                                    <input type="text" name="description[]" class="form-control"
                                                        placeholder="Description">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row mt-4">
                                    <div class="col-md-6"></div> <!-- Empty space for alignment -->
                                    <div class="col-md-6">
                                        <div class="table-responsive">
                                            <table class="table table-borderless align-middle">
                                                <tr>
                                                    <th>Subtotal (Amount)</th>
                                                    <td class="text-end">AED</td>
                                                    <td><input type="text" id="amount" name="amount"
                                                            class="form-control text-end" value="0.00" readonly></td>
                                                </tr>

                                                <tr>
                                                    <th>Net Amount</th>
                                                    <td class="text-end">AED</td>
                                                    <td><input type="number" id="net_amount" name="net_amount" step="0.01"
                                                            class="form-control text-end" value="0.00" min="0"></td>
                                                </tr>

                                                <tr>
                                                    <th>Discount Amount</th>
                                                    <td class="text-end">AED</td>
                                                    <td><input type="text" id="discount_amount" name="discount_amount"
                                                            class="form-control text-end" value="0.00" readonly></td>
                                                </tr>

                                                <tr>
                                                    <th>Discount %</th>
                                                    <td class="text-end">%</td>
                                                    <td><input type="number" id="discount_percent" step="0.01"
                                                            name="discount_percent" class="form-control text-end"
                                                            value="0" min="0" max="100"></td>
                                                </tr>

                                                <tr>
                                                    <th>VAT (5%)</th>
                                                    <td class="text-end">AED</td>
                                                    <td><input type="text" id="vat_amount" name="vat_amount"
                                                            class="form-control text-end" value="5" readonly></td>
                                                </tr>

                                                <tr class="border-top">
                                                    <th>Total Payable</th>
                                                    <td class="text-end">AED</td>
                                                    <td><input type="text" id="total_payable" name="total_payable"
                                                            class="form-control text-end fw-semibold" value="0.00"
                                                            readonly></td>
                                                </tr>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                                <!--end col-->
                                <div class="col-lg-12">
                                    <div class="d-flex justify-content-between align-items-center">
                                        <a href="{{ route('job-card.index') }}" class="btn btn-danger waves-effect">
                                            <i class="ri-arrow-left-line align-middle me-1"></i> Back
                                        </a>
                                        <div class="text-end">
                                            <button type="submit" class="btn btn-primary">Submit</button>
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

    @endsection
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        $(document).ready(function() {
            // Add New Customer Button Click
            $('#addNewCustomerBtn').click(function() {
                $('#addCustomerModal').modal('show');
            });

            // Save New Customer
            $('#newCustomerForm').on('submit', function(e) {
                e.preventDefault();
                var customerData = {
                    name: $('#newCustomerName').val(),
                    email: $('#newCustomerEmail').val(),
                    phone: $('#newCustomerPhone').val(),
                    car_model: $('#newCustomerCarModel').val(),
                    car_plat_no: $('#newCustomerCarPlate').val(),
                    address: $('#newCustomerAddress').val(),
                    date: $('#newCustomerDate').val(),
                    status: $('#newCustomerStatus').val(),
                    _token: '{{ csrf_token() }}'
                };

                if (!customerData.name || !customerData.phone) {
                    Swal.fire({
                        title: 'Validation Error!',
                        text: 'Please fill in all required fields',
                        icon: 'warning',
                        confirmButtonClass: 'btn btn-primary w-xs mt-2',
                        buttonsStyling: false,
                    });
                    return;
                }

                $.ajax({
                    url: "{{ route('customers.store') }}",
                    type: "POST",
                    data: customerData,
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    success: function(response) {
                        if (response.success) {
                            // Add new customer to dropdown
                            var newOption = new Option(response.customer.name, response.customer.id, true, true);
                            $(newOption).attr('data-name', response.customer.name);
                            $('#customer_id').append(newOption).trigger('change');
                            $('#email').val(response.customer.email || '');
                            $('#phone').val(response.customer.phone || '');
                            $('#car_model').val(response.customer.car_model || '');
                            $('#car_plat_no').val(response.customer.car_plat_no || '');
                            $('#chassis_no').val(response.customer.chassis_no || '');

                            // Close modal and clear fields
                            $('#addCustomerModal').modal('hide');
                            $('#newCustomerName').val('');
                            $('#newCustomerEmail').val('');
                            $('#newCustomerPhone').val('');
                            $('#newCustomerCarModel').val('');
                            $('#newCustomerCarPlate').val('');
                            $('#newCustomerAddress').val('');
                            $('#newCustomerDate').val('{{ date('Y-m-d') }}');
                            $('#newCustomerStatus').val('active');

                            // Show success message
                            Swal.fire({
                                title: 'Success!',
                                text: 'Customer has been added successfully!',
                                icon: 'success',
                                showCancelButton: false,
                                confirmButtonColor: '#3085d6',
                                confirmButtonText: 'OK'
                            });
                        } else {
                            Swal.fire({
                                title: 'Error!',
                                text: response.message || 'Failed to add customer.',
                                icon: 'error',
                                showCancelButton: false,
                                confirmButtonColor: '#d33',
                                confirmButtonText: 'OK'
                            });
                        }
                    },
                    error: function(xhr) {
                        Swal.fire({
                            title: 'Error!',
                            text: 'Something went wrong. Please try again.',
                            icon: 'error',
                            showCancelButton: false,
                            confirmButtonColor: '#d33',
                            confirmButtonText: 'OK'
                        });
                    }
                });
            });
            // Customer Selection Change
            $(document).on('change', '#customer_id', function() {
                var customerId = $(this).val();

                if (customerId) {
                    $.ajax({
                        url: "{{ url('/get-customer-details') }}/" + customerId,
                        type: "GET",
                        success: function(data) {
                            console.log('Customer data:', data); // Debug log

                            // Fill in all customer-related fields
                            $('#email').val(data.email || '');
                            $('#phone').val(data.phone || '');
                            $('#car_model').val(data.car_model || '');
                            $('#car_plat_no').val(data.car_plat_no || '');
                            $('#chassis_no').val(data.chassis_no || '');

                            // If car manufacture exists, select it in the dropdown
                            if (data.car_manufacture_id) {
                                $('#car_manufacture_id').val(data.car_manufacture_id).trigger('change');
                            }

                            // If manufacturing year exists, select it in the dropdown
                            if (data.manu_year) {
                                $('#manu_year').val(data.manu_year).trigger('change');
                            }
                        },
                        error: function(xhr, status, error) {
                            console.error('Error:', error); // Debug log
                            // Clear all fields if there's an error
                            $('#email').val('');
                            $('#phone').val('');
                            $('#car_model').val('');
                            $('#car_plat_no').val('');
                            $('#chassis_no').val('');
                            $('#car_manufacture_id').val('').trigger('change');
                            $('#manu_year').val('').trigger('change');
                        }
                    });
                } else {
                    // Clear all fields if no customer is selected
                    $('#email').val('');
                    $('#phone').val('');
                    $('#car_model').val('');
                    $('#car_plat_no').val('');
                    $('#chassis_no').val('');
                    $('#car_manufacture_id').val('').trigger('change');
                    $('#manu_year').val('').trigger('change');
                }
            });

            // ---------------------------
            // Load Subcategories
            // ---------------------------
            $(document).on("change", ".category_id", function() {
                var category_id = $(this).val();
                var row = $(this).closest(".item-row");
                var subCategoryDropdown = row.find(".sub_category_id");
                var productDropdown = row.find(".product_id");

                subCategoryDropdown.html('<option value="">Loading...</option>');
                productDropdown.html('<option value="">Select Product</option>');

                if (category_id) {
                    $.ajax({
                        url: "{{ url('/get-subcategories') }}/" + category_id,
                        type: "GET",
                        success: function(data) {
                            subCategoryDropdown.empty().append(
                                '<option value="">Select Sub Category</option>');
                            $.each(data, function(key, value) {
                                subCategoryDropdown.append('<option value="' + key +
                                    '">' + value + '</option>');
                            });
                        }
                    });
                } else {
                    subCategoryDropdown.html('<option value="">Select Sub Category</option>');
                }
            });

            // ---------------------------
            // Load Products
            // ---------------------------
            $(document).on("change", ".sub_category_id", function() {
                var sub_category_id = $(this).val();
                var row = $(this).closest(".item-row");
                var productDropdown = row.find(".product_id");

                productDropdown.html('<option value="">Loading...</option>');

                if (sub_category_id) {
                    $.ajax({
                        url: "{{ url('/get-products') }}/" + sub_category_id,
                        type: "GET",
                        success: function(data) {
                            productDropdown.empty().append(
                                '<option value="">Select Product</option>');
                            $.each(data, function(key, value) {
                                productDropdown.append('<option value="' + key + '">' +
                                    value + '</option>');
                            });
                        }
                    });
                } else {
                    productDropdown.html('<option value="">Select Product</option>');
                }
            });

            // ---------------------------
            // Product Change → Load Price
            // ---------------------------
            $(document).on("change", ".product_id", function() {
                var product_id = $(this).val();
                var row = $(this).closest(".item-row");

                if (product_id) {
                    $.ajax({
                        url: "{{ url('/get-product-price') }}/" + product_id,
                        type: "GET",
                        success: function(data) {
                            var price = parseFloat(data.price) || 0;
                            row.find(".qty").val(1);
                            row.find(".price").val(price.toFixed(2));
                            row.find(".total").val(price.toFixed(2));
                            calculateTotals();
                        }
                    });
                } else {
                    row.find(".qty, .price, .total").val("");
                    calculateTotals();
                }
            });

            // ---------------------------
            // Qty or Price Change
            // ---------------------------
            $(document).on("input", ".qty, .price", function() {
                var row = $(this).closest(".item-row");
                var qty = parseFloat(row.find(".qty").val()) || 0;
                var price = parseFloat(row.find(".price").val()) || 0;
                var total = qty * price;
                row.find(".total").val(total.toFixed(2));
                calculateTotals();
            });

            // ---------------------------
            // Add Row
            // ---------------------------
            $(document).on("click", ".addRow", function() {
                $.ajax({
                    url: "{{ route('get.new.item.row') }}",
                    type: "GET",
                    success: function(response) {
                        $("#itemRows").append(response.html);
                        calculateTotals();
                    },
                    error: function() {
                        alert("Failed to add new row.");
                    }
                });
            });

            // ---------------------------
            // Remove Row
            // ---------------------------
            $(document).on("click", ".removeRow", function() {
                var allRows = $(".item-row");
                if (allRows.length > 1) {
                    $(this).closest(".item-row").remove();
                    calculateTotals();
                } else {
                    alert("You must have at least one item row.");
                }
            });

            // ---------------------------
            // Calculation Logic
            // ---------------------------
            let netEdited = false;
            let lastDiscountPercent = 0; // Track latest discount percentage entered or derived

            // Main Calculation
            function calculateTotals() {
                let subtotal = 0;

                $('.total').each(function() {
                    let val = parseFloat($(this).val()) || 0;
                    subtotal += val;
                });

                $('#amount').val(subtotal.toFixed(2));

                let netAmount = parseFloat($('#net_amount').val()) || 0;

                // 🧠 Case 1: If user never edited → keep net = subtotal
                if (!netEdited) {
                    netAmount = subtotal;
                    $('#net_amount').val(netAmount.toFixed(2));
                    lastDiscountPercent = 0;
                }
                // 🧠 Case 2: If subtotal changes & user edited before → maintain same discount %
                else if (subtotal > 0 && lastDiscountPercent > 0) {
                    let discountAmount = (subtotal * lastDiscountPercent) / 100;
                    netAmount = subtotal - discountAmount;
                    $('#net_amount').val(netAmount.toFixed(2));
                }

                // 🧮 Recalculate dependent fields
                let discountAmount = subtotal - netAmount;
                let discountPercent = subtotal > 0 ? (discountAmount / subtotal) * 100 : 0;
                let vatAmount = (netAmount * 5) / 100;
                let totalPayable = netAmount + vatAmount;

                // Update all UI fields
                $('#discount_amount').val(discountAmount.toFixed(2));
                $('#discount_percent').val(discountPercent.toFixed(2));
                $('#vat_amount').val(vatAmount.toFixed(2));
                $('#total_payable').val(totalPayable.toFixed(2));

                // Remember last known % (for dynamic updates)
                lastDiscountPercent = discountPercent;
            }

            // 🧩 User manually edits Net Amount
            $(document).on('input', '#net_amount', function() {
                netEdited = true;

                let subtotal = parseFloat($('#amount').val()) || 0;
                let netAmount = parseFloat($(this).val()) || 0;
                let discountAmount = subtotal - netAmount;
                let discountPercent = subtotal > 0 ? (discountAmount / subtotal) * 100 : 0;
                let vatAmount = (netAmount * 5) / 100;
                let totalPayable = netAmount + vatAmount;

                $('#discount_amount').val(discountAmount.toFixed(2));
                $('#discount_percent').val(discountPercent.toFixed(2));
                $('#vat_amount').val(vatAmount.toFixed(2));
                $('#total_payable').val(totalPayable.toFixed(2));

                lastDiscountPercent = discountPercent;
            });

            // 🧩 User edits Discount %
            $(document).on('input', '#discount_percent', function() {
                netEdited = true;

                let subtotal = parseFloat($('#amount').val()) || 0;
                let discountPercent = parseFloat($(this).val()) || 0;
                let discountAmount = (subtotal * discountPercent) / 100;
                let netAmount = subtotal - discountAmount;
                let vatAmount = (netAmount * 5) / 100;
                let totalPayable = netAmount + vatAmount;

                $('#discount_amount').val(discountAmount.toFixed(2));
                $('#net_amount').val(netAmount.toFixed(2));
                $('#vat_amount').val(vatAmount.toFixed(2));
                $('#total_payable').val(totalPayable.toFixed(2));

                lastDiscountPercent = discountPercent;
            });

            // 🧩 Whenever products or qty change → recalc with preserved discount ratio
            $(document).on('input change', '.qty, .price, .total', function() {
                calculateTotals();
            });

            // 🧩 When rows added or removed
            $(document).on('click', '.addRow, .removeRow', function() {
                setTimeout(calculateTotals, 150);
            });
        });
    </script>

