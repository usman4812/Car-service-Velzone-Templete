<?php

namespace App\Http\Controllers\Admin;

use App\Models\JobCard;
use App\Models\SalesPerson;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class ContactsController extends Controller
{
    /**
     * Display a listing of contact job cards.
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $jobCards = JobCard::with(['salesPerson', 'items', 'customer'])
                ->select(['id', 'job_card_no', 'customer_id', 'date', 'updated_at'])
                ->latest();

            return DataTables::of($jobCards)
                ->filter(function ($query) use ($request) {
                    if ($request->search['value']) {
                        $searchValue = $request->search['value'];
                        $query->where(function($q) use ($searchValue) {
                            // Search in job_card_no
                            $q->where('job_card_no', 'like', "%{$searchValue}%")
                            // Search in customer name, phone, email, car_plat_no, car_model
                            ->orWhereHas('customer', function($q) use ($searchValue) {
                                $q->where('name', 'like', "%{$searchValue}%")
                                  ->orWhere('phone', 'like', "%{$searchValue}%")
                                  ->orWhere('email', 'like', "%{$searchValue}%")
                                  ->orWhere('car_plat_no', 'like', "%{$searchValue}%")
                                  ->orWhere('car_model', 'like', "%{$searchValue}%");
                            });
                        });
                    }
                })
                ->addIndexColumn()

                // ✅ Customer Name
                ->addColumn('name', function ($row) {
                    return $row->customer ? $row->customer->name : '-';
                })

                // ✅ Customer Email
                ->addColumn('email', function ($row) {
                    return $row->customer ? $row->customer->email : '-';
                })

                // ✅ Customer Phone
                ->addColumn('phone', function ($row) {
                    return $row->customer ? $row->customer->phone : '-';
                })

                // ✅ Car Model
                ->addColumn('car_model', function ($row) {
                    return $row->customer ? $row->customer->car_model : '-';
                })

                // ✅ Car Plate Number
                ->addColumn('car_plat_no', function ($row) {
                    return $row->customer ? $row->customer->car_plat_no : '-';
                })

                // ✅ Date (Updated At)
                ->addColumn('date', function ($row) {
                    return $row->updated_at ? $row->updated_at->format('Y-m-d') : '-';
                })
                ->make(true);
        }

        return view('pages.contact.index');
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
