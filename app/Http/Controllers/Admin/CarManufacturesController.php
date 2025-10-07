<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Models\CarManufactures;
use App\Http\Controllers\Controller;
use Yajra\DataTables\Facades\DataTables;

class CarManufacturesController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = CarManufactures::select(['id', 'image', 'name', 'date', 'status']);
            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('image', function ($row) {
                    $imagePath = asset('storage/carManufacture/' . ($row->image ?? 'avatar.png'));
                    return '<img src="' . $imagePath . '" alt="Car" width="90" height="60" class="img-thumbnail" />';
                })
                ->addColumn('status', function ($row) {
                    return $row->status === 'active'
                        ? '<span class="badge bg-success">Active</span>'
                        : '<span class="badge bg-danger">Inactive</span>';
                })
                ->addColumn('action', function ($row) {
                    $editUrl = route('car-manufactures.edit', $row->id);
                    $deleteUrl = route('car-manufactures.destroy', $row->id);

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
        return view('pages.car-manufacture.index');
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
