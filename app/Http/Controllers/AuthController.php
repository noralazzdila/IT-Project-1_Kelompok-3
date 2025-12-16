<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

class AuthController extends Controller
{
    public function showLogin()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $credentials = $request->only('email', 'password');

        // Hardcoded credentials for koor_pkl
        if ($credentials['email'] == 'adminpkl@politala.ac.id' && $credentials['password'] == 'politala2009') {
            // Find or create the koor_pkl user
            $user = User::firstOrCreate(
                ['email' => 'adminpkl@politala.ac.id'],
                [
                    'name' => 'Koordinator PKL',
                    'password' => bcrypt('politala2009'), // It's better to store a hashed password
                    'role' => 'koor_pkl',
                    'is_validated' => true
                ]
            );

            Auth::login($user);
            $request->session()->regenerate();
            return redirect()->intended('/dashboard')->with('success', 'Login berhasil');
        }

        if (Auth::attempt($credentials)) {
            if (!Auth::user()->is_validated) {
                Auth::logout();
                return back()->withErrors(['email' => 'Akun Anda belum divalidasi oleh admin.']);
            }
            return redirect()->intended('/dashboard')->with('success', 'Login berhasil');
        }

        return back()->withErrors(['email' => 'Email atau password salah']);
    }

    public function showRegister()
    {
        return view('auth.register');
    }

    public function register(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:8|confirmed',
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => bcrypt($request->password),
        ]);

        Auth::login($user);

        return redirect('/dashboard')->with('success', 'Registrasi berhasil');
    }
public function doLogin(Request $request)
{
    $username = $request->username;
    $password = $request->password;

    if ($username === 'admin' && $password === '123') {
        session(['user' => $username]);
        return redirect()->route('dashboard');
    }

    return back()->with('error', 'Username atau password salah');
}


    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/login')->with('success', 'Anda berhasil logout');
    }
}
