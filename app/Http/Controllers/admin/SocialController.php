<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Laravel\Socialite\Facades\Socialite;
use Illuminate\Support\Str;

class SocialController extends Controller
{
    // Redirigir a Google
    public function redirectToGoogle()
    {
        return Socialite::driver('google')->redirect();
    }

    // Manejar la respuesta de Google
    public function handleGoogleCallback()
    {
        try {
            $user = Socialite::driver('google')->user();
            $this->registerOrLoginUser($user, 'google');
            return redirect()->route('admin.dashboard');
        } catch (\Throwable $th) {
            return back()->with('error', $th->getMessage());
        }
        
    }

    // Redirigir a Facebook
    public function redirectToFacebook()
    {
        return Socialite::driver('facebook')->redirect();
    }

    // Manejar la respuesta de Facebook
    public function handleFacebookCallback()
    {
        try {
            $user = Socialite::driver('facebook')->user();
            $this->registerOrLoginUser($user, 'facebook');
            return redirect()->route('admin.dashboard');
        } catch (\Throwable $th) {
            return back()->with('error', $th->getMessage());
        }
    }

    // Registro o inicio de sesión del usuario
    protected function registerOrLoginUser($data, $provider = null)
    {
        $user = User::where('email', $data->email)->first();
        if (!$user) {
            try {
                $user = User::create([
                    'name'          => $data->name,
                    'avatar'        => $data->avatar,
                    'email'         => $data->email,
                    'provider'      => $provider,
                    'provider_id'   => $data->id,
                    'password'      => encrypt(Str::random(24)),
                    'created_at'    => now(),
                    'updated_at'    => now()
                ])->assignRole('vendedor');
            } catch (\Throwable $th) {
                dd($th->getMessage());
            }
        }
        
        Auth::login($user);
    }
}
