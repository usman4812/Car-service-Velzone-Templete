<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Models\CarManufactures;
use App\Http\Controllers\Controller;

class CarManufacturesController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $carManufactures = CarManufactures::all();
        return view('pages.car-manufacture.index', compact('carManufactures'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('pages.car-manufacture.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
        ]);
        $req_data = $request->all();
        if ($request->hasFile('image')) {

            $image = storeFile($request->file('image'), 'storage/carManufacture/');
        } else {
            $image = 'avatar.png';
        }
        $req_data['image'] = $image;
        CarManufactures::create($req_data);
        return redirect()->route('car-manufactures.index')
            ->with('success', 'Car Manufacture Created Successfully');
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
        $carManufacture = CarManufactures::find($id);
        return view('pages.car-manufacture.edit', compact('carManufacture'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|max:255',
        ]);
        $carManufacture = CarManufactures::findOrFail($id);
        $req_data = $request->all();
        if ($request->hasFile('image')) {
            if ($carManufacture->image && $carManufacture->image != 'avatar.png') {
                $oldPath = public_path('storage/carManufacture/' . $carManufacture->image);
                if (file_exists($oldPath)) {
                    unlink($oldPath);
                }
            }
            $image = storeFile($request->file('image'), 'storage/carManufacture/');
            $req_data['image'] = $image;
        } else {
            $req_data['image'] = $carManufacture->image;
        }
        $carManufacture->update($req_data);
        return redirect()->route('car-manufactures.index')
            ->with('success', 'Car Manufacture Updated Successfully');
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $carMenufacture = CarManufactures::find($id);
        if ($carMenufacture) {
            $carMenufacture->delete();
            return redirect()->route('car-manufactures.index')->with('success', 'Car Manufacture Delete Successfully!');
        } else {
            return redirect()->route('car-manufactures.index')->with('error', 'Record not found');
        }
    }
}
