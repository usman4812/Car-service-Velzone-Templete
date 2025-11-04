<?php

namespace App\Http\Controllers\Admin;

use App\Models\SalesPerson;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Yajra\DataTables\Facades\DataTables;

class SalePersonController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = SalesPerson::select(['id', 'name', 'email', 'phone', 'joining_date', 'status']);
            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('status', function ($row) {
                    return $row->status == 'active'
                        ? '<span class="badge bg-success">Active</span>'
                        : '<span class="badge bg-danger">Inactive</span>';
                })
                ->addColumn('action', function ($row) {
                    $user = Auth::user();
                    $canEdit = $user->hasRole('admin') || $user->can('edit-sales-person');
                    $canDelete = $user->hasRole('admin') || $user->can('delete-sales-person');

                    $editUrl = route('sales-persons.edit', $row->id);
                    $deleteUrl = route('sales-persons.destroy', $row->id);

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

                    if (!$canEdit && !$canDelete) {
                        $html .= '<li><span class="dropdown-item text-muted">No actions available</span></li>';
                    }

                    $html .= '</ul></div>';

                    return $html;
                })
                ->rawColumns(['status', 'action'])
                ->make(true);
        }

        return view('pages.sale-person.index');
    }


    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $user = Auth::user();
        if (!$user->hasRole('admin') && !$user->can('create-sales-person')) {
            abort(403, 'Unauthorized action.');
        }
        return view('pages.sale-person.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $user = Auth::user();
        if (!$user->hasRole('admin') && !$user->can('create-sales-person')) {
            abort(403, 'Unauthorized action.');
        }
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
        $user = Auth::user();
        if (!$user->hasRole('admin') && !$user->can('edit-sales-person')) {
            abort(403, 'Unauthorized action.');
        }
        $salePerson = SalesPerson::find($id);
        return view('pages.sale-person.edit', compact('salePerson'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $user = Auth::user();
        if (!$user->hasRole('admin') && !$user->can('edit-sales-person')) {
            abort(403, 'Unauthorized action.');
        }
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
        $user = Auth::user();
        if (!$user->hasRole('admin') && !$user->can('delete-sales-person')) {
            abort(403, 'Unauthorized action.');
        }
        $sale_person = SalesPerson::find($id);
        if ($sale_person) {
            $sale_person->delete();
            return redirect()->route('sales-persons.index')->with('success', 'Sales Person Delete Successfully!');
        } else {
            return redirect()->route('sales-persons.index')->with('error', 'Record not found');
        }
    }
}
