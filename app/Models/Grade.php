<?php

namespace App\Models;

use Backpack\CRUD\app\Models\Traits\CrudTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Grade extends Model
{
    use CrudTrait;
    use HasFactory;

    /*
    |--------------------------------------------------------------------------
    | GLOBAL VARIABLES
    |--------------------------------------------------------------------------
    */

    protected $table = 'grades';
    // protected $primaryKey = 'id';
    // public $timestamps = false;
    protected $guarded = ['id'];
    // protected $fillable = [];
    // protected $hidden = [];
    // protected $dates = [];
    protected $casts = [
        'times' => 'json'
    ];

    /*
    |--------------------------------------------------------------------------
    | FUNCTIONS
    |--------------------------------------------------------------------------
    */
    public function getStatus()
    {
        switch ($this->status) {
            case 0:
                return "Đang học";
            case 1:
                return "Đã kết thúc";
            case 3:
                return "Đang bảo lưu";
        }
    }

    public function frequency()
    {
        return count($this->times);
    }

    /*
    |--------------------------------------------------------------------------
    | RELATIONS
    |--------------------------------------------------------------------------
    */
    public function Logs()
    {
        return $this->hasMany(Log::class, "grade_id", "id");
    }

    public function Staffs()
    {
        return $this->belongsToMany(Staff::class, "staff_grade", "grade_id", "staff_id");
    }

    public function Teachers()
    {
        return $this->belongsToMany(Teacher::class, "teacher_grade", "grade_id", "teacher_id");
    }

    public function Students()
    {
        return $this->belongsToMany(Student::class, "student_grade", "grade_id", "student_id");
    }

    /*
    |--------------------------------------------------------------------------
    | SCOPES
    |--------------------------------------------------------------------------
    */
    /*
    |--------------------------------------------------------------------------
    | ACCESSORS
    |--------------------------------------------------------------------------
    */

    /*
    |--------------------------------------------------------------------------
    | MUTATORS
    |--------------------------------------------------------------------------
    */
}
