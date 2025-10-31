<?php

namespace App\Http\Controllers\Admin;

use App\Models\Product;
use App\Models\JobCardItem;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\Facades\DataTables;

class ReportController extends Controller
{
    /**
     * Display a listing of most used products.
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $products = JobCardItem::select('product_id', DB::raw('SUM(qty) as total_quantity'))
                ->whereNotNull('product_id')
                ->groupBy('product_id')
                ->orderBy('total_quantity', 'desc')
                ->with(['product.category', 'product.subCategory'])
                ->get();

            return DataTables::of($products)
                ->addIndexColumn()

                // ✅ Product Name
                ->addColumn('product_name', function ($row) {
                    return $row->product ? $row->product->name : '-';
                })

                // ✅ Product Code
                ->addColumn('product_code', function ($row) {
                    return $row->product ? $row->product->code : '-';
                })

                // ✅ Category
                ->addColumn('category', function ($row) {
                    return $row->product && $row->product->category ? $row->product->category->name : '-';
                })

                // ✅ Sub Category
                ->addColumn('sub_category', function ($row) {
                    return $row->product && $row->product->subCategory ? $row->product->subCategory->name : '-';
                })

                // ✅ Total Quantity Used
                ->addColumn('total_quantity', function ($row) {
                    return number_format($row->total_quantity, 0);
                })

                // ✅ Price
                ->addColumn('price', function ($row) {
                    return $row->product ? number_format($row->product->price, 2) : '0.00';
                })

                // ✅ Total Value
                ->addColumn('total_value', function ($row) {
                    $totalValue = $row->product ? ($row->product->price * $row->total_quantity) : 0;
                    return number_format($totalValue, 2);
                })

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
