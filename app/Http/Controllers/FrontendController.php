<?php

namespace App\Http\Controllers;

use App\Models\Appointment;
use App\Models\Category;
use App\Models\Employee;
use App\Models\ServiceSubCategory;
use App\Models\Settings;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Number;
use Spatie\OpeningHours\OpeningHours;

class FrontendController extends Controller
{
    public function index(Request $request)
    {
        $categories = Category::with([
            'services' => function ($query) {
                $query->where('status', 1)
                    ->with([
                        'employees' => function ($query) {
                            // Only include employees with active users
                            $query->whereHas('user', function ($q) {
                                $q->where('status', 1);
                            })->with('user');
                        }
                    ]);
            }
        ])->where('status', 1)->get();

        $employees = Employee::with('services')->with('user')->get();

        return view('welcome', compact('categories', 'employees'));
    }


    public function getServices(Request $request, Category $category)
    {
        $settings = Settings::firstOrFail();

        $services = $category->services()
            ->where('status', 1)
            ->with('category')
            ->get()
            ->map(function ($service) use ($settings) {
                if (isset($service->price)) {
                    $service->price = Number::currency($service->price, $settings->currency ?? 'USD');
                }

                if (isset($service->sale_price)) {
                    $service->sale_price = Number::currency($service->sale_price, $settings->currency ?? 'USD');
                }

                return $service;
            });

        return response()->json([
            'success' => true,
            'services' => $services
        ]);
    }

    public function getEmployees(Request $request, ServiceSubCategory $service)
    {
        $employees = $service->employees()
            ->whereHas('user', function ($query) {
                $query->where('status', 1);
            })
            ->with('user') // Eager load user details
            ->get();

        if ($employees->isEmpty()) {
            return response()->json([
                'success' => false,
                'message' => 'No employees available for this service'
            ]);
        }

        return response()->json([
            'success' => true,
            'employees' => $employees,
            'service' => $service
        ]);
    }

    public function getEmployeeAvailability(Employee $employee, $date = null)
    {
        // Use current date if not provided
        $date = $date ? Carbon::parse($date) : now();

        // Validate slot duration exists
        if (!$employee->slot_duration) {
            return response()->json(['error' => 'Slot duration not set for this employee'], 400);
        }

        // Time range formatting function
        $formatTimeRange = function ($timeRange) {
            if (str_contains($timeRange, 'AM') || str_contains($timeRange, 'PM')) {
                $timeRange = str_replace([' AM', ' PM', ' '], '', $timeRange);
            }

            $times = explode('-', $timeRange);
            $formattedTimes = array_map(function ($time) {
                $parts = explode(':', $time);
                $hours = str_pad(trim($parts[0]), 2, '0', STR_PAD_LEFT);
                return $hours . ':' . $parts[1];
            }, $times);

            return implode('-', $formattedTimes);
        };

        try {
            // Build holiday exceptions for each booked day
            $holidaysExceptions = [];

            foreach ($employee->holidays as $holiday) {
                if ($holiday->status !== 'approved') {
                    continue;
                }

                $start = Carbon::parse($holiday->start_date);
                $end = Carbon::parse($holiday->end_date);

                $hours = !empty($holiday->hours)
                    ? collect($holiday->hours)->map(function ($timeRange) use ($formatTimeRange) {
                        return $formatTimeRange($timeRange);
                    })->toArray()
                    : []; // empty array blocks full day

                while ($start->lte($end)) {
                    $holidaysExceptions[$start->toDateString()] = $hours;
                    $start->addDay();
                }
            }

            // Create opening hours using Spatie package
            $openingHours = OpeningHours::create(array_merge(
                $employee->days ?? [], // base availability (e.g., Mon–Fri)
                ['exceptions' => $holidaysExceptions]
            ));

            // Get available time ranges for selected date
            $availableRanges = $openingHours->forDate($date);

            // If no availability for this date
            if ($availableRanges->isEmpty()) {
                return response()->json(['available_slots' => []]);
            }

            // Generate slots
            $slots = $this->generateTimeSlots(
                $availableRanges,
                $employee->slot_duration,
                $employee->break_duration ?? 0,
                $date,
                $employee->id
            );

            return response()->json([
                'employee_id' => $employee->id,
                'date' => $date->toDateString(),
                'available_slots' => $slots,
                'slot_duration' => $employee->slot_duration,
                'break_duration' => $employee->break_duration,
            ]);
        } catch (\Exception $e) {
            \Log::error('Error fetching employee availability', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
            ]);

            return response()->json([
                'error' => 'Error processing availability: ' . $e->getMessage()
            ], 500);
        }
    }

    protected function generateTimeSlots($availableRanges, $slotDuration, $breakDuration, $date, $employeeId)
    {
        $slots = [];
        $now = now();
        $isToday = $date->isToday();

        // Get existing appointments for this date and employee
        $existingAppointments = Appointment::where('booking_date', $date->toDateString())
            ->where('employee_id', $employeeId)
            ->whereNotIn('status', ['Cancelled']) // Exclude cancelled/ here could add more status to make expection
            ->get(['booking_time']);

        // Convert existing appointments to time ranges we can compare against
        $bookedSlots = $existingAppointments->map(function ($appointment) {
            $times = explode(' - ', $appointment->booking_time);
            return [
                'start' => Carbon::createFromFormat('g:i A', trim($times[0]))->format('H:i'),
                'end' => Carbon::createFromFormat('g:i A', trim($times[1]))->format('H:i')
            ];
        })->toArray();

        foreach ($availableRanges as $range) {
            $start = Carbon::parse($date->toDateString() . ' ' . $range->start()->format('H:i'));
            $end = Carbon::parse($date->toDateString() . ' ' . $range->end()->format('H:i'));

            // Skip if the entire range is in the past (only for today)
            if ($isToday && $end->lte($now)) {
                continue;
            }

            $currentSlotStart = clone $start;

            // If today and current slot start is in the past, adjust to current time
            if ($isToday && $currentSlotStart->lt($now)) {
                $currentSlotStart = clone $now;

                // Round up to nearest slot interval
                $minutes = $currentSlotStart->minute;
                $remainder = $minutes % $slotDuration;
                if ($remainder > 0) {
                    $currentSlotStart->addMinutes($slotDuration - $remainder)->second(0);
                }
            }

            while ($currentSlotStart->copy()->addMinutes($slotDuration)->lte($end)) {
                $slotEnd = $currentSlotStart->copy()->addMinutes($slotDuration);

                // Check if this slot conflicts with any existing booking
                $isAvailable = true;
                foreach ($bookedSlots as $bookedSlot) {
                    $bookedStart = Carbon::parse($date->toDateString() . ' ' . $bookedSlot['start']);
                    $bookedEnd = Carbon::parse($date->toDateString() . ' ' . $bookedSlot['end']);

                    if ($currentSlotStart->lt($bookedEnd) && $slotEnd->gt($bookedStart)) {
                        $isAvailable = false;
                        break;
                    }
                }

                // Only add slots that are available and in the future (for today)
                if ($isAvailable && (!$isToday || $slotEnd->gt($now))) {
                    $slots[] = [
                        'start' => $currentSlotStart->format('H:i'),
                        'end' => $slotEnd->format('H:i'),
                        'display' => $currentSlotStart->format('g:i A') . ' - ' . $slotEnd->format('g:i A'),
                    ];
                }

                // Add break duration if specified
                $currentSlotStart->addMinutes($slotDuration + $breakDuration);

                // Check if next slot would exceed end time
                if ($currentSlotStart->copy()->addMinutes($slotDuration)->gt($end)) {
                    break;
                }
            }
        }

        return $slots;
    }

}
