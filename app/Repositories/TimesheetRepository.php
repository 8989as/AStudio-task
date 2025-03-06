<?php

namespace App\Repositories;

use App\Models\Timesheet;

class TimesheetRepository extends BaseRepository
{
    public function __construct(Timesheet $timesheet)
    {
        parent::__construct($timesheet);
    }
}
