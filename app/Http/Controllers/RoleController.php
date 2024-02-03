<?php

namespace App\Http\Controllers;

use App\Http\Requests\UpdateRole;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Requests\StoreRole;
use Yajra\DataTables\DataTables;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RoleController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        if (!auth()->user()->can('view_role')) {
            abort(403, 'Unauthorized action');
        }
        return view('role.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function ssd(Request $request)
    {
        if (!auth()->user()->can('view_role')) {
            abort(403, 'Unauthorized action');
        }
        $role = Role::query();
        return DataTables::of($role)
            ->addColumn('permissions', function ($each) {
                $output = '';
                foreach ($each->permissions as $permission) {
                    $output .= '<span class="badge badge-pill badge-primary m-1">' . $permission->name . '</span>';
                }
                return $output;
            })
            ->addColumn('action', function ($each) {
                $edit_icon = '';
                $delete_icon = '';

                if (auth()->user()->can('edit_role')) {
                    $edit_icon = '<a href="' . route('role.edit', $each->id) . '" class="text-warning"><i class="fas fa-edit"></i></a>';
                }
                if (auth()->user()->can('delete_role')) {

                    $delete_icon = '<a href="#" class="text-danger delete-btn" data-id="' . $each->id . '"><i class="fas fa-trash-alt"></i></a>';
                }



                return '<div class="action-icon">'  . $edit_icon . $delete_icon . '</div>';
            })
            ->editColumn('updated_at', function ($each) {
                return Carbon::parse($each->updated_at)->format('Y-m-d H:i:s');
            })
            ->addColumn('plus_icon', function ($each) {
                return null;
            })
            ->rawColumns(['action', 'permissions'])
            ->make(true);
    }
    public function create()
    {
        if (!auth()->user()->can('create_role')) {
            abort(403, 'Unauthorized action');
        }
        $permissions = Permission::all();
        return view('role.create', compact('permissions'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreRole $request)
    {
        if (!auth()->user()->can('create_role')) {
            abort(403, 'Unauthorized action');
        }
        $role = new Role;
        $role->name = $request->name;
        $role->save();
        $role->givePermissionTo($request->permissions);

        return redirect()->route('role.index')->with('create', 'Successfully Create Role');
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
    public function edit($id)
    {
        if (!auth()->user()->can('edit_role')) {
            abort(403, 'Unauthorized action');
        }
        $role = Role::findOrFail($id);
        $old_permissions = $role->permissions->pluck('id')->toArray();
        $permissions = Permission::all();
        return view('role.edit', compact('role', 'permissions', 'old_permissions'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateRole $request, $id)
    {
        if (!auth()->user()->can('edit_role')) {
            abort(403, 'Unauthorized action');
        }
        $role = Role::findOrFail($id);
        $role->name = $request->name;
        $role->update();

        $role->syncPermissions($request->permissions);
        return redirect()->route('role.index')->with('edit', 'Successfully Edit Role');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        if (!auth()->user()->can('delete_role')) {
            abort(403, 'Unauthorized action');
        }
        $role = Role::findOrFail($id);
        $role->delete();
        return 'success';
    }
}
