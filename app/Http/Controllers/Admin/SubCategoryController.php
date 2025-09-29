<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Categories;
use App\Models\SubCategory;
use Illuminate\Http\Request;

class SubCategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $subCategories = SubCategory::all();
        return view('pages.sub-category.index', compact('subCategories'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $categories = Categories::pluck('name', 'id');
        return view('pages.sub-category.create', compact('categories'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
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
        $subCategory = SubCategory::findOrFail($id);
        $categories = Categories::pluck('name', 'id');
        return view('pages.sub-category.edit', compact('subCategory', 'categories'));
    }


    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
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
        $subCategory = SubCategory::findOrFail($id);
        if ($subCategory) {
            $subCategory->delete();
            return redirect()->route('sub-categories.index')->with('success', 'Sub Category Delete Successfully!');
        } else {
            return redirect()->route('sub-categories.index')->with('error', 'Record not found');
        }

    }
}
