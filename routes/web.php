<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\AuthenticatedSessionController;
use App\Http\Controllers\AttendanceController;
use Carbon\Carbon;
use App\Http\Controllers\TaskController;
use App\Models\Task;

// Redirect to login page by default
Route::get('/', function () {
    return redirect('/login');
});

// Authentication routes
Route::get('/login', [AuthenticatedSessionController::class, 'create'])->name('login');
Route::post('/login', [AuthenticatedSessionController::class, 'store']);

Route::middleware(['auth', 'verified'])->get('/dashboard', function () {
    return view('dashboard');
})->name('dashboard');


Route::middleware(['auth', 'verified'])->get('/attendance_list', function (Request $request) {
    $date = $request->input('today_date', $request->input('date', now()->format('Y-m-d')));
    $search = $request->input('search');

    $query = DB::table('attendances')
        ->join('employees', 'attendances.employee_id', '=', 'employees.employee_id')
        ->select('attendances.*', 'employees.name', 'employees.position')
        ->whereDate('attendances.time_in', $date);

    if ($search) {
        $query->where(function ($q) use ($search) {
            $q->where('employees.name', 'like', "%{$search}%")
              ->orWhere('employees.employee_id', 'like', "%{$search}%");
        });
    }

    $attendances = $query->orderBy('time_in', 'desc')->get()
        ->map(function ($attendance) {
            $attendance->time_in = Carbon::parse($attendance->time_in);
            if ($attendance->time_out) {
                $attendance->time_out = Carbon::parse($attendance->time_out);
            }
            return $attendance;
        });

    return view('attendance_list.index', [
        'attendances' => $attendances,
        'selectedDate' => $date,
        'search' => $search,
    ]);
})->name('attendance_list');


// Employee routes
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// Employees management
Route::get('/employees', function (Request $request) {
    $search = $request->input('search');

    $query = DB::table('employees');

    if ($search) {
        $query->where(function ($q) use ($search) {
            $q->where('name', 'like', "%{$search}%")
              ->orWhere('employee_id', 'like', "%{$search}%");
        });
    }

    $employees = $query->get();

    return view('employees.index', [
        'employees' => $employees,
        'search' => $search
    ]);
})->middleware('auth');

Route::post('/employees', function (Request $request) {
    try {
        do {
            $employeeId = (string) rand(100000, 999999);
        } while (DB::table('employees')->where('employee_id', $employeeId)->exists());

        DB::insert("INSERT INTO employees (employee_id, name, email, position) VALUES (?, ?, ?, ?)", [
            $employeeId,
            $request->name,
            $request->email,
            $request->position
        ]);

        session()->flash('success', 'Employee added successfully.');
    } catch (\Throwable $th) {
        session()->flash('error', 'Error adding employee.');
    }
    return redirect('/employees');
})->middleware('auth');

Route::get('/employees/edit/{id}', function ($id) {
    $employee = DB::selectOne("SELECT * FROM employees WHERE id = ?", [$id]);
    return view('employees.edit', ['employee' => $employee]);
})->middleware('auth');

Route::post('/employees/update/{id}', function (Request $request, $id) {
    try {
        DB::update("UPDATE employees SET name = ?, email = ?, position = ? WHERE id = ?", [
            $request->name,
            $request->email,
            $request->position,
            $id
        ]);
        session()->flash('success', 'Employee updated successfully.');
    } catch (\Throwable $th) {
        session()->flash('error', 'Error updating employee.');
    }
    return redirect('/employees');
})->middleware('auth');

Route::get('/employees/delete/{id}', function ($id) {
    try {
        DB::delete("DELETE FROM employees WHERE id = ?", [$id]);
        session()->flash('success', 'Employee deleted successfully.');
    } catch (\Throwable $th) {
        session()->flash('error', 'Error deleting employee.');
    }
    return redirect('/employees');
})->middleware('auth');

// Attendance Routes
Route::get('/attendance', function () {
    $today = Carbon::today();

    $attendances = DB::table('attendances')
        ->join('employees', 'attendances.employee_id', '=', 'employees.employee_id')
        ->select('attendances.*', 'employees.name', 'employees.position')
        ->whereDate('time_in', $today)
        ->orderBy('time_in', 'desc')
        ->get()
        ->map(function ($attendance) {
            $attendance->time_in = \Carbon\Carbon::parse($attendance->time_in);
            if ($attendance->time_out) {
                $attendance->time_out = \Carbon\Carbon::parse($attendance->time_out);
            }
            return $attendance;
        });

    return view('attendance.form', [
        'attendances' => $attendances,

    ]);
});

// Record Time-In / Time-Out
Route::post('/attendance', function (Request $request) {
    $employee = DB::table('employees')->where('employee_id', $request->employee_id)->first();

    if (!$employee) {
        session()->flash('error', 'Invalid employee ID.');
        return redirect('/attendance');
    }

    $today = now()->format('Y-m-d');

    // Check if the employee has already clocked in today
    $existingAttendance = DB::table('attendances')
        ->where('employee_id', $request->employee_id)
        ->whereDate('time_in', $today)
        ->first();

    if ($existingAttendance && is_null($existingAttendance->time_out)) {
        // Record time-out if already clocked in
        DB::table('attendances')
            ->where('id', $existingAttendance->id)
            ->update([
                'time_out' => now(),
                'updated_at' => now(),
            ]);
        session()->flash('success', 'Time-out recorded successfully.');
    } elseif (!$existingAttendance) {
        // If no attendance exists today, record time-in
        DB::table('attendances')->insert([
            'employee_id' => $request->employee_id,
            'time_in' => now(),
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        session()->flash('success', 'Time-in recorded successfully.');
    } else {
        session()->flash('error', 'You have already clocked in today.');
    }

    return redirect('/attendance');
});

// Filter attendance by date (admin can select a day)
Route::post('/attendance/filter', function (Request $request) {
    $selectedDate = $request->selected_date;

    $attendances = DB::table('attendances')
        ->join('employees', 'attendances.employee_id', '=', 'employees.employee_id')
        ->select('attendances.*', 'employees.name', 'employees.position')
        ->whereDate('attendances.time_in', $selectedDate)
        ->orderBy('time_in', 'desc')
        ->get();

    return view('attendance.form', ['attendances' => $attendances]);
});

Route::get('/attendance_list/print', [AttendanceController::class, 'print'])->name('attendance_list.print');

Route::post('/tasks', [TaskController::class, 'store'])->name('tasks.store');
Route::patch('/tasks/{task}', [TaskController::class, 'update'])->name('tasks.update');
Route::delete('/tasks/{task}', [TaskController::class, 'destroy'])->name('tasks.destroy');

Route::get('/dashboard', function () {
    $tasks = Task::all();
    return view('dashboard', compact('tasks'));
})->name('dashboard');

require __DIR__.'/auth.php';
