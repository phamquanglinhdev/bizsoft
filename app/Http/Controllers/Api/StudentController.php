<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Student;
use App\Repositories\Eloquent\StudentRepository;
use App\Untils\Upload;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class StudentController extends Controller
{
    public function __construct(
        private readonly StudentRepository $studentRepository
    )
    {
    }

    /**
     * Display a listing of the resource.
     * currentPage
     * endRecord
     * perPage
     * startRecord
     * totalPage
     */

    public function index(Request $request): array
    {
        $attributes = $request->input();
        $currentPage = $attributes["currentPage"] ?? 1;
        $attributes["perPage"] = $attributes["perPage"] ?? "10";
        $attributes["startRecord"] = ($currentPage - 1) * $attributes["perPage"];
        $collection = $this->studentRepository->getStudentList($attributes);
        $totalRecord = $this->studentRepository->getTotalRecord($attributes);
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
            'students' => $collection->map(function (Student $student) {
                return [
                    'id' => $student['id'],
                    'code' => $student['code'],
                    'name' => $student['name'],
                    'avatar' => $student['avatar'],
                    'address' => $student['address'],
                    'gender' => $student['gender'] == 0 ? "Nam" : "Nữ",
                    'phone' => $student['phone'],
                    'email' => $student['email'],
                    'parent' => $student['parent'],
                    'staff' => "-",
                    'classrooms' => $student->ClassroomConnect(),
                ];
            })
        ];
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request): JsonResponse
    {
        $validation = Validator::make($request->input(), [
            'name' => 'required',
            'avatar' => 'required',
            'code' => 'required|unique:users,code,' . $request['id'] ?? "",
            'email' => 'required|email|unique:users,email,' . $request['id'] ?? "",
            'phone' => 'unique:users,phone,' . $request['id'] ?? "",
            "birthday" => 'required',
            'password' => 'confirmed',
        ], [
            'avatar.required' => 'Avatar không thể để trống',
            'name.required' => 'Tên không thể để trống',
            'email.unique' => "Email đã tồn tại",
            'code.unique' => "Mã đã tồn tại",
            'code.required' => 'Mã không thể để trống',
            'email.required' => 'Email không thể để trống',
            'phone.required' => 'Số điện thoại không thể để trống',
            'birthday.required' => 'Ngày sinh không thể để trống',
        ]);
        if ($validation->fails()) {
            return response()->json(['message' => $validation->errors()->first()], 500);
        }
        $dto = $request->input();
        $dto["gender"] = $request["gender"]["value"] ?? 0;
        $dto["avatar"] = Upload::base64Image($dto['avatar']);
        if (isset($dto["password"])) {
            $dto["password"] = Hash::make($dto["password"]);
        }
        if ($request["id"]) {
            /**
             * @var Student $student
             */
            $student = $this->studentRepository->find($request["id"]);
            try {
                $student?->update($dto);
                return response()->json(['message' => 'Cập nhật thành công']);
            } catch (\Exception $exception) {
                return response()->json(['message' => $exception->getMessage()], 500);
            }
        }

        try {
            $this->studentRepository->create($dto);
            return response()->json(['message' => 'Thêm mới thành công']);
        } catch (\Exception $exception) {
            return response()->json(['message' => $exception->getMessage()], 500);
        }

    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        /**
         * @var Student $student
         */
        $student = $this->studentRepository->find($id);
        return [
            'id' => $student['id'],
            'avatar' => $student['avatar'],
            'code' => $student['code'],
            'name' => $student['name'],
            'birthday_format' => Carbon::parse($student['birthday'])->isoFormat("DD/MM/YYYY"),
            'birthday' => $student['birthday'],
            'address' => $student["address"],
            'gender' => [
                'value' => $student["gender"],
                'label' => $student["gender"] == 0 ? 'Nam' : "Nữ"
            ],
            'phone' => $student['phone'],
            'email' => $student['email'],
            'parent' => $student['parent']
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
    public function destroy(int $id): JsonResponse
    {
        try {
            $this->studentRepository->delete($id);
            return response()->json(['message' => 'Xóa  thành công']);
        } catch (\Exception $exception) {
            return response()->json(['message' => $exception->getMessage()], 500);
        }
    }
}
