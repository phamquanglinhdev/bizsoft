<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Laravel\Socialite\Facades\Socialite;
use PHPUnit\Exception;

class SocialLoginController extends Controller
{
    public function facebookLogin()
    {
        return Socialite::driver("facebook")->redirect();
    }

    public function facebookCallback()
    {
        $user = Socialite::driver('facebook')->user();
        $exist = User::where("email", $user->getEmail())->count();
        if ($exist == 0) {
            $account = User::create([
                'facebook_id' => $user->getId(),
                'name' => $user->getName(),
                'email' => $user->getEmail() ?? "Fb" . $user->getId() . "@phone.com",
                'avatar' => $user->getAvatar(),
                'password' => Hash::make(Str::random(50))
            ]);
            backpack_auth()->loginUsingId($account->id);
        } else {
            $id = User::where("email", $user->getEmail())->first()->id;
            User::find($id)->update([
                'name' => $user->getName(),
                'email' => $user->getEmail() ?? "Fb" . $user->getId() . "@phone.com",
                'avatar' => $user->getAvatar(),
            ]);
            backpack_auth()->loginUsingId($id);
        }
        return redirect(backpack_url("/dashboard"));
    }

    public function googleLogin()
    {
        return Socialite::driver("google")->redirect();
    }

    public function googleCallback()
    {
        $user = Socialite::driver('google')->user();
        $exist = User::where("email", $user->getEmail())->count();
        if ($exist == 0) {
            $account = User::create([
                'google_id' => $user->getId(),
                'name' => $user->getName(),
                'email' => $user->getEmail() ?? "gg" . $user->getId() . "@phone.com",
                'avatar' => $user->getAvatar(),
                'password' => Hash::make(Str::random(50))
            ]);
            backpack_auth()->loginUsingId($account->id);
        } else {
            $id = User::where("email", $user->getEmail() ?? "gg" . $user->getId() . "@phone.com")->first()->id;
            User::find($id)->update([
                'name' => $user->getName(),
                'email' => $user->getEmail() ?? "gg" . $user->getId() . "@phone.com",
                'avatar' => $user->getAvatar(),
            ]);
            backpack_auth()->loginUsingId($id);
        }
        return redirect(backpack_url("/dashboard"));
    }

    public function githubLogin()
    {
        return Socialite::driver("github")->redirect();
    }

    public function githubCallback()
    {
        $user = Socialite::driver('github')->user();
        $email = $user->getEmail() ?? "git" . $user->getId() . "@phone.com";
        $exist = User::where("email", $email)->count();
        if ($exist == 0) {
            $account = User::create([
                'google_id' => $user->getId(),
                'name' => $user->getName(),
                'email' => $user->getEmail() ?? "git" . $user->getId() . "@phone.com",
                'avatar' => $user->getAvatar(),
                'password' => Hash::make(Str::random(50))
            ]);
            backpack_auth()->loginUsingId($account->id);
        } else {
            $email = $user->getEmail() ?? "git" . $user->getId() . "@phone.com";
            $id = User::where("email", $email)->first()->id;
            User::find($id)->update([
                'name' => $user->getName(),
                'email' => $user->getEmail() ?? "git" . $user->getId() . "@phone.com",
                'avatar' => $user->getAvatar(),
            ]);
            backpack_auth()->loginUsingId($id);
        }
        return redirect(backpack_url("/dashboard"));
    }
}
