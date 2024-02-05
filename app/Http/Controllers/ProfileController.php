<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ProfileController extends Controller
{
    public function profile(){
        $employee = auth()->user();
        $biometrics = DB::table('webauthn_credentials')->where('authenticatable_id',$employee->id)->get();
        // return dd($biometrics);
        return view('profile.profile',compact('employee', 'biometrics'));
    }
}
