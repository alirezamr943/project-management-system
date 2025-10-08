<?php

namespace App\Http\Controllers\Api;

use App\Models\Project;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Cache;

class ProjectController extends Controller
{
    public function index()
    {
        Gate::authorize('viewAny', Project::class);
        $user = Auth::user();
        if ($user->role == 'admin') {
            $projects = Cache::remember('projects',60,function(){
                return Project::with('tasks')->get();
            });
        } else {
            $projects = $user->projects()->with('tasks')->paginate(10);
        }
        return response()->json($projects);
    }

    public function store(Request $request)
    {
        Gate::authorize('create', Project::class);

        $validated = $request->validate([
            "title" => ['required', 'string', 'max:255'],
            "description" => ['required', 'string'],
            "start_date" => ['nullable', 'date'],
            "end_date" => ['nullable', 'date', 'after:start_date'],
            "status" => ['in:pending,under_develop,completed']
        ]);

        $project = Project::create($validated);
        return response()->json($project, 201);
    }

    public function show(Project $project)
    {
        Gate::authorize('view', $project);
        return response()->json($project->load('tasks'));
    }

    public function update(Request $request, Project $project)
    {
        Gate::authorize('update', $project);

        $validated = $request->validate([
            "title" => ['sometimes', 'required', 'string', 'max:255'],
            "description" => ['sometimes', 'required', 'string'],
            "start_date" => ['nullable', 'date'],
            "end_date" => ['nullable', 'date', 'after:start_date'],
            "status" => ['in:pending,under_develop,completed']
        ]);

        $project->update($validated);
        return response()->json($project);
    }

    public function destroy(Project $project)
    {
        Gate::authorize('destroy', $project);
        $project->delete();
        return response()->noContent();
    }
}
