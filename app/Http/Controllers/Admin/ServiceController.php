<?php

namespace App\Http\Controllers\Admin;

use App\Models\Service;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;
use Yajra\DataTables\Facades\DataTables;

class ServiceController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = Service::query();
            return DataTables::of($data)
                ->addColumn('image', function ($row) {
                    $imagePath = asset('storage/service/' . ($row->image ?? 'avatar.png'));
                    return '<img src="' . $imagePath . '" alt="Service" width="90" height="60" class="img-thumbnail" />';
                })
                ->addColumn('status', function ($row) {
                    return $row->status === 'active'
                        ? '<span class="badge bg-success">Active</span>'
                        : '<span class="badge bg-danger">Inactive</span>';
                })
                ->addColumn('action', function ($row) {
                    $editUrl = route('services.edit', $row->id);
                    $deleteUrl = route('services.destroy', $row->id);

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

        return view('pages.services.index');
    }

    public function create()
    {
        return view('pages.services.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'link' => 'nullable|string|max:255',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'date' => 'required|date',
            'status' => 'required|in:active,inactive',
        ]);

        $req_data = $request->all();

        if ($request->hasFile('image')) {
            $image = storeFile($request->file('image'), 'storage/service/');
        } else {
            $image = 'avatar.png';
        }

        $req_data['image'] = $image;
        Service::create($req_data);

        if ($request->ajax()) {
            return response()->json(['success' => true]);
        }

        return redirect()->route('services.index')
            ->with('success', 'Service created successfully.');
    }

    public function edit(Service $service)
    {
        return view('pages.services.edit', compact('service'));
    }

    public function update(Request $request, Service $service)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'link' => 'nullable|string|max:255',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'date' => 'required|date',
            'status' => 'required|in:active,inactive',
        ]);

        $req_data = $request->all();

        if ($request->hasFile('image')) {
            // Delete old image if it exists and is not the default avatar
            if ($service->image && $service->image != 'avatar.png') {
                if (file_exists(public_path('storage/service/' . $service->image))) {
                    unlink(public_path('storage/service/' . $service->image));
                }
            }
            $image = storeFile($request->file('image'), 'storage/service/');
            $req_data['image'] = $image;
        }

        $service->update($req_data);

        if ($request->ajax()) {
            return response()->json(['success' => true]);
        }

        return redirect()->route('services.index')
            ->with('success', 'Service updated successfully.');
    }

    public function destroy(Service $service)
    {
        // Delete image if it exists and is not the default avatar
        if ($service->image && $service->image != 'avatar.png') {
            if (file_exists(public_path('storage/service/' . $service->image))) {
                unlink(public_path('storage/service/' . $service->image));
            }
        }

        $service->delete();

        return redirect()->route('services.index')
            ->with('success', 'Service deleted successfully.');
    }
}
