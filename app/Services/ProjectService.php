<?php

namespace App\Services;

use App\Repositories\ProjectRepository;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Log;

class ProjectService
{
    protected $projectRepository;

    public function __construct(ProjectRepository $projectRepository)
    {
        $this->projectRepository = $projectRepository;
    }

    public function getAllProjects()
    {
        return $this->projectRepository->all();
    }

    public function createProject($data)
    {
        return $this->projectRepository->create($data);
    }

    public function getProjectById($id)
    {
        return $this->projectRepository->find($id);
    }

    public function updateProject($id, $data)
    {
        return $this->projectRepository->update($id, $data);
    }

    public function deleteProject($id)
    {
        return $this->projectRepository->delete($id);
    }

    public function filter(array $filters)
    {
        $query = $this->projectRepository->getFilteredProjects();

        foreach ($filters as $field => $value) {
            if (in_array($field, ['name', 'status'])) {
                $query->where($field, 'LIKE', "%{$value}%");
            }
        }

        foreach ($filters as $key => $value) {
            if (!in_array($key, ['name', 'status'])) {
                $query->whereHas('attributes', function (Builder $attrQuery) use ($key, $value) {
                    $attrQuery->whereHas('attribute', function (Builder $attributeQuery) use ($key) {
                        $attributeQuery->where('name', $key);
                    })->where('value', 'LIKE', "%$value%");
                });
            }
        }

        $projects = $query->get();

        if ($projects->isEmpty()) {
            return [
                'message' => 'No records found matching the applied filters',
                'data' => []
            ];
        }

        return [
            'message' => 'Projects retrieved successfully',
            'data' => $projects
        ];
    }
}
