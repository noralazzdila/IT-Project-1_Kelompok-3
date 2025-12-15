<?php

namespace App\Http\Controllers\Mahasiswa;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class ProfilController extends Controller
{
    // Menampilkan halaman profil
    public function index()
    {
        $user = Auth::user();
        return view('mahasiswa.profil', compact('user'));
    }

    // Update profil
    public function update(Request $request)
    {
         /** @var \App\Models\User $user */
        $user = Auth::user();

        // Validasi input
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => ['required','email','max:255', Rule::unique('users')->ignore($user->id)],
            'phone' => 'nullable|string|max:20',
            'profile_photo' => 'nullable|image|max:2048', // max 2MB
        ]);

        $user->name = $request->name;
        $user->email = $request->email;
        $user->phone = $request->phone;

        if($request->hasFile('profile_photo')){
            $path = $request->file('profile_photo')->store('profile_photos','public');
            $user->profile_photo = $path;
        }

        $user->save();

        return redirect()->back()->with('success','Profil berhasil diperbarui!');
    }

    // Update password (opsional)
    public function updatePassword(Request $request)
    {
         /** @var \App\Models\User $user */
        $user = Auth::user();

        $request->validate([
            'current_password' => 'required',
            'new_password' => 'required|min:6|confirmed',
        ]);

        if(!Hash::check($request->current_password, $user->password)){
            return back()->withErrors(['current_password' => 'Password lama salah']);
        }

        $user->password = Hash::make($request->new_password);
        $user->save();

        return redirect()->back()->with('success','Password berhasil diperbarui!');
    }
}
