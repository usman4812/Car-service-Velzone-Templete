<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Yajra\DataTables\Facades\DataTables;

class RoleController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = \Spatie\Permission\Models\Role::query();
            return DataTables::of($data)
                ->addColumn('permissions_count', function ($row) {
                    return $row->permissions->count();
                })
                ->addColumn('action', function ($row) {
                    $editUrl = route('roles.edit', $row->id);
                    $deleteUrl = route('roles.destroy', $row->id);

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
                ->rawColumns(['action'])
                ->make(true);
        }

        return view('pages.roles.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $permissions = \Spatie\Permission\Models\Permission::all()->groupBy(function ($permission) {
            return explode('-', $permission->name)[0];
        });

        return view('pages.roles.create', compact('permissions'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:roles,name',
            'permissions' => 'required|array',
            'permissions.*' => 'exists:permissions,id',
        ]);

        $req_data = $request->all();

        $role = \Spatie\Permission\Models\Role::create(['name' => $req_data['name'], 'guard_name' => 'web']);

        if (isset($req_data['permissions'])) {
            $permissions = \Spatie\Permission\Models\Permission::whereIn('id', $req_data['permissions'])->get();
            $role->syncPermissions($permissions);
        }

        if ($request->ajax()) {
            return response()->json(['success' => true]);
        }

        return redirect()->route('roles.index')
            ->with('success', 'Role created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(\Spatie\Permission\Models\Role $role)
    {
        $role->load('permissions');
        return view('pages.roles.show', compact('role'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(\Spatie\Permission\Models\Role $role)
    {
        $permissions = \Spatie\Permission\Models\Permission::all()->groupBy(function ($permission) {
            return explode('-', $permission->name)[0];
        });

        $role->load('permissions');

        return view('pages.roles.edit', compact('role', 'permissions'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, \Spatie\Permission\Models\Role $role)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:roles,name,' . $role->id,
            'permissions' => 'required|array',
            'permissions.*' => 'exists:permissions,id',
        ]);

        $req_data = $request->all();

        $role->update(['name' => $req_data['name']]);

        if (isset($req_data['permissions'])) {
            $permissions = \Spatie\Permission\Models\Permission::whereIn('id', $req_data['permissions'])->get();
            $role->syncPermissions($permissions);
        } else {
            $role->syncPermissions([]);
        }

        if ($request->ajax()) {
            return response()->json(['success' => true]);
        }

        return redirect()->route('roles.index')
            ->with('success', 'Role updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request, \Spatie\Permission\Models\Role $role)
    {
        // Don't allow deletion of default roles
        if (in_array($role->name, ['admin', 'manager', 'user'])) {
            if ($request->ajax()) {
                return response()->json(['success' => false, 'message' => 'Cannot delete default roles.'], 403);
            }
            return redirect()->route('roles.index')->with('error', 'Cannot delete default roles.');
        }

        $role->delete();

        if ($request->ajax()) {
            return response()->json(['success' => true, 'message' => 'Role deleted successfully.']);
        }

        return redirect()->route('roles.index')
            ->with('success', 'Role deleted successfully.');
    }
}
