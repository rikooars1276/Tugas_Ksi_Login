<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Password;

class AuthController extends Controller
{
    
    public function proseslogin(Request $request)
    {
        $credentials = $request->only('email', 'password');

        if (Auth::attempt($credentials)) {

            $request->session()->regenerate();

            return redirect()->route('dashboard');
        }

        return redirect()
            ->route('login')
            ->with('error', 'Email atau Password salah');
    }

    
    public function showRegister()
    {
        return view('auth.register');
    }

    
    public function dashboard()
    {
        return view('auth.dashboard');
    }

    
    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [

            'name' => 'required|string|max:255',

            'username' => 'required|string|max:15',

            'email' => 'required|string|email|max:255|unique:users',

            'password' => 'required|string|min:6|confirmed',

        ]);

        
        if ($validator->fails()) {

            return redirect()
                ->back()
                ->withErrors($validator)
                ->withInput();
        }

        
        $user = User::create([

            'name' => $request->name,

            'username' => $request->username,

            'email' => $request->email,

            'password' => Hash::make($request->password),

        ]);

        
        $user->sendEmailVerificationNotification();

        
        return redirect()
            ->route('login')
            ->with('success', 'Akun berhasil dibuat, silakan login.');
    }

    
    public function showForgotPassword()
    {
        return view('auth.forgot-password');
    }

    
    public function forgotPassword(Request $request)
    {
        $request->validate([
            'email' => 'required|email'
        ]);

        $status = Password::sendResetLink(
            $request->only('email')
        );

        return $status === Password::RESET_LINK_SENT

            ? back()->with([
                'status' => 'Link reset password berhasil dikirim ke email kamu.'
            ])

            : back()->withErrors([
                'email' => 'Email tidak ditemukan.'
            ]);
    }

    
    public function showResetPassword(string $token)
    {
        return view('auth.reset-password', [
            'token' => $token
        ]);
    }

    
    public function resetPassword(Request $request)
    {
        $request->validate([

            'token' => 'required',

            'email' => 'required|email',

            'password' => 'required|min:6|confirmed',

        ]);

        $status = Password::reset(

            $request->only(
                'email',
                'password',
                'password_confirmation',
                'token'
            ),

            function ($user, $password) {

                $user->forceFill([

                    'password' => Hash::make($password)

                ])->save();
            }
        );

        
        return $status === Password::PASSWORD_RESET

            ? redirect()
                ->route('login')
                ->with('success', 'Password berhasil direset, silakan login.')

            : back()->withErrors([
                'email' => ['Gagal mereset password.']
            ]);
    }
}