<?php

namespace App\Http\Controllers\Admin;

use App\Models\JobCard;
use App\Models\Categories;
use App\Models\JobCardItem;
use App\Models\SalesPerson;
use Illuminate\Http\Request;
use App\Models\CarManufactures;
use App\Http\Controllers\Controller;
use Yajra\DataTables\Facades\DataTables;

class JobCardController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $jobCards = JobCard::with(['salesPerson', 'items']) // ✅ Load related models
                ->select(['id', 'job_card_no', 'name', 'sale_person_id', 'date'])
                ->latest();

            return DataTables::of($jobCards)
                ->addIndexColumn()

                // ✅ Sales Person Name
                ->addColumn('sale_person_id', function ($row) {
                    return $row->salesPerson ? $row->salesPerson->name : '-';
                })

                // ✅ Sub Total Calculation
                ->addColumn('sub_total', function ($row) {
                    return number_format($row->items->sum(function ($item) {
                        return $item->price * $item->qty;
                    }), 2);
                })

                // ✅ Total (you can later add VAT or discount logic)
                ->addColumn('total', function ($row) {
                    $total = $row->items->sum(function ($item) {
                        return $item->price * $item->qty;
                    });
                    return number_format($total, 2);
                })

                // ✅ Action Buttons
                ->addColumn('action', function ($row) {
                    $editUrl = route('job-card.edit', $row->id);
                    $deleteUrl = route('job-card.destroy', $row->id);
                    $invoiceUrl = route('job-card.invoice', $row->id);
                    $jobCardUrl = route('job-card.show', $row->id);

                    return '
                    <div class="dropdown d-inline-block">
                        <button class="btn btn-soft-secondary btn-sm dropdown" type="button"
                            data-bs-toggle="dropdown" aria-expanded="false">
                            <i class="ri-more-fill align-middle"></i>
                        </button>
                        <ul class="dropdown-menu dropdown-menu-end">
                            <li>
                                <a href="' . $editUrl . '" class="dropdown-item edit-item-btn">
                                    <i class="ri-pencil-fill align-bottom me-2 text-muted"></i> Edit
                                </a>
                            </li>
                            <li>
                                <form action="' . $deleteUrl . '" method="POST" style="display:inline;">
                                    ' . csrf_field() . method_field('DELETE') . '
                                    <button type="button" class="dropdown-item remove-item-btn show-confirm">
                                        <i class="ri-delete-bin-fill align-bottom me-2 text-muted"></i> Delete
                                    </button>
                                </form>
                            </li>
                            <li>
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
                    </div>
                ';
                })
                ->rawColumns(['action'])
                ->make(true);
        }

        return view('pages.job-card.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $latestJobCard = JobCard::latest('id')->first();
        if ($latestJobCard) {
            $lastNumber = (int) str_replace('TSC-', '', $latestJobCard->job_card_no);
            $nextNumber = $lastNumber + 1;
        } else {
            $nextNumber = 1;
        }
        $jobCardNo = 'TSC-' . str_pad($nextNumber, 2, '0', STR_PAD_LEFT);

        $carMenus = CarManufactures::pluck('name', 'id');
        $salePersons = SalesPerson::pluck('name', 'id');
        $categories = Categories::pluck('name', 'id');
        return view('pages.job-card.create', compact('carMenus', 'salePersons', 'categories', 'jobCardNo'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'job_card_no' => 'required',
            'date' => 'required|date',
            'name' => 'required',
            'phone' => 'required',
            'car_manufacture_id' => 'required',
        ]);

        // Step 1️⃣: Create main JobCard record
        $jobCard = JobCard::create([
            'job_card_no' => $request->job_card_no,
            'date' => $request->date,
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
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
            'vat' => $request->vat,
            'discount' => $request->discount,
            'net_amount' => $request->net_amount,
        ]);

        // Step 2️⃣: Insert multiple JobCardItems
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
                    'vat' => 0, // optional, if you have
                    'discount' => 0, // optional
                    'net_amount' => $request->total[$key] ?? 0,
                ]);
            }
        }

        return redirect()->route('job-card.index')
            ->with('success', 'Job Card Created Successfully');
    }


    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $jobCard = JobCard::with(['salesPerson', 'items'])->findOrFail($id);
        return view('pages.job-card.view', compact('jobCard'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $jobCard = JobCard::find($id);
        $jobCardItems = JobCardItem::where('job_card_id', $id)->get();
        $carMenus = CarManufactures::pluck('name', 'id');
        $salePersons = SalesPerson::pluck('name', 'id');
        $categories = Categories::pluck('name', 'id');
        return view('pages.job-card.edit', compact('jobCardItems', 'carMenus', 'salePersons', 'categories', 'jobCard'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'job_card_no' => 'required',
            'date' => 'required|date',
            'name' => 'required',
            'phone' => 'required',
            'car_manufacture_id' => 'required',
        ]);
        $jobCard = JobCard::findOrFail($id);
        $jobCard->update([
            'job_card_no' => $request->job_card_no,
            'date' => $request->date,
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
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
            'vat' => $request->vat,
            'discount' => $request->discount,
            'net_amount' => $request->net_amount,
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
                ]);
            }
        }
        return redirect()->route('job-card.index')
            ->with('success', 'Job Card Updated Successfully');
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $jobCard = JobCard::find($id);
        if ($jobCard) {
            $jobCard->delete();
            return redirect()->route('job-card.index')->with('success', 'Job Card Delete Successfully!');
        } else {
            return redirect()->route('job-card.index')->with('error', 'Record not found');
        }
    }

    public function showInvoice($id)
    {
        $jobCard = JobCard::with('salesPerson')->findOrFail($id);
        $jobCardItems = JobCardItem::with('product')->where('job_card_id', $id)->get();

        return view('pages.job-card.invoice', compact('jobCard', 'jobCardItems'));
    }
}
