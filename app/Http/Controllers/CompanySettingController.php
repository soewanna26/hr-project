<?php

namespace App\Http\Controllers;

use App\Models\CompanySetting;
use Illuminate\Http\Request;

class CompanySettingController extends Controller
{
    public function show($id)
    {
        $setting = CompanySetting::findOrFail($id);
        return view('company_setting.show', compact('setting'));
    }

    public function edit($id)
    {
        $setting = CompanySetting::findOrFail($id);
        return view('company_setting.edit', compact('setting'));
    }
}
