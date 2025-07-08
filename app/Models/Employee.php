<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Employee extends Model
{
    protected $guarded = [];

    protected $casts = [
        'days' => 'array',
        'social' => 'array',
        'total_holiday_days',
    ];


    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function services()
    {
        return $this->belongsToMany(ServiceSubCategory::class, 'employee_service_sub_category');
    }

    public function holidays()
    {
        return $this->hasMany(Holiday::class,'employee_id');
    }

    public function appointments()
    {
        return $this->hasMany(Appointment::class, 'employee_id');
    }


    public static function getCurrentHolidayYearRange(): array
    {
        $now = now();
        $currentYear = $now->year;

        // If today is before April 6, we're still in the previous holiday year
        if ($now->lt(Carbon::create($currentYear, 4, 6))) {
            $start = Carbon::create($currentYear - 1, 4, 6)->startOfDay();
            $end = Carbon::create($currentYear, 4, 5)->endOfDay();
        } else {
            $start = Carbon::create($currentYear, 4, 6)->startOfDay();
            $end = Carbon::create($currentYear + 1, 4, 5)->endOfDay();
        }

        return [$start, $end];
    }

    public function getUsedHolidayDaysAttribute(): int
    {
        [$yearStart, $yearEnd] = self::getCurrentHolidayYearRange();

        return $this->holidays()
            ->where('status', 'approved')
            ->whereDate('start_date', '>=', $yearStart)
            ->whereDate('end_date', '<=', $yearEnd)
            ->get()
            ->sum(function ($holiday) {
                return $holiday->start_date->diffInDays($holiday->end_date) + 1;
            });
    }


    public function getRemainingHolidayDaysAttribute(): int
    {
        return max(0, $this->total_holiday_days - $this->used_holiday_days);
    }



}
