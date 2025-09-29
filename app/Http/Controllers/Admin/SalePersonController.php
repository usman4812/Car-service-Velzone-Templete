<?php

namespace App\Http\Controllers\Admin;

use App\Models\SalesPerson;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class SalePersonController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $salesPerson = SalesPerson::all();
        return view('pages.sale-person.index', compact('salesPerson'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('pages.sale-person.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name'         => 'required|string|max:255',
            'email'        => 'required|email',
            'phone'        => 'required|string',
            'joining_date' => 'required|date',
            'salary'       => 'required|numeric|min:0',
            'address'      => 'nullable|string|max:500',
            'status'       => 'nullable|in:active,inactive',
        ]);
        $req_data = $request->all();
        $salesPerson = SalesPerson::create($req_data);
        return redirect()->route('sales-persons.index')
            ->with('success', 'Sales Person Created Successfully');
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
        $salePerson = SalesPerson::find($id);
        return view('pages.sale-person.edit', compact('salePerson'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'name'         => 'required|string|max:255',
            'email'        => 'required|email',
            'phone'        => 'required|string',
            'joining_date' => 'required|date',
            'salary'       => 'required|numeric|min:0',
            'address'      => 'nullable|string|max:500',
            'status'       => 'nullable|in:active,inactive',
        ]);
        $req_data = $request->all();
        $salePerson = SalesPerson::findOrFail($id);
        if ($salePerson) {
            $salePerson->update($req_data);
            return redirect()->route('sales-persons.index')
                ->with('success', 'Sales Person Updated Successfully');
        } else {
            return redirect()->route('sales-persons.index')->with('error', 'Record not found');
        }
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $sale_person = SalesPerson::find($id);
        if ($sale_person) {
            $sale_person->delete();
            return redirect()->route('sales-persons.index')->with('success', 'Sales Person Delete Successfully!');
        } else {
            return redirect()->route('sales-persons.index')->with('error', 'Record not found');
        }
    }
}
