<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Laravel\Socialite\Facades\Socialite;

class GoogleAuthController extends Controller
{
    public function redirect()
    {
        return Socialite::driver('google')->redirect();
    }

    public function callback()
    {
        try {
            $google_user = Socialite::driver('google')->user();
            $user = User::query()->where('google_id', $google_user->id)->first();
            if (!$user) {
                $new_user = User::query()->create([
                    'name' => $google_user->getName(),
                    'email' => $google_user->getEmail(),
                    'google_id' => $google_user->id,
                ]);
            }

            Auth::login($user ?? $new_user);

            return redirect('/');
        } catch (\Exception $e) {
            dd($e->getMessage());
        }
    }
}
