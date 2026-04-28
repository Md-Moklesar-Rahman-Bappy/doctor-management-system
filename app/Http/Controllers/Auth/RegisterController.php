<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Doctor;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class RegisterController extends Controller
{
    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => 'doctor',
        ]);

        // Create doctor profile
        Doctor::create([
            'name' => $request->name,
            'email' => $request->email,
            'phone' => '',
            'address' => '',
            'degrees' => null,
            'email_verified' => false,
        ]);

        // Send email verification notification
        $user->sendEmailVerificationNotification();

        auth()->login($user);

        return redirect('/dashboard')->with('success', 'Registration successful! Please verify your email.');
    }
}
