<?php

namespace App\Http\Controllers;

use App\Http\Requests\Leave\CreateLeave;
use App\Http\Requests\Leave\UpdateLeave;
use App\Models\Employee;
use App\Models\LeaveRequest;
use App\Trait\CheckLeaveDate;
use Illuminate\Support\Carbon;

class LeaveRequestController extends Controller
{
    use CheckLeaveDate;

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('leave-request.index', [
            'leaves' => LeaveRequest::with('employee')->latest()->paginate(10),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $employees = Employee::select('id', 'first_name', 'last_name')->get();
        return view('leave-request.create', compact('employees'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(CreateLeave $request)
    {
        $verify = $this->verifyLeaveDate($request->start_date, $request->end_date);

        if (!$verify) {
            return back()->withErrors(['end_date' => 'You cannot request leave for more than one day in one month.'])->withInput();
        }

        LeaveRequest::create([
            'employee_id' => $request->employee_id,
            'reason' => $request->reason,
            'start_date' => Carbon::parse($request->start_date),
            'end_date' => Carbon::parse($request->end_date),
        ]);

        return redirect()->route('leave-request.index')->with('success', 'Leave request created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(LeaveRequest $leaveRequest)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(LeaveRequest $leaveRequest)
    {
        $employees = Employee::select('id', 'first_name', 'last_name')->get();
        return view('leave-request.edit', compact('leaveRequest', 'employees'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateLeave $request, LeaveRequest $leaveRequest)
    {
        $verify = $this->verifyLeaveDate($request->start_date, $request->end_date);

        if (!$verify) {
            return back()->withErrors(['end_date' => 'You cannot request leave for more than one day in one month.'])->withInput();
        }

        $leaveRequest->update([
            'employee_id' => $request->employee_id,
            'reason' => $request->reason,
            'start_date' => Carbon::parse($request->start_date),
            'end_date' => Carbon::parse($request->end_date),
        ]);

        return redirect()->route('leave-request.index')->with('success', 'Leave request updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(LeaveRequest $leaveRequest)
    {
        $leaveRequest->delete();
        return redirect()->route('leave-request.index')->with('success', 'Leave request deleted successfully.');
    }
}
