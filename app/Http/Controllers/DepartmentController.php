<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreDepartment;
use App\Http\Requests\UpdateDepartment;
use App\Models\Department;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;

class DepartmentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        if (!auth()->user()->can('view_department')) {
            abort(403, 'Unauthorized action');
        }

        return view('department.index');
    }


    public function ssd(Request $request)
    {
        if (!auth()->user()->can('view_department')) {
            abort(403, 'Unauthorized action');
        }
        $department = Department::query();
        return DataTables::of($department)
            ->addColumn('action', function ($each) {
                $edit_icon = '';
                $delete_icon = '';

                if (auth()->user()->can('edit_department')) {
                    $edit_icon = '<a href="' . route('department.edit', $each->id) . '" class="text-warning"><i class="fas fa-edit"></i></a>';
                }
                if (auth()->user()->can('delete_department')) {

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
        if (!auth()->user()->can('create_department')) {
            abort(403, 'Unauthorized action');
        }
        return view('department.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreDepartment $request)
    {
        if (!auth()->user()->can('create_department')) {
            abort(403, 'Unauthorized action');
        }
        $department = new Department;
        $department->title = $request->title;
        $department->save();
        return redirect()->route('department.index')->with('create', 'Successfully Created Department');
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        if (!auth()->user()->can('show_department')) {
            abort(403, 'Unauthorized action');
        }
        $department = Department::findOrFail($id);
        return view('department.show', compact('department'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        if (!auth()->user()->can('edit_department')) {
            abort(403, 'Unauthorized action');
        }
        $department = Department::findOrFail($id);
        return view('department.edit', compact('department'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update($id, UpdateDepartment $request)
    {
        if (!auth()->user()->can('edit_department')) {
            abort(403, 'Unauthorized action');
        }
        $department = Department::findOrFail($id);
        $department->title = $request->title;
        $department->update();
        return redirect()->route('department.index')->with('edit', 'Successfully Edit Department');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        if (!auth()->user()->can('delete_department')) {
            abort(403, 'Unauthorized action');
        }
        $department = Department::findOrFail($id)->delete();
        return 'success';
    }
}
