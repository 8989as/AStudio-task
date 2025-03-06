<?php

namespace App\Http\Controllers;

use App\Services\ProjectService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class ProjectController extends Controller
{
    protected $projectService;

    public function __construct(ProjectService $projectService)
    {
        $this->projectService = $projectService;
    }

    public function index()
    {
        return response()->json($this->projectService->getAllProjects());
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date',
        ]);

        return response()->json($this->projectService->createProject($data), 201);
    }

    public function show($id)
    {
        return response()->json($this->projectService->getProjectById($id));
    }

    public function update(Request $request, $id)
    {
        $data = $request->validate([
            'name' => 'sometimes|string|max:255',
            'description' => 'nullable|string',
            'start_date' => 'sometimes|date',
            'end_date' => 'sometimes|date|after_or_equal:start_date',
        ]);

        return response()->json($this->projectService->updateProject($id, $data));
    }

    public function destroy($id)
    {
        $this->projectService->deleteProject($id);
        return response()->json(['message' => 'Project deleted successfully']);
    }

    public function filter(Request $request)
    {
        // Validate the request (optional)
        $request->validate([
            'filters' => 'sometimes|array',
            'filters.*' => 'sometimes|string',
        ]);

        // Get the filters from the request
        $filters = $request->input('filters', []);

        // Apply filters using the service
        $projects = $this->projectService->filter($filters);

        return response()->json($projects);
    }

    // public function filter(Request $request)
    // {
    //     Log::info("Filter request received", ['filters' => $request->query('filters')]);

    //     $filters = $request->query('filters', []);

    //     if (empty($filters)) {
    //         Log::error("No filters provided");
    //         return response()->json(['message' => 'No filters provided'], 400);
    //     }

    //     $projects = $this->projectService->filterProjects($filters);

    //     Log::info("Filtered projects response", ['projects' => $projects]);

    //     return response()->json($projects);
    // }
}
