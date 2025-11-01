<?php

namespace App\Http\Controllers\Admin;

use App\Models\Quotation;
use App\Models\QuotationItem;
use App\Models\Categories;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Yajra\DataTables\Facades\DataTables;

class MakingQuotationController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $quotations = Quotation::select(['id', 'quotation_no', 'customer_name', 'customer_phone', 'customer_email', 'car_model', 'car_plat_no', 'chassis_no', 'date', 'amount', 'net_amount', 'total_payable'])
                ->latest();

            return DataTables::of($quotations)
                ->filter(function ($query) use ($request) {
                    if ($request->search['value']) {
                        $searchValue = $request->search['value'];
                        $query->where(function($q) use ($searchValue) {
                            // Search in quotation_no
                            $q->where('quotation_no', 'like', "%{$searchValue}%")
                            // Search in customer name, phone, email, and car_plat_no
                            ->orWhere('customer_name', 'like', "%{$searchValue}%")
                            ->orWhere('customer_phone', 'like', "%{$searchValue}%")
                            ->orWhere('customer_email', 'like', "%{$searchValue}%")
                            ->orWhere('car_plat_no', 'like', "%{$searchValue}%")
                            ->orWhere('car_model', 'like', "%{$searchValue}%")
                            ->orWhere('chassis_no', 'like', "%{$searchValue}%");
                        });
                    }
                })
                ->addIndexColumn()

                // ✅ Customer Name
                ->addColumn('customer_name', function ($row) {
                    return $row->customer_name ?: '-';
                })

                // ✅ Customer Phone
                ->addColumn('customer_phone', function ($row) {
                    return $row->customer_phone ?: '-';
                })

                // ✅ Car Model
                ->addColumn('car_model', function ($row) {
                    return $row->car_model ?: '-';
                })

                // ✅ Car Plate Number
                ->addColumn('car_plat_no', function ($row) {
                    return $row->car_plat_no ?: '-';
                })

                // ✅ Chassis No
                ->addColumn('chassis_no', function ($row) {
                    return $row->chassis_no ?: '-';
                })

                // ✅ Sub Total
                ->addColumn('sub_total', function ($row) {
                    return number_format($row->amount ?? 0, 2);
                })

            // ✅ Total Payable
            ->addColumn('total_payable', function ($row) {
                return number_format($row->total_payable ?? 0, 2);
            })

                // ✅ Action Buttons
                ->addColumn('action', function ($row) {
                    $editUrl = route('making-quotation.edit', $row->id);
                    $deleteUrl = route('making-quotation.destroy', $row->id);
                    $showUrl = route('making-quotation.show', $row->id);
                    
                    $user = \Illuminate\Support\Facades\Auth::user();
                    $canEdit = $user && ($user->hasRole('admin') || $user->can('edit-making-quotation'));
                    $canDelete = $user && ($user->hasRole('admin') || $user->can('delete-making-quotation'));

                    $html = '
                    <div class="dropdown d-inline-block">
                        <button class="btn btn-soft-secondary btn-sm dropdown" type="button"
                            data-bs-toggle="dropdown" aria-expanded="false">
                            <i class="ri-more-fill align-middle"></i>
                        </button>
                        <ul class="dropdown-menu dropdown-menu-end">';
                    
                    if ($canEdit) {
                        $html .= '
                            <li>
                                <a href="' . $editUrl . '" class="dropdown-item edit-item-btn">
                                    <i class="ri-pencil-fill align-bottom me-2 text-muted"></i> Edit
                                </a>
                            </li>';
                    }
                    
                    if ($canDelete) {
                        $html .= '
                            <li>
                                <form action="' . $deleteUrl . '" method="POST" style="display:inline;">
                                    ' . csrf_field() . method_field('DELETE') . '
                                    <button type="button" class="dropdown-item remove-item-btn show-confirm">
                                        <i class="ri-delete-bin-fill align-bottom me-2 text-muted"></i> Delete
                                    </button>
                                </form>
                            </li>';
                    }
                    
                    $html .= '
                            <li>
                                <a href="' . $showUrl . '" target="_blank" class="dropdown-item">
                                    <i class="ri-file-text-line align-bottom me-2 text-muted"></i> View Quotation
                                </a>
                            </li>
                        </ul>
                    </div>';
                    
                    return $html;
                })
                ->rawColumns(['action'])
                ->make(true);
        }

        return view('pages.quotation.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        // Generate quotation number
        $latestQuotation = Quotation::latest()->first();
        if ($latestQuotation) {
            $lastNumber = (int) str_replace('QUO-', '', $latestQuotation->quotation_no ?? 'QUO-00');
            $nextNumber = $lastNumber + 1;
        } else {
            $nextNumber = 1;
        }
        $quotationNo = 'QUO-' . str_pad($nextNumber, 2, '0', STR_PAD_LEFT);

        $categories = Categories::pluck('name', 'id');
        
        return view('pages.quotation.create', compact('categories', 'quotationNo'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'quotation_no' => 'required',
            'date' => 'required|date',
            'customer_name' => 'required',
            'amount' => 'required|numeric',
            'net_amount' => 'required|numeric',
            'total_payable' => 'required|numeric',
        ]);

        // Step 1: Create main Quotation record
        $quotation = Quotation::create([
            'quotation_no' => $request->quotation_no,
            'date' => $request->date,
            'customer_name' => $request->customer_name,
            'customer_email' => $request->customer_email,
            'customer_phone' => $request->customer_phone,
            'car_model' => $request->car_model,
            'car_plat_no' => $request->car_plat_no,
            'chassis_no' => $request->chassis_no,
            'amount' => $request->amount,
            'net_amount' => $request->net_amount,
            'vat_amount' => $request->vat_amount,
            'discount_amount' => $request->discount_amount,
            'discount_percent' => $request->discount_percent,
            'total_payable' => $request->total_payable,
        ]);

        // Step 2: Insert multiple QuotationItems
        if ($request->has('category_id')) {
            foreach ($request->category_id as $key => $categoryId) {
                if ($categoryId && isset($request->product_id[$key]) && $request->product_id[$key]) {
                    QuotationItem::create([
                        'quotation_id' => $quotation->id,
                        'category_id' => $categoryId,
                        'sub_category_id' => $request->sub_category_id[$key] ?? null,
                        'product_id' => $request->product_id[$key] ?? null,
                        'qty' => $request->qty[$key] ?? 0,
                        'price' => $request->price[$key] ?? 0,
                        'sub_total' => $request->total[$key] ?? 0,
                        'total' => $request->total[$key] ?? 0,
                        'amount' => $request->total[$key] ?? 0,
                        'vat' => 0,
                        'discount' => 0,
                        'net_amount' => $request->total[$key] ?? 0,
                    ]);
                }
            }
        }

        return redirect()->route('making-quotation.index')
            ->with('success', 'Quotation Created Successfully');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $quotation = Quotation::with('items')->findOrFail($id);
        // Load relationships for items
        $quotation->items->load('category', 'subCategory', 'product');
        
        return view('pages.quotation.view', compact('quotation'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $quotation = Quotation::findOrFail($id);
        $quotationItems = QuotationItem::where('quotation_id', $id)->get();
        $categories = Categories::pluck('name', 'id');
        
        return view('pages.quotation.edit', compact('quotation', 'quotationItems', 'categories'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'quotation_no' => 'required',
            'date' => 'required|date',
            'customer_name' => 'required',
            'amount' => 'required|numeric',
            'net_amount' => 'required|numeric',
            'total_payable' => 'required|numeric',
        ]);

        $quotation = Quotation::findOrFail($id);

        // Step 1: Update main Quotation record
        $quotation->update([
            'quotation_no' => $request->quotation_no,
            'date' => $request->date,
            'customer_name' => $request->customer_name,
            'customer_email' => $request->customer_email,
            'customer_phone' => $request->customer_phone,
            'car_model' => $request->car_model,
            'car_plat_no' => $request->car_plat_no,
            'chassis_no' => $request->chassis_no,
            'amount' => $request->amount,
            'net_amount' => $request->net_amount,
            'vat_amount' => $request->vat_amount,
            'discount_amount' => $request->discount_amount,
            'discount_percent' => $request->discount_percent,
            'total_payable' => $request->total_payable,
        ]);

        // Step 2: Delete existing items and insert new ones
        QuotationItem::where('quotation_id', $quotation->id)->delete();
        
        if ($request->has('category_id')) {
            foreach ($request->category_id as $key => $categoryId) {
                if ($categoryId && isset($request->product_id[$key]) && $request->product_id[$key]) {
                    QuotationItem::create([
                        'quotation_id' => $quotation->id,
                        'category_id' => $categoryId,
                        'sub_category_id' => $request->sub_category_id[$key] ?? null,
                        'product_id' => $request->product_id[$key] ?? null,
                        'qty' => $request->qty[$key] ?? 0,
                        'price' => $request->price[$key] ?? 0,
                        'sub_total' => $request->total[$key] ?? 0,
                        'total' => $request->total[$key] ?? 0,
                        'amount' => $request->total[$key] ?? 0,
                        'vat' => 0,
                        'discount' => 0,
                        'net_amount' => $request->total[$key] ?? 0,
                    ]);
                }
            }
        }

        return redirect()->route('making-quotation.index')
            ->with('success', 'Quotation Updated Successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $quotation = Quotation::find($id);
        if ($quotation) {
            // Delete associated items first
            QuotationItem::where('quotation_id', $id)->delete();
            // Delete quotation
            $quotation->delete();
            return redirect()->route('making-quotation.index')->with('success', 'Quotation Deleted Successfully!');
        } else {
            return redirect()->route('making-quotation.index')->with('error', 'Record not found');
        }
    }
}
