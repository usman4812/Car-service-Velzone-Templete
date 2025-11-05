<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use Yajra\DataTables\Facades\DataTables;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = User::query();
            return DataTables::of($data)
                ->addColumn('image', function ($row) {
                    $imagePath = ($row->image && $row->image != 'avatar.png') ? asset('storage/user/' . $row->image) : asset('storage/user/avatar.jpg');
                    return '<img src="' . $imagePath . '" alt="' . htmlspecialchars($row->name) . '" class="img-thumbnail" style="max-width: 100px;">';
                })
                ->addColumn('roles', function ($row) {
                    return $row->roles->pluck('name')->implode(', ') ?: '-';
                })
                ->addColumn('action', function ($row) {
                    $editUrl = route('users.edit', $row->id);
                    $deleteUrl = route('users.destroy', $row->id);

                    $user = auth()->user();
                    $canEdit = $user && ($user->hasRole('admin') || $user->can('edit-user'));
                    $canDelete = $user && ($user->hasRole('admin') || $user->can('delete-user'));

                    $html = '
                    <div class="dropdown d-inline-block">
                        <button class="btn btn-soft-secondary btn-sm dropdown" type="button"
                            data-bs-toggle="dropdown" aria-expanded="false">
                            <i class="ri-more-fill align-middle"></i>
                        </button>
                        <ul class="dropdown-menu dropdown-menu-end">';

                    if ($canEdit) {
                        $html .= '
                            <li>
                                <a href="' . $editUrl . '" class="dropdown-item edit-item-btn">
                                    <i class="ri-pencil-fill align-bottom me-2 text-muted"></i> Edit
                                </a>
                            </li>';
                    }

                    if ($canDelete) {
                        $html .= '
                            <li>
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

                    $html .= '
                        </ul>
                    </div>';

                    return $html;
                })
                ->rawColumns(['action', 'image'])
                ->make(true);
        }

        return view('pages.users.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $roles = Role::all();
        return view('pages.users.create', compact('roles'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:users,email',
            'password' => 'required|string|min:8',
            'roles' => 'nullable|array',
            'roles.*' => 'exists:roles,id',
        ]);

        $req_data = $request->all();
        $roleIds = $req_data['roles'] ?? [];
        unset($req_data['roles']);
        if ($request->hasFile('image')) {
            $image = storeFile($request->file('image'), 'storage/user/');
        } else {
            $image = 'avatar.png';
        }
        $req_data['image'] = $image;
        $user = User::create($req_data);
        if (!empty($roleIds)) {
            // Convert role IDs to role names for Spatie
            $roleNames = Role::whereIn('id', $roleIds)->pluck('name')->toArray();
            $user->syncRoles($roleNames);
        }

        if ($request->ajax()) {
            return response()->json(['success' => true]);
        }

        return redirect()->route('users.index')
            ->with('success', 'User created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(User $user)
    {
        return view('pages.users.show', compact('user'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(User $user)
    {
        $roles = Role::all();
        $user->load('roles');
        return view('pages.users.edit', compact('user', 'roles'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, User $user)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:users,email,' . $user->id,
            'password' => 'nullable|string|min:8',
            'roles' => 'nullable|array',
            'roles.*' => 'exists:roles,id',
        ]);

        $req_data = $request->all();
        $roleIds = $req_data['roles'] ?? [];
        unset($req_data['roles']);

        if (empty($req_data['password'])) {
            unset($req_data['password']);
        }
        if ($request->hasFile('image')) {
            if ($user->image && $user->image != 'avatar.png') {
                $oldPath = public_path('storage/user/' . $user->image);
                if (file_exists($oldPath)) {
                    unlink($oldPath);
                }
            }
            $image = storeFile($request->file('image'), 'storage/user/');
            $req_data['image'] = $image;
        } else {
            $req_data['image'] = $user->image;
        }
        $user->update($req_data);

        // Sync roles - convert role IDs to role names for Spatie
        if (!empty($roleIds)) {
            $roleNames = Role::whereIn('id', $roleIds)->pluck('name')->toArray();
            $user->syncRoles($roleNames);
        } else {
            $user->syncRoles([]);
        }

        if ($request->ajax()) {
            return response()->json(['success' => true]);
        }

        return redirect()->route('users.index')
            ->with('success', 'User updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request, $id)
    {
        $user = User::find($id);
        if ($user) {
            $user->delete();

            if ($request->ajax()) {
                return response()->json(['success' => true, 'message' => 'User deleted successfully.']);
            }

            return redirect()->route('users.index')->with('success', 'User deleted successfully.');
        } else {
            if ($request->ajax()) {
                return response()->json(['success' => false, 'message' => 'Record not found.'], 404);
            }

            return redirect()->route('users.index')->with('error', 'Record not found');
        }
    }
}
