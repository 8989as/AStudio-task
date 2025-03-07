<?php

namespace App\Http\Controllers;

use App\Helpers\ResponseFormatter;
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
        try {
            $projects = $this->projectService->getAllProjects();

            return ResponseFormatter::format(
                200,
                'Projects retrvied successfully',
                $projects
            );
        } catch (\Exception $e) {
            return ResponseFormatter::format(
                500,
                'An error occurred',
                [],
                $e->getMessage()
            );
        }
    }

    public function store(Request $request)
    {
        try {
            $data = $request->validate([
                'name' => 'required|string|max:255',
                'department' => 'required|string|max:255',
                'description' => 'nullable|string',
                'start_date' => 'required|date',
                'end_date' => 'required|date|after_or_equal:start_date',
            ]);

            $projects = $this->projectService->createProject($data);

            return ResponseFormatter::format(
                201,
                'Project created successfully',
                $projects
            );
        } catch (\Exception $e) {
            return ResponseFormatter::format(
                500,
                'An error occurred',
                [],
                $e->getMessage()
            );
        }
    }

    public function show($id)
    {
        try {
            $project = $this->projectService->getProjectById($id);

            return ResponseFormatter::format(
                200,
                'Project retrvied successfully',
                $project
            );
        } catch (\Exception $e) {
            return ResponseFormatter::format(
                500,
                'An error occurred',
                [],
                $e->getMessage()
            );
        }
    }

    public function update(Request $request, $id)
    {
        try {
            $data = $request->validate([
                'name' => 'sometimes|string|max:255',
                'department' => 'sometimes|string|max:255',
                'description' => 'nullable|string',
                'start_date' => 'sometimes|date',
                'end_date' => 'sometimes|date|after_or_equal:start_date',
            ]);

            $project = $this->projectService->updateProject($id, $data);

            return ResponseFormatter::format(
                200,
                'Project updated successfully',
                $project
            );
        } catch (\Exception $e) {
            return ResponseFormatter::format(
                500,
                'An error occurred',
                [],
                $e->getMessage()
            );
        }
    }

    public function destroy($id)
    {
        try {
            $project = $this->projectService->deleteProject($id);
            return ResponseFormatter::format(
                200,
                'Project deleted successfully',
                $project
            );
        } catch (\Exception $e) {
            return ResponseFormatter::format(
                500,
                'An error occurred',
                [],
                $e->getMessage()
            );
        }
    }

    public function filter(Request $request)
    {
        try {
            $request->validate([
                'filters' => 'sometimes|array',
                'filters.*' => 'sometimes|string',
            ]);

            $filters = $request->input('filters', []);

            $projects = $this->projectService->filter($filters);

            return ResponseFormatter::format(
                200,
                'Project data retrevied successfully',
                $projects
            );
        } catch (\Exception $e) {
            return ResponseFormatter::format(
                500,
                'An error occurred',
                [],
                $e->getMessage()
            );
        }
    }
}
