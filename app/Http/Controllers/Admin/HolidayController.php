<?php

namespace App\Http\Controllers\Admin;

use App\DataTables\HolidayDataTable;
use App\Http\Controllers\Controller;
use App\Models\Employee;
use App\Models\Holiday;
use Carbon\Carbon;
use Illuminate\Http\Request;

class HolidayController extends Controller
{
    /**
     * Display a listing of the resource in Admin.
     */
    public function index(HolidayDataTable $dataTable)
    {
        return $dataTable->render('admin.holiday.index');
    }


    /**
     * Display Listings of holiday in employee dashboard.
     */
    public function index2(HolidayDataTable $dataTable)
    {
        $employeeId = auth()->user()->employee->id;

        return $dataTable->forEmployee($employeeId)->render('employee.holiday.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('employee.holiday.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'start_date' => ['required', 'date', 'after_or_equal:today'],
            'end_date' => ['required', 'date', 'after_or_equal:start_date'],
            'reason' => ['nullable', 'string', 'max:1000']
        ]);

        [$holidayYearStart, $holidayYearEnd] = Employee::getCurrentHolidayYearRange();

        if (
            Carbon::parse($request->start_date)->lt($holidayYearStart) ||
            Carbon::parse($request->end_date)->gt($holidayYearEnd)
        ) {
            return redirect()->back()->with('error', "You can only book holidays within the current holiday year ({$holidayYearStart->toDateString()} to {$holidayYearEnd->toDateString()}).");
        }


        $employee = auth()->user()->employee;
        $employeeId = $employee->id;

        //Check for overlapping holidays
        $overlap = Holiday::where('employee_id', $employeeId)
            ->whereIn('status', ['approved', 'pending'])
            ->where(function ($query) use ($request) {
                $query->whereDate('start_date', '<=', $request->end_date)
                    ->whereDate('end_date', '>=', $request->start_date);
            })
            ->exists();

        if ($overlap) {
            return redirect()->back()->with('error', 'You already have a holiday booked in that period.');
        }

        // Calculate requested days
        $requestedDays = Carbon::parse($request->start_date)
            ->diffInDays(Carbon::parse($request->end_date)) + 1;

        // Check if the employee has enough balance
        $usedDays = $employee->used_holiday_days; // accessor from step 2
        $remaining = $employee->total_holiday_days - $usedDays;

        if ($requestedDays > $remaining) {
            return redirect()->back()->with('error', "You only have {$remaining} holiday day(s) left.");

        }

        // Save request
        Holiday::create([
            'employee_id' => $employeeId,
            'start_date' => $request->start_date,
            'end_date' => $request->end_date,
            'reason' => $request->reason,
            'status' => 'pending',
        ]);

        return redirect()->route('employee.holiday.index')->with('success', 'Holiday request submitted.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }



    public function updateStatus(Request $request, $id)
    {
        $request->validate([
            'status' => ['required', 'in:approved,rejected'],
            'feedback' => $request->status === 'rejected' ? ['required', 'string', 'max:1000'] : ['nullable', 'string', 'max:1000'],
        ]);

        $holiday = Holiday::findOrFail($id);

        // Prevent re-approval or re-rejection
        if (in_array($holiday->status, ['approved', 'rejected'])) {
            return response()->json(['error' => 'Cannot update a request that has already been approved or rejected.'], 403);
        }

        // Only check balance if approving
        if ($request->status === 'approved') {
            $employee = $holiday->employee; // Make sure there's a `employee()` relationship on Holiday model

            $requestedDays = $holiday->start_date->diffInDays($holiday->end_date) + 1;
            $remaining = $employee->remaining_holiday_days;

            if ($requestedDays > $remaining) {
                return response()->json([
                    'error' => "This employee only has {$remaining} day(s) left. Cannot approve {$requestedDays} days.",
                ], 422);
            }
        }

        $holiday->update([
            'status' => $request->status,
            'feedback' => $request->feedback,
        ]);

        return response()->json(['success' => true]);
    }





    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $holiday = Holiday::where('id', $id)->firstOrFail();

  
        if ($holiday->status === 'approved' || $holiday->status === 'rejected') {
            return response()->json([
                'status' => 'error',
                'message' => 'Cannot delete holiday with approved or rejected status.'
            ]);
        }

        $holiday->delete();

        return response()->json([
            'message' => 'Deleted successfully'
        ]);
    }
}
