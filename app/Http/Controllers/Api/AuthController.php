<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\UserResource;
use App\Models\User;
use App\Repositories\Eloquent\UserRepository;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    public function __construct(
        private readonly UserRepository $userRepository
    )
    {
    }

    public function login(Request $request): Response
    {
        $validate = Validator::make(
            data: $request->input(),
            rules: [
                'email' => 'required|email',
                'password' => 'required'
            ],
            messages: [
                "*.required" => 'Thiếu thông tin đăng nhập'
            ]);
        if ($validate->fails()) {
            return response([
                "message" => $validate->errors()->first()
            ], 404);
        }
        /**
         * @var User $user
         */
        $user = $this->userRepository->findByEmail($request["email"]);
        if (!$user) {
            return response([
                "message" => "Không tồn tại tài khoản"
            ], 404);
        }
        if (!Hash::check($request["password"], $user["password"])) {
            return response([
                "message" => "Mật khẩu không chính xác"
            ], 404);
        }
        return response([
            'token' => 'Bearer ' . $user->createToken("Bearer")->plainTextToken,
            'login_time' => Carbon::now()
        ]);
    }

    public function user(Request $request): array
    {
        /**
         * @var User $user
         */
        $user = $request->user();
        return [
            'name' => $user["name"],
            'avatar' => $user['avatar'],
            'role' => $user["role"]
        ];
    }
}
