<?php

namespace App\Http\Controllers;

use App\Models\Employee;

class EmployeePaidLeaveController extends Controller
{
    public function index()
    {
        $employeeLeaves = Employee::with('leaveRequests')
            ->withCount(['leaveRequests as total_leaves' => function ($query) {
                $query->whereYear('start_date', now()->year);
            }])
            ->paginate(10);
        return view('employee.paid_leave.index', compact('employeeLeaves'));
    }

    public function show(Employee $employee)
    {
        $leaves = $employee->leaveRequests()
            ->whereYear('start_date', now()->year)
            ->paginate(10);
        return view('employee.paid_leave.show', compact('employee', 'leaves'));
    }
}
