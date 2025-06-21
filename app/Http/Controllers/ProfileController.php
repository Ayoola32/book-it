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
    /**
     * Display the user's profile form.
     */
    public function index(Request $request): View
    {
        // return view('profile.index', [
        //     'user' => $request->user()->load(['employee']),
        // ]);
        $user = User::with('employee')->where('id', Auth::id())->firstOrFail();
        return view('profile.index', compact('user'));
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
}
