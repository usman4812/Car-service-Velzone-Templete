<?php

namespace App\Http\Controllers\Admin;

use App\Models\JobCard;
use App\Models\Product;
use App\Models\Customer;
use App\Models\Categories;
use App\Models\SalesPerson;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use App\Models\Service;
use App\Models\Worker;

class DashboardController extends Controller
{
    public function index()
    {
        // Total Earnings (All time)
        $totalEarnings = JobCard::whereNotNull('total_payable')->sum('total_payable') ?? 0;

        // Monthly Earnings (Current Month)
        $monthlyEarnings = JobCard::whereNotNull('total_payable')
            ->whereMonth('date', now()->month)
            ->whereYear('date', now()->year)
            ->sum('total_payable') ?? 0;

        // Today's Earnings
        $todayEarnings = JobCard::whereNotNull('total_payable')
            ->whereDate('date', today())
            ->sum('total_payable') ?? 0;

        // Log earnings for debugging
        Log::info('Earnings Stats', [
            'total' => $totalEarnings,
            'monthly' => $monthlyEarnings,
            'today' => $todayEarnings
        ]);

        // Total Job Cards
        $totalJobCards = JobCard::query()->count() ?? 0;

        // Total Customers (only active customers)
        $totalCustomers = Customer::where('status', 'active')->count() ?? 0;

        // Total Products (only active products)
        $totalProducts = Product::where('status', 'active')->count() ?? 0;

        // Total Workers (Sales Persons)
        $totalWorkers = Worker::where('status', 'active')->count() ?? 0;

        // Total Services (Categories)
        $totalServices = Service::where('status', 'active')->count() ?? 0;

        // Get monthly total_payable data for the graph
        $monthlyData = JobCard::selectRaw('MONTH(date) as month, SUM(total_payable) as total')
            ->whereYear('date', date('Y'))
            ->groupBy('month')
            ->orderBy('month')
            ->get()
            ->pluck('total', 'month')
            ->toArray();

        // Fill in missing months with 0
        $graphData = [];
        for ($i = 1; $i <= 12; $i++) {
            $graphData[] = isset($monthlyData[$i]) ? round($monthlyData[$i], 2) : 0;
        }

        // For debugging
        Log::info('Dashboard Stats', [
            'earnings' => $totalEarnings,
            'jobCards' => $totalJobCards,
            'customers' => $totalCustomers,
            'products' => $totalProducts,
            'graphData' => $graphData
        ]);

        return view('pages.dashboard', compact(
            'totalEarnings',
            'monthlyEarnings',
            'todayEarnings',
            'totalJobCards',
            'totalCustomers',
            'totalProducts',
            'graphData',
            'totalWorkers',
            'totalServices'
        ));
    }
}
