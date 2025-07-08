<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Holiday extends Model
{
    protected $guarded = [];

    protected $casts = [
        'hours' => 'array',
        'user_id', 'start_date', 'end_date', 'reason', 'status', 'feedback'
    ];


    public function employee()
    {
        return $this->belongsTo(Employee::class);
    }
}
