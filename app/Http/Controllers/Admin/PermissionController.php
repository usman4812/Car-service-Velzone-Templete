<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Permission;
use Yajra\DataTables\Facades\DataTables;

class PermissionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = \Spatie\Permission\Models\Permission::query();
            return DataTables::of($data)
                ->addColumn('module', function ($row) {
                    return ucfirst(explode('-', $row->name)[0]);
                })
                ->addColumn('action_name', function ($row) {
                    $parts = explode('-', $row->name);
                    return count($parts) > 1 ? ucfirst($parts[1]) : ucfirst($row->name);
                })
                ->make(true);
        }

        return view('pages.permissions.index');
    }
}
