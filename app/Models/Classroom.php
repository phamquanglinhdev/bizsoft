<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Facades\DB;

/**
 * @property array $schedule
 */
class Classroom extends Model
{
    use HasFactory;

    protected $table = "classrooms";
    protected $guarded = ["id"];
    protected $casts = [
        'schedule' => 'array'
    ];

    public function getSchedules(): array
    {
        $scheduleData = [];
        $schedules = $this->schedule;
        foreach ($schedules as $schedule) {
            $data = [
                "week_day" => $schedule['week_day'],
                'start' => $schedule["start"],
                'end' => $schedule['end'],
                'day' => Carbon::parse($schedule["week_day"])->isoFormat("DD/MM/YYYY")
            ];
            $scheduleData[] = $data;
        }
        return $scheduleData;
    }

    public function Students(): BelongsToMany
    {
        return $this->belongsToMany(Student::class, "classroom_student", "classroom_id", "student_id");
    }

    public function Teachers(): BelongsToMany
    {
        return $this->belongsToMany(Teacher::class, "classroom_teacher", "classroom_id", "teacher_id");
    }

    public function Supporters(): BelongsToMany
    {
        return $this->belongsToMany(Teacher::class, "classroom_supporter", "classroom_id", "supporter_id");
    }

    public function getStatus(): array
    {
        switch ($this->status ?? 0) {
            case 0:
                return [
                    "value" => 0,
                    'label' => "Lớp đang hoạt động",
                ];
            case 1:
                return [
                    "value" => 1,
                    'label' => "Lớp đã kết thúc",
                ];
            case 2:
                return [
                    "value" => 2,
                    'label' => "Lớp đang bảo lưu",
                ];
        }
        return [];
    }

    public function StudentConnect()
    {
        return $this->Students()->withPivot("pricing", "start", "status", "promote", "done", "paid", "apm")->get()->map(function ($data) {
            $studentConnect = $data->pivot;
            $studentConnect["name"] = $data["name"];
            $studentConnect["email"] = $data["email"];
            $studentConnect["avatar"] = $data["avatar"];
            $studentConnect["id"] = $studentConnect["student_id"];
            $studentConnect["status"] = $this->getStatusConnect($studentConnect["status"]);
            unset($studentConnect["student_id"]);
            unset($studentConnect["classroom_id"]);
            return $studentConnect;
        });
    }

    private function getStatusConnect(mixed $status): array
    {
        switch ($status ?? 0) {
            case 0:
                return [
                    "value" => 0,
                    'label' => "Đang học",
                ];
            case 1:
                return [
                    "value" => 1,
                    'label' => "Đã học xong",
                ];
            case 2:
                return [
                    "value" => 2,
                    'label' => "Đang bảo lưu",
                ];
        }
        return [];
    }

    public function Lessons(): HasMany
    {
        return $this->hasMany(Lesson::class, "classroom_id", "id");
    }
}
