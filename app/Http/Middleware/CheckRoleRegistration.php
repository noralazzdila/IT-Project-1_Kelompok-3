<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class CheckRoleRegistration
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        $email = $request->input('email');
        $role = $request->input('role');

        if (str_ends_with($email, '@mhs.politala.ac.id')) {
            if ($role !== 'mahasiswa') {
                return redirect()->back()->withErrors(['role' => 'With this email, you can only register as a student.']);
            }
        } elseif ($email === 'adminpkl@politala.ac.id') {
            if ($role !== 'koor_pkl') {
                return redirect()->back()->withErrors(['role' => 'With this email, you can only register as a Koor PKL.']);
            }
        }

        return $next($request);
    }
}
