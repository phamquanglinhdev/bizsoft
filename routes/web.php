<?php

use App\Http\Controllers\Admin\SocialLoginController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});
Route::get("/facebook/login", [SocialLoginController::class, "facebookLogin"])->name("facebook-login");
Route::get("/facebook/callback", [SocialLoginController::class, "facebookCallback"])->name("facebook-callback");
Route::get("/google/login", [SocialLoginController::class, "googleLogin"])->name("google-login");
Route::get("/google/callback", [SocialLoginController::class, "googleCallback"])->name("google-callback");
Route::get("/github/login", [SocialLoginController::class, "githubLogin"])->name("github-login");
Route::get("/github/callback", [SocialLoginController::class, "githubCallback"])->name("github-callback");
