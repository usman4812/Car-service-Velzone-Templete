<?php

namespace App\Http\Controllers\Admin;

use App\Models\Blog;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Yajra\DataTables\Facades\DataTables;

class BlogController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = Blog::query();
            return DataTables::of($data)
                ->addColumn('image', function ($row) {
                    $imagePath = asset('storage/blog/' . ($row->image ?? 'avatar.png'));
                    return '<img src="' . $imagePath . '" alt="Blog" width="110" height="80" class="img-thumbnail" />';
                })
                ->addColumn('status', function ($row) {
                    return $row->status === 'active'
                        ? '<span class="badge bg-success">Active</span>'
                        : '<span class="badge bg-danger">Inactive</span>';
                })
                ->addColumn('action', function ($row) {
                    $editUrl = route('blog.edit', $row->id);
                    $deleteUrl = route('blog.destroy', $row->id);

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

        return view('pages.blog.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('pages.blog.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'meta_keyword' => 'nullable|string|max:255',
            'meta_description' => 'nullable|string',
            'date' => 'nullable|date',
            'status' => 'required|in:active,inactive',
        ]);
        $req_data = $request->all();
        if ($request->hasFile('image')) {
            $image = storeFile($request->file('image'), 'storage/blog/');
        } else {
            $image = 'avatar.png';
        }
        $req_data['image'] = $image;
        Blog::create($req_data);
        if ($request->ajax()) {
            return response()->json(['success' => true]);
        }else{
            return redirect()->route('blog.index')->with('success', 'Blog created successfully.');
        }
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
        $blog = Blog::find($id);
        return view('pages.blog.edit', compact('blog'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'meta_keyword' => 'nullable|string|max:255',
            'meta_description' => 'nullable|string',
            'date' => 'nullable|date',
            'status' => 'required|in:active,inactive',
        ]);
        $req_data = $request->all();
        if ($request->hasFile('image')) {
            $image = storeFile($request->file('image'), 'storage/blog/');
            $req_data['image'] = $image;
        }
        $blog = Blog::find($id);
        if (!$blog) {
            return redirect()->route('blog.index')->with('error', 'Blog not found.');
        }
        $blog->update($req_data);
        if ($request->ajax()) {
            return response()->json(['success' => true]);
        }else{
            return redirect()->route('blog.index')->with('success', 'Blog updated successfully.');
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request, string $id)
    {
        $blog = Blog::find($id);
        if (!$blog) {
            return redirect()->route('blog.index')->with('error', 'Blog not found.');
        }
        $blog->delete();
        if ($request->ajax()) {
            return response()->json(['success' => true]);
        }else{
            return redirect()->route('blog.index')->with('success', 'Blog deleted successfully.');
        }
    }
}
