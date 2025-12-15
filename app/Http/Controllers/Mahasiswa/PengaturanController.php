<?php

namespace App\Http\Controllers\Mahasiswa;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use App\Models\User;

class PengaturanController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        return view('mahasiswa.pengaturan', compact('user'));
    }

    public function update(Request $request)
{
    /** @var \App\Models\User $user */
    $user = auth::user();

    $request->validate([
        'name' => 'required|string|max:255',
        'email' => 'required|email|max:255',
        'profile_photo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
    ]);

    $user->name = $request->name;
    $user->email = $request->email;

    if ($request->hasFile('profile_photo')) {
        $file = $request->file('profile_photo');
        $filename = time().'_'.$file->getClientOriginalName();
        $file->storeAs('public/profile', $filename);
        $user->profile_photo = 'profile/'.$filename;
    }

    $user->save();

    return redirect()->back()->with('success', 'Profil berhasil diperbarui!');
}


}

