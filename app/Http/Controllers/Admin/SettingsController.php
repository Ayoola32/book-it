<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Settings;
use App\Traits\FileUpload;
use Illuminate\Support\Facades\Storage;

class SettingsController extends Controller
{
    use FileUpload;

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // Fetch the settings from the database
        $settings = Settings::first();
        return view('admin.settings.index', compact('settings'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $activeTab = $request->input('active_tab', 'settings');

        $validated = [];

        switch ($activeTab) {
            case 'settings':
                $validated = $request->validate([
                    'bname' => ['required', 'string', 'max:255'],
                    'currency' => ['nullable', 'string', 'max:5'],
                    'logo' => ['nullable', 'image', 'mimes:png,jpeg,jpg,webp', 'max:3000'],
                    'favicon' => ['nullable', 'mimes:png,jpeg,jpg,webp,ico', 'max:3000'],
                ]);

                if ($request->hasFile('logo')) {
                    $logoPath = $this->uploadFile($request->file('logo'), 'uploads/setings');
                    $validated['logo'] = $logoPath;
                }

                if ($request->hasFile('favicon')) {
                    $Faviconpath = $this->uploadFile($request->file('favicon'), 'uploads/setings');
                    $validated['favicon'] = $Faviconpath;
                }
                break;

            case 'contact':
                $validated = $request->validate([
                    'email' => 'nullable|email',
                    'phone' => 'nullable|string|max:20',
                    'address' => 'nullable|string|max:255',
                    'map' => 'nullable|string',
                ]);
                break;

            case 'social':
                $validated = $request->validate([
                    'social' => 'array',
                    'social.facebook' => 'nullable|url',
                    'social.instagram' => 'nullable|url',
                    'social.tiktok' => 'nullable|url',
                    'social.twitter' => 'nullable|url',
                ]);
                break;

            case 'footer':
                $validated = $request->validate([
                    'footer_info' => 'nullable|string',
                    'copyright' => 'nullable|string',
                    'powered_by' => 'nullable|string',
                ]);
                break;

            case 'seo':
                $validated = $request->validate([
                    'seo_title' => 'nullable|string',
                    'seo_description' => 'nullable|string',
                    'seo_keywords' => 'nullable|string',
                ]);
                break;

            default:
                return back()->with('error', 'Invalid settings section.');
        }

        Settings::updateOrCreate(
            ['id' => 1],  // ensure only one row
            $validated
        );

        return redirect()
            ->route('admin.settings.index')
            ->withInput(['active_tab' => $activeTab])
            ->with('success', 'Settings updated successfully!');
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
