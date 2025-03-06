<?php

namespace App\Repositories;

use App\Models\Project;

class ProjectRepository
{
    protected $model;

    public function __construct(Project $model)
    {
        $this->model = $model;
    }

    public function all()
    {
        return $this->model->with('users', 'attributes.attribute')->get();
    }

    public function create(array $data)
    {
        return $this->model->create($data);
    }

    public function find($id)
    {
        return $this->model->with('users', 'attributes.attribute')->findOrFail($id);
    }

    public function update($id, array $data)
    {
        $project = $this->find($id);
        $project->update($data);
        return $project;
    }

    public function delete($id)
    {
        return $this->find($id)->delete();
    }

    public function getFilteredProjects()
    {
        return $this->model->query();
    }

    public function filter(array $filters)
    {
        $query = $this->model->newQuery();

        foreach ($filters as $field => $value) {
            if (is_array($value)) {
                $operator = $value['operator'];
                $filterValue = $value['value'];
                $query->where($field, $operator, $filterValue);
            } else {
                $query->where($field, 'like', "%{$value}%");
            }
        }

        return $query->get();
    }
}
