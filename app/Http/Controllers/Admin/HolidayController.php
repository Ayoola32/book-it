<?php

namespace App\Http\Controllers\Admin;

use App\DataTables\HolidayDataTable;
use App\Http\Controllers\Controller;
use App\Models\Holiday;
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

        return $dataTable->forEmployee($employeeId)->render('holiday.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('holiday.create');
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


        Holiday::create([
            'employee_id' => auth()->id(),
            'start_date' => $request->start_date,
            'end_date' => $request->end_date,
            'reason' => $request->reason,
        ]);

        return back()->with('success', 'Holiday request submitted.');
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
            'status' => 'required|in:approved,rejected',
            'feedback' => 'nullable|string|max:1000',
        ]);

        $holiday = Holiday::findOrFail($id);

        if (in_array($holiday->status, ['approved', 'rejected'])) {
            return response()->json(['error' => 'Cannot update approved/rejected request.'], 403);
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
        //
    }
}
