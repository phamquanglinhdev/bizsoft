<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Teacher extends User
{
    use HasFactory;

    public function setRoleAttribute()
    {
        $this->attributes["role"] = "teacher";
    }

    public function Grades()
    {
        return $this->belongsToMany(Grade::class, "teacher_grade", "teacher_id", "grade_id");
    }
}
