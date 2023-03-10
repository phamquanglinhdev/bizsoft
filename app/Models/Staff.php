<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;

class Staff extends User
{
    use HasFactory;


    public function setRoleAttribute()
    {
        $this->attributes["role"] = "staff";
    }

    public function Grades()
    {
        return $this->belongsToMany(Grade::class, "staff_grade", "staff_id", "grade_id");
    }

}
