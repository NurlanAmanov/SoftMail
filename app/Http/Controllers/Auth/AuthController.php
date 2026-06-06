<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
   // Login səhifəsini göstərmək
    public function showLoginForm()
    {
        return view('auth.Login'); // resources/views/auth/login.blade.php
    }

    // İstifadəçi login prosesi
    public function login(Request $request)
    {
        // Validasiya
        $request->validate([
            'email'    => 'required|email',
            'password' => 'required|min:6',
        ]);

        // Giriş məlumatları
        $credentials = $request->only('email', 'password');

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();

            // Admin isə → admin səhifəsinə yönləndir
            if (Auth::user()->role === 'admin') {
                return redirect()->route('admin.home');
            }

            // Əks halda → ana səhifə
            return redirect()->route('home');
        }

        // Uğursuz giriş
        return back()->withErrors([
            'email' => 'Invalid credentials',
        ])->withInput();
    }

    // Çıxış əməliyyatı
    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login')->with('success', 'Logged out successfully');
    }
    // Profil redaktə səhifəsi
public function editProfile()
{
    $user = Auth::user();
    return view('frontend.pages.profile.edit', compact('user'));
}

// Məlumatları yeniləmək
public function updateProfile(Request $request)
{
    $user = Auth::user();

    $request->validate([
        'name'  => 'required|string|max:255',
        'email' => 'required|email|unique:users,email,' . $user->id,
        'password' => 'nullable|min:6|confirmed', // 'password_confirmation' sahəsi ilə yoxlayır
    ]);

    $user->name = $request->name;
    $user->email = $request->email;

    if ($request->filled('password')) {
        $user->password = bcrypt($request->password);
    }

    $user->save();

    return back()->with('success', 'Profil məlumatlarınız yeniləndi!');
}
}
