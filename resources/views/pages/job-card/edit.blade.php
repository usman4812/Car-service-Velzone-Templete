@extends('layouts.master')
@section('title', 'Job Card')
@section('content')
    <div class="row">
        <div class="col-xxl-12">
            <div class="card">
                <div class="card-header align-items-center d-flex">
                    <h4 class="card-title mb-0 flex-grow-1">Add Job Card</h4>
                </div><!-- end card header -->
                <div class="card-body">
                    <div class="live-preview">
                        <form action="{{ route('job-card.update', $jobCard->id) }}" method="POST"
                            enctype="multipart/form-data">
                            @method('PUT')
                            @csrf
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="mb-3">
                                        <label for="job_card_no" class="form-label">Job Card No<span class="text-danger">
                                                *</span></label>
                                        <input type="text" name="job_card_no" class="form-control" placeholder=""
                                            value="{{ $jobCard->job_card_no }}" id="job_card_no" readonly>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="mb-3">
                                        <label for="date" class="form-label">Date<span class="text-danger">
                                                *</span></label>
                                        <input type="date" name="date" class="form-control"
                                            value="{{ $jobCard->date }}" required>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="mb-3">
                                        <label for="name" class="form-label">Customer Name<span class="text-danger">
                                                *</span></label>
                                        <input type="text" name="name" class="form-control"
                                            placeholder="Enter Customer Name" value="{{ $jobCard->name }}" required>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="mb-3">
                                        <label for="email" class="form-label">Email</label>
                                        <input type="email" name="email" class="form-control"
                                            value="{{ $jobCard->email }}" placeholder="Enter Email Address">
                                    </div>
                                </div>
                                <!--end col-->
                                <div class="col-md-4">
                                    <div class="mb-3">
                                        <label for="phone" class="form-label">Mobile Phone</label>
                                        <input type="text" name="phone" class="form-control"
                                            placeholder="Enter Mobile Phone" id="phone" value="{{ $jobCard->phone }}">
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="mb-3">
                                        <label for="car_model" class="form-label">Car Model</label>
                                        <input type="text" name="car_model" class="form-control"
                                            placeholder="Enter Car Model" id="car_model" value="{{ $jobCard->car_model }}">
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="mb-3">
                                        <label for="car_plat_no" class="form-label">Car Plate No</label>
                                        <input type="text" name="car_plat_no" class="form-control"
                                            placeholder="Enter Car Plate No" id="car_plat_no"
                                            value="{{ $jobCard->car_plat_no }}">
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="mb-3">
                                        <label for="chassis_no" class="form-label">Chassis No</label>
                                        <input type="text" name="chassis_no" class="form-control"
                                            placeholder="Enter Chassis No" id="chassis_no"
                                            value="{{ $jobCard->chassis_no }}">
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="mb-3">
                                        <label for="category_id" class="form-label">Car Manufacture</label>
                                        <select id="car_manufacture_id" class="form-select" data-choices
                                            data-choices-sorting="true" name="car_manufacture_id">
                                            <option value="">Select Car Manufacture</option>
                                            @foreach ($carMenus as $id => $carMenu)
                                                <option value="{{ $id }}"
                                                    {{ $jobCard->car_manufacture_id == $id ? 'selected' : '' }}>
                                                    {{ $carMenu }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="mb-3">
                                        <label for="manu_year" class="form-label">Manufacturing Year</label>
                                        <select id="manu_year" class="form-select" data-choices
                                            data-choices-sorting="true" name="manu_year">
                                            <option value="">Select Manufacturing Year</option>
                                            @for ($year = date('Y'); $year >= 2000; $year--)
                                                <option value="{{ $year }}"
                                                    {{ old('manu_year', $jobCard->manu_year) == $year ? 'selected' : '' }}>
                                                    {{ $year }}
                                                </option>
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
                                                <option value="{{ $id }}"
                                                    {{ old('sale_person_id', $jobCard->sale_person_id) == $id ? 'selected' : '' }}>
                                                    {{ $salePerson }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="mb-3">
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="checkbox" id="inlineCheckbox1"
                                                name="full_car" value="1"
                                                {{ old('full_car', $jobCard->full_car) == 1 ? 'checked' : '' }}>
                                            <label class="form-check-label" for="inlineCheckbox1">Full Car</label>
                                        </div>
                                        <div class="form-check form-check-inline">
                                            <label for="category_id" class="form-label">Full Car Price</label>
                                            <input type="number" name="full_car_price" class="form-control"
                                                value="{{ $jobCard->full_car_price }}" placeholder="Enter Full Car Price"
                                                id="full_car_price">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-8">
                                    <div class="mb-3">
                                        <label for="remarks" class="form-label">Remarks</label>
                                        <textarea type="text" name="remarks" class="form-control">{{ $jobCard->remarks }}</textarea>
                                    </div>
                                </div>
                                <div class="col-md-4 mt-5">
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="checkbox" id="inlineCheckbox2"
                                            name="promo" value="1"
                                            {{ old('promo', $jobCard->promo) == 1 ? 'checked' : '' }}>
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
                                            <div id="itemRows">
                                                @foreach ($jobCardItems as $item)
                                                    <div class="row align-items-center mb-3 item-row border-bottom pb-3">
                                                        <!-- Item Section (Category, Subcategory, Product) -->
                                                        <div class="col-md-6">
                                                            <div class="row g-2">
                                                                <div class="col-md-4">
                                                                    <select class="form-select category_id"
                                                                        name="category_id[]">
                                                                        <option value="">Select Category</option>
                                                                        @foreach ($categories as $id => $name)
                                                                            <option value="{{ $id }}"
                                                                                {{ $id == $item->category_id ? 'selected' : '' }}>
                                                                                {{ $name }}
                                                                            </option>
                                                                        @endforeach
                                                                    </select>
                                                                </div>
                                                                <div class="col-md-4">
                                                                    <select class="form-select sub_category_id"
                                                                        name="sub_category_id[]">
                                                                        <option value="{{ $item->sub_category_id }}">
                                                                            {{ optional($item->subCategory)->name ?? 'Select Sub Category' }}
                                                                        </option>
                                                                    </select>
                                                                </div>
                                                                <div class="col-md-4">
                                                                    <select class="form-select product_id"
                                                                        name="product_id[]">
                                                                        <option value="{{ $item->product_id }}">
                                                                            {{ optional($item->product)->name ?? 'Select Product' }}
                                                                        </option>
                                                                    </select>
                                                                </div>
                                                            </div>
                                                        </div>

                                                        <!-- Qty -->
                                                        <div class="col-md-1">
                                                            <input type="number" name="qty[]"
                                                                class="form-control text-center qty"
                                                                value="{{ $item->qty }}" placeholder="0">
                                                        </div>

                                                        <!-- Price -->
                                                        <div class="col-md-1">
                                                            <input type="text" name="price[]"
                                                                class="form-control text-center price"
                                                                value="{{ $item->price }}" placeholder="0.00" readonly>
                                                        </div>

                                                        <!-- Total -->
                                                        <div class="col-md-1">
                                                            <input type="text" name="total[]"
                                                                class="form-control text-center total"
                                                                value="{{ $item->total }}" placeholder="0.00" readonly>
                                                        </div>

                                                        <!-- Action Buttons -->
                                                        <div class="col-md-3 text-center">
                                                            <button type="button"
                                                                class="btn btn-success btn-sm addRow me-1 mt-1">
                                                                <i class="ri-add-line align-middle"></i> Add
                                                            </button>
                                                            <button type="button"
                                                                class="btn btn-danger btn-sm removeRow mt-1">
                                                                <i class="ri-delete-bin-line align-middle"></i> Delete
                                                            </button>
                                                        </div>

                                                        <!-- Description Row -->
                                                        <div class="col-md-8 mt-2">
                                                            <input type="text" name="description[]"
                                                                class="form-control" value="{{ $item->description }}"
                                                                placeholder="Description">
                                                        </div>
                                                    </div>
                                                @endforeach
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
                                                    <th>Amount</th>
                                                    <td class="text-end">AED</td>
                                                    <td><input type="text" id="amount" name="amount" value="{{$jobCard->amount}}"
                                                            class="form-control text-end" value="0.00" readonly></td>
                                                </tr>
                                                <tr>
                                                    <th>VAT %</th>
                                                    <td class="text-end">AED</td>
                                                    <td><input type="number" id="vat" name="vat" value="{{ $jobCard->vat}}"
                                                            class="form-control text-end" value="0"></td>
                                                </tr>
                                                <tr>
                                                    <th>Discount %</th>
                                                    <td class="text-end">AED</td>
                                                    <td><input type="number" id="discount" name="discount" value="{{ $jobCard->discount}}"
                                                            class="form-control text-end" placeholder="Discount"
                                                            value="0"></td>
                                                </tr>
                                                <tr>
                                                    <th>Net Amount</th>
                                                    <td class="text-end">AED</td>
                                                    <td><input type="text" id="net_amount" value="{{ $jobCard->net_amount}}"
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
                                            <button type="submit" class="btn btn-primary">Update</button>
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
            // Load subcategories when category changes
            $(document).on('change', '.category_id', function() {
                var category_id = $(this).val();
                var row = $(this).closest('.item-row');
                var subCategoryDropdown = row.find('.sub_category_id');
                var productDropdown = row.find('.product_id');

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

            // Load products when subcategory changes
            $(document).on('change', '.sub_category_id', function() {
                var sub_category_id = $(this).val();
                var row = $(this).closest('.item-row');
                var productDropdown = row.find('.product_id');

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

            // When Product Changes → set qty, price, total
            $(document).on('change', '.product_id', function() {
                var product_id = $(this).val();
                var row = $(this).closest('.item-row');

                if (product_id) {
                    $.ajax({
                        url: "{{ url('/get-product-price') }}/" + product_id,
                        type: "GET",
                        success: function(data) {
                            var price = parseFloat(data.price) || 0;
                            row.find('.qty').val(1);
                            row.find('.price').val(price.toFixed(2));
                            row.find('.total').val(price.toFixed(2));
                            calculateTotals();
                        }
                    });
                } else {
                    row.find('.qty, .price, .total').val('');
                    calculateTotals();
                }
            });

            // When Qty or Price Changes → update total for that row + global total
            $(document).on('input', '.qty, .price', function() {
                var row = $(this).closest('.item-row');
                var qty = parseFloat(row.find('.qty').val()) || 0;
                var price = parseFloat(row.find('.price').val()) || 0;
                var total = qty * price;
                row.find('.total').val(total.toFixed(2));
                calculateTotals();
            });

            // Add new row via AJAX
            $(document).on('click', '.addRow', function() {
                $.ajax({
                    url: "{{ route('get.new.item.row') }}",
                    type: "GET",
                    success: function(response) {
                        $('#itemRows').append(response.html);
                        calculateTotals();
                    },
                    error: function() {
                        alert('Failed to add new row.');
                    }
                });
            });

            // Remove row
            $(document).on('click', '.removeRow', function() {
                var allRows = $('.item-row');
                if (allRows.length > 1) {
                    $(this).closest('.item-row').remove();
                    calculateTotals();
                } else {
                    alert('You must have at least one item row.');
                }
            });

            // Global Total Calculation Function
            function calculateTotals() {
                let amount = 0;

                $('.total').each(function() {
                    let val = parseFloat($(this).val()) || 0;
                    amount += val;
                });

                $('#amount').val(amount.toFixed(2));

                let vatPercent = parseFloat($('#vat').val()) || 0;
                let discountPercent = parseFloat($('#discount').val()) || 0;

                let vatValue = (amount * vatPercent) / 100;
                let discountValue = (amount * discountPercent) / 100;

                let netAmount = amount + vatValue - discountValue;

                $('#net_amount').val(netAmount.toFixed(2));
            }

            // Recalculate when VAT or discount changes
            $(document).on('input', '#vat, #discount', function() {
                calculateTotals();
            });

        });
    </script>
