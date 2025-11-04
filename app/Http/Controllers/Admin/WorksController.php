<?php

namespace App\Http\Controllers\Admin;

use App\Models\Work;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Yajra\DataTables\Facades\DataTables;

class WorksController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = Work::query();
            return DataTables::of($data)
                ->addColumn('image', function ($row) {
                    $imagePath = asset('storage/work/' . ($row->image ?? 'avatar.png'));
                    return '<img src="' . $imagePath . '" alt="Work" width="90" height="60" class="img-thumbnail" />';
                })
                ->addColumn('status', function ($row) {
                    return $row->status === 'active'
                        ? '<span class="badge bg-success">Active</span>'
                        : '<span class="badge bg-danger">Inactive</span>';
                })
                ->addColumn('action', function ($row) {
                    $user = Auth::user();
                    $canEdit = $user->hasRole('admin') || $user->can('edit-work');
                    $canDelete = $user->hasRole('admin') || $user->can('delete-work');

                    $editUrl = route('works.edit', $row->id);
                    $deleteUrl = route('works.destroy', $row->id);

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
                ->rawColumns(['image', 'status', 'action'])
                ->make(true);
        }

        return view('pages.works.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $user = Auth::user();
        if (!$user->hasRole('admin') && !$user->can('create-work')) {
            abort(403, 'Unauthorized action.');
        }
        return view('pages.works.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $user = Auth::user();
        if (!$user->hasRole('admin') && !$user->can('create-work')) {
            abort(403, 'Unauthorized action.');
        }
        $request->validate([
            'title' => 'required|string|max:255',
            'type' => 'required|string|max:255',
            'date' => 'required|date',
            'status' => 'required|in:active,inactive',
        ]);
        $req_data = $request->all();
        if ($request->hasFile('image')) {
            $image = storeFile($request->file('image'), 'storage/work/');
        } else {
            $image = 'avatar.png';
        }
        $req_data['image'] = $image;
        Work::create($req_data);
        if ($request->ajax()) {
            return response()->json(['success' => true]);
        }
        return redirect()->route('works.index')
            ->with('success', 'Work created successfully.');
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
        public function edit(Work $work)
    {
        $user = Auth::user();
        if (!$user->hasRole('admin') && !$user->can('edit-work')) {
            abort(403, 'Unauthorized action.');
        }
        return view('pages.works.edit', compact('work'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Work $work)
    {
        $user = Auth::user();
        if (!$user->hasRole('admin') && !$user->can('edit-work')) {
            abort(403, 'Unauthorized action.');
        }
        $request->validate([
            'title' => 'required|string|max:255',
            'type' => 'required|string|max:255',
            'date' => 'required|date',
            'status' => 'required|in:active,inactive',
        ]);
        $req_data = $request->all();
        if ($request->hasFile('image')) {
            $image = storeFile($request->file('image'), 'storage/work/');
            $req_data['image'] = $image;
        }
        $work->update($req_data);
        if ($request->ajax()) {
            return response()->json(['success' => true]);
        }
        return redirect()->route('works.index')
            ->with('success', 'Work updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Work $work)
    {
        $user = Auth::user();
        if (!$user->hasRole('admin') && !$user->can('delete-work')) {
            abort(403, 'Unauthorized action.');
        }
        if ($work->image && $work->image != 'avatar.png') {
            if (file_exists(public_path('storage/work/' . $work->image))) {
                unlink(public_path('storage/work/' . $work->image));
            }
        }
        $work->delete();
        return redirect()->route('works.index')
            ->with('success', 'Work deleted successfully.');
    }
}
