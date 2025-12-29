<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Task;
use Illuminate\Http\Request;

class TaskController extends Controller
{
    public function store(Request $request)
    {
        $request->validate(['title' => 'required|string|max:255']);
        Task::create(['title' => $request->title]);
        return back()->with('success', 'Task added successfully.');
    }

    public function update(Request $request, Task $task)
    {
        if ($request->has('completed')) {
            $task->update(['completed' => $request->boolean('completed')]);
            return response()->json(['success' => true]);
        }
        
        $request->validate(['title' => 'required|string|max:255']);
        $task->update(['title' => $request->title]);
        return back()->with('success', 'Task updated.');
    }

    public function destroy(Task $task)
    {
        $task->delete();
        return back()->with('success', 'Task removed.');
    }
}
