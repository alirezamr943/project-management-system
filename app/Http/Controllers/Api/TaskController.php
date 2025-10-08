<?php

namespace App\Http\Controllers\Api;

use App\Models\Task;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Cache;

class TaskController extends Controller
{
    public function index()
    {
        Gate::authorize('viewAny', Task::class);
        $user = Auth::user();
        if ($user->role == "admin") {
            $tasks = Cache::remember('tasks', 60, function () {
                return Task::with(['project', 'user'])->get();
            });
        } else {
            $tasks = $user->tasks()->with('project')->paginate(10);
        }
        return response()->json($tasks);
    }

    public function store(Request $request)
    {
        Gate::authorize('create', Task::class);
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
        Gate::authorize('view', $task);

        return response()->json($task->load(['user', 'project']));
    }

    public function update(Request $request, Task $task)
    {
        Gate::authorize('update', $task);

        $validated = $request->validate([
            "title" => ['sometimes', 'required', 'string', 'max:255'],
            "description" => ['sometimes', 'required', 'string'],
            "status" => ['in:pending,under_develop,completed'],
            'assigned_to' => ['required', 'exists:users,id'],
            'project_id' => ['required', 'exists:projects,id'],
        ]);

        $task->update($validated);
        return response()->json($task);
    }

    public function destroy(Task $task)
    {
        Gate::authorize('destroy', $task);
        $task->delete();
        return response()->noContent();
    }
}
