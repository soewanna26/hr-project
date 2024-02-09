<?php

namespace App\Http\Controllers;

use App\Models\CheckinCheckout;
use App\Models\CompanySetting;
use App\Models\User;
use Carbon\Carbon;
use Carbon\CarbonPeriod;
use Illuminate\Http\Request;

class MyPayrollController extends Controller
{
    public function ssd(Request $request)
    {
        return view('attendance_scan');
    }

    public function mypayrollTable(Request $request)
    {
        $month = $request->month;
        $year  = $request->year;
        $startOfMonth = $year . '-' . $month  . '-01';
        $endOfMonth = Carbon::parse($startOfMonth)->endOfMonth()->format('Y-m-d');
        $dayInMonth = Carbon::parse($startOfMonth)->daysInMonth;

        $workingDays = Carbon::parse($startOfMonth)->subDays(1)->diffInDaysFiltered(function (Carbon $date) {
            return $date->isWeekday();
        }, Carbon::parse($endOfMonth));

        $offDays = $dayInMonth - $workingDays;

        $periods = new CarbonPeriod($startOfMonth, $endOfMonth);
        $employees = User::orderBy('employee_id')->where('id', auth()->user()->id)->get();
        $attendances = CheckinCheckout::whereMonth('date', $month)->whereYear('date', $year)->get();
        $company_setting = CompanySetting::findOrFail(1);
        return view('components.payroll_table', compact('periods', 'employees', 'attendances', 'company_setting', 'dayInMonth', 'workingDays', 'offDays','month','year'))->render();
    }
}
