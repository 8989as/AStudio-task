<?php

namespace App\Repositories;

use App\Models\Project;

class ProjectRepository extends BaseRepository
{
    public function __construct(Project $project)
    {
        parent::__construct($project);
    }

    public function getFilteredProjects()
    {
        return $this->model->query();
    }
}
