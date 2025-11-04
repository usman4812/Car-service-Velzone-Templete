<?php

namespace App\Http\Controllers\Admin;

use App\Models\Customer;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Yajra\DataTables\Facades\DataTables;

class CustomerController extends Controller
{
    /**
     * Display a listing of the resource.
     */

    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = Customer::select(['id', 'name', 'email', 'phone', 'car_model', 'car_plat_no', 'date', 'status']);
            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('status', function ($row) {
                    return $row->status == 'active'
                        ? '<span class="badge bg-success">Active</span>'
                        : '<span class="badge bg-danger">Inactive</span>';
                })
                ->addColumn('action', function ($row) {
                    $editUrl = route('customers.edit', $row->id);
                    $deleteUrl = route('customers.destroy', $row->id);

                    $user = auth()->user();
                    $canEdit = $user && ($user->hasRole('admin') || $user->can('edit-customer'));
                    $canDelete = $user && ($user->hasRole('admin') || $user->can('delete-customer'));

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

                    if (!$canEdit && !$canDelete) {
                        $html .= '<li><span class="dropdown-item text-muted">No actions available</span></li>';
                    }

                    $html .= '
                        </ul>
                    </div>';

                    return $html;
                })
                ->rawColumns(['status', 'action'])
                ->make(true);
        }

        return view('pages.customer.index');
    }


    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $user = Auth::user();
        if (!$user->hasRole('admin') && !$user->can('create-customer')) {
            abort(403, 'Unauthorized action.');
        }
        return view('pages.customer.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $user = Auth::user();
        if (!$user->hasRole('admin') && !$user->can('create-customer')) {
            abort(403, 'Unauthorized action.');
        }
        $request->validate([
            'name'         => 'required|string|max:255',
            'phone'        => 'required|string',
        ]);

        $customer = Customer::create($request->all());

        if ($request->ajax()) {
            return response()->json([
                'success' => true,
                'customer' => $customer,
                'message' => 'Customer created successfully'
            ]);
        }

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
        $user = Auth::user();
        if (!$user->hasRole('admin') && !$user->can('edit-customer')) {
            abort(403, 'Unauthorized action.');
        }
        $customer = Customer::find($id);
        return view('pages.customer.edit', compact('customer'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $user = Auth::user();
        if (!$user->hasRole('admin') && !$user->can('edit-customer')) {
            abort(403, 'Unauthorized action.');
        }
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
        $user = Auth::user();
        if (!$user->hasRole('admin') && !$user->can('delete-customer')) {
            abort(403, 'Unauthorized action.');
        }
        $customer = Customer::findOrFail($id);
        if ($customer) {
            $customer->delete();
            return redirect()->route('customers.index')->with('success', 'Customer Delete Successfully!');
        } else {
            return redirect()->route('customers.index')->with('error', 'Record not found');
        }
    }

    /**
     * Get customer details for AJAX request
     */
    public function getCustomerDetails($id)
    {
        $customer = Customer::find($id);
        if ($customer) {
            return response()->json([
                'email' => $customer->email,
                'phone' => $customer->phone,
                'car_model' => $customer->car_model,
                'car_plat_no' => $customer->car_plat_no,
                'chassis_no' => $customer->chassis_no,
                'car_manufacture_id' => $customer->car_manufacture_id,
                'manu_year' => $customer->manu_year,
                'address' => $customer->address
            ]);
        }
        return response()->json([]);
    }
}
