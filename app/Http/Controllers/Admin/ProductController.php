<?php

namespace App\Http\Controllers\Admin;

use App\Models\Product;
use App\Models\Categories;
use App\Models\SubCategory;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use GuzzleHttp\Handler\Proxy;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $products = Product::all();
        return view('pages.product.index', compact('products'));
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
