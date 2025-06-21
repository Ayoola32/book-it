<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use App\Models\Employee;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;

class ProfileController extends Controller
{
    use \App\Traits\TransformData;

    /**
     * Display the user's profile form.
     */
    public function index(Request $request): View
    {
        // return view('profile.index', [
        //     'user' => $request->user()->load(['employee']),
        // ]);

        $days = [
            'monday', 'tuesday', 'wednesday', 'thursday', 'friday', 'saturday', 'sunday',
        ];

        $user = User::with('employee')->where('id', Auth::id())->firstOrFail();
        $employeeDays = $user->employee->days ?? [];
        $employeeDays = $this->transformAvailabilitySlotsForEdit($employeeDays);

        // Ensure all days are present (even if empty)
        foreach ($days as $day) {
            if (!isset($employeeDays[$day])) {
                $employeeDays[$day] = [];
            }
        }
        $employee = Employee::with('services')->where('user_id', Auth::id())->first();




        return view('profile.index', compact('user', 'days', 'employeeDays', 'employee'));
    }

    /**
     * Update the user's profile information.
     */
    public function profileUpdate(ProfileUpdateRequest $request): RedirectResponse
    {
        $request->user()->fill($request->validated());

        if ($request->user()->isDirty('email')) {
            $request->user()->email_verified_at = null;
        }

        $request->user()->save();

        flash()->success('Your profile has been updated.');
        return redirect()->back();
    }

    public function updateBio(Request $request, Employee $employee)
    {
        if ($employee->user->id !== Auth::id()) {
            return Redirect::back()->withErrors(['You are not authorized to update this profile.']);
        }

        $data = $request->validate([
            'bio' => 'nullable|string|max:2000',
            'social' => 'nullable'
        ]);

        $employee->update($data);
        return back()->withSuccess('Profile has been updated successfullly!');
    }


    public function updateAvailability(Request $request, Employee $employee)
    {
        dd($request->all());
    }
}
