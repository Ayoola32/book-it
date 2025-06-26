<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ServiceSubCategory extends Model
{
    use HasFactory;
    public function category()
    {
        return $this->belongsTo(Category::class, 'category_id');
    }

    public function employees()
    {
        return $this->belongsToMany(Employee::class, 'employee_service_sub_category');
    }

    public function appointments()
    {
        return $this->hasMany(Appointment::class);
    }
}
