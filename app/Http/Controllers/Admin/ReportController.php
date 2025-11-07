<?php

namespace App\Http\Controllers\Admin;

use App\Models\Product;
use App\Models\JobCard;
use App\Models\JobCardItem;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\Facades\DataTables;
use Carbon\Carbon;

class ReportController extends Controller
{
    /**
     * Display a listing of earnings grouped by date.
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            // Group job cards by date, excluding replacement records
            $earnings = JobCard::select(
                    DB::raw('DATE(date) as date'),
                    DB::raw('COUNT(*) as total_job_cards'),
                    DB::raw('SUM(net_amount) as total_earnings')
                )
                ->where(function($query) {
                    $query->where('replacement', 0)
                          ->orWhereNull('replacement');
                })
                ->whereNotNull('date')
                ->groupBy(DB::raw('DATE(date)'))
                ->orderBy('date', 'desc')
                ->get();

            return DataTables::of($earnings)
                ->addIndexColumn()

                // Date column
                ->addColumn('date', function ($row) {
                    return $row->date ? Carbon::parse($row->date)->format('d M Y') : '-';
                })

                // Total Job Cards
                ->addColumn('total_job_cards', function ($row) {
                    return '<span class="badge bg-primary">' . number_format($row->total_job_cards, 0) . '</span>';
                })

                // Total Earnings
                ->addColumn('total_earnings', function ($row) {
                    return '<strong>' . number_format($row->total_earnings ?? 0, 2) . '</strong>';
                })

                // Action column with View button
                ->addColumn('action', function ($row) {
                    $viewUrl = route('reports.show', ['date' => $row->date]);
                    return '<a href="' . $viewUrl . '" class="btn btn-sm btn-info">
                                <i class="ri-eye-line"></i> View Details
                            </a>';
                })

                ->rawColumns(['total_job_cards', 'total_earnings', 'action'])
                ->make(true);
        }

        return view('pages.report.index');
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
     * Display detailed earnings for a specific date.
     */
    public function show(Request $request, $date)
    {
        // Parse the date
        try {
            $parsedDate = Carbon::parse($date)->format('Y-m-d');
        } catch (\Exception $e) {
            return redirect()->route('reports.index')
                ->with('error', 'Invalid date format.');
        }

        // Get all job cards for this date, excluding replacement records
        $jobCards = JobCard::with(['customer', 'salesPerson', 'carManufacture'])
            ->where(function($query) {
                $query->where('replacement', 0)
                      ->orWhereNull('replacement');
            })
            ->whereDate('date', $parsedDate)
            ->orderBy('created_at', 'desc')
            ->get();

        // Calculate totals
        $totalJobCards = $jobCards->count();
        $totalEarnings = $jobCards->sum('net_amount');
        $totalAmount = $jobCards->sum('amount');
        $totalDiscount = $jobCards->sum('discount_amount');
        $totalVat = $jobCards->sum('vat_amount');

        return view('pages.report.show', [
            'date' => Carbon::parse($parsedDate)->format('d M Y'),
            'parsedDate' => $parsedDate,
            'jobCards' => $jobCards,
            'totalJobCards' => $totalJobCards,
            'totalEarnings' => $totalEarnings,
            'totalAmount' => $totalAmount,
            'totalDiscount' => $totalDiscount,
            'totalVat' => $totalVat,
        ]);
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
