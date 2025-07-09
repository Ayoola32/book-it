<?php

namespace App\Http\Controllers\Admin;

use App\DataTables\UserDataTable;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\UserCreateRequest;
use App\Http\Requests\Admin\UserUpdateRequest;
use App\Models\Employee;
use App\Models\ServiceSubCategory;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\Http\Request;

class UserController extends Controller
{
    use \App\Traits\TransformData;
    /**
     * Display a listing of the resource.
     */
    public function index(UserDataTable $dataTable)
    {
        return $dataTable->render('admin.users.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $days = [
            'monday', 'tuesday', 'wednesday', 'thursday', 'friday', 'saturday', 'sunday',
        ];

        $services = ServiceSubCategory::where('status', 1)->get();
        return view('admin.users.create', compact('days', 'services'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(UserCreateRequest $request)
    {

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'role' => $request->role ?? 'user',
            'password' => Hash::make('password'),
            'image' => 'uploads/users/avatar.png',
            'status' => $request->status ?? 0,
        ]);

        event(new Registered($user));
 
        
        if($request->role === 'employee')
        {
            $transformedDays = $this->transformOpeningHours($request->input('days', []));

            $employee = Employee::create([
                'user_id'           => $user['id'],
                'slot_duration'     => $request['slot_duration'],
                'break_duration'    => $request['break_duration'],
                'total_holiday_days'  => $request['total_holiday_days'],
                'days'              => $transformedDays,
            ]);

            $flatServices = collect($request->input('service', []))
                ->flatten()
                ->filter()
                ->map(fn($id) => (int) $id)
                ->toArray();

            $employee->services()->attach($flatServices);        
        }
        return redirect()->route('admin.user.index')->with('success', 'New User Created Successfully');

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
        $days = [
            'monday', 'tuesday', 'wednesday', 'thursday', 'friday', 'saturday', 'sunday',
        ];

        $user = User::with('employee')->findOrFail($id);

        $employeeDays = $user->employee->days ?? [];
        $employeeDays = $this->transformAvailabilitySlotsForEdit($employeeDays);

        // Ensure all days are present (even if empty)
        foreach ($days as $day) {
            if (!isset($employeeDays[$day])) {
                $employeeDays[$day] = [];
            }
        }

        $services = ServiceSubCategory::where('status', 1)->get();
        $employee = Employee::with('services')->where('user_id', $id)->first();
        $selectedServices = $employee ? $employee->services->pluck('id')->toArray() : [];
        return view('admin.users.edit', compact('user', 'services', 'employee', 'selectedServices', 'days', 'employeeDays'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UserUpdateRequest $request, string $id)
    {
        $user = User::findOrFail($id);

        $user->update([
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'status' => $request->status ?? $user->status,
            'role' => $request->role ?? $user->role,
        ]);

        if ($request->role === 'employee') {

            $transformedDays = $this->transformOpeningHours($request->input('days', []));

            $employee = Employee::updateOrCreate(
                ['user_id' => $user->id],
                [
                    'slot_duration' => $request->input('slot_duration') ?? 30,
                    'break_duration' => $request->input('break_duration') ?? 10,
                    'total_holiday_days' => $request->input('total_holiday_days') ?? 28,
                    'days'           => $transformedDays,
                ]
            );


            // Handle nested service array
            $flatServices = collect($request->input('service', []))
                ->flatten(1) // Flatten nested array one level
                ->filter()
                ->map(fn($id) => (int) $id)
                ->toArray();

            $employee->services()->sync($flatServices);


            [$start, $end] = Employee::getCurrentHolidayYearRange();

            $employee->holidayBalances()
                ->where('holiday_year_start', $start->toDateString())
                ->update(['total_days' => $employee->total_holiday_days]);

            
        }

        return redirect()->route('admin.user.index')->with('success', 'User updated successfully');

    }

    /**
     * Update the status of a user.
     */
    public function updateStatus(Request $request, string $id)
    {
        $user = User::findOrFail($id);
        $user->status = $request->status;

        
        $user->save();
        return response()->json(['success' => 'Status updated successfully.']);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
