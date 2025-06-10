<?php

namespace App\Rules;

use App\Models\LeaveRequest;
use Closure;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Support\Carbon;

class MonthlyLeave implements ValidationRule
{
    /**
     * Run the validation rule.
     *
     * @param \Closure(string, ?string=): \Illuminate\Translation\PotentiallyTranslatedString $fail
     */

    protected int $employeeId;
    protected ?LeaveRequest $leaveRequest;

    public function __construct($employeeId, ?LeaveRequest $leaveRequest = null)
    {
        $this->employeeId = $employeeId;
        $this->leaveRequest = $leaveRequest;
    }

    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        $start_date = Carbon::parse($value);
        $end_date = Carbon::parse(request()->input('end_date'));

        if ($start_date->month === $end_date->month) {
            $exist = LeaveRequest::where('employee_id', $this->employeeId)
                ->when($this->leaveRequest, function ($query) {
                    $query->where('id', '!=', $this->leaveRequest->id);
                })
                ->where(function ($query) use ($start_date, $end_date) {
                    $query->whereMonth('start_date', $start_date->month)
                        ->whereYear('start_date', $start_date->year)
                        ->orWhere(function ($query) use ($end_date) {
                            $query->whereMonth('end_date', $end_date->month)
                                ->whereYear('end_date', $end_date->year);
                        });
                })
                ->exists();

            if ($exist) {
                $fail('You have already requested leave for this month.');
            }
            return;
        }

        $firstMonthLeave = LeaveRequest::where('employee_id', $this->employeeId)
            ->when($this->leaveRequest, function ($query) {
                $query->where('id', '!=', $this->leaveRequest->id);
            })
            ->whereMonth('start_date', $start_date->month)
            ->whereYear('start_date', $start_date->year)
            ->exists();

        $secondMonthLeave = LeaveRequest::where('employee_id', $this->employeeId)
            ->when($this->leaveRequest, function ($query) {
                $query->where('id', '!=', $this->leaveRequest->id);
            })
            ->whereMonth('start_date', $end_date->month)
            ->whereYear('start_date', $end_date->year)
            ->exists();

        if (!$firstMonthLeave && !$secondMonthLeave) {
            return;
        }

        $fail('You already requested leave for that month.');
    }
}
