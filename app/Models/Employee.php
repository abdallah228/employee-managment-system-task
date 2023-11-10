<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Employee extends Model
{
    use HasFactory;
    protected $guarded = [];

    //get FullName for employee

    public function getFullNameAttribute()
    {
        return $this->first_name . ' '.$this->last_name;
    }
    public function getImageAttribute($value)
    {
        return asset('storage/' . $value);
    }

    //relations
    public function department()
    {
        return $this->belongsTo(Department::class,'department_id');
    }


}
