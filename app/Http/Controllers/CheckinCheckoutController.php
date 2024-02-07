<?php

namespace App\Http\Controllers;

use App\Models\CheckinCheckout;
use App\Models\User;
use Illuminate\Http\Request;

class CheckinCheckoutController extends Controller
{
    public function checkInCheckOut()
    {
        return view('checkin_checkout');
    }
    public function checkInCheckOutStore(Request $request)
    {
        $user = User::where('pin_code', $request->pin_code)->first();
        if (!$user) {
            return [
                'status' => 'fail',
                'message' => 'Pin code is wrong',
            ];
        }
        // if(CheckinCheckout::where('user_id', $user->id)->whereNotNull('checkin_time')->exists())
        // {
        //     return [
        //         'status' => 'fail',
        //         'message' => 'Alredy check In',
        //     ];
        // }

        $checkin_checkout_data = CheckinCheckout::firstOrCreate([
            'user_id' => $user->id,
            'date' => now()->format('Y-m-d'),
        ]);

        if (!is_null($checkin_checkout_data->checkin_time) && !is_null($checkin_checkout_data->checkout_time)) {
            return [
                'status' => 'fail',
                'message' => 'Already Checkin and Checkout Today',
            ];
        }
        if (is_null($checkin_checkout_data->checkin_time)) {
            $checkin_checkout_data->checkin_time = now();
            $message = 'Successfully check in at ' . now();
        } else {
            if (is_null($checkin_checkout_data->checkout_time)) {
                $checkin_checkout_data->checkout_time = now();
                $message = 'Successfully check out at ' . now();
            }
        }
        $checkin_checkout_data->update();
        return [
            'status' => 'success',
            'message' => $message,
        ];
    }
}
