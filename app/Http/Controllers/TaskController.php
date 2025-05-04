<?php

namespace App\Http\Controllers;

use App\Models\Task;
use Illuminate\Http\Request;

class TaskController extends Controller
{
    public function store(Request $request)
    {
        Task::create([
            'title' => $request->title,
            'completed' => false,
        ]);

        return redirect()->back();
    }

    public function update(Request $request, Task $task)
    {
        $task->update([
            'completed' => $request->has('completed'),
        ]);

        return redirect()->back();
    }

    public function destroy(Task $task)
    {
        $task->delete();

        return redirect()->back();
    }
}
