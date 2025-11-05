<?php

namespace App\Http\Controllers\Admin;

use App\Models\JobCard;
use App\Models\JobCardItem;
use App\Models\SalesPerson;
use App\Models\Customer;
use App\Models\CarManufactures;
use App\Models\Categories;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Yajra\DataTables\Facades\DataTables;

class ReplacementController extends Controller
{
    /**
     * Display a listing of replacement job cards (replacement = 1).
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $jobCards = JobCard::with(['salesPerson', 'items', 'customer'])
                ->select(['id', 'job_card_no', 'customer_id', 'sale_person_id', 'date', 'amount', 'total_payable', 'updated_at', 'status'])
                ->where('replacement', 1) // Only show replacement job cards
                ->latest();

            return DataTables::of($jobCards)
                ->filter(function ($query) use ($request) {
                    if ($request->search['value']) {
                        $searchValue = $request->search['value'];
                        $query->where(function($q) use ($searchValue) {
                            // Search in job_card_no
                            $q->where('job_card_no', 'like', "%{$searchValue}%")
                            // Search in customer name, phone, and car_plat_no
                            ->orWhereHas('customer', function($q) use ($searchValue) {
                                $q->where('name', 'like', "%{$searchValue}%")
                                  ->orWhere('phone', 'like', "%{$searchValue}%")
                                  ->orWhere('car_plat_no', 'like', "%{$searchValue}%");
                            })
                            // Search in sales person name
                            ->orWhereHas('salesPerson', function($q) use ($searchValue) {
                                $q->where('name', 'like', "%{$searchValue}%");
                            });
                        });
                    }
                })
                ->addIndexColumn()

                // ✅ Customer Name
                ->addColumn('name', function ($row) {
                    return $row->customer ? $row->customer->name : '-';
                })

                // ✅ Customer Phone
                ->addColumn('phone', function ($row) {
                    return $row->customer ? $row->customer->phone : '-';
                })

                // ✅ Car Plate Number
                ->addColumn('car_plat_no', function ($row) {
                    return $row->customer ? $row->customer->car_plat_no : '-';
                })

                // ✅ Sales Person Name
                ->addColumn('sale_person_id', function ($row) {
                    return $row->salesPerson ? $row->salesPerson->name : '-';
                })

                // ✅ Sub Total Calculation
                ->addColumn('amount', function ($row) {
                    return number_format($row->amount ?? 0, 2);
                })

                // ✅ Total Payable
                ->addColumn('total_payable', function ($row) {
                    return number_format($row->total_payable ?? 0, 2);
                })

                // ✅ Date (Updated At)
                ->addColumn('date', function ($row) {
                    return $row->updated_at ? $row->updated_at->format('Y-m-d') : '-';
                })

                // ✅ Status Badge
                ->addColumn('status', function ($row) {
                    $status = strtolower(trim($row->status ?? 'replacement'));
                    if ($status === 'replacement') {
                        return '<span class="badge bg-warning">Replacement</span>';
                    } elseif ($status === 'active') {
                        return '<span class="badge bg-success">Active</span>';
                    } else {
                        return '<span class="badge bg-secondary">' . ucfirst($status) . '</span>';
                    }
                })

                // ✅ Action Buttons with Permission Checks
                ->addColumn('action', function ($row) {
                    $user = Auth::user();
                    $canEdit = $user->hasRole('admin') || $user->can('edit-replacement');
                    $canDelete = $user->hasRole('admin') || $user->can('delete-replacement');

                    $editUrl = route('replacements.edit', $row->id);
                    $deleteUrl = route('replacements.destroy', $row->id);
                    $invoiceUrl = route('job-card.invoice', $row->id);
                    $jobCardUrl = route('job-card.show', $row->id);

                    $html = '<div class="dropdown d-inline-block">
                        <button class="btn btn-soft-secondary btn-sm dropdown" type="button"
                            data-bs-toggle="dropdown" aria-expanded="false">
                            <i class="ri-more-fill align-middle"></i>
                        </button>
                        <ul class="dropdown-menu dropdown-menu-end">';

                    if ($canEdit) {
                        $html .= '<li>
                            <a href="' . $editUrl . '" class="dropdown-item edit-item-btn">
                                <i class="ri-pencil-fill align-bottom me-2 text-muted"></i> Edit
                            </a>
                        </li>';
                    }

                    if ($canDelete) {
                        $html .= '<li>
                            <form action="' . $deleteUrl . '" method="POST" style="display:inline;">
                                ' . csrf_field() . method_field('DELETE') . '
                                <button type="button" class="dropdown-item remove-item-btn show-confirm">
                                    <i class="ri-delete-bin-fill align-bottom me-2 text-muted"></i> Delete
                                </button>
                            </form>
                        </li>';
                    }

                    $html .= '<li>
                            <a href="' . $invoiceUrl . '" target="_blank" class="dropdown-item">
                                <i class="ri-file-text-line align-bottom me-2 text-muted"></i> Invoice
                            </a>
                        </li>
                        <li>
                            <a href="' . $jobCardUrl . '" target="_blank" class="dropdown-item">
                                <i class="ri-car-line align-bottom me-2 text-muted"></i> Job Card
                            </a>
                        </li>
                        </ul>
                    </div>';

                    return $html;
                })
                ->rawColumns(['action', 'status'])
                ->make(true);
        }

        $salePersons = SalesPerson::pluck('name', 'id');
        return view('pages.replacement.index', compact('salePersons'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $user = Auth::user();
        if (!$user->hasRole('admin') && !$user->can('edit-replacement')) {
            abort(403, 'Unauthorized action.');
        }
        $jobCard = JobCard::find($id);
        $jobCardItems = JobCardItem::where('job_card_id', $id)->get();
        $carMenus = CarManufactures::pluck('name', 'id');
        $salePersons = SalesPerson::pluck('name', 'id');
        $categories = Categories::pluck('name', 'id');
        $customers = Customer::where('status', 'active')->pluck('name', 'id');
        $isReplacementEdit = true; // Flag to indicate this is editing from replacement module
        return view('pages.job-card.edit', compact('jobCardItems', 'carMenus', 'salePersons', 'categories', 'jobCard', 'customers', 'isReplacementEdit'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $user = Auth::user();
        if (!$user->hasRole('admin') && !$user->can('edit-replacement')) {
            abort(403, 'Unauthorized action.');
        }
        $request->validate([
            'job_card_no' => 'required',
            'date' => 'required|date',
            'customer_id' => 'required',
            'phone' => 'required',
            'car_manufacture_id' => 'required',
        ]);
        $jobCard = JobCard::findOrFail($id);
        // Get customer details
        $customer = Customer::findOrFail($request->customer_id);

        $jobCard->update([
            'job_card_no' => $request->job_card_no,
            'date' => $request->date,
            'customer_id' => $request->customer_id,
            'email' => $customer->email,
            'phone' => $customer->phone,
            'car_model' => $request->car_model,
            'car_plat_no' => $request->car_plat_no,
            'chassis_no' => $request->chassis_no,
            'car_manufacture_id' => $request->car_manufacture_id,
            'manu_year' => $request->manu_year,
            'sale_person_id' => $request->sale_person_id,
            'full_car' => $request->full_car,
            'full_car_price' => $request->full_car_price,
            'remarks' => $request->remarks,
            'promo' => $request->promo,
            'amount' => $request->amount,
            'net_amount' => $request->net_amount,
            'vat_amount' => $request->vat_amount,
            'discount_amount' => $request->discount_amount,
            'discount_percent' => $request->discount_percent,
            'total_payable' => $request->total_payable,
            'status' => 'replacement', // Keep status as replacement when updating replacement records
        ]);
        JobCardItem::where('job_card_id', $jobCard->id)->delete();
        if ($request->has('category_id')) {
            foreach ($request->category_id as $key => $categoryId) {
                JobCardItem::create([
                    'job_card_id' => $jobCard->id,
                    'category_id' => $categoryId,
                    'sub_category_id' => $request->sub_category_id[$key] ?? null,
                    'product_id' => $request->product_id[$key] ?? null,
                    'qty' => $request->qty[$key] ?? 0,
                    'price' => $request->price[$key] ?? 0,
                    'sub_total' => $request->total[$key] ?? 0,
                    'total' => $request->total[$key] ?? 0,
                    'amount' => $request->total[$key] ?? 0,
                    'vat' => 0, // optional
                    'discount' => 0, // optional
                    'net_amount' => $request->total[$key] ?? 0,
                    'warranty' => $request->warranty[$key] ?? null,
                ]);
            }
        }

        return redirect()->route('replacements.index')->with('success', 'Replacement job card updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $user = Auth::user();
        if (!$user->hasRole('admin') && !$user->can('delete-replacement')) {
            abort(403, 'Unauthorized action.');
        }
        $jobCard = JobCard::findOrFail($id);
        
        // Delete associated job card items
        JobCardItem::where('job_card_id', $jobCard->id)->delete();
        
        // Delete the job card
        $jobCard->delete();

        return redirect()->route('replacements.index')->with('success', 'Replacement job card deleted successfully.');
    }
}
