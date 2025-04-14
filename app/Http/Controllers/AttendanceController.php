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
            ->whereDate('attendances.attended_at', $selectedDate)
            ->orderBy('attended_at', 'desc')
            ->get()
            ->map(function ($attendance) {
                $attendance->attended_at = Carbon::parse($attendance->attended_at);
                return $attendance;
            });

        return view('attendance_list.print', compact('attendances', 'selectedDate'));
    }
}