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
    // ================= LOGIN =================
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

    // ================= SHOW REGISTER =================
    public function showRegister()
    {
        return view('auth.register');
    }

    // ================= DASHBOARD =================
    public function dashboard()
    {
        return view('auth.dashboard');
    }

    // ================= REGISTER =================
    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [

            'name' => 'required|string|max:255',

            'username' => 'required|string|max:15',

            'email' => 'required|string|email|max:255|unique:users',

            'password' => 'required|string|min:6|confirmed',

        ]);

        // VALIDASI GAGAL
        if ($validator->fails()) {

            return redirect()
                ->back()
                ->withErrors($validator)
                ->withInput();
        }

        // ================= SIMPAN USER =================
        $user = User::create([

            'name' => $request->name,

            'username' => $request->username,

            'email' => $request->email,

            'password' => Hash::make($request->password),

        ]);

        // ================= EMAIL VERIFICATION =================
        $user->sendEmailVerificationNotification();

        // ================= REDIRECT KE LOGIN =================
        return redirect()
            ->route('login')
            ->with('success', 'Akun berhasil dibuat, silakan login.');
    }

    // ================= SHOW FORGOT PASSWORD =================
    public function showForgotPassword()
    {
        return view('auth.forgot-password');
    }

    // ================= KIRIM LINK RESET PASSWORD =================
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

    // ================= FORM PASSWORD BARU =================
    public function showResetPassword(string $token)
    {
        return view('auth.reset-password', [
            'token' => $token
        ]);
    }

    // ================= SIMPAN PASSWORD BARU =================
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

        // ================= RESET BERHASIL =================
        return $status === Password::PASSWORD_RESET

            ? redirect()
                ->route('login')
                ->with('success', 'Password berhasil direset, silakan login.')

            : back()->withErrors([
                'email' => ['Gagal mereset password.']
            ]);
    }
}