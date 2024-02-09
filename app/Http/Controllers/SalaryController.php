<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreSalary;
use App\Http\Requests\UpdateSalary;
use App\Models\Salary;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;

class SalaryController extends Controller
{
    public function index()
    {
        if (!auth()->user()->can('view_salary')) {
            abort(403, 'Unauthorized action');
        }
        return view('salary.index');
    }

    public function ssd(Request $request)
    {
        if (!auth()->user()->can('view_salary')) {
            abort(403, 'Unauthorized action');
        }
        $salary = Salary::with('employee');
        $currentYear = date('Y');
        return DataTables::of($salary)
            ->filterColumn('employee_name', function ($query, $keyword) {
                $query->whereHas('employee', function ($q1) use ($keyword) {
                    $q1->where('name', 'LIKE', '%' . $keyword . '%');
                });
            })
            ->addColumn('employee_name', function ($each) {
                return $each->employee ? $each->employee->name : "-";
            })
            ->addColumn('action', function ($each) {
                $edit_icon = '';
                $delete_icon = '';

                if (auth()->user()->can('edit_salary')) {
                    $edit_icon = '<a href="' . route('salary.edit', $each->id) . '" class="text-warning"><i class="fas fa-edit"></i></a>';
                }
                if (auth()->user()->can('delete_salary')) {

                    $delete_icon = '<a href="#" class="text-danger delete-btn" data-id="' . $each->id . '"><i class="fas fa-trash-alt"></i></a>';
                }

                return '<div class="action-icon">'  . $edit_icon . $delete_icon . '</div>';
            })
            ->editColumn('month', function ($each) use ($currentYear) {
                return Carbon::parse($currentYear . '-' . $each->month . '-01')->format('M');
            })
            ->editColumn('amount', function ($each) {
                return number_format($each->amount);
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
        if (!auth()->user()->can('create_salary')) {
            abort(403, 'Unauthorized action');
        }
        $employees = User::orderBy('employee_id')->get();
        return view('salary.create', compact('employees'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreSalary $request)
    {
        if (!auth()->user()->can('create_salary')) {
            abort(403, 'Unauthorized action');
        }
        $salary = new Salary();
        $salary->user_id = $request->user_id;
        $salary->month = $request->month;
        $salary->year = $request->year;
        $salary->amount = $request->amount;
        $salary->save();
        return redirect()->route('salary.index')->with('create', 'Successfully Created Salary');
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        if (!auth()->user()->can('edit_salary')) {
            abort(403, 'Unauthorized action');
        }
        $salary = Salary::findOrFail($id);
        $employees = User::orderBy('employee_id')->get();
        return view('salary.edit', compact('salary','employees'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update($id, UpdateSalary $request)
    {
        if (!auth()->user()->can('edit_salary')) {
            abort(403, 'Unauthorized action');
        }
        $salary = Salary::findOrFail($id);
        $salary->user_id = $request->user_id;
        $salary->month = $request->month;
        $salary->year = $request->year;
        $salary->amount = $request->amount;
        $salary->update();
        return redirect()->route('salary.index')->with('edit', 'Successfully Edit Salary');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        if (!auth()->user()->can('delete_salary')) {
            abort(403, 'Unauthorized action');
        }
        $salary = Salary::findOrFail($id)->delete();
        return 'success';
    }
}
