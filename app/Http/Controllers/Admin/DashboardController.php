<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Appointment;
use Carbon\Carbon;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    /**
     * Display the Employee dashboard with formatted individual appointments.
     */
    public function index2(Request $request)
    {
        $user = auth()->user();

        $query = Appointment::with(['employee.user', 'service', 'user']);

        if ($user->role === 'employee') {
            $query->whereHas('employee', function ($q) use ($user) {
                $q->where('user_id', $user->id);
            });
        }

        $appointments = $query->get()->map(function ($appointment) {
            try {
                if (!str_contains($appointment->booking_time ?? '', '-')) {
                    throw new \Exception("Invalid time format");
                }

                $bookingDate = Carbon::parse($appointment->booking_date);
                [$startTime, $endTime] = array_map('trim', explode('-', $appointment->booking_time));

                $startDateTime = Carbon::createFromFormat('h:i A', $startTime)
                    ->setDate($bookingDate->year, $bookingDate->month, $bookingDate->day);

                $endDateTime = Carbon::createFromFormat('h:i A', $endTime)
                    ->setDate($bookingDate->year, $bookingDate->month, $bookingDate->day);

                if ($endDateTime->lt($startDateTime)) {
                    $endDateTime->addDay();
                }

                return [
                    'id' => $appointment->id,
                    'title' => sprintf('%s - %s', $appointment->name, $appointment->service->name ?? 'Service'),
                    'start' => $startDateTime->toIso8601String(),
                    'end' => $endDateTime->toIso8601String(),
                    'color' => $this->getStatusColor($appointment->status),
                    'extendedProps' => [
                        'description' => $appointment->notes,
                        'email' => $appointment->email,
                        'phone' => $appointment->phone,
                        'amount' => $appointment->amount,
                        'status' => $appointment->status,
                        'staff' => $appointment->employee->user->name ?? 'Unassigned',
                        'service_title' => $appointment->service->name ?? 'Service',
                        'name' => $appointment->name,
                        'notes' => $appointment->notes,
                    ]
                ];
            } catch (\Exception $e) {
                \Log::error("Format error for appointment {$appointment->id}: {$e->getMessage()}");
                return null;
            }
        })->filter()->values();

        return view('employee.dashboard', compact('appointments'));
    }



    /**
     * Display the admin dashboard with all formatted appointments.
     */
    public function index()
    {
        $user = auth()->user();

        // Start with base query
        $query = Appointment::query()->with(['employee.user', 'service', 'user']);


        // Format the appointments with proper date handling
        $appointments = $query->get()->map(function ($appointment) {
            try {
                if (!str_contains($appointment->booking_time ?? '', '-')) {
                    throw new \Exception("Invalid time format");
                }

                // Parse booking date
                $bookingDate = Carbon::parse($appointment->booking_date);

                // Parse start and end times
                [$startTime, $endTime] = array_map('trim', explode('-', $appointment->booking_time));

                // Create proper datetime objects
                $startDateTime = Carbon::createFromFormat('h:i A', $startTime)
                    ->setDate($bookingDate->year, $bookingDate->month, $bookingDate->day);

                $endDateTime = Carbon::createFromFormat('h:i A', $endTime)
                    ->setDate($bookingDate->year, $bookingDate->month, $bookingDate->day);

                // Handle overnight appointments (if end time is next day)
                if ($endDateTime->lt($startDateTime)) {
                    $endDateTime->addDay();
                }

                return [
                    'id' => $appointment->id,
                    'title' => sprintf('%s - %s', $appointment->name, $appointment->service->name ?? 'Service'),
                    'start' => $startDateTime->toIso8601String(),
                    'end' => $endDateTime->toIso8601String(),
                    'color' => $this->getStatusColor($appointment->status),
                    'extendedProps' => [
                        'description' => $appointment->notes,
                        'email' => $appointment->email,
                        'phone' => $appointment->phone,
                        'amount' => $appointment->amount,
                        'status' => $appointment->status,
                        'staff' => $appointment->employee->user->name ?? 'Unassigned',
                        'service_title' => $appointment->service->name ?? 'Service',
                        'name' => $appointment->name,
                        'notes' => $appointment->notes,
                    ]
                ];
            } catch (\Exception $e) {
                \Log::error("Format error for appointment {$appointment->id}: {$e->getMessage()}");
                return null;
            }
        })->filter()->values(); // Reindex the array after filtering

        return view('admin.dashboard', compact('appointments'));

    }


    // Helper function to get color based on status
    private function getStatusColor($status)
    {
        $colors = [
            'Pending' => '#f39c12',
            'Processing' => '#3498db',
            'Confirmed' => '#2ecc71',
            'Cancelled' => '#ff0000',
            'Completed' => '#008000',
            'On Hold' => '#95a5a6',
            'Rescheduled' => '#f1c40f',
            'No Show' => '#e67e22',
        ];

        return $colors[$status] ?? '#7f8c8d';
    }

}
