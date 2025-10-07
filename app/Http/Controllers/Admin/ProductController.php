<?php

namespace App\Http\Controllers\Admin;

use App\Models\Product;
use App\Models\Categories;
use App\Models\SubCategory;
use Illuminate\Http\Request;
use GuzzleHttp\Handler\Proxy;
use App\Http\Controllers\Controller;
use Yajra\DataTables\Facades\DataTables;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
public function index(Request $request)
{
    if ($request->ajax()) {
        $data = Product::with(['category', 'subCategory'])
            ->select(['id', 'image', 'name', 'category_id', 'sub_category_id', 'code', 'price', 'warranty', 'date', 'status']);

        return DataTables::of($data)
            ->addIndexColumn()
            ->addColumn('image', function ($row) {
                $imagePath = asset('storage/product/' . ($row->image ?? 'avatar.png'));
                return '<img src="' . $imagePath . '" alt="Product" width="80" height="50" class="img-thumbnail" />';
            })
            ->addColumn('category', function ($row) {
                return $row->category->name ?? '-';
            })
            ->addColumn('sub_category', function ($row) {
                return $row->subCategory->name ?? '-';
            })
            ->addColumn('status', function ($row) {
                return $row->status === 'active'
                    ? '<span class="badge bg-success">Active</span>'
                    : '<span class="badge bg-danger">Inactive</span>';
            })
            ->addColumn('action', function ($row) {
                $editUrl = route('products.edit', $row->id);
                $deleteUrl = route('products.destroy', $row->id);

                return '
                <div class="dropdown d-inline-block">
                    <button class="btn btn-soft-secondary btn-sm dropdown" type="button"
                        data-bs-toggle="dropdown" aria-expanded="false">
                        <i class="ri-more-fill align-middle"></i>
                    </button>
                    <ul class="dropdown-menu dropdown-menu-end">
                        <li>
                            <a href="' . $editUrl . '" class="dropdown-item edit-item-btn">
                                <i class="ri-pencil-fill align-bottom me-2 text-muted"></i> Edit
                            </a>
                        </li>
                        <li>
                            <form action="' . $deleteUrl . '" method="POST" style="display:inline;">
                                ' . csrf_field() . method_field('DELETE') . '
                                <button type="button" class="dropdown-item remove-item-btn show-confirm">
                                    <i class="ri-delete-bin-fill align-bottom me-2 text-muted"></i> Delete
                                </button>
                            </form>
                        </li>
                    </ul>
                </div>
                ';
            })
            ->rawColumns(['image', 'status', 'action'])
            ->make(true);
    }

    return view('pages.product.index');
}


    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $categories = Categories::pluck('name', 'id');
        return view('pages.product.create',compact('categories'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'price' =>'required',
            'category_id' => 'required',
            'sub_category_id' => 'required',
        ]);
        $req_data = $request->all();
        if ($request->hasFile('image')) {

            $image = storeFile($request->file('image'), 'storage/product/');
        } else {
            $image = 'avatar.png';
        }
        $req_data['image'] = $image;
        Product::create($req_data);
        return redirect()->route('products.index')
            ->with('success', 'Product Created Successfully');
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
        $product = Product::find($id);
        $categories = Categories::pluck('name', 'id');
        $subCategories = SubCategory::where('category_id', $product->category_id)->pluck('name', 'id');
        return view('pages.product.edit',compact('categories','product','subCategories'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'price' =>'required',
            'category_id' => 'required',
            'sub_category_id' => 'required',
        ]);
        $product = Product::findOrFail($id);
        $req_data = $request->all();
        if ($request->hasFile('image')) {
            if ($product->image && $product->image != 'avatar.png') {
                $oldPath = public_path('storage/prodduct/' . $product->image);
                if (file_exists($oldPath)) {
                    unlink($oldPath);
                }
            }
            $image = storeFile($request->file('image'), 'storage/carManufacture/');
            $req_data['image'] = $image;
        } else {
            $req_data['image'] = $product->image;
        }
        $product->update($req_data);
        return redirect()->route('products.index')
            ->with('success', 'Product Updated Successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $product = Product::find($id);
        if ($product) {
            $product->delete();
            return redirect()->route('products.index')->with('success', 'Product Delete Successfully!');
        } else {
            return redirect()->route('products.index')->with('error', 'Record not found');
        }
    }
}
