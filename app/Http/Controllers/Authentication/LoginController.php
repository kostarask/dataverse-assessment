<?php

namespace App\Http\Controllers\Authentication;

use App\Http\Controllers\Controller;
use App\Http\Requests\LoginRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    public function login()
    {
        return view('auth.login');
    }

    public function authenticate(LoginRequest $request)
    {
        $credentials = $request->validated();

        if (Auth::attempt(['username' => $credentials['username'], 'password' => $credentials['password']])) {

            $request->session()->regenerate();

            return response([
                'success' => true,'message'=>'Login Successful',
                'intended' => route('home'),
            ], 200);

        } else {
            return response()->json(['errors' => ['password' => [ __('Incorrect Password') ]]], 422);
        }
    }
    public function logout(Request $request)
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return to_route('login');
    }
}
