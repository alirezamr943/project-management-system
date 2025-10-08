<?php

namespace App\Http\Controllers\Api;

use App\Models\Project;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ProjectController extends Controller
{
    public function index()
    {
        $projects = Project::with('tasks')->get();
        return response()->json($projects);
    }

    public function store(Request $request)
    {
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
        return response()->json($project->load('tasks'));
    }

    public function update(Request $request, Project $project)
    {
        $validated = $request->validate([
            "title" => ['sometimes','required', 'string', 'max:255'],
            "description" => ['sometimes','required', 'string'],
            "start_date" => ['nullable', 'date'],
            "end_date" => ['nullable', 'date', 'after:start_date'],
            "status" => ['in:pending,under_develop,completed']
        ]);
        
        $project->update($validated);
        return response()->json($project);
    }

    public function destroy(Project $project)
    {
        $project->delete();
        return response()->noContent();
    }
}
