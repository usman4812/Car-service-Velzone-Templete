<?php

namespace App\Http\Controllers\Admin;

use App\Models\Product;
use App\Models\SubCategory;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Categories;

class AjaxController extends Controller
{
    public function getSubCategories($category_id)
    {
        $subcategories = SubCategory::where('category_id', $category_id)->pluck('name', 'id');
        return response()->json($subcategories);
    }

    public function getProducts($subcategory_id)
    {
        $products = Product::where('sub_category_id', $subcategory_id)->pluck('name', 'id');
        return response()->json($products);
    }

    public function getProductPrice($product_id)
    {
        $product = Product::find($product_id);
        if ($product) {
            return response()->json([
                'price' => $product->price,
            ]);
        }
        return response()->json(['price' => 0]);
    }

    public function getNewItemRow()
    {
        $categories = Categories::pluck('name', 'id');
        $html = view('pages.job-card.item_row', compact('categories'))->render();

        return response()->json(['html' => $html]);
    }
}
