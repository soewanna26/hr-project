<?php

namespace Database\Seeders;

use App\Models\CheckinCheckout;
use App\Models\User;
use Carbon\Carbon;
use Carbon\CarbonPeriod;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class AttendanceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $users = User::all();
        foreach ($users as $user) {
            $periods = new CarbonPeriod('2024-01-1', '2024-12-31');
            foreach ($periods as $period) {
                if ($period->format('D') != 'Sat' && $period->format('D') != 'Sun') {
                    $attendance = new CheckinCheckout();
                    $attendance->user_id = $user->id;
                    $attendance->date = $period->format('Y-m-d');
                    $checkin_time = Carbon::parse($period->format('Y-m-d') . ' ' . rand(9, 10) . ':00:00')->subMinutes(rand(1, 55));
                    $checkout_time = Carbon::parse($period->format('Y-m-d') . ' ' . rand(17, 18) . ':00:00')->addMinutes(rand(1, 55));
                    $attendance->checkin_time = $checkin_time;
                    $attendance->checkout_time = $checkout_time;
                    $attendance->save();
                }
            }
        }
    }
}
