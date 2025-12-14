<?php

namespace App\Http\Controllers\Dosen;

use App\Models\Pemberkasan;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;
use App\Http\Controllers\Controller;

class PemberkasanDosenController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): View
    {
        // Eager load the mahasiswa relationship for searching
        $query = Pemberkasan::with('mahasiswa');

        if ($request->filled('search')) {
            $search = $request->search;
            $query->whereHas('mahasiswa', function ($q) use ($search) {
                $q->where('nama', 'like', "%{$search}%")
                  ->orWhere('nim', 'like', "%{$search}%");
            });
        }

        if ($request->filled('status')) {
            if ($request->status == 'lengkap') {
                $query->where('is_lengkap', true);
            } elseif ($request->status == 'belum') {
                $query->where('is_lengkap', false);
            }
        }

        $pemberkasans = $query->latest()->paginate(10)->withQueryString();

        return view('dosen.pemberkasan.indexdosen', compact('pemberkasans'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): View
    {
        // This might need Mahasiswa data to select from
        return view('dosen.pemberkasan.createdosen');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'mahasiswa_id' => 'required|exists:mahasiswa,id|unique:pemberkasans,mahasiswa_id',
            'is_lengkap' => 'required|boolean',
            'tanggal_verifikasi' => 'nullable|date',
            // File validations can be added here if uploads are handled
        ]);

        Pemberkasan::create($request->all());

        return redirect()->route('dosen.pemberkasan.indexdosen')
                         ->with('success', 'Data Pemberkasan berhasil ditambahkan.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Pemberkasan $pemberkasan): View
    {
        return view('dosen.pemberkasan.showdosen', compact('pemberkasan'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Pemberkasan $pemberkasan): View
    {
        return view('dosen.pemberkasan.editdosen', compact('pemberkasan'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Pemberkasan $pemberkasan): RedirectResponse
    {
        $request->validate([
            'mahasiswa_id' => 'required|exists:mahasiswa,id|unique:pemberkasans,mahasiswa_id,' . $pemberkasan->id,
            'is_lengkap' => 'required|boolean',
            'tanggal_verifikasi' => 'nullable|date',
        ]);

        $pemberkasan->update($request->all());

        return redirect()->route('dosen.pemberkasan.indexdosen')
                         ->with('success', 'Data Pemberkasan berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Pemberkasan $pemberkasan): RedirectResponse
    {
        // Add logic to delete files from storage if they exist
        
        $pemberkasan->delete();

        return redirect()->route('dosen.pemberkasan.indexdosen')
                         ->with('success', 'Data Pemberkasan berhasil dihapus.');
    }
}
