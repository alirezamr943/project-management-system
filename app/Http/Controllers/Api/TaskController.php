<?php

namespace App\Http\Controllers\Api;

use App\Models\Task;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class TaskController extends Controller
{
    public function index()
    {
        $tasks = Task::with(['project', 'user'])->get();
        return response()->json($tasks);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            "title" => ['required', 'string', 'max:255'],
            "description" => ['required', 'string'],
            "status" => ['in:pending,under_develop,completed'],
            'assigned_to' => ['required', 'exists:users,id'],
            'project_id' => ['required', 'exists:projects,id'],
        ]);

        $task = Task::create($validated);
        return response()->json($task, 201);
    }

    public function show(Task $task)
    {
        return response()->json($task->load(['user', 'project']));
    }

    public function update(Request $request, Task $task)
    {
        $validated = $request->validate([
            "title" => ['sometimes','required', 'string', 'max:255'],
            "description" => ['sometimes','required', 'string'],
            "status" => ['in:pending,under_develop,completed'],
            'assigned_to' => ['required', 'exists:users,id'],
            'project_id' => ['required', 'exists:projects,id'],
        ]);

        $task->update($validated);
        return response()->json($task);
    }

    public function destroy(Task $task)
    {
        $task->delete();
        return response()->noContent();
    }
}
