<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ProfileController extends Controller
{
    public function profile()
    {
        $employee = auth()->user();
        $biometrics = DB::table('webauthn_credentials')->where('authenticatable_id',$employee->id)->get();
        // return dd($biometrics);
        return view('profile.profile',compact('employee', 'biometrics'));
    }

    public function biometricsData()
    {
        $employee = auth()->user();
        $biometrics = DB::table('webauthn_credentials')->where('authenticatable_id',$employee->id)->get();
        // return dd($biometrics);
        return view('components.biometric_data',compact('employee', 'biometrics'))->render();
    }

    public function biometricsDestroy($id)
    {
        $employee = auth()->user();
        $biometric=DB::table('webauthn_credentials')->where('id',$id)->where('authenticatable_id',$employee->id)->delete();
        return 'success';
    }
}
