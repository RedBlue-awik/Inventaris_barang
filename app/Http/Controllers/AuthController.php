<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function indexlogin()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $credentials = $request->validate(
            [
                'email' => 'required|email',
                'password' => 'required',
            ],
            [
                'email.required' => 'Email wajib diisi.',
                'email.email' => 'Format email tidak valid.',
                'password.required' => 'Password wajib diisi.',
            ]
        );

        if (Auth::attempt($credentials, $request->remember)) {
            $request->session()->regenerate();
            return redirect()
                ->route('login')
                ->with('login_success', [
                    'message' => 'Login berhasil',
                    'icon' => 'success',
                    'redirect' => route('dashboard'),
                    'delay' => 1300,
                ]);
        }

        return back()->withErrors([
            'email' => 'Email atau password salah.',
        ])->withInput();
    }

    public function indexregister()
    {
        return view('auth.register');
    }

    public function register(Request $request)
    {
        $validatedData = $request->validate(
            [
                'name' => 'required|string|max:255',
                'email' => 'required|string|email|max:255|unique:users',
                'password' => 'required|string|min:6|confirmed',
                'password_confirmation' => 'required',
                'departemen' => 'nullable|string|max:255'
            ],
            [
                'name.required' => 'Nama wajib diisi.',
                'email.required' => 'Email wajib diisi.',
                'email.email' => 'Format email tidak valid.',
                'email.unique' => 'Email sudah digunakan.',
                'password.required' => 'Password wajib diisi.',
                'password.min' => 'Password minimal 6 karakter.',
                'password.confirmed' => 'Konfirmasi password tidak sesuai.',
                'password_confirmation.required' => 'Konfirmasi password wajib diisi.',
                'departemen.string' => 'Departemen harus berupa teks.',
                'departemen.max' => 'Departemen maksimal 255 karakter.',
            ]
        );

        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => bcrypt($request->password),
            'role' => 'staf',
            'departemen' => $request->departemen ?? '-',
        ]);

        return redirect()
            ->route('register')
            ->with('register_success', [
                'message' => 'Registrasi berhasil. Silakan login.',
                'icon' => 'success',
                'redirect' => route('login'),
                'delay' => 1300,
            ]);
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()
            ->route('dashboard')
            ->with('logout_success', [
                'message' => 'Logout berhasil.',
                'icon' => 'success',
                'redirect' => route('login'),
                'delay' => 1300,
            ]);
    }
}
