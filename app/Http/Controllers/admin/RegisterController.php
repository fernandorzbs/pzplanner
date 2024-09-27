<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RegisterController extends Controller
{
    public function login()
    {
        $title = "Login";
        return view('admin.register.login', compact('title'));
    }
    
    public function loginPost(Request $request){
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ],[],[
            'email' => 'correo',
            'password' => 'contraseña',
        ]);

        if (Auth::attempt($credentials)) {
            $user = Auth::user();
            
            if ($user->hasRole('administrador|cliente')) {
                $request->session()->regenerate();
                return redirect()->route('dashboard');
            } else {
                Auth::logout();
                return back()->with('mensaje', 'Acceso denegado. Solo los administradores pueden ingresar.');
            }
        }

        return back()->withErrors([
            'email' => 'Las credenciales no coinciden con nuestros registros.',
        ])->onlyInput('email');
    }


    public function logout()
    {
        Auth::logout();
        return redirect()->route('admin.login');
    }
}
