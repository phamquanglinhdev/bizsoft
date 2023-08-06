<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Teacher;
use App\Repositories\Eloquent\TeacherRepository;
use App\Untils\Upload;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class TeacherController extends Controller
{
    public function __construct(
        private readonly TeacherRepository $teacherRepository
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
        $collection = $this->teacherRepository->getStudentList($attributes);
        $totalRecord = $this->teacherRepository->getTotalRecord($attributes);
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
            'teachers' => $collection->map(function (Teacher $teacher) {
                return [
                    'id' => $teacher['id'],
                    'code' => $teacher['code'],
                    'name' => $teacher['name'],
                    'avatar' => $teacher['avatar'],
                    'address' => $teacher['address'],
                    'gender' => $teacher['gender'] == 0 ? "Nam" : "Nữ",
                    'phone' => $teacher['phone'],
                    'email' => $teacher['email'],
                    'grade' => '-',
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
            'phone.unique' => 'Số điện thoại đã tồn tại',
            'birthday.required' => 'Ngày sinh không thể để trống',
            "password" => "Kiểm tra lại mật khẩu"
        ]);
        if ($validation->fails()) {
            return response()->json(['message' => $validation->errors()->first()], 500);
        }
        $dto = $request->input();
        $dto["avatar"] = Upload::base64Image($dto['avatar']);
        $dto["gender"] = $request["gender"]["value"] ?? 0;
        if ($request["id"]) {
            /**
             * @var Teacher $teacher
             */
            $teacher = $this->teacherRepository->find($request["id"]);
            if (isset($dto["password"])) {
                $dto["password"] = Hash::make($dto["password"]);
            }
            try {
                $teacher?->update($dto);
                return response()->json(['message' => 'Cập nhật thành công']);
            } catch (\Exception $exception) {
                return response()->json(['message' => $exception->getMessage()], 500);
            }
        }

        try {
            if (isset($dto["password"])) {
                $dto["password"] = Hash::make($dto["password"]);
            }
            $this->teacherRepository->create($dto);
            return response()->json(['message' => 'Thêm mới thành công']);
        } catch (\Exception $exception) {
            return response()->json(['message' => $exception->getMessage()], 500);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id): array
    {
        /**
         * @var Teacher $student
         */
        $student = $this->teacherRepository->find($id);
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
            'extra_information' => $student["extra_information"]
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
            $this->teacherRepository->delete($id);
            return response()->json(['message' => 'Xóa  thành công']);
        } catch (\Exception $exception) {
            return response()->json(['message' => $exception->getMessage()], 500);
        }
    }
}
