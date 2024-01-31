<?php

namespace App\Http\Controllers;

use App\Http\Requests\UpdateRole;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Requests\StoreRole;
use Yajra\DataTables\DataTables;
use Spatie\Permission\Models\Role;

class RoleController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('role.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function ssd(Request $request)
    {
        $role = Role::query();
        return DataTables::of($role)
            ->addColumn('action', function ($each) {
                $edit_icon = '<a href="' . route('role.edit', $each->id) . '" class="text-warning"><i class="fas fa-edit"></i></a>';
                $delete_icon = '<a href="#" class="text-danger delete-btn" data-id="' . $each->id . '"><i class="fas fa-trash-alt"></i></a>';

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
    public function create()
    {
        return view('role.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreRole $request)
    {
        $role = new Role;
        $role->name = $request->name;
        $role->save();

        return redirect()->route('role.index')->with('create','Successfully Create Role');
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
        $role = Role::findOrFail($id);
        return view('role.edit',compact('role'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateRole $request,$id)
    {
        $role = Role::findOrFail($id);
        $role->name = $request->name;
        $role->update();

        return redirect()->route('role.index')->with('edit','Successfully Edit Role');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $role = Role::findOrFail($id);
        $role->delete();
        return 'success';
    }
}
