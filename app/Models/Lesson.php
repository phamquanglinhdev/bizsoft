<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * @property string $start
 * @property string $end
 * @property int $hour_salary
 */
class Lesson extends Model
{

    use HasFactory;

    protected $table = "lessons";
    protected $guarded = ["id"];
    protected $casts = [
        "exercises" => 'array'
    ];

    public function Classroom(): BelongsTo
    {
        return $this->belongsTo(Classroom::class, "classroom_id", "id");
    }

    public function Teacher(): BelongsTo
    {
        return $this->belongsTo(Teacher::class, "teacher_id", "id");
    }

    public function SalaryForLesson(): int
    {
        $start = Carbon::parse($this->start);
        $end = Carbon::parse($this->end);
        $minute = $end->diffInMinutes($start);
        return ($this->hour_salary * $minute / 60);
    }
}
