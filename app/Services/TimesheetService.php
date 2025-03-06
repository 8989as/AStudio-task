<?php

namespace App\Services;

namespace App\Services;

use App\Repositories\TimesheetRepository;

class TimesheetService
{
    protected $timesheetRepository;

    public function __construct(TimesheetRepository $timesheetRepository)
    {
        $this->timesheetRepository = $timesheetRepository;
    }

    public function logTime($data)
    {
        return $this->timesheetRepository->create($data);
    }

    public function getTimesheets()
    {
        return $this->timesheetRepository->all();
    }

    public function getTimesheetById($id)
    {
        return $this->timesheetRepository->find($id);
    }

    public function updateTimesheet($id, $data)
    {
        return $this->timesheetRepository->update($id, $data);
    }

    public function deleteTimesheet($id)
    {
        return $this->timesheetRepository->delete($id);
    }
}

