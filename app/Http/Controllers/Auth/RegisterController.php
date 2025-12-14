<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class RegisterController extends Controller
{
    public function showRegistrationForm()
    {
        return view('auth.register'); // arahkan ke view register.blade.php
    }

    public function register(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:100',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:6|confirmed',
            'role' => 'required|string|in:mahasiswa,dosen,staf,koor_prodi,koor_pkl',
        ]);

        $isValidated = str_ends_with($request->email, '@mhs.politala.ac.id');

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => $request->role,
            'is_validated' => $isValidated,
        ]);

        if ($isValidated) {
            Auth::login($user);
            return redirect()->route('login')->with('success', 'Pendaftaran berhasil, silakan login');
        }

        return redirect()->route('login')->with('success', 'Pendaftaran berhasil, harap tunggu validasi dari admin.');
    }
}
