<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AttendanceScanController extends Controller
{
    public function scan()
    {
        return view("attendance_scan");
    }
}
