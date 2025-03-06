<?php

namespace App\Http\Controllers;

use App\Services\TimesheetService;
use Illuminate\Http\Request;

class TimesheetController extends Controller
{
    protected $timesheetService;

    public function __construct(TimesheetService $timesheetService)
    {
        $this->timesheetService = $timesheetService;
    }

    public function index()
    {
        return response()->json($this->timesheetService->getTimesheets());
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'user_id' => 'required|exists:users,id',
            'project_id' => 'required|exists:projects,id',
            'task_name' => 'required|string|max:255',
            'date' => 'required|date',
            'hours' => 'required|integer|min:1',
        ]);

        return response()->json($this->timesheetService->logTime($data), 201);
    }

    public function show($id)
    {
        return response()->json($this->timesheetService->getTimesheetById($id));
    }

    public function update(Request $request, $id)
    {
        $data = $request->validate([
            'task_name' => 'sometimes|string|max:255',
            'date' => 'sometimes|date',
            'hours' => 'sometimes|integer|min:1',
        ]);

        return response()->json($this->timesheetService->updateTimesheet($id, $data));
    }

    public function destroy($id)
    {
        $this->timesheetService->deleteTimesheet($id);
        return response()->json(['message' => 'Timesheet deleted successfully']);
    }
}
