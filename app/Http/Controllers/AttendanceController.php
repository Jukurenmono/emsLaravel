<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class AttendanceController extends Controller
{
    public function print(Request $request)
    {
        $selectedDate = Carbon::parse($request->input('date', now()->toDateString()));

        $attendances = DB::table('attendances')
            ->join('employees', 'attendances.employee_id', '=', 'employees.employee_id')
            ->select('attendances.*', 'employees.name', 'employees.position')
            ->whereDate('attendances.time_in', $selectedDate)
            ->orderBy('time_in', 'desc')
            ->get()
            ->map(function ($attendance) {
                $attendance->time_in = Carbon::parse($attendance->time_in);
                if ($attendance->time_out) {
                    $attendance->time_out = Carbon::parse($attendance->time_out);
                }
                return $attendance;
            });

        return view('attendance_list.print', compact('attendances', 'selectedDate'));
    }
}