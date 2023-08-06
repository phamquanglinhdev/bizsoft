<?php

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\ClassroomController;
use App\Http\Controllers\Api\LessonController;
use App\Http\Controllers\Api\StudentController;
use App\Http\Controllers\Api\TeacherController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->group(function () {
    Route::get("/connect", function () {
        return 1;
    });
    Route::get("/user/", [AuthController::class, "user"]);
    Route::post("/student/list", [StudentController::class, "index"]);
    Route::get("/student/{id}/show", [StudentController::class, "show"]);
    Route::post("/student/modify", [StudentController::class, "store"]);
    Route::get("/student/{id}/delete", [StudentController::class, "destroy"]);
    //
    Route::post("/teacher/list", [TeacherController::class, "index"]);
    Route::post("/teacher/modify", [TeacherController::class, "store"]);
    Route::get("/teacher/{id}/show", [TeacherController::class, "show"]);
    Route::get("/teacher/{id}/delete", [TeacherController::class, "destroy"]);
    //
    Route::post("/classroom/list", [ClassroomController::class, "index"]);
    Route::get("/classroom/init", [ClassroomController::class, "init"]);
    Route::post("/classroom/modify", [ClassroomController::class, "store"]);
    Route::get("/classroom/{id}/show", [ClassroomController::class, "show"]);
    Route::get("/classroom/{id}/delete", [ClassroomController::class, "destroy"]);
    //
    Route::post("/lesson/list", [LessonController::class, "index"]);
    Route::get("/lesson/pre", [LessonController::class, "preCreate"]);
    Route::post("/lesson/init", [LessonController::class, "init"]);
    Route::post("/lesson/modify", [LessonController::class, "store"]);
    Route::get("/lesson/{id}/show", [LessonController::class, "show"]);
    Route::get("/lesson/{id}/delete", [LessonController::class, "destroy"]);
});
Route::post("/login", [AuthController::class, "login"]);
