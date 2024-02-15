<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreAttendance;
use App\Http\Requests\UpdateAttendance;
use App\Models\CheckinCheckout;
use App\Models\CompanySetting;
use App\Models\User;
use Carbon\Carbon;
use Carbon\CarbonPeriod;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;
use PDF;

class AttendanceController extends Controller
{
    public function index()
    {
        if (!auth()->user()->can('view_attendance')) {
            abort(403, 'Unauthorized action');
        }

        return view('attendance.index');
    }


    public function ssd(Request $request)
    {
        if (!auth()->user()->can('view_attendance')) {
            abort(403, 'Unauthorized action');
        }
        $attendances = CheckinCheckout::with('employee');
        return DataTables::of($attendances)
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

                if (auth()->user()->can('edit_attendance')) {
                    $edit_icon = '<a href="' . route('attendance.edit', $each->id) . '" class="text-warning"><i class="fas fa-edit"></i></a>';
                }
                if (auth()->user()->can('delete_attendance')) {

                    $delete_icon = '<a href="#" class="text-danger delete-btn" data-id="' . $each->id . '"><i class="fas fa-trash-alt"></i></a>';
                }

                return '<div class="action-icon">'  . $edit_icon . $delete_icon . '</div>';
            })
            ->editColumn('updated_at', function ($each) {
                return $each->updated_at->toDateTimeString();
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
        if (!auth()->user()->can('create_attendance')) {
            abort(403, 'Unauthorized action');
        }
        $employees = User::orderBy('employee_id')->get();
        return view('attendance.create', compact('employees'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreAttendance $request)
    {
        if (!auth()->user()->can('create_attendance')) {
            abort(403, 'Unauthorized action');
        }
        if (CheckinCheckout::where('user_id', $request->user_id)->where('date', $request->date)->exists()) {
            return back()->withErrors(['fail' => 'Already defined'])->withInput();
        }
        $attendance = new CheckinCheckout();
        $attendance->user_id = $request->user_id;
        $attendance->date = $request->date;
        $attendance->checkin_time = $request->date . ' ' . $request->checkin_time;
        $attendance->checkout_time = $request->date . ' ' . $request->checkout_time;
        $attendance->save();
        return redirect()->route('attendance.index')->with('create', 'Successfully Created Attendance');
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        if (!auth()->user()->can('show_attendance')) {
            abort(403, 'Unauthorized action');
        }
        $attendance = CheckinCheckout::findOrFail($id);
        return view('attendance.show', compact('attendance'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        if (!auth()->user()->can('edit_attendance')) {
            abort(403, 'Unauthorized action');
        }
        $attendance = CheckinCheckout::findOrFail($id);
        $employees = User::orderBy('employee_id')->get();
        return view('attendance.edit', compact('attendance', 'employees'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update($id, UpdateAttendance $request)
    {
        if (!auth()->user()->can('edit_attendance')) {
            abort(403, 'Unauthorized action');
        }

        $attendance = CheckinCheckout::findOrFail($id);
        if (CheckinCheckout::where('user_id', $request->user_id)->where('date', $request->date)->where('id', '!=', $attendance->id)->exists()) {
            return back()->withErrors(['fail' => 'Already defined'])->withInput();
        }
        $attendance->user_id = $request->user_id;
        $attendance->date = $request->date;
        $attendance->checkin_time = $request->date . ' ' . $request->checkin_time;
        $attendance->checkout_time = $request->date . ' ' . $request->checkout_time;
        $attendance->update();
        return redirect()->route('attendance.index')->with('edit', 'Successfully Edit Attendance');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        if (!auth()->user()->can('delete_attendance')) {
            abort(403, 'Unauthorized action');
        }
        $attendance = CheckinCheckout::findOrFail($id)->delete();
        return 'success';
    }

    public function overview(Request $request)
    {
        if (!auth()->user()->can('view_attendance_overview')) {
            abort(403, 'Unauthorized action');
        }
        return view('attendance.overview');
    }

    public function overviewTable(Request $request)
    {
        if (!auth()->user()->can('view_attendance_overview')) {
            abort(403, 'Unauthorized action');
        }
        $month = $request->month;
        $year  = $request->year;
        $startOfMonth = $year . '-' . $month  . '-01';
        $endOfMonth = Carbon::parse($startOfMonth)->endOfMonth()->format('Y-m-d');

        $periods = new CarbonPeriod($startOfMonth, $endOfMonth);
        $employees = User::orderBy('employee_id')->where('name', 'LIKE', '%' . $request->employee_name . '%')->get();
        $attendances = CheckinCheckout::whereMonth('date', $month)->whereYear('date', $year)->get();
        $company_setting = CompanySetting::findOrFail(1);
        return view('components.attendance_overview_table', compact('periods', 'employees', 'attendances', 'company_setting'))->render();
    }

    public function downloadPDF()
    {
        $attendances = CheckinCheckout::with('employee')->get();
        $pdf = PDF::loadView('pdf.attendance',['attendances'=>$attendances]);

        return $pdf->download('attendance.pdf');
    }
}
