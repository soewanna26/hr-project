<?php

namespace App\Http\Controllers;

use App\Http\Requests\StorePermission;
use App\Http\Requests\UpdatePermission;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;
use Spatie\Permission\Models\Permission;

class PermissionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        if (!auth()->user()->can('view_permission')) {
            abort(403, 'Unauthorized action');
        }
        return view('permission.index');
    }

    public function ssd(Request $request)
    {
        if (!auth()->user()->can('view_permission')) {
            abort(403, 'Unauthorized action');
        }
        $permission = Permission::query();
        return DataTables::of($permission)
            ->addColumn('action', function ($each) {
                $edit_icon = '';
                $delete_icon = '';

                if (!auth()->user()->can('edit_permission')) {
                    $edit_icon = '<a href="' . route('permission.edit', $each->id) . '" class="text-warning"><i class="fas fa-edit"></i></a>';
                }
                if (!auth()->user()->can('delete_permission')) {

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
            ->rawColumns(['action'])
            ->make(true);
    }
    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        if (!auth()->user()->can('create_permission')) {
            abort(403, 'Unauthorized action');
        }
        return view('permission.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StorePermission $request)
    {
        if (!auth()->user()->can('create_permission')) {
            abort(403, 'Unauthorized action');
        }
        $permission = new Permission;
        $permission->name = $request->name;
        $permission->save();

        return redirect()->route('permission.index')->with('create', 'Permission Created Successfully');
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
        if (!auth()->user()->can('edit_permission')) {
            abort(403, 'Unauthorized action');
        }
        $permission = Permission::findOrFail($id);
        return view('permission.edit', compact('permission'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdatePermission $request, $id)
    {
        if (!auth()->user()->can('edit_permission')) {
            abort(403, 'Unauthorized action');
        }
        $permission = Permission::findOrFail($id);
        $permission->name = $request->name;
        $permission->update();

        return redirect()->route('permission.index')->with('edit', 'Permission Updated Successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        if (!auth()->user()->can('delete_permission')) {
            abort(403, 'Unauthorized action');
        }
        Permission::findOrFail($id)->delete();
        return 'success';
    }
}
