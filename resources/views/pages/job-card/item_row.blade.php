<div class="row align-items-center mb-3 item-row border-bottom pb-3">
    <!-- Item Section -->
    <div class="col-md-6">
        <div class="row g-2">
            <div class="col-md-4">
                <select class="form-select category_id" name="category_id[]">
                    <option value="">Select Category</option>
                    @foreach ($categories as $id => $name)
                        <option value="{{ $id }}">{{ $name }}</option>
                    @endforeach
                </select>
            </div>

            <div class="col-md-4">
                <select class="form-select sub_category_id" name="sub_category_id[]">
                    <option value="">Select Sub Category</option>
                </select>
            </div>

            <div class="col-md-4">
                <select class="form-select product_id" name="product_id[]">
                    <option value="">Select Product</option>
                </select>
            </div>
        </div>
    </div>

    <!-- Qty -->
    <div class="col-md-1">
        <input type="number" name="qty[]" class="form-control text-center qty" placeholder="0">
    </div>

    <!-- Price -->
    <div class="col-md-1">
        <input type="text" name="price[]" class="form-control text-center price" placeholder="0.00" readonly>
    </div>

    <!-- Total -->
    <div class="col-md-1">
        <input type="text" name="total[]" class="form-control text-center total" placeholder="0.00" readonly>
    </div>

    <!-- Action Buttons -->
    <div class="col-md-3 text-center">
        <button type="button" class="btn btn-success btn-sm addRow me-1 mt-1">
            <i class="ri-add-line align-middle"></i> Add
        </button>
        <button type="button" class="btn btn-danger btn-sm removeRow mt-1">
            <i class="ri-delete-bin-line align-middle"></i> Delete
        </button>
    </div>

    <!-- Description Row -->
    <div class="col-md-8 mt-2">
        <input type="text" name="description[]" class="form-control" placeholder="Description">
    </div>
</div>
