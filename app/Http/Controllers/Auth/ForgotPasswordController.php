<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Mail\ResetPasswordMail;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\RateLimiter;
use App\Models\User;
use Carbon\Carbon;

class ForgotPasswordController extends Controller
{
    // tampilkan form lupa password
    public function showForgotForm()
    {
        return view('auth.forgot-password');
    }

    // kirim kode ke email
    public function sendResetCode(Request $request)
    {
        $request->validate([
            'email' => 'required|email|exists:users,email',
        ]);

        if (RateLimiter::tooManyAttempts('send-reset-code:'.$request->email, 1)) {
            $seconds = RateLimiter::availableIn('send-reset-code:'.$request->email);
            return back()->withErrors(['email' => 'Terlalu banyak percobaan. Silakan coba lagi dalam '.$seconds.' detik.']);
        }

        RateLimiter::hit('send-reset-code:'.$request->email, 60);

        $code = rand(100000, 999999);

        // simpan ke database (tabel password_resets)
        DB::table('password_resets')->updateOrInsert(
            ['email' => $request->email],
            ['token' => $code, 'created_at' => Carbon::now()]
        );

        // kirim email
        Mail::to($request->email)->send(new ResetPasswordMail($code));

        return back()->with('success', 'Kode verifikasi telah dikirim ke email Anda.');
    }

    // reset password
    public function resetPassword(Request $request)
    {
        $request->validate([
            'email' => 'required|email|exists:users,email',
            'code' => 'required',
            'password' => 'required|min:6|confirmed',
        ]);

        // cek kode
        $reset = DB::table('password_resets')
            ->where('email', $request->email)
            ->where('token', $request->code)
            ->first();

        if (!$reset) {
            return back()->withErrors(['code' => 'Kode verifikasi salah.'])->withInput($request->only('email'));
        }

        // update password user
        User::where('email', $request->email)
            ->update(['password' => Hash::make($request->password)]);

        // hapus kode setelah digunakan
        DB::table('password_resets')->where('email', $request->email)->delete();

        return redirect()->route('login')->with('success', 'Password berhasil direset, silakan login.');
    }
}
