<?php

namespace App\Models;

use Backpack\CRUD\app\Models\Traits\CrudTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Log extends Model
{
    use CrudTrait;
    use HasFactory;

    /*
    |--------------------------------------------------------------------------
    | GLOBAL VARIABLES
    |--------------------------------------------------------------------------
    */

    protected $table = 'logs';
    // protected $primaryKey = 'id';
    // public $timestamps = false;
    protected $guarded = ['id'];
    // protected $fillable = [];
    // protected $hidden = [];
    // protected $dates = [];
    protected $casts = ["students" => 'array'];

    /*
    |--------------------------------------------------------------------------
    | FUNCTIONS
    |--------------------------------------------------------------------------
    */
    public function miniVideo()
    {
        return json_decode($this->video)->url;
    }

    /*
    |--------------------------------------------------------------------------
    | RELATIONS
    |--------------------------------------------------------------------------
    */
    public function Grade()
    {
        return $this->belongsTo(Grade::class, "grade_id", "id");
    }

    public function Teacher()
    {
        return $this->belongsTo(Teacher::class, "teacher_id", "id");
    }

    public function frequency()
    {
        $total = $this->Grade()->first()->Students()->count();
        $students = ($this->students);
        if ($students != null) {
            $alive = count($students);
        } else {
            $alive = 0;
        }
        return '<div class="text-center bg-primary p-1 rounded">'.$alive . "/" . $total.'</div>';
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
