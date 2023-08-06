<?php

namespace App\Http\Controllers\Api;

use App\Enums\ClassroomStatus;
use App\Http\Controllers\Controller;
use App\Models\Classroom;
use App\Models\Lesson;
use App\Models\Student;
use App\Models\Teacher;
use App\Repositories\Eloquent\ClassroomRepository;
use App\Repositories\Eloquent\StudentRepository;
use App\Repositories\Eloquent\TeacherRepository;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class ClassroomController extends Controller
{
    public function __construct(
        private readonly ClassroomRepository $classroomRepository,
        private readonly TeacherRepository   $teacherRepository,
        private readonly StudentRepository   $studentRepository,
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
        $collection = $this->classroomRepository->getPagination($attributes);
        $totalRecord = $this->classroomRepository->getTotalRecord($attributes);
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
            'classrooms' => $collection->map(function (Classroom $classroom) {
                return [
                    'id' => $classroom['id'],
                    'name' => $classroom['name'],
                    'program' => $classroom['program'],
                    'pricing' => number_format($classroom["pricing"]),
                    'duration' => $classroom['duration'],
                    'session' => $classroom['session'],
                    'teachers' => $classroom->Teachers()->get()->map(function (Teacher $teacher) {
                        return [
                            'avatar' => $teacher['avatar'],
                            "name" => $teacher["name"],
                            "id" => $teacher["id"],
                            "extras" => $teacher["extra_information"]
                        ];
                    }),
                    'supporters' => $classroom->Supporters()->get()->map(function (Teacher $teacher) {
                        return [
                            'avatar' => $teacher['avatar'],
                            "name" => $teacher["name"],
                            "id" => $teacher["id"],
                            "extras" => $teacher["extra_information"]
                        ];
                    }),
                    'students' => $classroom->StudentConnect()->map(function ($student) {
                        return [
                            'avatar' => $student["avatar"],
                            'name' => $student["name"],
                            "id" => $student["id"],
                            "start" => Carbon::parse($student["start"])->isoFormat("DD/MM/YYYY"),
                            "done" => $student["done"],
                            "paid" => $student["paid"],
                            "less" => $student["pricing"] - $student["promote"] - $student["paid"],
                            "apm" => Carbon::parse($student["apm"])->isoFormat("DD/MM/YYYY"),
                        ];
                    }),
                    'status' => ClassroomStatus::trans($classroom['status']),
                    'schedules' => $classroom->getSchedules()
                ];
            })
        ];
    }

    /**
     * Store a newly created resource in storage.
     */
    public function init(Request $request)
    {
        $teachers = $this->teacherRepository->getForClassroom();
        $students = $this->studentRepository->getForClassroom();
        return [
            'initTeachers' => $teachers->map(function (Teacher $teacher) {
                return [
                    'value' => $teacher["id"],
                    'label' => $teacher["name"]
                ];
            })->toArray(),
            'initSupporters' => $teachers->map(function (Teacher $teacher) {
                return [
                    'value' => $teacher["id"],
                    'label' => $teacher["name"]
                ];
            })->toArray(),
            'initStudents' => $students->map(function (Student $student) {
                return [
                    'value' => $student["id"],
                    'label' => $student["name"],
                ];
            })
        ];
    }

    public function store(Request $request)
    {
        $attributes = $request->input();
        $validate = Validator::make($attributes, [
            'name' => 'required',
            'program' => 'required',
            'pricing' => 'required|numeric',
            'duration' => 'required|numeric',
            'session' => 'required|numeric',
            'status' => 'required',
        ], [
            'name.required' => 'Tên lớp học bị thiếu',
            'program.required' => 'Chương trình học bị thiếu',
            'pricing.required' => 'Gói học phí bị thiếu',
            'duration.required' => 'Thời lượng học bị thiếu',
            'session.required' => 'Số buổi học bị thiếu',
            'status.required' => 'Tình trạng khóa học bị thiếu',
            '*.numeric' => 'Vui lòng nhập đúng định dạng số',
        ]);
        if ($validate->fails()) {
            return response()->json(["message" => $validate->errors()->first()], 401);
        }
        $attributes["status"] = $attributes["status"]["value"];
        /**
         * @var Classroom $classroomCreate
         */
//        return $attributes["students"];
        if (isset($attributes["id"])) {
            $classroomCreate = $this->classroomRepository->find($attributes["id"]);
            $classroomCreate?->update($attributes);
        } else {
            $classroomCreate = $this->classroomRepository->create($attributes);
        }
        $teacherId = [];
        if (isset($attributes["teachers"])) {
            foreach ($attributes["teachers"] as $teacher) {
                $teacherId[] = $teacher["value"];
            }
        }
        $classroomCreate->Teachers()->sync($teacherId);
        $supporterId = [];
        if (isset($attributes["supporters"])) {
            foreach ($attributes["supporters"] as $supporter) {
                $supporterId[] = $supporter["value"];
            }
        }
        $classroomCreate->Supporters()->sync($supporterId);
        $studentId = [];
        if (isset($attributes["students"])) {
            foreach ($attributes["students"] as $student) {
                $studentId[] = $student["id"];
                $studentId[$student["id"]] = [
                    'apm' => Carbon::parse($student['apm']) ?? null,
                    'done' => $student['done'] ?? 1,
                    'paid' => $student['paid'] ?? $student['pricing'],
                    'pricing' => $student['pricing'],
                    'promote' => $student['promote'] ?? 0,
                    'start' => Carbon::parse($student['start']),
                    "status" => $student["status"]["value"],
                ];
            }
        }
        $classroomCreate->Students()->sync($studentId);
        /**
         * apm
         * done
         * id
         * name
         * paid
         * pricing
         * promote
         * show
         * start
         * total
         */
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
         * @var Classroom $classroom
         */
        $classroom = $this->classroomRepository->find($id);
        return [
            'name' => $classroom["name"],
            'program' => $classroom["program"],
            'pricing' => $classroom["pricing"],
            'duration' => $classroom['duration'],
            'session' => $classroom['session'],
            'status' => $classroom->getStatus(),
            'schedule' => $classroom["schedule"],
            'students' => $classroom->StudentConnect(),
            'teachers' => $classroom->Teachers()->get()->map(function (Teacher $teacher) {
                return [
                    'value' => $teacher["id"],
                    'label' => $teacher["name"],
                    "avatar" => $teacher["avatar"],
                    'email' => $teacher['email'],
                ];
            }),
            'supporters' => $classroom->Supporters()->get()->map(function (Teacher $teacher) {
                return [
                    'value' => $teacher["id"],
                    'label' => $teacher["name"],
                    "avatar" => $teacher["avatar"],
                    'email' => $teacher['email'],
                ];
            }),
            'lessons' => $classroom->Lessons()->get()->map(function (Lesson $lesson) {
                return [
                    "id" => $lesson["id"],
                    "session" => $lesson["session"],
                    'title' => Str::limit($lesson['title'], 20),
                    'day' => Carbon::parse($lesson["day"])->isoFormat("DD/MM/YYYY"),
                    'start' => $lesson['start'],
                    'end' => $lesson['end'],
                    'attendances' => [
                        [
                            "id" => 1,
                            "avatar" => "https://i.pinimg.com/736x/e0/8d/30/e08d306901193d49944c1c72bac9234b.jpg",
                            'attendance' => 1,
                            'comment' => 'Học tốt',
                            'name' => 'Phan Thái Nguyên',
                        ],
                        [
                            "id" => 2,
                            "avatar" => "https://i.pinimg.com/736x/58/93/bd/5893bdcb85e26e0d460371ac72a4e89f.jpg",
                            'attendance' => 0,
                            'comment' => 'Nghỉ ốm',
                            'name' => 'Phan Thái Nguyên',
                        ]
                    ],
                    'record' => $lesson['record'],
                    'exercises',
                    'teacher' => $lesson->Teacher()->first(["id", "name", "avatar"])
                ];
            })
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
    public function destroy(string $id): JsonResponse
    {
        try {
            $this->classroomRepository->delete($id);
            return response()->json(['message' => 'Xóa  thành công']);
        } catch (\Exception $exception) {
            return response()->json(['message' => $exception->getMessage()], 500);
        }
    }
}
