<?php

namespace App\Http\Controllers\Admin;

use App\DataTables\HolidayDataTable;
use App\Http\Controllers\Controller;
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
        //
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

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
