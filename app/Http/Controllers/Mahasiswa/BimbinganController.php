<?php

namespace App\Http\Controllers\Mahasiswa;

use App\Http\Controllers\Controller;
use App\Models\Bimbingan;
use Illuminate\Http\Request;

class BimbinganController extends Controller
{
    public function index(Request $request)
    {
        $query = Bimbingan::where('user_id', auth()->id());

        // Pencarian sederhana
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where('topik_bimbingan', 'like', "%{$search}%");
        }

        // Filter status
        if ($request->filled('status') && $request->status != 'Semua') {
            $query->where('status', $request->status);
        }

        $bimbingans = $query->latest()->paginate(10)->withQueryString();

        return view('mahasiswa.bimbingan.index', compact('bimbingans'));
    }
}
