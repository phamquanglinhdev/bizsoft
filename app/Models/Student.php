<?php

namespace App\Models;

use App\Models\Scopes\StudentScope;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Student extends User
{
    use HasFactory;

    protected static function boot()
    {
        parent::boot();
        static::addGlobalScope(new StudentScope);
    }

    public
    function setRoleAttribute()
    {
        $this->attributes["role"] = "student";
    }

    public
    function Grades()
    {
        $this->belongsToMany(Grade::class, "student_grade", "student_id", "grade_id");
    }
}
