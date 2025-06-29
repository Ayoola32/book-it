<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Appointment;
use Carbon\Carbon;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    function index2() : View
    {
        return view('admin.dashboard');
    }


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
                    'id' => $appointment->id, // Add appointment ID
                    'title' => sprintf('%s - %s',
                        $appointment->name,
                        $appointment->service->name ?? 'Service'
                    ),
                    'start' => $startDateTime->toIso8601String(),
                    'end' => $endDateTime->toIso8601String(),
                    'description' => $appointment->notes,
                    'email' => $appointment->email,
                    'phone' => $appointment->phone,
                    'amount' => $appointment->amount,
                    'status' => $appointment->status,
                    'staff' => $appointment->employee->user->name ?? 'Unassigned',
                    'color' => $this->getStatusColor($appointment->status),
                    'service_title' => $appointment->service->name ?? 'Service', // Add service title
                    'name' => $appointment->name, // Add client name
                    'notes' => $appointment->notes, // Add notes
                ];
            } catch (\Exception $e) {
                \Log::error("Format error for appointment {$appointment->id}: {$e->getMessage()}");
                return null;
            }
        })->filter();

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
