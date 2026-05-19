<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;

class AuthController extends Controller
{
    public function showRegister () {
        return view('auth.register');
    }
    public function register (Request $request) {
        $request->validate([
            'name'=>'required|string|max:255',
            'email'=>'required|string|email|max:255|unique:users',
            'password'=>hash::make($request->password, [
                'min:8',
                'letters',
                'numbers',
                'symbols',
            ]),
        ]);
        $user = User::create($request->all());
        Auth::login($user);
        return redirect()->route('home');

    }
    public function showLogin() {
        return view('auth.login');
    }
    public function login (Request $request) {
        if(Auth::attempt([
            'email'=>$request->email,
            'password'=>$request->password,
            'actif' => 1,
        ])) {
            $request->session()->regenerate();
            return redirect()->intended('/');
            return back()->withErrors([
                'email' => 'Invalid credentials or account not active.',
            ]);
        }
    } 
    public function logout(Request $request) {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect()->route('home');
    }
}