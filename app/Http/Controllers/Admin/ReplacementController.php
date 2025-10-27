<?php

namespace App\Http\Controllers\Admin;

use App\Models\JobCard;
use App\Models\SalesPerson;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
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
                ->select(['id', 'job_card_no', 'customer_id', 'sale_person_id', 'date', 'amount', 'total_payable', 'updated_at'])
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
                ->make(true);
        }

        $salePersons = SalesPerson::pluck('name', 'id');
        return view('pages.replacement.index', compact('salePersons'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
