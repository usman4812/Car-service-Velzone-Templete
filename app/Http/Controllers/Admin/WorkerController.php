<?php

namespace App\Http\Controllers\Admin;

use App\Models\Worker;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Yajra\DataTables\Facades\DataTables;

class WorkerController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = Worker::query();
            return DataTables::of($data)
                ->addColumn('image', function ($row) {
                    $imagePath = asset('storage/worker/' . ($row->image ?? 'avatar.png'));
                    return '<img src="' . $imagePath . '" alt="Worker" width="90" height="60" class="img-thumbnail" />';
                })
                ->addColumn('status', function ($row) {
                    return $row->status === 'active'
                        ? '<span class="badge bg-success">Active</span>'
                        : '<span class="badge bg-danger">Inactive</span>';
                })
                ->addColumn('action', function ($row) {
                    $editUrl = route('workers.edit', $row->id);
                    $deleteUrl = route('workers.destroy', $row->id);

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

        return view('pages.workers.index');
    }

    public function create()
    {
        return view('pages.workers.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'designation' => 'required|string|max:255',
            'date' => 'required|date',
            'status' => 'required|in:active,inactive',
        ]);
        $req_data = $request->all();
        if ($request->hasFile('image')) {
            $image = storeFile($request->file('image'), 'storage/worker/');
        } else {
            $image = 'avatar.png';
        }
        $req_data['image'] = $image;
        Worker::create($req_data);
        if ($request->ajax()) {
            return response()->json(['success' => true]);
        }
        return redirect()->route('workers.index')
            ->with('success', 'Worker created successfully.');
    }

    public function edit(Worker $worker)
    {
        return view('pages.workers.edit', compact('worker'));
    }

    public function update(Request $request, Worker $worker)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'designation' => 'required|string|max:255',
            'date' => 'required|date',
            'status' => 'required|in:active,inactive',
        ]);
        $req_data = $request->all();
        if ($request->hasFile('image')) {
            // Delete old image if it exists and is not the default avatar
            if ($worker->image && $worker->image != 'avatar.png') {
                if (file_exists(public_path('storage/worker/' . $worker->image))) {
                    unlink(public_path('storage/worker/' . $worker->image));
                }
            }
            $image = storeFile($request->file('image'), 'storage/worker/');
            $req_data['image'] = $image;
        }

        $worker->update($req_data);

        if ($request->ajax()) {
            return response()->json(['success' => true]);
        }

        return redirect()->route('workers.index')
            ->with('success', 'Worker updated successfully.');
    }

    public function destroy(Worker $worker)
    {
        // Delete image if it exists and is not the default avatar
        if ($worker->image && $worker->image != 'avatar.png') {
            if (file_exists(public_path('storage/worker/' . $worker->image))) {
                unlink(public_path('storage/worker/' . $worker->image));
            }
        }

        $worker->delete();
        return redirect()->route('workers.index')
            ->with('success', 'Worker deleted successfully.');
    }
}
