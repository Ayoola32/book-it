<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Employee extends Model
{
    protected $guarded = [];

    protected $casts = [
        'days' => 'array',
        'social' => 'array',
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

}
