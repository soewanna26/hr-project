<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\User;
use App\Models\Department;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;
use Illuminate\Routing\Controller;
use App\Http\Requests\StoreEmployee;
use Illuminate\Support\Facades\Hash;
use App\Http\Requests\UpdateEmployee;
use Illuminate\Support\Facades\Storage;
use Spatie\Permission\Models\Role;

class EmployeeController extends Controller
{
    public function index()
    {
        if (!auth()->user()->can('view_employee')) {
            abort(403, 'Unauthorized action');
        }
        return view('employee.index');
    }

    // Data tables
    public function ssd(Request $request)
    {
        if (!auth()->user()->can('view_employee')) {
            abort(403, 'Unauthorized action');
        }
        $employee = User::with('department');

        return DataTables::of($employee)
            ->filterColumn('department_name', function ($query, $keyword) {
                $query->whereHas('department', function ($q1) use ($keyword) {
                    $q1->where('title', 'like', '%' . $keyword . '%');
                });
            })
            ->addColumn('profile_img', function ($each) {
                return '<img src="' . $each->profile_img_path() . '" alt="" class="profile-thumbnail"/> <p class="my-1">
                ' . $each->name . '</p>';
            })
            ->addColumn('department_name', function ($each) {
                return $each->department ? $each->department->title : '-';
            })
            ->editColumn('updated_at', function ($each) {
                return Carbon::parse($each->updated_at)->format('Y-m-d H:i:s');
            })
            ->editColumn('is_present', function ($each) {
                if ($each->is_present == 1) {
                    return '<span class="badge badge-pill badge-success">Present</span>';
                } else {
                    return '<span class="badge badge-pill badge-danger">Leave</span>';
                }
            })
            ->addColumn('action', function ($each) {
                $edit_icon = '';
                $delete_icon = '';
                $show_icon = '';

                if (auth()->user()->can('view_employee')) {
                    $show_icon = '<a href="' . route('employee.show', $each->id) . '" class="text-primary"><i class="fas fa-info-circle"></i></a>';
                }
                if (auth()->user()->can('edit_employee')) {
                    $edit_icon = '<a href="' . route('employee.edit', $each->id) . '" class="text-warning"><i class="fas fa-edit"></i></a>';
                }
                if (auth()->user()->can('delete_employee')) {
                    $delete_icon = '<a href="#" class="text-danger delete-btn" data-id="' . $each->id . '"><i class="fas fa-trash-alt"></i></a>';
                }



                return '<div class="action-icon">' . $show_icon  . $edit_icon . $delete_icon . '</div>';
            })
            ->addColumn('plus_icon', function ($each) {
                return null;
            })
            ->addColumn('role_name', function ($each) {
                $output = '';
                foreach ($each->roles as $role) {
                    $output .= '<span class="badge badge-pill badge-primary m-1">' . $role->name . '</span>';
                }
                return $output;
            })
            ->rawColumns(['is_present', 'role_name', 'action', 'profile_img'])
            ->make(true);
    }
    public function create()
    {
        if (!auth()->user()->can('create_employee')) {
            abort(403, 'Unauthorized action');
        }
        $roles = Role::all();
        $departments = Department::orderBy('title')->get();
        return view('employee.create', compact('departments', 'roles'));
    }

    public function store(StoreEmployee $request)
    {
        if (!auth()->user()->can('create_employee')) {
            abort(403, 'Unauthorized action');
        }
        $profile_img_name = null;
        if ($request->hasFile('profile_img')) {
            $profile_img_file = $request->file('profile_img');
            $profile_img_name = uniqid() . '_' . time() . '.' . $profile_img_file->getClientOriginalExtension();
            Storage::disk('public')->put('employee/' . $profile_img_name, file_get_contents($profile_img_file));
        }
        $employee = new User;
        $employee->employee_id = $request->employee_id;
        $employee->name = $request->name;
        $employee->phone = $request->phone;
        $employee->email = $request->email;
        $employee->nrc_number = $request->nrc_number;
        $employee->gender = $request->gender;
        $employee->birthday = $request->birthday;
        $employee->address = $request->address;
        $employee->department_id = $request->department_id;
        $employee->date_of_join = $request->date_of_join;
        $employee->profile_img = $profile_img_name;
        $employee->is_present = $request->is_present;
        $employee->password = Hash::make($request->password);
        $employee->save();

        // $roleIds = $request->roles; // array{0 => 1},{1 => 2}
        // // dd($roleIds);
        // $roles = Role::whereIn('id', $roleIds)->pluck('name')->toArray(); //array{0 => name},{1 => name}
        // // dd($roles);
        // $employee->syncRoles($roles);
        $employee->syncRoles($request->roles);
        return redirect()->route('employee.index')->with("create", "Successfully created employee");
    }

    public function edit($id)
    {
        if (!auth()->user()->can('edit_employee')) {
            abort(403, 'Unauthorized action');
        }
        $employee = User::findOrFail($id);
        $old_roles = $employee->roles->pluck('id')->toArray();
        $departments = Department::orderBy('title')->get();
        $roles = Role::all();
        return view('employee.edit', compact('employee', 'departments', 'roles', 'old_roles'));
    }
    public function update($id, UpdateEmployee $request)
    {
        if (!auth()->user()->can('edit_employee')) {
            abort(403, 'Unauthorized action');
        }
        $employee = User::findOrFail($id);
        $profile_img_name = $employee->profile_img;
        if ($request->hasFile('profile_img')) {
            Storage::disk('public')->delete('employee/' . $employee->profile_img);
            $profile_img_file = $request->file('profile_img');
            $profile_img_name = uniqid() . '_' . time() . '.' . $profile_img_file->getClientOriginalExtension();
            Storage::disk('public')->put('employee/' . $profile_img_name, file_get_contents($profile_img_file));
        }
        $employee->employee_id = $request->employee_id;
        $employee->name = $request->name;
        $employee->phone = $request->phone;
        $employee->email = $request->email;
        $employee->nrc_number = $request->nrc_number;
        $employee->gender = $request->gender;
        $employee->birthday = $request->birthday;
        $employee->address = $request->address;
        $employee->department_id = $request->department_id;
        $employee->date_of_join = $request->date_of_join;
        $employee->profile_img = $profile_img_name;
        $employee->is_present = $request->is_present;
        $employee->password = $request->password ? Hash::make($request->password) : $employee->password;
        $employee->update();
        $employee->syncRoles($request->roles);
        return redirect()->route('employee.index')->with("edit", "Successfully edit employee");
    }

    public function show($id)
    {
        if (!auth()->user()->can('view_employee')) {
            abort(403, 'Unauthorized action');
        }
        $employee = User::findOrFail($id);
        return view('employee.show', compact('employee'));
    }
    public function destroy($id)
    {
        if (!auth()->user()->can('delete_employee')) {
            abort(403, 'Unauthorized action');
        }
        $employee = User::findOrFail($id)->delete();
        return 'success';
    }
}
