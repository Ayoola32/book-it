<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HolidayBalance extends Model
{
    use HasFactory;

    protected $fillable = [
        'employee_id',
        'holiday_year_start',
        'holiday_year_end',
        'total_days',
    ];


    public function employee()
    {
        return $this->belongsTo(Employee::class);
    }
}
