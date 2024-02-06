<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class CheckinCheckoutController extends Controller
{
    public function checkInCheckOut()
    {
        return view('checkin_checkout');
    }
}
