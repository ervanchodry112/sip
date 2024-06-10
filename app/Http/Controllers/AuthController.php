<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoginRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function login()
    {
        $data = [
            'title' => 'Login'
        ];

        return view('pages.auth.login', $data);
    }

    public function login_attempt(LoginRequest $request)
    {
        if (!Auth::attempt($request->validated())) {
            return back()->withInput($request->all())->with('error', 'Username atau Password tidak sesuai');
        }

        $user = User::where('username', $request->username)->whereNull('deleted_at')->first();
        if(empty($user)){
            return back()->withInput($request->all())->with('error', 'Username atau Password tidak sesuai');
        }

        if ((!empty($user->tokens))) {
            $user->tokens()->delete();
        }

        $token = $user->createToken('auth')->plainTextToken;

        Auth::login($user);
        session(['token' => $token]);

        return to_route('home');
    }

    public function logout()
    {

        Auth::logout();

        return to_route('login');
    }
}
