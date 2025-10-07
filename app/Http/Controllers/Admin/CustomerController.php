<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Customer;
use Illuminate\Http\Request;

class CustomerController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $customers = Customer:: all();
        return view('pages.customer.index',compact('customers'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('pages.customer.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name'         => 'required|string|max:255',
            'phone'        => 'required|string',
        ]);
        $req_data = $request->all();
        $customer = Customer::create($req_data);
        return redirect()->route('customers.index')
            ->with('success', 'Customer Created Successfully');
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
        $customer = Customer::find($id);
        return view('pages.customer.edit', compact('customer'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
       $request->validate([
            'name'         => 'required|string|max:255',
            'phone'        => 'required|string',
        ]);
        $customer = Customer::findOrFail($id);
        $req_data = $request->all();
       if ($customer) {
            $customer->update($req_data);
            return redirect()->route('customers.index')
                ->with('success', 'Customer Updated Successfully');
        } else {
            return redirect()->route('customers.index')->with('error', 'Record not found');
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $customer = Customer::findOrFail($id);
        if ($customer) {
            $customer->delete();
        return redirect()->route('customers.index')->with('success', 'Customer Delete Successfully!');
        } else {
            return redirect()->route('customers.index')->with('error', 'Record not found');
        }
    }
}
