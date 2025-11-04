<?php

namespace App\Http\Controllers\Admin;

use App\Models\Categories;
use App\Models\SubCategory;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Yajra\DataTables\Facades\DataTables;

class SubCategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = SubCategory::with('category:id,name')->select(['id', 'category_id', 'name', 'date', 'status']);
            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('category_name', function ($row) {
                    return $row->category ? $row->category->name : '-';
                })
                ->addColumn('status', function ($row) {
                    return $row->status == 'active'
                        ? '<span class="badge bg-success">Active</span>'
                        : '<span class="badge bg-danger">Inactive</span>';
                })
                ->addColumn('action', function ($row) {
                    $user = Auth::user();
                    $canEdit = $user->hasRole('admin') || $user->can('edit-sub-category');
                    $canDelete = $user->hasRole('admin') || $user->can('delete-sub-category');

                    $editUrl = route('sub-categories.edit', $row->id);
                    $deleteUrl = route('sub-categories.destroy', $row->id);

                    $html = '<div class="dropdown d-inline-block">
                        <button class="btn btn-soft-secondary btn-sm dropdown" type="button" data-bs-toggle="dropdown" aria-expanded="false">
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

        return view('pages.sub-category.index');
    }


    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $user = Auth::user();
        if (!$user->hasRole('admin') && !$user->can('create-sub-category')) {
            abort(403, 'Unauthorized action.');
        }
        $categories = Categories::pluck('name', 'id');
        return view('pages.sub-category.create', compact('categories'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $user = Auth::user();
        if (!$user->hasRole('admin') && !$user->can('create-sub-category')) {
            abort(403, 'Unauthorized action.');
        }
        $request->validate([
            'name' => 'required|string|max:255',
            'category_id' => 'required',
        ]);
        $req_data = $request->all();
        SubCategory::create($req_data);
        return redirect()->route('sub-categories.index')
            ->with('success', 'Sub Category Created Successfully');
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
    public function edit($id)
    {
        $user = Auth::user();
        if (!$user->hasRole('admin') && !$user->can('edit-sub-category')) {
            abort(403, 'Unauthorized action.');
        }
        $subCategory = SubCategory::findOrFail($id);
        $categories = Categories::pluck('name', 'id');
        return view('pages.sub-category.edit', compact('subCategory', 'categories'));
    }


    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $user = Auth::user();
        if (!$user->hasRole('admin') && !$user->can('edit-sub-category')) {
            abort(403, 'Unauthorized action.');
        }
        $request->validate([
            'name' => 'required|string|max:255',
            'category_id' => 'required',
        ]);
        $subCategory = SubCategory::findOrFail($id);
        $req_data = $request->all();
        $subCategory->update($req_data);
        return redirect()->route('sub-categories.index')
            ->with('success', 'Sub Category Updated Successfully!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $user = Auth::user();
        if (!$user->hasRole('admin') && !$user->can('delete-sub-category')) {
            abort(403, 'Unauthorized action.');
        }
        $subCategory = SubCategory::findOrFail($id);
        if ($subCategory) {
            $subCategory->delete();
            return redirect()->route('sub-categories.index')->with('success', 'Sub Category Delete Successfully!');
        } else {
            return redirect()->route('sub-categories.index')->with('error', 'Record not found');
        }
    }
}
