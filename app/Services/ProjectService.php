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
        return $this->projectRepository->filter($filters);
    }
}
