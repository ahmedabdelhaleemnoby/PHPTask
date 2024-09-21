<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\Employee;

class LoginController extends Controller
{
    public function showLoginForm()
    {
        return view('auth.login');
    }
    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required_without:phone|email',
            'phone' => 'required_without:email',
            'password' => 'required',
        ]);

        $employee = Employee::where('email', $request->email)
                            ->orWhere('phone', $request->phone)
                            ->first();

        if ($employee && Hash::check($request->password, $employee->password)) {
            if ($request->expectsJson()) {
                $token = $employee->createToken('API Token')->plainTextToken;
                return response()->json([
                    'access_token' => $token,
                    'token_type' => 'Bearer',
                ]);
            } else {
                Auth::login($employee);
                return redirect()->intended('dashboard');
            }
        }

        if ($request->expectsJson()) {
            return response()->json(['error' => 'Unauthorized'], 401);
        } else {
            return back()->withErrors([
                'email' => 'The provided credentials do not match our records.',
            ]);
        }
    }

    public function logout(Request $request)
    {
        if ($request->expectsJson()) {
            $request->user()->currentAccessToken()->delete();
            return response()->json(['message' => 'Logged out successfully']);
        } else {
            Auth::logout();
            return redirect('/login');
        }
    }
}
