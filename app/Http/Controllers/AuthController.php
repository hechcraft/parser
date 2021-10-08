<?php

namespace App\Http\Controllers;

use App\Http\Requests\Auth\LoginRequest;
use App\Models\User;
use App\Providers\RouteServiceProvider;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Laravel\Socialite\Facades\Socialite;

class AuthController extends Controller
{
    public function telegramAuth()
    {
        $currentUser = User::firstWhere('telegram_id', data_get($_REQUEST, 'id'));

        if (is_null($currentUser)) {
           $currentUser =  User::create([
                'name' => data_get($_REQUEST, 'first_name'),
                'username' => data_get($_REQUEST, 'username'),
                'telegram_id' => data_get($_REQUEST, 'id'),
                'profile_photo_path' => data_get($_REQUEST, 'photo_url'),
            ]);
        }

        auth()->login($currentUser, true);
        return redirect()->intended(RouteServiceProvider::HOME);
    }
}
