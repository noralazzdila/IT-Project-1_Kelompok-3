<?php

namespace App\Http\Controllers\Mahasiswa;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\ActivityLog as Aktivitas;
use App\Models\TempatPKL;
use Illuminate\Support\Facades\Auth;

class AktivitasController extends Controller
{
    public function index()
    {
        $aktivitas = Aktivitas::where('user_id', Auth::id())
            ->orderBy('created_at', 'desc')
            ->get();

        return view('mahasiswa.aktivitas.index', compact('aktivitas'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'pdf' => 'required|mimes:pdf|max:2048',
            'tempat_pkl_id' => 'required'
        ]);

        // Upload file PDF
        $file = $request->file('pdf');
        $filename = time() . '_' . $file->getClientOriginalName();
        $path = $file->storeAs('aktivitas', $filename, 'public');

        Aktivitas::create([
            'user_id' => Auth::id(),
            'tempat_pkl_id' => $request->tempat_pkl_id,
            'pdf_path' => $path,
        ]);

        return redirect()->back()->with('success', 'Aktivitas berhasil di-upload!');
    }
}
