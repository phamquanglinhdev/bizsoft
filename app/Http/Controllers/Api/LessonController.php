<?php

namespace App\Http\Controllers\Api;

use App\Enums\ClassroomStatus;
use App\Http\Controllers\Controller;
use App\Models\Classroom;
use App\Models\Lesson;
use App\Models\Student;
use App\Models\Teacher;
use App\Repositories\Eloquent\ClassroomRepository;
use App\Repositories\Eloquent\LessonRepository;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Validator;

class LessonController extends Controller
{
    public function __construct(
        private readonly LessonRepository    $lessonRepository,
        private readonly ClassroomRepository $classroomRepository,
    )
    {

    }

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $attributes = $request->input();
        $currentPage = $attributes["currentPage"] ?? 1;
        $attributes["perPage"] = $attributes["perPage"] ?? "10";
        $attributes["startRecord"] = ($currentPage - 1) * $attributes["perPage"];
        $collection = $this->lessonRepository->getPagination($attributes);
        $totalRecord = $this->lessonRepository->getTotalRecord($attributes);
        if ($totalRecord % $attributes["perPage"] == 0) {
            $totalPage = $totalRecord / $attributes["perPage"];
        } else {
            $totalPage = (int)($totalRecord / $attributes['perPage']) + 1;
        }
        return [
            'currentPage' => $attributes["currentPage"],
            'totalPage' => $totalPage,
            'perPage' => $attributes['perPage'],
            'startRecord' => ($currentPage - 1) * $attributes["perPage"] + 1,
            'endRecord' => min($currentPage * $attributes['perPage'], $totalRecord),
            'totalRecord' => $totalRecord,
            'lessons' => $collection->map(function (Lesson $lesson) {
                return [
                    'id' => $lesson['id'],
                    'session' => $lesson['session'],
                    'classroom' => $lesson->Classroom()->first(["id", "name"]),
                    'teacher' => $lesson->Teacher()->first(["id", "name", "avatar"]),
                    'title' => $lesson['title'],
                    'day' => Carbon::parse($lesson['day'])->isoFormat("DD/MM/YYYY"),
                    'start' => $lesson['start'],
                    'end' => $lesson['end'],
                    'hourSalary' => $lesson['hour_salary'],
                    'lessonSalary' => $lesson->SalaryForLesson(),
                    'recordVideo' => $lesson['record']
                ];
            })
        ];
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {

        $attributes = $request->input();

        $validate = Validator::make($attributes, [
            'session' => 'required',
            'classroom_id' => 'required',
            'title' => 'required',
            'day' => 'required',
            'start' => 'required',
            'end' => 'required',
            'attendances' => 'required',
            'hour_salary' => 'required|numeric',
        ], [
            'session' => 'Kiểm tra lại buổi học',
            'classroom_id.*' => 'Kiểm tra lại lớp học',
            'title.*' => 'Kiểm tra lại tiêu đề',
            'day.*' => 'Kiểm tra lại ngày học',
            'start.*' => 'Kiểm tra lại thời gian bắt đầu',
            'end.*' => 'Kiểm tra lại thời gian kết thúc',
            'attendances.*' => 'Kiểm tra lại danh sách điểm danh',
            'hour_salary.*' => 'Kiểm tra lại lương giờ học',
        ]);
        if ($validate->fails()) {
            return response()->json(["message" => $validate->errors()->first()], 401);
        }
        if (isset($attributes["id"])) {
            $lessonCreate = $this->lessonRepository->find($attributes["id"]);
            $lessonCreate?->update($attributes);
        } else {
            try {
                $attributes["teacher_id"] = $request["teacher_id"]["value"] ?? $request->user()->id;
                $this->lessonRepository->create($attributes);
            } catch (\Exception $exception) {
                return response()->json(['message' => $exception->getMessage(), "data" => $attributes], 500);
            }
        }
        return response()->json([
            "message" => "Thành công"
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        /**
         * @var Lesson $lesson
         */
        $lesson = $this->lessonRepository->find($id);
        return [
            'session' => $lesson["session"],
            'record' => $lesson['record'],
            'title' => $lesson['title'],
            'day' => $lesson['day'],
            'start' => $lesson['start'],
            'end' => $lesson['end'],
            'attendances' => $lesson['attendances'],
            'hour_salary' => $lesson['hour_salary'],
            'asm' => $lesson['asm'],
            'classroom' => [
                'id' => $lesson->Classroom()->first()->id,
                'name' => $lesson->Classroom()->first()->name,
            ],
            'teacher' => [
                'id' => $lesson->Teacher()->first()->id ?? '',
                'name' => $lesson->Teacher()->first()->name ?? 'Admin điểm danh'
            ],
            'classroom_id' => $lesson["classroom_id"],
            'teacher_id' => $lesson['teacher_id']
        ];
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }

    public function preCreate(): array
    {
        return $this->classroomRepository->getClassroomForCreate()->map(function (Classroom $classroom) {
            return [
                'value' => $classroom["id"],
                'label' => $classroom["name"],
            ];
        })->toArray();
    }

    public function init(Request $request): JsonResponse|array
    {
        /**
         * @var Classroom $classroom
         */
        $classroom_id = $request["classroom_id"] ?? null;
        if (!$classroom_id) {
            return response()->json(["message" => "Không tìm thấy thông tin lớp học"], 401);
        }
        $classroom = $this->classroomRepository->find($classroom_id);
        if (!$classroom) {
            return response()->json(["message" => "Không tìm thấy thông tin lớp học"], 401);
        }
        return [
            'initTeachers' => $classroom->Teachers()->get()->map(function (Teacher $teacher) {
                return [
                    'value' => $teacher['id'],
                    'label' => $teacher['name'],
                ];
            }),
            'initSession' => $classroom->Lessons()->max("session") + 1,
            'initStudents' => $classroom->Students()->get()->map(function (Student $student) {
                return [
                    'id' => $student["id"],
                    "avatar" => $student["avatar"],
                    'name' => $student['name'],
                    'attendance' => 1,
                    'comment' => ''
                ];
            })
        ];

    }
}
